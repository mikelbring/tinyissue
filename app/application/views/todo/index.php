<h3>
	<?php echo __('tinyissue.your_todos'); ?>
	<span><?php echo __('tinyissue.your_todos_description'); ?></span>
</h3>

<div class="pad todo-lane-count-<?php echo $columns; ?>">
  <?php $index = 1; ?>
  <?php while($index < $columns):  ?>
  <div class="todo-lane blue-box" id="lane-status-<?php echo $index; ?>" data-status-code="<?php echo $index; ?>">
    <h4><?php echo $status[$index]; ?></h4>
    <div class="inside-pad todo-lane-inner">
      <?php foreach($lanes[$index] as $todo):  ?>
      <div class="todo-list-item" id="todo-id-<?php echo $todo['issue_id']; ?>">
        <div class="todo-list-item-inner">
          #<?php echo $todo['issue_id']; ?>
          <a href="<?php echo $todo['issue_link']; ?>"><?php echo $todo['issue_name']; ?></a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php $index++; ?>
  <?php endwhile; ?>
  
  
  <div class="todo-lane blue-box" id="lane-status-0" data-status-code="0">
    <h4><?php echo $status[0]; ?></h4>
    <div class="inside-pad">
      <?php foreach($lanes[0] as $todo):  ?>
      <div class="todo-list-item" id="todo-id-<?php echo $todo['issue_id']; ?>">
        #<?php echo $todo['issue_id']; ?>
        <a href="<?php echo $todo['issue_link']; ?>"><?php echo $todo['issue_name']; ?></a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<style>
.todo-lane {
  float: left;
  margin-right: 10px; 
}

#lane-status-0 {
  margin-right: 0; 
}


.todo-lane-count-2 .todo-lane {
  width: 45%;
}

.todo-lane-count-3 .todo-lane {
  width: 30%;
}

.todo-lane-count-4 .todo-lane {
  width: 23%;
}

.todo-list-item {
  background-color: #fff;
  width: 100%;
  display: table;
}

.todo-list-item-inner {
  height: 4em;
  padding: 0 5px;
  display: table-cell;
  vertical-align: middle;
  border-bottom: 4px solid #D4EFFF;
}

.todo-state-active {
  border: 1px solid green;
}

.todo-state-hover {
  border: 1px solid orange;
}
</style>
