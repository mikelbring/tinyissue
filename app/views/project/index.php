<h3>
   <a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue"><?php echo trans('tinyissue.new_issue');?></a>
   <a href="<?php echo Project::current()->to(); ?>"><?php echo Project::current()->name; ?></a>
    <span><?php echo trans('tinyissue.project_overview');?></span>
</h3>
<div class="pad">
    <ul class="tabs">
        <li <?php echo $active == 'activity' ? 'class="active"' : ''; ?>>
            <a href="<?php echo Project::current()->to(); ?>"><?php echo trans('tinyissue.activity');?></a>
        </li>
        <li <?php echo $active == 'open' ? 'class="active"' : ''; ?>>
            <a href="<?php echo Project::current()->to('issues'); ?>">
            <?php echo $open_count == 1 ? '1 ' . trans('tinyissue.open_issue') : $open_count . ' ' . trans('tinyissue.open_issues'); ?>
            </a>
        </li>
        <li <?php echo $active == 'closed' ? 'class="active"' : ''; ?>>
            <a href="<?php echo Project::current()->to('issues'); ?>?status=0">
            <?php echo $closed_count == 1 ? '1 ' . trans('tinyissue.closed_issue') : $closed_count . ' ' . trans('tinyissue.closed_issues'); ?>
            </a>
        </li>
        <li <?php echo $active == 'assigned' ? 'class="active"' : ''; ?>>
            <a href="<?php echo Project::current()->to('assigned'); ?>?status=1">
            <?php echo $assigned_count == 1 ? '1 ' . trans('tinyissue.issue_assigned_to_you') : $assigned_count . ' ' . trans('tinyissue.issues_assigned_to_you'); ?>
            </a>
        </li>
    </ul>
    <div class="inside-tabs">
        <?php echo $page; ?>
    </div>
</div>
