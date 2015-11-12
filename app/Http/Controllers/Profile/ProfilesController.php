<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\User;
use Validator;

class ProfilesController extends Controler {


    public function __construct()
    {
        $this->beforeFilter('auth');
    }


    public function showProfile($id)
    {
        $user = User::find($id);

        return View::make('user.profile', array('user' => $user));
    }

}


?>