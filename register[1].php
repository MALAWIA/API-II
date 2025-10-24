<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow p-4">
            <h2 class="mb-4 text-primary">Create an Account</h2>

            <?php
                // This PHP block displays an error if the email already exists
                if (isset($_GET['status']) && $_GET['status'] == 'error' && isset($_GET['message'])) {
                    if ($_GET['message'] == 'emailexists') {
                        echo '<div class="alert alert-danger">This email address is already registered. Please <a href="login.php">log in</a>.</div>';
                    }
                }
            ?>
            
            <form action="process_registration.php" method="POST">
                
                <div class="mb-3">
                    <label for="customer_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
        </div>
    </div>
</body>
</html>