<script type="text/javascript">
function ChgLng(Lng = 'en') {
	document.location.href = 'index.php?Lng=' + Lng;
}
</script>

<?php
if(isset($_POST['create_config']) && isset($_POST['database_host'])) {
	if(!file_exists('../config.app.example.php')) { die($NoConfigApp); }
	$config_file = file_get_contents('../config.app.example.php');

	/* Edit Database Information */
	$config_file = str_replace('localhost', $_POST['database_host'], $config_file);
	$config_file = str_replace('database_user', $_POST['database_username'], $config_file);
	$config_file = str_replace('database_password', $_POST['database_password'], $config_file);
	$config_file = str_replace('database_name', $_POST['database_name'], $config_file);

	/* Edit E-mail Information */
	$config_file = str_replace('Your E-Mail Name', $_POST['email_name'], $config_file);
	$config_file = str_replace('name@domain.com', $_POST['email_address'], $config_file);
	$config_file = str_replace("'transport' => 'smtp'", "'transport' => '".$_POST['email_transport']."'", $config_file);
	$config_file = str_replace("'username' => 'xyzxyz'", "'username' =>  '".$_POST['email_username']."'", $config_file);
	$config_file = str_replace("'server' => 'smtp.gmail.com'", "'server' => '".$_POST['email_server']."'", $config_file);
	$config_file = str_replace("'port' => 587", "'port' => ".((trim($_POST['email_port']) == '') ? 25 : $_POST['email_port']), $config_file);
	$config_file = str_replace("'encryption' => 'tls'", "'encryption' =>  '".$_POST['email_encryption']."'", $config_file);
	$config_file = str_replace("'username' => 'xyzxyz'", "'username' =>  '".$_POST['email_username']."'", $config_file);
	$config_file = str_replace("'password' => '******'", "'password' =>  '".$_POST['email_password']."'", $config_file);

	/* Timezone */
	$config_file = str_replace('Europe/Brussels', $_POST['timezone'], $config_file);

	/* Key */
	$config_file = str_replace('yourrandomkey', md5(serialize($_POST) . time() . $_SERVER['HTTP_HOST']), $config_file);

	if(!is_writable(realpath('../'))){ ?>
<!DOCTYPE html>
<html>
<head>
	<link href="../app/assets/css/install.css" media="all" type="text/css" rel="stylesheet">
</head>
<body>

<div id="container">
	<table class="form">
	<tr>
		<td colspan="2">
			<p><?php echo $MyLng['NoAPPfile_0']; ?></p>
			<p><?php echo $MyLng['NoAPPfile_1']; ?></p>

			<textarea cols="98" rows="15" class="code"><?php echo htmlentities($config_file, ENT_COMPAT, 'UTF-8'); ?></textarea>

			<p><?php echo $MyLng['NoAPPfile_2']; ?></p>
			<p><a href="index.php?Lng=<?php echo $_GET["Lng"]; ?>" class="button primary"><?php echo $MyLng['RunInstall']; ?></a></p>
		</td>
	</tr>
</div>


<?php } else {

	file_put_contents('../config.app.php', $config_file);

	//From the MySQL_DB_Schema.sql file, we create a usable php file for php install
	if (!file_exists('mysql-structure.php') && file_exists('MySQL_DB_Schema.sql') ) {
		$FILEsql = file('MySQL_DB_Schema.sql');
		$FILEphp = fopen('mysql-structure.php', 'w+');
		$linePHP  = '<?php ';
		$linePHP .= 'return array(';
		foreach ($FILEsql as $lgn => $cnt) {
			if (trim($cnt) == '#----- First line of this file .... please let it here, first with NO carriage return before nor after. -----') { $cnt = ''; continue;}
			if (trim($cnt) == '#----- Last line of this file .... Anything bellow this line will be lost. -----') { $cnt = ''; break;}
			if (substr($cnt, 0, 4) === '#--#') { $cnt = '"#'.substr($cnt, 4); }
			if (substr($cnt, 0, 3) === '#--' ) { $cnt = '",'.substr($cnt, 3); }
			$linePHP .= $cnt;
		}
		$linePHP .= ' " );';
		fwrite($FILEphp, $linePHP);
		fclose($FILEphp);
	}
	//From the freshly made mysql-structure.php file, we'll create tables and default data along the install.php process
	require "./install.php";
	$install = new install();
	$database_check = $install->check_connect();
	$install->config = require '../config.app.php';
	$install->create_database($_POST);
?>
<!DOCTYPE html>
<html>
<head>
	<link href="../app/assets/css/install.css" media="all" type="text/css" rel="stylesheet">

</head>
<body>

<div id="container">
	<table class="form">
		<tr>
			<td colspan="2">
				<p>
					<?php echo $MyLng['OkAPPfile']; ?>
				</p>

				<p><a href="index.php?Lng=<?php echo $_GET["Lng"]; ?>" class="button primary"><?php echo $MyLng['RunInstall']; ?></a></p>
				<div id="CountDown" style="width: 100%; text-align: center; padding-top:10px;">6</div>
		  </td>
	  </tr>
	</table>
</div>
<script type="text/javascript">
var CountDown = 600;
setInterval(function () {
	document.getElementById('CountDown').innerHTML = CountDown;
	if (--CountDown <= 0) { document.location.href = "index.php?Lng=<?php echo $_GET["Lng"]; ?>";}
}, 1000);

</script>

<?php
	}
exit();
}
if(!file_exists('../config.app.php')){ ?>
<!DOCTYPE html>
<html>
<head>
	<link href="../app/assets/css/install.css" media="all" type="text/css" rel="stylesheet">

</head>
<body>

<div id="container">
	<p style="text-align:center;">
	<select onchange="ChgLng(this.value);" style="background-color: #FFF;">
	<?php
		foreach ($Language as $ind => $lang) {
			echo '<option value="'.$ind.'" '.(($ind == $_GET["Lng"]) ? 'selected="selected"' : '').'>'.$lang.'</option>';
		}
	?>
	</select>
	</p>
	<form method="post" action="index.php?Lng=<?php echo $_GET["Lng"]; ?>" autocomplete="off">
		<table class="form">
			<tr>
				<td colspan="2">
				<h2><?php echo $MyLng['SetupConfigFile']; ?></h2>

				<p>
					<?php echo $MyLng['OKconfAPPfile']; ?>
				</p>
				</td>
			</tr>
			<tr style="background-color: #DDD;">
				<td colspan="2">
				<h3 style="font-weight: bold; font-size: 150%; ">MySQL</h3>
				</td>
			</tr>
			<tr style="background-color: #DDD;">
				<th><?php echo $MyLng['SQL_Driver']; ?></th>
				<td>
					<select name="database_driver">
					<option value="mysql">MySQL</option>
					<option value="sqlsrv">MSSQL</option>
					<option value="pgsql">PostgreSQL</option>
					<option value="sqlite">SQLite</option>
					</select>
				</td>
			</tr>
			<tr style="background-color: #DDD;">
				<th><?php echo $MyLng['SQL_Host']; ?></th>
				<td><input type="text" name="database_host" value="localhost" /></td>
			</tr>
			<tr style="background-color: #DDD;">
				<th><?php echo $MyLng['SQL_Database']; ?></th>
				<td><input type="text" name="database_name" value="bugs" /></td>
			</tr>
			<tr style="background-color: #DDD;">
				<th><?php echo $MyLng['SQL_Username']; ?></th>
				<td><input type="text" name="database_username" value="" /></td>
			</tr>
			<tr style="background-color: #DDD;">
				<th><?php echo $MyLng['SQL_Password']; ?></th>
				<input type="password" name="autocompletion_off" value="" style="display:none;">
				<td><input type="password" name="database_password" value="" /></td>
			</tr>
			<tr>
				<td colspan="2">
				<h3 style="font-weight: bold; font-size: 150%; "><?php echo $MyLng['Email']; ?></h3>
				<p><?php echo $MyLng['Email_Desc']; ?></p>
				</td>
			</tr>
			<tr>
				<th><?php echo $MyLng['Email_Name']; ?></th>
				<td>
					<input type="text" name="email_name" value="" placeholder="My dear Bugs prog" />
				</td>
			</tr>
			<tr>
				<th><?php echo $MyLng['Email_Address']; ?></th>
				<td>
					<input type="text" name="email_address" value="" placeholder="you@domain.com" />
				</td>
			</tr>
			<tr>
				<th><?php echo $MyLng['Email_transport']; ?></th>
				<td>
					<select name="email_transport">
					<option value="smtp">smtp</option>
					<option value="mail" selected="selected">mail</option>
					<option value="sendmail">sendmail</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><?php echo $MyLng['Email_server']; ?></th>
				<td>
					<input type="text" name="email_server" value="" placeholder="smtp.gmail.com" />
				</td>
			</tr>
			<tr>
				<th><?php echo $MyLng['Email_port']; ?></th>
				<td>
					<select name="email_port">
					<option value="25"> 25 (default)</option>
					<option value="587">587 (gmail)</option>
					<option value="465">465 (SSL / TLS)</option>
					<?php
						for ($x=1; $x<999; $x++) {
							echo '<option value="'.$x.'">'.$x.'</option>';
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<th><?php echo $MyLng['Email_encryption']; ?></th>
				<td>
					<select name="email_encryption">
					<option value="">(none)</option>
					<option value="tsl">TSL</option>
					<option value="ssl">SSL</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><?php echo $MyLng['Email_username']; ?></th>
				<td>
					<input type="text" name="email_username" value="" placeholder="username@gmail.com" />
				</td>
			</tr>
			<tr>
				<th><?php echo $MyLng['Email_password']; ?></th>
				<td>
					<input type="text" name="email_password" value="" placeholder="email password" />
				</td>
			</tr>
			<tr>
				<td colspan="2" style="background-color: #DDD;">
				<h3 style="font-weight: bold; font-size: 150%; "><?php echo $MyLng['Time_Local']; ?></h3>
				</td>
			</tr>
			<tr style="background-color: #DDD;">
				<th><?php echo $MyLng['Time_Timezone']; ?></th>
				<td>
					<select name="timezone">
						<?php
						$timezones = timezone_identifiers_list();
						
						echo 'select name="timezone" size="10">' . "\n";
						
						foreach($timezones as $timezone)
						{
						  echo '<option';
//						  echo $timezone == 'Europe/Brussels' ? ' selected' : '';
						  echo $timezone == date("e") ? ' selected' : '';
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
						<input type="submit" class="button primary" name="create_config" value="<?php echo $MyLng['Button_CreateConfig']; ?>" />
					</td>
				</tr>
			</table>
		</form>
	</div>
<?php exit(); } ?>