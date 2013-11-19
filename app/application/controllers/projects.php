<?php

class Projects_Controller extends Base_Controller {

	public function get_index()
	{
		$status = Input::get('status', 1);
		if (Auth::guest()) 
		{
			return $this->layout->with('active', 'projects')->nest('content', 'projects.index', array(
				'projects' => Project::public_projects(),
				'active' => $status == 1 ? 'active' : 'archived',
				'active_count' => 0,
				'archived_count' => 0
			));
		}
		$projects_active = Project\User::active_projects(true);
		$projects_inactive = Project\User::inactive_projects(true);

		return $this->layout->with('active', 'projects')->nest('content', 'projects.index', array(
			'projects' => $status == 1 ? $projects_active : $projects_inactive,
			'active' => $status == 1 ? 'active' : 'archived',
			'active_count' => (int) count($projects_active),
			'archived_count' => (int) count($projects_inactive)
		));
	}

	public function get_new()
	{
		Asset::script('project-new', '/app/assets/js/project-new.js', array('app'));

		return $this->layout->with('active', 'projects')->nest('content', 'projects.new');
	}

	public function post_new()
	{
		$create = Project::create_project(Input::all());

		if($create['success'])
		{
			return Redirect::to($create['project']->to());
		}

		return Redirect::to('projects/new')
			->with_errors($create['errors'])
			->with('notice-error', __('tinyissue.we_have_some_errors'));
	}

}
