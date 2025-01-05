<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model 
{
    protected $table = 'users';                       
    protected $primaryKey = 'user_id';                
    protected $allowedFields = ['name', 'email', 'password', 'role'];

    public function validateUser($email, $password)
    {   
        $password = md5($password);
        $user = $this->where('email', $email)
                     ->where('password', $password)
                     ->first();

        return $user;
    }

    public function getUser($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        } else {
            return $this->getWhere(['user_id' => $id]);
        }   
    }

    public function insertUser($data)
    {
        return $this->insert($data);
    }
}
