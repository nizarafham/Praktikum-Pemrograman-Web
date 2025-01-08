<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
</head>
<body>
    <form id="addProductForm">
        <input type="text" id="name" placeholder="Product Name" required>
        <input type="number" id="price" placeholder="Price" required>
        <input type="number" id="stock" placeholder="Stock" required>
        <input type="text" id="category_id" placeholder="Category ID" required>
        <button type="submit">Add Product</button>
    </form>

    <script>
        document.getElementById('addProductForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const token = 'your_api_token_here'; 

            const data = {
                name: document.getElementById('name').value,
                price: document.getElementById('price').value,
                stock: document.getElementById('stock').value,
                category_id: document.getElementById('category_id').value
            };

            const response = await fetch('http://127.0.0.1:8000/api/products', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            console.log(result);
        });
    </script>
</body>
</html>
