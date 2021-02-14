<?php
	include_once ("db.php");
	$_GET["User"] = strtolower($_GET["User"]);
	$requUSER  = "INSERT INTO projects_users VALUES (NULL, ".$_GET["User"].", ".$_GET["Projet"].", 2, NOW(), NOW()) ";
	if (Requis($requUSER)) {
		$QuelPERS = Explose("SELECT firstname, UPPER(lastname) AS lastname FROM users WHERE id = ".$_GET["User"]);
		$membres  = '<li id="project-user'.$_GET["User"].'">';
		$membres .= $QuelPERS["firstname"] . ' ' . $QuelPERS["lastname"];
		$membres .= '</li>';
		echo $membres;
	}
?>