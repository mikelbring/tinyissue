<li onclick="window.location='<?php echo $issue->to(); ?>';">

	<div class="tag">
		<label class="label success"><?php echo __('tinyissue.label_closed'); ?></label>
	</div>

	<div class="data">
		<a href="<?php echo $issue->to(); ?>"><?php echo $issue->title; ?></a> <?php echo __('tinyissue.was_closed_by'); ?> <strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong>
		<span class="time">
			<?php echo date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->created_at)); ?>
		</span>
	</div>

	<div class="clr"></div>
</li>
