<?php namespace Project\Issue;

class Tag extends  \Eloquent {

	public static $table = 'projects_issues_tags';
	public static $timestamps = true;

	/******************************************************************
	* Methods to use against loaded project
	******************************************************************/

	/**
	* @Insert new tag
	*/
	
	public static function addNew_tags($issue_id, $tag_id = 9)
	{
		$insert = array(
			'issue_id' => $issue_id,
			'tag_id' => $tag_id
		);

		$tags = new static;

		return $tags->fill($insert)->save();
	}
	
}