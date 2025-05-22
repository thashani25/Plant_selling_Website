<?php
session_start();
include 'conection.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add to Cart (same as before)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $qty = 1; // Fixed quantity
    
    // Fetch product from DB
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

// Handle Remove item
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

// Handle Quantity Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_qty'])) {
    // $_POST['quantities'] is expected as an array: product_id => qty
    foreach ($_POST['quantities'] as $prod_id => $qty) {
        $qty = (int)$qty;
        if ($qty < 1) $qty = 1; // minimum 1

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $prod_id) {
                $item['qty'] = $qty;
                break;
            }
        }
        unset($item);
    }
    header("Location: cart.php?message=Cart updated successfully");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Shopping Cart</title>
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
        <form method="post" action="cart.php">
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
                <tr>
                    <td><img src="<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>"></td>
                    <td><?= htmlspecialchars($item['name']); ?></td>
                    <td><?= number_format($item['price'], 2); ?></td>
                    <td>
                        <input type="number" name="quantities[<?= $item['id']; ?>]" class="qty-input" value="<?= $item['qty']; ?>" min="1" max="99" />
                    </td>
                    <td><?= number_format($subtotal, 2); ?></td>
                    <td><a href="cart.php?remove=<?= $item['id']; ?>" class="remove-btn" onclick="return confirm('Remove this item?');">X</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align:right;"><strong>Total:</strong></td>
                    <td colspan="2"><strong>Rs. <?= number_format($total, 2); ?></strong></td>
                </tr>
            </tfoot>
        </table>
        <div style="text-align:center;">
            <button type="submit" name="update_qty" class="update-btn">Update Cart</button>
        </div>
        </form>

        <div style="text-align:center; margin-top:20px;">
            <a href="view_product.php" style="padding:10px 20px; background:#4caf50; color:#fff; border-radius:6px; text-decoration:none;">Continue Shopping</a>
            <a href="order.php" style="padding:10px 20px; background:#2196F3; color:#fff; border-radius:6px; text-decoration:none; margin-left:10px;">order</a>
        </div>

    <?php else: ?>
        <p style="text-align:center;">Your cart is empty. 
              <a href="view_product.php">Go to shop</a></p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
