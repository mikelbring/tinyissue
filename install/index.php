<?php
include_once "../app/application/language/all.php";
$EnLng = require_once("../app/application/language/en/install.php");
if (!isset($_GET["Lng"]) || !file_exists("../app/application/language/".@$_GET["Lng"]."/install.php")) { $_GET["Lng"] = 'en'; }
if (@$_GET["Lng"] != 'en' ) { $MyLng = require_once("../app/application/language/".$_GET["Lng"]."/install.php"); $MyLng = array_merge($EnLng, $MyLng); } else {$MyLng = $EnLng; }
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


if(!$database_check['error']) {
	if(isset($_POST['email'])) {
		if($_POST['email'] != ''&& $_POST['first_name'] != '' && $_POST['last_name'] != '' && $_POST['password'] != '') {
			$finish = $install->create_tables($_POST);
			if($finish) {
				session_start();
				$_SESSION["Msg"]  = '<h2 style="color: #060;">'.$MyLng['Complete_awesome'].'</h2>';
				$_SESSION["Msg"] .= '<p style="color: #060;">'.$MyLng['Complete_presentation'].'</p>';
				$_SESSION["usr"] = $_POST['email'];  
				$_SESSION["psw"] = $_POST['password'];  
				//header('location: complete.php?Lng=fr');
				header('location: ../');
				die();
			}
		} else {
			if(trim($_POST['email']) == '' || $_POST['email'] == "you@domain.com") 		{ $email_error = $MyLng['InitError_email']; }
			if(trim($_POST['first_name']) == '') 	{ $first_name_error = $MyLng['InitError_fname']; }
			if(trim($_POST['last_name']) == '') 	{ $last_name_error = $MyLng['InitError_lname']; }
			if(trim($_POST['password']) == '')		{ $pass_error = $MyLng['InitError_pswrd']; }
		}
	} else {
		$_POST['email'] = '';
		$_POST['first_name'] = '';
		$_POST['last_name'] = '';
	}
}
?>

<!DOCTYPE html>
<html>
<title>Installation BUGS</title>
<head>

	<link href="../app/assets/css/install.css" media="all" type="text/css" rel="stylesheet">

</head>
<body>

<div id="container">
	<form method="post" action="index.php?Lng=<?php echo $_GET["Lng"]; ?>" autocomplete="off">
		<table class="form">
			<tr>
				<td colspan="2">
				<?php
					echo '<h2>'.$MyLng['Installation'].'</h2>';
					if(count($requirement_check) > 0) {
						echo '<strong>'.$MyLng['Requirement_Check'].'</strong><br />';
						foreach ($requirement_check as $key => $value) { echo ' - '.$value.'<br />'; }
						die();
					}
					if($database_check['error']) {
						echo $MyLng['Database_check'].$database_check['error'];
						die();
					}
					echo $MyLng['Installation_Thanks'];
				?>

				
				</td>
			</tr>

			<tr>
				<th><label for="first_name"><?php echo $MyLng['Name_first']; ?></label></th>
				<td>
					<input autocomplete="off" type="text" name="first_name" id="first_name" value="<?php echo $_POST['first_name']; ?>"/>
					<span class="error"><?php echo $first_name_error ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="last_name"><?php echo $MyLng['Name_last']; ?></label></th>
					<td>
						<input autocomplete="off" type="text" name="last_name" id="last_name" value="<?php echo $_POST['last_name']; ?>"/>
						<span class="error"><?php echo $last_name_error ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="language"><?php echo $MyLng['Name_lang']; ?></label></th>
				<td>
				<select name="language" id="language" style="background-color: #FFF;">
				<?php
					foreach ($Language as $ind => $lang) {
						echo '<option value="'.$ind.'" '.(($ind == $_GET["Lng"]) ? 'selected="selected"' : '').'>'.$lang.'</option>';
					}
				?>
				</select>
				</td>
			</tr>
			<tr>
				<th><label for="email"><?php echo $MyLng['Name_email']; ?></label></th>
				<td>
					<input autocomplete="off" type="text" name="email" id="email" value="<?php echo $_POST['email']; ?>"/>
					<span class="error"><?php echo $email_error ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="password"><?php echo $MyLng['Name_pswd']; ?></label></th>
				<td>
					<input type="password" name="autocompletion_off" value="" style="display:none;">
					<input autocomplete="off" type="password" name="password" id="password" />
					<span class="error"><?php echo $pass_error ?></span>
				</td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" value="<?php echo $MyLng['Name_finish']; ?>" class="button primary"/></td>
			</tr>
		</table>
	</form>
</div>

</body>
</html>
