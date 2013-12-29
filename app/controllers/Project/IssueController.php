<?php namespace Project;

use Project\Issue;
use Project\Issue\Comment;

class IssueController extends \BaseController {

    /**
     * {@inheritdoc}
     */
    protected $layout_name = 'layouts.project';

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('project');
        $this->beforeFilter('issue', array(
            'except' => 'create'
        ));
        $this->beforeFilter('permission:issue-modify', array(
            'only' => array('edit_comment', 'delete_comment', 'status', 'edit')
        ));
    }

    /**
     * Create a new issue
     * /project/{project_id}/issue/new
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (\Request::isMethod('POST'))
        {
            $issue = Issue::createIssue(\Input::all(), \Project::current());

            if ( ! $issue['success'])
            {
                return \Redirect::to(\Project::current()->to('issue/new'))
                    ->with_input()
                    ->with_errors($issue['errors'])
                    ->with('notice-error', trans('tinyissue.we_have_some_errors'));
            }

            return \Redirect::to($issue['issue']->to())
                ->with('notice', trans('tinyissue.issue_has_been_created'));
        }

        $this->setupLayout();

        return $this->layout->nest('content', 'project.issue.new', array(
            'project' => \Project::current()
        ));
    }

    /**
     * View or create an issue.
     * /project/{project_id}/issue/{issue_id}
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (\Request::isMethod('POST'))
        {
            if ( ! \Input::get('comment'))
            {
                return \Redirect::to(Issue::current()->to() . '#new-comment')
                    ->with('notice-error', trans('tinyissue.you_put_no_comment'));
            }

            $comment = Comment::createComment(\Input::all(), \Project::current(), Issue::current());

            return \Redirect::to(Issue::current()->to() . '#comment' . $comment->id)
                ->with('notice', trans('tinyissue.your_comment_added'));
        }

        // Delete a comment
        if (\Input::get('delete') && \Auth::user()->permission('issue-modify'))
        {
            Comment::deleteComment((int) str_replace('comment', '', \Input::get('delete')));

            return true;
        }

        $this->setupLayout();

        return $this->layout->nest('content', 'project.issue.index', array(
            'issue'   => Issue::current(),
            'project' => \Project::current()
        ));
    }

    /**
     * Edit a issue.
     * /project/{project_id}/issue/{issue_id}/edit
     *
     * @return \Illuminate\View\View|\Illuminate\Routing\Redirector
     */
    public function edit()
    {
        if (\Request::isMethod('POST'))
        {
            $update = Issue::current()->updateIssue(\Input::all());

            if ( ! $update['success'])
            {
                return \Redirect::to(Issue::current()->to('edit'))
                    ->withInput()
                    ->withErrors($update['errors'])
                    ->with('notice-error', trans('tinyissue.we_have_some_errors'));
            }

            return \Redirect::to(Issue::current()->to())
                ->with('notice', trans('tinyissue.issue_has_been_updated'));
        }

        return $this->layout->nest('content', 'project.issue.edit', array(
            'issue'   => Issue::current(),
            'project' => \Project::current()
        ));
    }

    /**
     * Update / Edit a comment.
     * /project/{project_id}/issue/{issue_id}/edit_comment
     *
     * @request ajax
     * @return string|null
     */
    public function edit_comment()
    {
        if (\Input::get('body'))
        {
            Comment::find((int) str_replace('comment', '', \Input::get('id')))
                ->fill(array('comment' => \Input::get('body')))
                ->save();

            return Comment::format(\Input::get('body'));
        }
    }

    /**
     * Delete a comment.
     * /project/{project_id}/issue/{issue_id}/delete_comment
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function delete_comment()
    {
        Comment::deleteComment(\Input::get('comment'));

        return \Redirect::to(Issue::current()->to())->with('notice', trans('tinyissue.comment_deleted'));
    }

    /**
     * Change the status of a issue.
     * /project/{project_id}/issue/{issue_id}/status
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function status()
    {
        $status  = \Input::get('status', 0);
        $message = trans(sprintf('tinyissue.%s', ($status == 0) ? 'issue_has_been_closed' : 'issue_has_been_reopened'));

        Issue::current()->changeStatus($status);

        return \Redirect::to(Issue::current()->to())->with('notice', $message);
    }
}
