<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends BaseController
{
    public function index()
    {
        $model = new ProductModel();
        $data = $model->getProduct();
        return $this->response->setJSON($data);
    }

    // show catalog product that is_active is true
    public function showCatalog()
    {
        $model = new ProductModel();
        $data = $model->getProductByIsActive();
        return $this->response->setJSON($data);
    }
    // show detail product by id
    public function show($id)
    {
        $model = new ProductModel();
        $data = $model->getProduct($id);
        return $this->response->setJSON($data);
    }
    // create new product
    public function create()
    {
        $model = new ProductModel();
        $data = $this->request->getJSON(true);

        // Cek apakah data ada dan semua field terisi
        if (
            !isset($data['name'], $data['description'], $data['category'], $data['price'], $data['stock'], $data['is_active'])
            || empty($data['name']) || empty($data['description']) || empty($data['category'])
            || empty($data['price']) || empty($data['stock'])
        ) {
            return $this->response->setJSON(['message' => 'Invalid input']);
        }

        // Validasi kategori
        if (!in_array($data['category'], ['vitamin', 'supplement', 'medicine', 'ointment', 'other'])) {
            return $this->response->setJSON(['message' => 'Invalid category']);
        }

        // Simpan produk ke database
        $model->insertProduct($data);

        return $this->response->setJSON(['message' => 'Product created successfully']);
    }
    // update product by id
    public function update($id)
    {
        $model = new ProductModel();
        $data = $this->request->getJSON(true);
        $model->updateProduct($data, $id);
        return $this->response->setJSON(['message' => 'Product updated successfully']);
    }
    // delete product by id
    public function delete($id)
    {
        $model = new ProductModel();
        $model->deleteProduct($id);
        return $this->response->setJSON(['message' => 'Product deleted successfully']);
    }
    // search product by name or category
    public function search()
    {
        $model = new ProductModel();
        $keyword = $this->request->getGet('keyword');
        $data = $model->searchProduct($keyword);
        return $this->response->setJSON($data);
    }


}

