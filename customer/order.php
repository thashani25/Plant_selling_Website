<?php
session_start();
include 'conection.php'; // replace with your actual DB connection file

// Handle removal of cart item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'], $_POST['remove_key'])) {
    $key = $_POST['remove_key'];
    if (isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
        // Re-index array keys
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['qty'];
    }
}

$errors = [];
$success_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['remove_item'])) {
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
        $stmt = $conn->prepare("INSERT INTO orders (customer_name, phone, email, address, total, payment_method, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssdss", $name, $phone, $email, $address, $total, $payment_method);
        if ($stmt->execute()) {
            unset($_SESSION['cart']);
            $success_message = "<div class='success-box'>
                    <h3>Thank you for your order, $name!</h3>
                    <p>Confirmation has been sent to <strong>$email</strong>.</p>
                    <p>Payment Method: <strong>$payment_method</strong></p>
                    <p>Total Payment: <strong>Rs. " . number_format($total, 2) . "</strong></p>
                </div>";
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
    <title>Green Cactus - Order Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="main">
    <div class="banner"><h1>My Order</h1></div>
    <div class="title2"><a href="home.php">Home</a> <span>/ Order</span></div>
    <section class="products">
        <div class="box-container">
            <div class="title">
                <img src="img/logo.png" class="logo">
                <h1>My Orders</h1>
                <p>Track and manage your recent orders below.</p>
            </div>
        </div>
    </section>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <ul><?php foreach ($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <?= $success_message; ?>

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
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $total = 0;
                foreach ($_SESSION['cart'] as $key => $item):
                    $subtotal = $item['price'] * $item['qty'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width:50px;"> <?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['qty'] ?></td>
                        <td><?= number_format($item['price'], 2) ?></td>
                        <td><?= number_format($subtotal, 2) ?></td>
                        <td>
                            <form method="post" style="margin:0;">
                                <input type="hidden" name="remove_key" value="<?= $key ?>">
                                <button type="submit" name="remove_item" class="remove-btn" style="background:none;border:none;color:red;cursor:pointer;">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr><td colspan="4" style="text-align:right;"><strong>Total:</strong></td><td><strong>Rs. <?= number_format($total, 2) ?></strong></td></tr>
                </tfoot>
            </table>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <!-- Order History with Cancel Option -->
    <?php
    $email_filter = isset($email) ? $email : '';
    if ($email_filter) {
        $stmt = $conn->prepare("SELECT id, customer_name, total, payment_method, created_at FROM orders WHERE email = ? ORDER BY created_at DESC");
        $stmt->bind_param("s", $email_filter);
        $stmt->execute();
        $orders = $stmt->get_result();

        if ($orders->num_rows > 0): ?>
            <div class="order-history">
                <h3>Your Order History</h3>
                <table>
                    <thead>
                        <tr><th>Order ID</th><th>Total</th><th>Payment</th><th>Placed</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $orders->fetch_assoc()): 
                            $order_time = strtotime($row['created_at']);
                            $now = time();
                            $diff_days = floor(($now - $order_time) / (60 * 60 * 24));
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td>Rs. <?= number_format($row['total'], 2) ?></td>
                            <td><?= htmlspecialchars($row['payment_method']) ?></td>
                            <td><?= $row['created_at'] ?></td>
                            <td>
                                <?php if ($diff_days <= 3): ?>
                                    <a href="cancel_order.php?id=<?= $row['id'] ?>" onclick="return confirm('Cancel this order?');" style="color: red;">Cancel</a>
                                <?php else: ?>
                                    <span style="color: gray;">Expired</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No previous orders found.</p>
        <?php endif;
    } ?>
</div>
<?php include 'footer.php'; ?>
<script src="script.js"></script>
</body>
</html>
