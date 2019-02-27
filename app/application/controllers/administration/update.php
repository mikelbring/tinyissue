<?php

class Administration_Update_Controller extends Base_Controller {

	public function __construct() {
		parent::__construct();

		$this->filter('before', 'permission:administration');
	}

	public function get_index() {
		return $this->layout->with('active', 'dashboard')->nest('content', 'administration.update.index', array());
	}

	public function post_index() {
//		$update = Project\Issue::current()->update_issue(Input::all());

//		if(!$update['success']) {
//			return Redirect::to(Project\Issue::current()->to('edit'))
//				->with_input()
//				->with_errors($update['errors'])
//				->with('notice-error', __('tinyissue.we_have_some_errors'));
//		}

		return $this->layout->with('active', 'dashboard')->nest('content', 'administration.update.index', array());
	}

}