<div class="blue-box">
	<div class="inside-pad">

		<?php if(!$issues): ?>
		<p><?php echo __('tinyissue.no_issues'); ?></p>
		<?php else: ?>
		<ul class="issues">
			<?php foreach($issues as $row):  ?>
			<li>
				<a href="" class="comments"><?php echo $row->comment_count(); ?></a>
				<a href="" class="id">#<?php echo $row->id; ?></a>
				<div class="data">
					<a href="<?php echo $row->to(); ?>"><?php echo $row->title; ?></a>
					<div class="info">
						<?php echo __('tinyissue.created_by'); ?>
				                <?php if($row->user->private): ?>
				                <strong><?php echo __('tinyissue.anonymous'); ?></strong>
				                <?php else: ?>
						<strong><?php echo $row->user->firstname . ' ' . $row->user->lastname; ?></strong>
						<?php endif; ?>
						<?php echo Time::age(strtotime($row->created_at)); ?>

						<?php if(!is_null($row->updated_by)): ?>
						- <?php __('tinyissue.updated_by'); ?> 
				                <?php if($row->user->private): ?>
				                <strong><?php echo __('tinyissue.anonymous'); ?></strong>
				                <?php else: ?>
						<strong><?php echo $row->updated->firstname . ' ' . $row->updated->lastname; ?></strong>
						<?php endif; ?>
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
