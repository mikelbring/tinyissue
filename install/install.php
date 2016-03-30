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
		@$connect = ($GLOBALS["___mysqli_ston"] = mysqli_connect($this->config['database']['host'], $this->config['database']['username'], $this->config['database']['password']));

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

		if(version_compare(PHP_VERSION, '5.3.0', '<'))
		{
			$errors[] = 'PHP too old for Bugs. PHP 5.3.0 or above is needed.';
		}

		return $errors;	
	}

	public function create_tables()
	{
		foreach($this->mysql_structure as $query)
		{
			mysqli_query($GLOBALS["___mysqli_ston"], $query);
		}

		/* Create Administrator Account */
		$role = 4;
		$email = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['email']) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
		$first_name = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['first_name']) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
		$last_name = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['last_name']) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
		$password = Laravel\Hash::make($_POST['password']);

		/* Check if email exists if so change the password on it */
		$test_query = "select * from users where email = '$email' and deleted = 0 LIMIT 1";
		$test_result = mysqli_query($GLOBALS["___mysqli_ston"], $test_query);

		if(mysqli_num_rows($test_result) >= 1)
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
				language,
				created_at
			)VALUES(
				'$role',
				'$email',
				'$password',
				'$first_name',
				'$last_name',
				'en',
				now()
			)";

		}

		mysqli_query($GLOBALS["___mysqli_ston"], $query);

		return true;
	}

	private function check_db($connect)
	{
		@$database_connect = ((bool)mysqli_query( $connect, "USE " . $this->config['database']['database']));

		if($database_connect)
		{
			return $database_connect;
		}

		return false;
	}
}
