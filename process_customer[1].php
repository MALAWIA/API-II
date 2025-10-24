<?php
// FILE: process_customer.php

require_once 'config.php';
require_once 'customer.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1. ADD 'address' TO THE VALIDATION CHECK
    if (empty($_POST['customer_name']) || empty($_POST['email']) || empty($_POST['address'])) {
        header('Location: add_customer.php?status=error&message=emptyfields');
        exit();
    }

    $db = (new Database())->connect();
    $customer = new Customer($db);

    $name = $_POST['customer_name'];
    $email = $_POST['email'];
    
    // 2. GET THE ADDRESS FROM THE FORM
    $address = $_POST['address'];
    
    $phone = $_POST['phone'];

    // 3. PASS THE NEW $address VARIABLE TO THE METHOD
    if ($customer->addCustomer($name, $email, $address, $phone)) {
        header('Location: add_customer.php?status=success');
        exit();
    } else {
        header('Location: add_customer.php?status=error&message=dbfailure');
        exit();
    }
}
// ...
?>