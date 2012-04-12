<?php

require './config-setup.php';
require '../app/laravel/hash.php';
require '../app/laravel/str.php';



$first_name_error = '';
$last_name_error = '';
$email_error = '';
$pass_error = '';

require './install.php';

$install = new install();
$database_check = $install->check_connect();
$requirement_check = $install->check_requirements();

if(!$database_check['error'])
{
	if(isset($_POST['email']))
	{
		if($_POST['email'] != ''&& $_POST['first_name'] != '' && $_POST['last_name'] != '' && $_POST['password'] != '')
		{
			$finish = $install->create_tables($_POST);

			if($finish)
			{
				header('location: complete.php');
				die();
			}
		}
		else
		{
			if($_POST['email'] == '')
			{
				$email_error = 'Valid Email Required';
			}

			if($_POST['first_name'] == '')
			{
				$first_name_error = 'First Name Required';
			}

			if($_POST['last_name'] == '')
			{
				$last_name_error = 'Last Name Required';
			}

			if($_POST['password'] == '')
			{
				$pass_error = 'Password Required';
			}
		}
	}
	else
	{
		$_POST['email'] = '';
		$_POST['first_name'] = '';
		$_POST['last_name'] = '';
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<link href="../app/assets/css/install.css" media="all" type="text/css" rel="stylesheet">

</head>
<body>

<div id="container">
	<form method="post" action="">
		<table class="form">
			<tr>
				<td colspan="2">
					<h2>Installation</h2>

				<?php	if(count($requirement_check) > 0): ?>

					<strong>Please install all required extensions</strong><br />

					<?php foreach ($requirement_check as $key => $value): ?>
						<?php echo $value; ?><br />
					<?php endforeach; ?>

				<?php die(); endif; ?>

				<?php	if(count($database_check['error']) > 0): ?>
					Please fix your config.app.php - <?php echo $database_check['error']; ?>
				<?php die(); endif;?>

				Thank you for using Tiny Issue.  Your config file looks good.  Please fill out the form below to set up your administrator account and we will finish up the install.
				</td>
			</tr>

			<tr>
				<th><label for="first_name">First Name</label></th>
				<td>
					<input autocomplete="off" type="text" name="first_name" id="first_name" value="<?php echo $_POST['first_name']; ?>"/>
					<span class="error"><?php echo $first_name_error ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="last_name">Last Name</label></th>
					<td>
						<input autocomplete="off" type="text" name="last_name" id="last_name" value="<?php echo $_POST['last_name']; ?>"/>
						<span class="error"><?php echo $last_name_error ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="email">Your Email</label></th>
				<td>
					<input autocomplete="off" type="text" name="email" id="email" value="<?php echo $_POST['email']; ?>"/>
					<span class="error"><?php echo $email_error ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="password">Password</label></th>
				<td>
					<input autocomplete="off" type="password" name="password" id="password" />
					<span class="error"><?php echo $pass_error ?></span>
				</td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" value="Finish Installation" class="button primary"/></td>
			</tr>
		</table>
	</form>
</div>

</body>
</html>
