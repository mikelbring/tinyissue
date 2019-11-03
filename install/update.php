<?php


///////////////////////////////////////////////////////////////////////////////////////////
//                                                                                       //
//                                   Patrick                                             //
//                         Ce fichier n'est plus utilisé                                 //
//                         Néanmoins conservé « au cas-où »                              //
//                                                                                       //
//                                                                                       //
//                                   Voir plutôt                                         //
//                  app/application/view/administration/update/*.php                     //
//                                                                                       //
//                                                                                       //
///////////////////////////////////////////////////////////////////////////////////////////

function versionsSQL ($comparable) {
	$lesVersions = array();
	$prevUpdates = scandir(".");
	foreach ($prevUpdates as $ind => $nom) {
		if (substr($nom, 0, 8) == 'update_v' && !in_array($nom, $comparable) ) { $lesVersions[] = $nom; }
	}
	return $lesVersions;
}
include_once "../app/application/views/layouts/blocks/header.php";
$venant = substr($_SERVER ["HTTP_REFERER"], strpos($_SERVER ["HTTP_REFERER"], '//')+2);
$valableAdmin = $_SERVER ["SERVER_NAME"].substr($_SERVER["PHP_SELF"], 0, strlen($_SERVER["PHP_SELF"]) - 19).'/administration'; 


if (trim(@$_POST["versionYour"]) != '' && trim(@$_POST["versionDisp"]) != '' && trim(@$_POST["versionComm"]) != '' && $venant == $valableAdmin ) {
	$Etape = intval($_POST["Etape"]);
	echo '<form method="POST" id="agissons">';
	
	if ($Etape == 1) {
		$prevSQL = versionsSQL (array());
		echo '<input type="hidden" name="prevSQL" value="'.implode(";",$prevSQL).'" />';
		$zip = new ZipArchive;
		$MAJ = $zip->open("https://github.com/pixeline/bugs/archive/".$_POST["versionDisp"].".zip");
		echo ($MAJ) ? 'Nous avons le fichier en main' : 'Non, ça refuse de fonctionner';
		echo '<br />';
		 
	} else if ($Etape == 2) {
		$prevSQL = explode(";", $_POST["prevSQL"]);
	} else if ($Etape == 3) {
	} else if ($Etape == 4) {
	}
	
	var_dump($prevSQL);
	
	echo'<br /><br />';
	exec("sudo git pull", $chgmts);
	echo '------------ Liste des changements ----------------------<br />';
	var_dump($chgmts);
	echo '<br />';	
	echo '---------------- Fin de liste --------------------------';
	echo'<br />';
	
	$aftrSQL = versionsSQL ($prevSQL);
	var_dump($aftrSQL);

	file_put_contents ("../install/get_updates_list", '');

	echo '<input type="hidden" name="versionYour" value="'.$_POST["versionYour"].'" />';
	echo '<input type="hidden" name="versionDisp" value="'.$_POST["versionDisp"].'" />';
	echo '<input type="hidden" name="versionComm" value="'.$_POST["versionComm"].'" />';
	echo '<input type="hidden" name="Etape" value="'.++$Etape.'" />';
	echo '</form>';

} else {
	echo 'Accès interdit';
	echo '<script>document.location.href="index.php";</script>';
}
?><?php
function versionsSQL ($comparable) {
	$lesVersions = array();
	$prevUpdates = scandir(".");
	foreach ($prevUpdates as $ind => $nom) {
		if (substr($nom, 0, 8) == 'update_v' && !in_array($nom, $comparable) ) { $lesVersions[] = $nom; }
	}
	return $lesVersions;
}
include_once "../app/application/views/layouts/blocks/header.php";
$venant = substr($_SERVER ["HTTP_REFERER"], strpos($_SERVER ["HTTP_REFERER"], '//')+2);
$valableAdmin = $_SERVER ["SERVER_NAME"].substr($_SERVER["PHP_SELF"], 0, strlen($_SERVER["PHP_SELF"]) - 19).'/administration'; 


if (trim(@$_POST["versionYour"]) != '' && trim(@$_POST["versionDisp"]) != '' && trim(@$_POST["versionComm"]) != '' && $venant == $valableAdmin ) {
	$Etape = intval($_POST["Etape"]);
	echo '<form method="POST" id="agissons">';
	
	if ($Etape == 1) {
		$prevSQL = versionsSQL (array());
		echo '<input type="hidden" name="prevSQL" value="'.implode(";",$prevSQL).'" />';
		$zip = new ZipArchive;
		$MAJ = $zip->open("https://github.com/pixeline/bugs/archive/".$_POST["versionDisp"].".zip");
		echo ($MAJ) ? 'Nous avons le fichier en main' : 'Non, ça refuse de fonctionner';
		echo '<br />';
		 
	} else if ($Etape == 2) {
		$prevSQL = explode(";", $_POST["prevSQL"]);
	} else if ($Etape == 3) {
	} else if ($Etape == 4) {
	}
	
	var_dump($prevSQL);
	
	echo'<br /><br />';
	exec("sudo git pull", $chgmts);
	echo '------------ Liste des changements ----------------------<br />';
	var_dump($chgmts);
	echo '<br />';	
	echo '---------------- Fin de liste --------------------------';
	echo'<br />';
	
	$aftrSQL = versionsSQL ($prevSQL);
	var_dump($aftrSQL);

	file_put_contents ("../install/get_updates_list", '');

	echo '<input type="hidden" name="versionYour" value="'.$_POST["versionYour"].'" />';
	echo '<input type="hidden" name="versionDisp" value="'.$_POST["versionDisp"].'" />';
	echo '<input type="hidden" name="versionComm" value="'.$_POST["versionComm"].'" />';
	echo '<input type="hidden" name="Etape" value="'.++$Etape.'" />';
	echo '</form>';

} else {
	echo 'Accès interdit';
	echo '<script>document.location.href="index.php";</script>';
}
?>