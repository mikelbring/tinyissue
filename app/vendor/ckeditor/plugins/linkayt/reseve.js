//Reserve: ceci est le contenu des premières lignes de Messagerie.js
//Reserve: ceci fonctionnait bien avant de passer au mode « plugin »

var Adrs = "";
var AdrsDeb = 0;
var AdrsFin = 0;
var Attente = false;
var DernQuatre = new Array();
var Travail = "";

var CKcontenu = CKEDITOR.replace( 'contenu', { toolbar : 'Reduite',
	filebrowserImageBrowseUrl : 'outils/ckeditor_ChoisirImage.php',
	filebrowserImageUploadUrl : 'outils/ckeditor_RecevoirImage.php',
} );

//Merci à https://ckeditor.com/old/forums/CKEditor-3.x/Submit-Enter-key
var MonEditeur = CKEDITOR.instances.text_Messagerie;
MonEditeur.on("contentDom", function() {
   MonEditeur.document.on("keydown", function(event) {
   	DernQuatre.push(event.data.getKeystroke());
   	if (DernQuatre.length > 3) {
   		//Nous ne surveillons que les 4 dernières frappes
   		if (DernQuatre.length > 4) {
   			DernQuatre.shift();
   		}

			//Les 4 dernières frappent donnent « http », nous sommes donc en présence d'une adresse web
			if (DernQuatre[0] == '72' && DernQuatre[1] == '84' && DernQuatre[2] == '84' && DernQuatre[3] == '80') {
				Travail = MonEditeur.getData();
				AdrsDeb = Travail.length - 4;
				Travail = ""; 
				Attente = true; 
			}
			
			//Un lien complet a été inscrit, nous l'interpétons ici
			if (event.data.getKeystroke() == 32 && Attente == true) {
				Attente = false; 
				Travail = MonEditeur.getData();
				AdrsFin = Travail.length;
				Adrs = Travail.substring(AdrsDeb,AdrsFin);
				Adrs = Adrs.trim();
				Travail = ""; 
				
				//Affichage du lien				 
				var AdrsVue = Adrs;
				if (Adrs.substr(0, 17) == 'https://plongee.ca' || Adrs.substr(0, 18) == 'https://plongee.ca') { 
					if (Adrs.length == 17 || Adrs.length == 18 || Adrs=='https://plongee.ca/' || Adrs=='https://plongee.ca/') {  
						Adrs='index.php'; 
					} else { 
						Adrs = (Adrs.substr(0, 5) == 'http:') ? Adrs.substr(18) : Adrs.substr(19); 
					} 
					AdrsVue = 'Plongée ca!'; 
				}
				MonEditeur.insertHtml( '&nbsp; (<a href="' + Adrs + '">' + AdrsVue + '</a>) ' );
			}

//			//Un lien complet a été inscrit, nous l'interpétons ici
//			if (event.data.getKeystroke() == 32 && Attente == true) {
//				Attente = false; 
//				Travail = MonEditeur.getData();
//				AdrsFin = Travail.length;
//				var sel = MonEditeur.getSelection();
//				var element = sel.getStartElement();
//				sel.selectElement(element);
//				var ranges = MonEditeur.getSelection().getRanges();
//				alert("Voici la valeur retenue: " + ranges);
//				ranges[0].setStart(element.getFirst(), AdrsDeb);
//				ranges[0].setEnd(element.getFirst(), AdrsFin);
//				sel.selectRanges([ranges[0]]);
//				alert("Ici nous devrions avoir notre texte sélectionné");

			
   	}
   });

	//Surveillance des touches faites, afin de déterminer s'il y a lieu d'envoyer le message ( CTRL-enter )
   MonEditeur.document.on("keyup", function(event) {
      if( event.data.getKeystroke() == 1114125 ) {
		  	SoumettreMessage(); 
//		  	alert("Nous affirmons avoir tenté de soumettre le message");
//      	EnvoyonsCeci();
//      	document.getElementById('form_Messagerie').submit();
//      	alert("Nous avons reçu la touche enter en ligne 19 de Messagerie.js");
//      	return true;
//               MonEditeur.setData("");
//               MonEditeur.focus();
//               ajaxUpdates();
//               event.data.preventDefault();
//               return false;
      }
   });
});
      
