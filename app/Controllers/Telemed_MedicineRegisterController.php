<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Client;

class Telemed_MedicineRegisterController extends BaseController
{
    public function index()
    {
        // Menampilkan form registrasi
        return view('patient/Telemed_UserMedicineRegister');
    }

    public function submit()
    {
        // $client = \Config\Services::curlrequest(); // Menggunakan HTTP Client
        // $apiUrl = 'http://localhost:8080/MediMart/register'; // URL API teman Anda

        // Ambil data dari form
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = 'password123';

       // Validasi input
       if (!$name || !$email || !$password) {
        return redirect()->back()->with('error', 'Semua field wajib diisi!')->withInput();
    }

    // Endpoint API
    $apiUrl = base_url('/MediMart/register'); 

    // Data untuk dikirim
    $postData = http_build_query([
        'name' => $name,
        'email' => $email,
        'password' => $password,
    ]);

    // Opsi context untuk HTTP POST
    $options = [
        'http' => [
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
                         "Content-Length: " . strlen($postData) . "\r\n",
            'method'  => 'POST',
            'content' => $postData,
        ],
    ];

    // Membuat stream context
    $context = stream_context_create($options);

    try {
        // Kirim permintaan ke API
        $response = file_get_contents($apiUrl, false, $context);

        if ($response === FALSE) {
            throw new \Exception('Gagal menghubungi API.');
        }

        // Decode respons JSON
        $body = json_decode($response, true);

        // Periksa apakah berhasil
        if (isset($body['message'])) {
            return redirect()->to('/patient/dashboard')->with('success', 'Registrasi berhasil!');
        } else {
            return redirect()->back()->with('error', 'Gagal melakukan registrasi.')->withInput();
        }
    } catch (\Exception $e) {
        // Tangani kesalahan
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
    }
}
}