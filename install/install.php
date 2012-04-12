<?php

class install
{
	public $config;

	function __construct()
	{
		$this->config = require '../config.app.php';
		$this->mysql_structure = require './mysql-structure.php';

	}

	public function check_connect()
	{
		@$connect = mysql_connect($this->config['mysql']['host'],$this->config['mysql']['username'],$this->config['mysql']['password']);

		if(!$connect)
		{
			return array('error' => '<strong>Database Connect Error.</strong>!');
		}

		$check_db = $this->check_db($connect);

		if(!$check_db)
		{
			 return array('error' => '<strong>Database Error.</strong>');
		}

		return $check_db;
	}

	public function check_requirements()
	{
		$errors = array();

		if(!extension_loaded('pdo'))
		{
			$errors[] = 'pdo extension not found.';
		}

		if(!extension_loaded('pdo_mysql'))
		{
			$errors[] = 'mysql driver for pdo not found .';
		}

		if(!extension_loaded('mcrypt'))
		{
			$errors[] = 'mcrypt extension not found.';
		}

		return $errors;	
	}

	public function create_tables()
	{
		foreach($this->mysql_structure as $query)
		{
			mysql_query($query);
		}

		/* Create Administrator Account */
		$role = 4;
		$email = mysql_real_escape_string($_POST['email']);
		$first_name = mysql_real_escape_string($_POST['first_name']);
		$last_name = mysql_real_escape_string($_POST['last_name']);
		$password = Laravel\Hash::make($_POST['password']);

		/* Check if email exists if so change the password on it */
		$test_query = "select * from users where email = '$email' and deleted = 0 LIMIT 1";
		$test_result = mysql_query($test_query);

		if(mysql_num_rows($test_result) >= 1)
		{
			$query = "
			UPDATE `users`
			SET
				password = '{$password}',
				firstname = '{$first_name}',
				lastname = '{$last_name}'
			WHERE email = '{$email}' AND deleted = 0
			LIMIT 1
			";
		}
		else
		{
			$query = "
			INSERT INTO users(
				role_id,
				email,
				password,
				firstname,
				lastname,
				created_at
			)VALUES(
				'$role',
				'$email',
				'$password',
				'$first_name',
				'$last_name',
			now()
			)";

		}

		mysql_query($query);

		return true;
	}

	private function check_db($connect)
	{
		@$database_connect = mysql_select_db($this->config['mysql']['database'], $connect);

		if($database_connect)
		{
			return $database_connect;
		}

		return false;
	}
}