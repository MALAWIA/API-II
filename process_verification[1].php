<?php
// FILE: process_verification.php
session_start();
require_once 'config.php';
require_once 'customer.php';

// Check if user is actually in the 2FA process
if (!isset($_SESSION['2fa_user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = (new Database())->connect();
    $customer = new Customer($db);

    $user_id = $_SESSION['2fa_user_id'];
    $code = $_POST['2fa_code'];

    // We need a method to verify the code
    if ($customer->verify2FACode($user_id, $code)) {
        // SUCCESS! Log the user in
        unset($_SESSION['2fa_user_id']); // Clear the temporary session variable
        $_SESSION['user_id'] = $user_id; // Set the permanent login session

        // Clear the 2FA code from the database for security
        $customer->clear2FACode($user_id);

        echo "Login successful!";
        // Redirect to a protected dashboard or homepage
        // header("Location: dashboard.php");
        exit();
    } else {
        die("Invalid or expired code. Please try again.");
    }
}
?>