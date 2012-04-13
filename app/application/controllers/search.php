<?php

class Search_Controller extends Base_Controller {

	/**
	 * Show general application stats
	 * /administration
	 *
	 * @return View
	 */
	public function get_index()
	{
		return $this->layout->with('active', 'dashboard')->nest('content', 'search.index', array(
		));
	}

	public function post_index()
	{
		return $this->layout->with('active', 'dashboard')->nest('content', 'search.index', array(
		));
	}
}