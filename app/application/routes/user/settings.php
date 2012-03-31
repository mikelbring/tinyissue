<?php

return array(

   'GET /user/settings' => function()
   {
		return View::of_wrapper(array('active' => 'settings'))->nest('content', 'user/settings', array(
         'user' => User::find(Auth::user()->id)
      ));
   },

	'POST /user/settings' => function()
	{
		$settings = User\Setting::update_user_settings(Input::all(), Auth::user()->id);

      if(!$settings['success'])
      {
         return Redirect::to('settings')
               ->with_input()
               ->with_errors($settings['errors'])
               ->with('notice-error', 'Whoops, we have some errors below.');
      }

      return Redirect::to('user/settings')
				->with('notice', 'Settings Updated');
	}

);