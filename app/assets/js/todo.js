$(function(){ 
  // Set widths of lanes (dynamically to allow configurable N lanes).
  var laneSpacing = 10;
  var borderWidth = 4;
  var totalWidth  = parseInt($('#todo-lanes').width());
  var laneCount   = parseInt($('.todo-lane').size());
  var laneWidth   = (totalWidth - (laneSpacing * laneCount)) / laneCount;
  $('.todo-lane').each(function() {
    $(this).css( "width", laneWidth - borderWidth);
  });
  
  // Draggable interaction.
  $('.todo-list-item.draggable').draggable({
     snap: '.todo-lane',
     snapMode: "inner",
     revert: "invalid",
     revertDuration: 200
  });
  
  // Droppable interaction.
  $('.todo-lane').droppable({
    activeClass: "todo-state-active",
    hoverClass:  "todo-state-hover",
    drop: function( event, ui ) {
      var new_status = $(this).data('status');
      var issue_id   = $(ui.draggable).data("issue-id");
      
      // Add the dragged todo to the new lane, reset css.
      var this_id = $(this).attr('id');
      $(ui.draggable).prependTo($('#' + this_id + ' .todo-lane-inner'));
      $(ui.draggable).css('left', 0);
      $(ui.draggable).css('top', 0);
      
      // Prevent closed items from being moved again.
      if (new_status == 0) {
        $(ui.draggable).draggable( "option", "disabled", true );
      }
      
      // POST the new status.
      $.post(
        siteurl + 'ajax/todo/update_todo', 
        { "issue_id" : issue_id, "new_status" : new_status}, 
        function( data ) {
          if (!data.success) {
            alert(data.errors);
          } else {
	        	    document.location.href="todo";
          }
        }, "json" );
    }
  });
  
  // Remove a todo.
  $('a.todo-button.del').click(function(event) {
    event.preventDefault();
    
    var issue_id = $(this).data('issue-id');
    $.post(
      siteurl + 'ajax/todo/remove_todo', 
      { "issue_id" : issue_id }, 
      function( data ) {
        if (data.success) {
          $('#todo-id-' + issue_id).hide(300);
        }
        else {
          alert(data.errors);
        }
      }, "json" 
    );
  });

});
