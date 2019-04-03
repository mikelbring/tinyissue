<?php
	$colonnes = array(70,18, 50, 20, 18,18);
	$ChampDTE = "PRO.created_at";
	$ChampUSR = "PRO.default_assignee";
	$OrdreTRI = "PRO.name ASC";
	$PosiX = array('inactif0' => 150);
	$etOU = " WHERE ";
	$query  = "SELECT ";
	$query .= "PRO.name AS zero, ";
	$query .= "IF(PRO.status = 0, 'archived', 'active') AS prem, ";
	$query .= "CONCAT(UPPER(USR.lastname), ', ', USR.firstname) as deux, ";
	$query .= "DATE_FORMAT(PRO.created_at,'%Y-%m-%d') AS troi, ";
	$query .= "(SELECT count(id) FROM projects_issues AS ISSact WHERE ISSact.project_id = PRO.id AND closed_at IS NULL GROUP BY project_id) AS quat, ";
	$query .= "(SELECT count(id) FROM projects_issues AS ISScls WHERE ISScls.project_id = PRO.id AND closed_at IS NOT NULL GROUP BY project_id) AS cinq, ";
	$query .= "DATE_FORMAT(PRO.updated_at,'%Y-%m-%d') AS inactif0, ";
	$query .= "PRO.status AS status ";
	$query .= "FROM projects AS PRO ";
	$query .= "LEFT JOIN users AS USR ON USR.id = PRO.default_assignee ";
