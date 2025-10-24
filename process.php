<?php
class Product {
    private $conn;
    private $table = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function add($name, $description, $price, $size, $category_id, $stock) {
        $sql = "INSERT INTO {$this->table} (name, description, price, size, category_id, stock)
                VALUES (:name, :description, :price, :size, :category_id, :stock)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':stock', $stock);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // ✅ Get all products
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Get single product
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $description, $price, $size, $category_id, $stock) {
        $sql = "UPDATE {$this->table} 
                SET name = :name, description = :description, price = :price,
                    size = :size, category_id = :category_id, stock = :stock
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':stock', $stock);

        return $stmt->execute();
    }

    // ✅ Delete product
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
