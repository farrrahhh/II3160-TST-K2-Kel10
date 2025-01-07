<?php

namespace App\Models;

use CodeIgniter\Model;

class Telemed_DataDokterModel extends Model
{
    protected $DBGroup = 'secondary'; 
    protected $table = 'data_dokter'; // Tabel data_dokter
    protected $primaryKey = 'dokter_id'; // Primary key
    protected $allowedFields = ['id', 'nama_dokter', 'spesialis']; // Kolom yang dapat diisi
    protected $useTimestamps = true; // Tidak menggunakan timestamps
}
