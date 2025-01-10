<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Telemed_MedicineRegisterController extends Controller
{
    public function index()
    {
        return view('patient/Telemed_UserMedicineRegister', ['title' => 'User Registration']);
    }

    public function submit()
    {
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$name || !$email || !$password) {
            return redirect()->back()->with('error', 'All fields are required!')->withInput();
        }

        $url = 'http://farahproject.my.id/MediMart/registerprocess';
        $postData = [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ];

        $client = new Client();

        try {
            $response = $client->request('POST', $url, [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => $postData,
                'timeout' => 10,
            ]);

            if ($response->getStatusCode() == 200) {
                return redirect()->to('patient/Catalog')->with('message', 'Registration successful!');
            } else {
                return redirect()->back()->with('error', 'Registration failed. Please try again.')->withInput();
            }
        } catch (GuzzleException $e) {
            log_message('error', 'Registration error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during registration. Please try again later.')->withInput();
        }
    }
}
