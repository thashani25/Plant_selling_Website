
<style type="text/css">
    <?php include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Green Cactus - Cart</title>
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>Add to Cart</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a><span>/ Add to Cart</span> 
    </div>

    <?php
include 'conection.php';



$success_message = '';
$error_message = '';

// Handling the add to cart functionality
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];
    
    // Get the product price
    $product_query = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $product_query->bind_param("i", $product_id);
    $product_query->execute();
    $result = $product_query->get_result();
    
    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
        $total_price = $product['price'] * $qty;

        // Check if the product already exists in the cart
        $check_cart_query = $conn->prepare("SELECT id FROM cart WHERE user_id = ? AND product_id = ?");
        $check_cart_query->bind_param("ii", $user_id, $product_id);
        $check_cart_query->execute();
        $check_result = $check_cart_query->get_result();
        
        if ($check_result->num_rows > 0) {
            // Update the existing cart item
            $update_cart_query = $conn->prepare("UPDATE cart SET quantity = quantity + ?, total_price = total_price + ? WHERE user_id = ? AND product_id = ?");
            $update_cart_query->bind_param("idii", $qty, $total_price, $user_id, $product_id);
            if ($update_cart_query->execute()) {
                $success_message = 'Product added to cart successfully!';
            } else {
                $error_message = 'Error adding to cart.';
            }
        } else {
            // Insert the new product into the cart
            $insert_cart_query = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
            $insert_cart_query->bind_param("iiid", $user_id, $product_id, $qty, $total_price);
            if ($insert_cart_query->execute()) {
                $success_message = 'Product added to cart successfully!';
            } else {
                $error_message = 'Error adding to cart.';
            }
        }
    } else {
        $error_message = 'Product not found.';
    }
}

// Get all cart items and total price for the current user
$cart_query = $conn->prepare("SELECT p.name, c.quantity, c.total_price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$cart_query->bind_param("i", $user_id);
$cart_query->execute();
$cart_result = $cart_query->get_result();

$total_amount = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Green Cactus - Cart Page</title>
</head>
<body>
<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>Your Cart</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a><span>/ Cart</span>
    </div>

    <?php
include 'conection.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php"); // Redirect to login page if user is not logged in
    exit();
}

$success_message = '';
$error_message = '';

// Handling the add to cart functionality
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];
    
    // Get the product price
    $product_query = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $product_query->bind_param("i", $product_id);
    $product_query->execute();
    $result = $product_query->get_result();
    
    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
        $total_price = $product['price'] * $qty;

        // Check if the product already exists in the cart
        $check_cart_query = $conn->prepare("SELECT id FROM cart WHERE user_id = ? AND product_id = ?");
        $check_cart_query->bind_param("ii", $user_id, $product_id);
        $check_cart_query->execute();
        $check_result = $check_cart_query->get_result();
        
        if ($check_result->num_rows > 0) {
            // Update the existing cart item
            $update_cart_query = $conn->prepare("UPDATE cart SET quantity = quantity + ?, total_price = total_price + ? WHERE user_id = ? AND product_id = ?");
            $update_cart_query->bind_param("idii", $qty, $total_price, $user_id, $product_id);
            if ($update_cart_query->execute()) {
                $success_message = 'Product added to cart successfully!';
            } else {
                $error_message = 'Error adding to cart.';
            }
        } else {
            // Insert the new product into the cart
            $insert_cart_query = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
            $insert_cart_query->bind_param("iiid", $user_id, $product_id, $qty, $total_price);
            if ($insert_cart_query->execute()) {
                $success_message = 'Product added to cart successfully!';
            } else {
                $error_message = 'Error adding to cart.';
            }
        }
    } else {
        $error_message = 'Product not found.';
    }
}

// Get all cart items and total price for the current user
$cart_query = $conn->prepare("SELECT p.name, c.quantity, c.total_price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$cart_query->bind_param("i", $user_id);
$cart_query->execute();
$cart_result = $cart_query->get_result();

$total_amount = 0;
?>
</div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

