<?php

namespace App\Controllers;

use App\Models\Telemed_BookingModel;
use App\Models\Telemed_DataPasienModel;
use App\Models\Telemed_JadwalDokterModel;
use App\Models\Telemed_DataDokterModel;

class Telemed_BookingController extends BaseController
{
    public function index()
    {
        $patientModel = new Telemed_DataPasienModel();
        $jadwalDokterModel = new Telemed_JadwalDokterModel();
        
        // Ambil ID user dari session
        $userId = session()->get('id');

        if (!$userId) {
            log_message('error', 'User ID tidak ditemukan di session.');
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Daftar keluhan pasien berdasarkan ID pasien
        $keluhan = $patientModel->where('id', $userId)->findAll();

        // Daftar jadwal dokter, hanya kolom yang dibutuhkan
        $jadwalDokter = $jadwalDokterModel
            ->select('jadwal_dokter.dokter_id, jadwal_dokter.jam, jadwal_dokter.jadwal_konsultasi AS tanggal, data_dokter.spesialis, data_dokter.nama_dokter')
            ->join('data_dokter', 'jadwal_dokter.dokter_id = data_dokter.dokter_id')
            ->findAll();

        // Cek hasilnya di log
        log_message('debug', 'Jadwal Dokter: ' . print_r($jadwalDokter, true));
        $patientID = session()->get('id');

        return view('Telemed_Booking', [
            'keluhan' => $keluhan,
            'jadwalDokter' => $jadwalDokter,
            'patientID' => $patientID
        ]);
    }

    public function create()
    {
        $bookingModel = new Telemed_BookingModel();
        $jadwalDokterModel = new Telemed_JadwalDokterModel();
        
        // Debug: periksa data yang diterima dari form
        $postData = $this->request->getPost();
        log_message('debug', 'Data yang diterima: ' . print_r($postData, true));

        // Ambil data dari form
        $patientId = session()->get('id');
        $jadwalDokterId = $this->request->getPost('jadwal_dokter_id');
        $dokterId = $this->request->getPost('dokter_id');
        $bookingDate = $this->request->getPost('booking_date');
        $jamBooking = $this->request->getPost('jam_booking');
        
        // Validasi input
        if (!$patientId || !$jadwalDokterId || !$dokterId || !$bookingDate || !$jamBooking) {
            log_message('error', 'Validasi input gagal. Semua field wajib diisi.');
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Semua field wajib diisi!'
            ]);
        }

        // Cek apakah pasien sudah pernah booking untuk jadwal dokter ini
        $existingBooking = $bookingModel
            ->where('patient_id', $patientId)
            ->where('dokter_id', $dokterId)
            ->where('booking_date', $bookingDate)
            ->where('jam_booking', $jamBooking)
            ->first();
        
        if ($existingBooking) {
            log_message('info', 'Pasien sudah memiliki booking untuk jadwal ini.');
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Anda sudah memiliki booking untuk jadwal ini.'
            ]);
        }

        // Data booking baru
        $data = [
            'patient_id'    => $patientId,
            'dokter_id'     => $dokterId,
            'booking_date'  => $bookingDate,
            'jam_booking'   => $jamBooking,
        ];

        try {
            $bookingModel->save($data);
            log_message('info', 'Data yang disimpan: ' . print_r($data, true));
            // redirect to dashboard 
            return redirect()->to('/patient/dashboard')->with('success', 'Booking berhasil dibuat.');

        } catch (\Exception $e) {
            log_message('error', "Terjadi kesalahan saat menyimpan booking: " . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Gagal membuat booking!'
            ]);
        }
    }

    public function createProcess(){
        $bookingModel = new Telemed_BookingModel();
        
        // Ambil data dari form
        $patientId = session()->get('id');
        $jadwalDokterId = $this->request->getPost('jadwal_dokter_id');
        $dokterId = $this->request->getPost('dokter_id');
        $bookingDate = $this->request->getPost('booking_date');
        $jamBooking = $this->request->getPost('jam_booking');
        
        // Validasi input
        if (!$patientId || !$jadwalDokterId || !$dokterId || !$bookingDate || !$jamBooking) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Semua field wajib diisi!'
            ]);
        }

        // Cek apakah pasien sudah pernah booking untuk jadwal dokter ini
        $existingBooking = $bookingModel
            ->where('patient_id', $patientId)
            ->where('dokter_id', $dokterId)
            ->where('booking_date', $bookingDate)
            ->where('jam_booking', $jamBooking)
            ->first();
        
        if ($existingBooking) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Anda sudah memiliki booking untuk jadwal ini.'
            ]);
        }

        // Data booking baru
        $data = [
            'patient_id'    => $patientId,
            'dokter_id'     => $dokterId,
            'booking_date'  => $bookingDate,
            'jam_booking'   => $jamBooking,
        ];

        try {
            $bookingModel->save($data);
            return $this->response->setStatusCode(200)->setJSON([
                'success' => 'Booking berhasil dibuat!'
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Gagal membuat booking!'
            ]);
        }
    }




    
}