<?php

return array(

   'GET /project/(:num)' => array('before' => 'project', function()
   {
      return View::of_project(array('active' => 'projects'))->nest('content', 'project/index', array(
			'page' => View::make('project/index/activity', array(
				'project' => Project::current(),
				'activity' => Project::current()->activity(10)
			)),
         'active' => 'activity',
			'open_count' => Project::current()->issues()
								 ->where('status', '=', 1)
								 ->count(),
			'closed_count' => Project::current()->issues()
				 ->where('status', '=', 0)
				 ->count(),
			'assigned_count' => Project::current()->count_assigned_issues(),
		));
   }),

	/**
	 * Issues
	 */
	'GET /project/(:num)/issues' => array('before' => 'project', function()
	{
		 $status = Input::get('status', 1);

		 return View::of_project(array('active' => 'projects'))->nest('content', 'project/index', array(
			 'page' => View::make('project/index/issues', array(
				 'issues' => Project::current()->issues()
					->with('user')
					->with('updated')
					->where('status', '=', $status)
					->order_by('updated_at', 'DESC')
					->get(),
			 )),
			 'active' => $status == 1 ? 'open' : 'closed',
			 'open_count' => Project::current()->issues()
				 ->where('status', '=', 1)
				 ->count(),
			'closed_count' => Project::current()->issues()
				 ->where('status', '=', 0)
				 ->count(),
			'assigned_count' => Project::current()->count_assigned_issues()
		));
	}),

	/**
	 * Issues
	 */
	'GET /project/(:num)/issues/assigned' => array('before' => 'project', function()
	{
		 $status = Input::get('status', 1);

		 return View::of_project(array('active' => 'projects'))->nest('content', 'project/index', array(
			 'page' => View::make('project/index/issues', array(
				 'issues' => Project::current()->issues()
					->with('user')
					->with('updated')
					->where('status', '=', $status)
				 	->where('assigned_to', '=', Auth::user()->id)
					->order_by('updated_at', 'DESC')
					->get(),
			 )),
			 'active' => 'assigned',
			 'open_count' => Project::current()->issues()
				 ->where('status', '=', 1)
				 ->count(),
			 'closed_count' => Project::current()->issues()
				 ->where('status', '=', 0)
				 ->count(),
			 'assigned_count' => Project::current()->count_assigned_issues()
		));
	}),

   /**
    * Edit a project
    */
	'GET /project/(:num)/edit' => array('before' => 'project|permission:project-modify', function()
	{
		return View::of_project(array('active' => 'projects'))->nest('content', 'project/edit', array(
			'project' => Project::current()
		));
	}),

	'POST /project/(:num)/edit' => array('before' => 'project|permission:project-modify', function()
	{
      /* Delete the project */
      if(Input::get('delete'))
      {
         Project::delete_project(Project::current());

         return Redirect::to('/projects')
               ->with('notice', 'The project has been deleted.');
      }

      /* Update the project */
		$update = Project::update_project(Input::all(), Project::current());

		if($update['success'])
		{
			return Redirect::to(Project::current()->to('edit'))
					->with('notice', 'Project has been updated!');
		}

		return Redirect::to(Project::current()->to('edit'))
				->with_errors($update['errors'])
            ->with('notice-error', 'Whoops, we have some errors below.');
	})

);