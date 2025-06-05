<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Cactus - Home Page</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- External CSS file -->
    <style>
        /* Scroll to Top Button Styles */
        .scroll-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
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
            background: #218838;
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(40, 167, 69, 0.4);
        }

        .scroll-to-top:active {
            transform: translateY(-1px);
        }

        /* Animation for smooth appearance */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .scroll-to-top.show {
            animation: fadeInUp 0.3s ease;
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="main">
        <!-- Home Section Slider -->
        <section class="home-section">
            <div class="slider">
                <!-- Slide items (slide1 to slide5) -->
                <?php for ($i = 1; $i <= 5; $i++): ?>
                <div class="slider-slider slide<?= $i ?> <?= $i == 1 ? 'active' : '' ?>">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Welcome...</h1>
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
                <!-- Service Boxes (same as original HTML) -->
                <!-- Copy the 4 service boxes here -->
            </div>
        </section>
    </div>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" title="Back to Top">
        <i class="bx bx-up-arrow-alt"></i>
    </button>

    <?php include 'footer.php'; ?>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const userBtn = document.getElementById('user-btn');
            const userBox = document.getElementById('user-box');
            const menuBtn = document.getElementById('menu-btn');
            const navbar = document.querySelector('.navbar');

            if (userBtn && userBox && menuBtn && navbar) {
                userBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userBox.classList.toggle('active');
                    navbar.classList.remove('active');
                });

                menuBtn.addEventListener('click', () => {
                    navbar.classList.toggle('active');
                    userBox.classList.remove('active');
                });

                document.addEventListener('click', (e) => {
                    if (!userBox.contains(e.target) && !userBtn.contains(e.target)) {
                        userBox.classList.remove('active');
                    }
                    if (!navbar.contains(e.target) && !menuBtn.contains(e.target)) {
                        navbar.classList.remove('active');
                    }
                });

                document.querySelectorAll('.navbar a').forEach(link => {
                    link.addEventListener('click', () => {
                        navbar.classList.remove('active');
                    });
                });
            }

            const slides = document.querySelectorAll('.slider-slider');
            const leftArrow = document.querySelector('.left-arrow');
            const rightArrow = document.querySelector('.right-arrow');
            let currentSlide = 0;

            function showSlide(index) {
                slides.forEach(slide => slide.classList.remove('active'));
                slides[index].classList.add('active');
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }

            function prevSlide() {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(currentSlide);
            }

            rightArrow?.addEventListener('click', nextSlide);
            leftArrow?.addEventListener('click', prevSlide);

            setInterval(nextSlide, 5000);

            let lastScrollTop = 0;
            const header = document.querySelector('.header');

            window.addEventListener('scroll', () => {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                if (scrollTop > lastScrollTop && scrollTop > 150) {
                    header.style.transform = 'translateY(-100%)';
                } else {
                    header.style.transform = 'translateY(0)';
                }
                lastScrollTop = scrollTop;
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
        });
    </script>
</body>
</html>