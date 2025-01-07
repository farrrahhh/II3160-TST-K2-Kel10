<?php

namespace App\Controllers;

use App\Models\Telemed_UserModel;

class Telemed_SignupController extends BaseController
{
    public function index()
    {
        // Tampilkan halaman signup
        return view('Telemed_Signup');
    }

    public function register()
    {
        // Ambil data dari form signup
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role');

        // Validasi input
        if (empty($username) || empty($password) || empty($role)) {
            return redirect()->back()->with('error', 'All fields are required!');
        }

        $userModel = new Telemed_UserModel();

        // Periksa apakah username sudah ada
        if ($userModel->where('username', $username)->first()) {
            return redirect()->back()->with('error', 'Username already exists!');
        }

        // Hash password menggunakan MD5
        $hashedPassword = md5($password);

        // Masukkan data ke database
        $userModel->save([
            'username' => $username,
            'password' => $hashedPassword,
            'role' => $role,
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->to('/login')->with('success', 'Account created successfully! Please login.');
    }
}
