<?php

return array(

	'GET /ajax/project/inactive-users' => array('before' => 'permission:project-modify', function()
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
	}),

	'POST /ajax/project/add-user' => array('before' => 'permission:project-modify, ajax', function()
	{
		Project\User::assign(Input::get('user_id'), Input::get('project_id'));
	}),

	'POST /ajax/project/remove-user' => array('before' => 'permission:project-modify, ajax', function()
	{
		Project\User::remove_assign(Input::get('user_id'), Input::get('project_id'));
	}),

	'POST /ajax/project/issue/assign' => array('before' => 'permission:issue-modify, ajax', function()
	{
		Project\Issue::find(Input::get('issue_id'))->reassign(Input::get('user_id'));
	}),

	'POST /ajax/project/issue/upload-attachment' => function()
	{
		$user_id = Crypter::decrypt(str_replace(' ', '+', Input::get('session')));

		Auth::login($user_id);

		if(!Auth::user()->project_permission(Input::get('project_id')))
		{
			return Response::error('404');
		}

		Project\Issue\Attachment::upload(Input::all());

		return true;
	},

	'POST /ajax/project/issue/remove-attachment' => array('before' => 'ajax', function()
	{
		Project\Issue\Attachment::remove_attachment(Input::all());
	})

);