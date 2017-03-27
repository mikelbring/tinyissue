<li onclick="window.location='<?php echo $issue->to(); ?>';">

	<div class="tag">
		<label class="label warning"><?php echo __('tinyissue.tag_has_been_updated'); ?></label>
	</div>

	<div class="data">
		<a href="<?php echo $issue->to(); ?>"><?php echo $issue->title; ?></a> <?php echo __('tinyissue.tag_added'); ?>
		<a href="<?php echo $issue->to(); ?>"><?php echo $issue->title; ?></a> <?php echo __('tinyissue.tag_removed'); ?>
		<?php if($activity->action_id > 0): ?>
		<strong><?php echo $assigned->firstname . ' ' . $assigned->lastname; ?></strong>
		<?php else: ?>
		<strong><?php echo __('tinyissue.no_one'); ?></strong>
		<?php endif; ?>
		<?php echo __('tinyissue.by'); ?>
		<strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong>

		<span class="time">
			<?php echo date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->created_at)); ?>
		</span>
	</div>

	<div class="clr"></div>
</li>
