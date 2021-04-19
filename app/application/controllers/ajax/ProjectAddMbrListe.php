<?php
	include_once ("db.php");
	$membres = "<br />";
	$_GET["User"] = strtolower($_GET["User"]);
	$requUSER  = "SELECT USR.id, CONCAT(USR.firstname, ' ', UPPER(USR.lastname)) AS NM ";
	$requUSER .= "FROM  users AS USR ";
	$requUSER .= "WHERE (LOWER(USR.firstname) LIKE '%".$_GET["User"]."%' OR LOWER(USR.lastname) LIKE '%".$_GET["User"]."%' OR LOWER(CONCAT(USR.firstname, ' ', USR.lastname)) LIKE '%".$_GET["User"]."%') ";
	$requUSER .= "AND USR.id NOT IN (SELECT user_id FROM projects_users WHERE project_id = ".$_GET["Projet"]." )";
	$requUSER .= "ORDER BY NM ASC";
	$resuUSER = Requis($requUSER, $db);
	
	while ($QuelUSER = Fetche($resuUSER)) {
		$membres .= '<a href="javascript:addUserProject('.$_GET["Projet"].','.$QuelUSER["id"].', \''.$_GET["CettePage"].'\');" style="margin-left: 10%;">+ '.$QuelUSER["NM"].'</a><br />';
	}
	$membres.= "</ul>";
	echo $membres;
?>
