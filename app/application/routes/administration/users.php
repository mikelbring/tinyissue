<?php

return array(

	/**
	 * Show all users
	 */
	'GET /administration/users' => array('before' => 'permission:administration', function()
	{
		return View::of_wrapper()->nest('content', 'administration/users/index',array(
			'roles' => Role::order_by('id', 'DESC')->get()
		));
	}),

	/**
	 * Add a new user
	 */
	'GET /administration/users/add' => array('before' => 'permission:administration', function()
	{
		return View::of_wrapper()->nest('content', 'administration/users/add');
	}),

	'POST /administration/users/add' => array('before' => 'permission:administration|csrf', function()
	{
		$add = User::add_user(Input::all());

		if(!$add['success'])
		{
			return Redirect::to('administration/users/add/')
					->with_input()
					->with_errors($add['errors'])
					->with('notice-error', 'Whoops, we have a few errors.');
		}

		return Redirect::to('administration/users')
				->with('notice', 'User Added');
	}),

	/**
	 * Edit a user
	 */
	'GET /administration/users/edit/(:num)' => array('before' => 'permission:administration', function($id)
	{
		return View::of_wrapper()->nest('content', 'administration/users/edit',array(
			'user' => User::find($id)
		));
	}),

	'POST /administration/users/edit/(:num)' => array('before' => 'permission:administration|csrf', function($id)
	{
		$update = User::update_user(Input::all(),$id);

		if(!$update['success'])
		{
			return Redirect::to('administration/users/edit/'.$id)
					->with_input()
					->with_errors($update['errors'])
					->with('notice-error', 'Whoops, we have a few errors.');
		}

		return Redirect::to('administration/users')
				->with('notice', 'User Updated');
	}),

	/**
	 * Delete a user
	 */
	'GET /administration/users/delete/(:num)' => array('before' => 'permission:administration', function($id)
	{
		User::delete_user($id);

		return Redirect::to('administration/users')
				->with('notice','User Deleted');
	})

);