<h3>
	<?php echo __('tinyissue.your_issues'); ?>
	<span><?php echo __('tinyissue.your_issues_description'); ?></span>
</h3>

<div class="pad">

	<?php foreach($projects as $project): ?>

	<div class="blue-box">
		<div class="inside-pad">

			<h4><a href="<?php echo $project['detail']->to(); ?>"><?php echo $project['detail']->name; ?></a></h4>

			<ul class="issues">
				<?php foreach($project['issues'] as $row):  ?>
				<li>
					<a href="#" class="todo-button add" id="issue-id-<?php echo $row->id; ?>" data-issue-id="<?php echo $row->id; ?>" title="<?php echo __('tinyissue.todos_add'); ?>">[+]</a>
					<a href="<?php echo $row->to(); ?>" class="comments"><?php echo $row->comment_count(); ?></a>
					
					<?php if(!empty($row->tags)): ?>
					<div class="tags">
						<?php foreach($row->tags()->order_by('tag', 'ASC')->get() as $tag): ?>
						<?php echo '<label class="label"' . ($tag->bgcolor ? ' style="background: ' . $tag->bgcolor . '"' : '') . '>' . $tag->tag . '</label>'; ?>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>

					<a href="<?php echo $row->to(); ?>" class="id">#<?php echo $row->id; ?></a>
					<div class="data">
						<a href="<?php echo $row->to(); ?>"><?php echo $row->title; ?></a>
						<div class="info">
							<?php echo __('tinyissue.created_by'); ?>
							<strong><?php echo $row->user->firstname . ' ' . $row->user->lastname; ?></strong>
							<?php echo Time::age(strtotime($row->created_at)); ?>

							<?php if(!is_null($row->updated_by)): ?>
							- <?php echo __('tinyissue.updated_by'); ?> <strong><?php echo $row->updated->firstname . ' ' . $row->updated->lastname; ?></strong>
							<?php echo Time::age(strtotime($row->updated_at)); ?>
							<?php endif; ?>
						</div>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>

		</div>
	</div>

	<?php endforeach; ?>

</div>