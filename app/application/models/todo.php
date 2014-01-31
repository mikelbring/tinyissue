<?php

class Todo extends Eloquent {
  
	public static $table = 'users_todos';
  
  /**
  * Load todo information
  * 
  * @param int       $task_id
  * @return array
  */
  public static function load_todo($todo_id = 0)
  {
    $todo = Todo::find($todo_id);
    if (!$todo)
		{
			return array(
				'success' => false,
				'errors' => 'Todo item does not exist.',
			);
		}
    
    // We need the issue and project names for display.
    $issue = Project\Issue::load_issue($todo->issue_id);
    $todo->issue_name = $issue->name;
    
    $project = Project::load_project($issue->project_id);
    $todo->project_name = $project->name;
    
		/* Return success and todo object */
		return array(
			'success' => true,
			'issue' => $todo
		);
  }
  
	/**
	* Add a new todo
	*
	* @param int       $user_id
	* @param int       $issue_id
	* @return array
	*/
	public static function add_todo($issue_id = 0)
	{
    $user_id = Auth::user()->id;
    
    // Ensure user is assigned to issue.
		$issue = Project\Issue::load_issue($issue_id);
		if($issue->assigned_to !== $user_id)
		{
			return array(
				'success' => FALSE,
				'errors' => 'You cannot add this issue to your todo list.',
			);
		}
    
    // Ensure issue is not already a task.
    $count = Todo::where('issue_id', '=', $issue_id)->where('user_id', '=', $user_id)->count();
    if ($count > 0)
		{
			return array(
				'success' => false,
				'errors' => 'This issue is already in your todo list.',
			);
		}
    
    $todo = new Todo;
    $todo->user_id  = $user_id;
    $todo->issue_id = $issue_id;
    $todo->status   = 1;
		$todo->save();

		return array(
			'success' => TRUE,
		);
	}
  
	/**
	* Delete a todo
	*
	* @param int       $user_id
	* @param int       $task_id
	* @return array
	*/
	public static function remove_todo($issue_id = 0)
	{
    $user_id = Auth::user()->id;
    
    // Ensure this issue exists and belongs to user's todo board.
    $todo = Todo::where('issue_id', '=', $issue_id)->where('user_id', '=', $user_id)->first();
		if(empty($todo))
		{
			return array(
				'success' => FALSE,
				'errors' => 'This task is not on your todo list.',
			);
		}

		$todo->delete($todo);
    
		return array(
			'success' => TRUE
		);
	}
}
