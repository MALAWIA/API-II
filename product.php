<?php
// FILE: product.php

class Product {
    private $conn;
    private $table = "products";

    /**
     * This constructor correctly expects ONE argument:
     * the database connection.
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * This method takes the form data, sanitizes it,
     * and executes the query.
     */
    public function addProduct($name, $category, $price, $stock) {
        $sql = "INSERT INTO {$this->table} (product_name, category, price, stock)
                VALUES (:name, :category, :price, :stock)";
        
        $stmt = $this->conn->prepare($sql);

        // --- Sanitize your inputs ---
        $name = htmlspecialchars(strip_tags($name));
        $category = htmlspecialchars(strip_tags($category));
        $price = htmlspecialchars(strip_tags($price));
        $stock = htmlspecialchars(strip_tags($stock));

        // Bind the sanitized parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock', $stock);

        // Execute the statement
        if ($stmt->execute()) {
            return true;
        }
        
        // Print error if something goes wrong
        printf("Error: %s.\n", implode(" ", $stmt->errorInfo())); // Changed to errorInfo() for PDO
        return false;
    }

<<<<<<< HEAD
=======
    // --- START: ADD THIS NEW METHOD ---
>>>>>>> 611ad7d7c5de580eea32608f462c2caf5309802c

    /**
     * Fetches all products from the database
     */
    public function getAllProducts() {
        $sql = "SELECT product_name, category, price, stock FROM {$this->table} ORDER BY product_name ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt; // Return the statement object
    }
    
    // --- END: ADD THIS NEW METHOD ---
}
?>