<?php

class Administration_Users_Controller extends Base_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->filter('before', 'permission:administration');
	}

	public function get_index()
	{
		return $this->layout->with('active', 'dashboard')->nest('content', 'administration.users.index', array(
			'roles' => Role::order_by('id', 'DESC')->get()
		));
	}

	public function get_add()
	{
		return $this->layout->with('active', 'dashboard')->nest('content', 'administration.users.add');
	}

	public function post_add()
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
	}

	public function get_edit($user_id)
	{
		return $this->layout->with('active', 'dashboard')->nest('content', 'administration.users.edit', array(
			'user' => User::find($user_id)
		));
	}

	public function post_edit($user_id)
	{
		$update = User::update_user(Input::all(),$user_id);

		if(!$update['success'])
		{
			return Redirect::to('administration/users/edit/' . $user_id)
				->with_input()
				->with_errors($update['errors'])
				->with('notice-error', 'Whoops, we have a few errors.');
		}

		return Redirect::to('administration/users')
			->with('notice', 'User Updated');
	}

	public function get_delete($user_id)
	{
		User::delete_user($user_id);

		return Redirect::to('administration/users')
				->with('notice','User Deleted');
	}
}