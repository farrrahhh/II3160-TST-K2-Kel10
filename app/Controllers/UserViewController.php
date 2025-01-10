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
        $userId = session()->get('user_id');
        return view('MediMart/user/transactions', ['userId' => $userId]);
    }
    public function Consultation()
    {
        return view('MediMart/user/easydiagnose');
    }
    public function Payment()
    {
        $order_id = session()->get('order_id');
        
        return view('MediMart/user/payments', ['order_id' => $order_id]);
    }
    public function Booking()
    {
        return view('MediMart/user/booking');
    }

}