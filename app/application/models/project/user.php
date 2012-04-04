<?php namespace Project;

class User extends \Eloquent {

	public static $table  = 'projects_users';

   /**********************************************************
    * Methods to use with loaded User
    **********************************************************/

   /**
    * @return User
    */
   public function user()
   {
      return $this->belongs_to('User', 'user_id')->order_by('firstname', 'ASC');
   }

	/**
	 * @return Project
	 */
	public function project()
	{
		return $this->belongs_to('Project', 'project_id')->order_by('name', 'ASC');
	}

   /******************************************************************
  	 * Static methods for working with Users on a Project
  	 ******************************************************************/

   /**
    * Assign a user to a project with a role
    *
    * @param  int   $user_id
    * @param  int   $project_id
    * @param  int   $role_id
    * @return void
    */
   public static function assign($user_id, $project_id, $role_id = 0)
   {
		if(!static::check_assign($user_id, $project_id))
		{
			$fill = array(
				'user_id' => $user_id,
				'project_id' => $project_id,
				'role_id' => $role_id
			);

			$relation = new static;
			$relation->fill($fill);
			$relation->save();
		}
   }

	public static function remove_assign($user_id, $project_id)
	{
		static::where('user_id', '=', $user_id)
			->where('project_id', '=', $project_id)
			->delete();
	}

	public static function check_assign($user_id, $project_id)
	{
		return (bool) static::where('user_id', '=', $user_id)
				->where('project_id', '=', $project_id)
				->first(array('id'));
	}

	/**
	 * Build a dropdown of all users in the project
	 *
	 * @param  object  $users
	 * @return array
	 */
   public static function dropdown($users)
   {
      $return = array();

      foreach($users as $row)
      {
         $return[$row->id] = $row->firstname . ' ' . $row->lastname;
      }

      return $return;
   }

	public static function users_issues($user = null)
	{
		if(is_null($user))
		{
			$user = \Auth::user();
		}

		$projects = array();

		foreach(static::active_projects(true) as $project)
		{
			$project = array(
				'detail' => $project,
				'issues' => $project->issues()
						->where('assigned_to', '=', $user->id)
						->where('status', '=', 1)
						->get()
			);

			if(count($project['issues']) > 0)
			{
				$projects[] = $project;
			}
		}

		return $projects;
	}

	public static function active_projects($all = false, $user = null)
	{
		if(is_null($user))
		{
			$user = \Auth::user();
		}

		if($all)
		{
			if($user->permission('project-all'))
			{
				return \Project::where('status', '=', 1)
						->order_by('name', 'ASC')
						->get();
			}
		}

		$projects = array();

		foreach(static::with('project')->where('user_id', '=', $user->id)->get() as $row)
		{
			if($row->project->status != 1)
			{
				continue;
			}

			$projects[] = $row->project;
		}

		return $projects;
	}

	public static function inactive_projects($all = false, $user = null)
	{
		if(is_null($user))
		{
			$user = \Auth::user();
		}

		if($all)
		{
			if($user->permission('project-all'))
			{
				return \Project::where('status', '=', 0)
						->order_by('name', 'ASC')
						->get();
			}
		}

		$projects = array();

		foreach(static::with('project')->where('user_id', '=', \Auth::user()->id)->get() as $row)
		{
			if($row->project->status != 0)
			{
				continue;
			}

			$projects[] = $row->project;
		}

		return $projects;
	}

}