<?php

namespace App\Controllers;


class MediMartHome extends BaseController
{
    public function index()
    {
        return view('MediMart/homepage');
    }
}