<div class="blue-box">
    <div class="inside-pad">
        <?php if ( ! $issues): ?>
            <p><?php echo trans('tinyissue.no_issues'); ?></p>
        <?php else: ?>
        <ul class="issues">
            <?php foreach ($issues as $row):  ?>
            <li>
                <a href="" class="comments"><?php echo $row->comment_count(); ?></a>
                <a href="" class="id">#<?php echo $row->id; ?></a>
                <div class="data">
                    <a href="<?php echo $row->to(); ?>"><?php echo $row->title; ?></a>
                    <div class="info">
                        <?php echo trans('tinyissue.created_by'); ?>
                        <strong><?php echo $row->user->firstname . ' ' . $row->user->lastname; ?></strong>
                        <?php echo Tinyissue\Views\Time::age(strtotime($row->created_at)); ?>
                        <?php if ( ! is_null($row->updated_by)): ?>
                            - <?php trans('tinyissue.updated_by'); ?> <strong><?php echo $row->userUpdated->firstname . ' ' . $row->userUpdated->lastname; ?></strong>
                            <?php echo Tinyissue\Views\Time::age(strtotime($row->updated_at)); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</div>
