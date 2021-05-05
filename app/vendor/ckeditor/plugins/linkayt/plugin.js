// Link as you type
( function() {
	var Adrs = "";													//Working variable
	var AdrsDeb = 0;												//Address of the link's firt type character  (the "h" of "http")
	var AdrsFin = 0;												//Address of the link's last typed character (space )
	var Attente = false;											//Awaiting for the end of the link which user is typing
	var DernQuatre = new Array();								//Working variable
	var InternalDescription = "Plongez ca!";				//The sentence you want to show when it's an internal link
	var InternalDestination = "http://plongee.ca";		//The internal link signature
	var InternalDestinationS = "https://plongee.ca";	//The secured internal link signature
	var InternalLink = "index.php";							//The page to refer to when an internal link is recognized
	var Travail = "";												//Empty working variable
	
	//Merci à https://ckeditor.com/old/forums/CKEditor-3.x/Submit-Enter-key
   CKEDITOR.plugins.add( 'linkayt', {
   	init: function( editor ) {
			//Submit the text  (submitting its form) by CTRL-ENTER
			editor.on( 'key', function( evt ) {
				if ( evt.data.keyCode == CKEDITOR.CTRL + 13 ) {
					if (typeof(EnvoyonsCeci) == "function") { 					//First: check if a specific function exists.   Here the function's name is: « EnvoyonsCeci »
						EnvoyonsCeci(); 													//If so: fire the specific function.   Here the function's name is: « EnvoyonsCeci »
					} else {
						document.getElementsByName('Soumettre')[0].click(); 	//Otherwise: click on the submit button, recongnized from its name  (Here, the name is « Soumettre » )
					}
					evt.cancel();
				}
			} );

			editor.on("contentDom", function() {
				editor.document.on("keydown", function(event) {
			   	DernQuatre.push(event.data.getKeystroke());
			   	if (DernQuatre.length > 3) {
			   		//Nous ne surveillons que les 4 dernières frappes
			   		if (DernQuatre.length > 4) {
			   			DernQuatre.shift();
			   		}
			
						//Les 4 dernières frappent donnent « http », nous sommes donc en présence d'une adresse web
						if ((DernQuatre[0] == '72' && DernQuatre[1] == '84' && DernQuatre[2] == '84' && DernQuatre[3] == '80') || (DernQuatre[0] == '104' && DernQuatre[1] == '116' && DernQuatre[2] == '116' && DernQuatre[3] == '112') ) {	
							Travail = editor.getData();
							AdrsDeb = Travail.length - 4;
							Travail = ""; 
							Attente = true; 
						}
						
						//Un lien complet a été inscrit, nous l'interpétons ici
						if (event.data.getKeystroke() == 32 && Attente == true) {
							Attente = false; 
							Travail = editor.getData();
							AdrsFin = Travail.length;
							Adrs = Travail.substring(AdrsDeb,AdrsFin);
							Adrs = Adrs.trim();
							Travail = Travail.substring(0, AdrsDeb); 
							
							//Affichage du lien				 
							var AdrsVue = Adrs;
							if (Adrs.substr(0, InternalDestination.length) == InternalDestination || Adrs.substr(0, InternalDestinationS.length) == InternalDestinationS) { 
								if (Adrs.length == InternalDestination.length || Adrs.length == InternalDestinationS.length || Adrs==InternalDestination + '/' || Adrs== InternalDestinationS + '/') {  
									Adrs = InternalLink; 
								} else { 
									Adrs = (Adrs.substr(0, 5) == 'http:') ? Adrs.substr(InternalDestination.length+1) : Adrs.substr(InternalDestinationS.length+1); 
								} 
								AdrsVue = InternalDescription; 
							}
							editor.insertHtml( '&nbsp; (<a href="' + Adrs + '">' + AdrsVue + '</a>) ' );
//							editor.setData( Travail + '&nbsp;<a href="' + Adrs + '">' + AdrsVue + '</a> ' );
							Travail = ""; 
//							editor.resetDirty();
						}
			
			   	}
			   });
		   });
		}
	} )
} )();