<?php

class Ajax_Sortable_Controller extends Base_Controller {

	public $layout = null;

	public function __construct()
	{
		parent::__construct();
    
		$this->filter('before', 'permission:issue-modify')->only(array(
			'issue_assign'
		));
	}

	public function post_project_issue()
	{
    $issues = Input::get('weights');
    foreach ($issues as $index => $id) 
    {
      $issue = Project\Issue::load_issue($id);
      $issue->weight = $index;
      $issue->save();
    }
    
		return json_encode($issues);
    
	}
}