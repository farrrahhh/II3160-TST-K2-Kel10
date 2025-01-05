<?php
namespace App\Controllers;
use App\Models\PaymentModel;
use App\Models\OrderModel;



class PaymentController extends BaseController{
    protected $paymentModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
    }

    public function index()
    {
        $payments = $this->paymentModel->findAll();
        // turn back json
        return $this->response->setJSON($payments);
    }

    public function create()
    {
        // Ambil data JSON dari request
        $requestData = $this->request->getJSON(true);
        $orderId = $requestData['order_id'] ?? null;
    
        // Validasi input 
        if (!$orderId) {
            return $this->response->setJSON(['message' => 'Invalid input. Please provide order_id.']);
        }
    
        // Ambil data order berdasarkan orderId
        $orderModel = new OrderModel();
        $order = $orderModel->find($orderId);
        if (!$order) {
            return $this->response->setJSON(['message' => 'Order not found.']);
        }
    
        // Ambil total_price dari order
        $amount = $order['total_price'];
    
        // Data pembayaran
        $data = [
            'order_id' => $orderId,
            'status' => 'processing',
            'amount' => $amount,
        ];
    
        // Simpan data pembayaran
        $this->paymentModel->insertPayment($data);
    
        return $this->response->setJSON(['message' => 'Payment created successfully']);
    }

    // update status payment by id
    public function update()
    {
        // Ambil data JSON dari request
        $requestData = $this->request->getJSON(true);
        $paymentId = $requestData['payment_id'] ?? null;
        $status = $requestData['status'] ?? null;
    
        // Validasi input
        if (!$paymentId || !$status) {
            return $this->response->setJSON(['message' => 'Invalid input. Please provide payment_id and status.']);
        }
        // validasi isi
        if (!in_array($status, ['success', 'failed'])) {
            return $this->response->setJSON(['message' => 'Invalid status.']);
        }
    
        // Ambil data pembayaran berdasarkan paymentId
        $payment = $this->paymentModel->find($paymentId);
        if (!$payment) {
            return $this->response->setJSON(['message' => 'Payment not found.']);
        }
    
        // Update status pembayaran
        $this->paymentModel->updatePaymentStatus($status, $paymentId);
        // kalau status == success, maka update status order menjadi paid
        if ($status == 'success') {
            $orderModel = new OrderModel();
            $orderModel->updateOrderStatus('paid', $payment['order_id']);
        }
        // kalau gagal update jadi cancelled
        if ($status == 'failed') {
            $orderModel = new OrderModel();
            $orderModel->updateOrderStatus('cancelled', $payment['order_id']);
        }
    
        return $this->response->setJSON(['message' => 'Payment status updated successfully']);
    }

    // customer can see their payment history by user id
    public function history($orderId)
    {
        $payments = $this->paymentModel->getWhere(['order_id' => $orderId])->getResultArray();
        return $this->response->setJSON($payments);
    }

    // check payment by status
    public function check($status)
    {
        // validate status
        if (!in_array($status, ['processing', 'success', 'failed'])) {
            return $this->response->setJSON(['message' => 'Invalid status.']);
        }
        $payments = $this->paymentModel->getWhere(['status' => $status])->getResultArray();
        return $this->response->setJSON($payments);
    }


    

}