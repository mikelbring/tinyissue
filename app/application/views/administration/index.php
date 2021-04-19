<h3>
	<?php echo __('tinyissue.administration'); ?>
	<span><?php echo __('tinyissue.administration_description'); ?></span>
</h3>

<div class="pad">
	<div class="pad2">
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
					<?php echo ($active_projects < 2) ? __('tinyissue.active_project') : __('tinyissue.active_projects'); ?><br />
					<?php echo ($archived_projects < 2) ? __('tinyissue.archived_project') : __('tinyissue.archived_projects'); ?><br />
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
				<th><a href="user/issues"><?php echo __('tinyissue.issues'); ?></a>
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
				<th><a href="https://github.com/pixeline/bugs/" target="_blank"><?php echo __('tinyissue.version'); ?></a>
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
		<br />
		<?php
			include "application/libraries/checkVersion.php";
			echo '<h4><b>'.__('tinyissue.version_check').'</b> : ';
			echo '<br /><br />';
			echo __('tinyissue.version_actuelle');
			echo ' : '.$verActu.'<br />'.__('tinyissue.version_release_numb').' : '.Config::get('tinyissue.release');
			echo '<br /><br />';
			if ($verActu == $verNum) {
				echo '<a name="Apprécions">'.__('tinyissue.version_good').'!</a>';
				echo '<br /></h4>';
			} else if ($verNum == 0) {
				echo __('tinyissue.version_offline');
				echo '<br /></h4>';
				echo '<a href="https://github.com/pixeline/bugs/" target="_blank">https://github.com/pixeline/bugs/</a>';
			} else if ($verNum < $verActu) {
				echo '<h4><b>'.__('tinyissue.version_ahead').'</b></h4>';
				echo __('tinyissue.version_disp').' : '.$verNum.'<br />';
				echo __('tinyissue.version_commit').' : '.$verCommit.'<br />';
				echo '<br />';
				echo '<a href="https://github.com/pixeline/bugs/releases" target="_blank">'.__('tinyissue.version_details').'</a> <br />';
			} else {
				echo '<h4><a href="javascript: agissons.submit();">'.__('tinyissue.version_need').'.</a></h4>';
				echo __('tinyissue.release_disp').' : '.$verNum.'<br />';
				echo __('tinyissue.version_commit').' : '.$verCommit.'<br /><br />';
				echo __('tinyissue.version_disp').' : '.$verCod.'<br />';
				echo '<a href="https://github.com/pixeline/bugs/releases" target="_blank">'.__('tinyissue.version_details').'</a> <br />';
				echo '<form action="'.URL::to('administration/update').'" method="post" id="agissons">';
				echo '<input type="hidden" name="Etape" value="1" />';
				echo '<input type="hidden" name="versionYour" value="'.$verActu.'" />';
				echo '<input type="hidden" name="versionDisp" value="'.$verNum.'" />';
				echo '<input type="hidden" name="versionComm" value="'.$verCommit.'" />';
				echo '<br /><br />';
				echo '<input type="submit" value="'.__('tinyissue.updating').'" class="button	primary"/>';
				echo Form::token();
				echo '</form>';
			}
		?>
	</div>
	<br /><br />
	<br /><br />
	<div class="pad" style="border-top-style: solid; border-bottom-style: solid; border-color: grey; border-width: 2px;">
		<?php $Conf = Config::get('application.mail'); ?>
		<br /><br />
			<h4><b><?php echo __('tinyissue.email_head'); ?></b></h4>
			<br /><br />
		<div class="pad2">
			<?php echo __('tinyissue.email_from'); ?> : <?php echo __('tinyissue.email_from_name'); ?> : <input name="email_from_name" id="input_email_from_name" value="<?php echo $Conf["from"]["name"]; ?>" onkeyup="this.style.backgroundColor = 'yellow';" /><br />
			<?php echo __('tinyissue.email_from'); ?> : <?php echo __('tinyissue.email_from_email'); ?> : <input name="email_from_email" id="input_email_from_email" value="<?php echo $Conf["from"]["email"]; ?>" onkeyup="this.style.backgroundColor = 'yellow';" /><br /><br />
			<?php echo __('tinyissue.email_intro'); ?> : <input name="email_from" id="input_email_intro" value="<?php echo $Conf["intro"]; ?>" onkeyup="this.style.backgroundColor = 'yellow';" /><br /><br />
			<?php echo __('tinyissue.email_bye'); ?> : <input name="email_from" id="input_email_bye" value="<?php echo $Conf["bye"]; ?>" onkeyup="this.style.backgroundColor = 'yellow';" /><br /><br />
		</div>
		<div class="pad2">
			<?php echo __('tinyissue.email_replyto'); ?> : <?php echo __('tinyissue.email_from_name'); ?> : <input name="input_email_replyto_name" id="input_email_replyto_name" value="<?php echo $Conf["replyTo"]["name"]; ?>" onkeyup="this.style.backgroundColor = 'yellow';" /><br />
			<?php echo __('tinyissue.email_replyto'); ?> : <?php echo __('tinyissue.email_from_email'); ?> : <input name="input_email_replyto_email" id="input_email_replyto_email" value="<?php echo $Conf["replyTo"]["email"]; ?>" onkeyup="this.style.backgroundColor = 'yellow';" /><br /><br />
			<br />
			<?php echo __('tinyissue.first_name'); ?> : <b>{first}</b> ex.: <?php echo Auth::user()->firstname; ?><br /><br />
			<?php echo __('tinyissue.last_name'); ?> : <b>{last}</b> ex.: <?php echo Auth::user()->lastname; ?><br /><br />
			<?php echo __('tinyissue.name').' ( '.__('tinyissue.first_name'). ' '.__('tinyissue.last_name').' ) '; ?> : <b>{full}</b> ex.: <?php echo Auth::user()->firstname; ?>  <?php echo Auth::user()->lastname; ?><br />
		</div>
		<br />
		<div style="text-align: center;"><input type="button" value="<?php echo __('tinyissue.updating'); ?>" onclick="javascript: AppliquerCourriel();" class="button2"/></div>
		<br />
		
	</div>
