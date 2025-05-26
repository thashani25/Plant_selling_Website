<?php
session_start();

// Replace these with your admin credentials or connect to your database to verify
$admin_username = "admin";
$admin_password = "admin123"; // Ideally, use hashed passwords for production!

// If form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Simple authentication check (replace with DB check for real projects)
    if ($username === $admin_username && $password === $admin_password) {
        // Set session and redirect to dashboard
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: admin_dashboard.php');
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Login - Green Cactus</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            width: 320px;
        }
        h2 {
            margin-bottom: 1.5rem;
            text-align: center;
            color: #4CAF50;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 0.75rem;
            margin: 0.5rem 0 1.25rem 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            background: #4CAF50;
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover {
            background: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2><i class='bx bx-leaf'></i> Admin Login</h2>

    <?php if (!empty($error)) : ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <input type="text" name="username" placeholder="Username" required autofocus />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
