<?php

class Login_Controller extends Controller {

	public $restful = true;

	public function get_index()
	{
		return View::make('layouts.login');
	}

	public function post_index()
	{
		if(Auth::attempt(Input::get('email'), Input::get('password'), (bool) Input::get('remember')))
		{
			return Redirect::to(Input::get('return', '/'));
		}

	  return Redirect::to('login')
			  ->with('error', 'Whoops, your username or password did not match.');
	}

}