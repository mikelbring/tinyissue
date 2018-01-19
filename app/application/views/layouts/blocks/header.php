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
		<script>
			var siteurl = '<?php echo URL::to(); ?>';
			var current_url = '<?php echo URL::to(Request::uri()); ?>';
			var baseurl = '<?php echo URL::base(); ?>';
		</script>
		<?php echo Asset::styles(); ?>
		<?php echo Asset::scripts(); ?>
		<?php $wysiwyg = Config::get('application.editor');
			if (trim($wysiwyg['BasePage']) != '') {
				if (substr($wysiwyg['BasePage'], -2) == 'js') { echo '<script src="'.URL::base().$wysiwyg['BasePage'].'"></script>'; }
				if (substr($wysiwyg['BasePage'], -3) == 'php') { include $wysiwyg['BasePage']; }
			}
			$RepInstalled = false;
			if (file_exists("vendor/Reports/config.php")) { 
				$RepInstalled = true; 
				$Configurations = file("vendor/Reports/config.php"); 
				$ReportsConfig = explode(",",$Configurations[0]);
				foreach($ReportsConfig as $ind => $val ) { $ReportsConfig[$ind] = substr($val, 1, strlen($val)-2); }
			}

		?>
	</head>
<body>

	<iframe name="ContenuVariable" id="ContenuVariable" style="display:none; height:250px; width: 80%; left: 200px; position:absolute; background-color: #FFF; z-index:100;"></iframe>
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

			<a href="<?php echo URL::to(); ?>" class="logo" title="<?php echo  Config::get('application.my_bugs_app.name') ?>"><?php echo Config::get('application.my_bugs_app.name') ?></a>

			<ul class="nav">
				<li class="dashboard <?php echo $active == 'dashboard' ? 'active' : ''; ?>"><a href="<?php echo URL::to(); ?>"><?php echo __('tinyissue.dashboard');?></a></li>
				<li class="issues <?php echo $active == 'issues' ? 'active' : ''; ?>"><a href="<?php echo URL::to('user/issues'); ?>"><?php echo __('tinyissue.your_issues');?></a></li>
				<li class="todo <?php echo $active == 'todo' ? 'active' : ''; ?>"><a href="<?php echo URL::to('todo'); ?>"><?php echo __('tinyissue.your_todos');?></a></li>
				<li class="projects <?php echo $active == 'projects' ? 'active' : ''; ?>"><a href="<?php echo URL::to('projects'); ?>"><?php echo __('tinyissue.projects');?></a></li>
				<li><a href="<?php echo ($RepInstalled) ? 'http://127.0.0.1/'.$ReportsConfig[0].'/'.$ReportsConfig[1] : URL::to('projects/reports'); ?>" target="<?php echo ($RepInstalled) ? '_blank' : ''; ?>"><?php echo __('tinyissue.report');?></a></li>
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