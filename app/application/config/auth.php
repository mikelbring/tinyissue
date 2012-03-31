<?php

return array(

	'username' => 'email',

	'user' => function($id)
	{
		if ( ! is_null($id) and filter_var($id, FILTER_VALIDATE_INT) !== false)
		{
			return User::find($id);
		} 
	},

	'attempt' => function($username, $password, $config)
	{
		$user = User::where($config['username'], '=', $username)->first();

		if ( ! is_null($user) and Hash::check($password, $user->password))
		{
			return $user;
		}
	},

	'logout' => function($user) {}

);