<?php
$prefixe = "";
while (!file_exists($prefixe."config.app.php")) {
	$prefixe .= "../";
}
$config = require $prefixe."config.app.php";
$dataSrc = mysqli_connect($config['database']['host'], $config['database']['username'], $config['database']['password'], $config['database']['database']);

function Explose ($requ) {
	Global $dataSrc;
	$resu = Requis($requ, $dataSrc);
	return (Nombre($resu) > 0) ? Fetche ($resu) : '';
}

function Fetche ($resultat) {
	return mysqli_fetch_assoc ($resultat);
}


function Nombre ($base) {
	return (is_bool($base) || is_null($base)) ? 0 : mysqli_num_rows($base);
}

function NumID () {
	global $dataSrc;
	return mysqli_insert_id($dataSrc);
}

function Requis($requete) {
	global $dataSrc;
	$result = mysqli_query ($dataSrc, $requete);
	return $result;
}

?>
