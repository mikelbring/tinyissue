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
	echo '<h4 class="stat_'.substr($NomSimple, 0, strpos($NomSimple, "_")).'">';
	echo '<a href="'.$Rapport_Prod.'" target="_blank">'.$NomSimple.'';
	echo '<img src="../app/assets/images/upload_type/pdf.png" />';
	echo '</a>';
	echo '</h4>';
}
?>

<div class="stat_form">
<form action="reports?type=pdf" method="POST" id="form_reports">
<b><?php echo __('tinyissue.reports_Filter');?> : </b>
<?php echo __('tinyissue.reports_dteinit');?> : <input type="date" name="DteInit" id="input_DteInit" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo __('tinyissue.reports_dteends');?> : <input type="date" name="DteEnds" id="input_DteEnds" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="hidden" name="RapType" id="input_RapType" />
<input type="hidden" name="Couleur" id="input_Couleur" />
<select name="FilterUser" id="select_FiterUser">
<option value="0"><?php echo __('tinyissue.reports_allusers');?></option>
<?php 
	foreach($users as $user) {
		if ($user->firstname !='admin' && $user->lastname != 'admin' ) { echo '<option value="'.$user->id.'">'.$user->firstname.' '.$user->lastname.'</option>'; }
	} 
?>
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
	$Ordre = array("users","projects","issues","tags");
	$PasCeuxCi = array(".","..","index.php","index.htm","index.html");
	$LesRap = scandir("storage/reports/", SCANDIR_SORT_DESCENDING);
	foreach ($LesRap as $LeRap) {
		if (!in_array($LeRap, $PasCeuxCi)) {
			//echo $LeRap.'<br />';
			$Rap = explode("_", substr($LeRap, 0, -4));
			$Liste[$Rap[0]][$Rap[1]][$Rap[2]] = $LeRap;
		}
	}

	foreach ($Ordre as $col) {
		echo '<div class="stat">';
		if (isset($Liste[$col])) {
			foreach($Liste[$col] as $ligne  => $LesDates) {
				foreach ($LesDates as $LaDate => $Fichier) {
					if (isset($Liste[$col][$ligne][$LaDate])) {
						echo '<div class="stat_data stat_'.$col.'_data" onclick="window.open(\'../app/storage/reports/'.$Fichier.'\');" >';
						echo '<img src="../app/assets/images/upload_type/pdf.png" align="left" />';
						echo '<span style="font-size: 120%; font-weight: bold;">'.$rappLng[$col].'</span><br />';
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