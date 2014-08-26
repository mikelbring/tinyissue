<li id="comment<?php echo $activity->id; ?>" class="comment">
	<div class="insides">
		<div class="topbar">
			<div class="data">
				<?php if($tag_counts['added'] > 0): ?>
				<?php foreach($tag_diff['added_tags'] as $tag): ?>
					<?php echo '<label class="label"' . ($tag_diff['tag_data'][$tag]['bgcolor'] ? ' style="background: ' . $tag_diff['tag_data'][$tag]['bgcolor'] . '"' : '') . '>' . $tag_diff['tag_data'][$tag]['tag'] . '</label>'; ?>
				<?php endforeach; ?>
				<?php echo __($tag_counts['added'] > 1 ? 'tinyissue.tags_added' : 'tinyissue.tag_added'); ?>
				<?php echo __('tinyissue.by'); ?>
				<strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong>
				<span class="time">
					<?php echo date('F jS \a\t g:i A', strtotime($activity->created_at)); ?>
				</span>
				<?php endif; ?>
				
				<?php if($tag_counts['added'] > 0 && $tag_counts['removed'] > 0): ?><div class="tag-activity-spacer"></div><?php endif; ?>
								
				<?php if($tag_counts['removed'] > 0): ?>
				<?php foreach($tag_diff['removed_tags'] as $tag): ?>
					<?php echo '<label class="label"' . ($tag_diff['tag_data'][$tag]['bgcolor'] ? ' style="background: ' . $tag_diff['tag_data'][$tag]['bgcolor'] . '"' : '') . '>' . $tag_diff['tag_data'][$tag]['tag'] . '</label>'; ?>
				<?php endforeach; ?>
				<?php echo __($tag_counts['removed'] > 1 ? 'tinyissue.tags_removed' : 'tinyissue.tag_removed'); ?>
				<?php echo __('tinyissue.by'); ?>
				<strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong>
				<span class="time">
					<?php echo date('F jS \a\t g:i A', strtotime($activity->created_at)); ?>
				</span>
				<?php endif; ?>

			</div>
	</div>
</li>