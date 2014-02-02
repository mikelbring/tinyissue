<h3>
	<?php echo __('tinyissue.your_todos'); ?>
	<span><?php echo __('tinyissue.your_todos_description'); ?></span>
</h3>

<div class="pad" id="todo-lanes">
  <?php foreach($lanes as $index => $items):  ?>
  <div class="todo-lane blue-box" id="lane-status-<?php echo $index; ?>" data-status="<?php echo $index; ?>">
    <h4><?php echo $status[$index]; ?></h4>
    <div class="inside-pad todo-lane-inner">
      <?php foreach($items as $todo):  ?>
      <div class="todo-list-item <?php if ($index > 0) { echo ' draggable'; } ?>" id="todo-id-<?php echo $todo['issue_id']; ?>" data-issue-id="<?php echo $todo['issue_id']; ?>">
        <div class="todo-list-item-inner">
          #<?php echo $todo['issue_id']; ?>
          <a href="<?php echo $todo['issue_link']; ?>"><?php echo $todo['issue_name']; ?></a>
          <a class="todo-button del" title="<?php echo __('tinyissue.todos_remove'); ?>" data-issue-id="<?php echo $todo['issue_id']; ?>" href="#">[X]</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endforeach; ?>
</div>
