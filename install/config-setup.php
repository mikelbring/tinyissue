<?php

if (isset($_POST['create_config']) && isset($_POST['database_host']))
{
	if ( ! file_exists('../config.app.example.php'))
	{
		die('Sorry, we need a config.app.example.php file to work with. Please re-upload this from your Tiny Issue package.');
	}

	$config_file = file_get_contents('../config.app.example.php');

	/* Edit Database Information */
	$config_file = str_replace('localhost', $_POST['database_host'], $config_file);
	$config_file = str_replace('database_user', $_POST['database_username'], $config_file);
	$config_file = str_replace('database_password', $_POST['database_password'], $config_file);
	$config_file = str_replace('database_name', $_POST['database_name'], $config_file);

	/* Edit E-mail Information */
	$config_file = str_replace('Your E-Mail Name', $_POST['email_name'], $config_file);
	$config_file = str_replace('name@domain.com', $_POST['email_address'], $config_file);

	/* Timezone */
	$config_file = str_replace('America/Chicago', $_POST['timezone'], $config_file);

	/* Key */
	$config_file = str_replace('yourrandomkey', md5(serialize($_POST) . time() . $_SERVER['HTTP_HOST']), $config_file);

	if ( ! is_writable(realpath('../')))
    {
?>
<!DOCTYPE html>
<html>
<head>
	<link href="../assets/css/install.css" media="all" type="text/css" rel="stylesheet">
</head>
<body>
<div id="container">
	<table class="form">
	<tr>
		<td colspan="2">
			<p>
				Sorry, but I could not write the <code>config.app.php</code> file.
			</p>
			<p>
				You can create the <code>config.app.php</code> manually and paste the following text into it.
			</p>

			<textarea cols="98" rows="15" class="code"><?php echo htmlentities($config_file, ENT_COMPAT, 'UTF-8'); ?></textarea>

			<p>
			Okay, after doing that, click the "Run Install" button.
			</p>

			<p><a href="index.php" class="button primary">Run Install</a></p>
		</td>
	</tr>
</div>


<?php }else{

	file_put_contents('../config.app.php', $config_file);
?>
<!DOCTYPE html>
<html>
<head>
	<link href="../assets/css/install.css" media="all" type="text/css" rel="stylesheet">

</head>
<body>

<div id="container">
	<table class="form">
		<tr>
			<td colspan="2">
				<p>Okay, your <code>config.app.php</code> file has been created! You can now click "Run Install" below to go through the installation</p>

				<p><a href="index.php" class="button primary">Run Install</a></p>
		  </td>
	  </tr>
	</table>
</div>

<?php 
	}
exit();
}

if ( ! file_exists('../config.app.php'))
{
?>
<!DOCTYPE html>
<html>
<head>
	<link href="../assets/css/install.css" media="all" type="text/css" rel="stylesheet">

</head>
<body>

<div id="container">
	<form method="post" action="">
		<table class="form">
			<tr>
				<td colspan="2">
				<h2>Setup Config FIle</h2>

				<p>
					Looks like you do not have a <code>config.app.php</code> file setup. We need to create one before we can
					get started with the installation. We can attempt to create the <code>config.app.php</code> file through
					this setup, however not all servers will allow this.
				</p>
				</td>
			</tr>
				<tr>
					<th>MySQL Host</th>
					<td><input type="text" name="database_host" value="localhost" /></td>
				</tr>
				<tr>
					<th>MySQL Database</th>
					<td><input type="text" name="database_name" value="tinyissue" /></td>
				</tr>
				<tr>
					<th>MySQL Username</th>
					<td><input type="text" name="database_username" value="" /></td>
				</tr>
				<tr>
					<th>MySQL Password</th>
					<td><input type="password" name="database_password" value="" /></td>
				</tr>
				<tr>
					<th>E-Mail From Name</th>
					<td>
						<input type="text" name="email_name" value="Tiny Issue" />
						<p>Sometimes Tiny Issue needs to send e-mail, what do you want the name to be from?</p>
					</td>
				</tr>
				<tr>
					<th>E-Mail Address</th>
					<td>
						<input type="text" name="email_address" value="you@domain.com" />
					</td>
				</tr>
				<tr>
					<th>Timezone</th>
					<td>
						<select name="timezone">
<?php 
$timezones = timezone_identifiers_list();

echo 'select name="timezone" size="10">' . "\n";

foreach($timezones as $timezone)
{
  echo '<option';
  echo $timezone == 'America/Chicago' ? ' selected' : '';
  echo '>' . $timezone . '</option>' . "\n";
}

echo '</select>' . "\n";
?>
						</select>	
					</td>
				</tr>
				<tr>
					<th></th>
					<td>
						<input type="submit" class="button primary" name="create_config" value="Create Config" />
					</td>
				</tr>
			</table>
		</form>
	</div>
<?php exit(); } ?>