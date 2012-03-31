<?php

return array(

   'GET /user/login' => array('name' => 'login', function()
   {
      return View::of_login();
   }),

   'POST /user/login' => array('before' => 'csrf', function()
   {
      if(Auth::attempt(Input::get('email'), Input::get('password'), (bool) Input::get('remember')))
      {
      	return Redirect::to(Input::get('return', '/'));
      }

      return Redirect::to('user/login')
            ->with('error', 'Whoops, your username or password did not match.');
   })

);