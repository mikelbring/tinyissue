<h2>
	<?php if(Auth::user()->permission('project-create')): ?>
	<a href="<?php echo URL::to('projects/new'); ?>" class="add" title="New Project">New</a>
	<?php endif; ?>
	Active Projects
	<span>Quick list of your active projects</span>
</h2>

<ul>
	<?php foreach(Project\User::active_projects() as $row): ?>
	<li>
		<a href="<?php echo $row->to(); ?>"><?php echo $row->name; ?></a>
	</li>
	<?php endforeach ?>
</ul>