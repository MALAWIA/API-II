<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow p-4">
            <h2 class="mb-4">Enter Verification Code</h2>
            <p>We've sent a 6-digit code to your email address.</p>
            <form action="process_verification.php" method="POST">
                <div class="mb-3">
                    <label for="2fa_code" class="form-label">Verification Code</label>
                    <input type="text" class="form-control" id="2fa_code" name="2fa_code" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Verify</button>
            </form>
        </div>
    </div>
</body>
</html>