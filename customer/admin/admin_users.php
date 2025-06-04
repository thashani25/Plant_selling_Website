<?php
session_start();
include 'conection.php';

// Handle user deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM register WHERE id = $id");
    header("Location: admin_users.php");
    exit();
}

// Fetch all users
$result = $conn->query("SELECT * FROM register ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users - Green Cactus</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    <?php include 'style.css'; ?>
    
    /* Enhanced styles for users management */
    .users-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .users-title {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #333;
        margin: 0;
    }
    
    .users-stats {
        display: flex;
        gap: 20px;
        align-items: center;
        background: #f8f9fa;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        border-left: 4px solid #28a745;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-item h4 {
        margin: 0;
        color: #666;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-item p {
        margin: 8px 0 0 0;
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }
    
    .search-container {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .search-box {
        padding: 10px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 25px;
        font-size: 14px;
        min-width: 300px;
        transition: all 0.3s ease;
    }
    
    .search-box:focus {
        outline: none;
        border-color: #28a745;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
    }
    
    .search-btn {
        background: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
    }
    
    .search-btn:hover {
        background: #218838;
        transform: translateY(-2px);
    }
    
    .table-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-top: 20px;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(45deg, #28a745, #20c997);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 16px;
        margin-right: 10px;
    }
    
    .user-info {
        display: flex;
        align-items: center;
    }
    
    .user-details {
        flex: 1;
    }
    
    .user-name {
        font-weight: bold;
        color: #333;
        margin: 0;
        font-size: 16px;
    }
    
    .user-email {
        color: #666;
        margin: 2px 0 0 0;
        font-size: 14px;
    }
    
    .user-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        background: #d4edda;
        color: #155724;
    }
    
    .user-id-badge {
        background: #007bff;
        color: white;
        padding: 4px 8px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: bold;
    }
    
    .date-info {
        color: #666;
        font-size: 14px;
    }
    
    .date-day {
        font-weight: bold;
        color: #333;
        display: block;
    }
    
    .date-time {
        font-size: 12px;
        color: #999;
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    
    .btn-view {
        background: #17a2b8;
        color: white;
        padding: 6px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: all 0.3s ease;
    }
    
    .btn-view:hover {
        background: #138496;
        transform: translateY(-1px);
    }
    
    .btn-delete {
        background: #dc3545;
        color: white;
        padding: 6px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: all 0.3s ease;
    }
    
    .btn-delete:hover {
        background: #c82333;
        transform: translateY(-1px);
    }
    
    .no-users {
        text-align: center;
        padding: 60px 20px;
        color: #666;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .no-users i {
        font-size: 64px;
        color: #ddd;
        margin-bottom: 20px;
    }
    
    .no-users h3 {
        color: #999;
        margin-bottom: 10px;
    }
    
    .export-btn {
        background: #6f42c1;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .export-btn:hover {
        background: #5a32a3;
        transform: translateY(-2px);
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        .users-header {
            flex-direction: column;
            align-items: stretch;
        }
        
        .users-stats {
            flex-direction: column;
            gap: 15px;
        }
        
        .search-box {
            min-width: 100%;
        }
        
        .search-container {
            flex-direction: column;
        }
        
        .product-table {
            font-size: 12px;
        }
        
        .user-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
        
        .user-avatar {
            width: 30px;
            height: 30px;
            font-size: 14px;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 4px;
        }
    }
    
    /* Hover effects for table rows */
    .product-table tbody tr {
        transition: all 0.3s ease;
    }
    
    .product-table tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    /* Animation for new elements */
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
    
    .table-container {
        animation: fadeInUp 0.6s ease-out;
    }
    </style>
</head>
<body>

<div class="sidebar">
    <h2><i class='bx bx-leaf'></i> Admin Panel</h2>
    <a href="admin_dashboard.php"><i class='bx bx-home'></i> Dashboard</a>
    <a href="admin_products.php"><i class='bx bx-cube'></i> Products</a>
    <a href="admin_orders.php"><i class='bx bx-cart'></i> Orders</a>
    <a href="admin_users.php" class="active"><i class='bx bx-user'></i> Users</a>
    <a href="logout.php"><i class='bx bx-log-out'></i> Logout</a>
</div>

<div class="main">
    <div class="users-header">
        <h1 class="users-title">
            <i class='bx bx-group'></i> 
            Manage Users
        </h1>
        <div style="display: flex; gap: 10px;">
            <button class="export-btn" onclick="exportUsers()">
                <i class='bx bx-download'></i> Export Users
            </button>
        </div>
    </div>

    <!-- User Statistics -->
    <div class="users-stats">
        <div class="stat-item">
            <h4>Total Users</h4>
            <p id="totalUsers"><?= $result->num_rows ?></p>
        </div>
        <div class="stat-item">
            <h4>Active Today</h4>
            <p>--</p>
        </div>
        <div class="stat-item">
            <h4>New This Week</h4>
            <p>--</p>
        </div>
        <div class="stat-item">
            <h4>Total Revenue</h4>
            <p>Rs. --</p>
        </div>
    </div>

    <!-- Search Functionality -->
    <div class="search-container">
        <input type="text" class="search-box" id="searchInput" placeholder="Search users by name, email, or ID..." onkeyup="searchUsers()">
        <button class="search-btn" onclick="clearSearch()">
            <i class='bx bx-refresh'></i> Clear
        </button>
    </div>

    <?php if ($result->num_rows > 0): ?>
    <div class="table-container">
        <table class="product-table" id="usersTable">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>User Information</th>
                    <th>Email Address</th>
                    <th>Registration Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr class="user-row">
                    <td>
                        <span class="user-id-badge">#<?= $row['id'] ?></span>
                    </td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">
                                <?= strtoupper(substr($row['name'], 0, 1)) ?>
                            </div>
                            <div class="user-details">
                                <p class="user-name"><?= htmlspecialchars($row['name']) ?></p>
                                <small style="color: #666;">Member since <?= date('M Y', strtotime($row['created_at'])) ?></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong><?= htmlspecialchars($row['email']) ?></strong>
                            <br>
                            <small style="color: #28a745;">
                                <i class='bx bx-check-circle'></i> Verified
                            </small>
                        </div>
                    </td>
                    <td>
                        <div class="date-info">
                            <span class="date-day"><?= date('M d, Y', strtotime($row['created_at'])) ?></span>
                            <span class="date-time"><?= date('H:i A', strtotime($row['created_at'])) ?></span>
                        </div>
                    </td>
                    <td>
                        <span class="user-status">Active</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="#" class="btn-view" onclick="viewUser(<?= $row['id'] ?>)" title="View Details">
                                <i class='bx bx-show'></i> View
                            </a>
                            <a href="admin_users.php?delete=<?= $row['id'] ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')"
                               title="Delete User">
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
    <div class="no-users">
        <i class='bx bx-user-x'></i>
        <h3>No Users Found</h3>
        <p>No registered users in the system yet.</p>
    </div>
    <?php endif; ?>
</div>

<script>
// Search functionality
function searchUsers() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('usersTable');
    const rows = table.getElementsByClassName('user-row');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const name = row.cells[1].textContent.toLowerCase();
        const email = row.cells[2].textContent.toLowerCase();
        const id = row.cells[0].textContent.toLowerCase();
        
        if (name.includes(filter) || email.includes(filter) || id.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

// Clear search
function clearSearch() {
    document.getElementById('searchInput').value = '';
    searchUsers();
}

// View user details (placeholder function)
function viewUser(userId) {
    alert('View user details for ID: ' + userId + '\n\nThis feature can be implemented to show detailed user information, order history, etc.');
}

// Export users functionality (placeholder)
function exportUsers() {
    alert('Export functionality can be implemented here to generate CSV/Excel file with user data.');
}

// Enhanced delete confirmation
document.querySelectorAll('.btn-delete').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        const userName = this.closest('tr').querySelector('.user-name').textContent;
        if (!confirm(`Are you sure you want to delete user "${userName}"?\n\nThis action cannot be undone and will remove all user data.`)) {
            e.preventDefault();
        }
    });
});

// Add loading animation on page actions
document.querySelectorAll('a[href*="delete"]').forEach(function(link) {
    link.addEventListener('click', function() {
        if (confirm('Delete user?')) {
            // Show loading state
            this.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Deleting...';
            this.style.pointerEvents = 'none';
        }
    });
});
</script>

</body>
</html>