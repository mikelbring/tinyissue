<?php
	//We'll here produce the costumized report
	if (isset($_POST["Titre"]) && isset($_POST["ChxColonnes"])) {
		$compte = 0;
		$colorStatus = array(
			0 => array(220,220,220),
			1 => array(255,255,255),
			2 => array(100,100,255),
			3 => array(100,255,100),
			4 => array(255,225,50),
			5 => array(255,70,70)
			);
		$rendu = "";
		$SautPage = false;
		$untel = "";

		function EnTeteCus ($pdf, $colonnes, $untel, $rappLng) {
			global $_POST;
			$pdf->AddPage();
			$pdf->SetFillColor(hexdec("DA"), hexdec("B4"), hexdec("35"));
			$pdf->Image("assets/images/layout/logo.png", 12,20,40,18,"png", "");
			$pdf->SetFont("Times", "B", 15);
			$pdf->Text(86, 28,utf8_decode($_POST["TitreRapport"]));
			$pdf->SetFont("Times", "", 10);
			$pdf->SetXY(10, 40);
			$pdf->SetFont("Times", "B", 12);
			for ($x=1; $x<count($colonnes); $x++) {
				$pdf->Cell($colonnes[$x], 15, utf8_decode($_POST["Titre"][$x]), 1, 0, "C", true, "");
			}
			$pdf->SetFont("Times", "", 10);
			$pdf->SetXY(10, 55);
		} //Fin de l'En-tête

		//Élaguage des données reçues, élimination des informations vides
		for ($x=1; $x<6; $x++) {
			if (trim($_POST["Titre"][$x]) == '' || trim($_POST["ChxColonnes"][$x]) == '&' || $_POST["LargColonne"][$x] == '0' ) {
				unset($_POST["Titre"][$x], $_POST["ChxColonnes"][$x], $_POST["LargColonne"][$x]);
			}
		}		
		//Définition des largeurs de colonne en termes de pixels
		$colonnes[0] = 0;
		foreach($_POST["LargColonne"] as $ind => $val) {
			$colonnes[] = 186 * ($val / 100) * $Ajusteur;
		}
		
		$query  = "SELECT CONCAT(TIK.id, '. ', TIK.title) AS title, TIK.created_at, TIK.duration, TIK.updated_at, ";
		$query .= "  TIK.closed_at, TIK.project_id AS projects_id, TIK.status, TIK.body, ";
		$query .= "	 PRO.name AS projet, ";
		$query .= "	 CONCAT (CRE.firstname, ' ', CRE.lastname) AS created_by, ";
		$query .= "	 CONCAT (UPD.firstname, ' ', UPD.lastname) AS updated_by, ";
		$query .= "  CONCAT (RES.firstname, ' ', RES.lastname) AS assigned_to, ";
		$query .= "  CONCAT (FER.firstname, ' ', FER.lastname) AS closed_by, ";
		$query .= "  PROG.weight AS weight ";
		$query .= "FROM projects_issues AS TIK ";
		$query .= "  LEFT JOIN projects AS PRO ON PRO.id = TIK.project_id ";
		$query .= "  LEFT JOIN users AS CRE ON CRE.id = TIK.created_by ";
		$query .= "  LEFT JOIN users AS UPD ON UPD.id = TIK.updated_by ";
		$query .= "  LEFT JOIN users AS RES ON RES.id = TIK.assigned_to ";
		$query .= "  LEFT JOIN users AS FER ON FER.id = TIK.closed_by ";
		$query .= "  LEFT JOIN users_todos AS PROG ON PROG.issue_id = TIK.id ";
		$query .= "WHERE  ";
		$query .= (@$_POST["ChxProjets"] == '') ? "" :  	"	TIK.project_id IN (".implode(",", $_POST["ChxProjets"]).") AND ";
		$query .= (@$_POST["Chxcreated_by"] == '') ? "" : 	"	TIK.created_by IN (".implode(",", $_POST["Chxcreated_by"]).") AND ";
		$query .= (@$_POST["Chxassigned_to"] == '') ? "" : "	TIK.assigned_to IN (".implode(",", $_POST["Chxassigned_to"]).") AND ";
		$query .= (@$_POST["Chxupdated_by"] == '' ) ? "" : "	TIK.updated_by IN (".implode(",", $_POST["Chxupdated_by"]).") AND ";
		$query .= (@$_POST["Chxclosed_by"] == '' ) ? "" : "	TIK.closed_by IN (".implode(",", $_POST["Chxclosed_by"]).") AND ";

		$query .= "	 TIK.created_at >= '".(($_POST["Deb_created_at"] == '') ? '1981-01-01' : $_POST["Deb_created_at"])."' AND ";
		$query .= "	 TIK.created_at <= '".(($_POST["Fin_created_at"] == '') ? date("Y-m-d") : $_POST["Fin_created_at"])."' AND ";
		$query .= "	 TIK.updated_at >= '".(($_POST["Deb_updated_at"] == '') ? '1981-01-01' : $_POST["Deb_updated_at"])."' AND ";
		$query .= "	 TIK.updated_at <= '".(($_POST["Fin_updated_at"] == '') ? date("Y-m-d") : $_POST["Fin_updated_at"])."' AND ";
		$query .= "	 TIK.closed_at >= '".(($_POST["Deb_closed_at"] == '') ? '1981-01-01' : $_POST["Deb_closed_at"])."' AND ";
		$query .= "	 TIK.closed_at <= '".(($_POST["Fin_closed_at"] == '') ? date("Y-m-d") : $_POST["Fin_closed_at"])."'  ";
		$tri = "";
		if (trim(@$_POST["OrderBy_1"]) != '') { $tri .= "	".$_POST["OrderBy_1"]." ".$_POST["OrderOrder_1"]." "; }
		if (trim(@$_POST["OrderBy_2"]) != '') { $tri .= ",	".$_POST["OrderBy_2"]." ".$_POST["OrderOrder_2"]." "; }
		$query .= ($tri == '') ? '' : "ORDER BY ".$tri;
		$results = \DB::query($query);

		//Production du rapport lui-même
		EnTeteCus ($pdf, $colonnes, $untel, $rappLng);

		foreach($results as $result) {
			if ($SautPage && $rendu != $result->title && $rendu != '') { EnTeteCus ($pdf, $colonnes, $untel,$rappLng); $compte = 0;}
			$rendu = $result->title;
			$contenu = array(
				'title' => $result->title,
				'created_at' => $result->created_at,
				'duration' => $result->duration,
				'updated_at' => $result->updated_at,
				'closed_at' => $result->closed_at,
				'projects_id' => $result->projects_id,
				'status' => __('tinyissue.priority_desc_'.$result->status),
				'body' => $result->body,
				'projects_id' => $result->projet,
				'created_by' => $result->created_by,
				'updated_by' => $result->updated_by,
				'assigned_to' => $result->assigned_to,
				'closed_by' => $result->closed_by,
				'weight' => (($result->weight == 0 || $result->weight == '') ? 0 : $result->weight)." %"
			);
			$pdf->SetTextColor($colorFont[$result->status]);
			$pdf->SetFillColor($colorStatus[$result->status][0],$colorStatus[$result->status][1],$colorStatus[$result->status][2]);
			$pdf->SetFillColor(255);
			for ($x=1; $x<count($colonnes); $x++) {
				$LaCol = explode("&", $_POST["ChxColonnes"][$x]);
				$pdf->Cell($colonnes[$x], 10, 	utf8_decode($contenu[$LaCol[0]]), 	1, (($x>=count($colonnes)-1) ? 1 : 0), (($colonnes[$x]  > 23) ? "L" : "C"), true, "");
				if (isset($PosiX['special0']) && isset($result->special0)) { $pdf->Text($PosiX['special0'], ($pdf->GetY())-1,  $result->special0); }
			}
			if (++$compte >= $NbLignes) { EnTeteCus ($pdf, $colonnes, $untel,$rappLng); $compte = 0;}
		}
	}
?>