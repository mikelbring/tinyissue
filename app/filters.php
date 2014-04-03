<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

Route::filter('before', function()
{

});

Route::filter('after', function($response)
{

});

Route::filter('csrf', function()
{
    if (Request::forged())
    {
        throw new \RuntimeException('Invalid csrf key.');
    }
});

Route::filter('auth', function()
{
    if (Auth::guest())
    {
        return Redirect::to('login');
    }
});

Route::filter('ajax', function()
{
    if ( ! Request::ajax())
    {
        throw new NotFoundHttpException();
    }
});

/**
 * Retrieve current project given by request.
 */
Route::filter('project', function()
{
    Project::loadProject((int) Route::input('project_id'));

    if ( ! Project::current())
    {
        throw new NotFoundHttpException();
    }
});

/**
 * Retrieve current issue given by request.
 */
Route::filter('issue', function()
{
    Project\Issue::loadIssue((int) Route::input('issue_id'));

    if ( ! Project\Issue::current())
    {
        throw new NotFoundHttpException();
    }
});

Route::filter('permission', function($route, $request, $permission)
{
    if ( ! Auth::user()->permission($permission))
    {
        throw new AccessDeniedHttpException();
    }
});
