<?php
session_start();
include 'conection.php';

// Handle order deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM orders WHERE id = $id");
    header("Location: admin_orders.php");
    exit();
}

// Handle order acceptance
if (isset($_GET['accept'])) {
    $id = intval($_GET['accept']);
    $conn->query("UPDATE orders SET status = 'Shipped' WHERE id = $id AND status = 'Pending'");
    header("Location: admin_orders.php");
    exit();
}

// Handle order status updates
if (isset($_GET['status']) && isset($_GET['order_id'])) {
    $id = intval($_GET['order_id']);
    $status = $_GET['status'];
    $allowed_statuses = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];
    
    if (in_array($status, $allowed_statuses)) {
        $conn->query("UPDATE orders SET status = '$status' WHERE id = $id");
        header("Location: admin_orders.php");
        exit();
    }
}

// Fetch all orders with search and filter functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';

$query = "SELECT * FROM orders WHERE 1=1";
if (!empty($search)) {
    $query .= " AND (customer_name LIKE '%$search%' OR id LIKE '%$search%')";
}
if (!empty($status_filter)) {
    $query .= " AND status = '$status_filter'";
}
$query .= " ORDER BY id DESC";

$result = $conn->query($query);

// Get order statistics
$stats_query = "SELECT 
    COUNT(*) as total_orders,
    SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending_orders,
    SUM(CASE WHEN status = 'Shipped' THEN 1 ELSE 0 END) as shipped_orders,
    SUM(CASE WHEN status = 'Delivered' THEN 1 ELSE 0 END) as delivered_orders,
    SUM(total) as total_revenue
    FROM orders";
