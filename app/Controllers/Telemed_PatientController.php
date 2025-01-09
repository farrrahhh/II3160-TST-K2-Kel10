<?php

namespace App\Controllers;

use App\Models\Telemed_DataPasienModel;

class Telemed_PatientController extends BaseController
{
    public function dashboard()
    {
        // Data untuk halaman dashboard pasien
        $data = [
            'pageTitle' => 'Patient Dashboard',
            'welcomeMessage' => 'Welcome to your dashboard, Patient!',
        ];

        return view('patient/Telemed_PatientDashboard', $data);
    }

    public function addPatientForm()
    {
        return view('patient/Telemed_AddPatient');
    }

    public function savePatient()
    {
        // Ambil ID pengguna yang sedang login
        $session = session();
        $userId = $session->get('id');
    
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk menambahkan data pasien.');
        }
    
        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required',
            'usia' => 'required|integer',
            'keluhan_penyakit' => 'required',
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    
        $data = [
            'id' => $userId, // ID user diambil dari sesi
            'nama' => $this->request->getPost('nama'),
            'usia' => $this->request->getPost('usia'),
            'keluhan_penyakit' => $this->request->getPost('keluhan_penyakit'),
        ];
    
        $pasienModel = new Telemed_DataPasienModel();
        if ($pasienModel->insert($data)) {
            // Ambil ID pasien yang baru saja disimpan
            $pasienId = $pasienModel->getInsertID();
    
            // Simpan pasien_id ke dalam session
            session()->set('pasien_id', $pasienId);
    
            // Arahkan ke dashboard pasien setelah sukses
            return redirect()->to('/patient/dashboard')->with('success', 'Data pasien berhasil disimpan!');
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan data pasien!');
        }
    }
    
    public function savePatientProcess()
    {
        // Ambil ID pengguna yang sedang login
        $userId = 20;
    
    
    
        $data = [
            'id' => $userId, // ID user diambil dari sesi
            'nama' => $this->request->getPost('nama'),
            'usia' => $this->request->getPost('usia'),
            'keluhan_penyakit' => $this->request->getPost('keluhan_penyakit'),
        ];
    
        $pasienModel = new Telemed_DataPasienModel();
        if ($pasienModel->insert($data)) {
            // return message json
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data pasien berhasil disimpan.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan data pasien.'
            ]);
        }
    }

    public function viewProfile()
    {
        $session = session();
        $userId = $session->get('id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melihat profil.');
        }

        $pasienModel = new Telemed_DataPasienModel();
        $data = $pasienModel->where('id', $userId)->first();

        return view('patient/telemed_ViewProfile', ['data' => $data]);
    }

    public function viewHistory()
{
    // Ambil ID user dari session
    $userId = session()->get('id');

    // Pastikan pasien sudah login
    if (!$userId) {
        return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Load model pasien
    $patientModel = new Telemed_DataPasienModel();

    // Ambil data pasien berdasarkan user_id
    $history = $patientModel->where('id', $userId)->findAll();

    // Kirim data ke view
    return view('patient/Telemed_PatientHistory', [
        'pageTitle' => 'Riwayat Gejala',
        'history' => $history
    ]);
}

}
