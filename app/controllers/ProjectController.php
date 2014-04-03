<?php

class ProjectController extends BaseController {

    /**
     * @var string
     */
    protected $layout_name = 'layouts.project';

    /**
     * Instantiate a new ProjectController instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('project');
        $this->beforeFilter('permission:project-modify', array('only' => array('edit')));
    }

    /**
     * Display activity for a project
     * /project/{id}
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->setupLayout();

        return $this->layout->nest('content', 'project.index', array(
            'page' => View::make('project/index/activity', array(
                'project'  => Project::current(),
                'activity' => Project::current()->activity(10)
            )),
            'active'         => 'activity',
            'open_count'     => Project::current()->issues()->where('status', '=', 1)->count(),
            'closed_count'   => Project::current()->issues()->where('status', '=', 0)->count(),
            'assigned_count' => Project::current()->countAssignedIssues()
        ));
    }

    /**
     * Display issues for a project.
     * /project/{project_id}/issues
     *
     * @return \Illuminate\View\View
     */
    public function issues()
    {
        $status = Input::get('status', 1);

        return $this->layout->nest('content', 'project.index', array(
            'page' => View::make('project/index/issues', array(
                'issues' => Project::current()->issues()
                    ->where('status', '=', $status)
                    ->orderBy('updated_at', 'DESC')
                    ->get(),
            )),
            'active'         => $status == 1 ? 'open' : 'closed',
            'open_count'     => Project::current()->issues()->where('status', '=', 1)->count(),
            'closed_count'   => Project::current()->issues()->where('status', '=', 0)->count(),
            'assigned_count' => Project::current()->countAssignedIssues()
        ));
    }

    /**
     * Display issues assigned to current user for a project
     * /project/{project_id}/assigned
     *
     * @return \Illuminate\View\View
     */
    public function assigned()
    {
        $status = Input::get('status', 1);

        return $this->layout->nest('content', 'project.index', array(
            'page' => View::make('project/index/issues', array(
                'issues' => Project::current()->issues()
                    ->where('status', '=', $status)
                    ->where('assigned_to', '=', Auth::user()->id)
                    ->orderBy('updated_at', 'DESC')
                    ->get(),
            )),
            'active'         => 'assigned',
            'open_count'     => Project::current()->issues()->where('status', '=', 1)->count(),
            'closed_count'   => Project::current()->issues()->where('status', '=', 0)->count(),
            'assigned_count' => Project::current()->countAssignedIssues()
        ));
    }

    /**
     * Edit the project
     * /project/(:num)/edit
     *
     * @return \Illuminate\View\View
     */
    public function getEdit()
    {
        return $this->layout->nest('content', 'project.edit', array(
            'project' => Project::current()
        ));
    }

    public function postEdit()
    {
        /* Delete the project */
        if (Input::get('delete'))
        {
            Project::delete_project(Project::current());

            return Redirect::to('projects')
                ->with('notice', __('tinyissue.project_has_been_deleted'));
        }

        /* Update the project */
        $update = Project::update_project(Input::all(), Project::current());

        if ($update['success'])
        {
            return Redirect::to(Project::current()->to('edit'))
                ->with('notice', __('tinyissue.project_has_been_updated'));
        }

        return Redirect::to(Project::current()->to('edit'))
            ->with_errors($update['errors'])
            ->with('notice-error', __('tinyissue.we_have_some_errors'));
    }
}