<?php

class UserController extends BaseController {

    public function index()
    {
        $users = App::make('User')->all();
        // return View::make('users.index', ['users' => $users]);
    }

}
