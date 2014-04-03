<?php

class UserController extends BaseController {

	/**
	 * Edit the user's settings.
	 * /user/settings
	 *
	 * @return \Illuminate\View\View
	 */
	public function getSettings()
	{
		return $this->layout->with('active', 'settings')->nest('content', 'user.settings', array(
			'user' => Auth::user()
		));
	}

    /**
     * Edit the user's settings.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function postSettings()
	{
		$settings = User\Setting::updateUserSettings(Auth::user(), Input::all());

		if ( ! $settings['success'])
		{
			return Redirect::to('user/settings')
				->withInput()
				->withErrors($settings['errors'])
				->with('notice-error', trans('tinyissue.we_have_some_errors'));
		}

		return Redirect::to('user/settings')
			->with('notice', trans('tinyissue.settings_updated'));
	}

	/**
	 * Shows the user's assigned issues.
	 * /user/issues
	 *
	 * @return \Illuminate\View\View
	 */
	public function getIssues()
	{
		return $this->layout->with('active', 'issues')->nest('content', 'user.issues', array(
			'projects' => Project\User::usersIssues(Auth::user()),
		));
	}

	/**
	 * Log the user out.
	 * /user/logout
	 *
	 * @return \Illuminate\Routing\Redirector
	 */
	public function getLogout()
	{
		Auth::logout();

		return Redirect::to('/');
	}
}
