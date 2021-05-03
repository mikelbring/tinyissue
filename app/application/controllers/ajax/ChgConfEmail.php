<?php
	$prefixe = "";
	while (!file_exists($prefixe."config.app.php")) {
		$prefixe .= "../";
	}
	$config = require $prefixe."config.app.php";
	$dir = $prefixe.$config['attached']['directory']."/";

	//Définition des variables
	$MesLignes = array();
	$NumLigne = array();
	$NomFichier = $prefixe."config.app.php";
	$rendu = 0;
	foreach ($_POST AS $ind => $val) {
		$_POST[$ind] = str_replace("'", "`", $val);
	}

	//Sauvegarde du fichier original
	$SavFichier = "config.app.".date("Ymdhis").".php";
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
	$MesLignes[$NumLigne["mail"] - 3] = "			'name' => '".$_POST["fName"]."',
";
	$MesLignes[$NumLigne["mail"] - 2] = "			'email' => '".$_POST["fMail"]."',
";
	$MesLignes[$NumLigne["mail"] - 1] = "		),
";
	$MesLignes[$NumLigne["mail"] + 0] = "		'replyTo'  => array(
";
	$MesLignes[$NumLigne["mail"] + 1] = "			'name' => '".$_POST["rName"]."',
";
	$MesLignes[$NumLigne["mail"] + 2] = "			'email' => '".$_POST["rMail"]."',
";
	$MesLignes[$NumLigne["mail"] + 3] = "		),
";
}
if ($NumLigne["forma"] > 0) {
	$MesLignes[$NumLigne["forma"] + 0] = "		'intro' => '',
";
	$MesLignes[$NumLigne["forma"] + 1] = "		'bye' => '',
";
}

	//Textes reçus et devant être enregistrés
	//if ($_POST["Enreg"]) {
		$f = fopen($dir."intro.html", "w");
		fputs($f, $_POST["intro"]);
		fclose($f);
		$f = fopen($dir."bye.html", "w");
		fputs($f, $_POST["bye"]);
		fclose($f);
//	}

	//Enregistrement du nouveau fichier corrigé  
	$NeoFichier = fopen($NomFichier, "w");
	foreach ($MesLignes as $ind => $val) {
		fwrite($NeoFichier, $val);
	}
	fclose($NeoFichier);
	echo 'Nous avons terminé\n '.$NumLigne["mail"].'\n'.$NumLigne["forma"].'';
?>