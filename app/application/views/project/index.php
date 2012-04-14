<h3>
   <a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue">New Issue</a>
   <a href="<?php echo Project::current()->to(); ?>"><?php echo Project::current()->name; ?></a>
	<span>Project Overview</span>
</h3>

<div class="pad">

	<ul class="tabs">
		<li <?php echo $active == 'activity' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to(); ?>">Activity</a>
		</li>
		<li <?php echo $active == 'open' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to('issues'); ?>">
			<?php echo $open_count == 1 ? '1 Open Issue' : $open_count . ' Open Issues'; ?>
			</a>
		</li>
		<li <?php echo $active == 'closed' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to('issues'); ?>?status=0">
			<?php echo $closed_count == 1 ? '1 Closed Issue' : $closed_count . ' Closed Issues'; ?>
			</a>
		</li>
		<li <?php echo $active == 'assigned' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to('assigned'); ?>?status=1">
			<?php echo $assigned_count == 1 ? '1 Issue Assigned to you' : $assigned_count . ' Issues assigned to you'; ?>
			</a>
		</li>
		<li <?php echo $active == "export" ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to('export'); ?>">export</a>
		</li> 
	</ul>

	<div class="inside-tabs">
		<?php echo $page; ?>
	</div>


</div>