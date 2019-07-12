<h3>
	<?php echo __('tinyissue.administration'); ?>
	<span><?php echo __('tinyissue.administration_description'); ?></span>
</h3>

<div class="pad">

	<table class="table">
		<tr>
			<th style="border-top: 1px solid #ddd;"><a href="administration/users"><?php echo __('tinyissue.total_users'); ?></a></th>
			<td style="border-top: 1px solid #ddd;"><b><?php echo $users; ?></b></td>
		</tr>
		<tr>
			<th><a href="<?php echo URL::to('roles'); ?>"><?php echo __('tinyissue.role'); ?>s</a></th>
			<td><b><?php echo @$roles; ?></b></td>
		</tr>
		<tr>
			<th><a href="projects"><?php echo __('tinyissue.projects'); ?></a>
			<div class="adminListe">
				<a href="projects"><?php echo ($active_projects < 2) ? __('tinyissue.active_project') : __('tinyissue.active_projects'); ?></a><br />
				<a href="projects?status=0"><?php echo ($archived_projects < 2) ? __('tinyissue.archived_project') : __('tinyissue.archived_projects'); ?></a><br />
			</div>			
			</th>
			<td>
				<b><?php echo ($active_projects + $archived_projects); ?></b><br />
				<?php echo ($active_projects == 0) ? __('tinyissue.no_one') : $active_projects; ?><br />
				<?php echo ($archived_projects == 0) ? __('tinyissue.no_one') : $archived_projects; ?><br />
			</td>
		</tr>
		<tr>
		</tr>
		
		<tr>
			<th><a href="<?php echo URL::to('tags'); ?>"><?php echo __('tinyissue.tags'); ?></a></th>
			<td><b><?php echo $tags; ?></b></td>
		</tr>
		<tr>
			<th><?php echo __('tinyissue.issues'); ?>
				<div class="adminListe">
					<?php echo __('tinyissue.open_issues'); ?><br />
					<?php echo __('tinyissue.closed_issues'); ?><br />
				</div>
			</th>
			<td><b><?php echo ($issues['open']+$issues['closed']); ?></b><br />
			<?php echo $issues['open']; ?><br />
			<?php echo $issues['closed']; ?><br />
			</td>
		</tr>
		<tr>
			<th><?php echo __('tinyissue.version'); ?>
				<div class="adminListe">
				<?php echo __('tinyissue.version'); ?><br />
				<?php echo __('tinyissue.version_release_numb'); ?><br />
				<?php echo __('tinyissue.version_release_date'); ?><br />
				</div>
			</th>
			<td>
				<b><?php echo Config::get('tinyissue.version').Config::get('tinyissue.release'); ?></b><br />
				<?php echo Config::get('tinyissue.version'); ?><br />
				<?php echo Config::get('tinyissue.release'); ?><br />
				<?php echo $release_date = Config::get('tinyissue.release_date'); ?><br />
			</td>
		</tr>
	</table>

</div>
<div class="pad2">
	<?php
		include "../app/application/libraries/checkVersion.php";
		echo '<h4>'.__('tinyissue.version_check').' : ';
			if ($verActu == $verNum) {
				echo __('tinyissue.version_good').'!';
				echo '<br /></h4>';
			} else if ($verNum == 0) {
				echo __('tinyissue.version_offline');
				echo '<br /></h4>';
				echo '<a href="https://github.com/pixeline/bugs/" target="_blank">https://github.com/pixeline/bugs/</a>';
			} else {
				echo '<a href="javascript: agissons.submit();">'.__('tinyissue.version_need').'.</a></h4>';
				echo __('tinyissue.version_your').' : '.$verActu.'<br />';
				echo __('tinyissue.version_release_numb').' : '.Config::get('tinyissue.release').'<br />';
				echo '<br />';
				echo __('tinyissue.version_disp').' : '.$verNum.'<br />';
				echo __('tinyissue.version_commit').' : '.$verCommit.'<br />';
				echo '<a href="https://github.com/pixeline/bugs/releases" target="_blank">'.__('tinyissue.version_details').'</a> <br />';
				echo '<form action="'.URL::to('administration/update').'" method="post" id="agissons">';
				echo '<input type="hidden" name="Etape" value="1" />';
				echo '<input type="hidden" name="versionYour" value="'.$verActu.'" />';
				echo '<input type="hidden" name="versionDisp" value="'.$verNum.'" />';
				echo '<input type="hidden" name="versionComm" value="'.$verCommit.'" />';
				echo '<br /><br />';
				echo '<input type="submit" value="'.__('tinyissue.update').'" class="button	primary"/>';
				echo Form::token();
				echo '</form>';
				if ($verNum < $verActu) {
					echo '<br /><h4><b>'.__('tinyissue.version_ahead').'</b></h4>';
				}
			}
		echo '<br /><br />';
	?>
</div>
