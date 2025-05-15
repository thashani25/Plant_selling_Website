<?php
session_start();
include 'conection.php'; // DB connection


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>checkout - Green Cactus</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>checkout</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a><span> / checkout</span>
    </div>

<div class="checkout-container">
    <h1>Checkout</h1>
    <div class="product-summary">
        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <p>Price: Rs. <?= number_format($product['price'], 2) ?></p>
        <p>Quantity: <?= $qty ?></p>
        <h3>Total: Rs. <?= number_format($total_price, 2) ?></h3>
    </div>

    <form action="Cart/place_order.php" method="post">
        <input type="hidden" name="product_id" value="<?= $product_id ?>">
        <input type="hidden" name="qty" value="<?= $qty ?>">
        <input type="hidden" name="total_price" value="<?= $total_price ?>">

        <label>Delivery Address:</label><br>
        <textarea name="address" required placeholder="Enter your delivery address"></textarea><br>

        <label>Payment Method:</label><br>
        <select name="payment_method" required>
            <option value="">Select</option>
            <option value="Cash on Delivery">Cash on Delivery</option>
            <option value="Credit Card">Credit Card</option>
        </select><br><br>

        <button type="submit" class="btn">Place Order</button>
    </form>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
