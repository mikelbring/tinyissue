<?php namespace Project\Issue;

class Comment extends  \Eloquent {

	public static $table = 'projects_issues_comments';
	public static $timestamps = true;

	/**
	 * @return User
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
		$query = '
			UPDATE `projects_issues_attachments`
			SET issue_id = ?, comment_id = ?
			WHERE upload_token = ? AND uploaded_by = ?';

		\DB::query($query, array($issue->id, $comment->id, $input['token'], \Auth::user()->id));

		/* Update the project */
		$issue->updated_at = \DB::raw('NOW()');
		$issue->updated_by = \Auth::user()->id;
		$issue->save();

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
		/* Autolink URLs */
		$body = preg_replace('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', '<a href="$1" target="_blank">$1</a>', $body);

		return nl2br(stripslashes($body));
	}
}