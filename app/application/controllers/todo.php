<?php

class Todo_Controller extends Base_Controller {

	public function get_index() {
		$config_app = require path('public') . 'config.app.php';
		// @TODO Make configurable. Global or per-user?
		$status_codes = array(
			0 => __('tinyissue.todo_status_0'),
			1 => __('tinyissue.todo_status_1'),
			2 => __('tinyissue.todo_status_2'),
			3 => __('tinyissue.todo_status_3'),
		);

		// Ensure we have an entry for each lane.
		$lanes = array();
		//Les billets fermés
		$todos = Todo::load_user_todos("=", 0, 100);
		foreach ($todos as $todo) {
			$lanes[0][] = $todo;
		}

		//Les billets ouverts
		for ($index=1; $index<4; $index++) {
			$todos = Todo::load_user_todos(">", $config_app['Percent'][$index],$config_app['Percent'][$index+1]);
			foreach ($todos as $todo) {
				$lanes[$index][] = $todo;
			}
		}


		return $this->layout->with('active', 'todo')->nest('content', 'todo.index', array(
			'lanes'   => $lanes,
			'status_codes'  => $status_codes,
			'columns' => count($status_codes),
		));
	}
}
