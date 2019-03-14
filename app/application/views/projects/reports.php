<?php 
include_once "../app/vendor/Reports/en.php";  
$en = $Install; 
if (file_exists("../app/vendor/Reports/".Auth::user()->language.".php")) { 
	include "../app/vendor/Reports/".Auth::user()->language.".php";
}
$reports = array_merge($en, $Install);
if (file_exists("vendor/Reports/config.php")) { 
	include_once "vendor/Reports/config.php"; 
}
$ConfigExiste = (file_exists('vendor/Reports/BugsRepConfig.php')) ? true : false;

?>

<div style="padding-top: 50px; padding-bottom: 75px; width: 75%; baground-color: #CCC; position: relative; left: 15%; font-size: 150%;">

<table width="100%" align="center" style="background-color: #edf0f0;  border-color: #000; border-radius: 15px;  border-style: solid;">
<tr><td colspan="2" style="border-top-left-radius: 15px; border-top-right-radius: 15px; text-align: center; font-weight: bold; color: #FFF; background-color: #162338; font-size: 175%; font-weight: bold;"><?php echo $Reports[Auth::user()->language]; ?><br clear="all" /><img src="../app/vendor/Reports/ScreenShot.png" width="90%" alt=""/></td></tr>
<?php 
if(!$RepInstalled) {
	echo '<tr>';
	echo '<td colspan="2" style="padding: 45px; color: #FFF; background-color: #162338; font-size: 125%; font-weight: bold ">';
	if ($ConfigExiste) {
		echo $Install['Etape'][0];
		echo '<span style="color: #f8e81c; font-decoration: italic;">'.substr($_SERVER["SCRIPT_FILENAME"], 0, -9).'vendor/Reports/<u>BugsRepConfig.php</u></span> ';
		echo '<br />';
		echo $Install['Etape'][1];
		echo '<br />';
		echo '<span style="color: #f8e81c; font-decoration: italic;">'.$ReportsConfig[0].'</span> ';
		echo '<br />';
	} else {
		echo $Install['Infos'].'<br /><br />'.(($RepInstalled) ? $reports["Apres"] : $reports["Avant"]);
	}
	echo '</td>';
	echo '</tr>';
}
if($RepInstalled) {
	echo '<tr>';
	echo '<td colspan="2" style="padding: 45px;">';
	echo $reports["LetGo"].' : <br /><a href="'.$ReportsConfig[0].'" target="_blank" class="links" style="color:#00F;">'.$ReportsConfig[0].'</a>';
	echo '<br /><br />';
	echo '<hr />';
	echo '</td>';
	echo '</tr>';
} else {
	if ($ConfigExiste) {
		echo '<form name="LinkBugsReports" method="POST" action="reports" >';
		echo '<input name="Etape" value="Activation" type="hidden" />';
		echo '<tr>';
		echo '<td width="70%" style="text-align:right; background-color: #CCC; padding-top: 45px;">';
		echo $reports["Cfrmt"];
		echo '<td width="30%" style="text-align:left; background-color: #CCC; padding-top: 45px; padding-left: 1%;">';
		echo '<input name="Installed" value="true" type="radio" /">&nbsp;'.$Install['Ouais'];
		echo '<br />';
		echo '<input name="Installed" value="false" type="radio" checked="checked" /">&nbsp;'.$Install['Nenni'];
		echo '</td>';
		echo '</tr>';
	} else {
		echo '<form name="LinkBugsReports" method="POST" action="reports" onsubmit="return Verifie()"  >';
		echo '<input name="Etape" value="Definition" type="hidden" />';
		echo '<tr>';
		echo '<td style="text-align:right; background-color: #CCC; padding-top: 45px;">';
		echo $reports["Rpath"];
		echo '<td style="text-align:left; background-color: #CCC; padding-top: 45px; padding-left: 1%;">';
		echo '<input name="Path" id="input_Rpath"  value="'.(($RepInstalled) ? $ReportsConfig[0] : '').'" size="30" placeholder="http://127.0.0.1/Reports/">';
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td style="text-align:right; background-color: #CCC;">'.$reports["Rlang"].' : </td>';
		echo '<td style="text-align:left; background-color: #CCC; padding-left: 1%;">';
		echo '<select name="language" id="language">';
		include_once "../app/application/language/all.php";
		foreach ($Language as $ind => $lang) {
			echo '<option value="'.$ind.'" '.(($ind == Auth::user()->language) ? 'selected="selected"' : '').'>'.$lang.'</option>';
		}
		echo '</select>';
		echo '</td>';
		echo '</tr>';
	}
	echo '<tr>';
	echo '<td colspan="2" style="padding: 45px; background-color: #CCC; text-align: center; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;  ">';
	echo '<input type="submit" name="Soumettre" value="'.$reports["FormS"].'" />';
	echo '</td>';
	echo '</tr>';
	echo '</table>';
	echo '</form>';
} 
?>
</div>
<script type="text/javascript" >
	function Verifie() {
		var resu = true;
		var msg = '';
		var Rpath = document.getElementById('input_Rpath').value;
		if (resu == true && Rpath.trim() == '')  {
			msg = msg + "Vous devez indiquer le chemin complet menant aux rapports";
			resu = false;
		}
		if (resu == true && Rpath.substr(0, 7)  != 'http://' && Rpath.substr(0, 8)  != 'https://')  {
			msg = msg + "Vous devez indiquer un chemin complet commençant par http:// ou https://";
			resu = false;
		}
		if (msg != '') { alert(msg); }
		return resu;
	}
</script>
</body>
</html>
