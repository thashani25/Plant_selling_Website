<?php
include 'conection.php';

session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}


// Fetch total products
$product_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
$product_data = mysqli_fetch_assoc($product_result);
$total_products = $product_data['total'];

// Fetch total orders
$order_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM orders");
$order_data = mysqli_fetch_assoc($order_result);
$total_orders = $order_data['total'];

// Fetch total users
$user_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$user_data = mysqli_fetch_assoc($user_result);
$total_users = $user_data['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Green Cactus</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style type="text/css">
    <?php include 'style.css'; ?>
    </style>
</head>
<body>

<div class="sidebar">
    <h2><i class='bx bx-leaf'></i> Admin Panel</h2>
    <a href="admin_dashboard.php"><i class='bx bx-home'></i> Dashboard</a>
    <a href="admin_products.php"><i class='bx bx-cube'></i> Products</a>
    <a href="admin_orders.php"><i class='bx bx-cart'></i> Orders</a>
    <a href="admin_users.php"><i class='bx bx-user'></i> Users</a>
    <a href="logout.php"><i class='bx bx-log-out'></i> Logout</a>
</div>

<div class="main">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?>!</h1>

    <div class="card">
        <h3>Overview</h3>
        <p>Total Products: <?= $total_products ?></p>
        <p>Total Orders: <?= $total_orders ?></p>
        <p>Total Users: <?= $total_users ?></p>
    </div>

    <div class="card">
        <h3>Recent Orders</h3>
        <ul>
        <?php
        $recent_orders = mysqli_query($conn, "SELECT id, status FROM orders ORDER BY id DESC LIMIT 3");
        while ($row = mysqli_fetch_assoc($recent_orders)) {
            echo "<li>Order #{$row['id']} - " . ucfirst($row['status']) . "</li>";
        }
        ?>
        </ul>
    </div>
</div>

</body>
</html>
