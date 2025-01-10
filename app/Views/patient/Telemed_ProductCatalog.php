<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <script>
        // Script untuk memperbarui dropdown produk berdasarkan kategori
        async function updateProductDropdown() {
            const category = document.getElementById('category').value;
            const productDropdown = document.getElementById('product');
            
            // Ambil produk berdasarkan kategori
            const response = await fetch(`/patient/getProductsByCategory/${category}`);
            const products = await response.json();

            // Kosongkan dropdown produk
            productDropdown.innerHTML = '<option value="">-- Select Product --</option>';

            // Tambahkan produk berdasarkan kategori yang dipilih
            products.forEach(product => {
                const option = document.createElement('option');
                option.value = product.product_id;
                option.textContent = product.name;
                productDropdown.appendChild(option);
            });
        }
    </script>
</head>
<body>
    <h1><?= esc($title) ?></h1>

    <form method="POST" action="/MediMart/orders">
        <!-- Dropdown kategori -->
        <label for="category">Category:</label>
        <select id="category" name="category" onchange="updateProductDropdown()" required>
            <option value="">-- Select Category --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= esc($category) ?>"><?= esc(ucfirst($category)) ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <!-- Dropdown produk -->
        <label for="product">Product:</label>
        <select id="product" name="product" required>
            <option value="">-- Select Product --</option>
        </select>
        <br><br>

        <!-- Input quantity -->
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1" max="100" required>
        <br><br>

        <button type="submit">Order</button>
    </form>
</body>
</html>