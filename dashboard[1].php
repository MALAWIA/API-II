<?php
// FILE: dashboard.php

// 1. Always start the session
session_start();

// 2. Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit(); // Stop the script from running
}

// 3. INCLUDE BOTH MODELS
require_once 'config.php';
require_once 'customer.php';
require_once 'product.php'; // <-- ADDED THIS INCLUDE

$db = (new Database())->connect();

// Get Customer Info
$customer = new Customer($db);
$user_info = $customer->getCustomerById($_SESSION['user_id']);

// 4. GET ALL PRODUCTS
$product_model = new Product($db); // <-- CREATE PRODUCT OBJECT
$products = $product_model->getAllProducts(); // <-- CALL NEW METHOD

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Welcome, <?php echo htmlspecialchars($user_info['customer_name'] ?? 'User'); ?>!</h1>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        
        <hr>

        <div class="card shadow p-4">
            <h2>Available Goods</h2>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // 5. LOOP THROUGH THE PRODUCTS
                    while ($row = $products->fetch(PDO::FETCH_ASSOC)) {
                        // Extract variables for easier use
                        extract($row);
                        
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($product_name) . "</td>";
                        echo "<td>" . htmlspecialchars($category) . "</td>";
                        echo "<td>" . htmlspecialchars($price) . "</td>";
                        echo "<td>" . htmlspecialchars($stock) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>