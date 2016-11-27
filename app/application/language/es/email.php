<?php

return array(

	/** new user **/
    'subject_newuser' => 'Su cuenta de usuario '.Config::get('application.my_bugs_app.name').' ha sido creada',
	'new_user' => 'Se ha configurado la cuenta con '.Config::get('application.my_bugs_app.name').' en',
    'creds' => 'Puede entrar con su email %s y la clave asignada %s.',
	
	/** issue updates **/
	'new_issue' => 'La incidencia nueva "%s" se ha creado en el proyecto "%s"',
	'new_comment' => 'La incidencia "%s" del proyecto "%s" tiene nuevos comentarios',
	'assignment' => 'La incidencia "%s" fue creada en el proyecto "%s" y asignada a su usuario',
	'reassignment' => 'La incidencia "%s" en el proyecto "%s" ha sido reasignada a su usuario',
	'update' => 'La incidencia "%s" en el proyecto "%s" ha sido actualizada',
	
	'submitted_by' => 'Enviada por: %s',
	'created_by' => 'Creada por: %s',
	'reassigned_by' => 'Reasignada por: %s',
	'updated_by' => 'Actualizada por: %s',

	'issue_changed' => 'La incidencia "%s" en el proyecto "%s" fue %s',
	'closed' => 'cerrada',
	'reopened' => 'reabierta',
	//changed, reopened, etc. by
	'by' => 'por',	
	
	/** general **/
	'more_url' => 'Más información en: ',
	
);