<?php

class Home_Controller extends Base_Controller {

	public function get_index()
	{
		return $this->layout->with('active', 'dashboard')->nest('content', 'activity.dashboard');
	}
}