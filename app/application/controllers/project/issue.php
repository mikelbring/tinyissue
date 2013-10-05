<?php

class Project_Issue_Controller extends Base_Controller {

	public $layout = 'layouts.project';

	public function __construct()
	{
		parent::__construct();

		$this->filter('before', 'project');
		$this->filter('before', 'issue')->except('new');
		$this->filter('before', 'permission:issue-modify')
				->only(array('edit_comment', 'delete_comment', 'status', 'edit'));
	}

	/**
	 * Create a new issue
	 * /project/(:num)/issue/new
	 *
	 * @return View
	 */
	public function get_new()
	{
		return $this->layout->nest('content', 'project.issue.new', array(
			'project' => Project::current()
		));
	}

	public function post_new()
	{
		$issue = Project\Issue::create_issue(Input::all(), Project::current());

		if(!$issue['success'])
		{
			return Redirect::to(Project::current()->to('issue/new'))
				->with_input()
				->with_errors($issue['errors'])
				->with('notice-error', __('tinyissue.we_have_some_errors'));
		}

		return Redirect::to($issue['issue']->to())
			->with('notice', __('tinyissue.issue_has_been_created'));
	}

	/**
	 * View a issue
	 * /project/(:num)/issue/(:num)
	 *
	 * @return View
	 */
	public function get_index()
	{
		/* Delete a comment */
		if(Input::get('delete') && Auth::user()->permission('issue-modify'))
		{
			Project\Issue\Comment::delete_comment(str_replace('comment', '', Input::get('delete')));

			return true;
		}

		return $this->layout->nest('content', 'project.issue.index', array(
			'issue' => Project\Issue::current(),
			'project' => Project::current(),
			'projects' => Project\User::active_projects(true)
		));
	}

	/**
	 * Post a comment to a issue
	 *
	 * @return Redirect
	 */
	public function post_index()
	{
		if(!Input::get('comment'))
		{
			return Redirect::to(Project\Issue::current()->to() . '#new-comment')
				->with('notice-error', __('tinyissue.you_put_no_comment'));
		}

		$comment = \Project\Issue\Comment::create_comment(Input::all(), Project::current(), Project\Issue::current());

		return Redirect::to(Project\Issue::current()->to() . '#comment' . $comment->id)
			->with('notice', __('tinyissue.your_comment_added'));
	}

	/**
	 * Edit a issue
	 *
	 * @return View
	 */
	public function get_edit()
	{
		return $this->layout->nest('content', 'project.issue.edit', array(
			'issue' => Project\Issue::current(),
			'project' => Project::current()
		));
	}

	public function post_edit()
	{
		$update = Project\Issue::current()->update_issue(Input::all());

		if(!$update['success'])
		{
			return Redirect::to(Project\Issue::current()->to('edit'))
				->with_input()
				->with_errors($update['errors'])
				->with('notice-error', __('tinyissue.we_have_some_errors'));
		}

		return Redirect::to(Project\Issue::current()->to())
			->with('notice', __('tinyissue.issue_has_been_updated'));
	}

	/**
	 * Update / Edit a comment
	 * /project/(:num)/issue/(:num)/edit_comment
	 *
	 * @request ajax
	 * @return string
	 */
	public function post_edit_comment()
	{
		if(Input::get('body'))
		{
			$comment = Project\Issue\Comment::find(str_replace('comment', '', Input::get('id')))
					->fill(array('comment' => Input::get('body')))
					->save();

			return Project\Issue\Comment::format(Input::get('body'));
		}
	}

	/**
	 * Delete a comment
	 * /project/(:num)/issue/(:num)/delete_comment
	 *
	 * @return Redirect
	 */
	public function get_delete_comment()
	{
		Project\Issue\Comment::delete_comment(Input::get('comment'));

		return Redirect::to(Project\Issue::current()->to())
			->with('notice', __('tinyissue.comment_deleted'));
	}

	/**
	 * Change the status of a issue
	 * /project/(:num)/issue/(:num)/status
	 *
	 * @return Redirect
	 */
	public function get_status()
	{
		$status = Input::get('status', 0);

		if($status == 0)
		{
			$message = __('tinyissue.issue_has_been_closed');
		}
		else
		{
			$message = __('tinyissue.issue_has_been_reopened');
		}

		Project\Issue::current()->change_status($status);

		return Redirect::to(Project\Issue::current()->to())
			->with('notice', $message);
	}

}