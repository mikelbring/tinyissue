<?php

return array(

	/** new user **/
    'subject_newuser' => 'Your '.Config::get('application.my_bugs_app.name').' account',
	'new_user' => 'You have been set up with '.Config::get('application.my_bugs_app.name').' at',
    'creds' => 'You may log in with email %s and password %s.',
	
	/** issue updates **/
	'new_issue' => 'New issue "%s" was submitted to "%s" project',
	'new_comment' => 'Issue "%s" in "%s" project has a new comment',
	'assignment' => 'New issue "%s" was submitted to "%s" project and assigned to you',
	'assigned_by' => 'Assigned by: %s',
	'reassignment' => 'Issue "%s" in "%s" project was reassigned to you',
	'update' => 'Issue "%s" in "%s" project was updated',
	
	'submitted_by' => 'Submitted by: %s',
	'created_by' => 'Created by: %s',
	'reassigned_by' => 'Reassigned by: %s',
	'updated_by' => 'Updated by: %s',

	'issue_changed' => 'Issue "%s" in "%s" project was %s',
	'closed' => 'closed',
	'reopened' => 'reopened',
	//changed, reopened, etc. by
	'by' => 'by',	
	
	/** general **/
	'more_url' => 'Find more information at: ',
	
);