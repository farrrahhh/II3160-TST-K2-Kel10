
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediMart - Your Online Pharmacy</title>
    <link rel="stylesheet" href="<?= base_url('css/style2.css') ?>">
   
    <style>
    /* Modal Styles */
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
    }

    .modal-content {
        background-color: white;
        margin: 10% auto;
        padding: 20px;
        border-radius: 8px;
        width: 60%;
        max-width: 600px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        animation: fadeIn 0.3s;
    }

    .close-button {
        color: black;
        float: right;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-button:hover {
        color: red;
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="orders-list">
                        <!-- Data akan dimuat di sini via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <div id="orderDetailModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal()">&times;</span>
            <h3>Order Details</h3>
            <div id="orderDetailContent">
                <!-- Konten detail pesanan akan dimuat di sini -->
            </div>
        </div>
    </div>

<script>
    function formatCurrency(value) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'IRD',
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
                        <td>
                            <button class="btn btn-primary" onclick="showOrderDetail(${order.order_id})">View Details</button>
                        </td>
                    `;
                    ordersList.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching orders:', error));
    }

    // Panggil fungsi ini saat halaman dimuat
    fetchOrders();
    function showOrderDetail(orderId) {
    // Fetch detail pesanan
    fetch(`/MediMart/orders/${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const detailContent = document.getElementById('orderDetailContent');
                const order = data.data;

                // Tampilkan detail pesanan
                let detailsHTML = `
                    <p><strong>Order ID:</strong> ${order.order_id}</p>
                    <p><strong>Total Price:</strong> ${formatCurrency(order.total_price)}</p>
                    <p><strong>Status:</strong> ${order.status}</p>
                    <p><strong>Shipping Address:</strong> ${order.shipping_address}</p>
                    <h4>Items:</h4>
                    <ul>
                `;

                // Validasi apakah order_details adalah array
                if (Array.isArray(order.order_details)) {
                    order.order_details.forEach(item => {
                        detailsHTML += `
                            <li>
                                ${item.product_name} - ${item.quantity} x ${formatCurrency(item.product_price)}
                            </li>
                        `;
                    });
                } else {
                    detailsHTML += `<p>No items found for this order.</p>`;
                }

                detailsHTML += '</ul>';
                detailContent.innerHTML = detailsHTML;

                // Buka modal
                const modal = document.getElementById('orderDetailModal');
                modal.style.display = 'block';
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error fetching order detail:', error));
}

    function closeModal() {
        const modal = document.getElementById('orderDetailModal');
        modal.style.display = 'none';
    }

    // Tutup modal jika pengguna klik di luar modal
    window.onclick = function(event) {
        const modal = document.getElementById('orderDetailModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
</script>
    

      



</body>
</html>