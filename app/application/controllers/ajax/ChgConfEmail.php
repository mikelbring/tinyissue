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
	foreach ($_GET AS $ind => $val) {
		$_GET[$ind] = str_replace("'", "`", $val);
	}

	//Sauvegarde du fichier original
	$SavFichier = "config.app.".date("Ymd").".php";
	copy ($prefixe."config.app.php", $prefixe.$SavFichier);

	//Lecture du fichier de configuration
	////Ouvrons le fichier de configuration
	$RefFichier = fopen($NomFichier, "r");
	////Boucle de lecture
	while (!feof($RefFichier)) {
		$MesLignes[$rendu] = fgets($RefFichier);
		if (strpos($MesLignes[$rendu], "/**  Mail") 						!== false && !isset($NumLigne["mail_A"])) 										{ $NumLigne["mail_A"] = $rendu; }  
		if (strpos($MesLignes[$rendu], "'mail' => array(") 			!== false && !isset($NumLigne["mail"])	 && @$NumLigne["mail_A"] > 0) 	{ $NumLigne["mail"] = $rendu; }  
		if (strpos($MesLignes[$rendu], "* Final delivery format") 	!== false && !isset($NumLigne["forma"]) && @$NumLigne["mail"] > 0) 		{ $NumLigne["forma"] = $rendu; }  
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

	$MesLignes[$NumLigne["mail"] + 0] = "	'mail' => array(
";
	$MesLignes[$NumLigne["mail"] + 1] = "		'from' => array(
";
	$MesLignes[$NumLigne["mail"] + 2] = "			'name' => '".$_GET["fName"]."',
";
	$MesLignes[$NumLigne["mail"] + 3] = "			'email' => '".$_GET["fMail"]."',
";
	$MesLignes[$NumLigne["mail"] + 4] = "		),
";
	$MesLignes[$NumLigne["mail"] + 5] = "		'replyTo'  => array(
";
	$MesLignes[$NumLigne["mail"] + 6] = "			'name' => '".$_GET["rName"]."',
";
	$MesLignes[$NumLigne["mail"] + 7] = "			'email' => '".$_GET["rMail"]."',
";
	$MesLignes[$NumLigne["mail"] + 8] = "		),
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