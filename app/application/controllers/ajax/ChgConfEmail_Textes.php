<?php
	$prefixe = "";
	while (!file_exists($prefixe."config.app.php")) {
		$prefixe .= "../";
	}

	//Texte reçu et devant être enregistré
	if ($_POST["Enreg"]) {
		$f = fopen($prefixe."uploads/".$_POST["Quel"].".html", "w");
		fputs($f, $_POST["Prec"]);
		fclose($f);
	}

	////Texte retourné en sortie
	if (file_exists($prefixe."uploads/".$_POST["Suiv"].".html")) {
		$Sortie = file_get_contents($prefixe."uploads/".$_POST["Suiv"].".html");
	} else {
		$emailLng = require ($prefixe."app/application/language/en/tinyissue.php");
		if ( file_exists($prefixe."app/application/language/".$_POST["Lang"]."/tinyissue.php") && $_POST["Lang"] != 'en') {
			$Lng = require ($prefixe."app/application/language/".$_POST["Lang"]."/tinyissue.php");
			$Lng = array_merge($emailLng, $Lng);
		} else {
			$Lng = $emailLng;
		}
		$Sortie = $Lng["following_email_".$_POST["Suiv"]];
	}
	
echo $Sortie;
?>