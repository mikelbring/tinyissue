<?php
	$_POST["prevSQL"] = implode(";",$prevSQL);
	if (file_exists('../install/historique.txt')) { unlink('../install/historique.txt'); }
	if (file_exists('../install/config-setup.php')) { unlink('../install/config-setup.php'); }

	////4.Application - s'il y a lieu - des modifications de préférence
	if (isset($_POST["Commandes"])) {
		$CoulFond = array("CCFFCC", "99CC99");
		$ErroFond = array("FFCCCC", "CC9999");
		$rendu = 0;
		$renduFichier = 0;
		require_once "../install/install.php";
		$install = new install();
		if ($install->check_connect()) {
			$prevSQL = explode(";", $_POST["prevSQL"]);
			//Commande après commande, nous appliquons les changements demandés à la base MySQL
			foreach ($_POST["Commandes"] as $ind => $UneCommande) {
				$Coul = (mysqli_query($GLOBALS["___mysqli_ston"], $UneCommande)) ? $CoulFond[$rendu] : $ErroFond[$rendu] ;
				echo '<p style="background-color: #'.$Coul.'">';
				echo $UneCommande;
				echo '</p>';
				$rendu = abs($rendu -1);
			}
		}
			echo '<br /><br />';
			echo '<h3><a href="../">'.$MyLng['ResultData_1'].'</a></h3>';
			echo '<br /><br />';
		}
		//Comparaison des fichiers de préférences, en admettant que la mise à jour a apporté un nouveau fichier config.app.example.php
		$NomFichier = "../config.app.php";
		$MesPref = require $NomFichier;
		$DefPref = require "../config.app.example.php";
		$NeoPref = array_diff_key($DefPref, $MesPref);
		if (count($NeoPref) == 0) {
			echo $MyLng['updateData_5'];
		} else {
			//Sauvegarde du fichier original
			$SavFichier = "config.app.".date("Ymd").".php";
			copy ("../config.app.php", "../".$SavFichier);
			
			//Colligeons le rang des clefs
			////Clefs de préférences activées par l'usager
			$MesKeys = array_keys($MesPref);
			////Clefs du fichier de configurations par défaut
			$DefKeys = array_keys($DefPref);

			//Lisons les deux fichiers en parallèle
			$NeoContenu = "";
			////Fichier de préférences de l'usager
			$MonFichier = fopen("../config.app.php","r");
			////Fichier de préférences par défaut
			$DefFichier = fopen("../config.app.example.php","r");
			////Boucle de lecture
			while (!feof($DefFichier)) {
				$DefLigne = fgets($DefFichier);
				$MonLigne = fgets($MonFichier);
				if ($MonLigne == $DefLigne) {																						//Les lignes sont identiques
					$NeoContenu .= $MonLigne;
				} elseif ( in_array( trim(substr($MonLigne, 0, strpos($MonLigne, "=>")-2)), $MesKeys) ) {		//Nous faisons ici face à une personnalisation à conserver
					$NeoContenu .= $MonLigne;
				} else {																													//De nouvelles lignes à ajouter
					$NeoContenu .= $DefLigne; 
					while ($DefLigne != $MonLigne && !feof($DefFichier)) {
						$DefLigne = fgets($DefFichier);
						$NeoContenu .= $DefLigne; 
					}
				}
			}
			fclose($DefFichier);
			fclose($MonFichier);
			
			//Conservons le nouveau fichier de préférences  
			$NeoFichier = fopen($NomFichier, "w");
			fwrite($NeoFichier, $NeoContenu);
			fclose($NeoFichier);
			
			//Avisons l'usager des résultats
			echo $MyLng['ResultData_3a'].'.<br />';
			echo $MyLng['ResultData_3b'].' : <b>'.$SavFichier.'</b><br />';
		}
?>