<?php include 'conection.php'; session_start(); $user_id = $_SESSION['user_id'] ?? null; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Green Cactus - Shop Page</title>
    
    <style type="text/css">
        <?php include 'style.css'; ?>
        
        /* Professional Shop Page Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: #f8faf9;
            color: #333;
        }

        /* Main Container */
        .main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Banner Section */
        .banner {
           background-image: url('img/banner.jpg');
            color: white;
            text-align: center;
            padding: 80px 0;
            margin-bottom: 30px;
            border-radius: 15px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(45,80,22,0.3);
        }

        .banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 70%, rgba(255,255,255,0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .banner h1 {
            font-size: 4rem;
            font-weight: 500;
            text-shadow: 0 4px 8px rgba(0,0,0,0.3);
            position: relative;
            z-index: 2;
            letter-spacing: 2px;
        }

        /* Breadcrumb */
        .title2 {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            margin-bottom: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border-left: 4px solid #4a7c59;
        }

        .title2 a {
            color: #4a7c59;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .title2 a:hover {
            color: #2d5016;
            text-decoration: underline;
        }

        .title2 span {
            color: #666;
            margin-left: 5px;
        }

        /* Gallery Grid */
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            padding: 20px 0;
        }

        /* Product Box */
        .product-box {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            position: relative;
            border: 1px solid #e8f5e8;
        }

        .product-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(45,80,22,0.2);
            border-color: #4a7c59;
        }

        .product-box img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-box:hover img {
            transform: scale(1.05);
        }

        .product-box h2 {
            padding: 20px 25px 10px;
            font-size: 1.4rem;
            color: #2d5016;
            font-weight: 700;
            line-height: 1.3;
        }

        .product-box p {
            padding: 0 25px 15px;
            font-size: 1.3rem;
            color: #4a7c59;
            font-weight: 600;
        }

        /* Alert Messages */
        .alert {
            background: linear-gradient(135deg, #4caf50, #66bb6a);
            color: white;
            padding: 12px 25px;
            margin: 0 25px 15px;
            border-radius: 8px;
            font-size: 0.9rem;
            box-shadow: 0 3px 10px rgba(76,175,80,0.3);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Action Row */
        .action-row {
            display: flex;
            justify-content: center;
            gap: 15px;
            padding: 20px 25px 25px;
            background: #f8faf9;
        }

        .action-row button,
        .action-row a {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .action-row button {
            background: linear-gradient(135deg, #4a7c59, #2d5016);
            color: white;
            border: none;
        }

        .action-row button:hover {
            background: linear-gradient(135deg, #2d5016, #1a3009);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(45,80,22,0.4);
        }

        .action-row a:nth-child(2) {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
        }

        .action-row a:nth-child(2):hover {
            background: linear-gradient(135deg, #ee5a52, #e74c3c);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(231,76,60,0.4);
        }

        .action-row a:nth-child(3) {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }

        .action-row a:nth-child(3):hover {
            background: linear-gradient(135deg, #2980b9, #1f4e79);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(52,152,219,0.4);
        }

        /* Hover Effects */
        .action-row button i,
        .action-row a i {
            font-size: 1.3rem;
            transition: transform 0.3s ease;
        }

        .action-row button:hover i,
        .action-row a:hover i {
            transform: scale(1.2);
        }

        /* Product Box Special Effects */
        .product-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .product-box:hover::before {
            left: 100%;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .banner {
                padding: 60px 20px;
                margin: 0 -20px 30px;
                border-radius: 0;
            }

            .banner h1 {
                font-size: 2.5rem;
            }

            .gallery {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 20px;
            }

            .product-box img {
                height: 220px;
            }

            .title2 {
                margin: 0 -20px 30px;
                border-radius: 0;
                border-left: none;
                border-top: 4px solid #4a7c59;
            }
        }

        @media (max-width: 480px) {
            .banner h1 {
                font-size: 2rem;
            }

            .gallery {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .product-box h2 {
                font-size: 1.2rem;
                padding: 15px 20px 8px;
            }

            .product-box p {
                padding: 0 20px 12px;
                font-size: 1.1rem;
            }

            .action-row {
                padding: 15px 20px 20px;
                gap: 12px;
            }

            .action-row button,
            .action-row a {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }
        }

        /* Loading Animation */
        .gallery {
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Individual product animation delay */
        .product-box:nth-child(1) { animation-delay: 0.1s; }
        .product-box:nth-child(2) { animation-delay: 0.2s; }
        .product-box:nth-child(3) { animation-delay: 0.3s; }
        .product-box:nth-child(4) { animation-delay: 0.4s; }
        .product-box:nth-child(5) { animation-delay: 0.5s; }
        .product-box:nth-child(6) { animation-delay: 0.6s; }

        .product-box {
            animation: fadeInUp 0.6s ease both;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>Shop</h1>
    </div>
    <div class="title2">
        <div class="title2"><a href="home.php">Home</a><span> / view products </span></div>
    </div>
    
    <div class="gallery">
        <?php
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        
        while ($row = $result->fetch_assoc()) {
        ?>
            <div class="product-box">
                <img src="<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['name']); ?>">
                <h2><?= htmlspecialchars($row['name']); ?></h2>
                <p>Rs. <?= htmlspecialchars($row['price']); ?></p>
                
                <!-- Display success/error message -->
                <?php if (isset($_GET['message'])): ?>
                    <div class="alert"><?= htmlspecialchars($_GET['message']); ?></div>
                <?php endif; ?>
                
                <form action="cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                    <div class="action-row">
                        <button type="submit" name="add_to_cart" title="Add to Cart">
                            <i class="bx bx-cart"></i>
                        </button>
                        <a href="wishlist.php?product_id=<?= $row['id']; ?>" title="Add to Wishlist">
                            <i class="bx bx-heart"></i>
                        </a>
                        <a href="view_page.php?pid=<?= $row['id']; ?>" title="View Product">
                            <i class="bx bxs-show"></i>
                        </a>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>

<?php include 'alert.php'; ?>

</body>
</html>