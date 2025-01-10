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
        select {
            padding: 8px;
            margin: 10px 0;
            width: 200px;
        }
    </style>
    <script>
        function filterByCategory() {
            const category = document.getElementById('categoryDropdown').value;
            const rows = document.querySelectorAll('#productTable tbody tr');
            rows.forEach(row => {
                const cell = row.querySelector('td:nth-child(3)');
                if (category === 'all' || cell.textContent.trim() === category) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</head>
<body>
    <h1><?= esc($title) ?></h1> <!-- Gunakan $title -->

    <label for="categoryDropdown">Filter by Category:</label>
    <select id="categoryDropdown" onchange="filterByCategory()">
        <option value="all">All Categories</option>
        <?php 
        $categories = array_unique(array_column($products, 'category')); 
        foreach ($categories as $category): ?>
            <option value="<?= esc($category) ?>"><?= esc(ucfirst($category)) ?></option>
        <?php endforeach; ?>
    </select>

    <?php if (!empty($products)): ?>
        <table id="productTable">
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