</div>
<script type="text/javascript" >
	function AppliquerCourriel() {
		var compte = 0;
		if (document.getElementById('input_email_from_name').style.backgroundColor == 'red' ) { return false; }
		if (document.getElementById('input_email_from_email').style.backgroundColor == 'red' ) { return false; }
		if (document.getElementById('input_email_replyto_name').style.backgroundColor == 'red' ) { return false; }
		if (document.getElementById('input_email_replyto_email').style.backgroundColor == 'red' ) { return false; }
		if (document.getElementById('input_email_intro').style.backgroundColor == 'red' ) { return false; }
		if (document.getElementById('input_email_bye').style.backgroundColor == 'red' ) { return false; }
		if (document.getElementById('input_email_from_name').style.backgroundColor == 'yellow' ) { compte = compte + 1; }
		if (document.getElementById('input_email_from_email').style.backgroundColor == 'yellow' ) { compte = compte + 1; }
		if (document.getElementById('input_email_replyto_name').style.backgroundColor == 'yellow' ) { compte = compte + 1; }
		if (document.getElementById('input_email_replyto_email').style.backgroundColor == 'yellow' ) { compte = compte + 1; }
		if (document.getElementById('input_email_intro').style.backgroundColor == 'yellow' ) { compte = compte + 1; }
		if (document.getElementById('input_email_bye').style.backgroundColor == 'yellow' ) { compte = compte + 1; }
		if (compte == 0) { return false; }
		document.getElementById('input_email_from_name').style.backgroundColor = 'red';
		document.getElementById('input_email_from_email').style.backgroundColor = 'red';
		document.getElementById('input_email_replyto_name').style.backgroundColor = 'red';
		document.getElementById('input_email_replyto_email').style.backgroundColor = 'red';
		document.getElementById('input_email_intro').style.backgroundColor = 'red';
		document.getElementById('input_email_bye').style.backgroundColor = 'red';
		var xhttp = new XMLHttpRequest();
		var NextPage = 'app/application/controllers/ajax/ChgConfEmail.php?fName=' + document.getElementById('input_email_from_name').value + '&fMail=' + document.getElementById('input_email_from_email').value + '&rName=' + document.getElementById('input_email_replyto_name').value + '&rMail=' + document.getElementById('input_email_replyto_email').value + '&intro=' + document.getElementById('input_email_intro').value + '&bye='+document.getElementById('input_email_bye').value;
		xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (xhttp.responseText != '' ) {
				alert(xhttp.responseText);
				document.getElementById('input_email_from_name').style.backgroundColor = 'green';
				document.getElementById('input_email_from_email').style.backgroundColor = 'green';
				document.getElementById('input_email_replyto_name').style.backgroundColor = 'green';
				document.getElementById('input_email_replyto_email').style.backgroundColor = 'green';
				document.getElementById('input_email_intro').style.backgroundColor = 'green';
				document.getElementById('input_email_bye').style.backgroundColor = 'green';
				var blanc = setTimeout(Blanchit, 5000);
				}
			}
		};
		xhttp.open("GET", NextPage, true);
		xhttp.send(); 
	}
	
	function Blanchit() {
		document.getElementById('input_email_from_name').style.backgroundColor = 'white';
		document.getElementById('input_email_from_email').style.backgroundColor = 'white';
		document.getElementById('input_email_replyto_name').style.backgroundColor = 'white';
		document.getElementById('input_email_replyto_email').style.backgroundColor = 'white';
		document.getElementById('input_email_intro').style.backgroundColor = 'white';
		document.getElementById('input_email_bye').style.backgroundColor = 'white';
	}
</script>