<?php
$verActu = Config::get('tinyissue.version');
$verNum = 0;
$verCommit = "";
if (@fopen("https://github.com/pixeline/bugs/releases", 'r')) {
	$verDisp = file_get_contents( "https://github.com/pixeline/bugs/releases");
	$verDisp = substr($verDisp, strpos($verDisp, "Latest release"), 2600);
	$verNum = substr($verDisp, strpos($verDisp, '<span class="css-truncate-target" style="max-width: 125px">') + 59, 70);
	$verNum = trim(substr($verNum, 0, strpos($verNum, "<")));
	$verCommit = substr($verDisp, strpos($verDisp, '<svg class="octicon octicon-git-commit"'), 400); 
	$verCommit = substr($verCommit, strpos($verCommit,'<code>')+6);
	$verCommit = substr($verCommit, 0, strpos($verCommit, '<'));
}
if (@fopen("https://github.com/pixeline/bugs/blob/master/app/application/config/tinyissue.php", 'r')) {
	$Lisons = file_get_contents( "https://github.com/pixeline/bugs/blob/master/app/application/config/tinyissue.php");
	$Lisons = substr($Lisons, strpos($Lisons, "js-file-line-container"), 2000);
	$Lisons = substr($Lisons, strpos($Lisons, "LC4"), 400);
	$verCod = substr($Lisons, 123,3).'_'.substr($Lisons, 386, 2);
	$Lisons = substr($Lisons, 300);
//	$f = fopen("BAboom.txt", "w");
//	fputs($f, $Lisons);
//	$verCod .= '_'.substr($Lisons, 86, 2);
}
?>