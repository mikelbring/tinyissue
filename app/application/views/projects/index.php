<h3>
	<?php echo __('tinyissue.projects');?>
	<?php if(! Auth::guest()): ?>
	<span><?php echo __('tinyissue.projects_description');?></span>
	<?php else: ?>
	<span><?php echo __('tinyissue.projects_description_guest');?></span>
	<?php endif; ?>
</h3>

<div class="pad">

	<ul class="tabs">
		<li <?php echo $active == 'active' ? 'class="active"' : ''; ?>>
			<a href="<?php echo URL::to('projects'); ?>">
				<?php echo $active_count == 1 ? '1 '.__('tinyissue.active').' '.__('tinyissue.project') : $active_count . ' '.__('tinyissue.active').' '.__('tinyissue.projects'); ?>
			</a>
		</li>
		<li <?php echo $active == 'archived' ? 'class="active"' : ''; ?>>
			<a href="<?php echo URL::to('projects'); ?>?status=0">
				<?php echo $archived_count == 1 ? '1 '.__('tinyissue.archived').' '.__('tinyissue.project') : $archived_count . ' '.__('tinyissue.archived').' '.__('tinyissue.projects'); ?>
				</a>
		</li>
	</ul>

	<div class="inside-tabs">

		<div class="blue-box">

			<div class="inside-pad">
				<ul class="projects">
					<?php foreach($projects as $row):
						$issues = $row->issues()->where('status', '=', 1)->count();
					?>
					<li>
						<a href="<?php echo $row->to(); ?>"><?php echo $row->name; ?></a><br />
						<?php echo $issues == 1 ? '1 '. __('tinyissue.open_issue') : $issues . ' '. __('tinyissue.open_issues'); ?>
					</li>
					<?php endforeach; ?>

					<?php if(count($projects) == 0): ?>
					<li>
						<?php echo __('tinyissue.you_do_not_have_any_projects'); ?> <a href="<?php echo URL::to('projects/new'); ?>"><?php echo __('tinyissue.create_project'); ?></a>
					</li>
					<?php endif; ?>
				</ul>
				


			</div>

		</div>

	</div>

</div>
