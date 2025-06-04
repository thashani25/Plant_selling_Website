<?php
session_start();

// DB connection (make sure this file contains valid $conn connection)
include 'conection.php';

// Handle item removal
if (isset($_GET['remove_item'])) {
    $remove_index = (int)$_GET['remove_item'];
    if (isset($_SESSION['cart'][$remove_index])) {
        $removed_item_name = $_SESSION['cart'][$remove_index]['name'];
        unset($_SESSION['cart'][$remove_index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
        $_SESSION['remove_message'] = "✓ " . htmlspecialchars($removed_item_name) . " has been removed from your cart.";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle clear entire cart
if (isset($_GET['clear_cart'])) {
    $cart_count = count($_SESSION['cart']);
    unset($_SESSION['cart']);
    $_SESSION['remove_message'] = "✓ All items ($cart_count) have been removed from your cart.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['qty'];
    }
}

$errors = [];
$success_message = '';
$remove_message = '';

// Display remove message if exists
if (isset($_SESSION['remove_message'])) {
    $remove_message = $_SESSION['remove_message'];
    unset($_SESSION['remove_message']);
}

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
            // Store order ID for reference
            $order_id = $conn->insert_id;
            
            // Clear cart after successful order
            unset($_SESSION['cart']); 
            
            $success_message = "
                <div class='success-box' id='success-message'>
                    <button class='close-btn' onclick='document.getElementById(\"success-message\").style.display=\"none\"'>&times;</button>
                    <div class='success-icon'>✓</div>
                    <h3>🎉 Thank you for your order, " . htmlspecialchars($name) . "!</h3>
                    <div class='order-details'>
                        <p><strong>Order ID:</strong> #" . str_pad($order_id, 6, '0', STR_PAD_LEFT) . "</p>
                        <p><strong>Email Confirmation:</strong> Sent to " . htmlspecialchars($email) . "</p>
                        <p><strong>Payment Method:</strong> " . htmlspecialchars($payment_method) . "</p>
                        <p><strong>Total Amount:</strong> Rs. " . number_format($total, 2) . "</p>
                        <p><strong>Delivery Address:</strong> " . htmlspecialchars($address) . "</p>
                    </div>
                    <div class='success-actions'>
                        <p class='delivery-info'>📦 Your order will be processed within 24 hours.</p>
                        <a href='home.php' class='btn btn-success'>Continue Shopping</a>
                    </div>
                </div>
                <script>
                    // Auto-hide success message after 10 seconds
                    setTimeout(function() {
                        var successMsg = document.getElementById('success-message');
                        if (successMsg) {
                            successMsg.style.opacity = '0';
                            successMsg.style.transform = 'translateY(-20px)';
                            setTimeout(function() {
                                successMsg.style.display = 'none';
                            }, 500);
                        }
                    }, 10000);
                    
                    // Scroll to success message
                    setTimeout(function() {
                        var successMsg = document.getElementById('success-message');
                        if (successMsg) {
                            successMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }, 300);
                </script>
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
    <title>Green Cactus - checkout page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Enhanced Success Message Styling */
        .success-box {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 2px solid #28a745;
            border-radius: 12px;
            padding: 25px;
            margin: 20px 0;
            position: relative;
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.15);
            animation: successSlideIn 0.6s ease-out;
            transition: all 0.5s ease;
        }

        .success-box .success-icon {
            background: #28a745;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            margin: 0 auto 15px;
            animation: successPulse 1.5s infinite;
        }

        .success-box h3 {
            color: #155724;
            text-align: center;
            margin: 15px 0 20px;
            font-size: 1.4em;
            font-weight: bold;
        }

        .success-box .order-details {
            background: rgba(255, 255, 255, 0.7);
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }

        .success-box .order-details p {
            margin: 8px 0;
            color: #155724;
            font-size: 14px;
        }

        .success-box .success-actions {
            text-align: center;
            margin-top: 20px;
        }

        .success-box .delivery-info {
            color: #0c5460;
            font-style: italic;
            margin-bottom: 15px;
        }

        .success-box .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 24px;
            color: #155724;
            cursor: pointer;
            font-weight: bold;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .success-box .close-btn:hover {
            background: rgba(21, 87, 36, 0.1);
            transform: scale(1.1);
        }

        .btn-success {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        /* Remove Message Styling */
        .remove-message {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 8px;
            padding: 12px 20px;
            margin: 20px 0;
            color: #856404;
            font-weight: 500;
            animation: fadeInOut 0.5s ease-in;
            position: relative;
        }

        .remove-message .close-remove {
            position: absolute;
            top: 8px;
            right: 15px;
            background: none;
            border: none;
            font-size: 18px;
            color: #856404;
            cursor: pointer;
            font-weight: bold;
        }

        /* Remove button styling */
        .remove-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .remove-btn:hover {
            background: #c82333;
            transform: scale(1.05);
        }

        .clear-cart-btn {
            background: #6c757d;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .clear-cart-btn:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }

        /* Cart table enhancements */
        .cart-summary-table td {
            vertical-align: middle;
            padding: 10px;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-info img {
            border-radius: 4px;
        }

        @keyframes successSlideIn {
            from {
                opacity: 0;
                transform: translateY(-30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes successPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Enhanced Error Box */
        .error-box {
            background: #f8d7da;
            border: 2px solid #dc3545;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            color: #721c24;
        }

        .error-box ul {
            margin: 0;
            padding-left: 20px;
        }

        .error-box li {
            margin: 5px 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .success-box {
                margin: 15px 0;
                padding: 20px 15px;
            }
            
            .success-box h3 {
                font-size: 1.2em;
            }
            
            .success-box .success-icon {
                width: 40px;
                height: 40px;
                font-size: 20px;
            }

            .product-info {
                flex-direction: column;
                text-align: center;
            }

            .remove-btn {
                margin-top: 5px;
            }
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

        <?php if ($remove_message): ?>
            <div class="remove-message" id="remove-message">
                <?= $remove_message ?>
                <button class="close-remove" onclick="document.getElementById('remove-message').style.display='none'">&times;</button>
            </div>
            <script>
                // Auto-hide remove message after 5 seconds
                setTimeout(function() {
                    var removeMsg = document.getElementById('remove-message');
                    if (removeMsg) {
                        removeMsg.style.opacity = '0';
                        setTimeout(function() {
                            removeMsg.style.display = 'none';
                        }, 300);
                    }
                }, 5000);
            </script>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <h4>⚠️ Please fix the following errors:</h4>
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?= $e ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!$success_message): // Only show cart and form if order hasn't been placed ?>
        <div class="cart-summary-box">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3>Cart Summary</h3>
                <?php if (!empty($_SESSION['cart'])): ?>
                    <a href="?clear_cart=1" class="clear-cart-btn" onclick="return confirm('Are you sure you want to clear your entire cart?')">🗑️ Clear Cart</a>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($_SESSION['cart'])): ?>
                <table class="cart-summary-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price (Rs.)</th>
                            <th>Subtotal (Rs.)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['cart'] as $index => $item):
                            $subtotal = $item['price'] * $item['qty'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td>
                                <div class="product-info">
                                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="50">
                                    <span><?= htmlspecialchars($item['name']) ?></span>
                                </div>
                            </td>
                            <td><?= $item['qty'] ?></td>
                            <td><?= number_format($item['price'], 2) ?></td>
                            <td><?= number_format($subtotal, 2) ?></td>
                            <td>
                                <a href="?remove_item=<?= $index ?>" class="remove-btn" onclick="return confirm('Remove <?= htmlspecialchars($item['name']) ?> from cart?')">
                                    🗑️ Remove
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align:right;"><strong>Total:</strong></td>
                            <td><strong>Rs. <?= number_format($total, 2) ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            <?php else: ?>
                <div style="text-align: center; padding: 40px;">
                    <p style="font-size: 18px; color: #666;">🛒 Your cart is empty</p>
                    <a href="home.php" class="btn-success" style="margin-top: 15px;">Continue Shopping</a>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($_SESSION['cart'])): ?>
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
                    <option value="Cash" <?= (isset($_POST['payment_method']) && $_POST['payment_method'] == 'Cash') ? 'selected' : '' ?>>Cash on Delivery</option>
                </select>

                <button type="submit" class="btn">Place Order</button>   
                <a href="home.php"><i class="fa-solid fa-house"></i></a>

            </form>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="script.js"></script>
</body>
</html>