<?php 
session_start(); 
include 'conection.php';  

// Get product ID from URL 
if (!isset($_GET['id'])) {     
    header('Location: admin_products.php');     
    exit(); 
}  

$id = intval($_GET['id']); 
$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();  

// Handle form submission 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {     
    $name  = $conn->real_escape_string($_POST['name']);     
    $price = floatval($_POST['price']);          
    
    // Handle optional image upload     
    if (!empty($_FILES['image']['name'])) {         
        $image = 'uploads/' . basename($_FILES['image']['name']);         
        move_uploaded_file($_FILES['image']['tmp_name'], $image);         
        $conn->query("UPDATE products SET name='$name', price=$price, image='$image' WHERE id = $id");     
    } else {         
        $conn->query("UPDATE products SET name='$name', price=$price WHERE id = $id");     
    }      
    
    header('Location: admin_products.php');     
    exit(); 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Green Cactus Admin</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, #2c5530 0%, #3a7040 100%);
            color: white;
            padding: 30px 0;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 24px;
            font-weight: 600;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar h2 i {
            font-size: 28px;
            color: #90ee90;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 30px;
            color: #e0e0e0;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            font-size: 16px;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: #90ee90;
            transform: translateX(5px);
        }

        .sidebar a.active {
            background: rgba(144,238,144,0.2);
            color: #90ee90;
            border-left-color: #90ee90;
        }

        .sidebar a i {
            font-size: 20px;
            width: 25px;
        }

        .main {
            margin-left: 280px;
            padding: 40px;
            min-height: 100vh;
        }

        .main-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .main h1 {
            color: #2c5530;
            font-size: 32px;
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 0 0 30px 0;
        }

        .main h1::before {
            content: '';
            width: 4px;
            height: 40px;
            background: linear-gradient(135deg, #90ee90, #2c5530);
            border-radius: 2px;
        }

        .back-button {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 30px;
            width: fit-content;
        }

        .back-button:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 800px;
        }

        .form-header {
            background: linear-gradient(135deg, #2c5530, #3a7040);
            color: white;
            padding: 25px 30px;
            text-align: center;
        }

        .form-header h2 {
            font-size: 24px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .form-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .form-box {
            padding: 40px;
        }

        .form-grid {
            display: grid;
            gap: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            color: #2c5530;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group input {
            padding: 15px;
            border: 2px solid #e0e6ed;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #90ee90;
            background: white;
            box-shadow: 0 0 0 3px rgba(144,238,144,0.1);
        }

        .image-preview-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            border: 2px dashed #e0e6ed;
            transition: all 0.3s ease;
        }

        .image-preview-container:hover {
            border-color: #90ee90;
            background: #f0f8f0;
        }

        .current-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 15px;
            object-fit: cover;
        }

        .image-info {
            background: #e8f5e8;
            color: #2c5530;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .file-input-wrapper {
            position: relative;
            display: inline-block;
            cursor: pointer;
            width: 100%;
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-display {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            background: white;
            border: 2px solid #e0e6ed;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 16px;
            color: #666;
        }

        .file-input-wrapper:hover .file-input-display {
            border-color: #90ee90;
            background: #f0f8f0;
            color: #2c5530;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            justify-content: center;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-width: 150px;
            justify-content: center;
            background: linear-gradient(135deg, #90ee90, #2c5530);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(144,238,144,0.3);
        }

        .btn-back {
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-width: 150px;
            justify-content: center;
            background: #6c757d;
            color: white;
        }

        .btn-back:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .product-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #90ee90;
        }

        .product-info h3 {
            color: #2c5530;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-id {
            background: #e8f5e8;
            color: #2c5530;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .main-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .form-box {
                padding: 20px;
            }

            .button-group {
                flex-direction: column;
            }

            .btn, .btn-back {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2><i class='bx bx-leaf'></i> Admin Panel</h2>
    <a href="admin_dashboard.php"><i class='bx bx-home'></i> Dashboard</a>
    <a href="admin_products.php" class="active"><i class='bx bx-cube'></i> Products</a>
    <a href="admin_orders.php"><i class='bx bx-cart'></i> Orders</a>
    <a href="admin_users.php"><i class='bx bx-user'></i> Users</a>
    <a href="logout.php"><i class='bx bx-log-out'></i> Logout</a>
</div>

<div class="main">
    <h1><i class='bx bx-edit'></i> Edit Product</h1>
    
    <a href="admin_products.php" class="back-button">
        <i class='bx bx-arrow-back'></i> Back to Products
    </a>
    
    <div class="form-container">
        <div class="form-header">
            <h2><i class='bx bx-edit-alt'></i> Update Product Details</h2>
            <p>Modify the product information below</p>
        </div>
        
        <form method="POST" enctype="multipart/form-data" class="form-box">
            <div class="product-info">
                <h3><i class='bx bx-info-circle'></i> Product Information <span class="product-id">ID: <?= $product['id'] ?></span></h3>
                <p>Currently editing: <strong><?= htmlspecialchars($product['name']) ?></strong></p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="name"><i class='bx bx-rename'></i> Product Name:</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required placeholder="Enter product name">
                </div>

                <div class="form-group">
                    <label for="price"><i class='bx bx-money'></i> Price (Rs.):</label>
                    <input type="number" id="price" name="price" step="0.01" value="<?= $product['price'] ?>" required placeholder="0.00" min="0">
                </div>

                <div class="form-group">
                    <label><i class='bx bx-image'></i> Current Image:</label>
                    <div class="image-preview-container">
                        <img src="<?= htmlspecialchars($product['image']) ?>" class="current-image" alt="Current product image">
                        <div class="image-info">
                            <i class='bx bx-check-circle'></i> Current product image
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="image"><i class='bx bx-cloud-upload'></i> Change Image (Optional):</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="image" name="image" accept="image/*">
                        <div class="file-input-display">
                            <i class='bx bx-upload'></i>
                            <span>Choose new image file</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn">
                    <i class='bx bx-save'></i> Update Product
                </button>
                <a href="admin_products.php" class="btn-back">
                    <i class='bx bx-arrow-back'></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // File input preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const display = document.querySelector('.file-input-display span');
        
        if (file) {
            display.textContent = file.name;
            
            // Create preview of new image
            const reader = new FileReader();
            reader.onload = function(e) {
                const currentImage = document.querySelector('.current-image');
                currentImage.src = e.target.result;
                document.querySelector('.image-info').innerHTML = '<i class="bx bx-image"></i> New image selected';
            };
            reader.readAsDataURL(file);
        } else {
            display.textContent = 'Choose new image file';
        }
    });

    // Form validation
    document.getElementById('name').addEventListener('input', function() {
        if (this.value.length < 2) {
            this.style.borderColor = '#dc3545';
        } else {
            this.style.borderColor = '#90ee90';
        }
    });

    document.getElementById('price').addEventListener('input', function() {
        if (this.value <= 0) {
            this.style.borderColor = '#dc3545';
        } else {
            this.style.borderColor = '#90ee90';
        }
    });

    // Initialize form
    document.addEventListener('DOMContentLoaded', function() {
        // Focus on the first input
        document.getElementById('name').focus();
        
        // Add validation styles
        setTimeout(() => {
            document.getElementById('name').style.borderColor = '#90ee90';
            document.getElementById('price').style.borderColor = '#90ee90';
        }, 500);
    });
</script>

</body>
</html>