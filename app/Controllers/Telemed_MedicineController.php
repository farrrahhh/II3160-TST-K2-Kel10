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
            'base_uri' => 'http://localhost:8080/',
            'timeout'  => 10,
        ]);
    }

    public function catalog()
    {
        try {
            // Memanggil API untuk mendapatkan data produk
            $response = $this->client->get('MediMart/products/catalog');
            $products = json_decode($response->getBody()->getContents(), true);

            // Kirim data ke view
            return view('patient/Telemed_ProductCatalog', ['products' => $products]);
        } catch (\Exception $e) {
            // Menangani error
            log_message('error', 'Error fetching catalog: ' . $e->getMessage());
            return view('errors/html/error_exception', ['message' => 'Gagal memuat katalog produk.']);
        }
    }
}