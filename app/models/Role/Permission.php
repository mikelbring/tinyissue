<?php namespace Role;

class Permission extends \Eloquent {

    private static $permission = array();

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles_permissions';

    /**
     * Check if a role has a specific permission based on the permission $key
     *
     * @param  string $key
     * @param  int    $role_id
     * @return bool
     */
    public static function hasPermission($key, $role_id)
    {
        if ( ! isset(self::$permission[$key]))
        {
            self::$permission[$key] = \Permission::where('permission', '=', $key)->first(array('id'));
        }

        $relation = (bool) static::where('role_id', '=', $role_id)
            ->where('permission_id', '=', static::$permission[$key]->id)
            ->first(array('id'));

        return $relation;
    }
}
