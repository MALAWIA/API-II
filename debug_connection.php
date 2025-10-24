<?php
// FILE: debug_connection.php

// Use the exact same config file as your application
require_once 'config.php';

echo "<h1>Debugging Database Connection</h1>";

try {
    // Use the exact same connection method
    $db = (new Database())->connect();
    echo "<p style='color:green;'>Successfully connected to the database!</p>";
    
    // Ask the database to describe the 'customers' table
    $query = "DESCRIBE customers"; // Make sure this table name is lowercase
    
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($columns) > 0) {
        echo "<h2>Structure of the 'customers' table:</h2>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field Name</th><th>Data Type</th><th>Null?</th><th>Key</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td><strong>" . htmlspecialchars($column['Field']) . "</strong></td>";
            echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
            echo "<td>" . htmlspecialchars($column['Null']) . "</td>";
            echo "<td>" . htmlspecialchars($column['Key']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<h3 style='margin-top:20px; color:blue;'>This is the absolute truth. The 'Field Name' listed above is what you MUST use in your PHP code.</h3>";
        
    } else {
        echo "<p style='color:red;'>Could not find a table named 'customers'. Check the table name and the database name in config.php!</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color:red;'><strong>Connection Failed:</strong> " . $e->getMessage() . "</p>";
    echo "<p>Please check your `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASS` in your <strong>config.php</strong> file.</p>";
}
?>