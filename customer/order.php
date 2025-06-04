<?php
session_start();
include 'conection.php'; // replace with your actual DB connection file

$remove_message = '';

// Handle removal of cart item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'], $_POST['remove_key'])) {
    $key = $_POST['remove_key'];
    if (isset($_SESSION['cart'][$key])) {
        $removed_item_name = $_SESSION['cart'][$key]['name'];
        unset($_SESSION['cart'][$key]);
        // Re-index array keys
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        $remove_message = "<div class='remove-success-box'>
                <i class='bx bx-check-circle'></i>
                <span><strong>" . htmlspecialchars($removed_item_name) . "</strong> has been removed from your cart.</span>
            </div>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Cactus - Order Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style type="text/css">
        <?php include 'style.css'; ?>

        /* Professional Order Page Styles - Matching Shop Page */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: #f8faf9;
            color: #333;
        }

        /* Main Container */
        .main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Banner Section - Matching Shop Page */
        .banner {
            background-image: url('img/banner.jpg');
            color: white;
            text-align: center;
            padding: 80px 0;
            margin-bottom: 30px;
            border-radius: 15px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(45,80,22,0.3);
        }

        .banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 70%, rgba(255,255,255,0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .banner h1 {
            font-size: 4rem;
            font-weight: 500;
            text-shadow: 0 4px 8px rgba(0,0,0,0.3);
            position: relative;
            z-index: 2;
            letter-spacing: 2px;
        }

        /* Breadcrumb - Matching Shop Page */
        .title2 {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            margin-bottom: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border-left: 4px solid #4a7c59;
        }

        .title2 a {
            color: #4a7c59;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .title2 a:hover {
            color: #2d5016;
            text-decoration: underline;
        }

        .title2 span {
            color: #666;
            margin-left: 5px;
        }

        /* Section Header */
        .products {
            margin-bottom: 40px;
        }

        .products .title {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 1px solid #e8f5e8;
            margin-bottom: 30px;
        }

        .products .title .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(45,80,22,0.2);
        }

        .products .title h1 {
            color: #2d5016;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .products .title p {
            color: #4a7c59;
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Message Boxes */
        .remove-success-box, .success-box {
            background: linear-gradient(135deg, #4caf50, #66bb6a);
            color: white;
            padding: 20px 25px;
            margin: 20px 0;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 8px 25px rgba(76,175,80,0.3);
            animation: slideIn 0.5s ease-out;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .success-box {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }

        .success-box h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .remove-success-box i {
            font-size: 24px;
            color: #fff;
        }

        .error-box {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            color: white;
            padding: 20px 25px;
            margin: 20px 0;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(220,53,69,0.3);
            border: 1px solid rgba(255,255,255,0.2);
        }

        /* Cart Summary - Professional Style */
        .cart-summ, .order-history {
            background: white;
            padding: 30px;
            border-radius: 20px;
            margin: 30px 0;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 1px solid #e8f5e8;
            position: relative;
            overflow: hidden;
        }

        .cart-summ::before, .order-history::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4a7c59, #2d5016);
        }

        .cart-summ h3, .order-history h3 {
            color: #2d5016;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cart-summ h3::before {
            content: '🛒';
            font-size: 1.5rem;
        }

        .order-history h3::before {
            content: '📋';
            font-size: 1.5rem;
        }

        /* Table Styles */
        .cart-table, .order-history table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .cart-table th, .cart-table td,
        .order-history th, .order-history td {
            padding: 15px 12px;
            text-align: center;
            border-bottom: 1px solid #e8f5e8;
        }

        .cart-table th, .order-history th {
            background: linear-gradient(135deg, #4a7c59,rgb(114, 190, 63));
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
        }

        .cart-table tbody tr, .order-history tbody tr {
            transition: all 0.3s ease;
        }

        .cart-table tbody tr:hover, .order-history tbody tr:hover {
            background: #f8faf9;
            transform: translateX(2px);
        }

        .cart-table tfoot td {
            background: #f8faf9;
            font-weight: 700;
            font-size: 1.1rem;
            color:rgb(117, 167, 83);
        }

        /* Remove Button */
        .remove-btn {
            background: linear-gradient(135deg, #dc3545, #c82333) !important;
            color: white !important;
            border: none !important;
            padding: 8px 15px !important;
            border-radius: 8px !important;
            cursor: pointer !important;
            font-size: 0.85rem !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
        }

        .remove-btn:hover {
            background: linear-gradient(135deg, #c82333, #bd2130) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 15px rgba(220,53,69,0.4) !important;
        }

        /* Empty Cart Style */
        .empty-cart {
            text-align: center;
            padding: 60px 40px;
            background: #f8faf9;
            border-radius: 15px;
            border: 2px dashed #4a7c59;
        }

        .empty-cart i {
            font-size: 64px;
            color: #4a7c59;
            margin-bottom: 20px;
            opacity: 0.7;
        }

        .empty-cart p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 25px;
        }

        /* Button Styles */
        .btn {
            background: linear-gradient(135deg, #4a7c59, #2d5016);
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(45,80,22,0.3);
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: linear-gradient(135deg, #2d5016, #1a3009);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(45,80,22,0.4);
        }

        .btn i {
            font-size: 1.2rem;
        }

        /* Checkout Button Special Style */
        .checkout-section {
            text-align: center;
            margin: 40px 0;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 1px solid #e8f5e8;
        }

        /* Cancel Link */
        .cancel-link {
            color: #dc3545;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }

        .cancel-link:hover {
            color: #c82333;
            transform: translateX(2px);
        }

        .expired-text {
            color: #6c757d;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Animations */
        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cart-summ, .order-history {
            animation: fadeInUp 0.6s ease;
        }

        /* Auto-hide message */
        .remove-success-box {
            animation: slideIn 0.5s ease-out, fadeOut 0.5s ease-out 4.5s forwards;
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .banner {
                padding: 60px 20px;
                margin: 0 -20px 30px;
                border-radius: 0;
            }

            .banner h1 {
                font-size: 2.5rem;
            }

            .title2 {
                margin: 0 -20px 30px;
                border-radius: 0;
                border-left: none;
                border-top: 4px solid #4a7c59;
            }

            .cart-summ, .order-history {
                margin: 20px -20px;
                border-radius: 0;
                padding: 20px;
            }

            .products .title {
                margin: 0 -20px 20px;
                border-radius: 0;
                padding: 30px 20px;
            }

            .products .title h1 {
                font-size: 2rem;
            }

            .cart-table th, .cart-table td,
            .order-history th, .order-history td {
                padding: 10px 8px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .banner h1 {
                font-size: 2rem;
            }

            .products .title h1 {
                font-size: 1.5rem;
            }

            .cart-table, .order-history table {
                font-size: 0.8rem;
            }

            .cart-table th, .cart-table td,
            .order-history th, .order-history td {
                padding: 8px 5px;
            }

            .btn {
                padding: 12px 25px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>My Order</h1>
    </div>
    
    <div class="title2">
        <a href="home.php">Home</a><span> / Order</span>
    </div>
    
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
    <?= $remove_message; ?>

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
                        <td style="text-align: left;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width:50px; height:50px; border-radius: 8px; object-fit: cover;">
                                <span style="font-weight: 600; color: #2d5016;"><?= htmlspecialchars($item['name']) ?></span>
                            </div>
                        </td>
                        <td><span style="background: #4a7c59; color: white; padding: 5px 10px; border-radius: 15px; font-weight: 600;"><?= $item['qty'] ?></span></td>
                        <td style="font-weight: 600; color: #4a7c59;"><?= number_format($item['price'], 2) ?></td>
                        <td style="font-weight: 700; color: #2d5016;"><?= number_format($subtotal, 2) ?></td>
                        <td>
                            <form method="post" style="margin:0;">
                                <input type="hidden" name="remove_key" value="<?= $key ?>">
                                <button type="submit" name="remove_item" class="remove-btn" onclick="return confirm('Are you sure you want to remove this item from your cart?');">
                                    <i class='bx bx-trash'></i> Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right; font-weight: bold; font-size: 1.2rem;">
                            <strong>Total Amount:</strong>
                        </td>
                        <td style="font-weight: bold; font-size: 1.2rem; color: #2d5016;">
                            <strong>Rs. <?= number_format($total, 2) ?></strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        <?php else: ?>
            <div class="empty-cart">
                <i class='bx bx-cart'></i>
                <p>Your cart is empty.</p>
                <a href="products.php" class="btn">
                    <i class='bx bx-shopping-bag'></i>
                    Continue Shopping
                </a>
            </div>
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
                        <tr>
                            <th>Order ID</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Placed</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $orders->fetch_assoc()): 
                            $order_time = strtotime($row['created_at']);
                            $now = time();
                            $diff_days = floor(($now - $order_time) / (60 * 60 * 24));
                        ?>
                        <tr>
                            <td style="font-weight: 600; color: #2d5016;">#<?= $row['id'] ?></td>
                            <td style="font-weight: 600; color: #4a7c59;">Rs. <?= number_format($row['total'], 2) ?></td>
                            <td>
                                <span style="background: #e8f5e8; color: #2d5016; padding: 4px 8px; border-radius: 10px; font-size: 0.85rem; font-weight: 600;">
                                    <?= htmlspecialchars($row['payment_method']) ?>
                                </span>
                            </td>
                            <td style="color: #666; font-weight: 500;"><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
                            <td>
                                <?php if ($diff_days <= 3): ?>
                                    <a href="cancel_order.php?id=<?= $row['id'] ?>" onclick="return confirm('Cancel this order?');" class="cancel-link">
                                        <i class='bx bx-x-circle'></i> Cancel
                                    </a>
                                <?php else: ?>
                                    <span class="expired-text">
                                        <i class='bx bx-time'></i> Expired
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; color: #666;">
                <i class='bx bx-receipt' style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                <p style="font-size: 1.1rem;">No previous orders found.</p>
            </div>
        <?php endif;
    } ?>
    
    <?php if (!empty($_SESSION['cart'])): ?>
        <div class="checkout-section">
            <a href="checkout.php" class="btn">
                <i class='bx bx-credit-card'></i> 
                Proceed to Checkout
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
<script src="script.js"></script>
<script>
// Auto-hide remove success message after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const removeMessage = document.querySelector('.remove-success-box');
    if (removeMessage) {
        setTimeout(function() {
            removeMessage.style.display = 'none';
        }, 5000);
    }
});

// Add smooth scrolling to cart summary after item removal
<?php if ($remove_message): ?>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.cart-summ').scrollIntoView({ 
        behavior: 'smooth',
        block: 'start'
    });
});
<?php endif; ?>
</script>
</body>
</html>