<?php

class Todo extends Eloquent {
  
	public static $table = 'users_todos';
  
  /**
  * Loads a todo if it exists and belongs to the given user.
  */
  public static function load_todo($issue_id = 0, $user_id = 0) {
		if (!$user_id) $user_id = Auth::user()->id;
    
    $todo = Todo::where('issue_id', '=', $issue_id)->where('user_id', '=', $user_id)->first();
    if(empty($todo)) {
      return FALSE;
    }
    else {
      return $todo;
    }
  }
  
	/**
	 * Load all a user's todos
	 */
	public static function load_user_todos($user_id = 0)
	{
		$return = array();
		if (!$user_id) $user_id = Auth::user()->id;
		
		$todos = Todo::where('user_id', '=', $user_id)->order_by('updated_at', 'DESC')->get();
		foreach ($todos as $todo)
		{
			Todo::load_todo_extras($todo);
			$return[$todo->attributes['id']] = $todo->attributes;
		}
		
		return $return;
	}
  
	/**
	* Load a todo
	* 
	* @param int       $task_id
	* @return array
	*/
	public static function load_todo_extras(&$todo)
	{
		// We need the issue and project names for display.
		$issue = Project\Issue::load_issue($todo->issue_id);
		$todo->issue_name = $issue->attributes['title'];
		$todo->issue_link = $issue->to();
		
		$project = Project::find($issue->attributes['project_id']);
		$todo->project_name = $project->attributes['name'];
		$todo->project_link = $project->to();
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
    
    $todo = Todo::load_todo($issue_id, $user_id);
    if(!$todo)
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
  
	/**
	* Update a todo
	*
	* @param int       $user_id
	* @param int       $issue_id
	* @return array
	*/
	public static function update_todo($issue_id = 0, $new_status = 1)
	{
    $user_id = Auth::user()->id;
    
    $todo = Todo::load_todo($issue_id, $user_id);
    if(!$todo)
		{
			return array(
				'success' => FALSE,
				'errors' => 'This task is not on your todo list.',
			);
		}

    // Sanity check on status value.
    $new_status = (int)$new_status;
    if ($new_status >= 0 && $new_status <= 3) 
    {
      $todo->status = $new_status;
      $todo->save();
      
      // Close issue if todo is moved to closed lane. 
      if ($new_status == 0) {
        $issue = Project\Issue::load_issue($issue_id);
        $issue->change_status(0);
      }
      
      return array(
        'success' => TRUE
      );
    }
    else 
    {
			return array(
				'success' => FALSE,
				'errors' => 'There was a problem saving that update. Please reload the page and try again.',
			);
    }
	}
}
