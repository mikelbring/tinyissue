<?php
return array(

	'GET /administration' =>  array('before' => 'permission:administration', function()
	{
		$newest_version = @file_get_contents('https://secure.realizetheweb.com/api/newest_release/tinyissue');

		if($newest_version === FALSE)
		{
			$newest_version = false;
		}
		else
		{
			$newest_version = json_decode($newest_version);
		}

		return View::of_wrapper()->nest('content', 'administration/index',array(
			'users' => User::where('deleted', '=', 0)->count(),
			'active_projects' => Project::where('status', '=', 1)->count(),
			'archived_projects' => Project::where('status', '=', 0)->count(),
			'issues' => Project\Issue::count_issues(),
			'newest_version' => $newest_version
		));
	})

);