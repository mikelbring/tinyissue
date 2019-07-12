<div style="display: block ; " id="div_reporttous">
	<h3>
	<img src="../app/assets/images/reports/Stat.png" width="50" align="left" />
	&nbsp;&nbsp;&nbsp;
	<?php echo __('tinyissue.reports_Production');?>
	</h3>
	
	<?php
	//To create new reports:
	////1. Create new model in /app/application/models/reports/*
	//////How to name the model:  type_spreadout.php
	//////type: tags, issues, projects, users
	//////spreadout:  all, active, inactive, progress
	////2. Add new line in /app/application/language/en/reports.php and other languages
	////3. Add div below in this actual file and modify the link's value in the javascript "onclick" function 
	if(@$Rapport_Prod != '') {
		$NomSimple = substr($Rapport_Prod, strrpos($Rapport_Prod, "/")+1);
		$NomSimple = substr($NomSimple, 0, -4);
		$NomDecompose = explode("_", $NomSimple);
		$Couleur = ($NomDecompose[1] == 'customized') ? 'custom' : $NomDecompose[0];
		echo '<h4 class="stat_'.$Couleur.'">';
		echo '<a href="'.$Rapport_Prod.'" target="_blank">'.$NomSimple.'';
		echo '<img src="../app/assets/images/upload_type/pdf.png" />';
		echo '</a>';
		echo '</h4>';
	}
	?>
	
	<div class="stat_form">
	<form action="reports?type=pdf" method="POST" id="form_reports">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b><?php echo __('tinyissue.reports_Filter');?> : </b>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo __('tinyissue.reports_dteinit');?> : <input type="date" name="DteInit" id="input_DteInit" <?php echo ((isset($_POST["DteInit"])) ? 'value="'.$_POST["DteInit"].'"' : '' ); ?> />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo __('tinyissue.reports_dteends');?> : <input type="date" name="DteEnds" id="input_DteEnds" <?php echo ((isset($_POST["DteEnds"])) ? 'value="'.$_POST["DteEnds"].'"' : '' ); ?> />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="hidden" name="RapType" id="input_RapType" />
	<input type="hidden" name="Couleur" id="input_Couleur" />
	<select name="FilterUser" id="select_FiterUser">
	<option value="0"><?php echo __('tinyissue.reports_allusers');?></option>
	<?php 
		foreach($users as $user) {
			if ($user->firstname !='admin' && $user->lastname != 'admin' ) { echo '<option value="'.$user->id.'" '.((@$_POST["FilterUser"] == $user->id) ? 'selected="selected"' : '' ).'>'.$user->firstname.' '.$user->lastname.'</option>'; }
		} 
	?>
	</select>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<select name="Papier" id="select_papier">
	<option value="Letter" 	<?php echo (@$_POST["Papier"] == 'Letter') ? 'selected="selected"' : '';  ?>	>Lettre</option>
	<option value="A4"		<?php echo (@$_POST["Papier"] == 'A4') 	 ? 'selected="selected"' : '';  ?>	>A4</option>
	<option value="Legal"	<?php echo (@$_POST["Papier"] == 'Legal')  ? 'selected="selected"' : '';  ?>	>Legal</option>
	</select>
	</form>
	</div>
	
	<div class="stat">
		<div class="stat_element stat_users">
			<img src="../app/assets/images/reports/users.png" align="left" />
			<b><?php echo count($users); ?> <?php echo __('tinyissue.users');?></b><br />
		</div>	
		<div class="stat_data stat_users_data" onclick="document.getElementById('input_Couleur').value='efd583'; document.getElementById('input_RapType').value='users_list'; document.getElementById('form_reports').submit();">
			<img src="../app/assets/images/reports/Stat_users.png" align="left" />
			<b><?php echo __('tinyissue.reports_allusers');?></b><br />
			<?php echo __('tinyissue.reports_allusersdesc');?>
			
		</div>	
		<div class="stat_data stat_custom_data" onclick="document.getElementById('input_Couleur').value='da4b35'; document.getElementById('div_reportcustom').style.display = 'block'; document.getElementById('div_reporttous').style.display = 'none';" style="margin-top: 150px;">
			<img src="../app/assets/images/reports/Stat_custom.png" align="left" />
			<b><?php echo __('tinyissue.reports_custom');?></b><br />
			<?php echo __('tinyissue.reports_customdesc');?>
			
		</div>	
	</div>
	
	<div class="stat">
		<div class="stat_element stat_projects">
			<img src="../app/assets/images/reports/projects.png" align="left" />
			<b><?php echo $projects_total; ?> <?php echo __('tinyissue.projects');?></b><br />
			<br />
			<?php echo $projects_active; ?> <?php echo __('tinyissue.reports_proactive');?> <br />
			<?php echo $projects_inactive; ?>  <?php echo __('tinyissue.reports_proinactive');?> <br />
		</div>	
		<div class="stat_data stat_projects_data" onclick="document.getElementById('input_Couleur').value='79cf9e'; document.getElementById('input_RapType').value='projects_all'; document.getElementById('form_reports').submit();">
			<img src="../app/assets/images/reports/Stat_projects.png" align="left" />
			<b><?php echo __('tinyissue.reports_allprojects');?></b><br />
			<?php echo __('tinyissue.reports_allprojectsdesc');?>
		</div>	
		<div class="stat_data stat_projects_data" onclick="document.getElementById('input_Couleur').value='79cf9e'; document.getElementById('input_RapType').value='projects_active'; document.getElementById('form_reports').submit();">
			<img src="../app/assets/images/reports/Stat_projects.png" align="left" />
			<b><?php echo __('tinyissue.reports_allprojects');?></b><br />
			<?php echo __('tinyissue.reports_actprojectsdesc');?>
		</div>	
	</div>
	
	<div class="stat">
		<div class="stat_element stat_issues">
			<img src="../app/assets/images/reports/issues.png" align="left" />
			<b><?php echo $issues_total; ?> <?php echo __('tinyissue.issues');?></b><br />
			<br />
			<?php echo $issues_active; ?> <?php echo __('tinyissue.reports_issactive');?><br />
			<?php echo $issues_inactive; ?> <?php echo __('tinyissue.reports_issinactive');?><br />
		</div>	
		<div class="stat_data stat_issues_data" onclick="document.getElementById('input_Couleur').value='6ac5e6'; document.getElementById('input_RapType').value='issues_active'; document.getElementById('form_reports').submit();">
			<img src="../app/assets/images/reports/Stat_issues.png" align="left" />
			<b><?php echo __('tinyissue.reports_actissues');?></b><br />
			<?php echo __('tinyissue.reports_actissuesdesc');?>
		</div>	
		<div class="stat_data stat_issues_data" onclick="document.getElementById('input_Couleur').value='6ac5e6'; document.getElementById('input_RapType').value='issues_inactive'; document.getElementById('form_reports').submit();">
			<img src="../app/assets/images/reports/Stat_issues.png" align="left" />
			<b><?php echo __('tinyissue.reports_inactissues');?></b><br />
			<?php echo __('tinyissue.reports_inactissuesdesc');?>
		</div>	
		<div class="stat_data stat_issues_data" onclick="document.getElementById('input_Couleur').value='6ac5e6'; document.getElementById('input_RapType').value='issues_progress'; document.getElementById('form_reports').submit();">
			<img src="../app/assets/images/reports/Stat_issues.png" align="left" />
			<b><?php echo __('tinyissue.reports_progissues');?></b><br />
			<?php echo __('tinyissue.reports_progissuesdesc');?>
		</div>	
	</div>
	
	<div class="stat">
		<div class="stat_element stat_tags">
			<img src="../app/assets/images/reports/tags.png" align="left" />
			<b><?php echo $tags; ?> <?php echo __('tinyissue.tags');?></b><br />
		</div>	
		<div class="stat_data stat_tags_data" onclick="document.getElementById('input_Couleur').value='da7474'; document.getElementById('input_RapType').value='tags_all'; document.getElementById('form_reports').submit();">
			<img src="../app/assets/images/reports/Stat_tags.png" align="left" />
			<b><?php echo __('tinyissue.reports_alltags');?></b><br />
			<?php echo __('tinyissue.reports_alltagsdesc');?>
		</div>	
		<div class="stat_data stat_tags_data" onclick="document.getElementById('input_Couleur').value='da7474'; document.getElementById('input_RapType').value='tags_active'; document.getElementById('form_reports').submit();">
			<img src="../app/assets/images/reports/Stat_tags.png" align="left" />
			<b><?php echo __('tinyissue.reports_acttags');?></b><br />
			<?php echo __('tinyissue.reports_acttagsdesc');?>
		</div>	
		<div class="stat_data stat_tags_data" onclick="document.getElementById('input_Couleur').value='da7474'; document.getElementById('input_RapType').value='tags_inactive'; document.getElementById('form_reports').submit();">
			<img src="../app/assets/images/reports/Stat_tags.png" align="left" />
			<b><?php echo __('tinyissue.reports_inacttags');?></b><br />
			<?php echo __('tinyissue.reports_inacttagsdesc');?>
		</div>	
	</div>
	
	<br /><br />
	<h3>
	<?php echo __('tinyissue.reports_archives');?>
	</h3>
	<?php
		$rappLng = require ("application/language/en/reports.php"); 
		if ( file_exists("application/language/".Auth::user()->language."/reports.php")) {
			$rappMaLng = require "application/language/".Auth::user()->language."/reports.php";
			$rappLng = array_merge($rappLng, $rappMaLng);
		} 
		$Liste = array();
		$Ordre = array("users","projects","issues","tags","customized");
		$PasCeuxCi = array(".","..","index.php","index.htm","index.html");
		$LesRap = scandir("storage/reports/", SCANDIR_SORT_DESCENDING);
		foreach ($LesRap as $LeRap) {
			if (!in_array($LeRap, $PasCeuxCi)) {
				$Rap = explode("_", substr($LeRap, 0, -4));
//				echo $LeRap.' ... qui donne ...'.@$Rap[2].'<br />';
				if (isset($Rap[2])) { $Liste[$Rap[0]][$Rap[1]][$Rap[2]] = $LeRap; }
			}
		}
		foreach ($Ordre as $col) {
			echo '<div class="stat">';
			if (isset($Liste[$col])) {
				foreach($Liste[$col] as $ligne  => $LesDates) {
					foreach ($LesDates as $LaDate => $Fichier) {
						if (isset($Liste[$col][$ligne][$LaDate])) {
							echo '<div class="stat_data stat_'.(($ligne == 'customized') ? 'custom' : $col).'_data" onclick="window.open(\'../app/storage/reports/'.$Fichier.'\');" >';
							echo '<img src="../app/assets/images/upload_type/pdf.png" align="left" />';
							echo '<span style="font-size: 120%; font-weight: bold;">'.(($ligne == 'customized') ? __('tinyissue.reports_custom') : $rappLng[$col]).'</span><br />';
							echo $rappLng[$ligne].'<br />';
							echo substr($LaDate, 0, 4),'-'.substr($LaDate, 4, 2).'-'.substr($LaDate, 6, 2).' '.substr($LaDate, 8, 2).'h'.substr($LaDate, 10, 2).':'.substr($LaDate, 12, 2).'<br />';
							echo '</div>';
						}
					}
				}
			}
			echo '</div>';
		}
	?>
