$(function(){
  $('a.todo-button').click(function(event) {
    event.preventDefault();
    
    var issue_id = $(this).data('issue-id');
    var ajax_result = false;
    
    // Adding items to todo list.
    if ($(this).hasClass('add')) 
    {
      $.post(
        siteurl + 'ajax/todo/add_todo', 
        { "issue_id" : issue_id }, 
        function( data ) {
          if (data.success) {
            $('#issue-id-' + issue_id).removeClass('add');
            $('#issue-id-' + issue_id).addClass('del');
            $('#issue-id-' + issue_id).prop('title', 'Remove from todo list');
          }
          else {
            alert(data.errors);
          }
        }, "json" );
    }
    
    // Removing items from todo list.
    else if ($(this).hasClass('del')) 
    {
      $.post(
        siteurl + 'ajax/todo/remove_todo', 
        { "issue_id" : issue_id }, 
        function( data ) {
          if (data.success) {
            $('#issue-id-' + issue_id).removeClass('del');
            $('#issue-id-' + issue_id).addClass('add');
            $('#issue-id-' + issue_id).prop('title', 'Add to todo list');
          }
          else {
            alert(data.errors);
            console.log(data.data);
          }
        }, "json" );
    }
    
  });
});
