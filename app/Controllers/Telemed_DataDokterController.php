<?php

namespace App\Controllers;

use App\Models\Telemed_DataDokterModel;

class Telemed_DataDokterController extends BaseController
{
    public function index()
    {
        $dokterModel = new Telemed_DataDokterModel();

        // Ambil ID user dari session
        $userId = session()->get('id');

        // Cek apakah dokter sudah mengisi data
        $dokter = $dokterModel->where('id', $userId)->first();

        $data = [
            'pageTitle' => 'Data Dokter',
            'dokter' => $dokter, // Jika data dokter sudah ada, tampilkan
        ];

        return view('doctor/Telemed_DataDokter', $data);
    }

    public function save()
    {
        $dokterModel = new Telemed_DataDokterModel();

        $userId = session()->get('id'); // Ambil ID user dari session
        if (!$userId) {
            return redirect()->back()->with('error', 'User ID tidak ditemukan di session.');
        }

        // Data yang akan disimpan atau diperbarui
        $data = [
            'id' => $userId,
            'nama_dokter' => $this->request->getPost('nama_dokter'),
            'spesialis' => $this->request->getPost('spesialis'),
        ];

        // Cek apakah data dokter sudah ada
        $existingDokter = $dokterModel->where('id', $userId)->first();

        if ($existingDokter) {
            // Jika data ada, update
            $dokterModel->update($existingDokter['dokter_id'], $data);
            return redirect()->to('/doctor/dashboard')->with('success', 'Data dokter berhasil diperbarui!');
        } else {
            // Jika data belum ada, tambahkan data baru
            $dokterModel->insert($data);

            // Simpan dokter_id ke session
            $newDokter = $dokterModel->where('id', $userId)->first();
            session()->set('dokter_id', $newDokter['dokter_id']);

            return redirect()->to('/doctor/dashboard')->with('success', 'Data dokter berhasil disimpan!');
        }
    }

    
}
