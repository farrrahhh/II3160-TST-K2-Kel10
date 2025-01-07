<?php

namespace App\Models;

use CodeIgniter\Model;

class Telemed_JadwalDokterModel extends Model
{
    protected $DBGroup = 'secondary';
    protected $table = 'jadwal_dokter'; // Nama tabel
    protected $primaryKey = 'jadwal_dokter_id'; // Primary key
    protected $allowedFields = ['dokter_id', 'jadwal_konsultasi', 'jam']; // Kolom yang diizinkan
    protected $useTimestamps = false; // Tidak menggunakan timestamps

    protected $validationRules = [
        'dokter_id' => 'required|integer|is_not_unique[data_dokter.dokter_id]',
        'jadwal_konsultasi' => 'required|valid_date[Y-m-d]',
        'jam' => 'required|valid_date[H:i]',
    ];

    protected $validationMessages = [
        'dokter_id' => [
            'required' => 'Dokter ID wajib diisi.',
            'is_not_unique' => 'Dokter ID tidak valid.',
        ],
        'jadwal_konsultasi' => [
            'valid_date' => 'Tanggal konsultasi harus valid (YYYY-MM-DD).',
        ],
        'jam' => [
            'valid_date' => 'Jam konsultasi harus valid (HH:mm).',
        ],
    ];
}
