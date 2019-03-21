<h3>
	<?php echo __('tinyissue.your_todos'); ?>
	<span><?php echo __('tinyissue.your_todos_description'); ?></span>
</h3>
<?php
	$config_app = require path('public') . 'config.app.php';
	if(!isset($config_app['PriorityColors'])) { $config_app['PriorityColors'] = array("black","Orchid","Cyan","Lime","orange","red"); }
	if (!isset($config_app['Percent'])) { $config_app['Percent'] = array (100,0,10,80,100); }
	$config_app['Percent'][5] = 0;
	$column = array(1,2,3,0);

	echo '<div class="pad" id="todo-lanes">';
	foreach ($column as $col) {
		echo '<div class="todo-lane blue-box" id="lane-status-'.$col.'" data-status="'.$col.'">';
		echo '<h4>'.$status_codes[$col].'('.$config_app['Percent'][$col].(($col == 0) ? '' :  ' - '.($config_app['Percent'][$col+1]-1)).'% )</h4>';
		if (isset($lanes[$col])) {
			foreach ($lanes[$col] as $lane) {
				echo '<div class="todo-list-item '.(($col > 0) ? ' draggable' : '').'" id="todo-id-'.$lane->id.'" data-issue-id="'.$lane->id.'">';
				echo '	<div class="todo-list-item-inner">';
				echo '		<span><span style="color: '.$config_app['PriorityColors'][$lane->status].'; font-size: 200%;">&#9899;</span>#'. $lane->id.'</span>';
				echo '			<a href="'.(\URL::to('project/' . $lane->project_id . '/issue/' . $lane->id)).'">'.$lane->title.'</a>&nbsp;<span>( '.$lane->weight.'%)</span>';
				echo '			<a class="todo-button del" title="'. __('tinyissue.todos_remove').'" data-issue-id="'.$lane->id.'" href="#">[X]</a>';
				echo '		<div>'.$lane->name.'</div>';
				echo '	</div>';
				echo '</div>';
			}
		}
		echo '</div>';
	}
	echo '<div class="todo-line">&nbsp;</div>';
	echo '</div>';
?>
