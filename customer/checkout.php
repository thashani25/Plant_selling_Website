<?php
include 'conection.php';
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$user_id = $_SESSION['user_id'] ?? 0;
$grand_total = 0;

// Remove item from cart
if (isset($_POST['remove_item'])) {
    $cart_id = $_POST['cart_id'];
    $delete_item = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $delete_item->bind_param("ii", $cart_id, $user_id);
    $delete_item->execute();
    header("Location: checkout.php");
    exit();
}

// Place Order Logic
if (isset($_POST['place_order'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $number = $conn->real_escape_string($_POST['number']);
    $email = $conn->real_escape_string($_POST['email']);
    $method = $conn->real_escape_string($_POST['method']);
    $address_type = $conn->real_escape_string($_POST['address_type']);
    $flat = $conn->real_escape_string($_POST['flat']);
    $street = $conn->real_escape_string($_POST['street']);
    $city = $conn->real_escape_string($_POST['city']);
    $address = "$flat, $street, $city";

    $cart_query = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $cart_query->bind_param("i", $user_id);
    $cart_query->execute();
    $cart_result = $cart_query->get_result();

    if ($cart_result->num_rows > 0) {
        $order_details = "";
        $total_price = 0;

        while ($cart = $cart_result->fetch_assoc()) {
            $product_id = $cart['product_id'];
            $quantity = $cart['quantity'];

            $product_query = $conn->prepare("SELECT * FROM products WHERE id = ?");
            $product_query->bind_param("i", $product_id);
            $product_query->execute();
            $product_result = $product_query->get_result();
            $product = $product_result->fetch_assoc();

            $sub_total = $product['price'] * $quantity;
            $total_price += $sub_total;
            $order_details .= $product['name'] . " (Qty: $quantity) - Rs. " . $product['price'] . "\n";
        }

        $insert_order = $conn->prepare("INSERT INTO orders (user_id, name, number, email, method, address, total_price, placed_on) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $insert_order->bind_param("isssssd", $user_id, $name, $number, $email, $method, $address, $total_price);
        $insert_order->execute();

        $delete_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $delete_cart->bind_param("i", $user_id);
        $delete_cart->execute();

        $success_message = "Order placed successfully! Total: Rs. " . number_format($total_price, 2);
    } else {
        $error_message = "Your cart is empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Green Cactus</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>Checkout Summary</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a><span> / Checkout Summary</span>
    </div>

    <section class="checkout">
        <div class="title2">
            <img src="img/logo.png" class="logo">
            <h1>Checkout Summary</h1>
            <p>Please review your bag and billing details.</p>
        </div>

        <?php if (!empty($success_message)): ?>
            <div class="success"><?= $success_message; ?></div>
        <?php elseif (!empty($error_message)): ?>
            <div class="error"><?= $error_message; ?></div>
        <?php endif; ?>

        <div class="row">
            <form method="post">
                <h3>Billing Details</h3>
                <div class="flex">
                    <div class="box">
                        <div class="input-field">
                            <p>Your Name <span>*</span></p>
                            <input type="text" name="name" required maxlength="50" class="input">
                        </div>
                        <div class="input-field">
                            <p>Your Number <span>*</span></p>
                            <input type="number" name="number" required maxlength="50" class="input">
                        </div>
                        <div class="input-field">
                            <p>Your Email <span>*</span></p>
                            <input type="email" name="email" required maxlength="50" class="input">
                        </div>
                        <div class="input-field">
                            <p>Payment Method <span>*</span></p>
                            <select name="method" class="input">
                                <option value="Cash on Delivery">Cash on Delivery</option>
                                <option value="Credit or Debit Card">Credit or Debit Card</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <p>Address Type <span>*</span></p>
                            <select name="address_type" class="input">
                                <option value="Home">Home</option>
                                <option value="Office">Office</option>
                            </select>
                        </div>
                    </div>
                    <div class="box">
                        <div class="input-field">
                            <p>Address Line 01 <span>*</span></p>
                            <input type="text" name="flat" required maxlength="50" class="input">
                        </div>
                        <div class="input-field">
                            <p>Address Line 02 <span>*</span></p>
                            <input type="text" name="street" required maxlength="50" class="input">
                        </div>
                        <div class="input-field">
                            <p>City Name <span>*</span></p>
                            <input type="text" name="city" required maxlength="50" class="input">
                        </div>
                    </div>
                </div>
                <button type="submit" name="place_order" class="btn">Place Order</button>
            </form>

            <div class="summary">
                <h3>My Bag</h3>
                <div class="box-container">
                <?php
                $select_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
                $select_cart->bind_param("i", $user_id);
                $select_cart->execute();
                $result_cart = $select_cart->get_result();

                if ($result_cart->num_rows > 0) {
                    while ($cart = $result_cart->fetch_assoc()) {
                        $product_id = $cart['product_id'];

                        $select_product = $conn->prepare("SELECT * FROM products WHERE id = ?");
                        $select_product->bind_param("i", $product_id);
                        $select_product->execute();
                        $product_result = $select_product->get_result();
                        $product = $product_result->fetch_assoc();

                        $sub_total = $product['price'] * $cart['quantity'];
                        $grand_total += $sub_total;
                ?>
                    <div class="flex">
                        <img src="image/<?= $product['image']; ?>" alt="<?= $product['name']; ?>">
                        <div>
                            <h3><?= $product['name']; ?></h3>
                            <p>Rs. <?= number_format($product['price'], 2); ?> x <?= $cart['quantity']; ?></p>
                            <p>Subtotal: Rs. <?= number_format($sub_total, 2); ?></p>
                            <form method="post" style="margin-top: 5px;">
                                <input type="hidden" name="cart_id" value="<?= $cart['id']; ?>">
                                <button type="submit" name="remove_item" class="btn" style="background-color:#e74c3c; color:#fff; padding:4px 10px; border:none; border-radius:4px; cursor:pointer;">Remove</button>
                            </form>
                        </div>
                    </div>
                <?php
                    }
                } else {
                    echo "<p>Your cart is empty.</p>";
                }
                ?>
                <h3 style="margin-top:15px;">Total: Rs. <?= number_format($grand_total, 2); ?></h3>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include 'alert.php'; ?>
</body>
</html>