</div>

<div id="div_reportcustom" style="display: none;">

	<h3>
	<?php echo __('tinyissue.reports_custom');?>
	</h3>
		<table border width="100%">
			<tr><td valign="top"  style="border-style: none; ">
				<img src="../app/assets/images/reports/Stat_custom.png" width="150" align="left" />
			</td>
			<td style="width: 80%; border-style: none; vertical-align: top;">
				<table width="100%"  >
					<tr><td colspan="5" style="color: white; background-color: #003; font-size: 150%; font-weight: bold; text-align: center;" id="td_GdTitre"><?php echo __('tinyissue.reportsCusGdTitre'); ?></td></tr>
					<tr>
						<td style="width: 100%; color: white; background-color: #009; font-size: 115%; font-weight: bold; text-align: center;" id="td_Ex1"><?php echo __('tinyissue.reportsCusTitre'); ?> 1</td>
						<td style="width: 0%; color: white; background-color: #006; font-size: 115%; font-weight: bold; text-align: center;" id="td_Ex2"></td>
						<td style="width: 0%; color: white; background-color: #00A; font-size: 115%; font-weight: bold; text-align: center;" id="td_Ex3"></td>
						<td style="width: 0%; color: white; background-color: #006; font-size: 115%; font-weight: bold; text-align: center;" id="td_Ex4"></td>
						<td style="width: 0%; color: white; background-color: #009; font-size: 115%; font-weight: bold; text-align: center;" id="td_Ex5"></td>
					</tr>
				</table>
			</td>
			</tr>
			</tr>
		</table>
	
	
	<br clear="all" />
	
	<div style="margin-top: 50px; margin-bottom: 50px;">
		<form action="reports?type=pdf" method="POST"  id="form_reports"  >
		<div id="Titre" style="margin-bottom: 20px;">
			<input name="TitreRapport" value="" type="text" size="75" style="background-color: black; color: white;" placeholder="<?php echo __('tinyissue.reportsCusGdTitre');?>" onkeyup="AjourTitre(this.value);" />
		</div>
		<table id="ListColonnes" width="100%"><tr>
			<?php
				for ($col=1; $col<6; $col++) {
					echo '<td id="td_'.$col.'" width="20%">';
					echo '<br />';
					echo '<input name="Titre['.$col.']" id="input_Titre_'.$col.'" value="" placeholder="'.__('tinyissue.reportsCusTitre').' '.$col.'" onkeyup="ChgTitCol('.$col.', this.value);" />';
					echo '<br />';
					echo '<select name="ChxColonnes['.$col.']" id="select_ChxColonnes_'.$col.'" onchange="ChxTri('.$col.',this.value);">';
						echo '<option value="&" selected="selected">'.$rappLng["choisis"].'</option>';
						echo '<option value="projects_id&'.$rappLng["project_id"].'">'.$rappLng["project_id"].'</option>';
						echo '<option value="created_at&'.$rappLng["created_at"].'">'.$rappLng["created_at"].'</option>';
						echo '<option value="created_by&'.$rappLng["created_by"].'">'.$rappLng["created_by"].'</option>';
						echo '<option value="title&'.$rappLng["title"].'">'.$rappLng["title"].'</option>';
						echo '<option value="body&'.$rappLng["body"].'">'.$rappLng["body"].'</option>';
						echo '<option value="duration&'.$rappLng["duration"].'">'.$rappLng["duration"].'</option>';
						echo '<option value="assigned_to&'.$rappLng["assigned_to"].'">'.$rappLng["assigned_to"].'</option>';
						echo '<option value="status&'.$rappLng["status"].'">'.$rappLng["status"].'</option>';
						echo '<option value="weight&'.$rappLng["weight"].'">'.$rappLng["weight"].'</option>';
						echo '<option value="updated_by&'.$rappLng["updated_by"].'">'.$rappLng["updated_by"].'</option>';
						echo '<option value="updated_at&'.$rappLng["updated_at"].'">'.$rappLng["updated_at"].'</option>';
						echo '<option value="closed_at&'.$rappLng["closed_at"].'">'.$rappLng["closed_at"].'</option>';
						echo '<option value="closed_by&'.$rappLng["closed_by"].'">'.$rappLng["closed_by"].'</option>';
					echo '</select>';
					echo '<br />';
					echo '<input name="LargColonne['.$col.']" id="input_LargColonne_'.$col.'" type="number" min="0" max="100" value="20" size="4" onchange="ChgLargCols('.$col.', this.value);" /> %';
					echo '</td>';
				} 
			?>
		</tr></table>
	</div>
	<div style="margin-bottom: 50px; margin-left: 20%;">
		<table>
		<tr>
			<td style="padding: 5px;">
				&nbsp;&nbsp;&nbsp;
				<?php echo $rappLng["projects"]; ?>
				<br />
				<select name="ChxProjets[]" multiple="multiple" >
				<?php
				$query  = "SELECT * FROM projects ORDER BY status DESC, name ASC ";
				$results = \DB::query($query);
				foreach($results as $result) {
					echo '<option value="'.$result->id.'" '.(($result->status == 1) ? 'selected="selected"' : '').' >'.$result->name.' '.(($result->status == 1) ? '' : ' ( '.__('tinyissue.archived').' ) ').'</option>';
				}
				?>
				</select>
			</td>
			</tr>
			</table>
			<table>
			<tr>
			<td style="padding: 5px;">
				&nbsp;&nbsp;&nbsp;
				<?php echo $rappLng["created_by"]; ?>
				<br />
				<select name="Chxcreated_by[]" multiple="multiple" >
				<?php 
				$query  = "SELECT * FROM users WHERE firstname != 'admin' ORDER BY firstname ASC, lastname ASC ";
				$results = \DB::query($query);
				foreach($results as $result) {
					echo '<option value="'.$result->id.'" selected="selected" >'.$result->firstname.' '.$result->lastname.'</option>';
				}
				?>
				</select>
			</td>
			<td style="padding: 5px;">
				&nbsp;&nbsp;&nbsp;
				<?php echo $rappLng["assigned_to"]; ?>
				<br />
				<select name="Chxassigned_to[]" multiple="multiple" >
				<?php 
				$results = \DB::query($query);
				foreach($results as $result) {
					echo '<option value="'.$result->id.'" selected="selected" >'.$result->firstname.' '.$result->lastname.'</option>';
				}
				?>
				</select>
			</td>
			<td style="padding: 5px;">
				&nbsp;&nbsp;&nbsp;
				<?php echo $rappLng["updated_by"]; ?>
				<br />
				<select name="Chxupdated_by[]" multiple="multiple" > 
				<?php 
				$results = \DB::query($query);
				foreach($results as $result) {
					echo '<option value="'.$result->id.'" selected="selected" >'.$result->firstname.' '.$result->lastname.'</option>';
				}
				?>
				</select>
			</td>
			<td style="padding: 5px;">
				&nbsp;&nbsp;&nbsp;
				<?php echo $rappLng["closed_by"]; ?>
				<br />
				<select name="Chxclosed_by[]" multiple="multiple" > 
				<?php 
				$results = \DB::query($query);
				foreach($results as $result) {
					echo '<option value="'.$result->id.'" selected="selected" >'.$result->firstname.' '.$result->lastname.'</option>';
				}
				?>
				</select>
			<td>
		</tr>
		</table>
		<table>
		<tr>
			<td style="padding: 15px; background-color: green; color: white; text-align: right;">
				<p style="text-align: center; margin-top: 0px;"><?php echo $rappLng["created_at"]; ?></p>
				<?php echo $rappLng["between"]; ?>
				<input name="Deb_created_at" type="date" value="1981-01-01" >
				<br />
				<?php echo $rappLng["anddate"]; ?>
				<input name="Fin_created_at" type="date" value="<?php echo date("Y-m-d"); ?>" >
			</td>
			<td style="padding: 15px; background-color: blue; color: white; text-align: right;">
				<p style="text-align: center; margin-top: 0px;"><?php echo $rappLng["updated_at"]; ?></p>
				<?php echo $rappLng["between"]; ?>
				<input name="Deb_updated_at" type="date" value="1981-01-01" >
				<br />
				<?php echo $rappLng["anddate"]; ?>
				<input name="Fin_updated_at" type="date" value="<?php echo date("Y-m-d"); ?>" >
			</td>
			<td style="padding: 15px; background-color: red; color: white; text-align: right;">
				<p style="text-align: center; margin-top: 0px;"><?php echo $rappLng["closed_at"]; ?></p>
				<?php echo $rappLng["between"]; ?>
				<input name="Deb_closed_at" type="date" value="1981-01-01" >
				<br />
				<?php echo $rappLng["anddate"]; ?>
				<input name="Fin_closed_at" type="date" value="<?php echo date("Y-m-d"); ?>" >
			</td>
		</tr>
		</table>
	</div>
	<div style="margin-left: 25%;">
		<?php echo $rappLng["trions"]; ?> :<br /> 
		<select name="OrderBy_1" id="select_OrderBy_1"></select>
		&nbsp;&nbsp;&nbsp;
		<select name="OrderOrder_1">
			<option value="ASC"><?php echo $rappLng["triASC"]; ?></option>
			<option value="DESC"><?php echo $rappLng["triDESC"]; ?></option>
		</select>
		<br />
		<select name="OrderBy_2" id="select_OrderBy_2"></select>
		&nbsp;&nbsp;&nbsp;
		<select name="OrderOrder_2">
			<option value="ASC"><?php echo $rappLng["triASC"]; ?></option>
			<option value="DESC"><?php echo $rappLng["triDESC"]; ?></option>
		</select>
		<br /><br />
		<select name="Papier" id="select_papier">
		<option value="Letter" 	<?php echo (@$_POST["Papier"] == 'Letter') ? 'selected="selected"' : '';  ?>	>Lettre</option>
		<option value="A4"		<?php echo (@$_POST["Papier"] == 'A4') 	 ? 'selected="selected"' : '';  ?>	>A4</option>
		<option value="Legal"	<?php echo (@$_POST["Papier"] == 'Legal')  ? 'selected="selected"' : '';  ?>	>Legal</option>
		</select>
		<br /><br />
		<input type="submit" name="Soumettre" value="<?php echo $rappLng["btnSubmit"]; ?>" />
		<input type="hidden" name="RapType" id="input_RapType" />
		<input type="hidden" name="Couleur" id="input_Couleur" value="efd583" />		
		<input type="hidden" name="RapType" id="input_TypeCus" value="users_customized" />		
		</form>
	</div>
	
