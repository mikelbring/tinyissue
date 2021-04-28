<?php
	$prefixe = "";
	while (!file_exists($prefixe."config.app.php")) {
		$prefixe .= "../";
	}
	$config = require $prefixe."config.app.php";
	$dir = $prefixe.$config['attached']['directory']."/";

	//Texte reçu et devant être enregistré
	if ($_POST["Enreg"]) {
		$f = fopen($dir.$_POST["Quel"].".html", "w");
		fputs($f, $_POST["Prec"]);
		fclose($f);
		$f = fopen($dir.$_POST["Quel"]."_tit.html", "w");
		fputs($f, $_POST["Titre"]);
		fclose($f);
	}

	////Texte retourné en sortie
	if (file_exists($dir.$_POST["Suiv"].".html")) {
		$Sortie = file_get_contents($dir.$_POST["Suiv"].".html");
		if (file_exists($dir.$_POST["Suiv"]."_tit.html")) {
			$Sortie .= '||'.file_get_contents($dir.$_POST["Suiv"]."_tit.html");
		}
	} else {
		$emailLng = require ($prefixe."app/application/language/en/tinyissue.php");
		if ( file_exists($prefixe."app/application/language/".$_POST["Lang"]."/tinyissue.php") && $_POST["Lang"] != 'en') {
			$Lng = require ($prefixe."app/application/language/".$_POST["Lang"]."/tinyissue.php");
			$Lng = array_merge($emailLng, $Lng);
		} else {
			$Lng = $emailLng;
		}
		$Sortie = $Lng["following_email_".$_POST["Suiv"]].'||'.$Lng["following_email_".$_POST["Suiv"]].'_tit';
	}
	
	echo $Sortie;
?>