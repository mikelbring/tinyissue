<?php namespace Project;

use Illuminate\Database\Eloquent\Collection;

class User extends \Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects_users';

    /**
     * @var array
     */
    protected $fillable = array('user_id', 'project_id', 'role_id');

    /**
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('User', 'user_id')->orderBy('firstname', 'ASC');
    }

    /**
     * @return Project
     */
    public function project()
    {
        return $this->belongsTo('Project', 'project_id')->orderBy('name', 'ASC');
    }

    /**
     * Assign a user to a project with a role.
     *
     * @param int $user_id
     * @param int $project_id
     * @param int $role_id
     *
     * @return void
     */
    public static function assign($user_id, $project_id, $role_id = 0)
    {
        if (static::checkAssign($user_id, $project_id)) {
            return;
        }

        $fill = array(
            'user_id'    => $user_id,
            'project_id' => $project_id,
            'role_id'    => $role_id
        );

        $relation = new static;
        $relation->fill($fill);
        $relation->save();
    }

    /**
     * Removes a user from a project.
     *
     * @param int $user_id
     * @param int $project_id
     *
     * @return void
     */
    public static function remove_assign($user_id, $project_id)
    {
        static::where('user_id', '=', $user_id)
            ->where('project_id', '=', $project_id)
            ->delete();
    }

    /**
     * Checks to see if a user is assigned to a project.
     *
     * @param int $user_id
     * @param int $project_id
     *
     * @return bool
     */
    public static function checkAssign($user_id, $project_id)
    {
        return (bool) static::where('user_id', '=', $user_id)
            ->where('project_id', '=', $project_id)
            ->first(array('id'));
    }

    /**
     * Build a dropdown of all users in the project.
     *
     * @param Collection $users
     *
     * @return array
     */
    public static function dropdown(Collection $users)
    {
        $return = array();
        foreach ($users as $row) {
            $return[$row->id] = $row->firstname . ' ' . $row->lastname;
        }

        return $return;
    }

    /**
     * Returns issues assigned to the given user
     *
     * @param  \User $user
     * @return array
     */
    public static function usersIssues(\User $user)
    {
        $projects = array();
        foreach (static::activeProjects($user, true) as $project)
        {
            $project = array(
                'detail' => $project,
                'issues' => $project->issues()
                    ->where('assigned_to', '=', $user->id)
                    ->where('status', '=', 1)
                    ->get()
            );

            if (!empty($project['issues']))
            {
                $projects[] = $project;
            }
        }

        return $projects;
    }

    /**
     * Returns  active projects for the given user.
     *
     * @param \User $user
     * @param bool  $all  (optional)
     *
     * @return \Project[]
     */
    public static function activeProjects(\User $user, $all = false)
    {
        if ($all && $user->permission('project-all'))
        {
            return \Project::where('status', '=', 1)
                ->orderBy('name', 'ASC')
                ->get();
        }

        $projects = array();
        foreach (static::with('project')->where('user_id', '=', $user->id)->get() as $row)
        {
            if ($row->project->status != 1)
            {
                continue;
            }

            $projects[] = $row->project;
        }

        return $projects;
    }

    /**
     * Returns inactive projects for the given user.
     *
     * @param \User $user
     * @param bool  $all  (optional)
     *
     * @return \Project[]
     */
    public static function inactiveProjects(\User $user, $all = false)
    {
        if ($all && $user->permission('project-all'))
        {
            return \Project::where('status', '=', 0)
                ->orderBy('name', 'ASC')
                ->get();
        }

        $projects = array();
        foreach (static::with('project')->where('user_id', '=', $user->id)->get() as $row)
        {
            if ($row->project->status != 0)
            {
                continue;
            }

            $projects[] = $row->project;
        }

        return $projects;
    }
}
