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
			<td><?php echo Config::get('tinyissue.version'); ?></td>
		</tr>
		<tr>
			<th>Version Release Date</th>
			<td><?php echo $release_date = Config::get('tinyissue.release_date'); ?></td>
		</tr>

		<?php if($newest_version !== false && strtotime($release_date) < strtotime(date('m-d-Y', $newest_version->released_at))): ?>
		<tr>
			<th style="color: red;">Newest Release</th>
			<td style="color: red;">
				<?php echo $newest_version->name; ?>
				(<?php echo date('m-d-Y', strtotime($newest_version->released_at)); ?>)
			</td>
		</tr>
		<?php endif; ?>
	</table>
	
	<p style="margin-top: 25px;">
		<a href="https://secure.realizetheweb.com/download/tinyissue">Check for updates on Tiny Issue Download Portal</a>
	</p>

</div>
