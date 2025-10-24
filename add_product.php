<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow p-4">
      <h2 class="mb-4 text-primary">Add New Product</h2>

      <?php
        // This PHP block checks the URL for status messages from process.php
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'success') {
                echo '<div class="alert alert-success" role="alert">Product added successfully!</div>';
            } elseif ($_GET['status'] == 'error') {
                $message = $_GET['message'] == 'emptyfields' ? 'All fields are required.' : 'A database error occurred.';
                echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
            }
        }
      ?>

      <form id="productForm" method="POST" action="process.php">
        
        <div class="mb-3">
          <label for="product_name" class="form-label">Product Name</label>
          <input type="text" class="form-control" id="product_name" name="product_name" required>
        </div>

        <div class="mb-3">
          <label for="category" class="form-label">Category</label>
          <select class="form-select" id="category" name="category" required>
            <option value="">Select Category</option>
            <option value="Men">Men</option>
            <option value="Women">Women</option>
            <option value="Kids">Kids</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="price" class="form-label">Price</label>
          <input type="number" class="form-control" id="price" name="price" min="0.01" step="0.01" required>
        </div>

        <div class="mb-3">
          <label for="stock" class="form-label">Stock Quantity</label>
          <input type="number" class="form-control" id="stock" name="stock" min="0" required>
        </div>
        
        <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>

        <button type="submit" class="btn btn-primary w-100">Add Product</button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script src="add_product.js" defer></script>

</body>
</html>