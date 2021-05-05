<?php
	if (!isset($_SESSION)) { session_start(); }
	if (!isset($NumMbre) && isset($_SESSION["ID"]) ) { $NumMbre = $_SESSION["ID"]; }
	if (!isset($NumMbre)) {
		include "../outils/Securite/AccesBase.php";
		include "../outils/FonctionsCommunes.php";
		$QuelMBRE = Explose("SELECT id_perso FROM plongee_archives WHERE  Details LIKE '".$_SERVER["REMOTE_ADDR"]."_".(round(time()/1000)*1000)." en composition de texte%'");
		$NumMbre = (isset($QuelMBRE["id_perso"])) ? $QuelMBRE["id_perso"] : $_SESSION["ID"];    
	}
	if ($_FILES["upload"]['size'] > 0 && isset($NumMbre) ) {
		$destination_dir = "../images/Membres/Edition/".$NumMbre;
		if (isset($_SESSION["AdminEcole"]) && isset($_SESSION["EnAdmin"])) { $destination_dir = "../Ecoles/".$_SESSION["AdminEcole"]."/images"; }
		if (@$_SESSION["Agit"] == "EditonsUrgenceSite" && isset($_SESSION["NumSite"])) { $destination_dir = "../images/Sites/".$_SESSION["NumSite"]."/PlanUrgence/"; }

		if (!file_exists($destination_dir)) { 
			mkdir($destination_dir, 0755);
			copy ( $destination_dir."/../index.php", $destination_dir."/index.php");
			copy ( $destination_dir."/../index.htm", $destination_dir."/index.htm");
			copy ( $destination_dir."/../index.html", $destination_dir."/index.html");
		}
		include_once "../Langues/FR/outils.php";
		include_once "../outils/TraiterImage.php";
		$_POST["Confirmer"] = "oui";
		$NomFinal = substr($_FILES["upload"]["name"],0, (strlen($_FILES["upload"]["name"])-4));
		$NomFinal = str_replace(" ", "", $NomFinal);
		Telechargement ($_FILES["upload"], $destination_dir, $NomFinal, $LargeurFinale = 450, $HauteurFinale = 300, $Sens = "Horiz", $NumMbre);
?>
		<script>
			for(NumRef=90; NumRef<1900; NumRef++) {
				if (parent.document.getElementById('cke_' + NumRef + '_label')) {
					if (parent.document.getElementById('cke_' + NumRef + '_label').innerHTML == 'OK') {
						break; 
					}
				}
			}
			//De base, on peut attendre que le bouton OK porte le numéro 138
			//Dans ce cas, les valeurs qui nous intéressent seront 57, 67, 70, 76, 79, 82, 85 et 138
			//Ddonc les valeurs calculées se font en soustrayant   81, 71, 68, 62, 59, 56, 53 et 0
			parent.document.getElementById('cke_' + (NumRef - 81) + '_textInput').value = "<?php echo (($_SERVER['SERVER_NAME'] == "127.0.0.1") ? 'http://127.0.0.1/MesSites/Plongee/' : 'https://plongee.ca/' ); ?><?php echo substr($destination_dir, 3).'/'.$NumMbre.'_'.$_FILES["upload"]["name"]; ?>";
			parent.document.getElementById('cke_' + (NumRef - 71) + '_textInput').value = "200";
			parent.document.getElementById('cke_' + (NumRef - 68) + '_textInput').value = "150";
			parent.document.getElementById('cke_' + (NumRef - 62) + '_textInput').value = "0";
			parent.document.getElementById('cke_' + (NumRef - 59) + '_textInput').value = "15";
			parent.document.getElementById('cke_' + (NumRef - 56) + '_textInput').value = "15";
			parent.document.getElementById('cke_' + (NumRef - 53) + '_select').selectedIndex = 1;
			parent.document.getElementById('cke_' + (NumRef - 0) + '_label').click();
		</script>
		
<?php
	} else {
		$MsgErr = array($LngOutils[0], 
			$LngOutils[1], 
			$LngOutils[2], 
			$LngOutils[3]."( ".sys_get_temp_dir()." ) ", 
			$LngOutils[4], 
			$LngOutils[5], 
			$LngOutils[6], 
			$LngOutils[7] 
			);
		echo '<script>alert("'.$LngOutils[8].'.\n'.$MsgErr[$_FILES['upload']['error']].'");</script>';
	}
