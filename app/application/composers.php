<?php

return array(

   'templates.wrapper' => array('name' => 'wrapper', function($view)
   {
      Asset::style('app', 'app/assets/css/app.css');
      Asset::script('jquery', 'app/assets/js/jquery.js');
      Asset::script('jquery-ui', 'app/assets/js/jquery-ui.js');
      Asset::script('app', 'app/assets/js/app.js', 'jquery-ui');

		if(!isset($view->sidebar))
		{
			$view->with('sidebar', View::make('templates/blocks/default_sidebar'));
		}
   }),


	'templates.project' => array('name' => 'project', function($view)
	{
		Asset::style('app', 'app/assets/css/app.css');
		Asset::script('jquery', 'app/assets/js/jquery.js');
		Asset::script('jquery-ui', 'app/assets/js/jquery-ui.js');
		Asset::script('app', 'app/assets/js/app.js', 'jquery');

		if(!isset($view->sidebar))
		{
			$view->with('sidebar', View::make('project/sidebar'));
		}
	}),


   'templates/login' => array('name' => 'login', function()
   {
     Asset::style('login', 'app/assets/css/login.css');
   }),

);