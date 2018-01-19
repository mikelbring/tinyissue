<!DOCTYPE html>
<html>
<head>
<title>Reports installation</title>
<meta name="generator" content="Bluefish">
<meta name="author" content="Patrick Allaire, ptre">
<meta name="date" content="2018-01-02">
<meta name="copyright" content="Patrick Allaire, ptre">
<meta name="keywords" content="Links Bugs and Reports">
<meta name="description" content="">
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="expires" content="0">
</head>
<body>
<?php 
include_once "../app/application/language/all.php";

include "../app/vendor/Reports/en.php";  $en = $reports; 
if (file_exists("../app/vendor/Reports/".Auth::user()->language.".php")) { 
	include "../app/vendor/Reports/".Auth::user()->language.".php";
	$reports = array_merge($en, $reports);
}
$RepInstalled = false;
if (file_exists("vendor/Reports/config.php")) { 
	$RepInstalled = true; 
	$Configurations = file("vendor/Reports/config.php"); 
	$ReportsConfig = explode(",",$Configurations[0]);
	foreach($ReportsConfig as $ind => $val ) { $ReportsConfig[$ind] = substr($val, 1, strlen($val)-2); }
}
?>
<div style="text-align:center; width: 100%;">
<img src="../../app/vendor/Reports/ScreenShot.png" width="1200" alt=""/>
</div>

<div style="padding-top: 50px; padding-bottom: 75px; width: 75%; baground-color: #CCC; position: relative; left: 15%; font-size: 150%;">
<form name="LinkBugsReports" method="POST" action="reports">
<table width="100%" align="center" style="background-color: #edf0f0;  border-color: #000; border-radius: 15px;  border-style: solid;">
<tr><td colspan="2" style="border-top-left-radius: 15px; border-top-right-radius: 15px; text-align: center; font-weight: bold; color: #FFF; background-color: #162338; font-size: 175%; font-weight: bold; text-align:center;"><?php echo $reports['titre']; ?></td></tr>
<tr><td colspan="2" style="padding: 45px;"><?php echo (($RepInstalled) ? $reports["Apres"] : $reports["Avant"]);  ?><br /><br /><hr /></td></tr>
<?php if($RepInstalled) { ?>
<tr><td colspan="2" style="padding: 45px;"><?php echo $reports["LetGo"].' : <br /><a href="http://127.0.0.1/'.$ReportsConfig[0].'/'.$ReportsConfig[1].'" target="_blank" style="color:#00F;">http://127.0.0.1/'.$ReportsConfig[0].'/'.$ReportsConfig[1].'</a>';  ?><br /><br /><hr /></td></tr>
<?php } ?>
<tr>
	<td style="text-align:right;"><?php echo $reports["Rpath"]; ?> : </td>
	<td>http://127.0.0.1/<input name="Path" value="<?php echo (($RepInstalled) ? $ReportsConfig[0] : ''); ?>" size="30"></td>
</tr>
<tr>
	<td style="text-align:right;"><?php echo $reports["Bpath"]; ?> : </td>
	<td><input name="SubDir" value="<?php echo (($RepInstalled) ? $ReportsConfig[1] : 'Bugs'); ?>" size="10"></td>
</tr>
<tr>
	<td style="text-align:right;"><?php echo $reports["Rlang"]; ?> : </td>
	<td>
		<select name="language" id="language" style="background-color: #FFF;">
		<?php
			foreach ($Language as $ind => $lang) {
				echo '<option value="'.$ind.'" '.(($ind == Auth::user()->language) ? 'selected="selected"' : '').'>'.$lang.'</option>';
			}
		?>
		</select>
	</td>
</tr>
<tr><td colspan="2" style="padding: 45px; text-align: center;"><input type="submit" name="Soumettre" value="<?php echo $reports["FormS"];  ?>" /></td></tr>
</table>
</form>
</div>

</body>
</html>
