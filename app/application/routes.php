<?php

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/
Route::any('project/(:num)', 'project@index');
Route::any('project/(:num)/(:any)', 'project@(:2)');
Route::any('project/(:num)/issue/new', 'project.issue@new');
Route::any('project/(:num)/issue/(:num)', 'project.issue@index');
Route::any('project/(:num)/issue/(:num)/(:any)', 'project.issue@(:3)');


Route::controller(array(
	'home',
	'project',
	'projects',
	'login',
	'user',
	'administration.users',
	'administration',
	'ajax.project'
));


/*
|--------------------------------------------------------------------------
| Events
|--------------------------------------------------------------------------
*/

View::composer('layouts.wrapper', function($view)
{
	Asset::style('app', 'app/assets/css/app.css');
	Asset::script('jquery', 'app/assets/js/jquery.js');
	Asset::script('jquery-ui', 'app/assets/js/jquery-ui.js');
	Asset::script('app', 'app/assets/js/app.js', 'jquery-ui');

	if(!isset($view->sidebar))
	{
		$view->with('sidebar', View::make('layouts.blocks.default_sidebar'));
	}
});

View::composer('layouts.project', function($view)
{
	Asset::style('app', 'app/assets/css/app.css');
	Asset::script('jquery', 'app/assets/js/jquery.js');
	Asset::script('jquery-ui', 'app/assets/js/jquery-ui.js');
	Asset::script('app', 'app/assets/js/app.js', 'jquery');

	Asset::script('swf', '/app/assets/js/uploadify/swfobject.js', 'app');
	Asset::script('uploadify', '/app/assets/js/uploadify/jquery.uploadify.v2.1.4.min.js', 'app');
	Asset::script('project', '/app/assets/js/project.js', 'uploadify');

	if(!isset($view->sidebar))
	{
		$view->with('sidebar', View::make('project.sidebar'));
	}

	$view->active = 'projects';
});

View::composer('layouts.login', function($view)
{
	Asset::style('login', 'app/assets/css/login.css');
});

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Filters
|--------------------------------------------------------------------------
*/

Route::filter('before', function()
{

});

Route::filter('after', function($response)
{

});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});

Route::filter('ajax', function()
{
	if (!Request::ajax()) return Response::error('404');
});

Route::filter('project', function()
{
	// find project id from issue object
	if (Request::route()->parameters[0] == 0) {
		return;
	}

	Project::load_project(Request::route()->parameters[0]);

	if(!Project::current())
	{
		return Response::error('404');
	}
});

Route::filter('issue', function()
{
	Project\Issue::load_issue(Request::route()->parameters[1]);

	if(!Project\Issue::current())
	{
		return Response::error('404');
	}

	// load project
	if (Request::route()->parameters[0] == 0) {
		Request::route()->parameters = array(
			Project\Issue::current()->project_id,
			Project\Issue::current()->id
		);

		Project::load_project(Request::route()->parameters[0]);
	}
});

Route::filter('permission', function($permission)
{
	if(!Auth::user()->permission($permission)) return Response::error('500');
});
