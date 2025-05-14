
<style type="text/css">
    <?php include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Green Cactus - Cart</title>
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>Add to Cart</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a><span>/ Add to Cart</span> 
    </div>

    <?php
include 'conection.php';



$success_message = '';
$error_message = '';

?>

    <?php if ($success_message): ?>
        <div class="success-message"><?= $success_message; ?></div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="error-message"><?= $error_message; ?></div>
    <?php endif; ?>

    <div class="cart-items">
        <?php
        while ($row = $cart_result->fetch_assoc()) {
            $total_amount = $row['total_price']; // Calculate total amount
        ?>
            <div class="cart-item">
                <h3><?= htmlspecialchars($row['name']); ?></h3>
                <p>Quantity: <?= htmlspecialchars($row['quantity']); ?></p>
                <p>Total Price: Rs. <?= htmlspecialchars($row['total_price']); ?></p>
            </div>
        <?php } ?>

        <div class="cart-total">
            <h3>Total Amount: Rs. <?= number_format($total_amount, 2); ?></h3>
        </div>

        <a href="checkout.php" class="checkout-button">Proceed to Checkout</a>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include 'alert.php'; ?>

</body>
</html>



   