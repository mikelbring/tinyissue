<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tiny Issue</title>

<?php echo Asset::styles(); ?>
</head>
	<body>
	<div id="container">
		<div id="login">


			<form method="post" action="">


				<table class="form" >
					<tr>
						<td colspan="2" style="color: #a31500;"><?php echo Session::get('error'); ?></td>
					</tr>
					<tr><th colspan="2">Login to your account</th></tr>
					<tr>
						<th>Email</th>
						<td><input type="text" name="email" /></td>
					</tr>
					<tr>
						<th>Password</th>
						<td><input type="password" name="password" /></td>
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