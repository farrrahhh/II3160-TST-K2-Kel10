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

    fetch('/MediMart/orders/create', {
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