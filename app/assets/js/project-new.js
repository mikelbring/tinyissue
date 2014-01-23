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

    var selected,
        isSameElement = function(el1, el2) {
            return (el1 && el1.find('input').val() === el2.find('input').val());
        };
    users.on({
        mouseenter: function() {
            $(this).addClass('default-assignee');
        },
        mouseleave: function() {
            var user = $(this);
            if (isSameElement(selected, user)) {
                return false;
            }
            user.removeClass('default-assignee');
        },
        click: function() {
            var user = $(this);
            if (selected) {
                selected.removeClass('default-assignee');
                if (isSameElement(selected, user)) {
                    $('#default_assignee-id').val('');
                    return false;
                }
            }
            selected = $(this);
            selected.addClass('default-assignee');
            $('#default_assignee-id').val(selected.find('input').val());
        }
    }, 'li');
});