<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediMart - Your Online Pharmacy</title>
    <link rel="stylesheet" href="<?= base_url('css/style2.css') ?>">
    <!-- Tambahkan di bagian <head> -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Additional styles for the table section */
        .products-section {
            padding: 4rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .products-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-top: 2rem;
        }

        .products-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--secondary);
        }

        .products-title {
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

        .table th {
            background-color: var(--background);
            color: var(--text);
            font-weight: 600;
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 2px solid var(--secondary);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--secondary);
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .table tbody tr:hover {
            background-color: var(--background);
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            border: none;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        /* Modal improvements */
        .modal-content {
            max-width: 600px;
            border-radius: 12px;
        }

        .modal-header {
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--secondary);
        }

        .modal-body {
            margin-bottom: 1.5rem;
        }

        .modal-body p {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
            align-items: center;
        }

        .modal-body strong {
            color: var(--text);
        }

        .modal-footer {
            padding-top: 1rem;
            border-top: 1px solid var(--secondary);
        }
    </style>
</head>
<!-- Tambahkan di bagian bawah sebelum tag </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<body>
    <?php include 'navbar.php'; ?>

    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1 class="hero-title">Your Health, Our Priority</h1>
                <p class="hero-subtitle">Get your medicines and health supplies delivered right to your doorstep.</p>
                <a href="#" class="hero-button">Shop Now</a>
            </div>
        </div>
    </section>

    <section class="categories">
        <div class="categories-container">
            <h2 class="section-title">Shop By Category</h2>
            <div class="categories-grid">
                <div class="category-card">
                    <div class="category-image" style="background-image: url('<?php echo base_url('/images/medicine.png'); ?>')"></div>

                    <div class="category-content">
                        <h3 class="category-title">Medicines</h3>
                        <p class="category-description">Prescription and over-the-counter medicines</p>
                    </div>
                </div>
                
                <div class="category-card">
                <div class="category-image" style="background-image: url('<?php echo base_url('/images/vitamin.png'); ?>')"></div>
                    <div class="category-content">
                        <h3 class="category-title">Vitamins</h3>
                        <p class="category-description">Stay healthy with our range of vitamins</p>
                    </div>
                </div>
                
                <div class="category-card">
                <div class="category-image" style="background-image: url('<?php echo base_url('/images/supplement.png'); ?>')"></div>
                    <div class="category-content">
                        <h3 class="category-title">Supplements</h3>
                        <p class="category-description">Supplements boost health by providing essential nutrients your body needs.</p>
                    </div>
                </div>
                
                <div class="category-card">
                <div class="category-image" style="background-image: url('<?php echo base_url('/images/ointment.png'); ?>')"></div>
                    <div class="category-content">
                        <h3 class="category-title">Ointments</h3>
                        <p class="category-description">Ointments provide targeted relief and protection for the skin.</p>
                    </div>
                </div>
            </div>
        </div>

        <section class="products-section">
        <div class="products-card">
        <div class="products-header">
            <h3 class="products-title" style="display: inline-block; margin-right: 20px;">Available Products</h3>
            <button class="btn btn-primary" onclick="openOrderModal()">Shop Now</button>
        </div>
        <!-- Modal Order -->
<!-- Modal Order -->
<div id="order-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Place Your Order</h2>
            <button class="close-btn" onclick="closeOrderModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="order-form">
                <div class="form-group">
                    <label for="product-selection">Choose Products:</label>
                    <select id="product-selection" name="products[]" multiple="multiple" style="width: 100%;">
                        <!-- Produk akan dimuat di sini secara dinamis -->
                    </select>
                </div>
                <div id="product-quantities"></div>  <!-- Tempat untuk input quantity produk -->
                
                <p><strong>Address:</strong> 
                    <textarea id="address" name="address" required></textarea>
                </p>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Place Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="catalog-list">
                        <!-- Data will be loaded here via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal with improved styling -->
    <div id="detail-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Product Details</h2>
                <button class="close-btn" onclick="closeDetailModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="detail-name"></span></p>
                <p><strong>Category:</strong> <span id="detail-category"></span></p>
                <p><strong>Price:</strong> <span id="detail-price"></span></p>
                <p><strong>Stock:</strong> <span id="detail-stock"></span></p>
                <p><strong>Description:</strong> <span id="detail-description"></span></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeDetailModal()">Close</button>
            </div>
        </div>
    </div>

        
    </section>




    <script>
        const userId = <?= json_encode($userId) ?>;
        sessionStorage.setItem('user_id', userId);

        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown-menu');
            dropdown.classList.toggle('hidden');
        }

        window.addEventListener('click', function (event) {
            const dropdown = document.getElementById('dropdown-menu');
            if (!event.target.closest('.profile-container')) {
                dropdown.classList.add('hidden');
            }
        });
        function fetchCatalog() {
            fetch('/MediMart/products/catalog')
                .then(response => response.json())
                .then(data => {
                    const catalogList = document.getElementById('catalog-list');
                    catalogList.innerHTML = '';

                    const formatter = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    });

                    data.forEach(product => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${product.name}</td>
                            <td>${product.category}</td>
                            <td>${formatter.format(product.price)}</td>
                            <td>
                                <button class="btn btn-primary" onclick="showDetail(${product.product_id})">See Details</button>
                            </td>
                        `;
                        catalogList.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching catalog:', error));
        }

        // Fungsi untuk menampilkan detail produk
        function showDetail(productId) {
            fetch(`/MediMart/products/${productId}`)
                .then(response => response.json())
                .then(product => {
                    document.getElementById('detail-name').textContent = product.name;
                    document.getElementById('detail-category').textContent = product.category;
                    document.getElementById('detail-price').textContent = product.price;
                    document.getElementById('detail-stock').textContent = product.stock;
                    document.getElementById('detail-description').textContent = product.description;

                    const modal = document.getElementById('detail-modal');
                    modal.style.display = 'flex';
                })
                .catch(error => console.error('Error fetching product details:', error));
        }

        // Fungsi untuk menutup modal detail
        function closeDetailModal() {
            const modal = document.getElementById('detail-modal');
            modal.style.display = 'none';
        }

        // Panggil fetchCatalog saat halaman dimuat
        fetchCatalog();

        let productsData = [];

        function openOrderModal() {
            const modal = document.getElementById('order-modal');
            if (modal) {
                modal.style.display = 'flex';

                // Mengambil produk untuk form pemesanan
                fetch('/MediMart/products/catalog')
                    .then(response => response.json())
                    .then(data => {
                        productsData = data;
                        const productSelect = document.getElementById('product-selection');
                        if (productSelect) {
                            productSelect.innerHTML = '';  // Clear existing options

                            data.forEach(product => {
                                const option = document.createElement('option');
                                option.value = product.product_id;
                                option.textContent = `${product.name} - ${product.category} - ${formatCurrency(product.price)}`;
                                productSelect.appendChild(option);
                            });

                            // Inisialisasi Select2 untuk pencarian
                            $(productSelect).select2({
                                placeholder: "Select products",
                                allowClear: true
                            });

                            // Tambahkan input quantity untuk produk yang dipilih
                            productSelect.addEventListener('change', updateQuantityInputs);
                        }
                    })
                    .catch(error => console.error('Error fetching products:', error));
            }
        }

        function updateQuantityInputs() {
            const selectedProductIds = Array.from(document.getElementById('product-selection').selectedOptions).map(option => option.value);
            const quantityContainer = document.getElementById('product-quantities');
            if (quantityContainer) {
                quantityContainer.innerHTML = '';  // Clear previous quantity inputs

                selectedProductIds.forEach(productId => {
                    const product = productsData.find(p => p.product_id == productId);
                    if (product) {
                        const quantityDiv = document.createElement('div');
                        quantityDiv.classList.add('quantity-item'); // Optional: add class for styling
                        quantityDiv.innerHTML = `
                            <label for="quantity-${product.product_id}">Quantity for ${product.name}:</label>
                            <input type="number" id="quantity-${product.product_id}" name="quantity-${product.product_id}" min="1" required>
                        `;
                        quantityContainer.appendChild(quantityDiv);
                    }
                });
            }
        }

        function closeOrderModal() {
            const modal = document.getElementById('order-modal');
            if (modal) {
                modal.style.display = 'none';
            }
        }
        // Format harga menjadi IDR
        function formatCurrency(value) {
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            });
            return formatter.format(value);
        }
        document.getElementById('order-form')?.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission

            const orderItems = [];
            let validOrder = true;

            // Get selected product IDs
            const selectedProductIds = Array.from(document.getElementById('product-selection').selectedOptions).map(option => option.value);

            if (selectedProductIds.length === 0) {
                alert('Please select at least one product.');
                return;
            }

            selectedProductIds.forEach(productId => {
                const quantityInput = document.getElementById('quantity-' + productId);
                const quantity = quantityInput ? quantityInput.value : 0;

                if (quantity > 0) {
                    orderItems.push({
                        product_id: productId,
                        quantity: quantity
                    });
                }
            });

            if (orderItems.length === 0) {
                alert('Please enter valid quantities.');
                return;
            }

            const address = document.getElementById('address').value;
            if (!address) {
                alert("Please provide a shipping address.");
                return;
            }

            // ambil dari session
            const userId = sessionStorage.getItem('user_id');

            if (!userId) {
                alert("User ID is required.");
                return;
            }

            const orderData = {
                user_id: userId,
                shipping_address: address,
                order_details: orderItems
            };

            fetch('/MediMart/orders', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Order created successfully') {
                    alert('Order placed successfully!');
                    // Optionally close modal or reset form
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while processing your order.');
            });
        });

        // Menambahkan input quantity di bawah pilihan produk
        function updateProductQuantities() {
            const productSelection = document.getElementById('product-selection');
            const productQuantitiesDiv = document.getElementById('product-quantities');

            productQuantitiesDiv.innerHTML = '';  // Bersihkan konten sebelumnya

            // Ambil semua produk yang dipilih
            const selectedProducts = Array.from(productSelection.selectedOptions);

            selectedProducts.forEach(product => {
                const productId = product.value;
                const productName = product.text;

                // Buat input quantity untuk produk ini
                const quantityInput = document.createElement('div');
                quantityInput.classList.add('form-group');
                quantityInput.innerHTML = `
                    <label for="quantity-${productId}">${productName} Quantity:</label>
                    <input type="number" id="quantity-${productId}" name="quantities[${productId}]" min="1" value="1" required />
                `;
                productQuantitiesDiv.appendChild(quantityInput);
            });
        }

        // Inisialisasi Select2 dan event listener untuk update quantity
        $(document).ready(function() {
            $('#product-selection').select2({
                placeholder: 'Select products',
                allowClear: true
            });

            // Perbarui input quantity ketika produk dipilih
            $('#product-selection').on('change', function() {
                updateProductQuantities();
            });
        });
    </script>
    



</body>
</html>