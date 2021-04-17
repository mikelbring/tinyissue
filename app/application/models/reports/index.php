<?php
//Définition des variables communes à tous les rapports
$rappLng = require ("application/language/en/reports.php"); 
if ( file_exists("application/language/".Auth::user()->language."/reports.php")) {
	$rappMaLng = require ("application/language/".Auth::user()->language."/reports.php");
	$rappLng = array_merge($rappLng, $rappMaLng);
}
$colonnes = array();
$config_app = require_once path('public') . 'config.app.php';
$compte = 0;
$colorFont = array(0,0,0,0,0,0);
$colorStatus = array(
	0 => array(220,220,220),
	1 => array(255,255,255),
	2 => array(100,100,255),
	3 => array(100,255,100),
	4 => array(255,225,50),
	5 => array(255,70,70)
	);
if (isset($config_app["PriorityColors"])) {
	foreach ($config_app["PriorityColors"] as $ind => $val ) {
		if ($config_app["PriorityColors"][$ind] == 'transparent') {
			$colorStatus[$ind] = array(255,255,255);
		} else if (strlen($config_app["PriorityColors"][$ind]) == 6 && hexdec($config_app["PriorityColors"][$ind])) {
			$colorStatus[$ind][0] = hexdec(substr(0, 2, $config_app["PriorityColors"][$ind]));
			$colorStatus[$ind][1] = hexdec(substr(2, 2, $config_app["PriorityColors"][$ind]));
			$colorStatus[$ind][2] = hexdec(substr(4, 2, $config_app["PriorityColors"][$ind]));
			if (hexdec($config_app["PriorityColors"][$ind]) < 10066329) { $colorFont[$ind] = 255; }
		}
	}
}
$rendu = "";
$SautPage = false;
$untel = "";

function EnTete ($pdf, $colonnes, $untel, $rappLng) {
	global $_POST;
	$pdf->AddPage();
	$pdf->SetFillColor(hexdec(substr($_POST["Couleur"], 0, 2)), hexdec(substr($_POST["Couleur"], 2, 2)), hexdec(substr($_POST["Couleur"], 4, 2)));
	$pdf->Image("assets/images/layout/logo.png", 12,20,40,18,"png", "");
	$pdf->SetFont("Times", "B", 15);
	$pdf->Text(86, 28,utf8_decode($rappLng[$_POST["RapType"]][0]));
	$pdf->SetFont("Times", "", 10);
	if (trim(@$_POST["DteInit"]) != '' ) { $pdf->Text(86, 32, " Date >= ".$_POST["DteInit"]); }
	if (trim(@$_POST["DteEnds"]) != '' ) { $pdf->Text(86, 35, " Date <= ".$_POST["DteEnds"]); }
	if (trim(@$_POST["FilterUser"]) > 0 ) {$pdf->Text(86, 38, " ... ".$untel); }

	$pdf->SetXY(10, 40);
	$pdf->SetFont("Times", "B", 12);
	foreach ($colonnes as $ind => $width) {
		$Lignes = explode("&&", $rappLng[$_POST["RapType"]][$ind+1]);
		if (count($Lignes) == 1) {
			$pdf->Cell($width, 15, utf8_decode($rappLng[$_POST["RapType"]][$ind+1]), 1, 0, "C", true, "");
		} else {
			$CePosiX = 13;
			$pdf->Cell($width, 15, utf8_decode($Lignes[0]), 0, 0, "C", true, "");
			for($x=0; $x<$ind; $x++) {
				$CePosiX += $colonnes[$x];
			}
			$pdf->Text($CePosiX, 53, utf8_decode($Lignes[1]), 1, 0, "C", true, "");
		}
	}
	$pdf->SetFont("Times", "", 10);
	$pdf->SetXY(10, 55);
}

//Ajustement de la largeur des colonnes en fonction du papier utilisé
$Ajusteur = 1;		//216mm x 279mm (Letter)
$NbLignes = 20;	//216mm x 279mm (Letter)
switch ($_POST["Papier"]) {
	case "A4":
		$Ajusteur = 210/216;	// 210mm
		$NbLignes =	21;		// 297mm
		break;
	case "B4":
		$Ajusteur = 250/216;	//250mm
		$NbLignes = 27;		// 353mm
		break;
	case "Legal":
		$NbLignes =	27;		// 356 mm 
}