</div>
<script type="text/javascript" >
	var CetteVal = new Array("","","","","","","");
	var NbCol = 0;
	
	function AjourTitre(valeur) {
		if (valeur == '') {
			document.getElementById('td_GdTitre').innerHTML = "<?php echo __('tinyissue.reportsCusGdTitre'); ?>";
		} else {
			document.getElementById('td_GdTitre').innerHTML = valeur;
		}
	}

	function ChgLargCols(Quelle, valeur) {
		var Tot = 100;
		document.getElementById('td_Ex' + Quelle).style.width  = valeur + "%";
		for (x=1; x<=Quelle; x++) {
			Tot = Tot - document.getElementById('input_LargColonne_' + x).value;
		}
		if (Tot > 0) {
			var Nb = 0;
			for (x=(Quelle + 1); x<6; x++) {
				if ( CetteVal[x] != '') { Nb = Nb + 1; }
			}
			var Cols = Tot / Nb;
			for (x=(Quelle + 1); x<6; x++) {
				if ( CetteVal[x] == '') {
					document.getElementById('input_LargColonne_' + x).value = 0;
					document.getElementById('td_Ex' + x).style.width  = "0%";
				} else {
					document.getElementById('input_LargColonne_' + x).value = Cols;
					document.getElementById('td_Ex' + x).style.width  = Cols + "%";
				}
			}
		}
	}

	function ChgTitCol(Quelle, valeur) {
		//L'usager modifie un titre de colonne
		var Tot = 100;
		var Ecart = new Array(0, 100, 40, 30, 18, 12, 10);
		//if (Quelle == 2) { Ecart = 40; }
		CetteVal[Quelle] = valeur.trim();
		////Éviter de laisser l'usager définir la colonne c+x avant la colonne c
		for (x=5; x>1; x--) {
			if (document.getElementById('input_Titre_' + (x-1)).value == '' && document.getElementById('input_Titre_' + x).value != '') { 
				document.getElementById('input_Titre_' + (x-1)).value = document.getElementById('input_Titre_' + (x-0)).value;
				document.getElementById('input_Titre_' + (x-0)).value = "";
				QuelleVal[x-1] = QuelleVal[x];
				QuelleVal[x] = "";
				Quelle = x-1; 
			}
		}
		////Si l'usager inscrit un nouveau titre de colonne, 
		////assurons une largeur minimale à la nouvelle colonne 
		////et recalculons les largeurs
		if (document.getElementById('input_LargColonne_' + Quelle).value == 0) {
			if (Quelle > 1) {
				document.getElementById('input_LargColonne_' + Quelle).value = Ecart[Quelle];
				var Otons = Ecart[Quelle] / (Quelle-1);
				for (x=1; x<Quelle; x++) {
					var NouvLarg = document.getElementById('input_LargColonne_' + x).value - Otons;
					document.getElementById('input_LargColonne_' + x).value = NouvLarg;
					document.getElementById('td_Ex' + x).style.width = NouvLarg + "%";
				}
			}
		}
		document.getElementById('input_Titre_' + Quelle).focus();
		for (x=1; x<6; x++) {
			CetteVal[x] = CetteVal[x].trim();
			if ( CetteVal[x] == '') { 
				document.getElementById('td_Ex' + x).style.width = 0; 
			} else {
				document.getElementById('td_Ex' + Quelle).innerHTML = CetteVal[x];
			}
		}
		for (x=1; x<5; x++) {
			if ( CetteVal[x+1] == '') {
				document.getElementById('input_LargColonne_' + x).value = Tot;
				document.getElementById('td_Ex' + x).style.width = Tot + "%";
				break; 
			} else {
				Tot = Tot - document.getElementById('input_LargColonne_' + x).value; 
				document.getElementById('td_Ex' + x).style.width = document.getElementById('input_LargColonne_' + x).value + "%"; 
			} 
		}
		for (y=x+1; y<6; y++) {
			document.getElementById('input_LargColonne_' + y).value = 0;
			document.getElementById('td_Ex' + y).style.width  = "0%";
		}
		for (y=1; y<6; y++) {
			document.getElementById('td_Ex' + y).innerHTML  = CetteVal[y];
		}
	}
	
	function ChxTri(col, valeur) {
		var vals = valeur.split("&");
		if (document.getElementById('input_Titre_' + col).value == '')  {
			document.getElementById('input_Titre_' + col).value = vals[1];
			ChgTitCol(col, vals[1]);
		}
		var dest = document.getElementById("select_OrderBy_1");
		var nouv = document.createElement("OPTION");
		var txt = document.createTextNode(vals[1])
		nouv.setAttribute("value", vals[0]);
		nouv.appendChild(txt);
		dest.appendChild(nouv);
		dest = document.getElementById("select_OrderBy_2");
		nouv = document.createElement("OPTION");
		txt = document.createTextNode(vals[1])
		nouv.setAttribute("value", vals[0]);
		nouv.appendChild(txt);
		dest.appendChild(nouv);
		if (col == 2) { document.getElementById('select_OrderBy_2').selectedIndex = 1; }
	}
</script>
