<?php

class install
{
	public $config;

	function __construct() {
		$this->config = require '../config.app.php';
		$this->mysql_structure = require './mysql-structure.php';
		$this->language = require '../app/application/language/'.$_GET["Lng"].'/install.php';

	}

	public function check_connect() {
		@$connect = ($GLOBALS["___mysqli_ston"] = mysqli_connect($this->config['database']['host'], $this->config['database']['username'], $this->config['database']['password']));

		if(!$connect) { return array('error' => '<strong>'.$this->language['Database_Connect_Error'].'.</strong>!'); 	}
		$check_db = $this->check_db($connect);
		if(!$check_db) { return array('error' => '<strong>'.$this->language['Database_Error'].'.</strong>'); 		}

		return $check_db;
	}

	public function check_requirements() {
		$errors = array();

		if(!extension_loaded('pdo')) { 		$errors[] = 'pdo extension not found.'; }
		if(!extension_loaded('pdo_mysql')) { 	$errors[] = 'mysql driver for pdo not found .'; }
		if(version_compare(PHP_VERSION, '7.1', '<') && !extension_loaded('mcrypt')) { 		$errors[] = 'mcrypt extension not found.'; }
		if(version_compare(PHP_VERSION, '7.0', '>') && !extension_loaded('openSSL')) { 		$errors[] = 'openSSL extension not found.'; }
		if(version_compare(PHP_VERSION, '5.3.0', '<')) { 	$errors[] = 'PHP too old for Bugs. PHP 5.3.0 or above is needed.'; }

		return $errors;
	}

	public function create_database() {
			mysqli_query($GLOBALS["___mysqli_ston"], "CREATE DATABASE IF NOT EXISTS ".$_POST["database_name"]);
			echo ($GLOBALS["___mysqli_ston"]->error == '')  ? '<p style="color:#090;font-size: 150%;background-color: #FFF; text-align:center; width: 75%; position: absolute; top: 0; left: 15%;">'.$this->language['Database_CreateDatabase_success'].$_POST["database_name"].'</p>' : '<p style="color:#F00;font-size: 150%;background-color: #FFF; text-align:center; width: 75%; position: absolute; top: 0; left: 15%;">'.$this->language['Database_CreateDatabase_failed'].'</p>';
	}

	public function create_tables() {
		foreach($this->mysql_structure as $query) {
			mysqli_query($GLOBALS["___mysqli_ston"], $query);
		}
		/* Create Administrator Account */
		$role = 4;
		$email = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['email']) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
		$first_name = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['first_name']) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
		$last_name = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['last_name']) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
		$email = (trim($email) == '' ) ? $_POST["email"] : $email;
		$first_name = (trim($first_name) == '' ) ? $_POST["first_name"] : $first_name;
		$last_name = (trim($last_name) == '' ) ? $_POST["last_name"] : $last_name;
		$password = Laravel\Hash::make($_POST['password']);
		$language = $_POST['language'];
		/* Check if email exists if so change the password on it */
		$test_query = "select * from users where email = '".$email."' and deleted = 0 LIMIT 1";
		$test_result = mysqli_query($GLOBALS["___mysqli_ston"], $test_query);

		if(mysqli_num_rows($test_result) >= 1) {
			$query = "
			UPDATE `users`
			SET
				password = '{$password}',
				firstname = '{$first_name}',
				lastname = '{$last_name}'
			WHERE email = '{$email}' AND deleted = 0
			LIMIT 1
			";
		} else {
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
				'$language',
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
