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
	if (file_exists("../app/application/language/".Auth::user()->language."/update.php") && Auth::user()->language != 'en') { 
		$updateFR = require_once("../app/application/language/".Auth::user()->language."/update.php");
		$MyLng = array_merge($updateEN, $updateFR);
	} else { $MyLng = $updateEN; } 

	//Si une mise à jour a été laissée incomplète, nous reprendrons là où nous étions rendus en imposant Etape = 2
	include "../app/application/libraries/checkVersion.php";
	$Etape = file_exists('../install/historique.txt') ? 2 : $_POST["Etape"];
	$Etape = intval($Etape);
	
	//En-tête d'étape
	echo '<h3>'.$MyLng["Etape"].' '.$Etape.' - '.$MyLng['Description_'.$Etape].'</h3>';
	
	//Peu importe l'étape, nous aurons besoin du formulaire
	echo '<form action="" method="POST" id="agissons">';
	
	if ($Etape == 1) {
		//Enregistrement des mises à jour antérieurement complétées
		$prevSQL = versionsSQL (array());
		file_put_contents('../install/historique.txt', implode(";", $prevSQL));
		include_once "application/controllers/administration/update_1.php";
	} else if ($Etape == 2) {
		//Installation du code source
		if (@$_POST["Choix"] == 1 || @$_POST["Choix"] == 2) {
			//Installation complètement automatisée
			include_once "application/controllers/administration/update_101.php";
		} else {
			//Installation manuelle
			////Consignes contenues dans update_xyz ... mise à jour de la base de données
			include_once "application/controllers/administration/update_2.php";
		}
	} else if ($Etape == 3) {
		//Application de modifications demandées sur la base de données ( les commandes énumérées en étapes précédentes ont été acceptées par l'usager )
		//nous ne traiterons ici que les commandes acceptées par l'usager
		include_once "application/controllers/administration/update_3.php";
	} else if ($Etape == 4) {
		echo '<script>document.location.href="../administration";</script>';
	}
	
	echo '<input type="hidden" name="Etape" value="'.++$Etape.'" />';
	echo '</form>';

	//Mise à jour de la liste des installations dans le fichier local
	file_put_contents ("../install/get_updates_list", '');
	$CetteVersion = include("../app/application/config/tinyissue.php");
	$MaDate = explode("-", $CetteVersion["release_date"]);
	$CetteVersion["release_date"] = (strlen($MaDate[0]) == 4) ? $CetteVersion["release_date"] : $MaDate[2].'-'.$MaDate[1].'-'.$MaDate[0];
	$val = \DB::query("SHOW tables");
	if (in_array('update_history', $val)) {
		\DB::table('update_history')->insert(array(
			'Description'=>$CetteVersion['version'].$CetteVersion['release'], 
			'DteRelease'=>$CetteVersion["release_date"], 
			'DteInstall'=>date("Y-m-d H:i:s")
		));
	}
} else {
	echo 'Accès interdit';
	echo '<script>document.location.href="../";</script>';
}

?>
<br /><br />
</div>
