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

        return view('Telemed_Booking', [
            'keluhan' => $keluhan,
            'jadwalDokter' => $jadwalDokter,
        ]);
    }

    


    public function create()
    {
        $bookingModel = new Telemed_BookingModel();
        $jadwalDokterModel = new Telemed_JadwalDokterModel();
    
        // Ambil data dari form
        $patientId = session()->get('id');
        $jadwalDokterId = $this->request->getPost('jadwal_dokter_id');
    
        // Validasi input
        if (!$patientId || !$jadwalDokterId) {
            log_message('error', 'Validasi input gagal. Semua field wajib diisi.');
            return redirect()->back()->with('error', 'Semua field wajib diisi!')->withInput();
        }
    
        // Ambil detail jadwal dokter berdasarkan jadwal_dokter_id
        $jadwal = $jadwalDokterModel->find($jadwalDokterId);
    
        if (!$jadwal) {
            log_message('error', 'Jadwal dokter tidak ditemukan.');
            return redirect()->back()->with('error', 'Jadwal dokter tidak valid.')->withInput();
        }
    
        // Cek apakah pasien sudah pernah booking untuk jadwal dokter ini
        $existingBooking = $bookingModel
            ->where('patient_id', $patientId)
            ->where('dokter_id', $jadwal['dokter_id'])
            ->where('booking_date', $jadwal['jadwal_konsultasi'])
            ->where('jam_booking', $jadwal['jam'])
            ->first();
    
        if ($existingBooking) {
            log_message('info', 'Pasien sudah memiliki booking untuk jadwal ini.');
            return redirect()->back()->with('error', 'Anda sudah memiliki booking untuk jadwal ini.')->withInput();
        }
    
        // Data booking baru
        $data = [
            'patient_id'    => $patientId,
            'dokter_id'     => $jadwal['dokter_id'],
            'booking_date'  => $jadwal['jadwal_konsultasi'],
            'jam_booking'   => $jadwal['jam'],
        ];
    
        try {
            $bookingModel->save($data);
            log_message('info', 'Data yang disimpan: ' . print_r($data, true));
            return redirect()->to('/patient/dashboard')->with('success', 'Booking berhasil dibuat!');
        } catch (\Exception $e) {
            log_message('error', "Terjadi kesalahan saat menyimpan booking: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat booking!')->withInput();
        }
    }
}