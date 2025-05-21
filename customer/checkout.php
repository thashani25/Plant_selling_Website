<?php
session_start();
include 'conection.php';

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<h3>Your cart is empty.</h3>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $total = 0;

    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    $user_id = 1; // Change to dynamic user ID if available
    $email = ''; // Add email if needed
    $method = 'Cash on Delivery';

    $insert_order = "INSERT INTO orders (user_id, number, email, method, address, total_price) 
                     VALUES ('$user_id', '$phone', '$email', '$method', '$address', '$total')";

    if (mysqli_query($con, $insert_order)) {
        $order_id = mysqli_insert_id($con);

        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $total_price = $item['price'] * $item['quantity'];

            $insert_item = "INSERT INTO cart (user_id, product_id, quantity, total_price) 
                            VALUES ('$user_id', '$product_id', '$quantity', '$total_price')";
            mysqli_query($con, $insert_item);
        }

        unset($_SESSION['cart']);
        echo "<script>alert('Order placed successfully!'); window.location.href='home.php';</script>";
        exit();
    } else {
        echo "<p>Error placing order: " . mysqli_error($con) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Green Cafee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="main">
    <div class="banner"><h1>Checkout Summary</h1></div>
    <div class="title2"><a href="home.php">Home</a><span> / Checkout Summary</span></div>

    <div class="checkout-container">
        <form method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <textarea name="address" placeholder="Delivery Address" required></textarea>
            <button type="submit">Place Order</button>
        </form>

        <h3>Cart Summary</h3>
        <ul>
            <?php
            $grand_total = 0;
            foreach ($_SESSION['cart'] as $item) {
                $sub_total = $item['price'] * $item['quantity'];
                $grand_total += $sub_total;
                echo "<li>{$item['name']} - Rs. {$item['price']} x {$item['quantity']} = Rs. $sub_total</li>";
            }
            echo "<strong>Total: Rs. $grand_total</strong>";
            ?>
        </ul>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="script.js"></script>
</body>
</html>
