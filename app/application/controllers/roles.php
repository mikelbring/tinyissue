<?php

class Roles_Controller extends Base_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->filter('before', 'permission:administration');
	}

	/**
	 * Show role list
	 *
	 * @return View
	 */
	public function get_index()
	{
		return $this->layout->with('active', 'dashboard')->nest('content', 'roles.index', array(
			'roles' => Role::order_by('role', 'ASC')->get()
		));
	}
	
	
	/**
	 * Edit all roles
	 *
	 * @return View
	 */	
	public function post_index()
	{
		foreach ($_POST["RoleName"] as $id => $Name ) {
			\DB::table('roles')->where('id', '=', $id)->update(array('name' => $Name, 'description' => $_POST["RoleDesc"][$id]));
		}
		return Redirect::to('roles');
	}

}