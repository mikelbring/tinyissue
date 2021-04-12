<?php
include_once "FonctionsCommunes.php";
if ($_GET["Quoi"] == 1) {
	$tags = $_GET["tags"] ?? 1;
	$attached = $_GET["attached"] ?? 1;
	$retour = '0';
	if ($_GET["Etat"] == 0) {
		$retour = (Requis("INSERT INTO following VALUES(NULL, ".$_GET["Qui"].", ".$_GET["Project"].", ".$_GET["Quel"].", 0, ".$attached.", ".$tags.")")) ? 1 : $retour;
	} else {
		$retour = (Requis("DELETE FROM following WHERE user_id = ".$_GET["Qui"]." AND project_id = ".$_GET["Project"]." AND issue_id = ".$_GET["Quel"]." AND project = 0")) ? 3 : $retour;
	}
	echo $retour.' car nous avons reçu : '.$_GET["Etat"];
}
?>