<?php
	$colonnes = array(30,70, 40, 20, 18,8);
	$colorStatus[0] = array(170,170,170);
	$colorStatus[1] = array(215,215,225);
	$ChampDTE = "PRO.created_at";
	$ChampUSR = "PRO.default_assignee";
	$OrdreTRI = "PRO.name ASC, TIK.status DESC, TIK.created_at ASC";
	$PosiX = array('inactif0' => 151.75);
	$etOU = " AND ";
	$query  = "SELECT ";
	$query .= "PRO.name AS zero, ";
	$query .= "TIK.title AS prem, ";
	$query .= "CONCAT(UPPER(USR.lastname), ', ', USR.firstname) as deux, ";
	$query .= "DATE_FORMAT(TIK.created_at,'%Y-%m-%d') AS troi, ";
	$query .= "(SELECT MAX(DATE_FORMAT(COMT.updated_at,'%Y-%m-%d')) FROM projects_issues_comments AS COMT WHERE COMT.issue_id = TIK.id GROUP BY issue_id )  AS quat, ";
	$query .= "(SELECT count(id) FROM projects_issues_comments AS COMM WHERE COMM.issue_id = TIK.id GROUP BY issue_id) AS cinq, ";
	$query .= "DATE_FORMAT(TIK.updated_at,'%Y-%m-%d') AS inactif0, ";
	$query .= "TIK.status AS status ";
	$query .= "FROM projects_issues AS TIK ";
	$query .= "LEFT JOIN projects AS PRO ON PRO.id = TIK.project_id ";
	$query .= "LEFT JOIN users AS USR ON USR.id = TIK.assigned_to ";
	$query .= "WHERE PRO.status = 1 ";

	$SautPage = true;