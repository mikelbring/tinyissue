<?php
	$prefixe = "";
	while (!file_exists($prefixe."config.app.php")) {
		$prefixe .= "../";
	}
	//Définition des variables
	$MesLignes = array();
	$NumLigne = array();
	$NomFichier = $prefixe."config.app.php";
	$rendu = 0;

	//Sauvegarde du fichier original
	$SavFichier = "config.app.".date("Ymd").".php";
	copy ($prefixe."config.app.php", $prefixe.$SavFichier);

	//Lecture du fichier de configuration
	////Ouvrons le fichier de configuration
	$RefFichier = fopen($NomFichier, "r");
	////Boucle de lecture
	while (!feof($RefFichier)) {
		$MesLignes[$rendu] = fgets($RefFichier);
		if (strpos($MesLignes[$rendu], "/**  Mail") !== false && !isset($NumLigne["mail"])) { $NumLigne["mail"] = $rendu; }  
		if (strpos($MesLignes[$rendu], "* Final delivery format") !== false && @$NumLigne["mail"] > 0 && !isset($NumLigne["forma"])) { $NumLigne["forma"] = $rendu; }  
		++$rendu;
	}
	fclose($RefFichier);

	//Repérage des infomations intérssantes
//	$NumLigne["fName"] = $NumLigne["mail"] + 15; 
//	$NumLigne["fMail"] = $NumLigne["mail"] + 16; 
//	$NumLigne["rName"] = $NumLigne["mail"] + 19; 
//	$NumLigne["rMail"] = $NumLigne["mail"] + 20; 
//	$NumLigne["intro"] = $NumLigne["forma"] + 6; 
//	$NumLigne["bye"]   = $NumLigne["forma"] + 7;

	$MesLignes[$NumLigne["mail"] + 13] = "	'mail' => array(
";
	$MesLignes[$NumLigne["mail"] + 14] = "		'from' => array(
";
	$MesLignes[$NumLigne["mail"] + 15] = "			'name' => '".$_GET["fName"]."',
";
	$MesLignes[$NumLigne["mail"] + 16] = "			'email' => '".$_GET["fMail"]."',
";
	$MesLignes[$NumLigne["mail"] + 17] = "		),
";
	$MesLignes[$NumLigne["mail"] + 18] = "		'replyTo'  => array(
";
	$MesLignes[$NumLigne["mail"] + 20] = "			'name' => '".$_GET["rName"]."',
";
	$MesLignes[$NumLigne["mail"] + 21] = "			'email' => '".$_GET["rMail"]."',
";
	$MesLignes[$NumLigne["mail"] + 22] = "		),
";

	$MesLignes[$NumLigne["forma"] + 6] = "		'intro' => '".$_GET["intro"]."',
";
	$MesLignes[$NumLigne["forma"] + 7] = "		'bye' => '".$_GET["bye"]."',
";

//	//Changement des lignes repérées à la faveur des données soumises par l'usager
//	foreach ($NumLigne as $ind => $lgn) {
//		$MesLignes[$NumLigne[$ind]] = substr($MesLignes[$NumLigne[$ind]], 0, strpos($MesLignes[$NumLigne[$ind]], "=>") + 3 )."'".str_replace("'", "`",$_GET[$ind])."',
//";
//	}
//	unset( $NumLigne["mail"], $NumLigne["forma"]); 
	
	//Enregistrement du nouveau fichier corrigé  
	$NeoFichier = fopen($NomFichier, "w");
	foreach ($MesLignes as $ind => $val) {
		fwrite($NeoFichier, $val);
	}
	fclose($NeoFichier);
	echo 'Nous avons terminé';
?>