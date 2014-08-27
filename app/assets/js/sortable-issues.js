$(function() {
	$('#sortable-save').hide();
	
	// Apply sortable behaviours.
	$( "#sortable" ).sortable({
		placeholder: "sortable-li",
		change: function( event, ui ) {
			$('#sortable-save').show();
			$('#sortable-msg').text("Your new ordering is not yet saved.")
			$('#sortable-msg').removeClass('error');
		}
	});
	$( "#sortable" ).disableSelection();
	
	// Save it.
	$('#sortable-save-button').click(function(e){
    e.preventDefault();
    
		var weights = new Array();
		$('ul#sortable li').each(function (index) {
			weights.push($(this).data('issue-id'));
		});
    
    $.post(siteurl + 'ajax/sortable/project_issue', {
      "weights" : weights
    }, function(data){
			$('#sortable-save').hide();
			$('#sortable-msg').text("Changes saved");
		});    
  });
});
