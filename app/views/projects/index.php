<h3>
    <?php echo trans('tinyissue.projects');?>
    <span><?php echo trans('tinyissue.projects_description');?></span>
</h3>

<div class="pad">

    <ul class="tabs">
        <li <?php echo $active == 'active' ? 'class="active"' : ''; ?>>
            <a href="<?php echo URL::to('projects'); ?>">
                <?php echo $active_count == 1 ? '1 '.trans('tinyissue.active').' '.trans('tinyissue.project') : $active_count . ' '.trans('tinyissue.active').' '.trans('tinyissue.projects'); ?>
            </a>
        </li>
        <li <?php echo $active == 'archived' ? 'class="active"' : ''; ?>>
            <a href="<?php echo URL::to('projects'); ?>?status=0">
                <?php echo $archived_count == 1 ? '1 '.trans('tinyissue.archived').' '.trans('tinyissue.project') : $archived_count . ' '.trans('tinyissue.archived').' '.trans('tinyissue.projects'); ?>
                </a>
        </li>
    </ul>

    <div class="inside-tabs">

        <div class="blue-box">

            <div class="inside-pad">
                <ul class="projects">
                    <?php foreach($projects as $row):
                        $issues = $row->issues()->where('status', '=', 1)->count();
                    ?>
                    <li>
                        <a href="<?php echo $row->to(); ?>"><?php echo $row->name; ?></a><br />
                        <?php echo $issues == 1 ? '1 '. trans('tinyissue.open_issue') : $issues . ' '. trans('tinyissue.open_issues'); ?>
                    </li>
                    <?php endforeach; ?>

                    <?php if(count($projects) == 0): ?>
                    <li>
                        <?php echo trans('tinyissue.you_do_not_have_any_projects'); ?> <a href="<?php echo URL::to('projects/new'); ?>"><?php echo trans('tinyissue.create_project'); ?></a>
                    </li>
                    <?php endif; ?>
                </ul>



            </div>

        </div>

    </div>

</div>
