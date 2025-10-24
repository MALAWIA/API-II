<?php
class Database {
    // Database configuration
    private $host = "localhost";
    private $db_name = "clothing_store";
    private $username = "root";
    private $password = "1234"; 
    private $conn;

    // Database connection
    public function connect() {
        $this->conn = null;
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Display a user-friendly message (hide detailed error in production)
            echo "Database connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>
