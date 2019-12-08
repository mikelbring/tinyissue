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
	public static function has_permission($key, $role_id) {
		if(!isset(static::$permission[$key])) {
			static::$permission[$key] = \Permission::where('permission', '=', $key)->first(array('id'));
		}

		$relation = (bool) static::where('role_id', '=', $role_id)
			->where('permission_id', '=', static::$permission[$key]->id)
			->first(array('id'));

		return $relation;
	}

	public static function inherits_permission($hopeSo) {
		$myRole = \Auth::user()->role_id;
		$hopeSoNum = array();
		$permis = false;
		foreach ($hopeSo as $hope) {
			$resu  =\DB::table('permissions')->select(array('id', 'auto_has'))->where('permission','=',$hope)->get();
			if (isset($resu[0])) { 
				$perm = \DB::table('roles_permissions')->select(array('id'))->where('role_id', '=', $myRole)->where('permission_id', "=", $resu[0]->id)->get();
				if (count($perm) > 0 ) { $permis = true; break; } 
				if (!in_array($resu[0]->id, $hopeSoNum)) { $hopeSoNum[] = $resu[0]->id; }
				$resuA = $resu[0]->id;
				while ($resuA != 0 ) {
					$resuB =\DB::query("SELECT id FROM permissions WHERE auto_has LIKE '%".$resuA."%' ");
					foreach ($resuB as $ind => $val) { 
						if (!in_array($val->id, $hopeSoNum)) { $hopeSoNum[] = $val->id; }
						$resuA = $val->id;
					} 
					$resuA = 0; 
				}
			} 
		}
		return $permis;
	}
}