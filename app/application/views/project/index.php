<h3>
   <a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue"><?php echo __('tinyissue.new_issue');?></a>
   <a href="<?php echo Project::current()->to(); ?>"><?php echo Project::current()->name; ?></a>
	<span><?php echo __('tinyissue.project_overview');?></span>
</h3>

<div class="pad">

	<ul class="tabs">
		<li <?php echo $active == 'activity' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to(); ?>"><?php echo __('tinyissue.activity');?></a>
		</li>
		<li <?php echo $active == 'open' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to('issues'); ?>">
			<?php echo $open_count == 1 ? '1 '.__('tinyissue.open_issue') : $open_count . ' '.__('tinyissue.open_issues'); ?>
			</a>
		</li>
		<li <?php echo $active == 'closed' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to('issues'); ?>?status=0">
			<?php echo $closed_count == 1 ? '1 '.__('tinyissue.closed_issue') : $closed_count . ' '.__('tinyissue.closed_issues'); ?>
			</a>
		</li>
		<li <?php echo $active == 'assigned' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to('assigned'); ?>?status=1">
			<?php echo $assigned_count == 1 ? '1 '.__('tinyissue.issue_assigned_to_you') : $assigned_count . ' '.__('tinyissue.issues_assigned_to_you'); ?>
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