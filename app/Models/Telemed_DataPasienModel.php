<?php

namespace App\Models;

use CodeIgniter\Model;

class Telemed_DataPasienModel extends Model
{
    protected $DBGroup = 'secondary';
    protected $table = 'data_pasien';
    protected $primaryKey = 'pasien_id';
    protected $allowedFields = ['id', 'nama', 'keluhan_penyakit', 'usia'];
}
