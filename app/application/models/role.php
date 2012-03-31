<?php

class Role extends Eloquent {

	public static $table = 'roles';

	public static function dropdown(){
		$roles = array();
		foreach (Role::order_by('name','asc')->get() as $role)
		{
			$roles[$role->id]=$role->name;
		}
		return $roles;
	}

}