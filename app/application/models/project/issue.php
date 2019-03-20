<?php namespace Project;


class Issue extends \Eloquent {

	public static $table = 'projects_issues';
	public static $timestamps = true;

	/******************************************************************
	* Methods to use against loaded project
	******************************************************************/

	/**
	* @return User
	*/
	public function user()
	{
		return $this->belongs_to('\User', 'created_by');
	}

	/**
	* @return User
	*/
	public function assigned()
	{
		return $this->belongs_to('\User', 'assigned_to');
	}

	/**
	* @return User
	*/
	public function updated()
	{
		return $this->belongs_to('\User', 'updated_by');
	}

	/**
	* @return User
	*/
	public function closer()
	{
		return $this->belongs_to('\User', 'closed_by');
	}

	/**
	* @return Collection
	*/

	public function tags()
	{
		return $this->has_many_and_belongs_to('\Tag', 'projects_issues_tags', 'issue_id', 'tag_id');
	}

	public function activity($activity_limit = 5)
	{

		$users = $comments = $activity_type = array();

		$issue = $this;
		$project_id = $this->project_id;
		$project = \Project::find($project_id);

		foreach(\Activity::all() as $row) {
			$activity_type[$row->id] = $row;
		}


		$activities = array();


		foreach(\User\Activity::where('item_id', '=', $issue->id)->order_by('created_at', 'ASC')->get() as $activity) {
			$activities[] = $activity;

			switch($activity->type_id) {
				case 2:
					if(!isset($users[$activity->user_id])) 		{ $users[$activity->user_id] = \User::find($activity->user_id); }
					if(!isset($comments[$activity->action_id]))	{ $comments[$activity->action_id] = \Project\Issue\Comment::find($activity->action_id); }
					break;

				case 5:
					if(!isset($users[$activity->user_id]))		{ $users[$activity->user_id] = \User::find($activity->user_id); }
					if(!isset($users[$activity->action_id])) 	{ $users[$activity->action_id] = \User::find($activity->action_id); }
					break;

				case 7:
					if(!isset($users[$activity->user_id]))		{ $users[$activity->user_id] = \User::find($activity->user_id); }
					if(!isset($users[$activity->action_id])) 	{ $users[$activity->action_id] = \User::find($activity->action_id); }
					break;

				default:
					if(!isset($users[$activity->user_id])) 	{ $users[$activity->user_id] = \User::find($activity->user_id); }
					break;
			}
		}




		/* Loop through the projects and activity again, building the views for each activity */
		$return = array();


		foreach($activities as $row) {
			switch($row->type_id) {
				case 2:
					$return[] = \View::make('project/issue/activity/' . $activity_type[$row->type_id]->activity, array(
						'issue' => $issue,
						'project' => $project,
						'user' => $users[$row->user_id],
						'comment' => $comments[$row->action_id],
						'activity' => $row
					));
					break;

				case 3:
					$return[] = \View::make('project/issue/activity/' . $activity_type[$row->type_id]->activity, array(
						'issue' => $issue,
						'project' => $project,
						'user' => $users[$row->user_id],
						'activity' => $row
					));
					break;

				case 5:
					$return[] = \View::make('project/issue/activity/' . $activity_type[$row->type_id]->activity, array(
						'issue' => $issue,
						'project' => $project,
						'user' => $users[$row->user_id],
						'assigned' => $users[$row->action_id],
						'activity' => $row
					));
					break;

				case 6:
					$tag_diff = json_decode($row->data, true);
					$return[] = \View::make('project/issue/activity/' . $activity_type[$row->type_id]->activity, array(
						'issue' => $issue,
						'project' => $project,
						'user' => $users[$row->user_id],
						'tag_diff' => $tag_diff,
//						'tag_counts' => array('added' => sizeof($tag_diff['added_tags']), 'removed' => sizeof($tag_diff['removed_tags'])),
						'activity' => $row
					));
					break;
				default:
					$return[] = \View::make('project/issue/activity/' . $activity_type[$row->type_id]->activity, array(
						'issue' => $issue,
						'project' => $project,
						'user' => $users[$row->user_id],
						'activity' => $row
					));
					break;
			}
		}
		return $return;

	}



	public function comments()
	{
		return $this->has_many('Project\Issue\Comment', 'issue_id')
			->order_by('created_at', 'ASC');
	}

	public function comment_count()
	{
		return $this->has_many('Project\Issue\Comment', 'issue_id')->count();
	}

	public function attachments()
	{
		return $this->has_many('Project\Issue\Attachment', 'issue_id')->where('comment_id', '=', 0);
	}

