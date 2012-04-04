<h3>
	Projects
	<span>List of all your projects</span>
</h3>

<div class="pad">

	<ul class="tabs">
		<li <?php echo $active == 'active' ? 'class="active"' : ''; ?>>
			<a href="<?php echo URL::to('projects'); ?>">
				<?php echo $active_count == 1 ? '1 Active Project' : $active_count . ' Active Projects'; ?>
			</a>
		</li>
		<li <?php echo $active == 'archived' ? 'class="active"' : ''; ?>>
			<a href="<?php echo URL::to('projects'); ?>?status=0">
				<?php echo $archived_count == 1 ? '1 Archived Project' : $archived_count . ' Archived Projects'; ?>
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
						<?php echo $issues == 1 ? '1 Open Issue' : $issues . ' Open Issues'; ?>
					</li>
					<?php endforeach; ?>

					<?php if(count($projects) == 0): ?>
					<li>
						You do not have any projects. <a href="<?php echo URL::to('projects/new'); ?>">Create a new project!</a>
					</li>
					<?php endif; ?>
				</ul>
				


			</div>

		</div>

	</div>

</div>
