<?php

return array(

	/**
	 * You can define your URL or leave blank to let us figure it out
	 * 	- Sometimes in non-apache setups you need to define your url
	 */
	'url' => '',


	/**
	 * Fill out your database settings. Make sure that the driver is correct: 'mysql' for MySQL, 'sqlsrv' for MSSQL,
	 * 'pgsql' for PostgreSQL, or 'sqlite' for SQLite
	 */
	'database' => array(
	  'driver' => 'mysql'
		'host'  => 'localhost',
		'database' => 'database_name',
		'username' => 'database_user',
		'password' => 'database_password',
	),

	/**
	 * Mail Settings
	 * - Put in the name and email you would like email from Tiny Issue to come from
	 * - This is usually only for setting up new accounts
	 *
	 * Default Mail Transport
	 *	|
	 *	| Possible Values
	 *	| 	mail (PHP Mail Function)
	 *	| 	sendmail (Sendmail)
	 *	| 	smtp (Define Custom SMTP)
	 *
	 */
	'mail' => array(

		'from' => array(
			'name' => 'Your E-Mail Name',
			'email' => 'name@domain.com',
		),

		'transport' => 'mail',

		/**
		 * Transport Settings
		 *
		 * Transport settings if using sendmail or SMTP
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

	/**
	 * Specify your timezone
	 * - http://php.net/manual/en/timezones.php
	 */
	'timezone' => 'America/Chicago',

	/**
	 * Put in a random key combination to use as your session keys
	 * Up to 32 characters
	 */
	'key' => 'yourrandomkey',

	/**
	 * True if you are using mod rewrite
	 * False if you are not
	 */
	'mod_rewrite' => false,

);