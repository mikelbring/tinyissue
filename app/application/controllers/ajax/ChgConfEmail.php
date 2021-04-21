<?php
$prefixe = "";
while (!file_exists($prefixe."config.app.php")) {
	$prefixe .= "../";
}
	//Définition des variables
	$MesLignes = array();
	$NumLigne = array();
	$NomFichier = $prefixe."config.app.php";

	//Sauvegarde du fichier original
	$SavFichier = "config.app.".date("Ymd").".php";
	copy ($prefixe."config.app.php", $prefixe.$SavFichier);
	

	Lecture du fichier de configuration
	////Ouvrons le fichier de configuration
	$MonFichier = fopen($prefixe."config.app.php","r");
	////Boucle de lecture
	while (!feof($DefFichier)) {
		$MesLignes[] = fgets($MonFichier);
	}
	fclose($MonFichier);

	//Repérage des infomations intérssantes
	$NumLigne["mail"] = array_search("	'mail' => array(", $MesLignes);
	$NumLigne["fName"] = $NumLigne["mail"] + 2; 
	$NumLigne["fMail"] = $NumLigne["mail"] + 3; 
	$NumLigne["rName"] = $NumLigne["mail"] + 6; 
	$NumLigne["rMail"] = $NumLigne["mail"] + 7; 
	$NumLigne["mail"] = array_search("	* Final delivery format", $MesLignes);
	$NumLigne["intro"] = $NumLigne["mail"] + 6; 
	$NumLigne["bye"] = $NumLigne["mail"] + 7; 

	//Changement des lignes repérées à la faveur des données soumises par l'usager
	$MesLignes[$NumLigne["fName"]] =  $_GET["fName"]; 
	$MesLignes[$NumLigne["fMail"]] =  $_GET["fMail"]; 
	$MesLignes[$NumLigne["rName"]] =  $_GET["rName"]; 
	$MesLignes[$NumLigne["rMail"]] =  $_GET["rMail"]; 
	$MesLignes[$NumLigne["intro"]] =  $_GET["intro"]; 
	$MesLignes[$NumLigne["bye"]]   =  $_GET["bye"]; 
	
	//Enregistrement du nouveau fichier corrigé  
	$NeoFichier = fopen($NomFichier, "w");
	fwrite($NeoFichier, $NeoContenu);
	fclose($NeoFichier);
?>