<?php

class Administration_Controller extends Base_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->filter('before', 'permission:administration');
	}

	/**
	 * Show general application stats
	 * /administration
	 *
	 * @return View
	 */
	public function get_index()
	{
		$issues = Project\Issue::count_issues();
		return $this->layout->with('active', 'dashboard')->nest('content', 'administration.index', array(
			'users' => User::where('deleted', '=', 0)->count(),
			'active_projects' => Project::where('status', '=', 1)->count(),
			'archived_projects' => Project::where('status', '=', 0)->count(),
			'issues' => $issues,
			'roles' => Role::count(),
			'tags' => Tag::count(),
		));
	}
}