<?php
	$colonnes = array(70, 40, 20, 18,15,23);
	$colorStatus[0] = array(170,170,170);
	$colorStatus[1] = array(215,215,225);
	$ChampDTE = "TIK.created_at";
	$ChampUSR = "TIK.assigned_to";
	$OrdreTRI = "TIK.status DESC, TIK.created_at ASC,PRO.name ASC";
	$PosiX = array('special0' => 20,'special1' => 121.25,'special2' => 146);
	$etOU = " AND ";
	$query  = "SELECT ";
	$query .= "CONCAT(TIK.id, '. ', TIK.title) AS zero, ";
	$query .= "CONCAT(UPPER(USR.lastname), ', ', USR.firstname) as prem, ";
	$query .= "DATE_FORMAT(TIK.created_at,'%Y-%m-%d') AS deux, ";
	$query .= "CONCAT(datediff(NOW(), TIK.created_at), ' / ',duration) AS troi, ";
	$query .= "CONCAT((SELECT MAX(weight) FROM users_todos WHERE issue_id = TIK.id GROUP BY issue_id), ' %') AS quat, ";
	$query .= "(SELECT count(id) FROM projects_issues_comments AS COMM WHERE COMM.issue_id = TIK.id GROUP BY issue_id) AS cinq, ";
	$query .= "CONCAT('--', PRO.name) AS special0, ";
	$query .= "(SELECT MAX(DATE_FORMAT(COMT.updated_at,'%Y-%m-%d')) FROM projects_issues_comments AS COMT WHERE COMT.issue_id = TIK.id GROUP BY issue_id )  AS special1, ";
	$query .= "CONCAT(ROUND(datediff(NOW(), TIK.created_at)/duration*100), '%') AS special2, ";
	$query .= "TIK.status AS status ";
	$query .= "FROM projects_issues AS TIK ";
	$query .= "LEFT JOIN projects AS PRO ON PRO.id = TIK.project_id ";
	$query .= "LEFT JOIN users AS USR ON USR.id = TIK.assigned_to ";
	$query .= "WHERE PRO.status = 1 AND TIK.status > 0 ";

	$SautPage = false;