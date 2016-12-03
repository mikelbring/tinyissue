<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo URL::to_asset('/apple-touch-icon-57x57.png'); ?>">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo URL::to_asset('/apple-touch-icon-114x114.png');?>">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL::to_asset('/apple-touch-icon-72x72.png');?>">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo URL::to_asset('/apple-touch-icon-144x144.png');?>">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo URL::to_asset('/apple-touch-icon-60x60.png');?>">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo URL::to_asset('/apple-touch-icon-120x120.png');?>">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo URL::to_asset('/apple-touch-icon-76x76.png');?>">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo URL::to_asset('/apple-touch-icon-152x152.png');?>">
		<meta name="apple-mobile-web-app-title" content="Bugs">
		<link rel="icon" type="image/png" href="<?php echo URL::to_asset('/favicon-196x196.png');?>" sizes="196x196">
		<link rel="icon" type="image/png" href="<?php echo URL::to_asset('/favicon-160x160.png');?>" sizes="160x160">
		<link rel="icon" type="image/png" href="<?php echo URL::to_asset('/favicon-96x96.png');?>" sizes="96x96">
		<link rel="icon" type="image/png" href="<?php echo URL::to_asset('/favicon-16x16.png');?>" sizes="16x16">
		<link rel="icon" type="image/png" href="<?php echo URL::to_asset('/favicon-32x32.png');?>" sizes="32x32">
		<meta name="msapplication-TileColor" content="#39404f">
		<meta name="msapplication-TileImage" content="<?php echo URL::to_asset('/mstile-144x144.png');?>">
		<meta name="application-name" content="<?php Config::get('my_bugs_app.name'); ?>">	
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1">

		<title><?php echo Config::get('application.my_bugs_app.name'); ?></title>
		<?php echo Asset::styles(); ?>
	</head>
<body>
	<div id="container">
		<div id="login">
			
			<h1>Welcome to<br><img src="<?php echo URL::to_asset('app/assets/images/layout/tinyissue.svg');?>" alt="<?php echo Config::get('application.my_bugs_app.name'); ?>" style="width:350px;;"></h1>
			<form method="post">


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