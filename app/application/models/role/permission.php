<?php namespace Role;

class Permission extends \Eloquent {

	public static $table = 'roles_permissions';
	private static $permission = array();

	/**
	* Check if a role has a specific permission based on the permission $key
	*
	* @param  string  $key
	* @param  int     $role_id
	* @return bool
	*/
	public static function has_permission($key, $role_id)
	{
		if(!isset(static::$permission[$key]))
		{
			static::$permission[$key] = \Permission::where('permission', '=', $key)->first(array('id'));
		}

		$relation = (bool) static::where('role_id', '=', $role_id)
			->where('permission_id', '=', static::$permission[$key]->id)
			->first(array('id'));

		return $relation;
	}

}