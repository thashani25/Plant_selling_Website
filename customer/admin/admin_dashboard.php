<?php 
include 'conection.php';  
session_start();  

// Redirect to login if not logged in 
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {     
    header("Location: login.php");     
    exit; 
}   

// Fetch total products 
$product_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM products"); 
$product_data = mysqli_fetch_assoc($product_result); 
$total_products = $product_data['total'];  

// Fetch total orders 
$order_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM orders"); 
$order_data = mysqli_fetch_assoc($order_result); 
$total_orders = $order_data['total'];  

// Fetch total users 
$user_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM users"); 
$user_data = mysqli_fetch_assoc($user_result); 
$total_users = $user_data['total']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Green Cactus</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: #333;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #2d5a27 0%, #1a3a15 100%);
            color: white;
            padding: 0;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar h2 {
            padding: 30px 25px;
            font-size: 1.5rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.2);
        }

        .sidebar h2 i {
            margin-right: 12px;
            font-size: 1.6rem;
            color: #4ade80;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 18px 25px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            font-weight: 500;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: #4ade80;
            color: white;
            padding-left: 30px;
        }

        .sidebar a i {
            margin-right: 15px;
            font-size: 1.3rem;
            width: 20px;
            text-align: center;
        }

        /* Home Button Styles */
        .home-btn {
            background: linear-gradient(135deg, #4ade80, #22c55e);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(74, 222, 128, 0.3);
            cursor: pointer;
        }

        .home-btn:hover {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 222, 128, 0.4);
            color: white;
            text-decoration: none;
        }

        .home-btn i {
            font-size: 1.1rem;
        }

        /* Main Content */
        .main {
            margin-left: 280px;
            padding: 40px;
            min-height: 100vh;
        }

        .header {
            background: white;
            padding: 25px 35px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #2d5a27;
            font-size: 2rem;
            font-weight: 700;
        }

        .header .admin-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .admin-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #2d5a27, #4ade80);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2d5a27, #4ade80);
        }

        .stat-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
        }

        .stat-card.products .icon {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .stat-card.orders .icon {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .stat-card.users .icon {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .stat-card h3 {
            color: #6b7280;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .stat-card .number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            line-height: 1;
        }

        /* Recent Orders Card */
        .recent-orders {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .recent-orders .card-header {
            padding: 25px 30px;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-bottom: 1px solid #e5e7eb;
        }

        .recent-orders .card-header h3 {
            color: #2d5a27;
            font-size: 1.3rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .recent-orders .card-body {
            padding: 0;
        }

        .recent-orders ul {
            list-style: none;
        }

        .recent-orders li {
            padding: 20px 30px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background-color 0.2s ease;
        }

        .recent-orders li:hover {
            background: #f9fafb;
        }

        .recent-orders li:last-child {
            border-bottom: none;
        }

        .order-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .order-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        .order-details {
            font-weight: 600;
            color: #374151;
        }

        .order-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-processing {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .header .header-actions {
                order: -1;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .stat-card {
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .main {
                padding: 15px;
            }

            .header {
                padding: 20px;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .stat-card {
                padding: 20px;
            }

            .recent-orders li {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }

            .home-btn {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(45, 90, 39, 0.3);
            border-radius: 50%;
            border-top-color: #2d5a27;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2><i class='bx bx-leaf'></i> Green Cactus</h2>
        <a href="admin_dashboard.php" class="active"><i class='bx bx-home'></i> Dashboard</a>
        <a href="admin_products.php"><i class='bx bx-cube'></i> Products</a>
        <a href="admin_orders.php"><i class='bx bx-cart'></i> Orders</a>
        <a href="admin_users.php"><i class='bx bx-user'></i> Users</a>
       
    </div>

    <!-- Main Content -->
    <div class="main">
        <!-- Header -->
        <div class="header">
            <h1>Admin Dashboard</h1>
            <div class="header-actions">
                <a href="../home.php" class="home-btn">
                    <i class='bx bx-home-alt'></i>
                    Back to Home
                </a>
                <div class="admin-info">
                    <div class="admin-avatar">
                        <?= strtoupper(substr($_SESSION['admin_username'], 0, 1)) ?>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: #2d5a27;">
                            <?= htmlspecialchars($_SESSION['admin_username']) ?>
                        </div>
                        <div style="font-size: 0.9rem; color: #6b7280;">
                            Administrator
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-container">
            <div class="stat-card products">
                <div class="icon">
                    <i class='bx bx-cube'></i>
                </div>
                <h3>Total Products</h3>
                <div class="number"><?= $total_products ?></div>
            </div>
            
            <div class="stat-card orders">
                <div class="icon">
                    <i class='bx bx-cart'></i>
                </div>
                <h3>Total Orders</h3>
                <div class="number"><?= $total_orders ?></div>
            </div>
            
            <div class="stat-card users">
                <div class="icon">
                    <i class='bx bx-user'></i>
                </div>
                <h3>Total Users</h3>
                <div class="number"><?= $total_users ?></div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="recent-orders">
            <div class="card-header">
                <h3>
                    <i class='bx bx-time-five'></i>
                    Recent Orders
                </h3>
            </div>
            <div class="card-body">
                <ul>
                <?php
                $recent_orders = mysqli_query($conn, "SELECT id, status FROM orders ORDER BY id DESC LIMIT 5");
                if ($recent_orders && mysqli_num_rows($recent_orders) > 0) {
                    while ($row = mysqli_fetch_assoc($recent_orders)) {
                        $status = strtolower($row['status']);
                        $status_class = 'status-' . $status;
                        echo "<li>
                                <div class='order-info'>
                                    <div class='order-icon'>
                                        <i class='bx bx-receipt'></i>
                                    </div>
                                    <div class='order-details'>
                                        Order #{$row['id']}
                                    </div>
                                </div>
                                <div class='order-status {$status_class}'>
                                    " . ucfirst($row['status']) . "
                                </div>
                              </li>";
                    }
                } else {
                    echo "<li style='text-align: center; color: #6b7280; padding: 40px;'>
                            <i class='bx bx-info-circle' style='font-size: 2rem; margin-bottom: 10px; display: block;'></i>
                            No recent orders found
                          </li>";
                }
                ?>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Add smooth scrolling and interaction effects
        document.addEventListener('DOMContentLoaded', function() {
            // Animate stats on load
            const statNumbers = document.querySelectorAll('.stat-card .number');
            statNumbers.forEach(stat => {
                const finalNumber = parseInt(stat.textContent);
                let currentNumber = 0;
                const increment = finalNumber / 50;
                
                const timer = setInterval(() => {
                    currentNumber += increment;
                    if (currentNumber >= finalNumber) {
                        stat.textContent = finalNumber;
                        clearInterval(timer);
                    } else {
                        stat.textContent = Math.floor(currentNumber);
                    }
                }, 30);
            });

            // Add click effects to sidebar links
            const sidebarLinks = document.querySelectorAll('.sidebar a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    sidebarLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>