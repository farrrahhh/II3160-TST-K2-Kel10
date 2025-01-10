<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .filter-section {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .no-products {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= esc($title) ?></h1>
        
        <div class="filter-section">
            <label for="category-filter">Filter by Category:</label>
            <select id="category-filter">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= esc($category) ?>"><?= esc($category) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="product-table">
            <?php if (!empty($products)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= esc($product['product_id']) ?></td>
                                <td><?= esc($product['name']) ?></td>
                                <td><?= esc($product['category']) ?></td>
                                <td><?= esc(number_format($product['price'], 0, ',', '.')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-products">No products available.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.getElementById('category-filter').addEventListener('change', function() {
            const category = this.value;
            fetch(`/Telemed_Medicine/getProductsByCategory/${category}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        updateProductTable(data.data);
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        function updateProductTable(products) {
            const tableBody = document.querySelector('#product-table table tbody');
            tableBody.innerHTML = '';

            if (products.length === 0) {
                document.getElementById('product-table').innerHTML = '<p class="no-products">No products available for this category.</p>';
                return;
            }

            products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${escapeHtml(product.product_id)}</td>
                    <td>${escapeHtml(product.name)}</td>
                    <td>${escapeHtml(product.category)}</td>
                    <td>${formatPrice(product.price)}</td>
                `;
                tableBody.appendChild(row);
            });
        }

        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function formatPrice(price) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(price);
        }
    </script>
</body>
</html>

