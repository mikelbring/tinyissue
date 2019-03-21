<?php

class User extends Eloquent {

	public static $table = 'users';
	public static $timestamps = true;


	/**********************************************************
	* Methods to use with loaded User
	**********************************************************/

	/**
	* Checks to see if $this user is current user
	*
	* @return bool
	*/
	public function me()
	{
		return $this->id == Auth::user()->id;
	}

	/**
	* Check to see if current user has given permission
	*
	* @param  string  $key
	* @return bool
	*/
	public function permission($key)
	{
		return (bool) \Role\Permission::has_permission($key, $this->role_id);
	}

	/**
	* Check to see if current user has permission to see project
	*
	* @param  int   $project_id
	* @return bool
	*/
	public function project_permission($project_id = null)
	{
		if(is_null($project_id))
		{
			$project_id = Project::current()->id;
		}

		if($this->permission('project-all'))
		{
			return true;
		}

		if(Project\User::check_assign($this->id, $project_id))
		{
			return true;
		}

		return false;
	}

	/**
	* Select all issues assigned to a user
	*
	* @param int $status
	* @return mixed
	*/
/*
	public function issues($status = 1)
	{
		return $this->has_many('Project\Issue', 'created_by')
			->where('status', '=', 1)
			->where('assigned_to', '=', $this->id);
	}
*/

	/**
	* Build the user's dashboard
	*
	* @param  int    $activity_limit
	* @return array
	*/
	public function dashboard($activity_limit = 5)
	{
		$dashboard =  $users = $issues = $projects = $comments = $activity_type = array();

		/* Load the activity types */
		foreach(Activity::all() as $row)
		{
			$activity_type[$row->id] = $row;
		}

		/* Loop through all the active projects */
		foreach(Project\User::active_projects() as $project)
		{
			$dashboard[$project->id] = array();
			$projects[$project->id] = $project;

			/* Loop through all the logic from the project and cache all the needed data so we don't load the same data twice */
			foreach(User\Activity::where('parent_id', '=', $project->id)->order_by('created_at', 'DESC')->take($activity_limit)->get() as $activity)
			{
				$dashboard[$project->id][] = $activity;

				switch($activity->type_id)
				{
					case 2:

						if(!isset($issues[$activity->item_id]))
						{
							$issues[$activity->item_id] = Project\Issue::find($activity->item_id);
						}

						if(!isset($users[$activity->user_id]))
						{
							$users[$activity->user_id] = static::find($activity->user_id);
						}

						if(!isset($comments[$activity->action_id]))
						{
							$comments[$activity->action_id] = Project\Issue\Comment::find($activity->action_id);
						}

						break;

					case 5:

						if(!isset($issues[$activity->item_id]))
						{
							$issues[$activity->item_id] = Project\Issue::find($activity->item_id);
						}

						if(!isset($users[$activity->user_id]))
						{
							$users[$activity->user_id] = static::find($activity->user_id);
						}

						if(!isset($users[$activity->action_id]))
						{
							$users[$activity->action_id] = static::find($activity->action_id);
						}


						break;

					default:

						if(!isset($issues[$activity->item_id]))
						{
							$issues[$activity->item_id] = Project\Issue::find($activity->item_id);
						}

						if(!isset($users[$activity->user_id]))
						{
							$users[$activity->user_id] = static::find($activity->user_id);
						}

						break;
				}
			}
		}

		/* Loop through the projects and activity again, building the views for each activity */
		$return = array();

		foreach($dashboard as $project_id => $activity)
		{
			$return[$project_id] = array(
				'project' => $projects[$project_id],
				'activity' => array()
			);

			foreach($activity as $row)
			{
				switch($row->type_id)
				{
					case 2:

						$return[$project_id]['activity'][] = View::make('activity/' . $activity_type[$row->type_id]->activity, array(
							'issue' => $issues[$row->item_id],
							'project' => $projects[$project_id],
							'user' => $users[$row->user_id],
							'comment' => $comments[$row->action_id],
							'activity' => $row
						));

					break;

				case 5:

					$return[$project_id]['activity'][] = View::make('activity/' . $activity_type[$row->type_id]->activity, array(
						'issue' => $issues[$row->item_id],
						'project' => $projects[$project_id],
						'user' => $users[$row->user_id],
						'assigned' => $users[$row->action_id],
						'activity' => $row
					));

					break;
					
				case 6:

					$tag_diff = json_decode($row->data, true);
					$return[$project_id]['activity'][] = View::make('activity/' . $activity_type[$row->type_id]->activity, array(
						'issue' => $issues[$row->item_id],
						'project' => $projects[$project_id],
						'user' => $users[$row->user_id],
						'tag_diff' => $tag_diff,
						'tag_counts' => array('added' => sizeof($tag_diff['added_tags']), 'removed' => sizeof($tag_diff['removed_tags'])),
						'activity' => $row
					));

					break;

				default:

					$return[$project_id]['activity'][] = View::make('activity/' . $activity_type[$row->type_id]->activity, array(
						'issue' => $issues[$row->item_id],
						'project' => $projects[$project_id],
						'user' => $users[$row->user_id],
						'activity' => $row
					));

					break;
				}
			}
		}

		return $return;
	}

	/******************************************************************
	* Static methods for working with users
	******************************************************************/

	/**
	* Update a user
	*
	* @param  array  $info
	* @param  int    $id
	* @return array
	*/
	public static function update_user($info, $id)
	{
		$rules = array(
			'firstname' => array('required', 'max:50'),
			'lastname' => array('required', 'max:50'),
			'email' => array('required', 'email'),
		);

		/* Validate the password */
		if($info['password'])
		{
			$rules['password'] = 'confirmed';
		}

		$validator = Validator::make($info, $rules);

		if($validator->fails())
		{
			return array(
				'success' => false,
				'errors' => $validator->errors
			);
		}
			//Language (below) added
		$update = array(
			'email' => $info['email'],
			'firstname' => $info['firstname'],
			'lastname' => $info['lastname'],
			'language' => $info['language'],
			'role_id' => $info['role_id']
		);

		/* Update the password */
		if($info['password'])
		{
			$update['password'] = Hash::make($info['password']);
		}

		User::find($id)->fill($update)->save();

		return array(
			'success' => true
		);
	}

	/**
	* Add a new user
	*
	* @param  array  $info
	* @return array
	*/
	public static function add_user($info)
	{
		$rules = array(
			'firstname' => array('required', 'max:50'),
			'lastname' => array('required', 'max:50'),
			'email' => array('required', 'email', 'unique:users'),
		);

		$validator = Validator::make($info, $rules);

		if($validator->fails())
		{
			return array(
				'success' => false,
				'errors' => $validator->errors
			);
		}

			//Language (below) added
		$insert = array(
			'email' => $info['email'],
			'firstname' => $info['firstname'],
			'lastname' => $info['lastname'],
			'language' => $info['language'],
			'role_id' => $info['role_id'],
			'password' => Hash::make($password = Str::random(6))
		);

		$user = new User;
		$user->fill($insert)->save();

		/* Send Activation email */
		$view = View::make('email.new_user', array(
			'email' => $info['email'],
			'password' => $password
		));

		Mail::send_email($view, $info['email'], __('email.subject_newuser'));

		return array(
			'success' => true,
			'password' => $password
		);
	}

	/**
	* Soft deletes a user and empties the email
	*
	* @param  int   $id
	* @return bool
	*/
	public static function delete_user($id)
	{
		$update = array(
			'email' => '',
			'deleted' => 1
		);

		User::find($id)->fill($update)->save();
		Project\User::where('user_id', '=', $id)->delete();

		return true;
	}

}
