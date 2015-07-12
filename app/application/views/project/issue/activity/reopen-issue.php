<li id="comment<?php echo $activity->id; ?>" class="comment">
	<div class="insides">
		<div class="topbar">

			<div class="data">
				<label class="label important"><?php echo __('tinyissue.label_reopened'); ?></label> <?php echo __('tinyissue.to'); ?> <strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong> 
				<span class="time">
					<?php echo date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->created_at)); ?>
				</span>		
		</div>
	</div>
</li>
