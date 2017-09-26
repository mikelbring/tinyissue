<li id="comment<?php echo $activity->id; ?>" class="comment">

	<div class="insides">
		<div class="topbar">
			<label class="label warning"><?php echo __('tinyissue.label_reassigned'); ?></label> <?php echo __('tinyissue.to'); ?>
			<?php if($activity->action_id > 0): ?>
			<strong><?php echo $assigned->firstname . ' ' . $assigned->lastname; ?></strong>
			<?php else: ?>
			<strong><?php echo __('tinyissue.no_one'); ?></strong>
			<?php endif; ?>
			<?php echo __('tinyissue.by'); ?>
			<?php if($activity->user_id > 0): ?>
			<strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong>
			<?php else: ?>
			<strong><?php echo __('tinyissue.no_one'); ?></strong>
			<?php endif; ?>

			<span class="time">
				<?php echo date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->created_at)); ?>
			</span>
		</div>
	</div>

	<div class="clr"></div>
</li>
