<?php

class Project_Issue_Controller extends Base_Controller {

	public $layout = 'layouts.project';

	public function __construct()
	{
		parent::__construct();

		$this->filter('before', 'project');
		$this->filter('before', 'issue')->except('new');
		$this->filter('before', 'permission:issue-modify')
				->only(array('edit_comment', 'delete_comment', 'reassign', 'status', 'edit'));
	}

	/**
	 * Create a new issue
	 * /project/(:num)/issue/new
	 *
	 * @return View
	 */
	public function get_new()
	{
		Asset::add('tag-it-js', '/app/assets/js/tag-it.min.js', array('jquery', 'jquery-ui'));
		Asset::add('tag-it-css-base', '/app/assets/css/jquery.tagit.css');
		Asset::add('tag-it-css-zendesk', '/app/assets/css/tagit.ui-zendesk.css');

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
			'project' => Project::current()
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
		Asset::add('tag-it-js', '/app/assets/js/tag-it.min.js', array('jquery', 'jquery-ui'));
		Asset::add('tag-it-css-base', '/app/assets/css/jquery.tagit.css');
		Asset::add('tag-it-css-zendesk', '/app/assets/css/tagit.ui-zendesk.css');

		/* Get tags as string */
		$issue_tags = '';
		foreach(Project\Issue::current()->tags as $tag)
		{
			$issue_tags .= (!empty($issue_tags) ? ',' : '') . $tag->tag;
		}

		return $this->layout->nest('content', 'project.issue.edit', array(
			'issue' => Project\Issue::current(),
			'issue_tags' => $issue_tags,
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
	public function get_status() {
		$status = Input::get('status', 0);

		if($status == 0) {
			$message = __('tinyissue.issue_has_been_closed');
		} else {
			$message = __('tinyissue.issue_has_been_reopened');
		}

		Project\Issue::current()->change_status($status);

		return Redirect::to(Project\Issue::current()->to())
			->with('notice', $message);
	}

	/**
	 * Edit a issue
	 *
	 * @return View
	 */
	public function get_reassign() {
		if (Input::get('Next') == 0 ) { $result = false; } else {
			//Let note that into the issue table
			$resul  = __('tinyissue.edit_issue')." : ";
			$Modif = Project\Issue::where('id', '=', Input::get('Issue'))->update(array('assigned_to' => Input::get('Next')));
			$resul .= ($Modif) ? "Succès" : "Échec";

			//Let note that into the activity table so it cans show the reassigning history
			$resul .= "\\n";
			$resul .= __('tinyissue.activity')." : ";
			$resul .= (\User\Activity::add(5, Input::get('Prev'), Input::get('Issue'), Input::get('Next') )) ? "Succès" : "Échec";

			//Search for new assignee infos
			$Who = \User::where('id', '=', Input::get('Next') )->get(array('firstname','lastname','email'));
			$WhoName = $Who[0]->attributes["firstname"].' '.$Who[0]->attributes["lastname"];
			$WhoAddr = $Who[0]->attributes["email"];
			$thisIssue = \Project\Issue::where('id', '=', Input::get('Issue'))->get('*');
			$Issue_title = $thisIssue[0]->attributes["title"];
			$Project = \Project::where('id', '=', $thisIssue[0]->attributes["project_id"])->get(array('id', 'name'));
			$project_id = $Project[0]->attributes["id"];
			$project_nm = $Project[0]->attributes["name"];
			$project = \Project::find($project_id);

			if ($Modif) {  //Send mail to the new assignee
				$subject  = sprintf(__('email.reassignment'),$Issue_title,$project_nm);
				$text  = sprintf(__('email.reassignment'),$Issue_title,$project_nm);
				$text .= "\n\n";
				$text .= sprintf(__('email.reassigned_by'),\Auth::user()->firstname." ".\Auth::user()->lastname);
				$text .= "\n\n";
				$text .= __('email.more_url')." http://". $_SERVER['SERVER_ADDR'] ."/project/".$project_id."/issue/".Input::get('Issue')."";
				\Mail::send_email($text, $WhoAddr, $subject);
			}

			//Show on screen what did just happened
			$result = "
			<script>
				parent.document.getElementById('div_currentlyAssigned_name').innerHTML = '<label class=\"label warning\">".__('tinyissue.label_reassigned')."</label> ".__('tinyissue.to')." ".$WhoName." " . __('tinyissue.by') . " " . \Auth::user()->firstname . " " . \Auth::user()->lastname . "';
				parent.document.getElementById('div_currentlyAssigned_name').style.backgroundColor = '#e8e8e8';
				parent.document.getElementById('div_currentlyAssigned_name').style.padding = '12px 10px';
				parent.document.getElementById('div_currentlyAssigned_name').style.verticalAlign = 'middle';
				parent.document.getElementById('div_currentlyAssigned_name').style.borderRadius = '6x';
				parent.document.getElementById('span_currentlyAssigned_name').innerHTML = '".$WhoName."';
				//alert('".$resul."');
			</script>
			";
		}
		return $result;
	}

}
