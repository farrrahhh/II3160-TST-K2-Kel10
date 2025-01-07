<?php

namespace App\Models;

use CodeIgniter\Model;

class Telemed_UserModel extends Model
{
    protected $DBGroup = 'secondary';
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role'];

    protected $useTimestamps = false;

    /**
     * Fungsi untuk mendapatkan pengguna berdasarkan username
     */
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
