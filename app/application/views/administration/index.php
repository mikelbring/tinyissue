<h3>
	Administration
	<span>Global application statistics</span>
</h3>

<div class="pad">

	<table class="table">
		<tr>
			<th>Total Users</th>
			<td><?php echo $users; ?></td>
		</tr>
		<tr>
			<th>Active Projects</th>
			<td><?php echo $active_projects; ?></td>
		</tr>
		<tr>
			<th>Archived Projects</th>
			<td><?php echo $archived_projects; ?></td>
		</tr>
		<tr>
			<th>Open Issues</th>
			<td><?php echo $issues['open']; ?></td>
		</tr>
		<tr>
			<th>Closed Issues</th>
			<td><?php echo $issues['closed']; ?></td>
		</tr>
		<tr>
			<th>Tiny Issue Version</th>
			<td>v<?php echo Config::get('tinyissue.version'); ?></td>
		</tr>
		<tr>
			<th>Version Release Date</th>
			<td><?php echo $release_date = Config::get('tinyissue.release_date'); ?></td>
		</tr>
	</table>

</div>
