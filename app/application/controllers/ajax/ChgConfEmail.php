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
		if (strpos($MesLignes[$rendu], "'replyTo'") 	!== false && !isset($NumLigne["mail"])	 ) { $NumLigne["mail"] = $rendu; }  
		if (strpos($MesLignes[$rendu], "'intro' =>") !== false && !isset($NumLigne["forma"]) )	{ $NumLigne["forma"] = $rendu; }  
		++$rendu;
	}
	fclose($RefFichier);

if ($NumLigne["mail"] > 0 ) {
	$MesLignes[$NumLigne["mail"] - 5] = "	'mail' => array(
";
	$MesLignes[$NumLigne["mail"] - 4] = "		'from' => array(
";
	$MesLignes[$NumLigne["mail"] - 3] = "			'name' => '".$_GET["fName"]."',
";
	$MesLignes[$NumLigne["mail"] - 2] = "			'email' => '".$_GET["fMail"]."',
";
	$MesLignes[$NumLigne["mail"] - 1] = "		),
";
	$MesLignes[$NumLigne["mail"] + 0] = "		'replyTo'  => array(
";
	$MesLignes[$NumLigne["mail"] + 1] = "			'name' => '".$_GET["rName"]."',
";
	$MesLignes[$NumLigne["mail"] + 2] = "			'email' => '".$_GET["rMail"]."',
";
	$MesLignes[$NumLigne["mail"] + 3] = "		),
";
}
if ($NumLigne["forma"] > 0) {
	$MesLignes[$NumLigne["forma"] + 0] = "		'intro' => '".$_GET["intro"]."',
";
	$MesLignes[$NumLigne["forma"] + 1] = "		'bye' => '".$_GET["bye"]."',
";
}
	
	//Enregistrement du nouveau fichier corrigé  
	$NeoFichier = fopen($NomFichier, "w");
	foreach ($MesLignes as $ind => $val) {
		fwrite($NeoFichier, $val);
	}
	fclose($NeoFichier);
	echo 'Nous avons terminé\n '.$NumLigne["mail"].'\n'.$NumLigne["forma"].'';
?>