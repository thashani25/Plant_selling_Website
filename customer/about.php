<?php include 'conection.php'; session_start(); $user_id = $_SESSION['user_id'] ?? null; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' rel='stylesheet'>
    <title>Green Cactus - About Us</title>
    
    <style type="text/css">
        <?php include 'style.css'; ?>
        
        /* Professional About Page Styles */
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

        /* Banner Section - Matching shop page style */
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

        /* Breadcrumb - Matching shop page style */
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

        /* Company Info Section */
        .company-info {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            margin-bottom: 40px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 1px solid #e8f5e8;
        }

        .company-info .logo {
            width: 120px;
            height: auto;
            margin-bottom: 30px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
        }

        .company-info h2 {
            font-size: 2.5rem;
            color: #2d5016;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .company-info p {
            font-size: 1.2rem;
            color: #4a7c59;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* Services Section */
        .services {
            margin-bottom: 40px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: #2d5016;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .section-title p {
            font-size: 1.2rem;
            color: #4a7c59;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Services Grid - Matching product grid style */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            padding: 20px 0;
        }

        /* Service Box - Matching product box style */
        .service-box {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            position: relative;
            border: 1px solid #e8f5e8;
            text-align: center;
            padding: 40px 30px;
        }

        .service-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(45,80,22,0.2);
            border-color: #4a7c59;
        }

        .service-box img {
            width: 80px;
            height: 80px;
            margin-bottom: 25px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
            transition: transform 0.4s ease;
        }

        .service-box:hover img {
            transform: scale(1.1);
        }

        .service-box h3 {
            font-size: 1.4rem;
            color: #2d5016;
            margin-bottom: 15px;
            font-weight: 700;
            text-transform: capitalize;
        }

        .service-box p {
            color: #4a7c59;
            font-size: 1.1rem;
            line-height: 1.6;
            text-transform: capitalize;
        }

        /* Service Box Special Effects - Matching product box */
        .service-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .service-box:hover::before {
            left: 100%;
        }

        /* Testimonials Section */
        .testimonial-section {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 1px solid #e8f5e8;
            margin-bottom: 40px;
        }

        .testimonial-slider {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 15px;
        }

        .testimonial-item {
            background: #f8faf9;
            padding: 40px 30px;
            text-align: center;
            border-radius: 15px;
            display: none;
            animation: fadeInUp 0.6s ease;
            border: 2px solid #e8f5e8;
        }

        .testimonial-item.active {
            display: block;
        }

        .testimonial-item img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #4a7c59;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .testimonial-item h3 {
            font-size: 1.4rem;
            color: #2d5016;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .rating {
            margin-bottom: 20px;
        }

        .rating i {
            color: #ffc107;
            font-size: 1.2rem;
            margin: 0 2px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        .testimonial-item p {
            font-size: 1.1rem;
            color: #4a7c59;
            line-height: 1.8;
            font-style: italic;
            margin-bottom: 25px;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #4a7c59, #2d5016);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .social-links a:hover {
            background: linear-gradient(135deg, #2d5016, #1a3009);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(45,80,22,0.4);
        }

        /* Navigation Arrows */
        .nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #4a7c59, #2d5016);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .nav-arrow:hover {
            background: linear-gradient(135deg, #2d5016, #1a3009);
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 8px 20px rgba(45,80,22,0.4);
        }

        .left-arrow {
            left: -25px;
        }

        .right-arrow {
            right: -25px;
        }

        /* Scroll to Top Button Styles */
        .scroll-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #4a7c59, #2d5016);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(74, 124, 89, 0.4);
            transition: all 0.3s ease;
            opacity: 0;
            visibility: hidden;
            z-index: 1000;
        }

        .scroll-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .scroll-to-top:hover {
            background: linear-gradient(135deg, #2d5016, #1a3009);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(45, 80, 22, 0.5);
        }

        .scroll-to-top:active {
            transform: translateY(-1px);
        }

        /* Animation for smooth appearance */
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

        .scroll-to-top.show {
            animation: fadeInUp 0.3s ease;
        }

        /* Loading Animation */
        .services-grid {
            animation: fadeInUp 0.6s ease;
        }

        /* Individual service animation delay */
        .service-box:nth-child(1) { animation-delay: 0.1s; }
        .service-box:nth-child(2) { animation-delay: 0.2s; }
        .service-box:nth-child(3) { animation-delay: 0.3s; }
        .service-box:nth-child(4) { animation-delay: 0.4s; }

        .service-box {
            animation: fadeInUp 0.6s ease both;
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

            .services-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 20px;
            }

            .company-info,
            .testimonial-section {
                padding: 40px 25px;  
            }

            .company-info h2,
            .section-title h2 {
                font-size: 2rem;
            }

            .title2 {
                margin: 0 -20px 30px;
                border-radius: 0;
                border-left: none;
                border-top: 4px solid #4a7c59;
            }

            .nav-arrow {
                display: none;
            }

            .scroll-to-top {
                bottom: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
                font-size: 18px;
            }
        }

        @media (max-width: 480px) {
            .banner h1 {
                font-size: 2rem;
            }

            .services-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .service-box {
                padding: 30px 20px;
            }

            .company-info h2,
            .section-title h2 {
                font-size: 1.8rem;
            }

            .company-info p,
            .section-title p {
                font-size: 1.1rem;
            }

            .testimonial-item {
                padding: 30px 20px;
            }

            .scroll-to-top {
                bottom: 15px;
                right: 15px;
                width: 40px;
                height: 40px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>About Us</h1>
    </div>
    
    <div class="title2">
        <a href="home.php">Home</a><span> / About Us</span>
    </div>

    <!-- Company Information -->
    <div class="company-info">
        <img src="img/logo.png" alt="Green Cactus Logo" class="logo">
        <h2>Welcome to Green Cactus</h2>
        <p>We are passionate about bringing nature closer to you through our carefully curated collection of plants and gardening essentials. Our mission is to make gardening accessible to everyone, whether you're a seasoned gardener or just starting your green journey.</p>
    </div>

    <!-- Services Section -->
    <section class="services">
        <div class="section-title">
            <h2>Why Choose Us</h2>
            <p>Discover what makes Green Cactus your trusted partner in gardening</p>
        </div>
        
        <div class="services-grid">
            <div class="service-box">
                <img src="img/icon2.png" alt="Great Savings">
                <h3>Great Savings</h3>
                <p>Save big on every order with our competitive prices and special offers</p>
            </div>
            <div class="service-box">
                <img src="img/icon1.png" alt="24/7 Support">
                <h3>24/7 Support</h3>
                <p>Get personalized assistance whenever you need it</p>
            </div>
            <div class="service-box">
                <img src="img/icon0.png" alt="Gift Vouchers">
                <h3>Gift Vouchers</h3>
                <p>Special vouchers available during festivals and celebrations</p>
            </div>
            <div class="service-box">
                <img src="img/icon.png" alt="Worldwide Delivery">
                <h3>Worldwide Delivery</h3>
                <p>Fast and reliable shipping to customers around the globe</p>
            </div>
        </div>
    </section>
     
    <!-- Testimonials Section -->
    <div class="testimonial-section">
        <div class="section-title">
            <h2>What People Say About Us</h2>
            <p>Real feedback from our valued customers</p>
        </div>
        
        <div class="testimonial-slider">
            <div class="testimonial-item active">
                <img src="img/omesh.jpg" alt="Omesh Tharaka">
                <h3>Omesh Tharaka</h3>
                <div class="rating">
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star-half'></i>
                </div>
                <p>"Green Cactus provided excellent service! The plants arrived in perfect condition and the customer support was outstanding. Highly recommend!"</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            
            <div class="testimonial-item">
                <img src="img/kalani.jpg" alt="Kalani Lanka">
                <h3>Kalani Lanka</h3>
                <div class="rating">
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star-half'></i>
                </div>
                <p>"Friendly customer service and incredibly fast delivery. The quality exceeded my expectations. Will definitely shop again!"</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            
            <div class="testimonial-item">
                <img src="img/chamo.jpg" alt="Chamodya Nimeshi">
                <h3>Chamodya Nimeshi</h3>
                <div class="rating">
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star-half'></i>
                </div>
                <p>"Excellent quality plants that are thriving in my garden. There was a slight delay in shipping, but the quality made up for it completely."</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            
            <button class="nav-arrow left-arrow" onclick="prevSlide()">
                <i class="bx bx-chevron-left"></i>
            </button>
            <button class="nav-arrow right-arrow" onclick="nextSlide()">
                <i class="bx bx-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<!-- Scroll to Top Button -->
<button class="scroll-to-top" id="scrollToTop" title="Back to Top">
    <i class="bx bx-up-arrow-alt"></i>
</button>

<?php include 'footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.testimonial-item');
    const totalSlides = slides.length;

    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        slides[index].classList.add('active');
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    }

    // Auto-slide functionality
    setInterval(nextSlide, 5000);

    // Touch/swipe support for mobile
    let startX = 0;
    let endX = 0;

    document.querySelector('.testimonial-slider').addEventListener('touchstart', e => {
        startX = e.changedTouches[0].screenX;
    });

    document.querySelector('.testimonial-slider').addEventListener('touchend', e => {
        endX = e.changedTouches[0].screenX;
        if (startX - endX > 50) {
            nextSlide();
        } else if (endX - startX > 50) {
            prevSlide();
        }
    });

    // Scroll to Top Button Functionality
    const scrollToTopBtn = document.getElementById('scrollToTop');

    // Show/hide scroll to top button based on scroll position
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.add('show');
        } else {
            scrollToTopBtn.classList.remove('show');
        }
    });

    // Smooth scroll to top when button is clicked
    scrollToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>

<?php include 'alert.php'; ?>

</body>
</html>