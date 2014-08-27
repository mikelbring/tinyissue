<?php $application_name = Config::get('application.my_bugs_app.name'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="/favicon.ico?v=2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $application_name ?></title>

<?php echo Asset::styles(); ?>
</head>
	<body>
	<div id="container">
		<div id="login">
			
			<h1>Welcome to<br><img src="/app/assets/images/layout/tinyissue.svg" alt="<?= $application_name ?>" style="width:350px;;"></h1>
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