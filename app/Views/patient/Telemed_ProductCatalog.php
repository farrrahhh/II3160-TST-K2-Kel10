<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title> <!-- Gunakan $title -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1><?= esc($title) ?></h1> <!-- Gunakan $title -->
    
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
        <p>No products available.</p>
    <?php endif; ?>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        // Script untuk memperbarui dropdown produk berdasarkan kategori
        function updateProductDropdown() {
            const category = document.getElementById('category').value;
            const productDropdown = document.getElementById('product');
            const products = <?= json_encode($products) ?>;

            // Kosongkan dropdown produk
            productDropdown.innerHTML = '<option value="">-- Select Product --</option>';

            // Tambahkan produk berdasarkan kategori yang dipilih
            products.forEach(product => {
                if (product.category === category) {
                    const option = document.createElement('option');
                    option.value = product.product_id;
                    option.textContent = product.name;
                    productDropdown.appendChild(option);
                }
            });
        }
    </script>
</head>
<body>
    <h1><?= esc($title) ?></h1>
    
    <!-- Form untuk pembelian produk -->
    <form method="POST" action="/MediMart/orders">
        <label for="category">Category:</label>
        <select id="category" name="category" onchange="updateProductDropdown()" required>
            <option value="">-- Select Category --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= esc($category) ?>"><?= esc(ucfirst($category)) ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="product">Product:</label>
        <select id="product" name="product" required>
            <option value="">-- Select Product --</option>
            <!-- Dropdown ini akan diperbarui secara dinamis -->
        </select>
        <br><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1" max="100" required>
        <br><br>

        <button type="submit">Purchase</button>
    </form>
    
