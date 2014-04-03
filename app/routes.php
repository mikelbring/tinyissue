<?php

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/

// Project controller
Route::any('project/{project_id}', array('uses' => 'ProjectController@index'))
    ->where('project_id', '[0-9]+');
Route::any('project/{project_id}/issues', array('uses' => 'ProjectController@issues'))
    ->where('project_id', '[0-9]+');
Route::any('project/{project_id}/assigned', array('uses' => 'ProjectController@assigned'))
    ->where('project_id', '[0-9]+');

// Issue controller
Route::any('project/{project_id}/issue/new', array('uses' => 'Project\\IssueController@create'))
    ->where('project_id', '[0-9]+');
Route::any('project/{project_id}/issue/{issue_id}', array('uses' => 'Project\\IssueController@index'))
    ->where('project_id', '[0-9]+')
    ->where('issue_id', '[0-9]+');
Route::any('project/{project_id}/issue/{issue_id}/edit', array('uses' => 'Project\\IssueController@edit'))
    ->where('project_id', '[0-9]+')
    ->where('issue_id', '[0-9]+');
Route::any('project/{project_id}/issue/{issue_id}/status', array('uses' => 'Project\\IssueController@status'))
    ->where('project_id', '[0-9]+')
    ->where('issue_id', '[0-9]+');
Route::post('project/{project_id}/issue/{issue_id}/delete_comment', array('uses' => 'Project\\IssueController@delete_comment'))
    ->where('project_id', '[0-9]+')
    ->where('issue_id', '[0-9]+');

// Ajax
Route::get('ajax/project/inactiveUsers', array('uses' => 'Ajax\\ProjectController@inactiveUsers'));
Route::post('ajax/project/addUser',      array('uses' => 'Ajax\\ProjectController@addUser'));
Route::post('ajax/project/removeUser',   array('uses' => 'Ajax\\ProjectController@removeUser'));
Route::post('ajax/project/issueAssign',  array('uses' => 'Ajax\\ProjectController@issueAssign'));
Route::post('ajax/project/issueUploadAttachment',  array('uses' => 'Ajax\\ProjectController@issueUploadAttachment'));
Route::post('ajax/project/issueRemoveAttachment',  array('uses' => 'Ajax\\ProjectController@issueRemoveAttachment'));

Route::controllers(array(
    '/administration/users' => 'Admin\\UsersController',
    '/administration'       => 'AdminController',

    '/ajax/project' => 'Ajax\\ProjectController',

    '/login'    => 'LoginController',
    '/project'  => 'ProjectController',
    '/projects' => 'ProjectsController',
    '/user'     => 'UserController',
    '/'         => 'HomeController',
));


View::composer('layouts.wrapper', function($view)
{
    if ( ! isset($view->sidebar))
    {
        $view->with('sidebar', View::make('layouts.blocks.default_sidebar'));
    }
});

View::composer('layouts.project', function($view)
{
    if ( ! isset($view->sidebar))
    {
        $view->with('sidebar', View::make('project.sidebar'));
    }

    $view->active = 'projects';
});


/*
|--------------------------------------------------------------------------
| Events
|--------------------------------------------------------------------------
*/

Event::listen('404', function()
{
    return Response::error('404');
});

Event::listen('500', function()
{
    return Response::error('500');
});
