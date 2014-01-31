$(function(){  
  // AJAX interactions on todo lanes.
  $('.todo-list-item').draggable({
     snap: '.todo-lane',
     snapMode: "inner"
  });
  
  $('.todo-lane').droppable({
    activeClass: "todo-state-active",
    hoverClass:  "todo-state-hover",
    drop: function( event, ui ) {
      var new_status = $(this).data('status-code');
      var thisId = $(this).attr('id');
      $(ui.draggable).appendTo($('#' + thisId + ' .todo-lane-inner'));
      $(ui.draggable).css( 'left', 0 );
      $(ui.draggable).css( 'top', 0 );
    }
  });
});
