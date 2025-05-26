<?php
session_start();
include 'conection.php';

// Handle product deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: admin_products.php");
    exit();
}

// Fetch all products
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Products - Green Cactus</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    <?php include 'style.css'; ?>
    </style>
</head>
<body>

<div class="sidebar">
    <h2><i class='bx bx-leaf'></i> Admin Panel</h2>
    <a href="admin_dashboard.php"><i class='bx bx-home'></i> Dashboard</a>
    <a href="admin_products.php" class="active"><i class='bx bx-cube'></i> Products</a>
    <a href="admin_orders.php"><i class='bx bx-cart'></i> Orders</a>
    <a href="admin_users.php"><i class='bx bx-user'></i> Users</a>
    <a href="logout.php"><i class='bx bx-log-out'></i> Logout</a>
</div>

<div class="main">
    <h1>Manage Products</h1>

    <a href="add_product.php" class="btn">+ Add New Product</a>

    <table class="product-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price (Rs.)</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= number_format($row['price'], 2) ?></td>
                <td><img src="<?= htmlspecialchars($row['image']) ?>" width="60"></td>
                <td>
                    <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                    <a href="admin_products.php?delete=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
