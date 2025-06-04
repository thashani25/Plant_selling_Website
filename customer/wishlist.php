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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist - Green Cactus</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            box-sizing: border-box;
        }

        .wishlist-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .wishlist-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1.5rem 0;
            border-bottom: 2px solid #e8f5e8;
        }

        .wishlist-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 2rem;
            font-weight: 700;
            color: #2d5a27;
            margin: 0;
        }

        .wishlist-title i {
            font-size: 2.2rem;
            color: #e74c3c;
            animation: heartbeat 2s infinite;
        }

        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .wishlist-count {
            background: linear-gradient(135deg, #2d5a27, #4a7c59);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-left: 0.5rem;
        }

        .btn-bar {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2d5a27, #4a7c59);
            color: white;
            box-shadow: 0 4px 15px rgba(45, 90, 39, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1e3d1b, #2d5a27);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(45, 90, 39, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #c82333, #a71e2a);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
        }

        .alert {
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
            border: none;
            border-left: 4px solid #17a2b8;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border-radius: 12px;
            color: #0c5460;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert::before {
            content: '✓';
            background: #17a2b8;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .product-box {
            background: white;
            border: none;
            border-radius: 20px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .product-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2d5a27, #4a7c59, #6fa65f);
        }

        .product-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .product-image-container {
            position: relative;
            margin-bottom: 1.5rem;
            overflow: hidden;
            border-radius: 15px;
        }

        .product-box img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
            transition: transform 0.3s ease;
        }

        .product-box:hover img {
            transform: scale(1.05);
        }

        .product-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d5a27;
            margin: 1rem 0 0.5rem 0;
            line-height: 1.3;
        }

        .product-price {
            font-size: 1.4rem;
            font-weight: 800;
            color: #e74c3c;
            margin: 0.5rem 0 1.5rem 0;
        }

        .action-row {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .action-btn {
            width: 50px;
            height: 50px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .cart-btn {
            background: linear-gradient(135deg, #2d5a27, #4a7c59);
            color: white;
            box-shadow: 0 4px 15px rgba(45, 90, 39, 0.3);
        }

        .cart-btn:hover {
            background: linear-gradient(135deg, #1e3d1b, #2d5a27);
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(45, 90, 39, 0.4);
        }

        .view-btn {
            background: linear-gradient(135deg, #17a2b8, #138496);
            color: white;
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
        }

        .view-btn:hover {
            background: linear-gradient(135deg, #138496, #117a8b);
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(23, 162, 184, 0.4);
        }

        .empty-wishlist {
            text-align: center;
            padding: 4rem 2rem;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 20px;
            margin-top: 2rem;
        }

        .empty-wishlist i {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 1rem;
            opacity: 0.7;
        }

        .empty-wishlist h3 {
            font-size: 1.5rem;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .empty-wishlist p {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .shop-now-btn {
            background: linear-gradient(135deg, #2d5a27, #4a7c59);
            color: white;
            padding: 1rem 2rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .shop-now-btn:hover {
            background: linear-gradient(135deg, #1e3d1b, #2d5a27);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(45, 90, 39, 0.3);
        }

        @media (max-width: 768px) {
            .wishlist-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .gallery {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
            }
            
            .btn-bar {
                justify-content: center;
            }
            
            .wishlist-container {
                padding: 0 1rem;
            }
        }

        @media (max-width: 480px) {
            .gallery {
                grid-template-columns: 1fr;
            }
            
            .product-box {
                padding: 1rem;
            }
            
            .action-row {
                gap: 0.5rem;
            }
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

        <div class="wishlist-header">
            <h2 class="wishlist-title">
                <i class="bx bxs-heart"></i>
                My Wishlist
                <?php if (!empty($_SESSION['wishlist'])): ?>
                    <span class="wishlist-count"><?= count($_SESSION['wishlist']); ?> items</span>
                <?php endif; ?>
            </h2>
            
            <div class="btn-bar">
                <a href="view_product.php" class="btn btn-primary">
                    <i class="bx bx-store"></i>
                    Continue Shopping
                </a>
                <?php if (!empty($_SESSION['wishlist'])): ?>
                    <a href="wishlist.php?clear=1" class="btn btn-danger" onclick="return confirm('Are you sure you want to clear your wishlist?')">
                        <i class="bx bx-trash"></i>
                        Clear All
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($_SESSION['wishlist'])): ?>
            <div class="gallery">
                <?php foreach ($_SESSION['wishlist'] as $item): ?>
                    <div class="product-box">
                        <div class="product-image-container">
                            <img src="<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>">
                        </div>
                        <h3 class="product-name"><?= htmlspecialchars($item['name']); ?></h3>
                        <p class="product-price">Rs. <?= number_format($item['price'], 2); ?></p>

                        <div class="action-row">
                            <form action="cart.php" method="post" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                <button type="submit" name="add_to_cart" class="action-btn cart-btn" title="Add to Cart">
                                    <i class="bx bx-cart-add"></i>
                                </button>
                            </form>
                            <a href="view_page.php?pid=<?= $item['id']; ?>" class="action-btn view-btn" title="View Product">
                                <i class="bx bx-show"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-wishlist">
                <i class="bx bx-heart"></i>
                <h3>Your wishlist is empty</h3>
                <p>Start adding your favorite Green Cactus products to your wishlist!</p>
                <a href="view_product.php" class="shop-now-btn">
                    <i class="bx bx-shopping-bag"></i>
                    Start Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="script.js"></script>
</body>
</html>