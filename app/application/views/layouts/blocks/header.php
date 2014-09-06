<!DOCTYPE html>
<html>
<head>
<link rel="apple-touch-icon" sizes="57x57" href="/app/assets/images/app-icons/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="114x114" href="/app/assets/images/app-icons/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="72x72" href="/app/assets/images/app-icons/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="144x144" href="/app/assets/images/app-icons/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="60x60" href="/app/assets/images/app-icons/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="120x120" href="/app/assets/images/app-icons/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="76x76" href="/app/assets/images/app-icons/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="152x152" href="/app/assets/images/app-icons/apple-touch-icon-152x152.png">
<meta name="apple-mobile-web-app-title" content="Bugs">
<link rel="icon" type="image/png" href="/app/assets/images/app-icons/favicon-196x196.png" sizes="196x196">
<link rel="icon" type="image/png" href="/app/assets/images/app-icons/favicon-160x160.png" sizes="160x160">
<link rel="icon" type="image/png" href="/app/assets/images/app-icons/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/app/assets/images/app-icons/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="/app/assets/images/app-icons/favicon-32x32.png" sizes="32x32">
<meta name="msapplication-TileColor" content="#39404f">
<meta name="msapplication-TileImage" content="/app/assets/images/app-icons/mstile-144x144.png">
<meta name="application-name" content="Bugs">
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

			<a href="<?php echo URL::to(); ?>" class="logo" title="<?=  Config::get('application.my_bugs_app.name') ?>"><?=  Config::get('application.my_bugs_app.name') ?></a>

			<ul class="nav">
				<li class="dashboard <?php echo $active == 'dashboard' ? 'active' : ''; ?>"><a href="<?php echo URL::to(); ?>"><?php echo __('tinyissue.dashboard');?></a></li>
				<li class="issues <?php echo $active == 'issues' ? 'active' : ''; ?>"><a href="<?php echo URL::to('user/issues'); ?>"><?php echo __('tinyissue.your_issues');?></a></li>
				<li class="todo <?php echo $active == 'todo' ? 'active' : ''; ?>"><a href="<?php echo URL::to('todo'); ?>"><?php echo __('tinyissue.your_todos');?></a></li>
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
