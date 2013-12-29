<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Mail\Message;

class User extends Eloquent implements UserInterface, RemindableInterface {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * @var array
     */
    protected $fillable = array('email', 'firstname', 'lastname', 'role_id', 'password', 'deleted');

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * Checks to see if $this user is current user
     *
     * @return bool
     */
    public function isMe()
    {
        return $this->id == Auth::user()->id;
    }

    /**
     * Check to see if current user has given permission
     *
     * @param  string $key
     * @return bool
     */
    public function permission($key)
    {
        return (bool) \Role\Permission::hasPermission($key, $this->role_id);
    }

    /**
     * Check to see if current user has permission to see project
     *
     * @param  int  $project_id
     * @return bool
     */
    public function project_permission($project_id = null)
    {
        if (is_null($project_id)) {
            $project_id = Project::current()->id;
        }

        if ($this->permission('project-all')) {
            return true;
        }

        if (Project\User::checkAssign($this->id, $project_id)) {
            return true;
        }

        return false;
    }

    /**
     * Select all issues assigned to a user
     *
     * @param  int   $status
     * @return mixed
     */
    public function issues($status = 1)
    {
        return $this->hasMany('Project\Issue', 'created_by')
            ->where('status', '=', $status)
            ->where('assigned_to', '=', $this->id);
    }

    /**
     * Build the user's dashboard
     *
     * @param  int   $activity_limit
     * @return array
     */
    public function dashboard($activity_limit = 5)
    {
        $dashboard =  $users = $issues = $projects = $comments = $activity_type = array();

        /* Load the activity types */
        foreach (Activity::all() as $row)
        {
            $activity_type[$row->id] = $row;
        }

        /* Loop through all the active projects */
        foreach (Project\User::activeProjects($this) as $project)
        {
            $dashboard[$project->id] = array();
            $projects[$project->id] = $project;

            /* Loop through all the logic from the project and cache all the needed data so we don't load the same data twice */
            foreach (User\Activity::where('parent_id', '=', $project->id)->orderBy('created_at', 'DESC')->take($activity_limit)->get() as $activity)
            {
                $dashboard[$project->id][] = $activity;

                if ( ! isset($issues[$activity->item_id]))
                {
                    $issues[$activity->item_id] = Project\Issue::find($activity->item_id);
                }

                if ( ! isset($users[$activity->user_id]))
                {
                    $users[$activity->user_id] = static::find($activity->user_id);
                }

                switch ($activity->type_id)
                {
                    case 2:
                        if ( ! isset($comments[$activity->action_id]))
                        {
                            $comments[$activity->action_id] = Project\Issue\Comment::find($activity->action_id);
                        }

                        break;

                    case 5:
                        if ( ! isset($users[$activity->action_id]))
                        {
                            $users[$activity->action_id] = static::find($activity->action_id);
                        }

                        break;
                }
            }
        }

        /* Loop through the projects and activity again, building the views for each activity */
        $return = array();

        foreach ($dashboard as $project_id => $activity)
        {
            $return[$project_id] = array(
                'project'  => $projects[$project_id],
                'activity' => array()
            );

            foreach ($activity as $row)
            {
                $parameters = array(
                    'issue'    => $issues[$row->item_id],
                    'project'  => $projects[$project_id],
                    'user'     => $users[$row->user_id],
                    'activity' => $row
                );

                switch ($row->type_id)
                {
                    case 2:
                        $parameters['comment'] = $comments[$row->action_id];

                        break;

                    case 5:
                        $parameters['assigned'] = $users[$row->action_id];

                        break;
                }

                $return[$project_id]['activity'][] = View::make('activity/' . $activity_type[$row->type_id]->activity, $parameters);
            }
        }

        return $return;
    }

    /**
     * Update a user
     *
     * @param  array $info
     * @param  int   $id
     * @return array
     */
    public static function updateUser($info, $id)
    {
        $rules = array(
            'firstname' => array('required', 'max:50'),
            'lastname'  => array('required', 'max:50'),
            'email'     => array('required', 'email'),
        );

        /* Validate the password */
        if ($info['password'])
        {
            $rules['password'] = 'confirmed';
        }

        $validator = Validator::make($info, $rules);

        if ($validator->fails())
        {
            return array(
                'success' => false,
                'errors'  => $validator->errors
            );
        }

        $update = array(
            'email'     => $info['email'],
            'firstname' => $info['firstname'],
            'lastname'  => $info['lastname'],
            'role_id'   => $info['role_id']
        );

        /* Update the password */
        if ($info['password'])
        {
            $update['password'] = Hash::make($info['password']);
        }

        User::find($id)->fill($update)->save();

        return array(
            'success' => true
        );
    }

    /**
     * Add a new user.
     *
     * @param array $info
     *
     * @return array
     */
    public static function addUser(array $info)
    {
        $rules = array(
            'firstname' => array('required', 'max:50'),
            'lastname'  => array('required', 'max:50'),
            'email'     => array('required', 'email', 'unique:users'),
        );

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($info, $rules);

        if ($validator->fails())
        {
            return array(
                'success' => false,
                'errors'  => $validator->errors()
            );
        }

        $insert = array(
            'email'     => $info['email'],
            'firstname' => $info['firstname'],
            'lastname'  => $info['lastname'],
            'role_id'   => $info['role_id'],
            'password'  => Hash::make($password = Str::random(6))
        );

        $user = new User;
        $user->fill($insert)->save();

        Mail::send(
            'email.new_user',
            array(
                'email'    => $info['email'],
                'password' => $password
            ),
            function (Message $message) use ($info) {
                $message->to($info['email']);
                $message->subject('Your Tiny Issue Account');
            }
        );

        return array(
            'success'  => true,
            'password' => $password
        );
    }

    /**
     * Soft deletes a user and empties the email.
     *
     * @param int $id
     *
     * @return bool
     */
    public static function deleteUser($id)
    {
        $update = array(
            'email'   => '',
            'deleted' => 1
        );

        User::find($id)->fill($update)->save();
        Project\User::where('user_id', '=', $id)->delete();

        return true;
    }
}
