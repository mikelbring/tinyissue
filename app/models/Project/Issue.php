<?php namespace Project;

use Project\Issue\Comment;
use User\Activity;

class Issue extends \Eloquent {

    /**
     * Current loaded Issue
     *
     * @var Issue
     */
    private static $current = null;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects_issues';

    /**
     * @var array
     */
    protected $fillable = array('created_by', 'project_id', 'title', 'body');

    /**
    * @return User
    */
    public function user()
    {
        return $this->belongsTo('\User', 'created_by');
    }

    /**
    * @return User
    */
    public function assigned()
    {
        return $this->belongsTo('\User', 'assigned_to');
    }

    /**
    * @return User
    */
    public function userUpdated()
    {
        return $this->belongsTo('\User', 'updated_by');
    }

    /**
    * @return User
    */
    public function closer()
    {
        return $this->belongsTo('\User', 'closed_by');
    }

    public function activity()
    {
        $users = $comments = $activity_type = array();

        $project_id = $this->project_id;
        $project    = \Project::find($project_id);

        foreach (\Activity::all() as $row)
        {
            $activity_type[$row->id] = $row;
        }

        $activities = array();
        foreach (Activity::where('item_id', '=', $this->id)->orderBy('created_at', 'ASC')->get() as $activity)
        {
            $activities[] = $activity;

            switch ($activity->type_id)
            {
                case 2:
                    if (!isset($users[$activity->user_id]))
                    {
                        $users[$activity->user_id] = \User::find($activity->user_id);
                    }

                    if (!isset($comments[$activity->action_id]))
                    {
                        $comments[$activity->action_id] = Comment::find($activity->action_id);
                    }
                    break;

                case 5:
                    if (!isset($users[$activity->user_id]))
                    {
                        $users[$activity->user_id] = \User::find($activity->user_id);
                    }

                    if (!isset($users[$activity->action_id]))
                    {
                        $users[$activity->action_id] = \User::find($activity->action_id);
                    }

                    break;

                default:
                    if (!isset($users[$activity->user_id]))
                    {
                        $users[$activity->user_id] = \User::find($activity->user_id);
                    }

                    break;
            }
        }

        /* Loop through the projects and activity again, building the views for each activity */
        $return = array();
        foreach ($activities as $row)
        {
            switch ($row->type_id)
            {
                case 2:
                    $return[] = \View::make('project/issue/activity/' . $activity_type[$row->type_id]->activity, array(
                        'issue'    => $this,
                        'project'  => $project,
                        'user'     => $users[$row->user_id],
                        'comment'  => $comments[$row->action_id],
                        'activity' => $row
                    ));

                    break;

                case 3:
                    $return[] = \View::make('project/issue/activity/' . $activity_type[$row->type_id]->activity, array(
                        'issue'    => $this,
                        'project'  => $project,
                        'user'     => $users[$row->user_id],
                        'activity' => $row
                    ));

                    break;

                case 5:
                    $return[] = \View::make('project/issue/activity/' . $activity_type[$row->type_id]->activity, array(
                        'issue'    => $this,
                        'project'  => $project,
                        'user'     => $users[$row->user_id],
                        'assigned' => $users[$row->action_id],
                        'activity' => $row
                    ));

                    break;

                default:
                    $return[] = \View::make('project/issue/activity/' . $activity_type[$row->type_id]->activity, array(
                        'issue'    => $this,
                        'project'  => $project,
                        'user'     => $users[$row->user_id],
                        'activity' => $row
                    ));

                    break;
            }
        }

        return $return;
    }

    public function comments()
    {
        return $this->hasMany('Project\Issue\Comment', 'issue_id')->orderBy('created_at', 'ASC');
    }

    public function comment_count()
    {
        return $this->hasMany('Project\Issue\Comment', 'issue_id')->count();
    }

    public function attachments()
    {
        return $this->hasMany('Project\Issue\Attachment', 'issue_id')->where('comment_id', '=', 0);
    }

    /**
     * Generate a URL for the active project
     *
     * @param  string $url
     * @return string
     */
    public function to($url = '')
    {
        return \URL::to('project/' . $this->project_id . '/issue/' . $this->id . (($url) ? '/'. $url : ''));
    }

