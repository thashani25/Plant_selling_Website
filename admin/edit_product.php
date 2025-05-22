<?php
session_start();
include 'conection.php';

// Get product ID from URL
if (!isset($_GET['id'])) {
    header('Location: admin_products.php');
    exit();
}

$id = intval($_GET['id']);
$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    
    // Handle optional image upload
    if (!empty($_FILES['image']['name'])) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
        $conn->query("UPDATE products SET name='$name', price=$price, image='$image' WHERE id = $id");
    } else {
        $conn->query("UPDATE products SET name='$name', price=$price WHERE id = $id");
    }

    header('Location: admin_products.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - Green Cactus</title>
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
    <h1>Edit Product</h1>
    <form method="POST" enctype="multipart/form-data" class="form-box">
        <label>Product Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

        <label>Price (Rs.):</label>
        <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required>

        <label>Current Image:</label><br>
        <img src="<?= htmlspecialchars($product['image']) ?>" width="120"><br><br>

        <label>Change Image (optional):</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit" class="btn">Update Product</button>
        <a href="admin_products.php" class="btn-back">Cancel</a>
    </form>
</div>

</body>
</html>
