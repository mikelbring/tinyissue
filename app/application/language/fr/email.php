<?php

return array(

	/** new user **/
	'subject_newuser' => 'Votre compte sur '.Config::get('application.my_bugs_app.name'),
	'new_user' => 'Un compte a été créé à votre intention sur '.Config::get('application.my_bugs_app.name').' à ',
	'creds' => 'Vous pouvez vous connecter via l\'email %s et mot de passe: %s.',

	/** issue updates **/
	'new_issue' => 'Un nouveau billet "%s" a été créé pour le projet "%s"',
	'new_comment' => 'Le billet "%s" du projet "%s" a un nouveau commentaire',
	'assignment' => 'Un nouveau billet "%s" a été créé pour le projet "%s" et vous a été assigné.',
	'assigned_by' => 'Assigné par: %s',
	'reassignment' => 'Le billet "%s" du projet "%s" vous a été réassigné',
	'update' => 'Le billet "%s" du projet "%s" a été mis à jour',

	'submitted_by' => 'Soumis par: %s',
	'created_by' => 'Créé par: %s',
	'reassigned_by' => 'Réassigné par: %s',
	'updated_by' => 'Mis à jour par: %s',

	'issue_changed' => 'Le billet "%s" du projet "%s" a été %s',
	'closed' => 'fermé',
	'reopened' => 'réouvert',
	//changed, reopened, etc. by
	'by' => 'par',

	/** general **/
	'more_url' => 'Plus d`information: ',

);
