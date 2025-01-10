<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;

class Telemed_MedicineController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://farahproject.my.id/',
            'timeout'  => 10,
        ]);
    }

    public function catalog()
    {
        try {
            // Memanggil API untuk mendapatkan data produk
            $response = $this->client->get('MediMart/products/catalog');
            $products = json_decode($response->getBody()->getContents(), true);

            // Kirim data ke view, termasuk variabel title
            return view('Telemed_ProductCatalog', [
                'products' => $products,
                'title' => 'Telemed Product Catalog'
            ]);
        } catch (\Exception $e) {
            // Menangani error
            log_message('error', 'Error fetching catalog: ' . $e->getMessage());
            return view('errors/html/error_exception', ['message' => 'Gagal memuat katalog produk.']);
        }
    }
    // Method untuk mengupdate dropdown produk berdasarkan kategori
    public function getProductsByCategory($category)
    {
        try {
            // Memanggil API untuk mendapatkan data produk
            $response = $this->client->get('MediMart/products/catalog');
            $products = json_decode($response->getBody()->getContents(), true);

            // Filter produk berdasarkan kategori yang dipilih
            $filteredProducts = array_filter($products, function($product) use ($category) {
                return $product['category'] === $category;
            });

            // Kirim data produk yang difilter
            return $this->response->setJSON([
                'status' => 'success',
                'data' => array_values($filteredProducts)
            ]);
        } catch (\Exception $e) {
            // Menangani error dan mengirim pesan error sebagai JSON response
            log_message('error', 'Error fetching products by category: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal memuat produk. ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}

