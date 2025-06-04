<?php
session_start();
include 'conection.php';

// Handle AJAX quantity update directly
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_update'])) {
    $product_id = (int)$_POST['product_id'];
    $qty = max(1, (int)$_POST['qty']);
    $subtotal = 0;
    $total = 0;

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            $item['qty'] = $qty;
            $subtotal = $item['price'] * $qty;
        }
        $total += $item['price'] * $item['qty'];
    }
    unset($item);

    echo json_encode([
        'success' => true,
        'subtotal' => number_format($subtotal, 2),
        'total' => number_format($total, 2),
        'message' => 'Cart updated successfully!'
    ]);
    exit;
}

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $qty = isset($_POST['qty']) ? max(1, (int)$_POST['qty']) : 1;

    $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $found = false;

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id) {
                $item['qty'] += $qty;
                $found = true;
                break;
            }
        }
        unset($item);

        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'qty' => $qty
            ];
        }

        $message = urlencode("✓ " . $product['name'] . " has been added to your cart successfully!");
        header("Location: cart.php?success=" . $message);
        exit;
    } else {
        $error = urlencode("❌ Product not found. Please try again.");
        header("Location: cart.php?error=" . $error);
        exit;
    }
}

// Handle Remove
if (isset($_GET['remove'])) {
    $remove_id = (int)$_GET['remove'];
    $removed_item_name = '';
    
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $remove_id) {
            $removed_item_name = $item['name'];
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            break;
        }
    }
    
    if ($removed_item_name) {
        $message = urlencode("✓ " . $removed_item_name . " has been removed from your cart.");
        header("Location: cart.php?success=" . $message);
    } else {
        $error = urlencode("❌ Item not found in cart.");
        header("Location: cart.php?error=" . $error);
    }
    exit;
}

// Handle Clear Cart
if (isset($_GET['clear_cart'])) {
    $_SESSION['cart'] = [];
    $message = urlencode("✓ Your cart has been cleared successfully!");
    header("Location: cart.php?success=" . $message);
    exit;
}

