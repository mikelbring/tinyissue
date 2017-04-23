<h3>
	<?php echo __('tinyissue.administration'); ?>
	<span><?php echo __('tinyissue.administration_description'); ?></span>
</h3>

<div class="pad">

	<table class="table">
		<tr>
			<th><a href="administration/users"><?php echo __('tinyissue.total_users'); ?></a></th>
			<td><?php echo $users; ?></td>
		</tr>
		<tr>
			<th><a href="projects"><?php echo ($active_projects < 2) ? __('tinyissue.active_project') : __('tinyissue.active_projects'); ?></a></th>
			<td><?php echo ($active_projects == 0) ? __('tinyissue.no_one') : $active_projects; ?></td>
		</tr>
		<tr>
			<th><a href="projects?status=0"><?php echo ($archived_projects < 2) ? __('tinyissue.archived_project') : __('tinyissue.archived_projects'); ?></a></th>
			<td><?php echo ($archived_projects == 0) ? __('tinyissue.no_one') : $archived_projects; ?></td>
		</tr>

		<tr>
			<th><a href="<?php echo URL::to('tags'); ?>"><?php echo __('tinyissue.tags'); ?></a></th>
			<td><?php echo $tags; ?></td>
		</tr>
		<tr>
			<th><?php echo __('tinyissue.open_issues'); ?></th>
			<td><?php echo $issues['open']; ?></td>
		</tr>
		<tr>
			<th><?php echo __('tinyissue.closed_issues'); ?></th>
			<td><?php echo $issues['closed']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<th>Tiny Issue <?php echo __('tinyissue.version'); ?></th>
			<td>
			<?php
					$project_status = \DB::table('update_history')->where('Description', 'LIKE', 'Version%')->order_by('DteRelease','DESC')->get();
					echo $project_status[0]->description;
				?>
			</td>
			<td rowspan="2" style="min-width: 150px; padding-left: 100px;"><br /><?php echo __('tinyissue.let_update_it'); ?></td>
		</tr>
		<tr>
			<th><?php echo __('tinyissue.version_release_date'); ?></th>
			<td><?php echo substr($project_status[0]->dterelease, 0, 10); ?></td>
		</tr>
	</table>
</div>
