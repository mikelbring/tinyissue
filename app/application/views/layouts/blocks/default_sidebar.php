<h2>
	<?php if(Auth::user()->permission('project-create')): ?>
	<a href="<?php echo URL::to('projects/new'); ?>" class="add" title="New Project"><?php __('tinyissue.new'); ?></a>
	<?php endif; ?>
	<?php echo __('tinyissue.active_projects');?>
	<span><?php echo __('tinyissue.active_projects_description');?></span>
</h2>

<ul>
	<?php foreach(Project\User::active_projects() as $row): ?>

	<li>
		<a href="<?php echo $row->to(); ?>"><?php echo $row->name; ?> <span class="info-open-issues" title="Number of Open Tickets">(<?php echo $row->count_open_issues() ?>)</span></a>
	</li>
	<?php endforeach ?>
</ul>