<?php

return array(

   /**
    * Create a new issue
    */
   'GET /project/(:num)/issue/new' => array('before' => 'project', function()
   {
      return View::of_project(array('active' => 'projects'))->nest('content', 'project/issue/new', array(
			'project' => Project::current()
		));
   }),

   'POST /project/(:num)/issue/new' => array('before' => 'project|csrf', function()
   {
      $issue = Project\Issue::create(Input::all(), Project::current());

		if(!$issue['success'])
		{
			return Redirect::to(Project::current()->to('issue/new'))
					->with_input()
					->with_errors($issue['errors'])
					->with('notice-error', 'Whoops, we have a few errors.');
		}

      return Redirect::to($issue['issue']->to())
				->with('notice', 'Issue has been created!');
   }),

   /**
    * View Issue
    */
   'GET /project/(:num)/issue/(:num)' => array('before' => 'project|issue', function()
   {
		/* Delete a comment */
		if(Input::get('delete') && Auth::user()->permission('issue-modify'))
		{
			Project\Issue\Comment::delete_comment(str_replace('comment', '', Input::get('delete')));

			return true;
		}

      return View::of_project(array('active' => 'projects'))->nest('content', 'project/issue/index', array(
			'issue' => Project\Issue::current(),
			'project' => Project::current()
		));
   }),

   /*
    * Post a comment to a issue
    */
	'POST /project/(:num)/issue/(:num)' => array('before' => 'project|issue|csrf', function()
	{
      if(!Input::get('comment'))
      {
         return Redirect::to(Project\Issue::current()->to() . '#new-comment')
                ->with('notice-error', 'You did not put in a comment!');
      }

		$comment = \Project\Issue\Comment::create(Input::all(), Project::current(), Project\Issue::current());

		return Redirect::to(Project\Issue::current()->to() . '#comment' . $comment->id)
            ->with('notice', 'Your comment has been added!');
	}),

	'POST /project/(:num)/issue/(:num)/edit-comment' => array('before' => 'permission:issue-modify|project|issue', function()
	{
		if(Input::get('body'))
		{
			$comment = Project\Issue\Comment::find(str_replace('comment', '', Input::get('id')))
					->fill(array('comment' => Input::get('body')))
					->save();

			return nl2br(stripslashes(Input::get('body')));
		}
	}),

	/**
	 * Delete a comment from an issue
	 */
	'GET /project/(:num)/issue/(:num)/delete-comment/(:num)' => array('before' => 'permission:issue-modify|project|issue', function($project, $issue, $comment)
	{
		if(Auth::user()->permission('issue-modify'))
		{
			Project\Issue\Comment::delete_comment($comment);

			return Redirect::to(Project\Issue::current()->to())
					->with('notice', "Comment Deleted");
		}
		else
		{
			return Redirect::to(Project\Issue::current()->to())
					->with('notice', "You do not have permission to delete comments");
		}

	}),

   /**
    * Change the status of a issue
    */
   'GET /project/(:num)/issue/(:num)/status/(:num)' => array('before' => 'permission:issue-modify|project|issue', function($project, $issue, $status)
   {
      if($status == 0)
      {
         $message = 'This issue has been closed. It is now read-only.';
      }
      else
      {
         $message = 'This issue has been reopened. You can now work the issue.';
      }

      Project\Issue::current()->change_status($status);

      return Redirect::to(Project\Issue::current()->to())
            ->with('notice', $message);

   })
);