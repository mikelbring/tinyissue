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
	exec("git pull", $chgmts);
	var_dump($chgmts);	
	echo'<br /><br />';
	
	$aftrSQL = versionsSQL ($prevSQL);
	var_dump($aftrSQL);
	
?>