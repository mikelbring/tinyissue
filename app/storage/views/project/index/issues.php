<div class="blue-box">
	<div class="inside-pad">

		<?php if(!$issues): ?>
		<p>This project does not have any issues!</p>
		<?php else: ?>
		<ul class="issues">
			<?php foreach($issues as $row):  ?>
			<li>
				<a href="" class="comments"><?php echo $row->comments()->count(); ?></a>
				<a href="" class="id">#<?php echo $row->id; ?></a>
				<div class="data">
					<a href="<?php echo $row->to(); ?>"><?php echo $row->title; ?></a>
					<div class="info">
						Created by
						<strong><?php echo $row->user->firstname . ' ' . $row->user->lastname; ?></strong>
						<?php echo Time::age(strtotime($row->created_at)); ?>

						<?php if(!is_null($row->updated_by)): ?>
						- Updated by <strong><?php echo $row->updated->firstname . ' ' . $row->updated->lastname; ?></strong>
						<?php echo Time::age(strtotime($row->updated_at)); ?>
						<?php endif; ?>
					</div>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>

	</div>
</div>