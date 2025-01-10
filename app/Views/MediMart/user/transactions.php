<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediMart - Your Online Pharmacy</title>
    <link rel="stylesheet" href="<?= base_url('css/style2.css') ?>">
    <style>
        :root {
            --primary: #4066E0;
            --primary-dark: #3351B9;
            --secondary: #E8EAF6;
            --text: #2C3E50;
            --text-light: #6B7C93;
            --background: #F8FAFC;
            --border: #E2E8F0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--background);
            color: var(--text);
        }

        .orders-section {
            padding: 2rem;
            max-width: 1200px;
            margin: 2rem auto;
            margin-top: 4rem;
        }

        .orders-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .orders-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border);
        }

        .orders-title {
            font-size: 1.5rem;
            color: var(--text);
            margin: 0;
        }

        .table-container {
            padding: 1.5rem;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th, .table td {
            padding: 1rem;
            text-align: left;
        }

        .table th {
            background-color: var(--secondary);
            font-weight: 600;
            color: var(--text);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .table td {
            border-bottom: 1px solid var(--border);
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s;
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .close-button {
            color: var(--text-light);
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-button:hover {
            color: var(--text);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        #orderDetailContent {
            margin-top: 1.5rem;
        }

        #orderDetailContent p {
            margin-bottom: 0.5rem;
        }

        #orderDetailContent ul {
            list-style-type: none;
            padding: 0;
        }

        #orderDetailContent li {
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--border);
        }

        #orderDetailContent li:last-child {
            border-bottom: none;
        }
        .modal, .modal-content, .close-button, @keyframes fadeIn, #orderDetailContent {
            display: none;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
    
    <section class="orders-section">
        <div class="orders-card">
            <div class="orders-header">
                <h3 class="orders-title">Order History</h3>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Shipping Address</th>
                        </tr>
                    </thead>
                    <tbody id="orders-list">
                        <!-- Data will be loaded here via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script>
        function formatCurrency(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
            }).format(value);
        }

        const userId = <?= json_encode($userId) ?>;
        sessionStorage.setItem('user_id', userId);

        function fetchOrders() {
            const userId = sessionStorage.getItem('user_id');
            if (!userId) {
                alert('User ID is not available.');
                return;
            }

            fetch(`/MediMart/orders/user/${userId}`)
                .then(response => response.json())
                .then(data => {
                    const ordersList = document.getElementById('orders-list');
                    ordersList.innerHTML = '';

                    data.forEach(order => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${order.order_id}</td>
                            <td>${formatCurrency(order.total_price)}</td>
                            <td>${order.status}</td>
                            <td>${order.shipping_address}</td>
                        `;
                        ordersList.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching orders:', error));
        }

        // Call this function when the page loads
        fetchOrders();
    </script>
</body>
</html>

