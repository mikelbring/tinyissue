<h3>
	<?php echo __('tinyissue.administration_update'); ?>
	<span><?php echo __('tinyissue.administration_update_description'); ?></span>
</h3>
<div class="pad">

<?php
function versionsSQL ($comparable) {
	$lesVersions = array();
	$prevUpdates = scandir("../install");
	foreach ($prevUpdates as $ind => $nom) {
		if (substr($nom, 0, 8) == 'update_v' && !in_array($nom, $comparable) ) { $lesVersions[] = $nom; }
	}
	return $lesVersions;
}

//Sécurisation de l'accès
$_SERVER ["HTTP_REFERER"] = $_SERVER ["HTTP_REFERER"] ?? 'Patates pilées';
$venant = substr($_SERVER ["HTTP_REFERER"], strpos($_SERVER ["HTTP_REFERER"], '//')+2);
$valableAdmin = $_SERVER ["SERVER_NAME"].substr($_SERVER["PHP_SELF"], 0, strlen($_SERVER["PHP_SELF"]) - 10).'/administration';
$valableUpadte = $_SERVER ["SERVER_NAME"].substr($_SERVER["PHP_SELF"], 0, strlen($_SERVER["PHP_SELF"]) - 10).'/administration/update';

if (($venant == $valableAdmin  || $venant == $valableUpadte) && isset($_POST["Etape"])) {
	//Fichier linguistique spécifique aux fonctions de mise à jour
	$updateEN = require_once("../app/application/language/en/update.php");
	if (file_exists("../app/application/language/".Auth::user()->language."/update.php")) { 
		$updateFR = require_once("../app/application/language/".Auth::user()->language."/update.php");
		$MyLng = array_merge($EnLng, $MyLng);
	} else { $MyLng = $updateEN; } 

	//Si une mise à jour a été laissée incomplète, nous reprendrons là où nous étions rendus en imposant Etape = 2
	include "../app/application/libraries/checkVersion.php";
	$Etape = file_exists('../install/historique.txt') ? 2 : $_POST["Etape"];
	$Etape = intval($Etape);
	
	//En-tête d'étape
	echo '<h3>'.$MyLng["Etape"].' '.$Etape.'</h3>';
	
	//Peu importe l'étape, nous aurons besoin du formulaire
	echo '<form action="" method="POST" id="agissons">';
	
	if ($Etape == 1) {
		//Enregistrement des mises à jour antérieurement complétées
		$prevSQL = versionsSQL (array());
		file_put_contents('../install/historique.txt', implode(";", $prevSQL));
		
		//Consignes à l'utilisateur
		echo $MyLng["Intro_0"].'.<br />'.$MyLng["Intro_1"].' : ';
		echo '<div style="margin-left: 5%;">';
		echo '<li>'.$MyLng["Intro_2"].' <a href="https://github.com/pixeline/bugs/archive/'.$verNum.'.zip">github.com/pixeline/bugs/archive/'.$verNum.'</a> </li>';
		echo '<li>'.$MyLng["Intro_3"].' : <code>git pull</code> </li>';
		echo '</div>';
		echo '<br /><br />';
		echo '<br /><br />';
		echo '<a href="javascript: agissons.submit();">'.$MyLng["Intro_4"].'.</a>';
		echo '<br /><br />';
		echo '<input type="submit" value="'.$MyLng["Intro_5"].'" class="button	primary"/>';
		
	} else if ($Etape == 2) {
		$CoulFond = array("FFFFFF", "CCCCCC");
		$hist = file_get_contents('../install/historique.txt');
		$prevSQL = explode(";", $hist);
		$prevSQL = versionsSQL($prevSQL);
		$rendu = 0;
		$renduFichier = 0;

		//S'il y a des fichier update_xyz, c'est que la nouvelle mise à jour exige des modifications à la base de données
		//Par souci de sécurité, nous imposons à l'usager de confirmer les étapes à franchir.
		if (count($prevSQL) == 0) {
			echo '<h3>'.$MyLng["updateData_1"].'</h3>';
		} else {
			echo '<h3>'.$MyLng["updateData_2"].'s : </h3>';
			foreach ($prevSQL as $fichier) {
					$compte = 0;
					unset($Separateur);
					$UneCommande = "";
					$Toutes = fopen("../install/".$fichier, "r");
					while ($LaCmd = fgets($Toutes)) {
						if (substr($LaCmd, 0, 9) == 'delimiter') {
							$Separateur = trim(substr($LaCmd, 11));
							$Separateur = substr($Separateur, 0, -1);
						} else if (isset($Separateur)) {
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
			echo '<input type="submit" value="'.$MyLng['updateData_3'].'" class="button	primary"/>';
		}
		unlink('../install/historique.txt');
		unlink('../install/config-setup.php');
	} else if ($Etape == 3) {
		$CoulFond = array("CCFFCC", "99CC99");
		$ErroFond = array("FFCCCC", "CC9999");
		$rendu = 0;
		$renduFichier = 0;
		require "../install/install.php";
		$install = new install();
		if ($install->check_connect()) {
			$prevSQL = explode(";", $_POST["prevSQL"]);
			foreach ($_POST["Commandes"] as $ind => $val) {
				foreach ($val as $UneCommande) {
					$Coul = (mysqli_query($GLOBALS["___mysqli_ston"], $UneCommande)) ? $CoulFond[$rendu] : $ErroFond[$rendu] ;
					echo '<p style="background-color: #'.$Coul.'">';
					echo $UneCommande;
					echo '</p>';
					$rendu = abs($rendu -1);
				}
			}
			echo '<br /><br />';
			echo '<h3><a href="../">'.$MyLng['ResultData_1'].'</a></h3>';
		}
	}
	
	echo '<input type="hidden" name="Etape" value="'.++$Etape.'" />';
	echo '</form>';
	file_put_contents ("../install/get_updates_list", '');

} else {
	echo 'Accès interdit';
	echo '<script>document.location.href="../";</script>';
}

?>
<br /><br />
</div>
