<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AuthController extends ResourceController
{
    public function login(){
        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $user = $model->validateUser($email, $password);
        if ($user) {
            // Pastikan kunci rahasia (secret key) sesuai dengan yang digunakan untuk encode/decode JWT
            $key = 'itGDlDTd9TFgyaNwsY8NntPu0OdisipJk/4BCKMUEUY72tUGh51O5/bhnNCA7J/X/y4uLaz7neeWU4BpvF0IiQ==';

            // Data payload untuk JWT
            $payload = [
                'iss' => 'example.com', 
                'aud' => 'example.com', 
                'iat' => time(),        
                'nbf' => time(),        
                'exp' => time() + 3600, 
                'data' => [
                    'id' => $user['user_id'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                ],
            ];

            // Encode payload menggunakan JWT dan algoritma HS256
            $jwt = JWT::encode($payload, $key, 'HS256');

            // Return token dalam response
            return $this->respond(['token' => $jwt], 200);
        } else {
            // Jika user tidak ditemukan, kirim response gagal
            return $this->respond(['message' => 'Invalid login'], 401);
        }
    }
    public function register(){
        $model = new UserModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'password' => md5($this->request->getVar('password')),
            'role' => 'user'
        ];
        $model->insertUser($data);
        return $this->respondCreated(['message' => 'User created successfully']);
    }
}