//Selon le type de rapport demandé
include_once "application/models/reports/".$_POST["RapType"].".php";

if ($_POST["RapType"] != 'users_customized') {
	for ($x=0; $x<count($colonnes); $x++) {
		$colonnes[$x] = $colonnes[$x] * $Ajusteur;
	}
	////Definition de la requête, section du filtrage et du tri
	if (trim(@$_POST["DteInit"]) != '' ) { $query .= $etOU." ".$ChampDTE." >= '".$_POST["DteInit"]."' "; $etOU = " AND ";}
	if (trim(@$_POST["DteEnds"]) != '' ) { $query .= $etOU." ".$ChampDTE." <= '".$_POST["DteEnds"]."' "; $etOU = " AND ";}
	if (trim(@$_POST["FilterUser"]) > 0 ) { 
		$query .= $etOU." ".$ChampUSR." = '".$_POST["FilterUser"]."' "; 
		$etOU = " AND ";
		$Untel = \DB::table('users')->where('id', '=', $_POST["FilterUser"])->get();
		$untel = strtoupper($Untel[0]->lastname).', '.$Untel[0]->firstname; 
	}
	$query .= "ORDER BY ".$OrdreTRI;
	$results = \DB::query($query);
	
	
	//Production du rapport lui-même
	EnTete ($pdf, $colonnes, $untel,$rappLng);
	
	foreach($results as $result) {
		if ($SautPage && $rendu != $result->zero && $rendu != '') { EnTete ($pdf, $colonnes, $untel,$rappLng); $compte = 0;}
		$rendu = $result->zero;
		$pdf->SetFillColor($colorStatus[$result->status][0],$colorStatus[$result->status][1],$colorStatus[$result->status][2]);
		$pdf->Cell($colonnes[0],10, 	utf8_decode($result->zero), 	1, 0, (($colonnes[0]  > 23) ? "L" : "C"), true, "");
		$pdf->Cell($colonnes[1],10, 	utf8_decode($result->prem), 	1, 0, (($colonnes[1]  > 23) ? "L" : "C"), true, "");
		$pdf->Cell($colonnes[2],10, 	utf8_decode($result->deux),	1, 0, (($colonnes[2]  > 23) ? "L" : "C"), true, "");
		$pdf->Cell($colonnes[3],10,	utf8_decode($result->troi),	1, 0, (($colonnes[3]  > 23) ? "L" : "C"), true, "");
		$pdf->Cell($colonnes[4],10,	utf8_decode($result->quat),	1, 0, (($colonnes[4]  > 23) ? "L" : "C"), true, "");
		$pdf->Cell($colonnes[5],10,	utf8_decode($result->cinq), 	1, 1, (($colonnes[5]  > 23) ? "L" : "C"), true, "");
		if ($result->status == 0 && isset($PosiX['inactif0'])) { $pdf->Text($PosiX['inactif0'], ($pdf->GetY())-1,  $result->inactif0); }
		if ($result->status == 0 && isset($PosiX['inactif1'])) { $pdf->Text($PosiX['inactif1'], ($pdf->GetY())-1,  $result->inactif1); }
		if ($result->status == 0 && isset($PosiX['inactif2'])) { $pdf->Text($PosiX['inactif2'], ($pdf->GetY())-1,  $result->inactif2); }
		if ($result->status == 0 && isset($PosiX['inactif3'])) { $pdf->Text($PosiX['inactif3'], ($pdf->GetY())-1,  $result->inactif3); }
		if (isset($PosiX['special0']) && isset($result->special0)) { $pdf->Text($PosiX['special0'], ($pdf->GetY())-1,  $result->special0); }
		if (isset($PosiX['special1']) && isset($result->special1)) { $pdf->Text($PosiX['special1'], ($pdf->GetY())-1,  $result->special1); }
		if (isset($PosiX['special2']) && isset($result->special2)) { $pdf->Text($PosiX['special2'], ($pdf->GetY())-1,  $result->special2); }
		if (isset($PosiX['special3']) && isset($result->special3)) { $pdf->Text($PosiX['special3'], ($pdf->GetY())-1,  $result->special3); }
		if (++$compte >= $NbLignes) { EnTete ($pdf, $colonnes, $untel,$rappLng); $compte = 0;}
	}
}
