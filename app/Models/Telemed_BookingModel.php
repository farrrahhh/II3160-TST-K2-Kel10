<?php

namespace App\Models;

use CodeIgniter\Model;

class Telemed_BookingModel extends Model
{
    protected $DBGroup = 'secondary';
    protected $table = 'bookings';
    protected $primaryKey = 'booking_id';
    protected $allowedFields = ['booking_id', 'patient_id', 'dokter_id', 'booking_date', 'jam_booking'];
}
