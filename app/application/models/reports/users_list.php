<?php
		$colonnes = array(70, 22, 22, 18, 18, 45);
		$ChampDTE = "USR.created_at";
		$ChampUSR = "USR.id";
		$OrdreTRI = "USR.lastname ASC, USR.firstname ASC";
		$etOU = " AND ";
		$query  = "SELECT CONCAT(UPPER(USR.lastname), ', ', USR.firstname) as zero, ";
		$query .= "DATE_FORMAT(USR.created_at,'%Y-%m-%d') AS prem, ";
		$query .= "'active' AS deux, ";
		$query .= "(SELECT count(id) FROM projects_issues AS ISSact WHERE ISSact.assigned_to = USR.id AND closed_at IS NULL GROUP BY assigned_to) AS troi, ";
		$query .= "(SELECT count(id) FROM projects_issues AS ISScls WHERE ISScls.assigned_to = USR.id AND closed_at IS NOT NULL GROUP BY assigned_to) AS quat, ";
		$query .= "USR.language AS cinq, ";
		$query .= "1 AS status ";
		$query .= "FROM users AS USR ";
		$query .= "WHERE USR.firstname != 'admin' AND USR.lastname !='admin' ";
