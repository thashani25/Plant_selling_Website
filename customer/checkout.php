<?php
include 'conection.php';
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$user_id = $_SESSION['user_id'] ?? 0;
$grand_total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Green Cactus</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>checkout summary</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a><span> / checkout summary</span>
    </div>

    <section class="checkout">
        <div class="title2">
            <img src="img/logo.png" class="logo">
            <h1>checkout summary</h1>
            <p>bbjxsdjweijfjdwebcqwoiodklc cdbcdhc loqfkcvb olqlqkd cb okfcw</p>
        </div>
        <div class="row">
            <form method="post">
                <h3>billing details</h3>
                <div class="flex">
                    <div class="box">
                        <div class="input-field">
                            <p>Your name <span>*</span></p>
                            <input type="text" name="name" required maxlength="50" placeholder="Enter Your Name" class="input">
                        </div>
                        <div class="input-field">
                            <p>Your number <span>*</span></p>
                            <input type="number" name="number" required maxlength="50" placeholder="Enter Your Number" class="input">
                        </div>
                        <div class="input-field">
                            <p>Your email <span>*</span></p>
                            <input type="email" name="email" required maxlength="50" placeholder="Enter Your Email" class="input">
                        </div>
                        <div class="input-field">
                            <p>Payment method <span>*</span></p>
                            <select name="method" class="input">
                                <option value="cash on delivery">Cash on Delivery</option>
                                <option value="credit or debit card">Credit or Debit Card</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <p>Address type <span>*</span></p>
                            <select name="address_type" class="input">
                                <option value="home">Home</option>
                                <option value="office">Office</option>
                            </select>
                        </div>
                    </div>

                    <div class="box">
                        <div class="input-field">
                            <p>Address Line 01 <span>*</span></p>
                            <input type="text" name="flat" required maxlength="50" placeholder="E.g flat & building number" class="input">
                        </div>
                        <div class="input-field">
                            <p>Address Line 02 <span>*</span></p>
                            <input type="text" name="street" required maxlength="50" placeholder="E.g. street name" class="input">
                        </div>
                        <div class="input-field">
                            <p>City name <span>*</span></p>
                            <input type="text" name="city" required maxlength="50" placeholder="Enter your city" class="input">
                        </div>
                    </div>
                </div>
                <button type="submit" name="place_order" class="btn">Place Order</button>
            </form>

            <div class="summary">
                <h3>My Bag</h3>
                <div class="box-container">
                 
<?php 
$user_id = $_SESSION['user_id'] ?? 0;
$grand_total = 0;

// Handle order submission
if (isset($_POST['place_order'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $address_type = $_POST['address_type'];
    $flat = $_POST['flat'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $full_address = "$address_type - $flat, $street, $city";

    // Calculate total from cart
    $select_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $select_cart->execute([$user_id]);
    if ($select_cart->rowCount() > 0) {
        while ($cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            $product_stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
            $product_stmt->execute([$cart['product_id']]);
            $product = $product_stmt->fetch(PDO::FETCH_ASSOC);
            if ($product) {
                $sub_total = $product['price'] * $cart['qty'];
                $grand_total += $sub_total;
            }
        }

        // Save order
        $insert_order = $conn->prepare("INSERT INTO orders (user_id, name, number, email, method, address, total_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert_order->execute([$user_id, $name, $number, $email, $method, $full_address, $grand_total]);

        // Clear cart after order
        $delete_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $delete_cart->execute([$user_id]);

        echo "<script>
            alert('Order placed successfully! Total Rs. " . number_format($grand_total, 2) . "');
            window.location.href='home.php';
        </script>";
    } else {
        echo "<script>alert('Your cart is empty!');</script>";
    }
}
?>
<?php
$select_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$select_cart->execute([$user_id]);



       ?>
<div class="flex">
    
    </div>
</div>
<?php
        
?>
<hr>
<h3>Total: Rs. <?= number_format($grand_total, 2); ?></h3>
<?php

?>


    <?php include 'footer.php'; ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include 'alert.php'; ?>
</body>
</html>
