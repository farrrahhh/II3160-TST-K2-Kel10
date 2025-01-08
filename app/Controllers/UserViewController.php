<?php

namespace App\Controllers;

class UserViewController extends BaseController
{
    public function Dashboard()
    {
        return view('MediMart/user/dashboard');
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