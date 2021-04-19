<?php
$prefixe = "";
while (!file_exists($prefixe."config.app.php")) {
	$prefixe .= "../";
}
echo 'Je suis au début - ligne 6';
			//Sauvegarde du fichier original
			$SavFichier = "config.app.".date("Ymd").".php";
			copy ($prefixe."config.app.php", $prefixe.$SavFichier);
			
			//Colligeons le rang des clefs
			////Clefs de préférences activées par l'usager
			$MesKeys = array_keys($MesPref);
			////Clefs du fichier de configurations par défaut
			$DefKeys = array_keys($DefPref);
echo 'Je suis au début - ligne 16';

			//Ouvrons le fichier de configuration
			$NeoContenu = "";
			$NomFichier = $prefixe."config.app.php";
			////Fichier de préférences de l'usager
			$MonFichier = fopen($prefixe."config.app.php","r");
echo 'Voici la ligne 23';

			////Boucle de lecture
			while (!feof($DefFichier)) {
				$MonLigne = fgets($MonFichier);
				$NeoContenu .= $MonLigne;
				if ($MonLigne == "'mail' => array(") { break; } 
			}
			//Avons repéré la section du courriel
			////Sautons deux lignes afin de redéfinir la valeur du courriel FROM
			$MonLigne = fgets($MonFichier);
			$NeoContenu .= $MonLigne;
			$MonLigne = fgets($MonFichier);
			$NeoContenu .= $MonLigne;
			$MonLigne = fgets($MonFichier);
			$NeoContenu .= "'name' => '".$_GET["fName"]."',";
			$MonLigne = fgets($MonFichier);
			$NeoContenu .= "'name' => '".$_GET["fMail"]."',";
			////Deux autres lignes puis l'adresse ReplyTo
			$MonLigne = fgets($MonFichier);
			$NeoContenu .= $MonLigne;
			$MonLigne = fgets($MonFichier);
			$NeoContenu .= $MonLigne;
			$MonLigne = fgets($MonFichier);
			$NeoContenu .= "'name' => '".$_GET["rName"]."',";
			$MonLigne = fgets($MonFichier);
			$NeoContenu .= "'name' => '".$_GET["rMail"]."',";
			////Reprise de la lecture avant de modifier intro et bye
			while (!feof($DefFichier)) {
				$MonLigne = fgets($MonFichier);
				if (substr(trim($MonLigne), 0, 10) == "'intro' =>") { break; } 
				$NeoContenu .= $MonLigne;
			}
			////Mise à jour de la valeur intro
			$NeoContenu .= "'intro' => '".$_GET["intro"]."', ";
			////Mise à jour de la valeur bye
			$MonLigne = fgets($MonFichier);
			$NeoContenu .= "'bye' => '".$_GET["bye"]."', ";
			
			while (!feof($DefFichier)) {
				$MonLigne = fgets($MonFichier);
				$NeoContenu .= $MonLigne;
			}
			fclose($MonFichier);

			//Conservons le nouveau fichier de préférences  
//			$NeoFichier = fopen($NomFichier, "w");
//			fwrite($NeoFichier, $NeoContenu);
//			fclose($NeoFichier);
			echo 'Voici le nouveau fichier';
			echo $NeoContenu;
?>