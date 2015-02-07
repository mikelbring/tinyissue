<?php $application_name = Config::get('application.my_bugs_app.name'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
<meta name="apple-mobile-web-app-title" content="Bugs">
<link rel="icon" type="image/png" href="/favicon-196x196.png" sizes="196x196">
<link rel="icon" type="image/png" href="/favicon-160x160.png" sizes="160x160">
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
<meta name="msapplication-TileColor" content="#39404f">
<meta name="msapplication-TileImage" content="/mstile-144x144.png">
<meta name="application-name" content="Bugs">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $application_name ?></title>

<?php echo Asset::styles(); ?>
</head>
	<body>
	<div id="container">
		<div id="login">
			
			<h1>Welcome to<br><img src="app/assets/images/layout/tinyissue.svg" alt="<?php echo $application_name ?>" style="width:350px;;"></h1>
			<form method="post" action="">


				<table class="form" >
					<tr>
						<td colspan="2" style="color: #a31500;"><?php echo Session::get('error'); ?></td>
					</tr>
					<tr><th colspan="2">Login to your account</th></tr>
					<tr>
						<th><label for="email">Email</label></th>
						<td><input type="text" name="email" id="email" autofocus /></td>
					</tr>
					<tr>
						<th><label for="password">Password</label></th>
						<td><input type="password" id="password" name="password" /></td>
					</tr>
					<tr>
						<th></th>
						<td>
							<label><input type="checkbox" value="1" name="remember" /> Remember me? </label>
							<input type="submit" value="Login" class="button primary"/>
						</td>
					</tr>
				</table>

				<?php echo Form::hidden('return', Session::get('return', '')); ?>
				<?php echo Form::token(); ?>
			</form>
		</div>
	</div>
</body>

<?php echo Asset::scripts(); ?>

</html>