<?php

namespace App\Controllers;

class UserViewController extends BaseController
{
    public function Dashboard()
    {
        $userId = session()->get('user_id');
        return view('MediMart/user/dashboard', ['userId' => $userId]);

    }
    public function Transactions()
    {
        return view('MediMart/user/transactions');
    }
    public function Consultation()
    {
        return view('MediMart/user/consultation');
    }
    public function Payment()
    {
        return view('MediMart/user/profile');
    }

}