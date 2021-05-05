<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title></title>
<meta name="copyright" content="Patrick Allaire">
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">
<meta http-equiv="content-style-type" content="text/css">
</head>
<body>
<table width="100%"><tr>
<?php
$prefixe = $_SESSION["prefixe"] ?? "../"; 
//var_dump($_SESSION);
$agit = false;
$NomFichier = array();
$NomRepertoire = array();
if (isset($NumMbre) && !isset($_SESSION["EnAdmin"])) {
	$chemin = $prefixe."uploads/".$NumMbre;
	$Chemin = $chemin;
	$handle=opendir($chemin);
	while ($file = readdir($handle)) {
		if (!is_dir($file) && (strtolower(substr($file, -3)) == 'jpg' || strtolower(substr($file, -4)) == 'jpeg'  || strtolower(substr($file, -3)) == 'png'  || strtolower(substr($file, -3)) == 'gif' )) {
			$NomFichier[] = $file;
		}
	}
	$agit = true;
}
unset($_SESSION["Historique"]);
if (isset($_SESSION["AdminEcole"]) && isset($_SESSION["EnAdmin"])) {
	unset($NomFicher);
	$chemin = $prefixe."Ecoles/".$_SESSION["AdminEcole"]."/images".@$_GET["SousRep"];
	$Chemin = substr($chemin, strlen($prefixe));
	$handle=opendir($chemin);
	while ($file = readdir($handle)) {
		if (is_dir($prefixe."Ecoles/".$_SESSION["AdminEcole"]."/images".@$_GET["SousRep"]."/".$file)) {
			if ( !in_array($file, array(".", ".."))) { $NomRepertoire[] = @$_GET["SousRep"].((@$_GET["SousRep"] != '') ? "/" : "").$file; }
		} else if (strtolower(substr($file, -3)) == 'jpg' || strtolower(substr($file, -4)) == 'jpeg' || strtolower(substr($file, -3)) == 'png' || strtolower(substr($file, -3)) == 'gif' ) {
			$NomFichier[] = $file;
		}
	}
	$agit = true;
}
if ($agit) {
	sort ($NomFichier);
	sort ($NomRepertoire);
	$compteRep = 0;
	foreach ($NomRepertoire as $indRep => $Rep) {
		$Rep = (substr($Rep, 0, 1) == "/") ? substr($Rep, 1) : $Rep;
		echo '<td>';
		echo '<a href="javascript:void(0);" onclick="ChangeRep(\''.$Rep.'\');" >';
		echo '<img src="'.$prefixe.'images/Admin/www/dossier0.png" width="150" border="0">';
		echo '<br />';
		echo $Rep;
		echo '</a>';
		echo '</td>';
		if (++$compteRep == 5) { echo '</tr><tr>'; }
	}
	$compte = 0;
	foreach ($NomFichier as $indice => $Fichier) {
		echo '<td>';
		echo '<a href="javascript:void(0);" onclick="ChoisitImage(\''.$Fichier.'\');" >';
		echo '<img src="'.$chemin.'/'.$Fichier.'" width="200" border="0">';
		echo '<br />';
		echo ''.$Fichier.'';
		echo '</a>';
		echo '</td>';
		if (++$compte == 5) { echo '</tr><tr>'; }
	}	
}
?>
</tr>
</table>
<script type="text/javascript" >
	var retenue = Array;
	retenue[0] = 'cke_72_textInput';
	retenue[1] = 'cke_79_textInput';
	retenue[2] = 'cke_82_textInput';
	retenue[3] = 'cke_85_textInput';
	retenue[4] = 'cke_91_textInput';
	retenue[5] = 'cke_94_textInput';
	retenue[6] = 'cke_97_textInput';
	var selects = opener.document.getElementsByTagName("input");
	var compte = 0;
	for (var i = 0; i < selects.length; i++) {
	    if(selects[i].id.indexOf("_textInput") > 3) {
	    		retenue[compte] =  selects[i].id;
	    		compte = compte + 1;
	    }
	} 

	function ChoisitImage (Quelle) {
		opener.document.getElementById(retenue[0]).value = '<?php echo $Chemin.'/';  ?>' + Quelle;
		if ( opener.document.getElementById(retenue[2]).value == 0 ) { opener.document.getElementById(retenue[2]).value = 200; }
		if ( opener.document.getElementById(retenue[3]).value == 0 ) { opener.document.getElementById(retenue[3]).value = 150; }
		if ( opener.document.getElementById(retenue[4]).value == 0 ) { opener.document.getElementById(retenue[4]).value = 0; }
		if ( opener.document.getElementById(retenue[5]).value == 0 ) { opener.document.getElementById(retenue[5]).value = 15; }
		if ( opener.document.getElementById(retenue[6]).value == 0 ) { opener.document.getElementById(retenue[6]).value = 15; }
		opener.document.getElementById(retenue[1]).focus();
		this.close();
	}
	
	function ChangeRep (Quel) {
		var actu = String(document.location);
		if (actu.indexOf("&SousRep")  > 0 ) { actu = actu.substr(0, actu.indexOf("&SousRep")); }
		document.location.href = actu + '&SousRep=/' + Quel;
	}
</script>
</body>
</html>
