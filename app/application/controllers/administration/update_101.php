<?php
		////2.Récupération et déploiement du code source
		$zip = new ZipArchive();
		$source = "https://github.com/pixeline/bugs/archive/refs/heads/".(($_POST["Choix"] == 1 ) ? "stable" : "master").".zip";
		exec("wget ".$source. " -O ../temp/".$verNum.".zip");
		if ($zip->open("../temp/".$verNum.".zip")) {
			$zip->extractTo('../');
			$zip->close();
		} else {
			echo '<script>alert("'.$MyLng["echec_2"].'"); document.location.href="index.php";</script>';
		}
		////3.Application - s'il y a lieu - des modifications SQL
		//Consignes contenues dans update_xyz ... mise à jour de la base de données
		$CoulFond = array("FFFFFF", "CCCCCC");
		$hist = file_exists('../install/historique.txt') ?  file_get_contents('../install/historique.txt') : '';
		$prevSQL = explode(";", $hist);
		$prevSQL = versionsSQL($prevSQL);
		$rendu = 0;
		$renduFichier = 0;

		////4.S'il y a des fichier update_xyz, c'est que la nouvelle mise à jour exige des modifications à la base de données
		if (count($prevSQL) == 0) {
			//Aucun fichier update_xyz n'a été trouvé
			echo '<h3>'.$MyLng["updateData_4"].'</h3>';
			$MyLng['updateData_3'] = $MyLng['Intro_5'];
		} else {
			//Au moins un fichier update_xyz a été trouvé, peut-être plus
			echo '<h3>'.$MyLng["updateData_2"].'s : </h3>';
			//Lecture de tous les fichiers update_xyz trouvés
			foreach ($prevSQL as $fichier) {
				$compte = 0;
				unset($Separateur);
				$UneCommande = "";
				//Lecture des détails d'un des fichiers update_xyz
				$Toutes = fopen("../install/".$fichier, "r");
				while ($LaCmd = fgets($Toutes)) {
					if (substr($LaCmd, 0, 9) == 'delimiter') {
						$Separateur = trim(substr($LaCmd, 11));
						$Separateur = substr($Separateur, 0, -1);
					} else if (isset($Separateur)) {
						////Affichage des commandes contenues dans les fichiers update_xyz afin de faire valider par l'usager ( éviter ainsi les piratages )
						if ( trim($LaCmd) == trim($Separateur)) {
							echo '<p style="background-color: #'.$CoulFond[$rendu].'">'.$UneCommande.'</p>';
							$_POST["Commandes"]['.$renduFichier.']['.$compte++.'] = $UneCommande;
							$UneCommande = '';
							$rendu = abs($rendu -1);
						} else {
							$UneCommande .= $LaCmd;
						}
					}
				}
				$renduFichier = $renduFichier + 1;
			}
		}
		include_once "application/controllers/administration/update_3a.php";
			
		////5.Page synthèse et sortie

?>