<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Tiny Issue</title>
	<script>
	   var siteurl = '<?php echo URL::to(); ?>';
		var current_url = '<?php echo URL::to(Request::uri()); ?>';
		var baseurl = '<?php echo URL::base(); ?>';
	</script>

	<meta name="viewport" content="width=device-width,initial-scale=1">
	<?php echo Asset::styles(); ?>
	<?php echo Asset::scripts(); ?>
</head>
<body>

	<div id="container">

		<div id="header">

			<ul class="nav-right">
				<li>Welcome, <a href="<?php echo URL::to('user/settings'); ?>" class="user"><?php echo Auth::user()->firstname; ?></a></li>
				<?php if(Auth::user()->permission('administration')): ?>
				<li><a href="<?php echo URL::to('administration/users'); ?>">Users</a></li>
				<li><a href="<?php echo URL::to('administration'); ?>">Administration</a></li>
				<?php endif; ?>
				<li class="logout"><a href="<?php echo URL::to('user/logout'); ?>">Logout</a></li>
			</ul>

			<a href="<?php echo URL::to(); ?>" class="logo">Tiny Issue</a>

			<ul class="nav">
				<li class="dashboard <?php echo $active == 'dashboard' ? 'active' : ''; ?>"><a href="<?php echo URL::to(); ?>">Dashboard</a></li>
				<li class="issues <?php echo $active == 'issues' ? 'active' : ''; ?>"><a href="<?php echo URL::to('user/issues'); ?>">Your Issues</a></li>
				<li class="projects <?php echo $active == 'projects' ? 'active' : ''; ?>"><a href="<?php echo URL::to('projects'); ?>">Projects</a></li>
				<li class="settings <?php echo $active == 'settings' ? 'active' : ''; ?>"><a href="<?php echo URL::to('user/settings'); ?>">Settings</a></li>
			</ul>

		</div>

		<div id="main">

			<div id="sidebar">
				<div class="inside">

					<?php echo $sidebar; ?>

				</div>
			</div> <!-- end sidebar -->

			<div id="content">
				<div class="inside">
