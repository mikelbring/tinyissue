<?php

return array(

	'GET /user/issues' => function()
	{
		return View::of_wrapper(array('active' => 'issues'))->nest('content', 'user/issues', array(
         'projects' => Project\User::users_issues(),

      ));
	}


);