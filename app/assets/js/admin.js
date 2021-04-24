	var champs = new Array('input_email_from_name','input_email_from_email','input_email_replyto_name','input_email_replyto_email','input_email_intro','input_email_bye');
	function AppliquerCourriel() {
		var compte = 0;
		for (x=0; x<champs.length; x++) {
			if (document.getElementById(champs[x]).style.backgroundColor == 'red' ) { return false; }
			if (document.getElementById(champs[x]).style.backgroundColor == 'yellow' ) { compte = compte + 1; }
		}
		if (compte == 0) { return false; }
		for (x=0; x<champs.length; x++) {
			document.getElementById(champs[x]).style.backgroundColor = 'red';
		}

		var xhttp = new XMLHttpRequest();
		var NextPage = 'app/application/controllers/ajax/ChgConfEmail.php?fName=' + document.getElementById('input_email_from_name').value + '&fMail=' + document.getElementById('input_email_from_email').value + '&rName=' + document.getElementById('input_email_replyto_name').value + '&rMail=' + document.getElementById('input_email_replyto_email').value + '&intro=' + document.getElementById('input_email_intro').value + '&bye='+document.getElementById('input_email_bye').value;
		xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (xhttp.responseText != '' ) {
				//alert(xhttp.responseText);
				for (x=0; x<champs.length; x++) {
					document.getElementById(champs[x]).style.backgroundColor = 'green';
				}
				var blanc = setTimeout(function() { for (x=0; x<champs.length; x++) { document.getElementById(champs[x]).style.backgroundColor = 'white'; } }, 5000);
				}
			}
		};
		xhttp.open("GET", NextPage, true);
		xhttp.send(); 
	}

	function AppliquerTest() {
		var compte = 0;
		for (x=0; x<champs.length; x++) {
			if (document.getElementById(champs[x]).style.back
			
			groundColor == 'red' ) { return false; }
			if (document.getElementById(champs[x]).style.backgroundColor == 'yellow' ) { compte = compte + 1; }
		}
		if (compte > 0) { alert("Vous devez mettre à jour avant de tester"); return false; }

		var xhttp = new XMLHttpRequest();
		var NextPage = 'app/application/controllers/ajax/SendMail.php?fName=TestonsSVP&User=<?php echo Auth::user()->id; ?>';
		xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (xhttp.responseText != '' ) {
				alert(xhttp.responseText);
			}
			}
		};
		xhttp.open("GET", NextPage, true);
		xhttp.send(); 
	}

	function ChangeonsText(Quel) {
		alert("Nous afficherons le texte suivant: " + Quel);
	}