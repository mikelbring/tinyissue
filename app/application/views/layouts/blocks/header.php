<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo Config::get('config.mail_from_name') ?></title>
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
				<li><?php echo __('tinyissue.welcome');?>, <a href="<?php echo URL::to('user/settings'); ?>" class="user"><?php echo Auth::user()->firstname; ?></a></li>
				<?php if(Auth::user()->permission('administration')): ?>
				<li><a href="<?php echo URL::to('administration/users'); ?>"><?php echo __('tinyissue.users');?></a></li>
				<li><a href="<?php echo URL::to('administration'); ?>"><?php echo __('tinyissue.administration');?></a></li>
				<?php endif; ?>
				<li class="logout"><a href="<?php echo URL::to('user/logout'); ?>"><?php echo __('tinyissue.logout');?></a></li>
			</ul>

			<a href="<?php echo URL::to(); ?>" class="logo" title="Pixeline Bug Squashing Platform">Pixeline Bug Squashing Platform</a>

			<ul class="nav">
				<li class="dashboard <?php echo $active == 'dashboard' ? 'active' : ''; ?>"><a href="<?php echo URL::to(); ?>"><?php echo __('tinyissue.dashboard');?></a></li>
				<li class="issues <?php echo $active == 'issues' ? 'active' : ''; ?>"><a href="<?php echo URL::to('user/issues'); ?>"><?php echo __('tinyissue.your_issues');?></a></li>
				<li class="projects <?php echo $active == 'projects' ? 'active' : ''; ?>"><a href="<?php echo URL::to('projects'); ?>"><?php echo __('tinyissue.projects');?></a></li>
				<li class="settings <?php echo $active == 'settings' ? 'active' : ''; ?>"><a href="<?php echo URL::to('user/settings'); ?>"><?php echo __('tinyissue.settings');?></a></li>
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
