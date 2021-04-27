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

	function AppliquerTest(Qui) {
		var compte = 0;
		for (x=0; x<champs.length; x++) {
			if (document.getElementById(champs[x]).style.backgroundColor == 'red' ) { return false; }
			if (document.getElementById(champs[x]).style.backgroundColor == 'yellow' ) { compte = compte + 1; }
		}
		if (compte > 0) { alert("Vous devez mettre à jour avant de tester"); return false; }

		var xhttp = new XMLHttpRequest();
		var NextPage = 'app/application/controllers/ajax/SendMail.php?Type=TestonsSVP&User=' + Qui;
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

	function ChangeonsText(Quel, Langue, Question) {
		var texte = CachonsEditor(9);
		var Enreg = (Question == 'OUI') ? true : false;
		if (texte != TexteInital && Enreg == false) { Enreg = confirm(Question); }
		var formdata = new FormData();
		formdata.append("Quel", Affiche);
		formdata.append("Enreg", Enreg);
		formdata.append("Prec", texte);
		formdata.append("Suiv", Quel);
		formdata.append("Titre", document.getElementById('input_TitreMsg').value);
		formdata.append("Lang", Langue);
		var xhttp = new XMLHttpRequest();
		var NextPage = 'app/application/controllers/ajax/ChgConfEmail_Textes.php';
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (xhttp.responseText != '' ) {
					Affiche = Quel;
					if (Question == 'OUI') { alert("Mise à jour complétée"); }
					TexteInital = xhttp.responseText;
					ChangeonsEditor(9, TexteInital);
					document.getElementById('input_TitreMsg').value = '';
				}
			}
		};
		xhttp.open("POST", NextPage, true);
		xhttp.send(formdata); 
	}

	var Affiche = "attached";	
	var TexteInital = ""
	setTimeout(function() { TexteInital = CachonsEditor(9); } , 1500);
