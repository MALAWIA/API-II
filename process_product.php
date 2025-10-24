<?php
// FILE: process.php

// 1. Include Files (Task 2)
// This brings in your DB connection class and your Product class
require_once 'config.php';
require_once 'product.php';

// 2. Check Method (Task 1)
// Only run code if the form was actually submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 3. Server-Side Validation (Task 3)
    // This is the CRUCIAL second check.
    
    // Check for empty fields
    if (empty($_POST['product_name']) || 
        empty($_POST['category']) || 
        empty($_POST['price']) || 
        !isset($_POST['stock'])) // Use !isset for 'stock' because 0 is a valid value
    {
        // Redirect back with an error for empty fields
        header('Location: add_product.php?status=error&message=emptyfields');
        exit(); // Always stop the script after a redirect
    }

    // Check for valid data types
    if (!is_numeric($_POST['price']) || $_POST['price'] <= 0) {
        // Redirect back with an error for invalid price
        header('Location: add_product.php?status=error&message=invalidprice');
        exit();
    }

    if (!is_numeric($_POST['stock']) || $_POST['stock'] < 0) {
        // Redirect back with an error for invalid stock
        header('Location: add_product.php?status=error&message=invalidstock');
        exit();
    }

    // --- Validation Passed ---

    // 4. Connect to DB and Create Object (Task 4)
    $db = (new Database())->connect();
    $product = new Product($db); // This matches YOUR class constructor

    // 5. Get the (now validated) data
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // 6. Save to DB (Task 5)
    if ($product->addProduct($name, $category, $price, $stock)) {
        // 7. Redirect on Success (Task 6)
        header('Location: add_product.php?status=success');
        exit();
    } else {
        // 7. Redirect on Failure (Task 6)
        header('Location: add_product.php?status=error&message=dbfailure');
        exit();
    }

} else {
    // If someone tries to access this file directly, send them away.
    header('Location: add_product.php');
    exit();
}
?>