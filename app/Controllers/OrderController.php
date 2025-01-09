<?php
namespace App\Controllers;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Models\ProductModel;

class OrderController extends BaseController
{
    protected $orderModel;
    protected $orderDetailModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderDetailModel = new OrderDetailModel();
    }

    public function index()
    {
        $orders = $this->orderModel->getOrder();
        return $this->response->setJSON($orders);

    }
    // user can create new order
    // customer can choose product from catalog, determine quantity, and create order
    public function create()
    {
        // Ambil data JSON dari request
        $requestData = $this->request->getJSON(true);
        $orderDetails = $this->orderDetailModel->getOrderDetail($orderId) ?? [];
        $orderDetails = $requestData['order_details'] ?? null;
        $userId = $requestData['user_id'] ?? null;
        $shippingAddress = $requestData['shipping_address'] ?? null;
    
        // Validasi input utama
        if (!$userId || !$shippingAddress || !$orderDetails || !is_array($orderDetails)) {
            return $this->response->setJSON(['message' => 'Invalid input. Please provide user ID, shipping address, and order details.']);
        }
    
        $productModel = new ProductModel();
        $productsCache = []; // Cache untuk produk yang sudah diambil
        $totalPrice = 0;
    
        // Validasi stok dan data produk
        foreach ($orderDetails as $orderDetail) {
            $productId = $orderDetail['product_id'] ?? null;
            $quantity = $orderDetail['quantity'] ?? 0;
    
            if (!$productId || $quantity <= 0) {
                return $this->response->setJSON(['message' => 'Invalid order detail. Please provide product ID and quantity.']);
            }
    
            // Ambil data produk (gunakan cache jika tersedia)
            if (!isset($productsCache[$productId])) {
                $product = $productModel->getProduct($productId);
                if (!$product) {
                    return $this->response->setJSON(['message' => "Product with ID $productId not found."]);
                }
                $productsCache[$productId] = $product;
            } else {
                $product = $productsCache[$productId];
            }
    
            // Validasi stok
            if ($product['stock'] < $quantity) {
                return $this->response->setJSON(['message' => "Product $product[name] is out of stock."]);
            }
    
            // Validasi jika produk tidak aktif
            if ($product['is_active'] == 0) {
                return $this->response->setJSON(['message' => "Product $product[name] is not ready."]);
            }
    
            // Hitung harga total
            $totalPrice += $product['price'] * $quantity;
        }
    
        // Data utama pesanan
        $orderData = [
            'user_id' => $userId,
            'total_price' => 0, // Akan diperbarui nanti
            'status' => 'pending',
            'shipping_address' => $shippingAddress
        ];
    
        // Simpan data order ke tabel `orders`
        $this->orderModel->insert($orderData);
        $orderId = $this->orderModel->insertID();
    
        // Simpan detail pesanan dan perbarui stok
        foreach ($orderDetails as $orderDetail) {
            $productId = $orderDetail['product_id'];
            $quantity = $orderDetail['quantity'];
            $product = $productsCache[$productId];
    
            // Hitung harga produk
            $price = $product['price'] * $quantity;
    
            // Simpan ke tabel `order_details`
            $this->orderDetailModel->insert([
                'order_id' => $orderId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price
            ]);
    
            // Kurangi stok produk
            $productModel->update($productId, [
                'stock' => $product['stock'] - $quantity
            ]);
        }
    
        // Perbarui total harga pesanan di tabel `orders`
        $this->orderModel->update($orderId, ['total_price' => $totalPrice]);
    
        // Kirim respons sukses
        return $this->response->setJSON([
            'message' => 'Order created successfully',
            'order_id' => $orderId,
            'total_price' => $totalPrice
        ]);
    }

    // user can see their order
    public function showByUser($userId)
    {
        $orders = $this->orderModel->getOrderByUser($userId);
        return $this->response->setJSON($orders);
    }


    // user can see their detail order
    // customer can see the details of the order they made, like the name of product, quantity, and price, shipping address, and total price
    public function showDetail($orderId)
    {
        // Ambil data order berdasarkan orderId
        $order = $this->orderModel->getOrder($orderId);

        // Validasi apakah data order ditemukan dan dalam bentuk array
        if (!$order || !is_array($order)) {
            log_message('error', 'Invalid order data: ' . json_encode($order));
            return $this->response->setJSON([
                'message' => "Order with ID $orderId not found.",
                'status' => 'error'
            ])->setStatusCode(404);
        }

        // Ambil data order detail berdasarkan orderId
       
        $orderDetails = $this->orderDetailModel->getOrderDetail($orderId);
        // Validasi apakah order details ditemukan dan dalam bentuk array
        if (!is_array($orderDetails) || empty($orderDetails)) {
            log_message('error', 'Invalid order details data: ' . json_encode($orderDetails));
            return $this->response->setJSON([
                'message' => "Order details not found for order ID $orderId.",
                'status' => 'error'
            ])->setStatusCode(404);
        }

        // Ambil data produk untuk setiap detail pesanan
        $productModel = new ProductModel();
        foreach ($orderDetails as &$detail) {
            // Validasi apakah elemen $detail adalah array dan memiliki key 'product_id'
            if (!is_array($detail) || !isset($detail['product_id'])) {
                log_message('error', 'Invalid detail data: ' . json_encode($detail));
                continue; // Lewati elemen yang tidak valid
            }

            // Cari produk berdasarkan product_id
            $product = $productModel->find($detail['product_id']);
            if ($product) {
                $detail['product_name'] = $product['name'];
                $detail['product_price'] = $product['price'];
            } else {
                $detail['product_name'] = 'Unknown Product';
                $detail['product_price'] = 0;
            }
        }

        // Format respons
        $response = [
            'order_id' => $order['order_id'],
            'user_id' => $order['user_id'],
            'shipping_address' => $order['shipping_address'],
            'total_price' => $order['total_price'],
            'status' => $order['status'],
            'order_details' => $orderDetails // Ini harus selalu array
        ];

        // Kirim respons dalam format JSON
        return $this->response->setJSON([
            'message' => 'Order details retrieved successfully.',
            'status' => 'success',
            'data' => $response
        ])->setStatusCode(200);
    }

    // update status order by admin
    public function update($id)
    {
        $data = $this->request->getJSON(true);
        $status = $data['status'] ?? null;
        if (!$status) {
            return $this->response->setJSON(['message' => 'Status is required.']);
        }
        if (!in_array($status, ['pending', 'paid', 'shipped', 'completed', 'cancelled'])) {
            return $this->response->setJSON(['message' => 'Invalid status.']);
        }

        $order = $this->orderModel->find($id);
        if (!$order) {
            return $this->response->setJSON(['message' => "Order with ID $id not found."]);
        }

        $this->orderModel->updateOrderStatus($status, $id);

        return $this->response->setJSON([
            'message' => 'Order status updated successfully.',
            'order_id' => $id,
            'status' => $status
        ]);
    }

    // customer can track their order
    public function track($id)
    {
        $order = $this->orderModel->getOrder($id);
        if (!$order) {
            return $this->response->setJSON(['message' => "Order with ID $id not found."]);
        }

        return $this->response->setJSON([
            'message' => 'Order status retrieved successfully.',
            'order_id' => $id,
            'status' => $order['status']
        ]);
    }



    

    
}