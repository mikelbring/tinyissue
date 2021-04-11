<?php
	include_once "FonctionsCommunes.php";
	$retour = '0';
	if ($_GET["Etat"] == 0) {
		$retour = (Requis("INSERT INTO following VALUES(NULL, ".$_GET["User"].", ".$_GET["Project"].", ".$_GET["Quel"].", 0, 1, 1)")) ? 1 : $retour;
	} else {
		$retour = (Requis("DELETE FROM following WHERE user_id = ".$_GET["User"]." AND project_id = ".$_GET["Project"]." AND issue_id = ".$_GET["Quel"]." AND project = 0")) ? 3 : $retour;
	}
	echo $retour;
?>