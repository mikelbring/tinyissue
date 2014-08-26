<?php

class Tag extends Eloquent {

	public static $table = 'tags';
	public static $hidden = array('created_at', 'updated_at');
	
	/**
	* @return Collection
	*/
	public function issues()
	{
		return $this->has_many_and_belongs_to('\Project\Issue', 'projects_issues_tags', 'tag_id', 'issue_id');
	}
	
}