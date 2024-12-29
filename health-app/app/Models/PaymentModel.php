<?php

namespace App\Models;
use CodeIgniter\Model;
class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';
    protected $allowedFields = [
        'order_id', 
        'status', 
        'amount'
    ]; 

    public function getPayment($id = false)
    {
        if ($id === false) {
            // Kembalikan semua data
            return $this->findAll();
        } else {
            // Ambil data berdasarkan ID dan kembalikan sebagai array
            $result = $this->getWhere(['payment_id' => $id])->getRowArray();
            return $result;
        }
    }

    public function insertPayment($data)
    {
        return $this->insert($data);
    }
    public function updatePayment($data, $id)
    {
        return $this->update($id, $data);
    }
    public function deletePayment($id)
    {
        return $this->delete($id);
    }
    public function getPaymentByOrder($order_id)
    {
        return $this->getWhere(['order_id' => $order_id])->getRowArray();
    }
    public function updatePaymentStatus($status, $id)
    {
        return $this->set(['status' => $status])->where('payment_id', $id)->update();
    }
    
}