	/**
	* Generate a URL for the active project
	*
	* @param  string  $url
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
		$old_assignee = $this->assigned_to;

		$this->assigned_to = $user_id;
		$this->save();

		/* Notify the person being assigned to unless that person is doing the actual assignment */
		if($this->assigned_to && $this->assigned_to != \Auth::user()->id)
		{
			$project_id = $this->project_id;
			$project = \Project::find($project_id);

			$subject = sprintf(__('email.reassignment'),$this->title,$project->name);
			$text = \View::make('email.reassigned_issue', array(
				'actor' => \Auth::user()->firstname . ' ' . \Auth::user()->lastname,
				'project' => $project,
				'issue' => $this
			));

			\Mail::send_email($text, $this->assigned->email, $subject);
			}
		add($type_id, $parent_id, $item_id = null, $action_id = null, $data = null);
		\User\Activity::add(5, $this->project_id, $this->id, $user_id, null);
	}

	/**
	* Change the status of an issue
	*
	* @param  int   $status
	* @return void
	*/
	public function change_status($status) {

		/* Retrieve all tags */
		$tags = $this->tags;
		$tag_ids = array();
		foreach($tags as $tag) {
			$tag_ids[$tag->id] = $tag->id;
		}

		if($status == 0) {
			$this->closed_by = \Auth::user()->id;
			$this->closed_at = date('Y-m-d H:i:s');

			/* Update tags */
			$tag_ids[2] = 2;
			if(isset($tag_ids[1])) {
				unset($tag_ids[1]);
			}

			if(isset($tag_ids[8])) {
				unset($tag_ids[8]);
			}

			/* Add to activity log */
			\User\Activity::add(3, $this->project_id, $this->id);
		} else {

			/* Update tags */
			$tag_ids[1] = 1;
			if(isset($tag_ids[2])) {
				unset($tag_ids[2]);
			}

			/* Add to activity Log */
			\User\Activity::add(4, $this->project_id, $this->id);
		}
		$this->tags()->sync($tag_ids);
		$this->status = $status;
		$this->save();

		/* Notify the person to whom the issue is currently assigned, unless that person is the one changing the status */
		if($this->assigned_to && $this->assigned_to != \Auth::user()->id) {
			$project = \Project::current();
			$verb = ($this->status == 0 ? __('email.closed') : __('email.reopened'));
			$subject = sprintf(__('email.issue_changed'),$this->title,$project->name,$verb);
			$text = \View::make('email.change_status_issue', array(
				'actor' => \Auth::user()->firstname . ' ' . \Auth::user()->lastname,
				'project' => $project,
				'issue' => $this,
				'verb' => $verb
			));

			\Mail::send_email($text, $this->assigned->email, $subject);
		}
	}

	/**
	* Update the given issue
	*
	* @param  array  $input
	* @return array
	*/
	public function update_issue($input) {
		$rules = array(
			'title' => 'required|max:200',
			'body' => 'required'
		);

		$validator = \Validator::make($input, $rules);

		if($validator->fails())
		{
			return array(
				'success' => false,
				'errors' => $validator->errors
			);
		}

		$fill = array(
			'title' => $input['title'],
			'body' => $input['body'],
			'assigned_to' => $input['assigned_to'],
			'duration' => $input['duration'],
			'status' => $input['status']
		);

		/* Add to activity log for assignment if changed */
		if($input['assigned_to'] != $this->assigned_to) {
			\User\Activity::add(5, $this->project_id, $this->id, \Auth::user()->id);
		}

		$this->fill($fill);
		$this->save();

		/* Update tags */
		$this->set_tags('update');

		/* Notify the person to whom the issue is currently assigned, unless that person is the one making the update */
		if($this->assigned_to && $this->assigned_to != \Auth::user()->id) {
			$project = \Project::current();
			$subject = sprintf(__('email.update'),$this->title,$project->name);
			$text = \View::make('email.update_issue', array(
				'actor' => \Auth::user()->firstname . ' ' . \Auth::user()->lastname,
				'project' => $project,
				'issue' => $this
			));

			\Mail::send_email($text, $this->assigned->email, $subject);
		}

		return array(
			'success' => true
		);
	}



	/**
	* Sets tags on an issue
	*
	* @param  string	Mode (create or update)
	* @return void
	*/
	public function set_tags($mode) {
		if ($mode == 'create') {
			/* Set old tag ids to contain just the status:open tag */
			$old_tag_ids = array(1);
		} else {
			/* Save old tags to determine if we need to record activity */
			$old_tag_ids = array();
			foreach($this->tags as $tag) {
				$old_tag_ids[] = $tag->id;
			}
		}

		/* Update tags */
		$tags = \Input::get('tags', '');
		$new_tag_ids = array();

		if(trim($tags) != '') {
			$tags = explode(',', $tags);

			/* Only users with administration permission should be able to add new tags */
			if(\Auth::user()->permission('administration')) {
				foreach($tags as $tag) {
					if (!\Tag::where('tag', '=', $tag)->first()) {
						$tag_object = new \Tag;
						$tag_object->fill(array('tag' => $tag));
						$tag_object->save();
					}
				}
			}

			$tag_records = \Tag::where_in('tag', $tags)->get();
			foreach($tag_records as $tag_record) {
				$new_tag_ids[] = $tag_record->id;
			}
		}

		//if ($this->status == 1) {
		if ($this->status > 0) {
			$force_tag = 1;
			$exclude_tag = 2;
		} else {
			$force_tag = 2;
			$exclude_tag = 1;
		}

		$found_tag = false;
		foreach($new_tag_ids as $key => $val) {
			if($val == $force_tag) {
				$found_tag = true;
			} else if($val == $exclude_tag) {
				unset($new_tag_ids[$key]);
			}
		}

		if (!$found_tag) {
			$new_tag_ids[] = $force_tag;
		}

		$this->tags()->sync($new_tag_ids);

		/* Add to activity log for tags if changed */
		$added_tags = array_diff($new_tag_ids, $old_tag_ids);
		$removed_tags = array_diff($old_tag_ids, $new_tag_ids);
		$has_tag_diff = (!empty($added_tags) || !empty($removed_tags));
		if ($has_tag_diff) {
			$tag_data = array();
			$tag_data_resource = \Tag::where_in('id', array_merge($added_tags, $removed_tags))->get();
			foreach($tag_data_resource as $tag) {
				$tag_data[$tag->id] = $tag->to_array();
			}

			\User\Activity::add(6, $this->project_id, $this->id, null, json_encode(array('added_tags' => $added_tags, 'removed_tags' => $removed_tags, 'tag_data' => $tag_data)));
		}
	}


	/******************************************************************
	* Static methods for working with issues
	******************************************************************/

	/**
	* Current loaded Issue
	*
	* @var Issue
	*/
	private static $current = null;

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
	* @param   int   $id
	* @return  Issue
	*/
	public static function load_issue($id)
	{
		static::$current = static::find($id);

		return static::$current;
	}

	/**
	* Create a new issue
	*
	* @param  array    $input
	* @param  \Project  $project
	* @return Issue
	*/
	public static function create_issue($input, $project) {
		$rules = array(
			'title' => 'required|max:200',
			'body' => 'required'
		);

		$validator = \Validator::make($input, $rules);

		if($validator->fails()) {
			return array(
				'success' => false,
				'errors' => $validator->errors
			);
		}

		//Modificated to include the feather « duration »
		$input['duration'] = ((isset($input['duration'])) ? $input['duration'] : 30);
		$fill = array(
			'created_by' => \Auth::user()->id,
			'project_id' => $project->id,
			'title' => $input['title'],
			'body' => $input['body'],
			'duration' => $input['duration'],
			'status' => $input['status']
		);

		if(\Auth::user()->permission('issue-modify')) {
			$fill['assigned_to'] = $input['assigned_to'];
		}

		$issue = new static;
		$issue->fill($fill);
		$issue->save();

		/* Create tags */
		$issue->set_tags('create');

		/* Add to user's activity log */
		\User\Activity::add(1, $project->id, $issue->id);

		/* Add attachments to issue */
		\DB::table('projects_issues_attachments')->where('upload_token', '=', $input['token'])->where('uploaded_by', '=', \Auth::user()->id)->update(array('issue_id' => $issue->id));

		/* Notify the person being assigned to. */
		/* If no one is assigned, notify all users who are assigned to this project and who have permission to modify the issue. */
		/* Do not notify the person creating the issue. */
		if($issue->assigned_to) {
			if($issue->assigned_to != \Auth::user()->id) {
				$project = \Project::current();

				//$subject = 'New issue "' . $issue->title . '" was submitted to "' . $project->name . '" project and assigned to you';
				$subject = sprintf(__('email.assignment'),$issue->title,$project->name);
				$text = \View::make('email.new_assigned_issue', array( 'project' => $project, 'issue' => $issue, ));
				\Mail::send_email($text, $issue->assigned->email, $subject);
			}
		} else {
			$project = \Project::current();
			foreach($project->users()->get() as $row) {
				if($row->id != \Auth::user()->id && $row->permission('project-modify')) {
					//$subject = 'New issue "' . $issue->title . '" was submitted to "' . $project->name . '" project';
					$subject = sprintf(__('email.new_issue'),$issue->title,$project->name);
					$text = \View::make('email.new_issue', array('project' => $project, 'issue' => $issue, ));
					\Mail::send_email($text, $row->email, $subject);
				}
			}
		}

		/* Return success and issue object */
		return array(
			'success' => true,
			'issue' => $issue
		);
	}

	public static function count_issues() {
		/* Count Open Issues - Project must be open */
		$count = \DB::table('projects_issues')
									->join('projects', 'projects.id', '=', 'projects_issues.project_id')
									->where('projects.status', '=', 1)
									->where('projects_issues.status', '>', 1)
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
			'open' => $open_issues,
			'closed' => $closed_issues
		);
	}

}
