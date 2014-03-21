<h2>
    <?php if (Auth::user()->permission('project-create')): ?>
        <a href="<?php echo URL::to('projects/new'); ?>" class="add" title="New Project"><?php trans('tinyissue.new'); ?></a>
    <?php endif; ?>
    <?php echo trans('tinyissue.active_projects');?>
    <span><?php echo trans('tinyissue.active_projects_description');?></span>
</h2>

<ul>
    <?php foreach (Project\User::activeProjects(Auth::user()) as $row): ?>
    <li>
        <a href="<?php echo $row->to(); ?>"><?php echo $row->name; ?></a>
    </li>
    <?php endforeach ?>
</ul>
