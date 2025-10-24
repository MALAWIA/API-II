<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product | Clothing Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container mt-5">
    <div class="card shadow p-4">
      <h2 class="mb-4 text-primary">Add New Clothing Item</h2>

      <form id="clothingForm" method="POST" action="process.php">
        <div class="mb-3">
          <label for="itemName" class="form-label">Item Name</label>
          <input type="text" class="form-control" id="itemName" name="itemName" required>
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
          <label for="size" class="form-label">Size</label>
          <input type="text" class="form-control" id="size" name="size" required>
        </div>

        <div class="mb-3">
          <label for="price" class="form-label">Price (KES)</label>
          <input type="number" class="form-control" id="price" name="price" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Add Item</button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('clothingForm').addEventListener('submit', function(e) {
      const price = document.getElementById('price').value;
      if (price <= 0) {
        e.preventDefault();
        alert('Price must be greater than zero.');
      }
    });
  </script>

</body>
</html>