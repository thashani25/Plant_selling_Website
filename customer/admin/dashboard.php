<!-- admin_dashboard.php -->
<?php session_start(); ?>
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
    <h1>Welcome, Admin!</h1>

    <div class="card">
        <h3>Overview</h3>
        <p>Total Products: 100</p>
        <p>Total Orders: 75</p>
        <p>Total Users: 25</p>
    </div>

    <div class="card">
        <h3>Recent Orders</h3>
        <p>Order #1023 - Pending</p>
        <p>Order #1022 - Shipped</p>
        <p>Order #1021 - Delivered</p>
    </div>
</div>

</body>
</html>
