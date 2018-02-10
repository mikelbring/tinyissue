<?php namespace Laravel; defined('DS') or die('No direct script access.');
	include_once (phpversion() < 7.1) ? "crypterMcrypt.php" : "crypterSSL.php";

