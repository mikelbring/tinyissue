<?php
	include_once ("db.php");
	$membres = "";
	$requRESP  = "SELECT USR.id, CONCAT(USR.firstname, ' ', UPPER(USR.lastname)) AS NM, PRO.default_assignee AS Deft ";
	$requRESP .= "FROM projects_users AS PRSR ";
	$requRESP .= "LEFT JOIN users AS USR ON USR.id = PRSR.user_id ";
	$requRESP .= "LEFT JOIN projects AS PRO ON PRO.id = PRSR.project_id ";
	$requRESP .= "WHERE project_id = ".$_GET["Projet"]." ";
	$requRESP .= "ORDER BY NM ASC";
	$resuRESP = Requis($requRESP, $db);
	
	while ($QuelRESP = Fetche($resuRESP)) {
		$membres .= '<option value="'.$QuelRESP["id"].'">'.$QuelRESP["NM"].'</option>';
	}
	echo $membres;
?>