    /**
     * Reassign the issue to a new user
     *
     * @param  int  $user_id
     * @return void
     */
    public function reassign($user_id)
    {
        $this->assigned_to = $user_id;
        $this->save();

        Activity::add(5, $this->project_id, $this->id, $user_id, null, $user_id);
    }

    /**
     * Change the status of an issue
     *
     * @param  int  $status
     * @return void
     */
    public function changeStatus($status)
    {
        $type = 4; // reopen issue

        if ($status == 0)
        {
            $this->closed_by = \Auth::user()->id;
            $this->closed_at = date('Y-m-d H:i:s');

            $type = 3; // close issue
        }

        // Add to activity log
        Activity::add($type, $this->project_id, $this->id);

        $this->status = $status;
        $this->save();
    }

    /**
     * Update the given issue
     *
     * @param  array $input
     * @return array
     */
    public function updateIssue($input)
    {
        $rules = array(
            'title' => 'required|max:200',
            'body'  => 'required'
        );

        $validator = \Validator::make($input, $rules);

        if ($validator->fails())
        {
            return array(
                'success' => false,
                'errors'  => $validator->errors
            );
        }

        $fill = array(
            'title'       => $input['title'],
            'body'        => $input['body'],
            'assigned_to' => $input['assigned_to']
        );

        /* Add to activity log for assignment if changed */
        if ($input['assigned_to'] != $this->assigned_to)
        {
            \User\Activity::add(5, $this->project_id, $this->id, \Auth::user()->id);
        }

        $this->fill($fill);
        $this->save();

        return array(
            'success' => true
        );
    }

    /**
     * Return the current loaded Issue
     *
     * @return Issue
     */
    public static function current()
    {
        return static::$current;
    }

    /**
     * Load a new Issue into $current, based on the $id
     *
     * @param  int   $id
     * @return Issue
     */
    public static function loadIssue($id)
    {
        static::$current = static::find($id);

        return static::$current;
    }

    /**
     * Create a new issue.
     *
     * @param array    $input
     * @param \Project $project
     *
     * @return array Return success and issue object
     */
    public static function createIssue(array $input, \Project $project)
    {
        $rules = array(
            'title' => 'required|max:200',
            'body'  => 'required'
        );

        $validator = \Validator::make($input, $rules);

        if ($validator->fails())
        {
            return array(
                'success' => false,
                'errors'  => $validator->errors
            );
        }

        $fill = array(
            'created_by' => \Auth::user()->id,
            'project_id' => $project->id,
            'title'      => $input['title'],
            'body'       => $input['body']
        );

        if (\Auth::user()->permission('issue-modify'))
        {
            $fill['assigned_to'] = $input['assigned_to'];
        }

        $issue = new static;
        $issue->fill($fill);
        $issue->save();

        /* Add to user's activity log */
        Activity::add(1, $project->id, $issue->id);

        /* Add attachments to issue */
        \DB::table('projects_issues_attachments')->where('upload_token', '=', $input['token'])->where('uploaded_by', '=', \Auth::user()->id)->update(array('issue_id' => $issue->id));

        /* Return success and issue object */

        return array(
            'success' => true,
            'issue'   => $issue
        );
    }

    /**
     *
     *
     * @return array Return success and issue object
     */
    public static function countIssues()
    {
        /* Count Open Issues - Project must be open */
        $count = \DB::table('projects_issues')
            ->join('projects', 'projects.id', '=', 'projects_issues.project_id')
            ->where('projects.status', '=', 1)
            ->where('projects_issues.status', '=', 1)
            ->count();

        $open_issues = !$count ? 0 : $count;

        /* Count Closed Issues - Open Projects */
        $count = \DB::table('projects_issues')
            ->join('projects', 'projects.id', '=', 'projects_issues.project_id')
            ->where('projects.status', '=', 1)
            ->where('projects_issues.status', '=', 0)
            ->count();

        $closed_issues_open_project = !$count ? 0 : $count;

        /* Count Issues - Closed Projects */
        $count = \DB::table('projects_issues')
            ->join('projects', 'projects.id', '=', 'projects_issues.project_id')
            ->where('projects.status', '=', 0)
            ->count();

        $issues_closed_project = !$count ? 0 : $count;

        $closed_issues = ($closed_issues_open_project + $issues_closed_project);

        return array(
            'open'   => $open_issues,
            'closed' => $closed_issues
        );
    }
}
