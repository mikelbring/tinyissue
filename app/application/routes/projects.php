<?php

return array(

   'GET /projects' => function()
   {
      $status = Input::get('status', 1);

		$projects_active = Project\User::active_projects(true);
		$projects_inactive = Project\User::inactive_projects(true);

      return View::of_wrapper(array('active' => 'projects'))->nest('content', 'projects/index', array(
         'projects' => $status == 1 ? $projects_active : $projects_inactive,
         'active' => $status == 1 ? 'active' : 'archived',
         'active_count' => (int) count($projects_active),
         'archived_count' => (int) count($projects_inactive)
      ));
   }

);