<?php

class Project_Controller extends Base_Controller {

	public $layout = 'layouts.project';

	public function __construct()
	{
		parent::__construct();

		$this->filter('before', 'project');
		$this->filter('before', 'permission:project-modify')->only('edit');
	}

	/**
	 * Display activity for a project
	 * /project/(:num)
	 *
	 * @return View
	 */
	public function get_index()
	{
		return $this->layout->nest('content', 'project.index', array(
			'page' => View::make('project/index/activity', array(
				'project' => Project::current(),
				'activity' => Project::current()->activity(10)
			)),
			'active' => 'activity',
			'open_count' => Project::current()->issues()
				 ->where('status', '=', 1)
				 ->count(),
			'closed_count' => Project::current()->issues()
				 ->where('status', '=', 0)
				 ->count(),
			'assigned_count' => Project::current()->count_assigned_issues()
		));
	}

	/**
	 * Display issues for a project
	 * /project/(:num)
	 *
	 * @return View
	 */
	public function get_issues()
	{
		$status = Input::get('status', 1);

		return $this->layout->nest('content', 'project.index', array(
			'page' => View::make('project/index/issues', array(
				'issues' => Project::current()->issues()
				->where('status', '=', $status)
				->order_by('updated_at', 'DESC')
				->get(),
			)),
			'active' => $status == 1 ? 'open' : 'closed',
			'open_count' => Project::current()->issues()
				->where('status', '=', 1)
				->count(),
			'closed_count' => Project::current()->issues()
				->where('status', '=', 0)
				->count(),
			'assigned_count' => Project::current()->count_assigned_issues()
		));
	}

	/**
	 * Display issues assigned to current user for a project
	 * /project/(:num)
	 *
	 * @return View
	 */
	public function get_assigned()
	{
		$status = Input::get('status', 1);

		return $this->layout->nest('content', 'project.index', array(
			'page' => View::make('project/index/issues', array(
				'issues' => Project::current()->issues()
					->where('status', '=', $status)
					->where('assigned_to', '=', Auth::user()->id)
					->order_by('updated_at', 'DESC')
					->get(),
			)),
			'active' => 'assigned',
			'open_count' => Project::current()->issues()
				->where('status', '=', 1)
				->count(),
			'closed_count' => Project::current()->issues()
				->where('status', '=', 0)
				->count(),
			'assigned_count' => Project::current()->count_assigned_issues()
		));
	}

	/**
	 * Edit the project
	 * /project/(:num)/edit
	 *
	 * @return View
	 */
	public function get_edit()
	{
		return $this->layout->nest('content', 'project.edit', array(
			'project' => Project::current()
		));
	}

	public function post_edit()
	{
		/* Delete the project */
		if(Input::get('delete'))
		{
			Project::delete_project(Project::current());

			return Redirect::to('projects')
				->with('notice', __('tinyissue.project_has_been_deleted'));
		}

		/* Update the project */
		$update = Project::update_project(Input::all(), Project::current());

		if($update['success'])
		{
			return Redirect::to(Project::current()->to('edit'))
				->with('notice', __('tinyissue.project_has_been_updated'));
		}

		return Redirect::to(Project::current()->to('edit'))
			->with_errors($update['errors'])
			->with('notice-error', __('tinyissue.we_have_some_errors'));
	}

	public function get_export(){
		return $this->layout->nest('content', 'project.export', array(
			'project' => Project::current()
		));
	}

	public function post_export(){
		$issues = Project::current()->issues; 
		switch (Input::get('format')) {
			case '0':
				$headers = CsvExport::headers(Project::current()->name);
				$content = CsvExport::write_row(array(project::current()->name));
				$content .= CsvExport::write_row(array('Id','Title','Body','Status','Assigned To'));
				foreach ($issues as $key => $issue) {
					$status = $issue->status==1 ? "open" : "closed";
					$name = "";
					if (isset($issue->assigned->firstname)) {
						$name = $issue->assigned->firstname . " " . $issue->assigned->lastname;
					}
					$content .= CsvExport::write_row(array($issue->id,$issue->title,$issue->body,$status,$name));
				}
				return Response::make($content,200,$headers);
				break;
			case '1':
				$headers = XlsExport::headers(Project::current()->name);
				$content = XlsExport::open();
				$content .= XlsExport::write_text(0,0,Project::current()->name);
				$content .= XlsExport::write_text(1,0, 'Id');
				$content .= XlsExport::write_text(1,1,'Title');
				$content .= XlsExport::write_text(1,2,'Body');
				$content .= XlsExport::write_text(1,3,'Status');
				$content .= XlsExport::write_text(1,4,'Assigned To');
				$row = 2;
				foreach ($issues as $key => $issue) {
					$content .= XlsExport::write_text($row,0,$issue->id);
					$content .= XlsExport::write_text($row,1,$issue->title);
					$content .= XlsExport::write_text($row,2,$issue->body);
					$content .= XlsExport::write_text($row,3,$issue->status==1 ? "open" : "closed");
					if (isset($issue->assigned->firstname)) {
						$content .= XlsExport::write_text($row,4,$issue->assigned->firstname . " " . $issue->assigned->lastname);
					}
					$row++;
				}
				$content .= XlsExport::close();
				return Response::make($content,200,$headers);
				break;
			default:
				break;
		} 
	}
}