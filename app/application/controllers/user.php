<?php

class User_Controller extends Base_Controller {

	/**
	 * Edit the user's settings
	 * /user/settings
	 *
	 * @return View
	 */
	public function get_settings()
	{
		return $this->layout->with('active', 'settings')->nest('content', 'user.settings', array(
			'user' => Auth::user()
		));
	}

	public function post_settings()
	{
		$settings = User\Setting::update_user_settings(Input::all(), Auth::user()->id);

		if(!$settings['success'])
		{
			return Redirect::to('user/settings')
				->with_input()
				->with_errors($settings['errors'])
				->with('notice-error', __('tinyissue.we_have_some_errors'));
		}

		return Redirect::to('user/settings')
			->with('notice', __('tinyissue.settings_updated'));
	}

	/**
	 * Shows the user's assigned issues
	 * /user/issues
	 *
	 * @return View
	 */
	public function get_issues()
	{
		return $this->layout->with('active', 'issues')->nest('content', 'user.issues', array(
			'projects' => Project\User::users_issues(),
		));
	}

	/**
	 * Log the user out
	 * /user/logout
	 *
	 * @return Redirect
	 */
	public function get_logout()
	{
		Auth::logout();

		return Redirect::to('/');
	}

}