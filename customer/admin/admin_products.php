<?php 
session_start(); 
include 'conection.php';  

// Handle product deletion 
if (isset($_GET['delete'])) {     
    $id = intval($_GET['delete']);     
    $conn->query("DELETE FROM products WHERE id = $id");     
    header("Location: admin_products.php");     
    exit(); 
}  

// Fetch all products 
$result = $conn->query("SELECT * FROM products ORDER BY id DESC"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Products - Green Cactus</title>
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

        /* Main Content */
        .main {
            margin-left: 280px;
            padding: 40px;
            min-height: 100vh;
        }

        .page-header {
            background: white;
            padding: 30px 35px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .page-header h1 {
            color: #2d5a27;
            font-size: 2.2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-header h1 i {
            color: #4ade80;
        }

        .add-btn {
            background: linear-gradient(135deg, #2d5a27, #4ade80);
            color: white;
            padding: 15px 25px;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(45, 90, 39, 0.3);
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(45, 90, 39, 0.4);
        }

        .add-btn i {
            font-size: 1.2rem;
        }

        /* Products Grid */
        .products-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .table-header {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            padding: 25px 30px;
            border-bottom: 1px solid #e5e7eb;
        }

        .table-header h2 {
            color: #2d5a27;
            font-size: 1.4rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table thead {
            background: linear-gradient(135deg, #2d5a27, #4ade80);
            color: white;
        }

        .products-table th {
            padding: 20px 15px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .products-table tbody tr {
            border-bottom: 1px solid #f3f4f6;
            transition: all 0.2s ease;
        }

        .products-table tbody tr:hover {
            background: #f9fafb;
            transform: scale(1.001);
        }

        .products-table td {
            padding: 20px 15px;
            vertical-align: middle;
        }

        .product-id {
            font-weight: 700;
            color: #2d5a27;
            font-size: 1.1rem;
        }

        .product-name {
            font-weight: 600;
            color: #374151;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .product-price {
            font-weight: 700;
            color: #059669;
            font-size: 1.1rem;
        }

        .product-image {
            position: relative;
            display: inline-block;
        }

        .product-image img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .product-image:hover img {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-edit, .btn-delete {
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-edit {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 20px;
            display: block;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #374151;
        }

        .empty-state p {
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        /* Loading State */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f4f6;
            border-top: 4px solid #2d5a27;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 250px;
            }
            
            .main {
                margin-left: 250px;
            }
        }

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

            .page-header {
                flex-direction: column;
                text-align: center;
            }

            .page-header h1 {
                font-size: 1.8rem;
            }

            .products-table {
                font-size: 0.9rem;
            }

            .products-table th,
            .products-table td {
                padding: 12px 8px;
            }

            .product-image img {
                width: 60px;
                height: 60px;
            }

            .actions {
                flex-direction: column;
                gap: 8px;
            }

            .btn-edit, .btn-delete {
                font-size: 0.8rem;
                padding: 6px 12px;
            }
        }

        @media (max-width: 480px) {
            .main {
                padding: 15px;
            }

            .page-header {
                padding: 20px;
            }

            .products-table {
                font-size: 0.8rem;
            }

            .products-table th,
            .products-table td {
                padding: 10px 6px;
            }

            .product-name {
                max-width: 120px;
            }
        }

        /* Responsive Table */
        @media (max-width: 640px) {
            .products-table thead {
                display: none;
            }

            .products-table tbody tr {
                display: block;
                background: white;
                margin-bottom: 15px;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                padding: 20px;
                border: none;
            }

            .products-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border-bottom: 1px solid #f3f4f6;
            }

            .products-table td:before {
                content: attr(data-label);
                font-weight: 600;
                color: #2d5a27;
                text-transform: uppercase;
                font-size: 0.8rem;
                letter-spacing: 0.5px;
            }

            .products-table td:last-child {
                border-bottom: none;
                justify-content: center;
                padding-top: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2><i class='bx bx-leaf'></i> Green Cactus</h2>
        <a href="admin_dashboard.php"><i class='bx bx-home'></i> Dashboard</a>
        <a href="admin_products.php" class="active"><i class='bx bx-cube'></i> Products</a>
        <a href="admin_orders.php"><i class='bx bx-cart'></i> Orders</a>
        <a href="admin_users.php"><i class='bx bx-user'></i> Users</a>
        <a href="logout.php"><i class='bx bx-log-out'></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main">
        <!-- Page Header -->
        <div class="page-header">
            <h1>
                <i class='bx bx-cube'></i>
                Manage Products
            </h1>
            <a href="add_product.php" class="add-btn">
                <i class='bx bx-plus'></i>
                Add New Product
            </a>
        </div>

        <!-- Products Container -->
        <div class="products-container">
            <div class="table-header">
                <h2>
                    <i class='bx bx-list-ul'></i>
                    Products List
                </h2>
            </div>

            <?php if ($result && $result->num_rows > 0): ?>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Price (Rs.)</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td data-label="ID" class="product-id">#<?= $row['id'] ?></td>
                            <td data-label="Name" class="product-name" title="<?= htmlspecialchars($row['name']) ?>">
                                <?= htmlspecialchars($row['name']) ?>
                            </td>
                            <td data-label="Price" class="product-price">
                                Rs. <?= number_format($row['price'], 2) ?>
                            </td>
                            <td data-label="Image" class="product-image">
                                <img src="<?= htmlspecialchars($row['image']) ?>" 
                                     alt="<?= htmlspecialchars($row['name']) ?>"
                                     onerror="this.src='img/placeholder.png'">
                            </td>
                            <td data-label="Actions" class="actions">
                                <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn-edit">
                                    <i class='bx bx-edit'></i>
                                    Edit
                                </a>
                                <a href="admin_products.php?delete=<?= $row['id'] ?>" 
                                   class="btn-delete" 
                                   onclick="return confirm('Are you sure you want to delete this product?')">
                                    <i class='bx bx-trash'></i>
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <i class='bx bx-package'></i>
                    <h3>No Products Found</h3>
                    <p>You haven't added any products yet. Start by adding your first product!</p>
                    <a href="add_product.php" class="add-btn">
                        <i class='bx bx-plus'></i>
                        Add Your First Product
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth animations to table rows
            const tableRows = document.querySelectorAll('.products-table tbody tr');
            tableRows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.1}s`;
                row.style.animation = 'fadeInUp 0.6s ease forwards';
            });

            // Image error handling
            const images = document.querySelectorAll('.product-image img');
            images.forEach(img => {
                img.addEventListener('error', function() {
                    this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAiIGhlaWdodD0iODAiIHZpZXdCb3g9IjAgMCA4MCA4MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjgwIiBoZWlnaHQ9IjgwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik00MCA1NkM0OC44MzY2IDU2IDU2IDQ4LjgzNjYgNTYgNDBDNTYgMzEuMTYzNCA0OC44MzY2IDI0IDQwIDI0QzMxLjE2MzQgMjQgMjQgMzEuMTYzNCAyNCA0MEMyNCA0OC44MzY2IDMxLjE2MzQgNTYgNDAgNTZaIiBzdHJva2U9IiM5Q0EzQUYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0zMiAzNkgzMi4wMTMzIiBzdHJva2U9IiM5Q0EzQUYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+Cjwvc3ZnPgo=';
                    this.alt = 'Product image not available';
                });
            });

            // Confirm deletion with better UX
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productName = this.closest('tr').querySelector('.product-name').textContent.trim();
                    if (confirm(`Are you sure you want to delete "${productName}"?\n\nThis action cannot be undone.`)) {
                        window.location.href = this.href;
                    }
                });
            });
        });

        // CSS animations
        const style = document.createElement('style');
        style.textContent = `
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
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>