<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Green Cactus - Contact Us</title>

     <style type="text/css">
        <?php include 'style.css'; ?>
    
   
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

        /* Header Styles */
        .header {
            background: linear-gradient(135deg, #2c5530 0%, #3a7040 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo {
            height: 40px;
            width: auto;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: #90ee90;
        }

        .nav-links a.active {
            color: #90ee90;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #90ee90;
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
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


        .banner p {
            font-size: 1.2rem;
            opacity: 0.9;
            position: relative;
            z-index: 2;
            margin-top: 10px;
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

        /* Contact Content */
        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 50px;
        }

        .contact-info {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 1px solid #e8f5e8;
        }

        .contact-info h2 {
            color: #2d5016;
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding: 20px;
            background: #f8faf9;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(45,80,22,0.1);
        }

        .info-item i {
            font-size: 1.5rem;
            color: #4a7c59;
            margin-right: 15px;
            width: 30px;
            text-align: center;
        }

        .info-item div h3 {
            color: #2d5016;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .info-item div p {
            color: #666;
            font-size: 0.95rem;
        }

        /* Contact Form */
        .contact-form {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 1px solid #e8f5e8;
        }

        .contact-form h2 {
            color: #2d5016;
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #2d5016;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e8f5e8;
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background: #f8faf9;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #4a7c59;
            background: white;
            box-shadow: 0 0 0 3px rgba(74,124,89,0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #4a7c59, #2d5016);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(45,80,22,0.3);
            background: linear-gradient(135deg, #2d5016, #1a3009);
        }

        /* Map Section */
        .map-section {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 1px solid #e8f5e8;
            margin-bottom: 50px;
            text-align: center;
        }

        .map-section h2 {
            color: #2d5016;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .map-placeholder {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, #e8f5e8, #f8faf9);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4a7c59;
            font-size: 1.2rem;
            margin-top: 20px;
            border: 2px dashed #4a7c59;
        }

        /* Alert Messages */
        .alert {
            background: linear-gradient(135deg, #4caf50, #66bb6a);
            color: white;
            padding: 15px 25px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 0.95rem;
            box-shadow: 0 3px 10px rgba(76,175,80,0.3);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #2c5530, #3a7040);
            color: white;
            text-align: center;
            padding: 3rem 2rem;
            margin-top: 4rem;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="footer-pattern" patternUnits="userSpaceOnUse" width="25" height="25"><path d="M12.5 5L7 15h11z" fill="rgba(144,238,144,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23footer-pattern)"/></svg>');
        }

        .footer-content {
            position: relative;
            z-index: 1;
        }

        .footer p {
            font-size: 1.1rem;
            opacity: 0.9;
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

            .contact-container {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .contact-info,
            .contact-form,
            .map-section {
                padding: 30px 20px;
            }

            .title2 {
                margin: 0 -20px 30px;
                border-radius: 0;
                border-left: none;
                border-top: 4px solid #4a7c59;
            }

            .navbar {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .nav-links {
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            .banner h1 {
                font-size: 2rem;
            }

            .banner p {
                font-size: 1rem;
            }

            .contact-info h2,
            .contact-form h2,
            .map-section h2 {
                font-size: 1.5rem;
            }

            .info-item {
                flex-direction: column;
                text-align: center;
                padding: 15px;
            }

            .info-item i {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .map-placeholder {
                height: 250px;
                font-size: 1rem;
            }
        }

        /* Loading Animation */
        .contact-container {
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
    </style>
</head>
<body>
<?php include 'header.php'; ?>


<div class="main">
    <!-- Banner Section -->
    <div class="banner">
        <h1>Contact Us</h1>
    </div>
    
    <!-- Breadcrumb -->
    <div class="title2">
        <a href="home.php">Home</a><span> / Contact Us</span>
    </div>
    
    <!-- Contact Content -->
    <div class="contact-container">
        <!-- Contact Information -->
        <div class="contact-info">
            <h2>Get In Touch</h2>
            
            <div class="info-item">
                <i class='bx bx-map'></i>
                <div>
                    <h3>Address</h3>
                    <p>buttal, Uva-pellwatta.</p>
                </div>
            </div>
            
            <div class="info-item">
                <i class='bx bx-phone'></i>
                <div>
                    <h3>Phone</h3>
                    <p>078-3740204</p>
                </div>
            </div>
            
            <div class="info-item">
                <i class='bx bx-envelope'></i>
                <div>
                    <h3>Email</h3>
                    <p>piyunilthashani4@gmail.com</p>
                </div>
            </div>
            
            <div class="info-item">
                <i class='bx bx-time'></i>
                <div>
                    <h3>Business Hours</h3>
                    <p>Mon - Fri: 9:00 AM - 6:00 PM<br>
                       Tus - Fri: 9:00 AM - 6:00 PM<br>
                       Wed - Fri: 9:00 AM - 6:00 PM<br>
                       Thr- Fri: 9:00 AM - 6:00 PM<br>
                       Fri - Fri: 9:00 AM - 6:00 PM<br>
                       Sat - Sun: 10:00 AM - 4:00 PM</p>
                </div>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div class="contact-form">
            <h2>Send Message</h2>
            
            <?php if (isset($_GET['message'])): ?>
                <div class="alert"><?= htmlspecialchars($_GET['message']); ?></div>
            <?php endif; ?>
            
            <form action="contact_process.php" method="post">
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone">
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject *</label>
                    <select id="subject" name="subject" required>
                        <option value="">Select a subject</option>
                        <option value="general">General Inquiry</option>
                        <option value="support">Customer Support</option>
                        <option value="order">Order Related</option>
                        <option value="feedback">Feedback</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" required placeholder="Tell us how we can help you..."></textarea>
                </div>
                
                <button type="submit" name="submit_contact" class="submit-btn">
                    <i class='bx bx-send'></i> Send Message
                </button>
            </form>
        </div>
    </div>
    
    <!-- Map Section -->
    <div class="map-section">
        <h2>Find Us</h2>
        <p>Visit our store for a hands-on experience with our plants and accessories</p>
        <div class="map-placeholder">
            <div>
                <i class='bx bx-map' style="font-size: 2rem; margin-bottom: 10px;"></i><br>
                Interactive Map Goes Here<br>
                <small>Replace this with Google Maps or similar service</small>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    // Form validation and enhancement
    document.querySelector('.contact-form form').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const subject = document.getElementById('subject').value;
        const message = document.getElementById('message').value.trim();
        
        if (!name || !email || !subject || !message) {
            e.preventDefault();
            swal('Error!', 'Please fill in all required fields.', 'error');
            return;
        }
        
        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            swal('Error!', 'Please enter a valid email address.', 'error');
            return;
        }
        
        // Show loading state
        const submitBtn = document.querySelector('.submit-btn');
        submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Sending...';
        submitBtn.disabled = true;
    });
    
    // Add smooth scrolling for internal links
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
    
    // Add animation to info items on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.info-item').forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(item);
    });
</script>

</body>
</html>