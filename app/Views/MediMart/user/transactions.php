
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediMart - Your Online Pharmacy</title>
    <link rel="stylesheet" href="<?= base_url('css/style2.css') ?>">
   
    
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
</script>
    

      



</body>
</html>