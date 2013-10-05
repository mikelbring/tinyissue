$(function() {

	/* Uploadify */
	var uploaded_attachments = $('#uploaded-attachments');
	var upload_token = $('input[name=token]').val();
	var session = $('input[name=session]').val();
	var project = $('input[name=project_id]').val();

	$('#upload').uploadify({
		'uploader' : baseurl + '/app/assets/js/uploadify/uploadify.swf',
		'script' : siteurl + 'ajax/project/issue_upload_attachment',
		'scriptData' : {
			session : session,
			project_id : project,
			upload_token : upload_token
		},
		'cancelImg' : baseurl + '/app/assets/images/layout/icon-delete.png',
		'auto' : true,
		'multi' : true,
		'queSizeLimit' : 10,
		'onComplete' : function(event, id, file){
			
			var body = '<li id="' + id + '">' +
					'<a href="javascript:void(0);" class="delete" rel="' + id + '">Remove</a><span>' +
					file.name + '</span></li>';
			
			uploaded_attachments.append(body);
		}
	});

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
		return false;
	});

	discussion.find('li .delete').live('click', function(e){

		e.preventDefault();

		if(confirm('Are sure you want to delete this comment?')){

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

		$('#' + id + ' textarea').attr('disabled', 'disabled');

		saving_toggle();

		$.post(current_url + '/edit_comment', {
			body: discussion.find('#' + id + ' textarea').val(),
			id: id,
			csrf_token: $('input[name=csrf_token]').val()
		}, function(data){
			$('#' + id + ' textarea').removeAttr('disabled');
			$('#' + id + ' .comment-edit').hide();
			$('#' + id + ' .issue').html(data).show();
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

function remove_project_user(user_id, project_id){
	if(!confirm('Are you sure you want to remove this user from the project?')){
		return false;
	}

	saving_toggle();

	$.post(siteurl + 'ajax/project/remove_user', {
		user_id : user_id,
		project_id : project_id
	}, function(data){
		$('#project-user' + user_id).fadeOut();
		saving_toggle();
	});

	return true;
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

function issue_project_change(project_id, issue_id) {
   saving_toggle();

   $.post(siteurl + 'ajax/project/issue_project', {
      project_id : project_id,
      issue_id : issue_id
   },  function(){
       saving_toggle();
       window.location =  siteurl + 'project/' + project_id + '/issue/' + issue_id;
   });
}

function assign_issue_to_user(user_id, issue_id, callback){
   $.post(siteurl + 'ajax/project/issue_assign', {
      user_id : user_id,
      issue_id : issue_id
   }, function(){
      callback();
   });
}
