<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Admin Panel</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg,rgb(85, 175, 126) 0%,rgb(75, 162, 97) 100%);
            min-height: 100vh;
            display: flex;
        }

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

        .main {
            margin-left: 280px;
            padding: 2rem;
            flex: 1;
        }

        /* Back button at the top */
        .back-nav {
            margin-bottom: 1.5rem;
        }

        .btn-back-nav {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.8rem 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            backdrop-filter: blur(10px);
        }

        .btn-back-nav:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-back-nav i {
            font-size: 1.2rem;
        }

        h1 {
            color: white;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .form-box {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 600px;
        }

        .error-message {
            background: rgba(244, 67, 54, 0.1);
            color: #d32f2f;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #f44336;
            display: none;
        }

        .success-message {
            background: rgba(76, 175, 80, 0.1);
            color: #388e3c;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #4caf50;
            display: none;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 600;
            font-size: 1rem;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            outline: none;
            border-color:rgb(152, 221, 173);
            box-shadow: 0 0 0 3px rgba(102, 234, 113, 0.1);
            transform: translateY(-2px);
        }

        .file-input-wrapper {
            position: relative;
            margin-bottom: 2rem;
        }

        input[type="file"] {
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
            gap: 1rem;
            padding: 2rem;
            border: 2px dashed #e0e0e0;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
        }

        .file-input-display:hover {
            border-color:rgb(102, 234, 153);
            background: rgba(102, 126, 234, 0.05);
        }

        .file-input-display i {
            font-size: 2rem;
            color:rgb(102, 234, 135);
        }

        .file-info {
            color: #666;
            font-size: 0.9rem;
        }

        .file-selected {
            color: #4caf50;
            font-weight: 600;
        }

        .image-preview {
            margin-top: 1rem;
            text-align: center;
            display: none;
        }

        .image-preview img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn {
            background: linear-gradient(135deg,rgb(102, 234, 135) 0%,rgb(75, 162, 108) 100%);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            margin-right: 1rem;
            box-shadow: 0 4px 15px rgba(102, 234, 153, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-back {
            background: linear-gradient(135deg,rgb(149, 166, 156) 0%,rgb(127, 141, 133) 100%);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(149, 165, 166, 0.3);
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(149, 165, 166, 0.4);
        }

        .btn-view {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        .button-group {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
                padding: 1rem;
            }

            .form-box {
                padding: 2rem;
            }

            h1 {
                font-size: 2rem;
            }

            .button-group {
                flex-direction: column;
            }

            .btn, .btn-back, .btn-view {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }

        .loading {
            display: none;
            text-align: center;
            margin-top: 1rem;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solidrgb(102, 234, 157);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><i class='bx bx-leaf'></i> Admin Panel</h2>
        <a href="#dashboard"><i class='bx bx-home'></i> Dashboard</a>
        <a href="#products" class="active"><i class='bx bx-cube'></i> Products</a>
        <a href="#orders"><i class='bx bx-cart'></i> Orders</a>
        <a href="#users"><i class='bx bx-user'></i> Users</a>
        <a href="#logout"><i class='bx bx-log-out'></i> Logout</a>
    </div>

    <div class="main">
        <!-- Back navigation button at the top -->
        <div class="back-nav">
            <button class="btn-back-nav" onclick="goBack()">
                <i class='bx bx-arrow-back'></i>
                Back
            </button>
        </div>

        <h1>Add New Product</h1>

        <div class="form-box">
            <div class="error-message" id="errorMessage">
                Please fill in all fields and upload an image.
            </div>

            <div class="success-message" id="successMessage">
                Product added successfully!
            </div>

            <form id="productForm" enctype="multipart/form-data">
                <label for="productName">Product Name</label>
                <input type="text" id="productName" name="name" required>

                <label for="productPrice">Product Price (Rs.)</label>
                <input type="number" id="productPrice" name="price" step="0.01" min="0" required>

                <label>Product Image</label>
                <div class="file-input-wrapper">
                    <input type="file" id="productImage" name="image" accept="image/*" required>
                    <div class="file-input-display" id="fileDisplay">
                        <i class='bx bx-cloud-upload'></i>
                        <div>
                            <div class="file-info" id="fileInfo">Click to upload product image</div>
                            <small style="color: #999;">JPG, PNG, GIF up to 5MB</small>
                        </div>
                    </div>
                </div>

                <div class="image-preview" id="imagePreview">
                    <img id="previewImg" src="" alt="Preview">
                </div>

                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    <p>Adding product...</p>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn">Add Product</button>
                    <a href="../view_product.php" class="btn-view">View Products</a>
                    <button type="button" class="btn-back" onclick="goBack()">
                        <i class='bx bx-arrow-back'></i>
                        Back
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Back button functionality
        function goBack() {
            // Check if there's a previous page in history
            if (window.history.length > 1) {
                window.history.back();
            } else {
                // If no history, go to a default page (products page)
                window.location.href = '#products';
                // Or you could use a specific URL like:
                // window.location.href = 'products.php';
            }
        }

        // Alternative back function with confirmation if form has data
        function goBackWithConfirmation() {
            const form = document.getElementById('productForm');
            const formData = new FormData(form);
            let hasData = false;
            
            // Check if form has any data
            for (let [key, value] of formData.entries()) {
                if (value && value.toString().trim() !== '') {
                    hasData = true;
                    break;
                }
            }
            
            if (hasData) {
                if (confirm('You have unsaved changes. Are you sure you want to go back?')) {
                    goBack();
                }
            } else {
                goBack();
            }
        }

        // File input handling
        const fileInput = document.getElementById('productImage');
        const fileDisplay = document.getElementById('fileDisplay');
        const fileInfo = document.getElementById('fileInfo');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                fileInfo.textContent = file.name;
                fileInfo.classList.add('file-selected');
                
                // Show image preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                fileInfo.textContent = 'Click to upload product image';
                fileInfo.classList.remove('file-selected');
                imagePreview.style.display = 'none';
            }
        });

        // Form submission handling
        const form = document.getElementById('productForm');
        const errorMessage = document.getElementById('errorMessage');
        const successMessage = document.getElementById('successMessage');
        const loading = document.getElementById('loading');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Hide previous messages
            errorMessage.style.display = 'none';
            successMessage.style.display = 'none';
            
            // Get form data
            const formData = new FormData(form);
            const name = formData.get('name').trim();
            const price = formData.get('price');
            const image = formData.get('image');
            
            // Basic validation
            if (!name || !price || !image.name) {
                errorMessage.style.display = 'block';
                errorMessage.scrollIntoView({ behavior: 'smooth' });
                return;
            }
            
            if (parseFloat(price) <= 0) {
                errorMessage.textContent = 'Price must be greater than 0.';
                errorMessage.style.display = 'block';
                errorMessage.scrollIntoView({ behavior: 'smooth' });
                return;
            }
            
            // Show loading
            loading.style.display = 'block';
            
            // Simulate form submission (replace with actual submission logic)
            setTimeout(() => {
                loading.style.display = 'none';
                successMessage.style.display = 'block';
                successMessage.scrollIntoView({ behavior: 'smooth' });
                
                // Reset form after success
                setTimeout(() => {
                    form.reset();
                    fileInfo.textContent = 'Click to upload product image';
                    fileInfo.classList.remove('file-selected');
                    imagePreview.style.display = 'none';
                    successMessage.style.display = 'none';
                }, 2000);
            }, 1500);
        });

        // Sidebar mobile toggle (if needed)
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('open');
        }

        // Prevent accidental page leave with unsaved changes
        window.addEventListener('beforeunload', function(e) {
            const form = document.getElementById('productForm');
            const formData = new FormData(form);
            let hasData = false;
            
            for (let [key, value] of formData.entries()) {
                if (value && value.toString().trim() !== '') {
                    hasData = true;
                    break;
                }
            }
            
            if (hasData) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    </script>
</body>
</html>