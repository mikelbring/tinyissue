<h3>
<img src="../app/assets/images/reports/Stat.png" width="50" align="left" />&nbsp;&nbsp;&nbsp;Statistiques et rapports
</h3>

<div class="stat">
	<div class="stat_element stat_users">
		<img src="../app/assets/images/reports/users.png" align="left" />
		<b><?php echo $users; ?> Usagers</b><br />
	</div>	
	<div class="stat_data stat_users_data">
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
	<div class="stat_data stat_projects_data">
		<img src="../app/assets/images/reports/Stat_projects.png" align="left" />
		<b>Tous les projets</b><br />
		Détails de chaque projet, à savoir, responsable, état, création, mise au repos, ses nombres de billets actifs et inactifs
	</div>	
	<div class="stat_data stat_projects_data">
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
	<div class="stat_data stat_issues_data">
		<img src="../app/assets/images/reports/Stat_issues.png" align="left" />
		<b>Billets actifs</b><br />
		<br />
		Inventaire de tous les billets actifs avec mention de leur responsable
	</div>	
	<div class="stat_data stat_issues_data">
		<img src="../app/assets/images/reports/Stat_issues.png" align="left" />
		<b>Billets inactifs</b><br />
		<br />
		Inventaire de tous les billets inactifs / fermés
	</div>	
	<div class="stat_data stat_issues_data">
		<img src="../app/assets/images/reports/Stat_issues.png" align="left" />
		<b>Progrès des billets</b><br />
		<br />
		Durée prévue, début des travaux, pourcentage réalisé
	</div>	
</div>

<div class="stat">
	<div class="stat_element stat_tags">
		<img src="../app/assets/images/reports/tags.png" align="left" />
		<b><?php echo $tags; ?> Étiquettes</b><br />
	</div>	
	<div class="stat_data stat_tags_data">
		<img src="../app/assets/images/reports/Stat_tags.png" align="left" />
		<b>Étiquettes</b><br />
		À chaque étiquette, nous listerons ici les billets actifs associés, les billets inactifs associés.
	</div>	
</div>

	Bonjour les ti-copains!!!<br /><br />
	<?php echo __('tinyissue.projects');?>
	<span><?php echo __('tinyissue.projects_description');?></span>


