<?php

class Ajax_Todo_Controller extends Base_Controller {

	public $layout = null;
  
	public function __construct() {
		parent::__construct();
	}
  
	public function post_add_todo() {
		$result = Todo::add_todo(Input::get('issue_id'));
		return json_encode($result);
	}

	public function post_remove_todo() {
		$result = Todo::remove_todo(Input::get('issue_id'));
		return json_encode($result);
	}

	public function post_update_todo() {
		$result = Todo::update_todo(Input::get('issue_id'), Input::get('new_status'));
		return json_encode($result);
	}
  
	public function post_get_user_todos() {
		$result = Todo::load_user_todos();
		return json_encode($result);
	}

}
