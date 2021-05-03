	var champs = new Array('input_email_from_name','input_email_from_email','input_email_replyto_name','input_email_replyto_email');
	function AppliquerCourriel() {
		var compte = 0;
		var intro = CachonsEditor(7);
		var bye = CachonsEditor(8);
		for (x=0; x<champs.length; x++) {
			if (document.getElementById(champs[x]).style.backgroundColor == 'red' ) { return false; }
			if (document.getElementById(champs[x]).style.backgroundColor == 'yellow' ) { compte = compte + 1; }
		}
		if (compte == 0 && intro == IntroInital && bye == TxByeInital) { return false; }
		for (x=0; x<champs.length; x++) {
			document.getElementById(champs[x]).style.backgroundColor = 'red';
		}

		var xhttp = new XMLHttpRequest();
		var formdata = new FormData();
		formdata.append("fName", document.getElementById('input_email_from_name').value);
		formdata.append("fMail", document.getElementById('input_email_from_email').value);
		formdata.append("rName", document.getElementById('input_email_replyto_name').value);
		formdata.append("rMail", document.getElementById('input_email_replyto_email').value);
		formdata.append("intro", document.getElementById('input_email_replyto_email').value);
		formdata.append("intro", intro);
		formdata.append("bye", bye);
		var NextPage = 'app/application/controllers/ajax/ChgConfEmail.php';
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (xhttp.responseText != '' ) {
					//alert(xhttp.responseText);
					for (x=0; x<champs.length; x++) {
						document.getElementById(champs[x]).style.backgroundColor = 'green';
					}
					IntroInital = intro; 
					TxByeInital = bye;
					var blanc = setTimeout(function() { for (x=0; x<champs.length; x++) { document.getElementById(champs[x]).style.backgroundColor = 'white'; } }, 5000);
				}
			}
		};
		xhttp.open("POST", NextPage, true);
		xhttp.send(formdata); 
	}

	function AppliquerServeur() {
		champs = new Array('input_email_encoding','input_email_linelenght','input_email_server','input_email_port','input_email_encryption','input_email_username','input_email_password');
		var compte = 0;
		for (x=0; x<champs.length; x++) {
			if (document.getElementById(champs[x]).style.backgroundColor == 'red' ) { return false; }
			if (document.getElementById(champs[x]).style.backgroundColor == 'yellow' ) { compte = compte + 1; }
		}
		if (compte == 0 && intro == IntroInital && bye == TxByeInital) { return false; }
		for (x=0; x<champs.length; x++) {
			document.getElementById(champs[x]).style.backgroundColor = 'red';
		}

		var xhttp = new XMLHttpRequest();
		var formdata = new FormData();
		formdata.append("fName", document.getElementById('input_email_from_name').value);
		formdata.append("fMail", document.getElementById('input_email_from_email').value);
		formdata.append("rName", document.getElementById('input_email_replyto_name').value);
		formdata.append("rMail", document.getElementById('input_email_replyto_email').value);
		formdata.append("intro", document.getElementById('input_email_replyto_email').value);
		formdata.append("intro", intro);
		formdata.append("bye", bye);
		var NextPage = 'app/application/controllers/ajax/ChgConfEmail.php';
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (xhttp.responseText != '' ) {
					//alert(xhttp.responseText);
					for (x=0; x<champs.length; x++) {
						document.getElementById(champs[x]).style.backgroundColor = 'green';
					}
					IntroInital = intro; 
					TxByeInital = bye;
					var blanc = setTimeout(function() { for (x=0; x<champs.length; x++) { document.getElementById(champs[x]).style.backgroundColor = 'white'; } }, 5000);
				}
			}
		};
		xhttp.open("POST", NextPage, true);
		xhttp.send(formdata); 
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
					var r = xhttp.responseText;
					var recu = r.split('||');
					TexteInital = recu[0];
					ChangeonsEditor(9, TexteInital);
					document.getElementById('input_TitreMsg').value = recu[1];
				}
			}
		};
		xhttp.open("POST", NextPage, true);
		xhttp.send(formdata);
	}

	function AppliquerPrefGen() {
	}

	var Affiche = "attached";
	var IntroInital = ""
	var TexteInital = ""
	var TxByeInital = ""
	setTimeout(function() { IntroInital = CachonsEditor(7); } , 1500);
	setTimeout(function() { TxByeInital = CachonsEditor(8); } , 1500);
	setTimeout(function() { TexteInital = CachonsEditor(9); } , 1500);
