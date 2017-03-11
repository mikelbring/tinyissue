<?php

class Todo_Controller extends Base_Controller {

	public function get_index()
	{
		// @TODO Make configurable. Global or per-user?
		$status_codes = array(
			0 => __('tinyissue.todo_status_0'),
			1 => __('tinyissue.todo_status_1'),
			2 => __('tinyissue.todo_status_2'),
			3 => __('tinyissue.todo_status_3'),
		);

		// Ensure we have an entry for each lane.
		$lanes = array();
		foreach ($status_codes as $index => $name) {
			$lanes[$index] = array();
		}

		// Load todos into lanes according to status.
		$todos = Todo::load_user_todos();
		foreach ($todos as $todo) {
			$lanes[$todo['status']][] = $todo;
		}

		return $this->layout->with('active', 'todo')->nest('content', 'todo.index', array(
			'lanes'   => $lanes,
			'status'  => $status_codes,
			'columns' => count($status_codes),
		));
	}
}
