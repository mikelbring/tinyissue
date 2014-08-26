<?php

class Project extends Eloquent {

	public static $table = 'projects';
	public static $timestamps = true;

	/**********************************************************
	 * Methods to use with loaded Project
	 **********************************************************/

	/**
	* Generate a URL for the active project
	*
	* @param  string  $url
	* @return string
	*/
	public function to($url = '')
	{
		return URL::to('project/' . $this->id . (($url) ? '/'. $url : ''));
	}

	/**
	* Returns all issues related to project
	*
	* @return mixed
	*/
	public function issues()
	{
		return $this->has_many('Project\Issue', 'project_id');
	}

	/**
	* Assign a user to a project
	*
	* @param  int   $user_id
	* @param  int   $role_id
	* @return void
	*/
	public function assign_user($user_id, $role_id = 0)
	{
		Project\User::assign($user_id, $this->id, $role_id);
	}

	public function users()
	{
		return $this->has_many_and_belongs_to('\User', 'projects_users', 'project_id', 'user_id');
	}

	public function users_not_in()
	{
		$users = array();

		foreach($this->users()->get(array('user_id')) as $user)
		{
			$users[] = $user->id;
		}

		$results = User::where('deleted', '=', 0);

		if(count($users) > 0)
		{
			$results->where_not_in('id', $users);
		}

		return $results->get();
	}

	/**
	* Counts the project's issues assigned to the given user
	*
	* @param  int  $user_id
	* @return int
	*/
	public function count_assigned_issues($user_id = null)
	{
		if(is_null($user_id))
		{
			$user_id = \Auth::user()->id;
		}

		return \Project\Issue::where('project_id', '=', $this->id)
			->where('assigned_to', '=', $user_id)
			->where('status', '=', 1)
			->count();
	}

	/**
	* Select activity for a project
	*
	* @param  int    $activity_limit
	* @return array
	*/
	public function activity($activity_limit)
	{
		$users = $issues = $comments = $activity_type = array();

		/* Load the activity types */
		foreach(Activity::all() as $row)
		{
			$activity_type[$row->id] = $row;
		}

		/* Loop through all the logic from the project and cache all the needed data so we don't load the same data twice */
		$project_activity = User\Activity::where('parent_id', '=', $this->id)
			->order_by('created_at', 'DESC')
			->take($activity_limit)
			->get();
			
		if(!$project_activity)
		{
			return null;
		}

		foreach($project_activity as $activity)
		{
			if(!isset($issues[$activity->item_id]))
			{
				$issues[$activity->item_id] = Project\Issue::find($activity->item_id);
			}

			if(!isset($users[$activity->user_id]))
			{
				$users[$activity->user_id] = User::find($activity->user_id);
			}

			if(!isset($comments[$activity->action_id]))
			{
				$comments[$activity->action_id] = Project\Issue\Comment::find($activity->action_id);
			}

			if($activity->type_id == 5)
			{
				if(!isset($users[$activity->action_id]))
				{
					if($activity->action_id > 0)
					{
						$users[$activity->action_id] =  User::find($activity->action_id);
					}
					else
					{
						$users[$activity->action_id] = array();
					}
				}
			}
		}

		/* Loop through the projects and activity again, building the views for each activity */
		$return = array();

		foreach($project_activity as $row)
		{
			switch($row->type_id)
			{
				case 2:
					$return[] = View::make('activity/' . $activity_type[$row->type_id]->activity, array(
						'issue' => $issues[$row->item_id],
						'project' => $this,
						'user' => $users[$row->user_id],
						'comment' => $comments[$row->action_id],
						'activity' => $row
					));

					break;

				case 5:

					$return[] = View::make('activity/' . $activity_type[$row->type_id]->activity, array(
						'issue' => $issues[$row->item_id],
						'project' => $this,
						'user' => $users[$row->user_id],
						'assigned' => $users[$row->action_id],
						'activity' => $row
					));

					break;

				default:

					$return[] = View::make('activity/' . $activity_type[$row->type_id]->activity, array(
						'issue' => $issues[$row->item_id],
						'project' => $this,
						'user' => $users[$row->user_id],
						'activity' => $row
					));

					break;
			}
		}

		return $return;
	}

	/******************************************************************
	 * Static methods for working with projects
	 ******************************************************************/

	/**
	 * Current loaded Project
	 *
	 * @var Project
	 */
	private static $current = null;

	/**
	* Return the current loaded Project object
	*
	* @return Project
	*/
	public static function current()
	{
		return static::$current;
	}

	/**
	* Load a new Project into $current, based on the $id
	*
	* @param   int  $id
	* @return  void
	*/
	public static function load_project($id)
	{
		static::$current = static::find($id);
	}

	/**
	* Create a new project
	*
	* @param  array  $input
	* @return array
	*/
	public static function create_project($input)
	{
		$rules = array(
			'name' => 'required|max:250'
		);

		$validator = \Validator::make($input, $rules);

		if($validator->fails())
		{
			return array(
				'success' => false,
				'errors' => $validator->errors
			);
		}

		$fill = array(
			'name' => $input['name'],
			'default_assignee' => $input['default_assignee'],
		);

		$project = new Project;
		$project->fill($fill);
		$project->save();

		/* Assign selected users to the project */
		if(isset($input['user']) && count($input['user']) > 0)
		{
			foreach($input['user'] as $id)
			{
				$project->assign_user($id);
			}
		}

		return array(
			'project' => $project,
			'success' => true
		);
	}

	/**
	* Update a project
	*
	* @param array     $input
	* @param \Project  $project
	* @return array
	*/
	public static function update_project($input, $project)
	{
		$rules = array(
			'name' => 'required|max:250'
		);

		$validator = \Validator::make($input, $rules);

		if($validator->fails())
		{
			return array(
				'success' => false,
				'errors' => $validator->errors
			);
		}

		$fill = array(
			'name' => $input['name'],
			'status' => $input['status'],
			'default_assignee' => $input['default_assignee'],
		);

		$project->fill($fill);
		$project->save();

		return array(
			'success' => true
		);
	}

	/**
	* Delete a project and it's children
	*
	* @param  Project  $project
	* @return void
	*/
	public static function delete_project($project)
	{
		$id = $project->id;
		$project->delete();

		/* Delete all children from the project */
		Project\Issue::where('project_id', '=', $id)->delete();
		Project\Issue\Comment::where('project_id', '=', $id)->delete();
		Project\User::where('project_id', '=', $id)->delete();
		User\Activity::where('parent_id', '=', $id)->delete();
	}

}