<?php
include 'conection.php';
session_start();
$user_id = $_SESSION['user_id'] ?? null;

if (!isset($_GET['pid'])) {
    header("Location: view_product.php");
    exit;
}

$product_id = intval($_GET['pid']);
$stmt = $conn->prepare("SELECT * FROM iew_products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Product not found.";
    exit;
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?> - Green Cactus</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .product-detail-container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
            text-align: center;
        }
        .product-detail img {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }
        .action-row {
            margin-top: 20px;
        }
        .action-row a,
        .action-row button {
            margin: 10px;
            padding: 10px 20px;
            text-decoration: none;
            border: none;
            background: #28a745;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .action-row a:hover,
        .action-row button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <div class="product-detail-container">
        <div class="product-detail">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <p><strong>Price:</strong> Rs. <?= number_format($product['price'], 2) ?></p>
           <p><?= (htmlspecialchars($product['description'])) ?></p>


            <div class="action-row">
                <!-- Add to Cart -->
                <form action="cart.php" method="post" style="display:inline;">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit" name="add_to_cart">
                        <i class="bx bx-cart"></i> Add to Cart
                    </button>
                </form>

                <!-- Add to Wishlist -->
                <a href="wishlist.php?product_id=<?= $product['id'] ?>">
                    <i class="bx bx-heart"></i> Add to Wishlist
                </a>

                <!-- Back to Shop -->
                <a href="view_product.php" style="background-color: #007bff;">
                    <i class="bx bx-arrow-back"></i> Back to Shop
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="script.js"></script>
</body>
</html>
