<?php
include 'conection.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please <a href='login.php'>login</a> to view your wishlist.");
}

$user_id = $_SESSION['user_id'];

// Delete item from wishlist
if (isset($_POST['delete'])) {
    $wishlist_id = $_POST['wishlist_id'];
    $delete_query = $conn->prepare("DELETE FROM wishlist WHERE id = ? AND user_id = ?");
    $delete_query->bind_param("ii", $wishlist_id, $user_id);
    $delete_query->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Wishlist - Green Cactus</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>My Wishlist</h1>
    </div>
    <div class="title2">
       <div class="title2"><a href="home.php">Home</a><span> / whishlist</span></div>
    </div>

    <div class="gallery">
        <?php
        $stmt = $conn->prepare("SELECT wishlist.id AS wid, products.* FROM wishlist JOIN products ON wishlist.product_id = products.id WHERE wishlist.user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($product = $result->fetch_assoc()) {
                echo '<div class="product-box">';
                echo "<h2>" . htmlspecialchars($product['name']) . "</h2>";
                echo "<p>R.S. " . htmlspecialchars($product['price']) . "</p>";
                echo "<img src='" . htmlspecialchars($product['image']) . "' alt='" . htmlspecialchars($product['name']) . "'>";

                echo '<form method="post">';
                echo '<input type="hidden" name="wishlist_id" value="' . $product['wid'] . '">';
                echo '<button type="submit" name="delete" class="btn">Remove</button>';
                echo '</form>';

                echo '<form action="checkout.php" method="POST">';
                echo '<input type="hidden" name="product_id" value="' . $product['id'] . '">';
                echo '<input type="number" name="qty" value="1" min="1" max="99" class="qty" required>';
                echo '<button type="submit" name="add_to_cart" class="buy-btn">Buy Now</button>';
                echo '</form>';

                echo '</div>';
            }
        } else {
            echo '<p style="text-align:center;">Your wishlist is empty.</p>';
        }

        $stmt->close();
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
