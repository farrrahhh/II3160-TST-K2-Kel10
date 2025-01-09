<?php

namespace App\Models;
use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $allowedFields = [
        'user_id', 
        'total_price', 
        'status',
        'shipping_address'
    ]; 

    public function getOrder($id = false)
    {
        if ($id === false) {
            // Kembalikan semua data
            return $this->findAll();
        } else {
            // Ambil data berdasarkan ID dan kembalikan sebagai array
            $result = $this->getWhere(['order_id' => $id])->getRowArray();
            return $result;
        }
    }

    public function insertOrder($data)
    {
        return $this->insert($data);
    }
    public function updateOrderStatus($status, $id)
    {
        return $this->update($id, ['status' => $status]);
    }
    public function getOrderByUser($user_id)
    {
        // validate user_id
        if (!$user_id) {
            return [];
        }
        return $this->getWhere(['user_id' => $user_id])->getResultArray();
    }
    public function getOrderDetail($order_id)
    {
        $query = $this->db->table('order_details')
            ->select('order_details.*, products.name, products.price')
            ->join('products', 'products.product_id = order_details.product_id')
            ->where('order_id', $order_id)
            ->get();

        $result = $query->getResultArray();
        
        // Log hasil query untuk debugging
        log_message('debug', 'Query Result: ' . json_encode($result));

        return $result;
    }
    
}