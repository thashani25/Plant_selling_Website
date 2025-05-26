<?php
session_start();
include 'conection.php';

// Handle order deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM orders WHERE id = $id");
    header("Location: admin_orders.php");
    exit();
}

// Handle order acceptance
if (isset($_GET['accept'])) {
    $id = intval($_GET['accept']);
    $conn->query("UPDATE orders SET status = 'Shipped' WHERE id = $id AND status = 'Pending'");
    header("Location: admin_orders.php");
    exit();
}

// Fetch all orders
$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Orders - Green Cactus</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    <?php include 'style.css'; ?>
    </style>
</head>
<body>

<div class="sidebar">
    <h2><i class='bx bx-leaf'></i> Admin Panel</h2>
    <a href="admin_dashboard.php"><i class='bx bx-home'></i> Dashboard</a>
    <a href="admin_products.php"><i class='bx bx-cube'></i> Products</a>
    <a href="admin_orders.php" class="active"><i class='bx bx-cart'></i> Orders</a>
    <a href="admin_users.php"><i class='bx bx-user'></i> Users</a>
    <a href="logout.php"><i class='bx bx-log-out'></i> Logout</a>
</div>

<div class="main">
    <h1>Manage Orders</h1>

    <table class="product-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Total (Rs.)</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                <td><?= number_format($row['total'], 2) ?></td>
                <td><?= $row['status'] ?></td>
                <td><?= $row['created_at'] ?></td>
                <td>
                    <?php if ($row['status'] == 'Pending'): ?>
                        <a href="admin_orders.php?accept=<?= $row['id'] ?>" class="btn-edit">Accept</a>
                    <?php endif; ?>
                    <a href="admin_orders.php?delete=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure to delete this order?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
