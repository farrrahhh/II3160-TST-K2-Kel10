<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
            $response = $this->client->get('MediMart/products/catalog');
            $products = json_decode($response->getBody()->getContents(), true);

            // Extract unique categories
            $categories = array_unique(array_column($products, 'category'));

            return view('patient/Telemed_ProductCatalog', [
                'products' => $products,
                'categories' => $categories,
                'title' => 'Telemed Product Catalog'
            ]);
        } catch (GuzzleException $e) {
            log_message('error', 'Error fetching catalog: ' . $e->getMessage());
            return view('errors/html/error_exception', ['message' => 'Failed to load product catalog. Please try again later.']);
        }
    }

    public function getProductsByCategory($category)
    {
        try {
            $response = $this->client->get('MediMart/products/catalog');
            $products = json_decode($response->getBody()->getContents(), true);

            $filteredProducts = array_filter($products, function($product) use ($category) {
                return $product['category'] === $category;
            });

            return $this->response->setJSON([
                'status' => 'success',
                'data' => array_values($filteredProducts)
            ]);
        } catch (GuzzleException $e) {
            log_message('error', 'Error fetching products by category: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to load products. Please try again later.'
            ])->setStatusCode(500);
        }
    }
}
