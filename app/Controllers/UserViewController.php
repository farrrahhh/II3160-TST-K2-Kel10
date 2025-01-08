<?php

namespace App\Controllers;

class UserViewController extends BaseController
{
    public function Dashboard()
    {
        return view('MediMart/user/dashboard');
    }

}