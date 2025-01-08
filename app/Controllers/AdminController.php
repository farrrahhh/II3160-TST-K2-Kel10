<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    // function return view admin
    public function ManageProduct()
    {
        return view('MediMart/admin/manageProduct');
    }

    public function Payments()
    {
        return view('MediMart/admin/payments');
    }

    public function Shipping()
    {
        return view('MediMart/admin/shipping');
    }
}