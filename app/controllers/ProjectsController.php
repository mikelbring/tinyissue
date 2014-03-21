<?php

class ProjectsController extends BaseController {

    /**
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $status = Input::get('status', 1);
        $projects_active = Project\User::activeProjects(Auth::user(), true);
        $projects_inactive = Project\User::inactiveProjects(Auth::user(), true);

        return $this->layout->with('active', 'projects')->nest('content', 'projects.index', array(
            'projects'       => ($status == 1)? $projects_active : $projects_inactive,
            'active'         => ($status == 1)? 'active' : 'archived',
            'active_count'   => count($projects_active),
            'archived_count' => count($projects_inactive)
        ));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getNew()
    {
        return $this->layout
            ->with('scripts', array('/assets/js/project-new.js'))
            ->with('active',  'projects')
            ->nest('content', 'projects.new');
    }

    /**
     * @return \Illuminate\Routing\Redirector
     */
    public function postNew()
    {
        $create = Project::createProject(Input::all());

        if ($create['success'])
        {
            return Redirect::to($create['project']->to());
        }

        return Redirect::to('projects/new')
            ->withErrors($create['errors'])
            ->with('notice-error', trans('tinyissue.we_have_some_errors'));
    }
}
