<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Task Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5 col-md-4">
        <h3 class="text-center mb-4">Task Manager Login</h3>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $conn->real_escape_string($_POST['username']);
            $password = md5($_POST['password']); // Same hashing as DB

            $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $result = $conn->query($query);

            if ($result->num_rows === 1) {
                $_SESSION['user'] = $result->fetch_assoc();
                header("Location: index.php");
                exit;
            } else {
                echo '<div class="alert alert-danger">Invalid credentials</div>';
            }
        }
        ?>
        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input name="username" type="text" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input name="password" type="password" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>
