
<h2>
	<?php if(Auth::user()->permission('project-modify')): ?>
	<a href="<?php echo Project::current()->to('edit'); ?>" class="edit"><?php echo __('tinyissue.edit');?></a>
	<?php endif; ?>

	<?php echo HTML::link(Project::current()->to(), Project::current()->name); ?>
	<span><?php echo __('tinyissue.assign_users_and_edit_the_project');?></span>
</h2>

<ul>
	<li><a href="<?php echo Project::current()->to('issues'); ?>"><?php echo Project::current()->count_open_issues(); ?> <?php echo __('tinyissue.open_issues');?></a></li>
	<li><a href="<?php echo Project::current()->to('issues'); ?>?tags=status:closed"><?php echo Project::current()->count_closed_issues(); ?> <?php echo __('tinyissue.closed_issues');?></a></li>
</ul>

<h2>
	<?php echo __('tinyissue.assigned_users');?>
	<span><?php echo __('tinyissue.assigned_users_description');?></span>
</h2>

<ul class="sidebar-users">
<?php foreach(Project::current()->users()->get() as $row): ?>

	<li id="project-user<?php echo $row->id; ?>">
		<?php if(Auth::user()->permission('project-modify')): ?>
		<a href="javascript:void(0);" onclick="remove_project_user(<?php echo $row->id; ?>, <?php echo Project::current()->id; ?>);" class="delete"><?php echo __('tinyissue.remove');?></a>
		<?php endif; ?>
		<?php echo $row->firstname . ' ' . $row->lastname; ?>
	</li>
<?php endforeach; ?>
</ul>

<?php if(Auth::user()->permission('project-modify')): ?>

	<input type="text" id="add-user-project" placeholder="<?php echo __('tinyissue.assign_a_user');?>" onmouseover="init_sidebar_autocomplete(<?php echo Project::current()->id; ?>);" />

<?php endif; ?>
