$(function() {

	/* Make external links target to _blank */

	var links = document.links;
	$(document.links).filter(function() {
		var Ceci = this.href;
    	if (Ceci.substr(0, 11) == 'javascript:') { return false; }
    	return this.hostname != window.location.hostname;
	}).attr('target', '_blank');

	/*
	//Patrick, 7 février 2021
	//Nous devons nous débarasser de ces références à des outils désuets
	
	//Ceci a un impact sur l'affichage et la sélection des étiquettes rattachées à un billet
	//Aussi sur les étiquettes du billet, en mode « Mofidication du billet »

	/* Uploadify */
	/*
	var uploaded_attachments = $('#uploaded-attachments');
	var upload_token = $('input[name=token]').val();
	var session = $('input[name=session]').val();
	var project = $('input[name=project_id]').val();
	*/

//	$("#upload").uploadify({
//		return true;
//	});

	uploaded_attachments.find('.delete').live('click', function(){
		var attachment = $(this);
		var id = attachment.attr('rel');
		var filename = $('#' + id).find('span').html();

		$.post(siteurl + 'ajax/project/issue_remove_attachment', {
			filename : filename,
			upload_token : upload_token,
			project_id : project
		}, function(){
			$('#' + id).fadeOut();
		})
	});

	/* Comment Actions */
	var discussion = $('.issue-discussion');

	discussion.find('li .edit').live('click', function(){
		var id = $(this).closest('.comment').attr('id');
		$('#' + id + ' .issue').hide();
		$('#' + id + ' .comment-edit').show();
		AffichonsEditor(id);
		return false;
	});

	discussion.find('li .delete').live('click', function(e){

		e.preventDefault();

		if(confirm('Are you sure you want to delete this comment?')){

			var saving = $('.global-saving span').html();
			$('.global-saving span').html('Deleting');
			$('.global-saving').show();

			var id = $(this).closest('.comment').attr('id');

			$.get('?delete=' + id, function(){
				$('#' + id).fadeOut();
				$('.global-saving').hide();
				$('.global-saving span').html(saving);
			});

		}

		return false;
	});

	discussion.find('li .save').live('click', function(){
		var id = $(this).closest('.comment').attr('id');

		var contenu = CachonsEditor(id);
		if (contenu == false) { contenu = discussion.find('#' + id + ' textarea').val(); }
		$('#' + id + ' textarea').attr('disabled', 'disabled');
		saving_toggle();

		$.post(current_url + '/edit_comment', {
			body: contenu,
			id: id,
			csrf_token: $('input[name=csrf_token]').val()
		}, function(data){
			$('#' + id + ' textarea').removeAttr('disabled');
			$('#' + id + ' .comment-edit').hide();
//			$('#' + id + ' .issue').html(data).show();
			$('#' + id + ' .issue').html(contenu).show();
			saving_toggle();
		});

	});

	discussion.find('li .cancel').live('click', function(){
		var id = $(this).closest('.comment').attr('id');

		$('#' + id + ' .comment-edit').hide();
		$('#' + id + ' .issue').show();
	});

});

/* Autocomplete for sidebar adding user */
var autocomplete_sidebar_init = false;

function assign_issue_to_user(user_id, issue_id, callback){
   $.post(siteurl + 'ajax/project/issue_assign', {
      user_id : user_id,
      issue_id : issue_id
   }, function(){
      callback();
   });
}

function issue_assign_change(user_id, issue_id){
   saving_toggle();

   assign_issue_to_user(user_id, issue_id, function(){

      var assigned_to = $('.assigned-to');
      var assign_to = assigned_to.find('.user' + user_id);

      assigned_to.find('.assigned').removeClass('assigned');
      assign_to.addClass('assigned');
      assigned_to.find('.currently_assigned').html(assign_to.html());

      saving_toggle();
   });

}

function init_sidebar_autocomplete(project){

	if(!autocomplete_sidebar_init){

		var users = $('.sidebar-users');

		$.getJSON(siteurl + 'ajax/project/inactive_users?project_id=' + project, function(data){
			var suggestions = [];

			$.each(data, function(key, value){
				suggestions.push(value);
			});

			var input = $('#add-user-project');

		   $(input).autocomplete({
				source: suggestions,
				select: function (event, ui){
					saving_toggle();

					$.post(siteurl + 'ajax/project/add_user', {
						user_id : ui.item.id,
						project_id : project
					}, function(data){
						saving_toggle();

						var append = '<li id="project-user' + ui.item.id + '">' +
								'<a href="javascript:void(0);" onclick="remove_project_user(' + ui.item.id + ', ' + project + ');" class="delete">Remove</a>' +
								'' + ui.item.label + '' +
								'</li>';

						users.append(append);
					});
				},
				close: function(event, ui){
					$('#add-user-project').val('');
				}
			});
		});

		autocomplete_sidebar_init = true;
	}

}

