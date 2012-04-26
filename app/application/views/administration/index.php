<h3>
	<?php echo __('tinyissue.administration'); ?>
	<span><?php echo __('tinyissue.administration_description'); ?></span>
</h3>

<div class="pad">

	<table class="table">
		<tr>
			<th><?php echo __('tinyissue.total_users'); ?></th>
			<td><?php echo $users; ?></td>
		</tr>
		<tr>
			<th><?php echo __('tinyissue.active_projects'); ?></th>
			<td><?php echo $active_projects; ?></td>
		</tr>
		<tr>
			<th><?php echo __('tinyissue.archived_projects'); ?></th>
			<td><?php echo $archived_projects; ?></td>
		</tr>
		<tr>
			<th><?php echo __('tinyissue.open_issues'); ?></th>
			<td><?php echo $issues['open']; ?></td>
		</tr>
		<tr>
			<th><?php echo __('tinyissue.closed_issues'); ?></th>
			<td><?php echo $issues['closed']; ?></td>
		</tr>
		<tr>
			<th>Tiny Issue <?php echo __('tinyissue.version'); ?></th>
			<td>v<?php echo Config::get('tinyissue.version'); ?></td>
		</tr>
		<tr>
			<th><?php echo __('tinyissue.version_release_date'); ?></th>
			<td><?php echo $release_date = Config::get('tinyissue.release_date'); ?></td>
		</tr>
	</table>

</div>
