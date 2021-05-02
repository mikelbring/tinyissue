<?php
	$prefixe = "";
	while (!file_exists($prefixe."config.app.php")) {
		$prefixe .= "../";
	}
	//Définition des variables
	$MesLignes = array();
	$NumLigne = array();
	$repere = 0;
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
		if ($repere > 0) {
			foreach($_POST as $ind => $val) {
				if (strpos($MesLignes[$rendu], "'".$ind."'") !== false && !isset($NumLigne[$ind]))  { 
					$NumLigne[$ind] = $rendu; 
					$MesLignes[$rendu] = substr($MesLignes[$rendu], 0, strpos($MesLignes[$rendu], '=>')+2)." '".$val."',
";
				}
			}
		} else {
			if (strpos($MesLignes[$rendu], "/**  Mail") !== false ) { $repere = $rendu; }
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
	echo 'Nous avons terminé';
?>