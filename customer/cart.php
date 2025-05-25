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
        'total' => number_format($total, 2)
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
    $qty = 1;

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

        header("Location: cart.php?message=Added to cart successfully");
        exit;
    } else {
        header("Location: cart.php?message=Product not found");
        exit;
    }
}

// Handle Remove
if (isset($_GET['remove'])) {
    $remove_id = (int)$_GET['remove'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $remove_id) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            header("Location: cart.php?message=Item removed from cart");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Green Cactus - cart page</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <h1 style="text-align:center;">Your Cart</h1>

    <?php if (isset($_GET['message'])): ?>
        <div class="message"><?= htmlspecialchars($_GET['message']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['cart'])): ?>
        <form id="cartForm">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price (Rs.)</th>
                    <th>Quantity</th>
                    <th>Subtotal (Rs.)</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $item):
                    $subtotal = $item['price'] * $item['qty'];
                    $total += $subtotal;
                ?>
                <tr data-id="<?= $item['id']; ?>">
                    <td><img src="<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>" width="80"></td>
                    <td><?= htmlspecialchars($item['name']); ?></td>
                    <td><?= number_format($item['price'], 2); ?></td>
                    <td>
                        <input type="number" class="qty-input" value="<?= $item['qty']; ?>" min="1" max="99" />
                    </td>
                    <td class="subtotal"><?= number_format($subtotal, 2); ?></td>
                    <td><a href="cart.php?remove=<?= $item['id']; ?>" onclick="return confirm('Remove this item?');">X</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align:right;"><strong>Total:</strong></td>
                    <td colspan="2"><strong>Rs. <span id="cartTotal"><?= number_format($total, 2); ?></span></strong></td>
                </tr>
            </tfoot>
        </table>
        </form>

        <div style="text-align:center; margin-top:20px;">
            <a href="view_product.php" style="padding:10px 20px; background:#4caf50; color:#fff; border-radius:6px; text-decoration:none;">Continue Shopping</a>
            <a href="order.php" style="padding:10px 20px; background:#2196F3; color:#fff; border-radius:6px; text-decoration:none; margin-left:10px;">Order</a>
        </div>
    <?php else: ?>
        <p style="text-align:center;">Your cart is empty. <a href="view_product.php">Go to shop</a></p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

<!-- AJAX Script -->
<script>
document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('change', function () {
        const tr = this.closest('tr');
        const productId = tr.getAttribute('data-id');
        const qty = this.value;

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
            } else {
                alert("Failed to update cart.");
            }
        });
    });
});
</script>

</body>
</html>
