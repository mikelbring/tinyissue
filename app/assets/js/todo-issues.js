$(function(){
  // Set up buttons (do this by ajax to avoid hacking in to project/issues models etc.).
  $.post(
      siteurl + 'ajax/todo/get_user_todos', 
      { }, 
      function( returned ) {
        // Generate list of current todo items.
        var todo_issues = [];
        for (todo in returned) {
          todo_issues.push(returned[todo]["issue_id"]);
        }
        
        console.log(returned);
        
        // Apply button classes as needed.
        $('a.todo-button').each(function() {
          var issue_id = "" + $(this).data('issue-id');
          if (todo_issues.indexOf(issue_id) >= 0) {
            $(this).removeClass('add');
            $(this).addClass('del');
            $(this).prop('title', 'Remove from your todos.');
          }
        })
      }, "json" );

  
  // AJAX interactions on issues.
  $('a.todo-button').click(function(event) {
    event.preventDefault();
    
    var issue_id = $(this).data('issue-id');
    
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
            $('#issue-id-' + issue_id).prop('title', 'Remove from your todos.');
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
            $('#issue-id-' + issue_id).prop('title', 'Add to your todos.');
          }
          else {
            alert(data.errors);
          }
        }, "json" );
    }
    
  });
});
