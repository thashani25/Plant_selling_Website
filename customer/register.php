<?php
include 'conection.php';
session_start();

$success_msg = '';
$error_msg = '';

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Invalid email format.";
    } elseif ($pass !== $cpass) {
        $error_msg = "Passwords do not match.";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM register WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_msg = "Email already registered.";
        } else {
            // Hash password and insert user
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO register(name, email, password) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $name, $email, $hashed_password);

            if ($insert->execute()) {
                $success_msg = "Registration successful! <a href='login.php'>Click here to login</a>.";
            } else {
                $error_msg = "Something went wrong. Try again.";
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Tea - Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main-container">
    <section class="form-container">
        <div class="title">
            <img src="img/download.png" class="logo-img">
            <h1>Register Now</h1>
            <p>Join Green Tea to enjoy shopping and more!</p>
        </div>

        <?php if ($error_msg): ?>
            <p style="color:red;"><?php echo htmlspecialchars($error_msg); ?></p>
        <?php endif; ?>
        <?php if ($success_msg): ?>
            <p style="color:green;"><?php echo $success_msg; ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <div class="input-filed">
                <p>Your Name <sub>*</sub></p>
                <input type="text" name="name" required placeholder="Enter your name" maxlength="50">
            </div>
            <div class="input-filed">
                <p>Your Email <sub>*</sub></p>
                <input type="email" name="email" required placeholder="Enter your email" maxlength="50"
                       oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
            <div class="input-filed">
                <p>Your Password <sub>*</sub></p>
                <input type="password" name="pass" required placeholder="Enter your password" maxlength="50"
                       oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
            <div class="input-filed">
                <p>Confirm Password <sub>*</sub></p>
                <input type="password" name="cpass" required placeholder="Confirm your password" maxlength="50"
                       oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
            <input type="submit" name="submit" value="Register Now" class="btn">
            <p>Already have an account? <a href="login.php">Login now</a></p>
        </form>
    </section>


    <?php
include 'connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Invalid email format.";
    } elseif ($pass !== $cpass) {
        $error_msg = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_msg = "Email already registered.";
        } else {
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $name, $email, $hashed_password);

            if ($insert->execute()) {
                $success_msg = "Registration successful! <a href='login.php'>Click here to login</a>.";
            } else {
                $error_msg = "Something went wrong. Try again.";
            }
        }
        $stmt->close();
    }
}
?>

</div>
</body>
</html>
