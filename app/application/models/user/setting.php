<?php namespace User;

class Setting extends \Eloquent {

	public static $table = 'user';

	/**
	* Updates the users settings, validates the fields
	*
	* @param  array  $info
	* @param  int    $user_id
	* @return array
	*/
	public static function update_user_settings($info, $user_id)
	{
		$rules = array(
			'firstname'  => array('required', 'max:50'),
			'lastname'  => array('required', 'max:50'),
			'email' => array('required', 'email'),
		);

		/* Validate the password */
		if($info['password'])
		{
			$rules['password'] = 'confirmed';
		}

		$validator = \Validator::make($info, $rules);

		if($validator->fails())
		{
			return array(
				'success' => false,
				'errors' => $validator->errors
			);
		}

		/* Settings are valid */
		$update = array(
			'email' => $info['email'],
			'firstname' => $info['firstname'],
			'lastname' => $info['lastname']
		);

		/* Update the password */
		if($info['password'])
		{
			$update['password'] = \Hash::make($info['password']);
		}

		\User::find($user_id)->fill($update)->save();

		return array(
			'success' => true
		);
	}
}