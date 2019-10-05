<div id="div_Recherche" class="ResuRech" style="width: 100%; background: #38404f; color: #f8e81c;">
<div style="text-align: center;">
<input type="text" name="Chercher" placeholder="<?php echo __('tinyissue.search'); ?>" onkeyup="if(this.value.length > 3) { Cherchons(this.value); } else { document.getElementById('div_ResultatsRech').innerHTML = ''; }" />
</div>
<div id="div_ResultatsRech">
</div>
</div>

<script type="text/javascript" >
function Cherchons(Quoi) {
	var Exactement = "<?php echo $prefixe; ?>app/vendor/searchEngine/Chercher.php?Quoi=" + Quoi + "&Qui=<?php echo Auth::user()->id; ?>";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
//		alert("Voici les valeurs : \nstate = " + this.readyState + "\nStatus = " +  this.status + "\En visant vers <?php echo $prefixe; ?>app/vendor/searchEngine/Chercher.php?Quoi=" );
	    if (this.readyState == 4 && this.status == 200) {
		   if (document.getElementById('sidebar_MenuDefault')) { document.getElementById('sidebar_MenuDefault').style.display = 'none'; }
		   if (document.getElementById('sidebar_Issues')) { document.getElementById('sidebar_Issues').style.display = 'none'; }
		   if (document.getElementById('sidebar_Projects')) { document.getElementById('sidebar_Projects').style.display = 'none'; }
		   if (document.getElementById('sidebar_Users')) { document.getElementById('sidebar_Users').style.display = 'none'; }
			var valeur = this.responseText;
	    	document.getElementById('div_ResultatsRech').innerHTML = valeur;
	    }
	}
	xhttp.open("GET", Exactement, true);
	xhttp.send(); 
}
</script>