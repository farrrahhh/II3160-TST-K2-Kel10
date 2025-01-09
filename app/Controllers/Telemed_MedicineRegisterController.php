<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;

class Telemed_MedicineRegisterController extends Controller
{
    public function index()
    {
        return view('patient/Telemed_UserMedicineRegister');
    }

    public function submit()
    {
        // Ambil data dari form
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = 'password123'; // Password default

        // Validasi input
        if (!$name || !$email) {
            return redirect()->back()->with('error', 'All fields are required!')->withInput();
        }
        $url = 'http://localhost:8080/MediMart/register';

        // Data yang akan dikirim ke API
        $postData = [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ];

        // Inisialisasi Guzzle client
        $client = new Client();


        try {
            // Mengirimkan data POST ke API
            $response = $client->request('POST', $url, [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => $postData, // Secara otomatis meng-encode data menjadi JSON
                'timeout' => 10, // Timeout 10 detik
            ]);

            // Cek status code dari response API
            if ($response->getStatusCode() == 200) {
                return redirect()->to('/success')->with('message', 'Registration successful!');
            } else {
                return redirect()->back()->with('error', 'Registration failed!')->withInput();
            }
        } catch (\Exception $e) {
            // Jika terjadi error pada request
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }
}
