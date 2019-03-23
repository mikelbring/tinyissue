<?php

return array(
	/**  URL
	 * You can define your URL or leave blank to let us figure it out
	 * 	- Sometimes in non-apache setups you need to define your url
	 */
	'url' => '',

	/**  Directories
	 Here, you'll define where to store informations
	 'directory' : where to store the files you'll attach to an issue
	   | Default value : 'uplaods/'  ... which means  /var/www/html/Bugs_directory/uploads/
	   | if you want to store wherever in your computer, give the absolute path starting this with a '/'  like  '/home/user/Documents/Downloads/'
	 'format' : how to name the downloaded files attached to an issue, each component of this variable will be separated by an undescore
	   | Possible values are limited to : 'ICN', 'NCI', 'CIN'
	   | 'C' like 'Comment' refering to comment's number
	   | 'I' like 'Issue' refering to issue's number
	   | 'N' like 'Name' a somewhat given name
	   | Defalut value : 'ICN'	will produce something like I_C_name.ext
	 'method' : how to store the attached files
	   | Possible values are limited to : 'd', 'i'
	   | 'd' like 'directories' : all together in a single directory
	   | 'i' like 'issue' : each issue has its own sub-directory   ... if you chose this option, the 'I' value of 'format' will be skipped
	   | Default value : 'i'
	 */
	'attached' => array(
		'directory' => 'uploads/',
		'format' => 'ICN',
		'method' => 'i'
	),

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

	/**  Date format
	  * Check http://php.net/manual/en/function.date.php for informations
	  * Internationnal date and time:   				'date_format'=>'Y-m-d H:i',
	  * Internationnal date and time with seconds:  'date_format'=>'Y-m-d H:i:s',
	  * USA way of writing time:							'date_format'=>'F jS \a\t g:i A',
	**/           
	'my_bugs_app'=>array(
		'name'=> 'Bugs',
		'date_format'=>'Y-m-d H:i',
	),

	/**  Timezone
	 * Specify your timezone
	 * - http://php.net/manual/en/timezones.php
	 */
	'timezone' => 'Europe/Brussels',

	/**  wysiwyg editor
	  *  Default : 'BasePage'=>'/app/vendor/ckeditor/ckeditor.js',
	  *  No one  : 'BasePage'=>'',
	  *  If you want to use no wysiwyg editor please set this to empty.
	  *  Do not mark this as comment
	  *  Fill out with the entire path, begining with app/
	  *  Editor base page type permitted:  .js   .php
	  ////This (below) for ckeditor
			'directory' = > 'vendor/ckeditor',  
			'BasePage' => '/app/vendor/ckeditor/ckeditor.js',
			'name' => 'ckeditor',
	  ////This (below) for Trumbowyg editor
		'directory' = > 'vendor/Trumbowyg/',  
		'BasePage' => '/app/vendor/Trumbowyg/trumbowyg.min.js',
		'name' => 'trumbowyg',
	*/
	'editor' => array( 
		'BasePage' => '/app/vendor/ckeditor/ckeditor.js',
		'directory' => 'vendor/ckeditor',
		'name' => 'ckeditor',
	),


	/**  Mail
	 * Mail Settings
	 * - Put in the name and email you would like email from Tiny Issue to come from
	 * - This is usually only for setting up new accounts
	 *
	 * Default Mail Transport
	 *	|
	 *	| Possible Values
	 *	| 	mail (PHP Mail Function) --- default
	 *	| 	PHP (php language mail function)
	 *	| 	sendmail (Sendmail - almost the same as 'mail' option but with authentications details)
	 *	| 	gmail (using Google's gmail system)
	 *	| 	pop3 (Define Custom POP3)
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
		'transport' => 'mail',
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

		/* Characters encoding  
		* Possible values or endless, but most usual are 'UTF-8' (Europe) or 'iso-8859-1' (North-America)
		* Default value : 'UTF-8'  
		*/
		'encoding' => 'UTF-8',

		/*
		* Final delivery format
		* Default: multipart/mixed
		* 'text/plain' or 'html'  or 'multipart/mixed' must be lower case
		*/
		'plainHTML' => 'multipart/mixed',
		'linelenght' => 80
	),

	/**  Session key
	 * Put in a random key combination to use as your session keys
	 * You must use 16 or 32 characters
	 * You can use this online generator: http://online-code-generator.com/generate-salt-random-string.php
	 */
	'key' => 'UseAtLeast16char',

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

	/**Priority
	*Beside others tickets, 
	*which ones need to be solved first  ( priority = 5 )
	*which ones can wait ( priority = 1 )
	*closed issues have priority = 0
	
	**PriorityColors chose the color of the dot marker
	**Values can be either names or hexadecimals
	**Names like:  black, darkviolet, blue, green ... ref https://www.w3schools.com/cssref/css_colors.asp
	**Hexadecimal values starting with # code  like  #FF0000 #FFFF00  #123456
	**If you don't wont to see the status marker, set the values to transparent
	**Examples below:
	****Default
	****'PriorityColors' => array("black",	"PaleGray","DarkCyan","LimeGreen","Darkorange","Crimson"),
	****'PriorityColors' => array("#000000","#acacac","#008B8B", "#32CD32",  "#FF8C00",   "#DC143C"),
	****All transparent
	****'PriorityColors' => array("transparent","transparent","transparent","transparent","transparent","transparent "),
	*/
	'PriorityColors' => array("black","PaleGray","DarkCyan","LimeGreen","Darkorange","Crimson"),

);