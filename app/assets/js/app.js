$(function(){

   if($('.global-notice').html().length > 0){

   	$('.global-notice').slideDown();

   	setTimeout(function(){
   		$('.global-notice').slideUp();
   	}, 7500);

   	$('.global-notice').live('click', function(){
   		$('.global-notice').slideUp();
   	});
   }
});

var saving = false;

function Issue_ChgListMbre(NumProj) {
	var Exactement = "../../../../app/application/controllers/ajax/ListMbr.php"
	Exactement = Exactement + "?Projet=" + NumProj;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
			document.getElementById('project_newSelectResp').innerHTML = this.responseText;
	    }
	};
	xhttp.open("GET", Exactement, true);
	xhttp.send(); 
}

function saving_toggle(){
	if(saving){
		$('.global-saving').hide();
		saving = false;
	}else{
		$('.global-saving').show();
		saving = true;
	}
}
