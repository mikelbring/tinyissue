<li id="comment<?php echo $activity->id; ?>" class="comment">
    <div class="insides">
        <div class="topbar">

            <div class="data">
                <label class="label success"><?php echo trans('tinyissue.label_closed'); ?></label> <?php echo trans('tinyissue.by'); ?> <strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong>
                <span class="time">
                    <?php echo date('F jS \a\t g:i A', strtotime($activity->created_at)); ?>
                </span>
                <?php if(Project\Issue::current()->status == 0): ?>
                <a href="<?php echo Project\Issue::current()->to('status?status=1'); ?>" class="button success"><?php echo trans('tinyissue.reopen'); ?></a>
                <?php endif;?>
        </div>
    </div>
</li>
