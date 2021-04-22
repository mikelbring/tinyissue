<?php
		//Consignes contenues dans update_xyz ... mise à jour de la base de données
		$CoulFond = array("FFFFFF", "CCCCCC");
		$hist = file_exists('../install/historique.txt') ?  file_get_contents('../install/historique.txt') : '';
		$prevSQL = explode(";", $hist);
		$prevSQL = versionsSQL($prevSQL);
		$rendu = 0;
		$renduFichier = 0;

		//S'il y a des fichier update_xyz, c'est que la nouvelle mise à jour exige des modifications à la base de données
		//Par souci de sécurité, nous imposons à l'usager de confirmer les étapes à franchir.
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
								echo '<p style="background-color: #'.$CoulFond[$rendu].'"><input name="Commandes['.$renduFichier.']['.$compte++.']" type="checkbox" value="'.$UneCommande.'" />&nbsp;'.$UneCommande.'</p>';
								$UneCommande = '';
								$rendu = abs($rendu -1);
							} else {
								$UneCommande .= $LaCmd;
							}
						}
				}
				$renduFichier = $renduFichier + 1;
			}
			echo '<br /><br />';
			echo '<input type="hidden" name="prevSQL" value="'.implode(";",$prevSQL).'" />';
		}
		echo '<input type="submit" value="'.$MyLng['updateData_3'].'" class="button	primary"/>';
		if (file_exists('../install/historique.txt')) { unlink('../install/historique.txt'); }
		if (file_exists('../install/config-setup.php')) { unlink('../install/config-setup.php'); }
?>