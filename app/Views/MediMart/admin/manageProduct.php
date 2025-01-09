<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MediMart</title>
    <!-- ambil style dari public css -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">


</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <span class="logo-icon">
                <img class="logo-icon" src="<?= base_url('images/icon.png') ?>" alt="My Icon">
            </span>
            <h1 class="sidebar-title">MediMart</h1>
        </div>
        <nav class="nav-links">
            <a href="/MediMart/admin/manage" class="nav-link active">Products</a>
            <a href="/MediMart/admin/payments" class="nav-link">Payments</a>
            <a href="/MediMart/admin/shipping" class="nav-link">Shipping</a>
            <!-- make a soft line -->
            <hr style="border: 1px solid #E8EAF6; width: 100%; margin-top: 1rem; margin-bottom: 1rem;">
            
            <a href="/MediMart/logout" class="nav-link">Logout</a>
            
        </nav>
    </div>

    <div class="content">
        <div class="page-header">
            <h1 class="page-title">Product Management</h1>
            <button class="btn btn-primary" onclick="showAddProductForm()">
                <span>+</span> Add Product
            </button>
        </div>

        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Disease</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <!-- Data will be inserted here -->
                </tbody>
            </table>
        </div>
    </div>

    <div id="product-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="form-title">Add Product</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <form id="product-form" onsubmit="submitProductForm(event)">
                <!-- Input untuk product_id -->
                <input type="hidden" id="product-id" name="product_id">

                <div class="form-group">
                    <label class="form-label" for="product-name">Name</label>
                    <input type="text" id="product-name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <input type="text" id="product-description" name="description" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="category">Category</label>
                    <select id="category" name="category" class="form-control" required>
                        <option value="vitamin">Vitamin</option>
                        <option value="supplement">Supplement</option>
                        <option value="medicine">Medicine</option>
                        <option value="ointment">Ointment</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="product-price">Price</label>
                    <input type="number" id="product-price" name="price" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="product-stock">Stock</label>
                    <input type="number" id="product-stock" name="stock" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="disease">Disease</label>
                    <select id="disease" name="disease" class="form-control">
                        <option value="" selected>Select Disease</option>
                        <option value="Diabetes">Diabetes</option>
                        <option value="Hypertension">Hypertension</option>
                        <option value="Asthma">Asthma</option>
                        <option value="Heart Disease">Heart Disease</option>
                        <option value="Influenza">Influenza</option>
                        <option value="Diarrhea">Diarrhea</option>
                        <option value="Constipation">Constipation</option>
                        <option value="Migraine">Migraine</option>
                        <option value="Maag">Maag</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-danger" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Keep the existing JavaScript functions but update the product list template


        // Fungsi untuk menampilkan modal
        function showModal(title, product = null) {
            const modal = document.getElementById('product-modal');
            const formTitle = document.getElementById('form-title');
            const form = document.getElementById('product-form');

            form.reset(); // Reset form sebelum digunakan
            formTitle.innerText = title;

            if (product) {
                document.getElementById('product-id').value = product.product_id; // Set product_id
                document.getElementById('product-name').value = product.name;
                document.getElementById('product-description').value = product.description;
                document.getElementById('category').value = product.category;
                document.getElementById('product-price').value = product.price;
                document.getElementById('product-stock').value = product.stock;
                document.getElementById('disease').value = product.disease;
            }

            modal.style.display = 'flex'; // Tampilkan modal
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            const modal = document.getElementById('product-modal');
            modal.style.display = 'none';
        }

        // Fungsi untuk menampilkan form tambah produk
        function showAddProductForm() {
            showModal('Add Product');
        }

        // Fungsi untuk menampilkan form edit produk
        function editProduct(productId) {
            // Ambil data produk berdasarkan ID (simulasi fetch data)
            fetch(`/MediMart/products/${productId}`)
                .then(response => response.json())
                .then(product => {
                    showModal('Edit Product', product);
                })
                .catch(error => console.error('Error:', error));
        }

        // Fungsi untuk submit form tambah/edit produk
        function submitProductForm(event) {
    event.preventDefault();

    const form = document.getElementById('product-form');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    data.is_active = 1; // Tambahkan atribut lain yang diperlukan
    
    // Log data untuk melihat apakah 'disease' sudah dikirim
    console.log('Form Data:', data);

    // Tentukan metode dan URL berdasarkan keberadaan product_id
    const productId = data.product_id;
    const method = productId ? 'PUT' : 'POST';
    const url = productId ? `/MediMart/products/${productId}` : '/MediMart/products';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.message === 'Product created successfully' || result.message === 'Product updated successfully') {
            alert(result.message);
            fetchProducts();
            closeModal();
        } else {
            alert(result.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

        // Fungsi untuk menampilkan daftar produk
        function fetchProducts() {
            fetch('/MediMart/products')
                .then(response => response.json())
                .then(data => {
                    const productList = document.getElementById('product-list');
                    productList.innerHTML = '';
                    data.forEach(product => {
                        productList.innerHTML += `
                            <tr>
                                <td>${product.product_id}</td>
                                <td>${product.name}</td>
                                <td>${product.category}</td>
                                <td>${product.price}</td>
                                <td>${product.stock}</td>
                                <td>${product.disease}</td>
                                <td class="action-buttons">
                                    <button class="btn btn-edit" onclick="editProduct(${product.product_id})">Edit</button>
                                    <button class="btn btn-delete" onclick="deleteProduct(${product.product_id})">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                });
        }


        


       
        // konfirmasi delete atau gak
        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch(`/MediMart/products/${id}`, { method: 'DELETE' })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        fetchProducts();
                    });
            }
        }
        // Fungsi untuk memuat data catalog


        // Panggil fetchProducts saat halaman dimuat
        fetchProducts();

        
    </script>
</body>
</html>