<?php
// FILE: customer.php

class Customer {
    private $conn;
    private $table = "customers";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addCustomer($name, $email, $address, $phone) {
        $sql = "INSERT INTO {$this->table} (customer_name, email, address, phone)
                VALUES (:name, :email, :address, :phone)";
        
        $stmt = $this->conn->prepare($sql);

        // Sanitize data
        $name = htmlspecialchars(strip_tags($name));
        $email = htmlspecialchars(strip_tags($email));
        $address = htmlspecialchars(strip_tags($address));
        $phone = htmlspecialchars(strip_tags($phone));

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);

        if ($stmt->execute()) {
            return true;
        }
        
        printf("Error: %s.\n", implode(" ", $stmt->errorInfo()));
        return false;
    }

    // START: ADD THIS NEW METHOD
    /**
     * Checks if an email already exists in the database.
     * Returns true if email exists, false otherwise.
     */
    public function emailExists($email) {
        $sql = "SELECT customer_id FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return true; // Email found
        }
        return false; // Email not found
    }
    // END: ADD THIS NEW METHOD

    /**
     * Registers a new user with name, email and password.
     */
    public function register($name, $email, $password_hash) {
        $sql = "INSERT INTO {$this->table} (customer_name, email, password) VALUES (:name, :email, :password)";
        
        $stmt = $this->conn->prepare($sql);

        // Sanitize
        $name = htmlspecialchars(strip_tags($name));
        $email = htmlspecialchars(strip_tags($email));

        // Bind
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hash);

        if ($stmt->execute()) {
            return true;
        }
        
        // Optionally, add error reporting
        // printf("Error: %s.\n", implode(" ", $stmt->errorInfo()));
        return false;
    }

    public function checkLogin($email, $password) {
        $sql = "SELECT customer_id, email, password FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verify the hashed password
            if (password_verify($password, $row['password'])) {
                return $row; // Return user data if password is correct
            }
        }
        return false; // Return false if user not found or password incorrect
    }

    public function save2FACode($customer_id, $code, $expiry) {
        $sql = "UPDATE {$this->table} SET 2fa_code = :code, 2fa_expiry = :expiry WHERE customer_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':expiry', $expiry);
        $stmt->bindParam(':id', $customer_id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function verify2FACode($customer_id, $code) {
        $sql = "SELECT 2fa_code, 2fa_expiry FROM {$this->table} WHERE customer_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $customer_id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $current_time = date("Y-m-d H:i:s");
            
            // Check if code matches AND is not expired
            if ($row['2fa_code'] === $code && $row['2fa_expiry'] > $current_time) {
                return true;
            }
        }
        return false;
    }

    public function clear2FACode($customer_id) {
        $sql = "UPDATE {$this->table} SET 2fa_code = NULL, 2fa_expiry = NULL WHERE customer_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $customer_id);
        $stmt->execute();
    }

    /**
     * Gets a single customer's details by their ID
     */
    public function getCustomerById($customer_id) {
        $sql = "SELECT customer_id, email, customer_name, phone, address FROM {$this->table} WHERE customer_id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
}
?>