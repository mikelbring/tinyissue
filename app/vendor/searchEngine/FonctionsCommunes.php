<?php
//Définition des variable de travail
$adresse = substr($_SERVER["HTTP_REFERER"], 0, strpos($_SERVER["HTTP_REFERER"], '//')).'//'.$_SERVER["SERVER_NAME"].substr($_SERVER["PHP_SELF"], 0, strpos($_SERVER["PHP_SELF"], 'app/vendor'));
$lesProj = array();
$prefixe = "";
while (!file_exists($prefixe."config.app.php")) {
	$prefixe .= "../";
}
$Config = require_once $prefixe."config.app.php";

//Vérification de sécurité vraiment minimale
if ($Config['database']['driver'] == 'mysql') {
	//Connexion à la base de données
	$db = mysqli_connect($Config['database']['host'],$Config['database']['username'],$Config['database']['password'],$Config['database']['database']);
	
	//Fonction de traitement des informations en base de données
	////Récupération du contenu des champs d'une sélection
	function Fetche ($resultat) {
		return mysqli_fetch_assoc ($resultat);
	}
	////Récupération du nombre de résultats obtenus
	function Nombre ($base) {
		return mysqli_num_rows($base);
	}
	////Obtention des résultats cherchés.
	function Requis($requete) {
		global $db;
		$result = mysqli_query ($db, $requete);
		return $result;
	}
}
?>