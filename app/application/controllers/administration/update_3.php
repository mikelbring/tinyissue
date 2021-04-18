<?php
		//Application de modifications demandées sur la base de données ( les commandes énumérées en étapes précédentes ont été acceptées par l'usager )
		//nous ne traiterons ici que les commandes acceptées par l'usager
		if (isset($_POST["Commandes"])) {
			$CoulFond = array("CCFFCC", "99CC99");
			$ErroFond = array("FFCCCC", "CC9999");
			$rendu = 0;
			$renduFichier = 0;
			require "../install/install.php";
			$install = new install();
			if ($install->check_connect()) {
				$prevSQL = explode(";", $_POST["prevSQL"]);
				//Commande après commande, nous appliquons les changements demandés à la base MySQL
				foreach ($_POST["Commandes"] as $ind => $val) {
					foreach ($val as $UneCommande) {
						$Coul = (mysqli_query($GLOBALS["___mysqli_ston"], $UneCommande)) ? $CoulFond[$rendu] : $ErroFond[$rendu] ;
						echo '<p style="background-color: #'.$Coul.'">';
						echo $UneCommande;
						echo '</p>';
						$rendu = abs($rendu -1);
					}
				}
			}
			echo '<br /><br />';
			echo '<h3><a href="../">'.$MyLng['ResultData_1'].'</a></h3>';
			echo '<br /><br />';
		}
		include_once "application/controllers/administration/update_3a.php";
		echo '<br /><br />';
		echo '<input type="submit" value="'.$MyLng['Intro_5'].'" class="button	primary"/>';
?>