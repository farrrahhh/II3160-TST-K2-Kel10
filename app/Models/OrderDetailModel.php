<?php
namespace App\Models;
use CodeIgniter\Model;

class OrderDetailModel extends Model
{
    protected $table = 'order_details';
    protected $primaryKey = 'order_detail_id';
    protected $allowedFields = [
        'order_id', 
        'product_id', 
        'quantity', 
        'price'
    ]; 


    public function getOrderDetail($id = false)
    {
        if ($id === false) {
            // Kembalikan semua data
            return $this->findAll();
        } else {
            // Ambil data berdasarkan ID dan kembalikan sebagai array
            $result = $this->getWhere(['order_detail_id' => $id])->getRowArray();
            return $result;
        }
    }

    public function insertOrderDetail($data)
    {
        return $this->insert($data);
    }
    public function updateOrderDetail($data, $id)
    {
        return $this->update($id, $data);
    }
    public function deleteOrderDetail($id)
    {
        return $this->delete($id);
    }
    public function getOrderDetailByOrder($order_id)
    {
        return $this->getWhere(['order_id' => $order_id])->getResultArray();
    }
    
}