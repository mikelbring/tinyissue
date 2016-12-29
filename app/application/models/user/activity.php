<?php namespace User;

class Activity extends \Eloquent {

	public static $table = 'users_activity';
	public static $timestamps = true;
	
	
	public function user()
	{
		return $this->belongs_to('\User');
	}
	
	
	public function other_user()
	{
		return $this->belongs_to('\User');
	}
	
	public function activity()
	{
		return $this->belongs_to('Activity', 'type_id');
	}
		
	/**
	* Add an activity action
	*
	* @param  int     $type_id
	* @param  int     $parent_id
	* @param  int     $item_id
	* @param  int     $action_id
	* @param  string  $data
	* @return bool
	*/
	public static function add($type_id = 18, $parent_id, $item_id = null, $action_id = null, $data = null)
	{
		$insert = array(
			'type_id' => $type_id,
			'parent_id' => $parent_id,
			'user_id' => \Auth::user()->id
		);

		if(!is_null($item_id))
		{
			$insert['item_id'] = $item_id;
		}

		if(!is_null($action_id))
		{
			$insert['action_id'] = $action_id;
		}

		if(!is_null($data))
		{
			$insert['data'] = $data;
		}
		
		$activity = new static;

		return $activity->fill($insert)->save();
	}

}