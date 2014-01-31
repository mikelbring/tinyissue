<?php

class Todo_Controller extends Base_Controller {
	
	public function get_index()
	{
		// @TODO make configurable.
		$status_codes = array(
			0 => 'Closed',
			1 => 'Open',
			2 => 'In Progress',
			3 => 'QA',
		);
		
		// Load todos into lanes according to status.
		$lanes = array();
		$todos = Todo::user_todos();
		foreach ($todos as $todo) {
			$lanes[$todo['status']][] = $todo;
		}

		// Ensure we have an entry for each lane. 
		foreach ($status_codes as $index => $name) {
			if(!isset($lanes[$index])) $lanes[$index] = array();
		}
		
		return $this->layout->with('active', 'todo')->nest('content', 'todo.index', array(
			'lanes'   => $lanes,
			'status'  => $status_codes,
			'columns' => count($status_codes),
		));
	}
}