$stats_result = $conn->query($stats_query);
$stats = $stats_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders - Green Cactus</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    <?php include 'style.css'; ?>
    
    /* Additional styles for enhanced functionality */
    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .search-filter-container {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .search-box, .filter-select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }
    
    .search-box {
        min-width: 200px;
    }
    
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }
    
    .stat-card {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        border-left: 4px solid #28a745;
    }
    
    .stat-card h3 {
        margin: 0;
        color: #666;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-card p {
        margin: 10px 0 0 0;
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }
    
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        display: inline-block;
    }
    
    .status-pending { background: #fff3cd; color: #856404; }
    .status-processing { background: #d1ecf1; color: #0c5460; }
    .status-shipped { background: #d4edda; color: #155724; }
    .status-delivered { background: #d1ecf1; color: #0c5460; }
    .status-cancelled { background: #f8d7da; color: #721c24; }
    
    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }
    
    .btn-small {
        padding: 4px 8px;
        font-size: 12px;
        text-decoration: none;
        border-radius: 3px;
        border: none;
        cursor: pointer;
        display: inline-block;
    }
    
    .btn-accept { background: #28a745; color: white; }
    .btn-process { background: #ffc107; color: #212529; }
    .btn-ship { background: #17a2b8; color: white; }
    .btn-deliver { background: #6f42c1; color: white; }
    .btn-cancel { background: #dc3545; color: white; }
    .btn-delete { background: #dc3545; color: white; }
    
    .btn-small:hover {
        opacity: 0.8;
        transform: translateY(-1px);
    }
    
    .no-orders {
        text-align: center;
        padding: 40px;
        color: #666;
    }
    
    .order-details-btn {
        background: #007bff;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        text-decoration: none;
        font-size: 12px;
        margin-right: 5px;
    }
    
    .order-details-btn:hover {
        background: #0056b3;
    }
    
    @media (max-width: 768px) {
        .product-table {
            font-size: 12px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .search-filter-container {
            width: 100%;
        }
        
        .search-box {
            min-width: 150px;
        }
    }
    </style>
</head>
<body>

<div class="sidebar">
    <h2><i class='bx bx-leaf'></i> Admin Panel</h2>
    <a href="admin_dashboard.php"><i class='bx bx-home'></i> Dashboard</a>
    <a href="admin_products.php"><i class='bx bx-cube'></i> Products</a>
    <a href="admin_orders.php" class="active"><i class='bx bx-cart'></i> Orders</a>
    <a href="admin_users.php"><i class='bx bx-user'></i> Users</a>
    <a href="logout.php"><i class='bx bx-log-out'></i> Logout</a>
</div>

<div class="main">
    <div class="orders-header">
        <h1><i class='bx bx-cart'></i> Manage Orders</h1>
        <div class="search-filter-container">
            <form method="GET" style="display: flex; gap: 10px; align-items: center;">
                <input type="text" name="search" class="search-box" placeholder="Search by customer name or order ID..." value="<?= htmlspecialchars($search) ?>">
                <select name="status_filter" class="filter-select">
                    <option value="">All Status</option>
                    <option value="Pending" <?= $status_filter == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Processing" <?= $status_filter == 'Processing' ? 'selected' : '' ?>>Processing</option>
                    <option value="Shipped" <?= $status_filter == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                    <option value="Delivered" <?= $status_filter == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                    <option value="Cancelled" <?= $status_filter == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
                <button type="submit" class="btn-small btn-accept">
                    <i class='bx bx-search'></i> Search
                </button>
                <a href="admin_orders.php" class="btn-small btn-process">
                    <i class='bx bx-refresh'></i> Clear
                </a>
            </form>
        </div>
    </div>

    <!-- Order Statistics -->
    <div class="stats-container">
        <div class="stat-card">
            <h3>Total Orders</h3>
            <p><?= number_format($stats['total_orders']) ?></p>
        </div>
        <div class="stat-card">
            <h3>Pending Orders</h3>
            <p><?= number_format($stats['pending_orders']) ?></p>
        </div>
        <div class="stat-card">
            <h3>Shipped Orders</h3>
            <p><?= number_format($stats['shipped_orders']) ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Revenue</h3>
            <p>Rs. <?= number_format($stats['total_revenue'], 2) ?></p>
        </div>
    </div>

    <?php if ($result->num_rows > 0): ?>
    <div class="table-container">
        <table class="product-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><strong>#<?= $row['id'] ?></strong></td>
                    <td>
                        <div>
                            <strong><?= htmlspecialchars($row['customer_name']) ?></strong>
                            <?php if (isset($row['customer_email'])): ?>
                            <br><small><?= htmlspecialchars($row['customer_email']) ?></small>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td><strong>Rs. <?= number_format($row['total'], 2) ?></strong></td>
                    <td>
                        <span class="status-badge status-<?= strtolower($row['status']) ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                    <td>
                        <?= date('M d, Y', strtotime($row['created_at'])) ?><br>
                        <small><?= date('H:i A', strtotime($row['created_at'])) ?></small>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <!-- Status Update Buttons -->
                            <?php if ($row['status'] == 'Pending'): ?>
                                <a href="admin_orders.php?status=Processing&order_id=<?= $row['id'] ?>" 
                                   class="btn-small btn-process" title="Mark as Processing">
                                    <i class='bx bx-time'></i> Process
                                </a>
                                <a href="admin_orders.php?status=Shipped&order_id=<?= $row['id'] ?>" 
                                   class="btn-small btn-accept" title="Mark as Shipped">
                                    <i class='bx bx-check'></i> Ship
                                </a>
                            <?php elseif ($row['status'] == 'Processing'): ?>
                                <a href="admin_orders.php?status=Shipped&order_id=<?= $row['id'] ?>" 
                                   class="btn-small btn-ship" title="Mark as Shipped">
                                    <i class='bx bx-package'></i> Ship
                                </a>
                            <?php elseif ($row['status'] == 'Shipped'): ?>
                                <a href="admin_orders.php?status=Delivered&order_id=<?= $row['id'] ?>" 
                                   class="btn-small btn-deliver" title="Mark as Delivered">
                                    <i class='bx bx-check-circle'></i> Deliver
                                </a>
                            <?php endif; ?>
                            
                            <!-- Cancel Button (only for pending/processing orders) -->
                            <?php if (in_array($row['status'], ['Pending', 'Processing'])): ?>
                                <a href="admin_orders.php?status=Cancelled&order_id=<?= $row['id'] ?>" 
                                   class="btn-small btn-cancel" 
                                   onclick="return confirm('Are you sure you want to cancel this order?')"
                                   title="Cancel Order">
                                    <i class='bx bx-x'></i> Cancel
                                </a>
                            <?php endif; ?>
                            
                            <!-- Delete Button -->
                            <a href="admin_orders.php?delete=<?= $row['id'] ?>" 
                               class="btn-small btn-delete" 
                               onclick="return confirm('Are you sure you want to delete this order? This action cannot be undone.')"
                               title="Delete Order">
                                <i class='bx bx-trash'></i> Delete
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="no-orders">
        <i class='bx bx-cart' style="font-size: 48px; color: #ccc;"></i>
        <h3>No Orders Found</h3>
        <p>No orders match your search criteria.</p>
    </div>
    <?php endif; ?>
</div>

<script>
// Auto-refresh every 30 seconds for real-time updates
setTimeout(function(){
    window.location.reload();
}, 30000);

// Confirmation for status changes
document.querySelectorAll('.btn-small').forEach(function(btn) {
    if (btn.href && (btn.href.includes('status=') || btn.href.includes('delete='))) {
        btn.addEventListener('click', function(e) {
            if (btn.href.includes('status=Cancelled')) {
                if (!confirm('Are you sure you want to cancel this order?')) {
                    e.preventDefault();
                }
            } else if (btn.href.includes('delete=')) {
                if (!confirm('Are you sure you want to delete this order? This action cannot be undone.')) {
                    e.preventDefault();
                }
            }
        });
    }
});
</script>

</body>
</html>