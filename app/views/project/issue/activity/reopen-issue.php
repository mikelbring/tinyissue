<li id="comment<?php echo $activity->id; ?>" class="comment">
    <div class="insides">
        <div class="topbar">

            <div class="data">
                <label class="label important"><?php echo trans('tinyissue.label_reopened'); ?></label> <?php echo trans('tinyissue.to'); ?> <strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong>
                <span class="time">
                    <?php echo date('F jS \a\t g:i A', strtotime($activity->created_at)); ?>
                </span>
        </div>
    </div>
</li>
