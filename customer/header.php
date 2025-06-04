
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        /* Professional Header Styles */
        .header {
            margin: 40px;
            background: linear-gradient(135deg, #2d5016 0%, #4a7c59 50%, #2d5016 100%);
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.05"><circle cx="20" cy="20" r="2" fill="white"/><circle cx="80" cy="30" r="1.5" fill="white"/><circle cx="40" cy="70" r="1" fill="white"/><circle cx="60" cy="10" r="1.2" fill="white"/></svg>');
            pointer-events: none;
        }

        .header .flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
        }

        /* Logo Styles */
        .header .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .header .logo:hover {
            transform: scale(1.05);
        }

        .header .logo img {
            height: 55px;
            width: 55px;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(255,255,255,0.3);
            transition: all 0.3s ease;
            border: 2px solid rgba(255,255,255,0.2);
        }

        .header .logo:hover img {
            transform: rotate(10deg);
            box-shadow: 0 6px 25px rgba(255,255,255,0.4);
            border-color: rgba(255,255,255,0.4);
        }

        /* Navigation Styles */
        .navbar {
            display: flex;
            gap: 2.5rem;
            align-items: center;
            margin
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            text-transform: capitalize;
            padding: 0.7rem 1.2rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
        }

        .navbar a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.6s;
        }

        .navbar a:hover::before {
            left: 100%;
        }

        .navbar a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar a:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255,255,255,0.2);
            color: #ffd700;
        }

        .navbar a:hover::after {
            width: 80%;
        }

        /* Icons Section */
        .icons {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .icons i,
        .icons .cart-btn {
            color: white;
            font-size: 1.6rem;
            cursor: pointer;
            padding: 0.6rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            text-decoration: none;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .icons i:hover,
        .icons .cart-btn:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 8px 25px rgba(255,255,255,0.3);
            color: #ffd700;
        }

        .icons i:active,
        .icons .cart-btn:active {
            transform: translateY(-1px) scale(1.05);
        }

        /* Cart Badge */
        .cart-btn sup {
            position: absolute;
            top: -5px;
            right: -5px;
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
            box-shadow: 0 3px 10px rgba(255,107,107,0.5);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* User Dropdown */
        .user-box {
            position: absolute;
            top: 100%;
            right: 2rem;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(15px);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            display: none;
            flex-direction: column;
            gap: 1rem;
            min-width: 250px;
            border: 1px solid rgba(255,255,255,0.3);
            margin-top: 0.5rem;
        }

        .user-box::before {
            content: '';
            position: absolute;
            top: -10px;
            right: 20px;
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 10px solid rgba(255,255,255,0.95);
        }

        .user-box.active {
            display: flex;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-box p {
            color: #333;
            font-size: 0.95rem;
            margin: 0;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .user-box p span {
            font-weight: 700;
            color: #2d5016;
            text-transform: capitalize;
        }

        .user-box .btn {
            display: inline-block;
            background: linear-gradient(45deg, #2d5016, #4a7c59);
            color: white;
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .user-box .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .user-box .btn:hover::before {
            left: 100%;
        }

        .user-box .btn:hover {
            background: linear-gradient(45deg, #4a7c59, #2d5016);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(45,80,22,0.4);
        }

        /* Mobile Menu Button */
        #menu-btn {
            display: none;
            font-size: 2rem !important;
        }

        /* Mobile Responsive */
        @media (max-width: 968px) {
            .header .flex {
                padding: 1rem 1.5rem;
            }

            .navbar {
                gap: 1.5rem;
            }

            .navbar a {
                font-size: 0.9rem;
                padding: 0.6rem 1rem;
            }
        }

        @media (max-width: 768px) {
            .header .flex {
                padding: 1rem;
            }

            .navbar {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: linear-gradient(135deg, #2d5016, #4a7c59);
                flex-direction: column;
                padding: 1.5rem;
                gap: 0.8rem;
                display: none;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                border-top: 1px solid rgba(255,255,255,0.1);
            }

            .navbar.active {
                display: flex;
                animation: slideDown 0.4s ease;
            }

            .navbar a {
                width: 100%;
                text-align: center;
                padding: 1.2rem;
                background: rgba(255,255,255,0.1);
                margin-bottom: 0.5rem;
                border-radius: 15px;
                border: 1px solid rgba(255,255,255,0.2);
            }

            .navbar a:hover {
                background: rgba(255,255,255,0.2);
                transform: scale(1.02);
            }

            #menu-btn {
                display: flex;
            }

            .icons {
                gap: 0.8rem;
            }

            .user-box {
                right: 1rem;
                left: 1rem;
                width: auto;
                min-width: auto;
            }

            .user-box::before {
                right: 50px;
            }
        }

        @media (max-width: 480px) {
            .header .flex {
                padding: 0.8rem;
            }

            .header .logo img {
                height: 45px;
                width: 45px;
            }

            .icons i,
            .icons .cart-btn {
                width: 45px;
                height: 45px;
                font-size: 1.4rem;
            }

            .navbar {
                padding: 1rem;
            }

            .navbar a {
                padding: 1rem;
                font-size: 0.95rem;
            }
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Demo content for testing */
        .demo-content {
            height: 200vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 2rem;
        }

        .demo-content h1 {
            color: #2d5016;
            font-size: 2.5rem;
            text-align: center;
        }

        .demo-content p {
            color: #666;
            font-size: 1.1rem;
            text-align: center;
            max-width: 600px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <header class="header">      
        <div class="flex">         
            <a href="home.php" class="logo"><img src="img/logo.png" alt=""></a>          
            
            <nav class="navbar">             
                <a href="home.php">home</a>             
                <a href="view_product.php">products</a>             
                <a href="order.php">orders</a>             
                <a href="about.php">about</a>             
                <a href="contact.php">contact</a>                          
            </nav>         
            
            <div class="icons">             
                <i class="bx bxs-user" id="user-btn"></i>             
                <a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i><sup>3</sup></a>             
                <a href="cart.php" class="cart-btn"><i class="bx bx-cart-download"></i><sup>5</sup></a>             
                <i class="bx bx-list-plus" id="menu-btn"></i>         
            </div>                  
            
            <div class="user-box" id="user-box">            
                <!-- <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p> -->           
                <!-- <p>Email : <span><?php echo $_SESSION['user_email']; ?></span></p> -->             
                <a href="login.php" class="btn">login</a>             
                <a href="admin/login.php" class="btn">Admin</a>            
                <!-- <form method="post">                  
                    <a href="logout.php" class="btn">logout</a>
                </form> -->                                 
            </div>         
        </div> 
    </header>



    <script>
        // Header functionality
        const userBtn = document.getElementById('user-btn');
        const userBox = document.getElementById('user-box');
        const menuBtn = document.getElementById('menu-btn');
        const navbar = document.querySelector('.navbar');

        // User dropdown toggle
        userBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userBox.classList.toggle('active');
            // Close mobile menu if open
            navbar.classList.remove('active');
        });

        // Mobile menu toggle
        menuBtn.addEventListener('click', function() {
            navbar.classList.toggle('active');
            // Close user box if open
            userBox.classList.remove('active');
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!userBox.contains(e.target) && !userBtn.contains(e.target)) {
                userBox.classList.remove('active');
            }
            
            if (!navbar.contains(e.target) && !menuBtn.contains(e.target)) {
                navbar.classList.remove('active');
            }
        });

        // Close mobile menu when clicking nav links
        document.querySelectorAll('.navbar a').forEach(link => {
            link.addEventListener('click', () => {
                navbar.classList.remove('active');
            });
        });

        // Header scroll effect - auto hide/show
        let lastScrollTop = 0;
        const header = document.querySelector('.header');

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop && scrollTop > 150) {
                // Scrolling down - hide header
                header.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up - show header
                header.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
        });

        // Add active state to current page (you can customize this)
        const currentPage = window.location.pathname.split('/').pop();
        document.querySelectorAll('.navbar a').forEach(link => {
            if (link.getAttribute('href') === currentPage) {
                link.style.background = 'rgba(255,255,255,0.2)';
                link.style.color = '#ffd700';
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>