<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Management - MediMart</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <span class="logo-icon">
                <img class="logo-icon" src="<?= base_url('images/icon.png') ?>" alt="My Icon">
            </span>
            <h1 class="sidebar-title">MediMart</h1>
        </div>
        <nav class="nav-links">
            <a href="/MediMart/admin/manage" class="nav-link">Products</a>
            <a href="/MediMart/admin/payments" class="nav-link">Payments</a>
            <a href="/MediMart/admin/shipping" class="nav-link active">Shipping</a>
            <hr style="border: 1px solid #E8EAF6; width: 100%; margin-top: 1rem; margin-bottom: 1rem;">
            <a href="/MediMart/logout" class="nav-link">Logout</a>
        </nav>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="page-header">
            <h1 class="page-title">Shipping Management</h1>
        </div>
        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Status</th>
                        <th>Shipping Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="order-list">
                    <!-- Data akan dimasukkan di sini -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="shipping-modal" class="modal">
        <div class="modal-content">
            <h2>Edit Shipping Status</h2>
            <form id="shipping-form" onsubmit="submitShippingForm(event)">
                <div class="form-group">
                    <label for="order-status" class="form-label">Status</label>
                    <select id="order-status" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="shipped">Shipped</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-warning" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentOrderId = null;

        // Fetch orders data
        function fetchOrders() {
            fetch('/MediMart/orders')
                .then(response => response.json())
                .then(data => {
                    const orderList = document.getElementById('order-list');
                    orderList.innerHTML = '';
                    data.forEach(order => {
                        orderList.innerHTML += `
                            <tr>
                                <td>${order.order_id}</td>
                                <td>${order.user_id}</td>
                                <td>${order.status}</td>
                                <td>${order.shipping_address}</td>
                                <td class="action-buttons">
                                    <button class="btn btn-warning" onclick="editOrder(${order.order_id}, '${order.status}')">Edit</button>
                                </td>
                            </tr>
                        `;
                    });
                })
                .catch(error => console.error('Error fetching orders:', error));
        }

        // Show modal for editing order status
        function editOrder(id, status) {
            currentOrderId = id;
            document.getElementById('order-status').value = status;
            document.getElementById('shipping-modal').style.display = 'flex';
        }

        // Close modal
        function closeModal() {
            document.getElementById('shipping-modal').style.display = 'none';
        }

        // Submit form to update order status
        function submitShippingForm(event) {
            event.preventDefault();
            const status = document.getElementById('order-status').value;

            fetch(`/MediMart/orders/${currentOrderId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status })
            })
            .then(response => response.json())
            .then(result => {
                alert(result.message);
                closeModal();
                fetchOrders();
            })
            .catch(error => console.error('Error updating order:', error));
        }

        // Load orders on page load
        fetchOrders();
    </script>
</body>
</html>