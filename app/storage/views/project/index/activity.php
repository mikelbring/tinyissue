<div class="blue-box">
	<div class="inside-pad">

		<?php if(!$activity): ?>
		<p>
			This project does not have any activity!
		</p>
		<?php else: ?>
		<ul class="activity">
			<?php foreach($project->activity(10) as $activity): ?>
			<?php echo $activity; ?>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>

	</div>
</div>
