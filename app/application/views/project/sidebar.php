
<h2>
	<?php if(Auth::user()->permission('project-modify')): ?>
	<a href="<?php echo Project::current()->to('edit'); ?>" class="edit">Edit</a>
	<?php endif; ?>

	<?php echo HTML::link(Project::current()->to(), Project::current()->name); ?>
	<span>Assign users and edit the project</span>
</h2>

<ul>
	<li><a href="<?php echo Project::current()->to('issues'); ?>"><?php echo Project::current()->issues()->where('status', '=', 1)->count(); ?> Open Issues</a></li>
	<li><a href="<?php echo Project::current()->to('issues'); ?>?status=0"><?php echo Project::current()->issues()->where('status', '=', 0)->count(); ?> Closed Issues</a></li>
</ul>

<h2>
	Assigned Users
	<span>Users assigned to this project</span>
</h2>

<ul class="sidebar-users">
<?php foreach(Project::current()->users()->get() as $row): ?>

	<li id="project-user<?php echo $row->id; ?>">
		<?php if(Auth::user()->permission('project-modify')): ?>
		<a href="javascript:void(0);" onclick="remove_project_user(<?php echo $row->id; ?>, <?php echo Project::current()->id; ?>);" class="delete">Remove</a>
		<?php endif; ?>
		<?php echo $row->firstname . ' ' . $row->lastname; ?>
	</li>
<?php endforeach; ?>
</ul>

<?php if(Auth::user()->permission('project-modify')): ?>

	<input type="text" id="add-user-project" placeholder="Assign a user" onmouseover="init_sidebar_autocomplete(<?php echo Project::current()->id; ?>);" />

<?php endif; ?>
