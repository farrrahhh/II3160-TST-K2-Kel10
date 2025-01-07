<?php

namespace App\Controllers;

use App\Models\Telemed_UserModel;

class Telemed_AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new Telemed_UserModel();
    }

    // Halaman Login
    public function login()
    {
        return view('auth/Telemed_Login');
    }

    // Proses Login
    public function loginProcess() {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Ambil data pengguna dari database
        $user = $this->userModel->where('username', $username)->first();

        if ($user) {
            // Periksa password menggunakan MD5
            if ($user['password'] === md5($password)) {
                // Set session
                session()->set([
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'logged_in' => true,
                ]);

                // Redirect sesuai role
                if ($user['role'] === 'admin') {
                    return redirect()->to('/admin/dashboard');
                } elseif ($user['role'] === 'doctor') {
                    return redirect()->to('/doctor/dashboard');
                } elseif ($user['role'] === 'patient') {
                    return redirect()->to('/patient/dashboard');
                }
            } else {
                return redirect()->back()->with('error', 'Password salah.');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan.');
        }
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // Halaman Admin Dashboard
    public function adminDashboard()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        return view('admin/telemed_admin_dashboard');
    }

    public function register() {
    if ($this->request->getMethod() === 'post') {
        $username = $this->request->getPost('username');
        $password = md5($this->request->getPost('password')); // Menggunakan MD5 untuk hashing password
        // Enkripsi password dengan bcrypt

        // Simpan pengguna sebagai user yang belum memiliki role
        $this->userModel->save([
            'username' => $username,
            'password' => $password,
            'role' => 'pending' // Status 'pending' menunggu verifikasi dari admin
        ]);

        return redirect()->to('/login')->with('success', 'Registration successful. Please wait for admin approval.');
    }

    return view('telemed_register');
    }

    public function editUser($id) {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        // Ambil data pengguna berdasarkan ID
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $builder->where('id', $id)->get()->getRowArray();

        if (!$user) {
            return redirect()->to('/admin/manage-users')->with('error', 'User not found');
        }

        // Kirim data pengguna ke view
        return view('admin/Telemed_Admin_EditUser', ['user' => $user]);
    }

    public function updateUser($id) {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        // Validasi form
        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username');
            $role = $this->request->getPost('role');

            // Update data pengguna di database
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            $builder->where('id', $id);
            $builder->update([
                'username' => $username,
                'role' => $role
            ]);

            return redirect()->to('/admin/manage-users')->with('success', 'User updated successfully');
        }
    }

    public function manageUsers() {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied.');
        }

        // Ambil semua data pengguna dari database
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $users = $builder->get()->getResultArray();

        // Kirim data ke view
        return view('admin/Telemed_Admin_ManageUsers', ['users' => $users]);

    }




}
