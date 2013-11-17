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

		$pattern = '/project\/[0-9]+$/';
		if(Request::uri() !== 'ajax/project/issue_upload_attachment' &&
		   Request::uri() !== 'projects' &&
		   ! preg_match($pattern, Request::uri()))
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
