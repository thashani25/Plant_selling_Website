<?php
session_start();
include 'conection.php';

if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

$message = '';

// Clear wishlist if requested
if (isset($_GET['clear']) && $_GET['clear'] == 1) {
    $_SESSION['wishlist'] = [];
    $message = "Wishlist cleared.";
}

// Add to wishlist if product_id is passed via GET
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Check if product already in wishlist
    $in_wishlist = false;
    foreach ($_SESSION['wishlist'] as $item) {
        if ($item['id'] == $product_id) {
            $in_wishlist = true;
            break;
        }
    }

    if (!$in_wishlist) {
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
            $_SESSION['wishlist'][] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image']
            ];
            $message = "Added to wishlist!";
        } else {
            $message = "Product not found.";
        }
    } else {
        $message = "Already in wishlist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wishlist - Green Cactus</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <style>
        .wishlist-container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
        }
        .product-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            text-align: center;
            background-color: #f9f9f9;
        }
        .product-box img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 6px;
        }
        .action-row {
            margin-top: 10px;
        }
        .btn-bar {
            margin-bottom: 20px;
            text-align: right;
        }
        .btn-bar a {
            padding: 10px 20px;
            background-color: #444;
            color: #fff;
            text-decoration: none;
            margin-left: 10px;
            border-radius: 5px;
        }
        .alert {
            background: #def;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 5px solid #3399cc;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>Your Wishlist</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a> <span>/ Wishlist</span>
    </div>

    <div class="wishlist-container">
        <?php if (!empty($message)): ?>
            <div class="alert"><?= htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="btn-bar">
            <?php if (!empty($_SESSION['wishlist'])): ?>
                <a href="wishlist.php?clear=1">Clear Wishlist</a>
            <?php endif; ?>
            <a href="view_product.php">Back to Shop</a>
        </div>

        <?php if (!empty($_SESSION['wishlist'])): ?>
            <div class="gallery">
                <?php foreach ($_SESSION['wishlist'] as $item): ?>
                    <div class="product-box">
                        <img src="<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>">
                        <h2><?= htmlspecialchars($item['name']); ?></h2>
                        <p>Rs. <?= number_format($item['price'], 2); ?></p>

                        <div class="action-row">
                            <form action="cart.php" method="post" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                <button type="submit" name="add_to_cart" title="Add to Cart">
                                    <i class="bx bx-cart"></i>
                                </button>
                            </form>
                            <a href="view_page.php?pid=<?= $item['id']; ?>" title="View Product">
                                <i class="bx bxs-show"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Your wishlist is empty.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="script.js"></script>
</body>
</html>