// Calculate cart totals
$cart_total = 0;
$cart_items_count = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_total += $item['price'] * $item['qty'];
        $cart_items_count += $item['qty'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Cactus - Shopping Cart</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        .message {
            padding: 12px 20px;
            margin: 15px 0;
            border-radius: 6px;
            text-align: center;
            font-weight: 500;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .cart-actions {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 0 8px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: #4caf50;
            color: #fff;
        }
        .btn-primary:hover {
            background: #45a049;
        }
        .btn-secondary {
            background: #2196F3;
            color: #fff;
        }
        .btn-secondary:hover {
            background: #1976D2;
        }
        .btn-danger {
            background: #f44336;
            color: #fff;
        }
        .btn-danger:hover {
            background: #d32f2f;
        }
        .cart-summary {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .ajax-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #4caf50;
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
            display: none;
            z-index: 1000;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <h1 style="text-align:center;">🛒 Your Shopping Cart</h1>

    <!-- Success Messages -->
    <?php if (isset($_GET['success'])): ?>
        <div class="message success-message">
            <?= htmlspecialchars(urldecode($_GET['success'])); ?>
        </div>
    <?php endif; ?>

    <!-- Error Messages -->
    <?php if (isset($_GET['error'])): ?>
        <div class="message error-message">
            <?= htmlspecialchars(urldecode($_GET['error'])); ?>
        </div>
    <?php endif; ?>

    <!-- Legacy message support -->
    <?php if (isset($_GET['message'])): ?>
        <div class="message success-message">
            <?= htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>

    <!-- AJAX Message Container -->
    <div id="ajaxMessage" class="ajax-message"></div>

    <?php if (!empty($_SESSION['cart'])): ?>
        <!-- Cart Summary -->
        <div class="cart-summary">
            <p><strong>Cart Summary:</strong> <?= $cart_items_count; ?> item(s) - Total: Rs. <?= number_format($cart_total, 2); ?></p>
        </div>

        <form id="cartForm">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f5f5f5;">
                    <th style="padding: 12px; border: 1px solid #ddd;">Image</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Product</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Price (Rs.)</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Quantity</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Subtotal (Rs.)</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $item):
                    $subtotal = $item['price'] * $item['qty'];
                    $total += $subtotal;
                ?>
                <tr data-id="<?= $item['id']; ?>" style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px; text-align: center;">
                        <img src="<?= htmlspecialchars($item['image']); ?>" 
                             alt="<?= htmlspecialchars($item['name']); ?>" 
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                    </td>
                    <td style="padding: 12px; font-weight: 500;">
                        <?= htmlspecialchars($item['name']); ?>
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        <?= number_format($item['price'], 2); ?>
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        <input type="number" 
                               class="qty-input" 
                               value="<?= $item['qty']; ?>" 
                               min="1" 
                               max="99" 
                               style="width: 60px; padding: 5px; text-align: center; border: 1px solid #ddd; border-radius: 4px;" />
                    </td>
                    <td class="subtotal" style="padding: 12px; text-align: center; font-weight: 500;">
                        <?= number_format($subtotal, 2); ?>
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        <a href="cart.php?remove=<?= $item['id']; ?>" 
                           onclick="return confirm('Are you sure you want to remove <?= htmlspecialchars($item['name']); ?> from your cart?');"
                           style="color: #f44336; font-weight: bold; text-decoration: none; font-size: 16px;">
                           ❌
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="background: #f9f9f9; font-weight: bold;">
                    <td colspan="4" style="padding: 15px; text-align: right; font-size: 16px;">
                        <strong>Grand Total:</strong>
                    </td>
                    <td colspan="2" style="padding: 15px; text-align: center; font-size: 18px; color: #4caf50;">
                        <strong>Rs. <span id="cartTotal"><?= number_format($total, 2); ?></span></strong>
                    </td>
                </tr>
            </tfoot>
        </table>
        </form>

        <div class="cart-actions">
            <a href="view_product.php" class="btn btn-primary">🛍️ Continue Shopping</a>
            <a href="order.php" class="btn btn-secondary">📦 Proceed to Checkout</a>
            <a href="cart.php?clear_cart=1" 
               class="btn btn-danger" 
               onclick="return confirm('Are you sure you want to clear your entire cart? This action cannot be undone.');">
               🗑️ Clear Cart
            </a>
        </div>

    <?php else: ?>
        <div style="text-align: center; padding: 60px 20px;">
            <h2 style="color: #666; margin-bottom: 20px;">🛒 Your cart is empty</h2>
            <p style="color: #888; margin-bottom: 30px;">Discover our amazing products and start shopping!</p>
            <a href="view_product.php" class="btn btn-primary">🌵 Start Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

<!-- Enhanced AJAX Script -->
<script>
function showAjaxMessage(message, type = 'success') {
    const messageDiv = document.getElementById('ajaxMessage');
    messageDiv.textContent = message;
    messageDiv.style.background = type === 'success' ? '#4caf50' : '#f44336';
    messageDiv.style.display = 'block';
    
    setTimeout(() => {
        messageDiv.style.display = 'none';
    }, 3000);
}

document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('change', function () {
        const tr = this.closest('tr');
        const productId = tr.getAttribute('data-id');
        const qty = this.value;
        const originalValue = this.defaultValue;

        // Disable input during update
        this.disabled = true;

        fetch('cart.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `ajax_update=1&product_id=${productId}&qty=${qty}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                tr.querySelector('.subtotal').textContent = data.subtotal;
                document.getElementById('cartTotal').textContent = data.total;
                this.defaultValue = qty; // Update default value
                showAjaxMessage(data.message || 'Cart updated successfully!', 'success');
                
                // Update cart summary
                updateCartSummary();
            } else {
                this.value = originalValue; // Restore original value
                showAjaxMessage('Failed to update cart. Please try again.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.value = originalValue; // Restore original value
            showAjaxMessage('Network error. Please check your connection.', 'error');
        })
        .finally(() => {
            this.disabled = false; // Re-enable input
        });
    });
});

function updateCartSummary() {
    // Recalculate total items and amount
    let totalItems = 0;
    let totalAmount = 0;
    
    document.querySelectorAll('.qty-input').forEach(input => {
        totalItems += parseInt(input.value);
    });
    
    const cartTotalText = document.getElementById('cartTotal').textContent;
    
    // Update cart summary if it exists
    const summaryElement = document.querySelector('.cart-summary p');
    if (summaryElement) {
        summaryElement.innerHTML = `<strong>Cart Summary:</strong> ${totalItems} item(s) - Total: Rs. ${cartTotalText}`;
    }
}

// Add loading animation for better UX
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth transitions
    const style = document.createElement('style');
    style.textContent = `
        .qty-input:disabled {
            opacity: 0.6;
            cursor: wait;
        }
        tr {
            transition: background-color 0.2s ease;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
    `;
    document.head.appendChild(style);
});
</script>

</body>
</html>