<?php

class AdminController extends BaseController {

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('permission:administration');
    }

    /**
     * Show general application stats.
     * /administration
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return $this->layout->with('active', 'dashboard')->nest('content', 'administration.index', array(
            'users'             => User::where('deleted', '=', 0)->count(),
            'active_projects'   => Project::where('status', '=', 1)->count(),
            'archived_projects' => Project::where('status', '=', 0)->count(),
            'issues'            => Project\Issue::countIssues(),
        ));
    }
}
