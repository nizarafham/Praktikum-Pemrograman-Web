<!DOCTYPE html>
<html>
<head>
    <title>Seller Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <!-- Login Form -->
        <div class="card mb-4" id="loginCard">
            <div class="card-header">
                <h5 class="card-title">Login Seller</h5>
            </div>
            <div class="card-body">
                <form id="loginForm">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="loginEmail" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="loginPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>

        <!-- Product Management Section (Initially Hidden) -->
        <div id="productManagement" style="display: none;">
            <button class="btn btn-danger mb-3" onclick="logout()">Logout</button>

            <!-- Categories Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Kategori</h5>
                </div>
                <div class="card-body">
                    <form id="categoryForm" class="mb-3">
                        <div class="row">
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="categoryName" placeholder="Nama Kategori" required>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="categoryDescription" placeholder="Deskripsi">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Tambah Kategori</button>
                            </div>
                        </div>
                    </form>
                    <select class="form-select" id="categoryList">
                        <option value="">Pilih Kategori</option>
                    </select>
                </div>
            </div>

            <!-- Product Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title" id="formTitle">Tambah Produk Baru</h5>
                </div>
                <div class="card-body">
                    <form id="productForm">
                        <input type="hidden" id="productId">
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" id="category_id" required>
                                <option value="">Pilih Kategori</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" class="form-control" id="price" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stock" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="image" accept="image/jpeg,image/png">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>

            <!-- Product List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Produk</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="productList"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        const API_URL = 'http://localhost/api';
        let token = localStorage.getItem('token');

        // Check if user is logged in
        if (token) {
            showProductManagement();
            getCategories();
            getProducts();
        }

        // Login Handler
        $('#loginForm').submit(function(e) {
            e.preventDefault();

            const data = {
                email: $('#loginEmail').val(),
                password: $('#loginPassword').val()
            };

            $.ajax({
                url: `${API_URL}/login`,
                method: 'POST',
                data: data,
                success: function(response) {
                    if (response.data.user.roles !== 'seller') {
                        alert('Akun ini bukan akun seller');
                        return;
                    }
                    token = response.data.token;
                    localStorage.setItem('token', token);
                    showProductManagement();
                    getCategories();
                    getProducts();
                },
                error: function() {
                    alert('Login gagal. Periksa email dan password Anda.');
                }
            });
        });

        // Logout Function
        function logout() {
            $.ajax({
                url: `${API_URL}/logout`,
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                success: function() {
                    localStorage.removeItem('token');
                    showLoginForm();
                }
            });
        }

        // Category Functions
        $('#categoryForm').submit(function(e) {
            e.preventDefault();

            const data = {
                name: $('#categoryName').val(),
                description: $('#categoryDescription').val()
            };

            $.ajax({
                url: `${API_URL}/seller/category`,
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                data: data,
                success: function(response) {
                    alert('Kategori berhasil ditambahkan');
                    $('#categoryForm')[0].reset();
                    getCategories();
                },
                error: function() {
                    alert('Gagal menambahkan kategori');
                }
            });
        });

        function getCategories() {
            $.ajax({
                url: `${API_URL}/seller/categories`,
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                success: function(response) {
                    const categories = response.data;
                    let html = '<option value="">Pilih Kategori</option>';

                    categories.forEach(category => {
                        html += `<option value="${category.id}">${category.name}</option>`;
                    });

                    $('#category_id').html(html);
                    $('#categoryList').html(html);
                }
            });
        }

        // Product Functions
        $('#productForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData();
            const productId = $('#productId').val();

            formData.append('category_id', $('#category_id').val());
            formData.append('name', $('#name').val());
            formData.append('price', $('#price').val());
            formData.append('stock', $('#stock').val());
            formData.append('description', $('#description').val());

            if ($('#image')[0].files[0]) {
                formData.append('image', $('#image')[0].files[0]);
            }

            const url = productId ?
                `${API_URL}/seller/products/${productId}` :
                `${API_URL}/seller/products`;

            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert(response.message);
                    resetForm();
                    getProducts();
                },
                error: function() {
                    alert('Gagal menyimpan produk');
                }
            });
        });

        function getProducts() {
            $.ajax({
                url: `${API_URL}/seller/products`,
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                success: function(response) {
                    const products = response.data;
                    let html = '';

                    products.forEach(product => {
                        html += `
                            <tr>
                                <td><img src="/storage/${product.image}" height="50"></td>
                                <td>${product.name}</td>
                                <td>${product.category_id}</td>
                                <td>${product.price}</td>
                                <td>${product.stock}</td>
                                <td>${product.description || '-'}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editProduct(${product.id})">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteProduct(${product.id})">Hapus</button>
                                </td>
                            </tr>
                        `;
                    });

                    $('#productList').html(html);
                }
            });
        }

        function editProduct(id) {
            const product = currentProducts.find(p => p.id === id);
            if (product) {
                $('#productId').val(product.id);
                $('#category_id').val(product.category_id);
                $('#name').val(product.name);
                $('#price').val(product.price);
                $('#stock').val(product.stock);
                $('#description').val(product.description);
                $('#formTitle').text('Edit Produk');
            }
        }

        function deleteProduct(id) {
            if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                $.ajax({
                    url: `${API_URL}/seller/products/${id}`,
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    },
                    success: function(response) {
                        alert(response.message);
                        getProducts();
                    },
                    error: function() {
                        alert('Gagal menghapus produk');
                    }
                });
            }
        }

        // Helper Functions
        function showProductManagement() {
            $('#loginCard').hide();
            $('#productManagement').show();
        }

        function showLoginForm() {
            $('#loginCard').show();
            $('#productManagement').hide();
        }

        function resetForm() {
            $('#productId').val('');
            $('#productForm')[0].reset();
            $('#formTitle').text('Tambah Produk Baru');
        }
    </script>
</body>
</html>
