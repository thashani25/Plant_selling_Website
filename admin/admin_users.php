<?php
session_start();
include 'conection.php';

// Handle user deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM register WHERE id = $id");
    header("Location: admin_users.php");
    exit();
}

// Fetch all users
$result = $conn->query("SELECT * FROM register ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Users - Green Cactus</title>
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
    <a href="admin_orders.php"><i class='bx bx-cart'></i> Orders</a>
    <a href="admin_users.php" class="active"><i class='bx bx-user'></i> Users</a>
    <a href="logout.php"><i class='bx bx-log-out'></i> Logout</a>
</div>

<div class="main">
    <h1>Manage Users</h1>

    <table class="product-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Registered At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= $row['created_at'] ?></td>
                <td>
                    <a href="admin_users.php?delete=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
