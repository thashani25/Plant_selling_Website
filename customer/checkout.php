<?php
include 'conection.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: checkout.php");
    exit();
}

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
$qty = isset($_GET['qty']) ? intval($_GET['qty']) : 1;

if ($product_id <= 0 || $qty <= 0) {
    echo "Invalid product or quantity.";
    exit();
}

$query = $conn->prepare("SELECT * FROM products WHERE id = ?");
$query->bind_param("i", $product_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo "Product not found.";
    exit();
}

$product = $result->fetch_assoc();
$total_price = $product['price'] * $qty;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout - Green Cactus</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <div class="banner"><h1>Checkout</h1></div>

    <div class="checkout-container">
        <div class="checkout-box">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width:200px;">
            <p>Unit Price: Rs. <?= number_format($product['price'], 2) ?></p>
            <p>Quantity: <?= $qty ?></p>
            <h3>Total: Rs. <?= number_format($total_price, 2) ?></h3>

            <form action="process_payment.php" method="post">
                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                <input type="hidden" name="qty" value="<?= $qty ?>">
                <input type="hidden" name="expected_total" value="<?= $total_price ?>">

                <label>Enter Payment Amount (Rs.):</label><br>
                <input type="number" name="amount_paid" required step="0.01" min="1"><br><br>

                <label>Payment Method:</label><br>
                <select name="payment_method" required>
                    <option value="">Select...</option>
                    <option value="Card">Card</option>
                    <option value="Cash on Delivery">Cash on Delivery</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select><br><br>

                <label>Delivery Address:</label><br>
                <textarea name="address" rows="4" required></textarea><br><br>

                <button type="submit">Place Order</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
