<h3>
    <?php echo trans('tinyissue.administration'); ?>
    <span><?php echo trans('tinyissue.administration_description'); ?></span>
</h3>

<div class="pad">

    <table class="table">
        <tr>
            <th><?php echo trans('tinyissue.total_users'); ?></th>
            <td><?php echo $users; ?></td>
        </tr>
        <tr>
            <th><?php echo trans('tinyissue.active_projects'); ?></th>
            <td><?php echo $active_projects; ?></td>
        </tr>
        <tr>
            <th><?php echo trans('tinyissue.archived_projects'); ?></th>
            <td><?php echo $archived_projects; ?></td>
        </tr>
        <tr>
            <th><?php echo trans('tinyissue.open_issues'); ?></th>
            <td><?php echo $issues['open']; ?></td>
        </tr>
        <tr>
            <th><?php echo trans('tinyissue.closed_issues'); ?></th>
            <td><?php echo $issues['closed']; ?></td>
        </tr>
        <tr>
            <th>Tiny Issue <?php echo trans('tinyissue.version'); ?></th>
            <td>v<?php echo Config::get('tinyissue.version'); ?></td>
        </tr>
        <tr>
            <th><?php echo trans('tinyissue.version_release_date'); ?></th>
            <td><?php echo $release_date = Config::get('tinyissue.release_date'); ?></td>
        </tr>
    </table>

</div>
