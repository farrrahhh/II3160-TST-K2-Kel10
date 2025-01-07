<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Telemed_JadwalDokterModel;

class Telemed_DoctorController extends BaseController
{
    public function dashboard()
    {
        // Data yang ingin ditampilkan di dashboard (contoh)
        $data = [
            'pageTitle' => 'Doctor Dashboard',
            'welcomeMessage' => 'Welcome to your dashboard, Doctor!',
        ];

        return view('doctor/Telemed_DoctorDashboard', $data);
    }

    public function showAddScheduleForm()
    {
        return view('doctor/Telemed_DoctorAddSchedule');
    }

    public function addSchedule()
{
    $jadwalModel = new Telemed_JadwalDokterModel();
    log_message('info', 'Data yang diterima: ' . json_encode($this->request->getPost()));

    $dokterId = session()->get('dokter_id'); // Dokter ID dari session
    if (!$dokterId) {
        log_message('error', 'Dokter ID tidak ditemukan di session.');
        return redirect()->back()->with('error', 'Gagal: Dokter ID tidak ditemukan.');
    }

    $data = [
        'dokter_id' => $dokterId,
        'jadwal_konsultasi' => $this->request->getPost('jadwal_konsultasi'),
        'jam' => $this->request->getPost('jam'),
    ];

    if (!$jadwalModel->insert($data)) {
        log_message('error', 'Gagal menyimpan data: ' . json_encode($jadwalModel->errors()));
        return redirect()->back()->with('errors', $jadwalModel->errors())->withInput();
    }

    log_message('info', 'Jadwal berhasil ditambahkan: ' . json_encode($data));
    return redirect()->to('/doctor/dashboard')->with('message', 'Jadwal berhasil ditambahkan.');
}


}
