<li id="comment<?php echo $activity->id; ?>" class="comment">

    <div class="insides">
        <div class="topbar">
            <label class="label warning"><?php echo trans('tinyissue.label_reassigned'); ?></label> <?php echo trans('tinyissue.to'); ?>
            <?php if($activity->action_id > 0): ?>
            <strong><?php echo $assigned->firstname . ' ' . $assigned->lastname; ?></strong>
            <?php else: ?>
            <strong><?php echo trans('tinyissue.no_one'); ?>/strong>
            <?php endif; ?>
            by
            <strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong>

            <span class="time">
                <?php echo date('F jS \a\t g:i A', strtotime($activity->created_at)); ?>
            </span>
        </div>

    <div class="clr"></div>
</li>
