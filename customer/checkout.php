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
    <title>Checkout - Green Cafee</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .success-box {
            border: 2px solid #4CAF50;
            background-color: #e8f5e9;
            padding: 20px;
            border-radius: 10px;
            color: #2e7d32;
            margin-bottom: 20px;
        }

        .error-box {
            border: 2px solid #f44336;
            background-color: #ffebee;
            padding: 20px;
            border-radius: 10px;
            color: #c62828;
            margin-bottom: 20px;
        }

        .checkout-container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
        }

        form input, form textarea, form select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        form button.btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        table.cart-summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.cart-summary-table th, table.cart-summary-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        table.cart-summary-table img {
            height: 50px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="main">
    <div class="banner"><h1>Checkout Summary</h1></div>
    <div class="title2"><a href="home.php">Home</a><span> / Checkout Summary</span></div>

    <div class="checkout-container">

        <?= $success_message ?>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?= $e ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="cart-summary-box">
            <h3>Cart Summary</h3>
            <?php if (!empty($_SESSION['cart'])): ?>
                <table class="cart-summary-table">
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

        <div class="cart-summary-box">
            <h3>Customer & Payment Details</h3>
            <form method="POST">
                <input type="text" name="name" placeholder="Your Name" required value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                <input type="text" name="phone" placeholder="Phone Number" required value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
                <input type="email" name="email" placeholder="Email Address" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                <textarea name="address" placeholder="Delivery Address" required><?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?></textarea>

                <label for="payment_method">Payment Method:</label>
                <select name="payment_method" required>
                    <option value="">-- Select Payment Method --</option>
                    <option value="Credit Card" <?= (isset($_POST['payment_method']) && $_POST['payment_method'] == 'Credit Card') ? 'selected' : '' ?>>Credit Card</option>
                    <option value="Cash" <?= (isset($_POST['payment_method']) && $_POST['payment_method'] == 'Cash') ? 'selected' : '' ?>>Cash</option>
                </select>

                <button type="submit" class="btn">Place Order</button>
            </br>
                <a href="cart.php">Go to cart</a></p>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="script.js"></script>
</body>
</html>
