<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments Management - MediMart</title>
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
            <a href="/MediMart/admin/payments" class="nav-link active">Payments</a>
            <a href="/MediMart/admin/shipping" class="nav-link">Shipping</a>
            <!-- make a soft line -->
            <hr style="border: 1px solid #E8EAF6; width: 100%; margin-top: 1rem; margin-bottom: 1rem;">
            
            <a href="/MediMart/logout" class="nav-link">Logout</a>
            
        </nav>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="page-header">
            <h1 class="page-title">Payments Management</h1>
        </div>
        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order ID</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="payment-list">
                    <!-- Data akan dimasukkan di sini -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="payment-modal" class="modal">
        <div class="modal-content">
            <h2>Edit Payment Status</h2>
            <form id="payment-form" onsubmit="submitPaymentForm(event)">
                <div class="form-group">
                    <label for="payment-status" class="form-label">Status</label>
                    <select id="payment-status" class="form-control" required>
                        <option value="processing">Processing</option>
                        <option value="success">Succees</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-warning" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentPaymentId = null;

        // Fetch payments data
        function fetchPayments() {
            fetch('/MediMart/payments')
                .then(response => response.json())
                .then(data => {
                    const paymentList = document.getElementById('payment-list');
                    paymentList.innerHTML = '';
                    data.forEach(payment => {
                        paymentList.innerHTML += `
                            <tr>
                                <td>${payment.payment_id}</td>
                                <td>${payment.order_id}</td>
                                <td>${payment.status}</td>
                                <td>Rp ${payment.amount.toLocaleString()}</td>
                                <td class="action-buttons">
                                    <button class="btn btn-warning" onclick="editPayment(${payment.payment_id}, '${payment.status}')">Edit</button>
                                </td>
                            </tr>
                        `;
                    });
                })
                .catch(error => console.error('Error fetching payments:', error));
        }

        // Show modal for editing payment status
        function editPayment(id, status) {
            currentPaymentId = id;
            document.getElementById('payment-status').value = status;
            document.getElementById('payment-modal').style.display = 'flex';
        }

        // Close modal
        function closeModal() {
            document.getElementById('payment-modal').style.display = 'none';
        }

        // Submit form to update payment status
        function submitPaymentForm(event) {
            event.preventDefault();
            const status = document.getElementById('payment-status').value;

            fetch(`/MediMart/payments`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ payment_id: currentPaymentId, status })
            })
            .then(response => response.json())
            .then(result => {
                alert(result.message);
                closeModal();
                fetchPayments();
            })
            .catch(error => console.error('Error updating payment:', error));
        }

        // Load payments on page load
        fetchPayments();
    </script>
</body>
</html>