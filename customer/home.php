<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Cactus - Home Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="main">
        <!-- Home Section Slider -->
        <section class="home-section">
            <div class="slider">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                <div class="slider-slider slide<?= $i ?>">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Welcome to Cactus Web Page</h1>
                        <p>Dear friends<br>Your destination for quality and exotic cactus.</p>
                        <a href="view_product.php" class="btn">Shop Now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <?php endfor; ?>

                <!-- Arrows -->
                <div class="left-arrow"><i class="bx bxs-left-arrow"></i></div>
                <div class="right-arrow"><i class="bx bxs-right-arrow"></i></div>
            </div>
        </section>

        <!-- Thumb Section -->
        <section class="thumb">
            <div class="box-container">
                <div class="box">
                    <img src="img/ho2.png" width="150px" height="150px">
                    <h3>Powder Puff</h3>
                    <p>Mammillaria bocasana (Powder Puff Cactus) forms large clumps over time. Covered with silky white hairs and yellow-to-red hooked spines.</p>
                </div>
                <div class="box">
                    <img src="img/ho3.png" width="170px" height="170px">
                    <h3>Domino</h3>
                    <p>A small cactus with woolly white areoles. Native to Bolivia and Argentina. A member of the cactus family (Cactaceae).</p>
                </div>
                <div class="box">
                    <img src="img/ho4.png" width="130px" height="130px">
                    <h3>Angel Wing</h3>
                    <p>Native to Mexico, forms tiers of flattened pads. Take care not to touch glochids. Yellow flowers in spring.</p>
                </div>
                <div class="box">
                    <img src="img/ho5.png" width="150px" height="150px">
                    <h3>Golden Barrel</h3>
                    <p>Popular, drought-tolerant cactus native to Mexico. Known for its barrel shape and golden-yellow spines.</p>
                </div>
            </div>
        </section>

        <!-- Promotion Section -->
        <section class="container">
            <div class="box-container">
                <div class="box">
                    <img src="img/off.png" alt="Promotion">
                </div>
                <div class="box">
                    <div class="logo">
                        <img src="img/logo.png" alt="Logo">
                        <span>Beautiful Cactus</span>
                        <h1>Save up to 20% Off</h1>
                        <p>Potted arrangements of artificial succulents. Perfect for home or office decor with no maintenance.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services">
            <div class="box-container">
                <div class="box">
                    <img src="img/icon2.png" alt="">
                    <div class="detail">
                        <h3>Great Savings</h3>
                        <p>Save big on every order</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon1.png" alt="">
                    <div class="detail">
                        <h3>24/7 Support</h3>
                        <p>One-on-one customer support</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon0.png" alt="">
                    <div class="detail">
                        <h3>Gift Vouchers</h3>
                        <p>Available on every festival</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon.png" alt="">
                    <div class="detail">
                        <h3>Worldwide Delivery</h3>
                        <p>We ship worldwide</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>
