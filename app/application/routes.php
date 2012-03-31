<?php

return array(

	'GET /' => function()
	{
		return View::of_wrapper(array('active' => 'dashboard'))->nest('content', 'activity/dashboard');
	}
);