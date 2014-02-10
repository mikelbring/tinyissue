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


		/* Add attachments to issue */
		\DB::table('projects_issues_attachments')->where('upload_token', '=', $input['token'])->where('uploaded_by', '=', \Auth::user()->id)->update(array('issue_id' => $issue->id, 'comment_id' => $comment->id));

		/* Update the project */
		$issue->updated_at = date('Y-m-d H:i:s');
		$issue->updated_by = \Auth::user()->id;
		$issue->save();
		
		/* Notify the person to whom the issue is currently assigned, unless that person is the one making the comment */
		if($issue->assigned_to && $issue->assigned_to != \Auth::user()->id)
		{
			$project = \Project::current();
			
			$subject = 'Issue "' . $issue->title . '" in "' . $project->name . '" project has a new comment';
			$text = \View::make('email.commented_issue', array(
				'actor' => \Auth::user()->firstname . ' ' . \Auth::user()->lastname,
				'project' => $project,
				'issue' => $issue,
			));

			\Mail::send_email($text, $issue->assigned->email, $subject);
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
		return \Sparkdown\Markdown($body);
	}
}
