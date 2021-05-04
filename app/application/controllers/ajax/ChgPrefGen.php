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
	$SavFichier = "config.app.".date("Ymdhis").".php";
	copy ($prefixe."config.app.php", $prefixe.$SavFichier);

	//Lecture du fichier de configuration
	////Ouvrons le fichier de configuration
	$RefFichier = fopen($NomFichier, "r");
	////Boucle de lecture
	while (!feof($RefFichier)) {
		$MesLignes[$rendu] = fgets($RefFichier);
		if (strpos($MesLignes[$rendu], "'Percent'") !== false && !isset($NumLigne['Percent']))  { 
			$NumLigne['Percent'] = $rendu; 
			$MesLignes[$rendu] = substr($MesLignes[$rendu], 0, strpos($MesLignes[$rendu], '=>')+2)." array (100,0,".$_POST["prog"].",".$_POST["test"].",100),
";
		}
		if (strpos($MesLignes[$rendu], "'duration'") !== false && !isset($NumLigne['duration']))  { 
			$NumLigne['duration'] = $rendu; 
			$MesLignes[$rendu] = substr($MesLignes[$rendu], 0, strpos($MesLignes[$rendu], '=>')+2)." ".$_POST["duree"].",
";
		}
		if (strpos($MesLignes[$rendu], "'PriorityColors'") !== false && strpos($MesLignes[$rendu], "****") === false && !isset($NumLigne['PriorityColors']))  { 
			$NumLigne['PriorityColors'] = $rendu; 
			$MesLignes[$rendu] = substr($MesLignes[$rendu], 0, strpos($MesLignes[$rendu], '=>')+2)." array ('".$_POST["coulo"]."','".$_POST["coulb"]."','".$_POST["coulb"]."','".$_POST["coulc"]."','".$_POST["could"]."','".$_POST["coule"]."'),
";
		}
		++$rendu;
	}
	fclose($RefFichier);
	
	//Enregistrement du nouveau fichier corrigé  
	$NeoFichier = fopen($NomFichier, "w");
	foreach ($MesLignes as $ind => $val) {
		fwrite($NeoFichier, $val);
	}
	fclose($NeoFichier);
	echo 'Nous avons terminé avec '.$MesLignes[$NumLigne['PriorityColors']];
?>