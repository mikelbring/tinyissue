<?php

class Ajax_Project_Controller extends Base_Controller {

	public $layout = null;

	public function __construct()
	{
		parent::__construct();

		//$this->filter('before', 'ajax')->except('issue_upload_attachment');
		$this->filter('before', 'permission:project-modify')->only(array(
			'inactive_users',
			'add_user',
			'remove_user',
		));
		$this->filter('before', 'permission:issue-modify')->only(array(
			'issue_assign'
		));

	}

	public function get_inactive_users()
	{
		$project = Project::find(Input::get('project_id'));

		$results = array();

		if(is_null($project))
		{
			$users = User::all();
		}
		else
		{
			$users = $project->users_not_in();
		}

		foreach($users as $row)
		{
			$results[] = array(
				'id' => $row->id,
				'label' => $row->firstname . ' ' . $row->lastname
			);
		}

		return json_encode($results);
	}

	public function post_add_user()
	{
		Project\User::assign(Input::get('user_id'), Input::get('project_id'));
	}

	public function post_remove_user()
	{
		Project\User::remove_assign(Input::get('user_id'), Input::get('project_id'));
	}

	public function post_issue_assign()
	{
		Project\Issue::find(Input::get('issue_id'))->reassign(Input::get('user_id'));
	}

	public function post_issue_project()
	{
		Project\Issue::find(Input::get('issue_id'))->change_project(Input::get('project_id'));
	}

	public function post_issue_upload_attachment()
	{
		$user_id = Crypter::decrypt(str_replace(' ', '+', Input::get('session')));

		Auth::login($user_id);

		if(!Auth::user()->project_permission(Input::get('project_id')))
		{
			return Response::error('404');
		}

		Project\Issue\Attachment::upload(Input::all());

		return true;
	}

	public function post_issue_remove_attachment()
	{
		Project\Issue\Attachment::remove_attachment(Input::all());
	}

}