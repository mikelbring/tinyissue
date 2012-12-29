<li onclick="window.location='<?php echo $issue->to(); ?>';">

	<div class="tag">
		<label class="label warning">Reassigned</label>
	</div>

	<div class="data">
		<a href="<?php echo $issue->to(); ?>"><?php echo $issue->title; ?></a> was reassigned to
		<?php if($activity->action_id > 0): ?>
		<strong><?php echo $assigned->firstname . ' ' . $assigned->lastname; ?></strong>
		<?php else: ?>
		<strong>No one</strong>
		<?php endif; ?>
		by
		<strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong>

		<span class="time">
			<?php echo date(Config::get('application.time_format'), strtotime($activity->created_at)); ?>
		</span>
	</div>

	<div class="clr"></div>
</li>