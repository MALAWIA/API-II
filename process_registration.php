<?php
// FILE: process_registration.php
require_once 'config.php';
require_once 'customer.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Basic validation
    if (empty($_POST['customer_name']) || empty($_POST['email']) || empty($_POST['password'])) {
        die("Full name, email, and password are required.");
    }

    $db = (new Database())->connect();
    $customer = new Customer($db);

    $name = $_POST['customer_name'];
    $email = $_POST['email'];
    
    // START: ADD THIS CHECK
    // Check if the email is already in use
    if ($customer->emailExists($email)) {
        // Redirect back to the registration form with an error message
        header("Location: register.php?status=error&message=emailexists");
        exit();
    }
    // END: ADD THIS CHECK

    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // If the check passes, proceed with registration
    if ($customer->register($name, $email, $password_hash)) {
        header("Location: login.php?status=success");
        exit();
    } else {
        echo "Error: Could not register.";
    }
}
?>