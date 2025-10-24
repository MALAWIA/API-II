<?php
// FILE: process_2fa_request.php

// 1. Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once 'config.php';
require_once 'customer.php';
// 2. Include the Composer autoloader
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = (new Database())->connect();
    $customer = new Customer($db);

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user_data = $customer->checkLogin($email, $password);

    if ($user_data) {
        $code = random_int(100000, 999999);
        $expiry = date("Y-m-d H:i:s", time() + 300); // 5-minute expiry

        $customer->save2FACode($user_data['customer_id'], $code, $expiry);

        // 3. --- START: PHPMailer Code ---
        $mail = new PHPMailer(true); // Enable exceptions
        
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'amanda.muyoka@strathmore.edu';      // <<< EDIT THIS: Your Gmail address
            $mail->Password   = 'xklj dini ivac dfey'; // <<< EDIT THIS: Your 16-character App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('your-email@gmail.com', 'My Website'); // <<< EDIT THIS: Your Gmail address and name
            $mail->addAddress($email); // Adds the user who is logging in

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Two-Factor Authentication Code';
            $mail->Body    = 'Your verification code is: <b>' . $code . '</b>';
            $mail->AltBody = 'Your verification code is: ' . $code;

            $mail->send(); // Send the email

        } catch (Exception $e) {
            // This will show an error if the email fails to send
            die("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
        // --- END: PHPMailer Code ---

        // Remember who is trying to log in
        $_SESSION['2fa_user_id'] = $user_data['customer_id'];

        // 4. --- REMOVE THE OLD TEST CODE ---
        // We removed the die("TESTING: ..."); line

        // Redirect to the verification page
        header("Location: verify_2fa.php");
        exit();
        
    } else {
        die("Invalid email or password.");
    }
}
?>