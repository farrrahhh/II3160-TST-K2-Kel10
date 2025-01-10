<?php

namespace App\Controllers;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data = $model->getUser();
        return $this->response->setJSON($data);
    }

    public function show($id = null)
    {
        $model = new UserModel();
        $data = $model->getUser($id);
        return $this->response->setJSON($data);
    }
    
}