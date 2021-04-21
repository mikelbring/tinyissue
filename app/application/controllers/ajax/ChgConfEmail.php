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
		if (strpos($MesLignes[$rendu], "mail' => array") !== false && !isset($NumLigne["mail"])) { $NumLigne["mail"] = $rendu; }  
		if (strpos($MesLignes[$rendu], "* Final delivery format") !== false) { $NumLigne["forma"] = $rendu; }  
		++$rendu;
	}
	fclose($RefFichier);

	//Repérage des infomations intérssantes
	$NumLigne["fName"] = $NumLigne["mail"] + 2; 
	$NumLigne["fMail"] = $NumLigne["mail"] + 3; 
	$NumLigne["rName"] = $NumLigne["mail"] + 6; 
	$NumLigne["rMail"] = $NumLigne["mail"] + 7; 
	$NumLigne["intro"] = $NumLigne["forma"] + 6; 
	$NumLigne["bye"]   = $NumLigne["forma"] + 7;
	unset( $NumLigne["mail"], $NumLigne["forma"]); 

	//Changement des lignes repérées à la faveur des données soumises par l'usager
	$posi = 0;
	foreach ($NumLigne as $ind => $lgn) {
		$MesLignes[$NumLigne[$ind]] = substr($MesLignes[$NumLigne[$ind]], 0, strpos($MesLignes[$NumLigne[$ind]], "=>") + 3 )."'".str_replace("'", "`",$_GET[$ind])."',
"; 
	}
	
	//Enregistrement du nouveau fichier corrigé  
	$NeoFichier = fopen($NomFichier, "w");
	foreach ($MesLignes as $ind => $val) {
		fwrite($NeoFichier, $val);
	}
	fclose($NeoFichier);
	echo 'Nous avons terminé';
?>