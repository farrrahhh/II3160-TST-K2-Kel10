<?php

namespace App\Controllers;

use App\Models\Telemed_UserModel;

class Telemed_AdminController extends BaseController
{
    public function editUser($id)
    {
        $userModel = new Telemed_UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }

        return view('admin/Telemed_Admin_EditUser', ['user' => $user]);
    }

    public function updateUser($id) {
        $userModel = new Telemed_UserModel();

        // Ambil data user dari database
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }

        // Ambil data dari form
        $username = $this->request->getPost('username');
        $role = $this->request->getPost('role');

        // Validasi input
        if (empty($username) || empty($role)) {
            return redirect()->back()->with('error', 'All fields are required!');
        }

        // Update data user
        $userModel->update($id, [
            'username' => $username,
            'role' => $role,
        ]);

        // Redirect ke halaman manage users dengan pesan sukses
        return redirect()->to('/admin/manage-users')->with('success', 'User updated successfully!');
    }

    public function deleteUser($id) {
        $userModel = new Telemed_UserModel();

        // Periksa apakah user dengan ID tersebut ada
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }

        // Hapus user dari database
        $userModel->delete($id);

        // Redirect ke halaman manage users dengan pesan sukses
        return redirect()->to('/admin/manage-users')->with('success', 'User deleted successfully!');
    }

}
