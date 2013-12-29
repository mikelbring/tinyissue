<?php

class HomeController extends BaseController {

    public function getIndex()
    {
        return $this->layout->with('active', 'dashboard')->nest('content', 'activity.dashboard');
    }
}
