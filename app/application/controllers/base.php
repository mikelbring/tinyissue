<?php

class Base_Controller extends Controller {

	/**
	 * @var View
	 */
	public $layout = 'layouts.wrapper';

	/**
	 * @var bool
	 */
	public $restful = true;

	public function __construct()
	{
		parent::__construct();

		$public_projects = Project::public_projects();

                $project = '/project\/[0-9]+$/';
                $issues = '/project\/[0-9]+\/issues?(\/[0-9]+)?$/';
                if(Request::uri() !== 'ajax/project/issue_upload_attachment' &&
		   (count($public_projects) == 0 ||
                    (Request::uri() !== 'projects' &&
                     ! preg_match($project, Request::uri()) &&
                     ! preg_match($issues, Request::uri()))))
		{
			$this->filter('before', 'auth');
		}

	}

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}


}
