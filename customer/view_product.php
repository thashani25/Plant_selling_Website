<?php
include 'conection.php';
session_start();
$user_id = $_SESSION['user_id'] ?? null;
$message = ''; // Initialize message variable for success/error
?>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Green Cactus - Shop Page</title>
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>Shop</h1>
    </div>
    <div class="title2">
        <div class="title2"><a href="home.php">Home</a><span> / view products </span></div>
    </div>

    <div class="gallery">
        <?php
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
        ?>

            <div class="product-box">
                <h2><?= htmlspecialchars($row['name']); ?></h2>
                <p>Rs. <?= htmlspecialchars($row['price']); ?></p>
                <img src="<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['name']); ?>">

                <!-- Display success/error message -->
                <?php if (isset($_GET['message'])): ?>
                    <div class="alert"><?= htmlspecialchars($_GET['message']); ?></div>
                <?php endif; ?>

                <form action="cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?= $row['id']; ?>">

                    <!-- Quantity 
                    <input type="number" name="qty" value="1" min="1" max="99" class="qty" required> --->

                    <!-- Action buttons row -->
                    <div class="action-row">
                        <!-- Add to Cart -->
                        <button type="submit" name="add_to_cart" title="Add to Cart">
                            <i class="bx bx-cart"></i> 
                        </button>

                        <!-- Buy Now -->
                        <button type="button" onclick="buyNow(this.form)" title="Buy Now">
                            <i class="bx bx-credit-card"></i> 
                        </button>

                        <!-- Add to Wishlist -->
                        <a href="wishlist.php?product_id=<?= $row['id']; ?>" title="Add to Wishlist">
                            <i class="bx bx-heart"></i> 
                        </a>

                        <!-- View Product -->
                        <a href="view_page.php?pid=<?= $row['id']; ?>" title="View Product">
                            <i class="bx bxs-show"></i> 
                        </a>
                    </div>
                </form>
            </div>

        <?php
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include 'alert.php'; ?>

</body>
</html>


