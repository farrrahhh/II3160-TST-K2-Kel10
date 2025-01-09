<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Telemed_JadwalDokterModel;
use App\Models\Telemed_BookingModel;

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

    // view scheduled appointments
    public function viewAppointments()
    {
        // booking model
        $bookingModel = new Telemed_BookingModel();
        $dokterId = session()->get('id'); // Dokter ID dari session
        if (!$dokterId) {
            log_message('error', 'Dokter ID tidak ditemukan di session.');
            return redirect()->back()->with('error', 'Gagal: Dokter ID tidak ditemukan.');
        }

        $appointments = $bookingModel->where('dokter_id', $dokterId)->findAll();
        $data = [
            'pageTitle' => 'Doctor View Appointments',
            'appointments' => $appointments,
        ];


        return view('doctor/Telemed_DoctorViewAppointments', $data);


    }

    public function getDoctor()
{
    // Ambil parameter 'spesialis' dari request
    $spesialis = $this->request->getVar('spesialis');

    // Validasi input
    if (!$spesialis) {
        return $this->response->setJSON(['error' => 'Parameter spesialis is required'])->setStatusCode(400);
    }

    // Model untuk jadwal dokter
    $jadwalDokterModel = new Telemed_JadwalDokterModel();

    // Pecah string menjadi array (dipisahkan '-')
    $spesialisList = explode('-', $spesialis);

    // Mulai query
    $jadwalDokterModel
        ->select('jadwal_dokter.dokter_id, jadwal_dokter.jam, jadwal_dokter.jadwal_konsultasi AS tanggal, data_dokter.spesialis, data_dokter.nama_dokter')
        ->join('data_dokter', 'jadwal_dokter.dokter_id = data_dokter.dokter_id');

    // Tambahkan kondisi LIKE untuk setiap nilai dalam array
    foreach ($spesialisList as $value) {
        $jadwalDokterModel->orLike('data_dokter.spesialis', trim($value));
    }

    // Ambil data dari database
    try {
        $jadwalDokter = $jadwalDokterModel->findAll();

        // Jika tidak ada data
        if (empty($jadwalDokter)) {
            return $this->response->setJSON(['message' => 'No doctors found'])->setStatusCode(404);
        }

        // Kembalikan data dalam format JSON
        return $this->response->setJSON($jadwalDokter)->setStatusCode(200);

    } catch (\Exception $e) {
        // Tangani error database atau lainnya
        return $this->response->setJSON(['error' => $e->getMessage()])->setStatusCode(500);
    }
}


    
    
    
}
