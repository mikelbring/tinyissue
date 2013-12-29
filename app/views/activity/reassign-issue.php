<li onclick="window.location='<?php echo $issue->to(); ?>';">

    <div class="tag">
        <label class="label warning"><?php echo trans('tinyissue.label_reassigned'); ?></label>
    </div>

    <div class="data">
        <a href="<?php echo $issue->to(); ?>"><?php echo $issue->title; ?></a> <?php echo trans('tinyissue.was_reassigned_to'); ?>
        <?php if($activity->action_id > 0): ?>
        <strong><?php echo $assigned->firstname . ' ' . $assigned->lastname; ?></strong>
        <?php else: ?>
        <strong><?php echo trans('tinyissue.no_one'); ?></strong>
        <?php endif; ?>
        <?php echo trans('tinyissue.by'); ?>
        <strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong>

        <span class="time">
            <?php echo date('F jS \a\t g:i A', strtotime($activity->created_at)); ?>
        </span>
    </div>

    <div class="clr"></div>
</li>
