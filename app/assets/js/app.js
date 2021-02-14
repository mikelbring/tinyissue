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

function addUserProject(project_id, user, cettepage) {
	var Exactement = siteurl + "app/application/controllers/ajax/ProjectAddMbr.php";
	Exactement = Exactement + "?Projet=" + project_id;
	Exactement = Exactement + "&User=" + user;
	Exactement = Exactement + "&CettePage=" + cettepage;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if ( this.responseText  != "") {
				document.getElementById('projetProsedNamesList').innerHTML = "";
				document.getElementById('sidebar-users').innerHTML = document.getElementById('sidebar-users').innerHTML + '<li id="project-user' + user + '">' + this.responseText + '</li>';
				if (cettepage == 'page') {
					document.getElementById('projetProsedNamesPage').innerHTML = "";
					document.getElementById('page-users').innerHTML = '<td>' + this.responseText + '</td><td></td><td></td>';
				}
			}
		}
	};
	xhttp.open("GET", Exactement, true);
	xhttp.send(); 
}

function Issue_ChgListMbre(NumProj) {
	var Exactement = siteurl + "app/application/controllers/ajax/ListMbr.php"
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

function propose_project_user(user, project_id, cettepage) {
	var Exactement = siteurl + "app/application/controllers/ajax/ProjectAddMbrListe.php";
	Exactement = Exactement + "?Projet=" + project_id;
	Exactement = Exactement + "&User=" + user;
	Exactement = Exactement + "&CettePage=" + cettepage;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
			if (cettepage == 'sidebar') {
				document.getElementById('projetProsedNamesList').innerHTML = this.responseText;
			} else if (cettepage == 'page') {
				document.getElementById('projetProsedNamesPage').innerHTML = this.responseText;
			}
	    }
	};
	xhttp.open("GET", Exactement, true);
	xhttp.send(); 
}

function remove_project_user(user_id, project_id,ProjSuppMbre, cettepage) {
	if(!confirm(ProjSuppMbre)){
		return false;
	}

	saving_toggle();

	$.post(siteurl + 'ajax/project/remove_user', {
		user_id : user_id,
		project_id : project_id
	}, function(data){
		$('#project-user' + user_id).fadeOut();
		saving_toggle();
		if (cettepage == 'page') {
			document.getElementById('project-user_' + user_id).class = "";
			document.getElementById('project-user_' + user_id).innerHTML = "";
		}
	});

	return true;
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

