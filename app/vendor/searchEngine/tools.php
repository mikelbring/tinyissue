<?php
class tools {
	public $config;
	function __construct() {
		$this->config = require '../config.app.php';
		if (file_exists('./mysql-structure.php')) { $this->mysql_structure = require './mysql-structure.php'; 
			$this->language = require '../app/application/language/'.$_GET["Lng"].'/install.php';
		}

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

	public function requis($query) {
		return mysqli_query($GLOBALS["___mysqli_ston"], $query);
	}

	public function fetche($resu) {
	}

	public function explose($query) {
	}

	private function check_db($connect) {
		@$database_connect = ((bool)mysqli_query( $connect, "USE " . $this->config['database']['database']));
		if($database_connect) {
			return $database_connect;
		}

		return false;
	}
}
