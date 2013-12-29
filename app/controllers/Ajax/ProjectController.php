<?php namespace Ajax;

use Project\Issue;
use Project\Issue\Attachment;
use Project\User as ProjectUser;

class ProjectController extends \BaseController {

    /**
     * {@inheritdoc}
     */
    protected $layout_name = null;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('permission:project-modify', array('only' => array(
            'inactive_users',
            'add_user',
            'remove_user',
        )));
        $this->beforeFilter('permission:issue-modify', array('only' => array('issue_assign')));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function inactiveUsers()
    {
        /** @var \Project $project */
        $project = \Project::find(\Input::get('project_id'));
        /** @var \User[] $users */
        $users   = is_null($project)? \User::all() : $project->usersNotIn();

        $results = array();
        foreach ($users as $row)
        {
            $results[] = array(
                'id'    => $row->id,
                'label' => $row->firstname . ' ' . $row->lastname
            );
        }

        return \Response::json($results);
    }

    public function addUser()
    {
        ProjectUser::assign(\Input::get('user_id'), \Input::get('project_id'));
    }

    public function removeUser()
    {
        ProjectUser::remove_assign(\Input::get('user_id'), \Input::get('project_id'));
    }

    public function issueAssign()
    {
        Issue::find(\Input::get('issue_id'))->reassign(\Input::get('user_id'));
    }

    public function issueUploadAttachment()
    {
        $user_id = \Crypt::decrypt(str_replace(' ', '+', \Input::get('session')));

        \Auth::login($user_id);

        if ( ! \Auth::user()->project_permission(\Input::get('project_id')))
        {
            return \Response::error('404');
        }

        Attachment::upload(\Input::all());

        return true;
    }

    public function issueRemoveAttachment()
    {
        Attachment::removeAttachment(\Input::all());
    }
}
