<?php

class install
{
	public $config;

	function __construct()
	{
		$this->config = require '../config.app.php';
		$this->mssql_structure = require './mssql-structure.php';

	}

	public function check_connect()
	{
		$conn_info = array(
						"Database" => $this->config['sqlsrv']['database'],
						"UID" => $this->config['sqlsrv']['username'],
						"PWD" => $this->config['sqlsrv']['password'] );
		$connect = sqlsrv_connect($this->config['sqlsrv']['host'], $conn_info);
		
		if(!$connect)
		{
			die( print_r( sqlsrv_errors(), true));
			return array('error' => '<strong>Database Connect Error.</strong>!');
		}

		/*$check_db = $this->check_db($connect);
		
		if(!$check_db)
		{
			 return array('error' => '<strong>Database Error.</strong>');
		}*/

		//return $check_db;
		return;
	}

	public function check_requirements()
	{
		$errors = array();

		if(!extension_loaded('pdo'))
		{
			$errors[] = 'pdo extension not found.';
		}

		if(!extension_loaded('pdo_sqlsrv'))
		{
			$errors[] = 'MSSQL driver for pdo not found .';
		}

		if(!extension_loaded('mcrypt'))
		{
			$errors[] = 'mcrypt extension not found.';
		}

		if(version_compare(PHP_VERSION, '5.3.0', '<'))
		{
			$errors[] = 'PHP too old for Tiny Issue. PHP 5.3.0 or above is needed.';
		}

		return $errors;	
	}

	public function create_tables()
	{
		$conn_info = array(
						"Database" => $this->config['sqlsrv']['database'],
						"UID" => $this->config['sqlsrv']['username'],
						"PWD" => $this->config['sqlsrv']['password'] );
		$connect = sqlsrv_connect($this->config['sqlsrv']['host'], $conn_info);
		
		foreach($this->mssql_structure as $query)
		{
			sqlsrv_query($connect, $query);
		}

		/* Create Administrator Account */
		$role = 4;
		/*$email = mysql_real_escape_string($_POST['email']);
		$first_name = mysql_real_escape_string($_POST['first_name']);
		$last_name = mysql_real_escape_string($_POST['last_name']);*/
		$email = $_POST['email'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$password = Laravel\Hash::make($_POST['password']);

		/* Check if email exists if so change the password on it */
		$test_query = "select * from users where email = '$email' and deleted = 0 LIMIT 1";
		$test_result = sqlsrv_query($connect, $test_query);

		if($test_result)
		{
			$query = "
			UPDATE users
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
			INSERT INTO users (
				role_id,
				email,
				password,
				firstname,
				lastname,
				created_at
			) VALUES (
				'$role',
				'$email',
				'$password',
				'$first_name',
				'$last_name',
				CURRENT_TIMESTAMP
			)";

		}
		
		sqlsrv_query($connect, $query) or die(print_r(sqlsrv_errors()));

		return true;
	}

	private function check_db($connect)
	{
		$database_connect = sqlsrv_select_db($this->config['sqlsrv']['database'], $connect);

		if($database_connect)
		{
			return $database_connect;
		}

		return false;
	}
}
