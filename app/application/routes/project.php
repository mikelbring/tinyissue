<?php

$routes = array(

   'GET /project/new' => function()
   {
		Asset::script('project-new', '/app/assets/js/project-new.js', array('app'));

      return View::of_wrapper(array('active' => 'projects'))->nest('content', 'project/new');
   },

   'POST /project/new' => function()
   {
      $create = Project::create_project(Input::all());

      if($create['success'])
      {
         return Redirect::to($create['project']->to());
      }

      return Redirect::to('project/new')
				->with_errors($create['errors'])
            ->with('notice-error', 'Whoops, we have some errors below.');
   }

);

foreach(glob(APP_PATH . 'routes/project/*.php') as $file)
{
	$routes += include($file);
}

return $routes;