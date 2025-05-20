<?php
include 'conection.php';
session_start();

$error_msg = '';

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Invalid email format.";
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM register WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $hashed_password);
            $stmt->fetch();

            if (password_verify($pass, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                header("Location: home.php");
                exit;
            } else {
                $error_msg = "Incorrect password!";
            }
        } else {
            $error_msg = "Email not registered!";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Green Cafee - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-container">
    <section class="form-container">
        <div class="title">
            <img src="img/logo.png" alt="Logo">
            <h1>Login Now</h1>
        </div>

        <?php if ($error_msg): ?>
            <p style="color:red;"><?php echo htmlspecialchars($error_msg); ?></p>
        <?php endif; ?>

        <form action="" method="post">
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
            <input type="submit" name="submit" value="Login Now" class="btn">
            <p>Don't have an account? <a href="register.php">Register Now</a></p>
        </form>
    </section>
</div>

</body>
</html>
