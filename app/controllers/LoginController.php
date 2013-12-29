<?php

class LoginController extends Controller {

    /**
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return View::make('layouts.login');
    }

    /**
     * Connection process.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function postIndex()
    {
        $userdata = array(
            'email'    => Input::get('email'),
            'password' => Input::get('password'),
        );

        if (Auth::attempt($userdata))
        {
            return Redirect::to(Input::get('return', '/'));
        }

        return Redirect::to('login')->with('error', Lang::get('tinyissue.password_incorrect'));
    }
}
