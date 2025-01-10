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