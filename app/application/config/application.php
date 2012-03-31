<?php

$config = require PUBLIC_PATH . 'config.app.php';

return array(


	/*
	|--------------------------------------------------------------------------
	| MySQL Database Information
	|--------------------------------------------------------------------------
	*/

	'database' => 'mysql',

	'connections' => array(

		'mysql' => array(
			'driver'   => 'mysql',
			'host'     => $config['mysql']['host'],
			'database' => $config['mysql']['database'],
			'username' => $config['mysql']['username'],
			'password' => $config['mysql']['password'],
			'charset'  => 'utf8',
		),

	),

	/*
	|--------------------------------------------------------------------------
	| Application Settings
	|--------------------------------------------------------------------------
	*/

	'url' => '',

	'index' => !$config['mod_rewrite'] ? 'index.php' : '',

	'key' => $config['key'],

	'timezone' => $config['timezone'],

	/*
	|--------------------------------------------------------------------------
	| File Uploads
	|--------------------------------------------------------------------------
	*/

	'upload_path' => PUBLIC_PATH . 'app/assets/uploads/',
	'attachment_path' => '/app/assets/uploads/',

	'image_extensions' => array(
		'jpg', 'jpeg', 'JPG', 'JPEG',
		'png', 'PNG',
		'gif', 'GIF'
	),

	/*
	|--------------------------------------------------------------------------
	| Mail Settings
	|--------------------------------------------------------------------------
	|
	| Default Mail Transport
	|
	| Possible Values
	| 	mail (PHP Mail Function)
	| 	sendmail (Sendmail)
	| 	smtp (Define Custom SMTP)
	|
	*/

	'mail' => array(

		'transport' => 'mail',

		/*
		 * Default Mail From
		 *
		 * Possible Value
		 * 	name => Joe Bob
		 * 	email => joe@bob.com
		 */

		'from' => array(
			'name' => $config['mail']['name'],
			'email' => $config['mail']['email']
		),

		/**
		 * Transport Settings
		 *
		 * Transport Settings If Using Sendmail Or SMTP
		 */

		'sendmail' => array(
			'path' => ''
		),

		'smtp' => array(
			'server' => '',
			'port' => 25,
			'username' => '',
			'password' => '',
		),

	),

	/*
	|--------------------------------------------------------------------------
	| Core Configuration
	|--------------------------------------------------------------------------
	*/

	'login_skip' => array(
		'user/login',
		'ajax/project/issue/upload-attachment'
	),

	'encoding' => 'UTF-8',
	'language' => 'en',
	'ssl' => true,

	'aliases' => array(
		'Arr'        => 'Laravel\\Arr',
		'Asset'      => 'Laravel\\Asset',
		'Autoloader' => 'Laravel\\Autoloader',
		'Benchmark'  => 'Laravel\\Benchmark',
		'Cache'      => 'Laravel\\Cache\\Manager',
		'Config'     => 'Laravel\\Config',
		'Controller' => 'Laravel\\Routing\\Controller',
		'Cookie'     => 'Laravel\\Cookie',
		'Crypter'    => 'Laravel\\Crypter',
		'DB'         => 'Laravel\\Database\\Manager',
		'Eloquent'   => 'Laravel\\Database\\Eloquent\\Model',
		'File'       => 'Laravel\\File',
		'Form'       => 'Laravel\\Form',
		'Hash'       => 'Laravel\\Hash',
		'HTML'       => 'Laravel\\HTML',
		'Inflector'  => 'Laravel\\Inflector',
		'Input'      => 'Laravel\\Input',
		'IoC'        => 'Laravel\\IoC',
		'Lang'       => 'Laravel\\Lang',
		'Memcached'  => 'Laravel\\Memcached',
		'Paginator'  => 'Laravel\\Paginator',
		'URL'        => 'Laravel\\URL',
		'Redirect'   => 'Laravel\\Redirect',
		'Redis'      => 'Laravel\\Redis',
		'Request'    => 'Laravel\\Request',
		'Response'   => 'Laravel\\Response',
		'Section'    => 'Laravel\\Section',
		'Session'    => 'Laravel\\Facades\\Session',
		'Str'        => 'Laravel\\Str',
		'Validator'  => 'Laravel\\Validator',
		'View'       => 'Laravel\\View',
	),

);
