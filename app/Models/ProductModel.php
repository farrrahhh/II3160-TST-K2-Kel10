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
        'is_active',
        'diasease'
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
        $this->db->table('products')->insert([
            'name' => $data['name'],
            'description' => $data['description'],
            'category' => $data['category'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'is_active' => $data['is_active'],
            'disease' => $data['disease'] // Pastikan field ini ada
        ]);
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
        return $this->db->table('products')
            ->select('product_id, name, category, price', disease)  // Gabungkan kolom dalam satu string
            ->where('is_active', 1)
            ->get()  // Menjalankan query
            ->getResultArray();  // Mengembalikan hasil sebagai array
    }
    // search product by name or category
    public function searchProduct($keyword)
    {
        return $this->like('name', $keyword)->orLike('category', $keyword)->get()->getResultArray();
    }

}