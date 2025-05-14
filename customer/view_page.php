<?php 
include 'conection.php';
session_start();

// Check if user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['qty'];

    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($price);
    $stmt->fetch();
    $stmt->close();

    $total_price = $price * $quantity;

    $check = $conn->prepare("SELECT id FROM cart WHERE user_id = ? AND product_id = ?");
    $check->bind_param("ii", $user_id, $product_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $update = $conn->prepare("UPDATE cart SET quantity = quantity + ?, total_price = total_price + ? WHERE user_id = ? AND product_id = ?");
        $update->bind_param("idii", $quantity, $total_price, $user_id, $product_id);
        $update->execute();
    } else {
        $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
        $insert->bind_param("iiid", $user_id, $product_id, $quantity, $total_price);
        $insert->execute();
    }

    header("Location: cart_page.php");
    exit;
}

// Handle Add to Wishlist
if (isset($_POST['add_to_wishlist'])) {
    $product_id = (int)$_POST['product_id'];

    $check = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
    $check->bind_param("ii", $user_id, $product_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows == 0) {
        $insert = $conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
        $insert->bind_param("ii", $user_id, $product_id);
        $insert->execute();
    }

    header("Location: wishlist_page.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Green Cafee - Product Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>Product Details</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a> <span>/ Product Details</span>
    </div>

    <section class="view_page">
        <?php
        $product_id = isset($_GET['pid']) ? (int)$_GET['pid'] : 0;

        // Track product view
        if ($user_id && $product_id) {
            $product_stmt = $conn->prepare("INSERT INTO products (user_id, product_id) VALUES (?, ?)");
            if ($product_stmt === false) {
                die("Prepare failed: " . $conn->error);
            }
            $product_stmt->bind_param("ii", $user_id, $product_id);
            if (!$product_stmt->execute()) {
                die("Execute failed: " . $product_stmt->error);
            }
        }

        // Get product details
        $stmt = $conn->prepare("SELECT * FROM iew_products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        if ($product):
        ?>
        <form method="post">
            <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="Product Image" width="300">
            <div class="details">
                <div class="price">Rs. <?= number_format($product['price'], 2) ?></div>
                <div class="name"><?= htmlspecialchars($product['name']) ?></div>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="qty" value="1">
                <div class="button">
                    <button type="submit" name="add_to_wishlist" class="btn">Add to Wishlist <i class="bx bx-heart"></i></button>
                    <button type="submit" name="add_to_cart" class="btn">Add to Cart <i class="bx bx-cart"></i></button>
                </div>
            </div>
        </form>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>
    </section>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include 'alert.php'; ?>

</body>
</html>
