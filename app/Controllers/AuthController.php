<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AuthController extends ResourceController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }
    public function login(){

        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $user = $model->validateUser($email, $password);
        if ($user) {
            // Jika user ditemukan, set session
            session()->set([
                'user_id' => $user['user_id'],
                'name'    => $user['name'],
                'email'   => $user['email'],
                'role'    => $user['role'],
                'is_logged_in' => true
            ]);
            
            

            // kalau sudah login dan role = admin redirect ke halaman admin
            if ($user['role'] == 'admin') {
                return redirect()->to('/MediMart/admin/manage');
            }
            return redirect()->to('/MediMart/user/dashboard');

        } else {
            // Jika user tidak ditemukan, kirim response gagal
            return $this->respond(['message' => 'Invalid login'], 401);
        }
    }
    public function registerProcess(){
        $model = new UserModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'password' => md5($this->request->getVar('password')),
            'role' => 'customer'
        ];

        $model->insertUser($data);
        

        
    }

    public function register(){
        // call register process
        $this->registerProcess();
        return redirect()->to('/MediMart/login');
    }

    

    // return view login
    public function Medimartlogin(){
        return view('MediMart/auth/login');
    }
    public function Medimartregister(){
        return view('MediMart/auth/signup');
    }
    public function logout(){
        session()->destroy();
        return redirect()->to('/MediMart');
    }
   
}
