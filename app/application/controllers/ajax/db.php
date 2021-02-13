<?php
	$config = require_once ("../../../../config.app.php");
	$db = mysqli_connect($config['database']['host'], $config['database']['username'], $config['database']['password'], $config['database']['database']);
	
function Explose ($requ) {
	$resu = Requis($requ);
	return (Nombre($resu) > 0) ? Fetche ($resu) : '';
}

function Fetche ($resultat) {
	return mysqli_fetch_assoc ($resultat);
//	return (is_bool($resultat) || is_null($resultat)) ? NULL : mysqli_fetch_assoc ($resultat);
}


function Nombre ($base) {
	return (is_bool($base) || is_null($base)) ? 0 : mysqli_num_rows($base);
}

function NumID () {
	global $db;
	return mysqli_insert_id($db);
}

function Requis ($requete) {
	global $db;
	$result = mysqli_query ($db, $requete);
//	if (!$result ) {
//		return NULL;
//	} else {
		return $result;
//	}
}
?>