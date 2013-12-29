<?php namespace Admin;

class UsersController extends \BaseController {

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('permission:administration');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return $this->layout->with('active', 'dashboard')->nest('content', 'administration.users.index', array(
            'roles' => \Role::orderBy('id', 'DESC')->get()
        ));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getAdd()
    {
        return $this->layout->with('active', 'dashboard')->nest('content', 'administration.users.add');
    }

    /**
     * @return \Illuminate\Routing\Redirector
     */
    public function postAdd()
    {
        $add = \User::addUser(\Input::all());

        if( ! $add['success'])
        {
            return \Redirect::to('administration/users/add/')
                ->withInput()
                ->withErrors($add['errors'])
                ->with('notice-error', trans('tinyissue.we_have_some_errors'));
        }

        return \Redirect::to('administration/users')
            ->with('notice', trans('tinyissue.user_added'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getEdit($user_id)
    {
        return $this->layout->with('active', 'dashboard')->nest('content', 'administration.users.edit', array(
            'user' => \User::find($user_id)
        ));
    }

    /**
     * @return \Illuminate\Routing\Redirector
     */
    public function postEdit($user_id)
    {
        $update = \User::update_user(\Input::all(),$user_id);

        if ( ! $update['success'])
        {
            return \Redirect::to('administration/users/edit/' . $user_id)
                ->withInput()
                ->withErrors($update['errors'])
                ->with('notice-error', trans('tinyissue.we_have_some_errors'));
        }

        return \Redirect::to('administration/users')
            ->with('notice', trans('tinyissue.user_updated'));
    }

    /**
     * Delete an user of website.
     *
     * @param int $user_id
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function getDelete($user_id)
    {
        \User::deleteUser((int) $user_id);

        return \Redirect::to('administration/users')
            ->with('notice', trans('tinyissue.user_deleted'));
    }
}
