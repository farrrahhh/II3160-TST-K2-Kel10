<?php

namespace App\Models;
use CodeIgniter\Model;
class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $allowedFields = [
        'name', 
        'description', 
        'category', 
        'price', 
        'stock', 
        'is_active'
    ]; 

    public function getProduct($id = false)
    {
        if ($id === false) {
            // Kembalikan semua data
            return $this->findAll();
        } else {
            // Ambil data berdasarkan ID dan kembalikan sebagai array
            $result = $this->getWhere(['product_id' => $id])->getRowArray();
            return $result;
        }
    }

    public function insertProduct($data)
    {
        
        return $this->insert($data);
    }
    public function updateProduct($data, $id)
    {
        return $this->update($id, $data);
    }
    public function deleteProduct($id)
    {
        return $this->delete($id);
    }
    public function getProductByIsActive()
    {
        // only return the name of prodyct and the price
        return $this->select('name, price')->getWhere(['is_active' => 1])->getResultArray();
    }
    // search product by name or category
    public function searchProduct($keyword)
    {
        return $this->like('name', $keyword)->orLike('category', $keyword)->get()->getResultArray();
    }

}