<?php

class role extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Dropdown of all roles
     *
     * @return array
     */
    public static function dropdown()
    {
        $roles = array();
        foreach (Role::orderBy('name','asc')->get() as $role)
        {
            $roles[$role->id]=$role->name;
        }

        return $roles;
    }
}
