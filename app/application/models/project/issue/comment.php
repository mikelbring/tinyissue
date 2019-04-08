<?php namespace Project\Issue;

class Comment extends  \Eloquent {

	public static $table = 'projects_issues_comments';
	public static $timestamps = true;

	/**
	 * @return \User
	 */
	public function user()
	{
		return $this->belongs_to('\User', 'created_by');
	}


	public function attachments()
	{
		return $this->has_many('Project\Issue\Attachment', 'comment_id');
	}


	/**
	 * Create a new comment
	 *
	 * @param  array           $input
	 * @param  \Project        $project
	 * @param  \Project\Issue  $issue
	 * @return Comment
	 */
	public static function create_comment($input, $project, $issue)
	{
		$config_app = require path('public') . 'config.app.php';
		if (!isset($config_app['Percent'])) { $config_app['Percent'] = array (100,0,10,80,100); }
		require "tag.php";
		$fill = array(
			'created_by' => \Auth::user()->id,
			'project_id' => $project->id,
			'issue_id' => $issue->id,
			'comment' => $input['comment'],
		);

		$comment = new static;
		$comment->fill($fill);
		$comment->save();

		/* Add to user's activity log */
		\User\Activity::add(2, $project->id, $issue->id, $comment->id);
		$vide = true;
		$Val = ($input['Pourcentage'] > $config_app['Percent'][3]) ? 8: (($input['Pourcentage'] == 100 ) ? 2: 9);
		if(!empty($issue->tags)):
			foreach($issue->tags()->order_by('tag', 'ASC')->get() as $tag):
				if ($Val == $tag->id) { $vide = false; }
			endforeach;
		endif;
		if ($vide) { Tag::addNew_tags($issue->id, $Val); }

		/* Add attachments to issue */
		\DB::table('projects_issues_attachments')->where('upload_token', '=', $input['token'])->where('uploaded_by', '=', \Auth::user()->id)->update(array('issue_id' => $issue->id, 'comment_id' => $comment->id));

		/* Update the Todo state for this issue  */
		//\DB::table('users_todos')->where('issue_id', '=', $issue->id)->update(array('user_id' => \Auth::user()->id, 'status' => (($input['Pourcentage'] > $config_app['Percent'][3]) ? 3: 2), 'weight' => $input['Pourcentage'], 'updated_at'=>date("Y-m-d H:m:s")));
		\DB::table('users_todos')->where('issue_id', '=', $issue->id)->update(array('status' => (($input['Pourcentage'] > $config_app['Percent'][3]) ? 3: 2), 'weight' => $input['Pourcentage'], 'updated_at'=>date("Y-m-d H:m:s")));

		/* Update the status of this issue according to its percentage done;  */
		\DB::table('projects_issues')->where('id', '=', $issue->id)->update(array('closed_by' => (($input['Pourcentage'] == 100 ) ? \Auth::user()->id : NULL), 'status' => (($input['Pourcentage'] == 100 )? 0 : $issue->status)));

		/*Update tags attached to this issue */
		$MesTags = explode(",", $input["MesTags"]);
		$IDtags = array();
		foreach($MesTags as $val) {
			foreach(\Tag::where('tag', '=', $val)->get("id","tag") as $activity) {
				$Idtags[] =  $activity->id;
			}
		}
		if (isset($Idtags)) {
		$issue->tags()->sync($Idtags);
		$issue->save();
		}

		/* Update the project */
		$issue->updated_at = date('Y-m-d H:i:s');
		$issue->updated_by = \Auth::user()->id;
		$issue->save();
		if ($input['Pourcentage'] == 100 ) {
			$tags = $issue->tags;
			$tag_ids = array();
			foreach($tags as $tag) { $tag_ids[$tag->id] = $tag->id; }
			$issue->closed_by = \Auth::user()->id;
			$issue->closed_at = date('Y-m-d H:i:s');

			/* Update tags */
			$tag_ids[2] = 2;
			if(isset($tag_ids[1])) { unset($tag_ids[1]); }
			if(isset($tag_ids[8])) { unset($tag_ids[8]); }
			if(isset($tag_ids[9])) { unset($tag_ids[9]); }

			/* Add to activity log */
			\User\Activity::add(3, $issue->project_id, $issue->id);
			$issue->tags()->sync($tag_ids);
			$issue->status = 0;
			$issue->save();
		}

		/*Notifications by email to those who concern */
		$project = \Project::current();
		$subject = sprintf(__('email.new_comment'), $issue->title, $project->name);
		$text = \View::make('email.commented_issue', array(
				'actor' => \Auth::user()->firstname . ' ' . \Auth::user()->lastname,
				'project' => $project,
				'issue' => $issue,
				'comment' => $comment->comment
			));

		/* Notify the person to whom the issue is currently assigned, unless that person is the one making the comment */
		if($issue->assigned_to && $issue->assigned_to != \Auth::user()->id && (!empty($issue->assigned->email))) {
 			\Mail::send_email($text, $issue->assigned->email, $subject);
		}

		/* Notify the person who created the issue, unless that person is the one making the comment */
		if($issue->created_by && $issue->created_by != \Auth::user()->id  && (!empty($issue->user->email))) {
			\Mail::send_email($text, $issue->user->email, $subject);
		}

		return $comment;
	}


	/**
	 * Delete a comment and its attachments
	 *
	 * @param int    $comment
	 * @return bool
	 */
	public static function delete_comment($comment)
	{
		\User\Activity::where('action_id', '=', $comment)->delete();

		$comment = static::find($comment);

		if(!$comment)
		{
			return false;
		}

		$issue = \Project\Issue::find($comment->issue_id);

		/* Delete attachments and files */
		$path = \Config::get('application.upload_path') . $issue->project_id;

		foreach($comment->attachments()->get() as $row)
		{
			Attachment::delete_file($path . '/' . $row->upload_token, $row->filename);

			$row->delete();
		}

		$comment->delete();

		return true;
	}


	/**
	 * Modify $body format for displaying
	 *
	 * @param  string  $body
	 * @return string
	 */
	public static function format($body)
	{
		$body = \Sparkdown\Markdown($body);
		// convert issue numbers into issue url
		return preg_replace('/((?:' . __('tinyissue.issue') . ')?)(\s*)#(\d+)/i', '<a href="' . \URL::to('/project/0/issue/$3') . '" title="$1 #$3" class="issue-link">$1 #$3</a>', $body);
	}


}
