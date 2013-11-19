<?php if(! Auth::guest()): ?>
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
		<a href="<?php echo $row->to(); ?>"><?php echo $row->name; ?></a>
	</li>
	<?php endforeach ?>
</ul>
<?php else: ?>
<h2>
	<?php echo __('tinyissue.active_users');?>
	<span><?php echo __('tinyissue.active_users_description');?></span>
</h2>

<ul>
	<?php foreach(User::public_users() as $row): ?>
	<li>
		<h3>
			<?php echo $row->firstname; echo "&nbsp;"; echo $row->lastname; ?>
			<span>34 Open, 13 Closed</span>
		</h3>
	</li>
	<?php endforeach ?>
</ul>
<?php endif; ?>
