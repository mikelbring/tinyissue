<li id="comment<?php echo $activity->id; ?>" class="comment">

	<div class="insides">
		<div class="topbar">
			<label class="label warning">Reassigned</label> to
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
