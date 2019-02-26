<?php
	function versionsSQL ($comparable) {
		$lesVersions = array();
		$prevUpdates = scandir(".");
		foreach ($prevUpdates as $ind => $nom) {
			if (substr($nom, 0, 8) == 'update_v' && !in_array($nom, $comparable) ) { $lesVersions[] = $nom; }
		}
		return $lesVersions;
	}
	
	$prevSQL = versionsSQL (array());
	var_dump($prevSQL);
	
	echo'<br /><br />';
	exec("sudo git pull", $chgmts);
	echo '------------ Liste des changements ----------------------<br />';
	var_dump($chgmts);
	echo '<br />';	
	echo '---------------- Fin de liste --------------------------';
	echo'<br /><br />';
	
	$aftrSQL = versionsSQL ($prevSQL);
	var_dump($aftrSQL);

	file_put_contents ("../install/get_updates_list", '');
?>