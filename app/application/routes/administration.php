<?php
return array(

	'GET /administration' =>  array('before' => 'permission:administration', function()
	{
		return View::of_wrapper()->nest('content', 'administration/index',array(
			'users' => User::where('deleted', '=', 0)->count(),
			'active_projects' => Project::where('status', '=', 1)->count(),
			'archived_projects' => Project::where('status', '=', 0)->count(),
			'issues' => Project\Issue::count_issues(),
		));
	})

);