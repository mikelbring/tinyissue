<?php
		//Enregistrement des mises à jour antérieurement complétées
		$prevSQL = versionsSQL (array());
		file_put_contents('../install/historique.txt', implode(";", $prevSQL));
		
		//Consignes à l'utilisateur
		echo '<div style="margin-left: 5%;">';
		if (extension_loaded('zip')) { 
			echo $MyLng["choix_0"].'<br /><br />';
		} else {
			echo $MyLng["choix_4"].'<br /><br />';
		}
		if (extension_loaded('zip')) { 
			echo '<input name="Choix" value="1" type="radio" onClick="Afficher(1);" />'.$MyLng["choix_1"].'<br />';
			echo '<input name="Choix" value="2" type="radio" onClick="Afficher(2);" />'.$MyLng["choix_2"].'<br />';
			echo '<input name="Choix" value="3" type="radio" onClick="Afficher(3);" />'.$MyLng["choix_3"].'<br />';
			echo '</div>';
			echo '<div style="margin-left: 10%; margin-top: 15px; margin-bottom:40px; display: none;" id="div_3">';
		}
		echo $MyLng["Intro_0"].'.<br />'.$MyLng["Intro_1"].' : ';
		echo '<div style="margin-left: 5%;">';
		echo '<ul>';
		echo '<li>'.$MyLng["Intro_2"].' <a href="https://github.com/pixeline/bugs/archive/'.$verNum.'.zip">github.com/pixeline/bugs/archive/'.$verNum.'</a> </li>';
		echo '<li>'.$MyLng["Intro_3"].' : <code>git pull</code> </li>';
		echo '</ul>';
		echo '<br /><br />';
		echo '<br /><br />';
		echo '<a href="javascript: agissons.submit();">'.$MyLng["Intro_4"].'.</a>';
		echo '<br /><br />';
		echo '</div>';
		echo '</div>';
		echo '<br /><br />';
		echo '<input type="submit" value="'.$MyLng["Intro_5"].'" class="button	primary"/>';
?>
<script type="text/javascript" >
	function Afficher(Quel) {
		var forme = (Quel == 3) ? 'block' : 'none';
		document.getElementById('div_3').style.display = forme;
	}
</script>
