<?php

return array(
	/**  URL
	 * You can define your URL or leave blank to let us figure it out
	 * 	- Sometimes in non-apache setups you need to define your url
	 */
	'url' => '',

	/**  Database
	 * Fill out your database settings. Make sure that the driver is correct: 'mysql' for MySQL, 'sqlsrv' for MSSQL,
	 * 'pgsql' for PostgreSQL, or 'sqlite' for SQLite
	 */
	'database' => array(
		'driver' => 'mysql',
		'host'  => 'localhost',
		'database' => 'database_name',
		'username' => 'database_user',
		'password' => 'database_password',
	),

	/**  Date format */
	'my_bugs_app'=>array(
		'name'=> 'Bugs',
		'date_format'=>'F jS \a\t g:i A',
	),

	/**  wysiwyg editor
	  *  Default : 'BasePage'=>'/app/vendor/ckeditor/ckeditor.js',
	  *  No one  : 'BasePage'=>'',
	  *  If you want to use no wysiwyg editor please set this to empty.
	  *  Do not mark this as comment
	  *  Fill out with the entire path, begining with app/
	  *  Editor base page type permitted:  .js   .php
	*/
	'editor' => array(
		'BasePage' => '/app/vendor/ckeditor/ckeditor.js',
	),


	/**  Mail
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
		/**
		 * Transport Settings
		 * Transport settings if using mail or smtp
		 * 'mail' or 'smtp' must be lower case
		 */
		'transport' => 'smtp',
		'sendmail' => array('path' => ''),
		'smtp' => array(
			'server' => 'smtp.gmail.com',
			'port' => 587,
			/*
			* Encryption support, SSL/TLS, used with gmail servers
			* Default: blank
			* 'ssl' or 'tls' must be lower case
			* Here example for gmail server
			*/
			'encryption' => 'tls',
			'username' => 'xyzxyz',
			'password' => '******'
		),
		'encoding' => 'UTF-8',
		/*
		* Final delivery format
		* Default: text/plain
		* 'text/plain' or 'html'  must be lower case
		*/
		'plainHTML' => 'text/plain',
		'linelenght' => 80
	),

	/**  Timezone
	 * Specify your timezone
	 * - http://php.net/manual/en/timezones.php
	 */
	'timezone' => 'Europe/Brussels',

	/**  Session key
	 * Put in a random key combination to use as your session keys
	 * Up to 32 characters
	 * You can use this online generator: http://online-code-generator.com/generate-salt-random-string.php
	 */
	'key' => 'yourrandomkey',

	/**  mod_rewrite
	 * True if you are using mod rewrite
	 * False if you are not
	 */
	'mod_rewrite' => true,

	/**  Percentage
	 *Percentage of issue done
	 *Make sure your array count 5 items, the fifth must be 100
	 *In order:  (done, open, inProgress, Testing, SysNeed)
	 *Default: (100,0,10,80,100)
	*/
	'Percent' => array (100,0,10,80,100),

	/**  duration
	 *How long is supposed to be given to fix an issue
	 *Duration in days
	 *Default: 30
	*/
	'duration' => 30,

);