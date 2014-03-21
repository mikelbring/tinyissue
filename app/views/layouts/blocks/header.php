<div id="container">
    <div id="header">
        <ul class="nav-right">
            <li><?php echo trans('tinyissue.welcome');?>, <a href="<?php echo URL::to('user/settings'); ?>" class="user"><?php echo Auth::user()->firstname; ?></a></li>
            <?php if (Auth::user()->permission('administration')): ?>
                <li><a href="<?php echo URL::to('administration/users'); ?>"><?php echo trans('tinyissue.users');?></a></li>
                <li><a href="<?php echo URL::to('administration'); ?>"><?php echo trans('tinyissue.administration');?></a></li>
            <?php endif; ?>
            <li class="logout"><a href="<?php echo URL::to('user/logout'); ?>"><?php echo trans('tinyissue.logout');?></a></li>
        </ul>
        <a href="<?php echo URL::current(); ?>" class="logo">Tiny Issue</a>
        <ul class="nav">
            <li class="dashboard <?php echo $active == 'dashboard' ? 'active' : ''; ?>"><a href="<?php echo URL::to('/'); ?>"><?php echo trans('tinyissue.dashboard');?></a></li>
            <li class="issues <?php echo $active == 'issues' ? 'active' : ''; ?>"><a href="<?php echo URL::to('user/issues'); ?>"><?php echo trans('tinyissue.your_issues');?></a></li>
            <li class="projects <?php echo $active == 'projects' ? 'active' : ''; ?>"><a href="<?php echo URL::to('projects'); ?>"><?php echo trans('tinyissue.projects');?></a></li>
            <li class="settings <?php echo $active == 'settings' ? 'active' : ''; ?>"><a href="<?php echo URL::to('user/settings'); ?>"><?php echo trans('tinyissue.settings');?></a></li>
        </ul>
    </div>
    <div id="main">
        <div id="sidebar">
            <div class="inside">
                <?php echo $sidebar; ?>
            </div>
        </div>
        <div id="content">
            <div class="inside">
