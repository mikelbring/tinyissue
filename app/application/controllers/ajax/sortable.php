<?php

class Ajax_Sortable_Controller extends Base_Controller {

	public $layout = null;

	public function __construct()
	{
		parent::__construct();
	}

	public function post_project_issue()
	{
		$this->filter('before', 'permission:project-modify')->only(array(
			'inactive_users',
			'add_user',
			'remove_user',
		));
    
    $issues = Input::get('weights');
    foreach ($issues as $index => $id) 
    {
      $issue = Project\Issue::load_issue($id);
      $issue->weight = $index;
      Project\Issue::update_issue($issue);
    }
	}
}
