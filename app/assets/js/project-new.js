$(function(){

	var users = $('.assign-users');

	$.getJSON(siteurl + 'ajax/project/inactive_users?project_id=0', function(data){
		var suggestions = [];

		$.each(data, function(key, value){
			suggestions.push(value);
		});

		var input = $('#add-user-project');

		$(input).autocomplete({
			source: suggestions,
			select: function (event, ui){

				var append = '<li class="project-user' + ui.item.id + '">' +
						'<a href="javascript:void(0);" onclick="$(\'.project-user' + ui.item.id + '\').remove();" class="delete">Remove</a>' +
						'' + ui.item.label + '' +
						'<input type="hidden" name="user[]" value="' + ui.item.id + '" />' +
						'</li>';

				users.append(append);
			},
			close: function(event, ui){
				$('#add-user-project').val('');
			}
		});
	});

});