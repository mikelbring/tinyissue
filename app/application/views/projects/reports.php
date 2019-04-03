<h3>
<img src="../app/assets/images/reports/Stat.png" width="50" align="left" />
&nbsp;&nbsp;&nbsp;
Statistiques et rapports de tous les <?php echo __('tinyissue.projects');?>
</h3>

<?php 
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
<b>Filtrage des résultats : </b>
Début : <input type="date" name="DteInit" id="input_DteInit" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Fin : <input type="date" name="DteEnds" id="input_DteEnds" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="hidden" name="RapType" id="input_RapType" />
<input type="hidden" name="Couleur" id="input_Couleur" />
<select name="FilterUser" id="select_FiterUser">
<option value="0">Tous</option>
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
		<b><?php echo count($users); ?> Usagers</b><br />
	</div>	
	<div class="stat_data stat_users_data" onclick="document.getElementById('input_Couleur').value='efd583'; document.getElementById('input_RapType').value='users_list'; document.getElementById('form_reports').submit();">
		<img src="../app/assets/images/reports/Stat_users.png" align="left" />
		<b>Tous les usagers</b><br />
		Statistiques de chaque usager: date de début, nombre billets actifs, nombre de billets fermés par lui.
	</div>	
</div>

<div class="stat">
	<div class="stat_element stat_projects">
		<img src="../app/assets/images/reports/projects.png" align="left" />
		<b><?php echo $projects_total; ?> Projets</b><br />
		<br />
		<?php echo $projects_active; ?> actifs <br />
		<?php echo $projects_inactive; ?>  inactifs <br />
	</div>	
	<div class="stat_data stat_projects_data" onclick="document.getElementById('input_Couleur').value='79cf9e'; document.getElementById('input_RapType').value='projects_all'; document.getElementById('form_reports').submit();">
		<img src="../app/assets/images/reports/Stat_projects.png" align="left" />
		<b>Tous les projets</b><br />
		Détails de chaque projet, à savoir, responsable, état, création, mise au repos, ses nombres de billets actifs et inactifs
	</div>	
	<div class="stat_data stat_projects_data" onclick="document.getElementById('input_Couleur').value='79cf9e'; document.getElementById('input_RapType').value='projects_active'; document.getElementById('form_reports').submit();">
		<img src="../app/assets/images/reports/Stat_projects.png" align="left" />
		<b>Projets actifs</b><br />
		Liste de billets actifs, billets inactifs et responsables de billet pour chaque projet
	</div>	
</div>

<div class="stat">
	<div class="stat_element stat_issues">
		<img src="../app/assets/images/reports/issues.png" align="left" />
		<b><?php echo $issues_total; ?> Billets</b><br />
		<br />
		<?php echo $issues_active; ?> actifs<br />
		<?php echo $issues_inactive; ?> inactifs<br />
	</div>	
	<div class="stat_data stat_issues_data" onclick="document.getElementById('input_Couleur').value='6ac5e6'; document.getElementById('input_RapType').value='issues_active'; document.getElementById('form_reports').submit();">
		<img src="../app/assets/images/reports/Stat_issues.png" align="left" />
		<b>Billets actifs</b><br />
		Inventaire de tous les billets actifs avec mention de leur responsable
	</div>	
	<div class="stat_data stat_issues_data" onclick="document.getElementById('input_Couleur').value='6ac5e6'; document.getElementById('input_RapType').value='issues_inactive'; document.getElementById('form_reports').submit();">
		<img src="../app/assets/images/reports/Stat_issues.png" align="left" />
		<b>Billets inactifs</b><br />
		Inventaire de tous les billets inactifs / fermés
	</div>	
	<div class="stat_data stat_issues_data" onclick="document.getElementById('input_Couleur').value='6ac5e6'; document.getElementById('input_RapType').value='issues_progress'; document.getElementById('form_reports').submit();">
		<img src="../app/assets/images/reports/Stat_issues.png" align="left" />
		<b>Progrès des billets</b><br />
		Durée prévue, début des travaux, pourcentage réalisé
	</div>	
</div>

<div class="stat">
	<div class="stat_element stat_tags">
		<img src="../app/assets/images/reports/tags.png" align="left" />
		<b><?php echo $tags; ?> Étiquettes</b><br />
	</div>	
	<div class="stat_data stat_tags_data" onclick="document.getElementById('input_Couleur').value='da7474'; document.getElementById('input_RapType').value='tags_all'; document.getElementById('form_reports').submit();">
		<img src="../app/assets/images/reports/Stat_tags.png" align="left" />
		<b>Étiquettes</b><br />
		À chaque étiquette, nous listerons ici tous les billets (actifs, inactifs ou fermés)
	</div>	
	<div class="stat_data stat_tags_data" onclick="document.getElementById('input_Couleur').value='da7474'; document.getElementById('input_RapType').value='tags_active'; document.getElementById('form_reports').submit();">
		<img src="../app/assets/images/reports/Stat_tags.png" align="left" />
		<b>Étiquettes</b><br />
		À chaque étiquette, nous listerons ici les billets actifs.
	</div>	
	<div class="stat_data stat_tags_data" onclick="document.getElementById('input_Couleur').value='da7474'; document.getElementById('input_RapType').value='tags_inactive'; document.getElementById('form_reports').submit();">
		<img src="../app/assets/images/reports/Stat_tags.png" align="left" />
		<b>Étiquettes</b><br />
		À chaque étiquette, nous listerons ici les billets inactifs ou fermés.
	</div>	
</div>

<br /><br />
<h3>
Rapports antérieurs <?php echo __('tinyissue.projects');?>
</h3>
<?php
	$rappLng = require( (file_exists("application/language/".Auth::user()->language."/reports.php")) ? "application/language/".Auth::user()->language."/reports.php" : "application/language/en/reports.php"); 
	$Liste = array();
	$Ordre = array("users","projects","issues","tags");
	$PasCeuxCi = array(".","..","index.php","index.htm","index.html");
	$LesRap = scandir("storage/reports/", SCANDIR_SORT_DESCENDING);
	foreach ($LesRap as $LeRap) {
		if (!in_array($LeRap, $PasCeuxCi)) {
//			echo $LeRap.'<br />';
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
						echo $LaDate.'<br />';
						echo '</div>';
					}
				}
			}
		}
		echo '</div>';
	}
?>