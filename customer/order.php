<?php
session_start();
include 'conection.php'; // replace with your actual DB connection file

$total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['qty'];
    }
}

$errors = [];
$success_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $address = htmlspecialchars(trim($_POST['address']));
    $payment_method = htmlspecialchars(trim($_POST['payment_method']));

    if (!$name) $errors[] = "Name is required.";
    if (!$phone) $errors[] = "Phone number is required.";
    if (!$email) $errors[] = "Valid email is required.";
    if (!$address) $errors[] = "Address is required.";
    if (!$payment_method) $errors[] = "Please select a payment method.";

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO orders (customer_name, phone, email, address, total, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdss", $name, $phone, $email, $address, $total, $payment_method);
        if ($stmt->execute()) {
            unset($_SESSION['cart']); // Clear cart
            $success_message = "
                <div class='success-box'>
                    <h3>Thank you for your order, $name!</h3>
                    <p>Confirmation has been sent to <strong>$email</strong>.</p>
                    <p>Payment Method: <strong>$payment_method</strong></p>
                    <p>Total Payment: <strong>Rs. " . number_format($total, 2) . "</strong></p>
                </div>
            ";
        } else {
            $errors[] = "Failed to place order. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Green Cactus- order page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>my order</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a> <span>/ order</span>
    </div>

    <section class="products">
        <div class="box-container">
            <div class="title">
                <img src="img/logo.png" class="logo">
                <h1>my orders </h1>
                <p> skjad ksabnc ;sdjk;c nxbc jsdhbuias;l c nbjhvbsk lskj </p>
            </div>
</section>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?= $e ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="cart-summ">
            <h3>Cart Summary</h3>
            <?php if (!empty($_SESSION['cart'])): ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price (Rs.)</th>
                            <th>Subtotal (Rs.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['cart'] as $item):
                            $subtotal = $item['price'] * $item['qty'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                <?= htmlspecialchars($item['name']) ?>
                            </td>
                            <td><?= $item['qty'] ?></td>
                            <td><?= number_format($item['price'], 2) ?></td>
                            <td><?= number_format($subtotal, 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align:right;"><strong>Total:</strong></td>
                            <td><strong>Rs. <?= number_format($total, 2) ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
         <div style="text-align:center; margin-top:20px;">
            
            <a href="checkout.php" style="padding:10px 20px; background:#2196F3; color:#fff; border-radius:6px; text-decoration:none; margin-left:10px;">pace to checkout</a>
        </div>

               <a href="cart.php">Go to cart</a></p>


</div>
</div>


















    </div>
</div>

<?php include 'footer.php'; ?>
</di
<script src="script.js"></script>
</body>
</html>