<?php
session_start();
include 'conection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    $image = '';

    // Image Upload Handling
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . '_' . basename($_FILES["image"]["name"]);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $imageName;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = $targetFile;
        }
    }

    if ($name && $price && $image) {
        $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $name, $price, $image);
        $stmt->execute();
        $stmt->close();
        header("Location: admin_products.php");
        exit();
    } else {
        $error = "Please fill in all fields and upload an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Admin Panel</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style><?php include 'style.css'; ?></style>
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
    <h1>Add New Product</h1>

    <div class="form-box">
        <?php if (isset($error)): ?>
            <p style="color:red"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Product Name</label>
            <input type="text" name="name" required>

            <label>Product Price (Rs.)</label>
            <input type="number" name="price" step="0.01" required>

            <label>Product Image</label>
            <input type="file" name="image" accept="image/*" required>

            <button type="submit" class="btn">Add Product</button>
            <a href="admin_products.php" class="btn-back">Cancel</a>
        </form>
    </div>
</div>

</body>
</html>
