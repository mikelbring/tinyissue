<?php

class Projects_Controller extends Base_Controller {

	public function get_index() {
		$status = Input::get('status', 1);
		$projects_active = Project\User::active_projects(true);
		$projects_inactive = Project\User::inactive_projects(true);

		return $this->layout->with('active', 'projects')->nest('content', 'projects.index', array(
			'projects' => $status == 1 ? $projects_active : $projects_inactive,
			'active' => $status == 1 ? 'active' : 'archived',
			'active_count' => (int) count($projects_active),
			'archived_count' => (int) count($projects_inactive)
		));
	}

	public function get_new() {
		Asset::script('project-new', '/app/assets/js/project-new.js', array('app'));

		return $this->layout->with('active', 'projects')->nest('content', 'projects.new');
	}

	public function get_reports($RapProduit = '') {
//		return $this->layout->with('active', 'projects')->nest('content', 'projects.reports');
		$status = Input::get('status', 1);
		$projects_active = Project\User::active_projects(true);
		$projects_inactive = Project\User::inactive_projects(true);
		$tags = \DB::table('tags')->get();
		$users = \DB::table('users')->get();
		$issues_active = \DB::table('projects_issues')->whereNull('closed_at')->get();
		$issues_inactive = \DB::table('projects_issues')->whereNotNull('closed_at')->get();

		return $this->layout->with('active', 'projects')->nest('content', 'projects.reports', array(
			'projects_active' =>  (int) count($projects_active),
			'projects_inactive' =>  (int) count($projects_inactive),
			'projects_total' =>  (int) count($projects_active) + count($projects_inactive),
			'tags' => (int) count($tags),  	
			'users' => $users,
			'issues_active' =>  (int) count($issues_active),
			'issues_inactive' =>  (int) count($issues_inactive),
			'issues_total' =>  (int) count($issues_active) + count($issues_inactive),
			'Rapport_Prod' => $RapProduit
		));

	}

	public function post_reports() {
		require_once("../app/application/libraries/fpdf/fpdf.php");
		$pdf = new FPDF("P", "mm", "Letter", true, 'UTF-8', false);
		$pdf->SetMargins(10, 1, 10);
		$pdf->SetAuthor("Patrick Allaire, ptre", true);
		$pdf->SetCreator('Voici une Info à venir', true);
		$pdf->SetTitle("BUGS report", true);
		$pdf->SetSubject("Voici une info à venir");
		$pdf->SetKeywords('BUGS tickets report rapport');
		$pdf->SetFont("Times", "", 12);
		$pdf->SetTextColor(0,0,0);
		include ("../app/application/models/reports/index.php");

		$pdf->output("../app/storage/reports/".$_POST["RapType"]."_".date("YmdHis").".pdf", "F");
		return $this->get_reports("../app/storage/reports/".$_POST["RapType"]."_".date("YmdHis").".pdf");
	}

	public function post_new() {
		$create = Project::create_project(Input::all());

		if($create['success']) {
			return Redirect::to($create['project']->to());
		}

		return Redirect::to('projects/new')
			->with_errors($create['errors'])
			->with('notice-error', __('tinyissue.we_have_some_errors'));
	}
	
	private function frontPage() {
	}

}