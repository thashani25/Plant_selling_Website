<?php
    include 'conection.php';
    session_start();

   

?>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>green tea - login now </title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="img/download.png">
                <h1>login now</h1>
                <p> </p>
            </div>

            <form action="" method="post">
                 <div class="input-filed">
                    <p>your email <sub>*</sub></p>
                    <input type="email" name="email" required placeholder="enter your email" maxlength="50" 
                    oninput="this.value = this.value.replace(/\s/g, '')">
                 </div>
                 <div class="input-filed">
                    <p>your password <sub>*</sub></p>
                    <input type="password" name="pass" required placeholder="enter your password" maxlength="50" 
                    oninput="this.value = this.value.replace(/\s/g, '')">
                  </div>
                 <input type="submit" name="submit" value="register now" class="btn">
                 <p> do not have  an account? <a href="register.php">login now</a></p>

                 <?php

$conn = new mysqli("localhost", "root", "", "cactusdb");

$username = "test@example.com";
$password = password_hash("123", PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);



?>




</body>
</html>