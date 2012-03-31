<?php

return array(

	'before' => function()
	{

      if(!in_array(Request::uri(), Config::get('application.login_skip')) && !Auth::check())
      {
         return Redirect::to('user/login')
               ->with('return', Request::uri());
      }
	},

	'after' => function($response)
	{

	},

	'auth' => function()
	{
		if(Auth::guest()) return Redirect::to_login();
	},

	'csrf' => function()
	{
		if(Request::forged()) return Response::error('500');
	},

   'ajax' => function()
   {
      if(!Request::ajax()) return Response::error('500');
   },

   'permission' => function($permission)
   {
      if(!Auth::user()->permission($permission)) return Response::error('500');
   },

   'project' => function()
   {
      Project::load(Request::route()->parameters[0]);

		Asset::script('swf', '/app/assets/js/uploadify/swfobject.js', 'app');
		Asset::script('uploadify', '/app/assets/js/uploadify/jquery.uploadify.v2.1.4.min.js', 'app');
      Asset::script('project', '/app/assets/js/project.js', 'uploadify');
   },

   'issue' => function()
   {
      Project\Issue::load(Request::route()->parameters[1]);
   },

);