<?php

class Project_Issue_Controller extends Base_Controller {

	public $layout = 'layouts.project';

	public function __construct()
	{
		parent::__construct();

		$this->filter('before', 'project');
		$this->filter('before', 'issue')->except('new');
		$this->filter('before', 'permission:issue-modify')
				->only(array('edit_comment', 'delete_comment', 'reassign', 'retag', 'status', 'edit'));
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


	private function show_tag ($Content) {
		$result = "
		<script>
			parent.document.getElementById('div_currentlyAssigned_name').style.backgroundColor = '#e8e8e8';
			parent.document.getElementById('div_currentlyAssigned_name').style.padding = '12px 10px';
			parent.document.getElementById('div_currentlyAssigned_name').style.verticalAlign = 'middle';
			parent.document.getElementById('div_currentlyAssigned_name').style.borderRadius = '6x';
			var ad = parent.document.createElement(\"SPAN\");
			var adTxt = parent.document.createTextNode(".$Content.");
			ad.appendChild(adTxt);
			parent.document.getElementById('div_currentlyAssigned_name').appendChild(ad);
		</script>
		";
		return $result;
	}



	/**
	 * Edit a issue
	 *
	 * @change assignation
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
			$content  = '<div class="insides"><div class="topbar"><div class="data"><label class="label warning">';
			$content .= __('tinyissue.label_reassigned');
			$content .= '</label> ';
			$content .= __('tinyissue.to');
			$content .= ' <b>'.$WhoName.'</b> ';
			$content .= __('tinyissue.by').' ';
			$content .= \Auth::user()->firstname.' ';
			$content .= \Auth::user()->lastname;
			$content .= '</div></div></div>';
			$t = time();
			$result = "
			<script>
				var adLi = document.createElement(\"LI\");
				adLi.className = 'comment';
				adLi.id = 'comment".$t."';
				parent.document.getElementById('ul_IssueDiscussion').appendChild(adLi);
				parent.document.getElementById('comment".$t."').innerHTML = '".$content."';
				parent.document.getElementById('span_currentlyAssigned_name').innerHTML = '".$WhoName."';
			</script>
			";
		}
		return $result;
	}

	/**
	 * Edit an issue
	 *
	 * change tags
	 */
	public function get_retag() {
		if (Input::get('avant') == Input::get('apres') ) { $result = false; } else {
			$LESgets = array_keys($_GET);
			$Datas = explode("/", $LESgets[0]);
			$Issue = $Datas[4];

			//avant = before
			//apres = after
			$avant = explode("|",$_GET["avant"] );
			foreach ($avant as $ind=>$val) { if (trim($val) == '') { unset($avant[$ind]); } }


			if (substr($_GET["apres"], 0, 5) == 'xxxxx') {  //We add new tags
				$_GET["apres"] = substr($_GET["apres"], 5);
				$apres = explode(",",$_GET["apres"] );
				foreach ($apres as $ind=>$val) { if (trim($val) == '') { unset($apres[$ind]); } }
				$TagsDiff = array_diff($apres,$avant);
				$Msg = __('tinyissue.tag_added');
				//foreach ($TagsDiff as $ind => $this) {
				foreach ($TagsDiff as $ind => $val) {
					//$TagNum = Tag::where('tag', '=', $this )->first(array('id','tag','bgcolor'));
					$TagNum = Tag::where('tag', '=', $val )->first(array('id','tag','bgcolor'));
					$IssueTagNum = \DB::table('projects_issues_tags')->where('issue_id', '=', $Issue)->where('tag_id', '=', $TagNum->attributes['id'], 'AND' )->first(array('id'));
					$now = date("Y-m-d H:i:s");
					If ($IssueTagNum == NULL) {
						\DB::table('projects_issues_tags')->insert(array('id'=>NULL,'issue_id'=>$Issue,'tag_id'=>$TagNum->attributes['id'],'created_at'=>$now,'updated_at'=>$now) );
					} else {
						\DB::table('projects_issues_tags')->where('issue_id', '=', $Issue)->where('tag_id', '=', $TagNum->attributes['id'], 'AND' )->update(array('updated_at'=>$now) );
					}
				}
				$Action = NULL;
			} else {		//We take a tag off
				$apres = explode("|",$_GET["apres"] );
				foreach ($apres as $ind=>$val) { if (trim($val) == '') { unset($apres[$ind]); } }
				$TagsDiff = array_diff($avant,$apres);
				//foreach ($TagsDiff as $ind => $this) {
				foreach ($TagsDiff as $ind => $val) {
				//	$TagNum = Tag::where('tag', '=', $this )->first(array('id','tag','bgcolor'));
					$TagNum = Tag::where('tag', '=', $val )->first(array('id','tag','bgcolor'));
					$IssueTagNum =\DB::table('projects_issues_tags')
					->where('issue_id','=',$Issue)
					->where('tag_id','=',$TagNum->id,'AND')
					->first('id');
					\DB::table('projects_issues_tags')->delete($IssueTagNum->id);
					$Msg = __('tinyissue.tag_removed');
				}
				$Action = $Issue;
			}
			\User\Activity::add(6, $Action, $Issue, $TagNum->attributes['id'] );

			//Show on screen what did just happened
			$content  = '<div class="insides"><div class="topbar"><div class="data">';
			$content .= '<label style="background-color: '.$TagNum->attributes['bgcolor'].'; padding: 5px 10px; border-radius: 8px;">';
			$content .= $TagNum->attributes['tag'].'</label>';
			$content .= ' : <b>'.$Msg.'</b> ';
			$content .= __('tinyissue.by') . ' ';
			$content .= \Auth::user()->firstname . ' ' . \Auth::user()->lastname;
			$content .= '</div></div></div>';
			$t = time();
			$result = "
			<script>
				var adLi = document.createElement(\"LI\");
				adLi.className = 'comment';
				adLi.id = 'comment".$t."';
				parent.document.getElementById('ul_IssueDiscussion').appendChild(adLi);
				parent.document.getElementById('comment".$t."').innerHTML = '".$content."';
			</script>
			";
		}
		return $result;
	}
}
