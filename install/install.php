<?php

class install
{
	protected $config;
	protected $connect;
	public $error;

	function __construct()
	{
		$this->config = require '../config.app.php';
		$this->mysql_structure = require './mysql-structure.php';

		$this->check_connect();
	}

	public function check_connect()
	{

		if(!$this->connect)
		{
			try {
				$this->connect = mysqli_connect($this->config['database']['host'],$this->config['database']['username'],$this->config['database']['password'], $this->config['database']['database']);
			} catch(Exception $e) {
				echo $this->error = 'Could not connect to database';
			}
		}

		return $this;
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
			$errors[] = 'PHP too old for Tiny Issue. PHP 5.3.0 or above is needed.';
		}

		return $errors;	
	}

	public function create_tables()
	{
		foreach($this->mysql_structure as $query)
		{
			$stmt = $this->connect->prepare($query);
			$stmt->execute();
		}

		/* Create Administrator Account */
		$role = 4;
		$email = $_POST['email'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$password = Laravel\Hash::make($_POST['password']);

		/* Check if email exists if so change the password on it */
		$stmt = $this->connect->prepare("SELECT * FROM users WHERE email = ? AND deleted = 0");
		$stmt->bind_param("s", $email);

		$stmt->execute();
		$stmt->store_result();

		if($stmt->num_rows >= 1)
		{
			$query = $this->connect->prepare("UPDATE `users` SET password = ?, firstname = ?, lastname = ? WHERE email = ? AND deleted = 0 LIMIT 1");
			$query->bind_param('s', $password);
			$query->bind_param('s', $first_name);
			$query->bind_param('s', $last_name);
			$query->bind_param('s', $email);
		}
		else
		{
			$query = $this->connect->prepare("INSERT INTO users(role_id, email, password, firstname, lastname, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
			$query->bind_param('issss', $role, $email, $password, $first_name, $last_name);

		}

		$query->execute();

		return true;
	}

}
