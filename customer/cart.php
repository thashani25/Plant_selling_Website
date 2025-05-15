<?php
include 'conection.php';
session_start();
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
    <title>Green Cactus - Cart</title>
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>Add to Cart</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a><span>/ Add to Cart</span> 
    </div>

    <div class="gallery">
        <?php
        $result = $conn->query("SELECT * FROM products");
        if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                $price = $row['price'];
                $default_qty = 1;
                $total = $price * $default_qty;
        ?>
            <div class="box" id="product_<?= $row['id'] ?>">
                <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <span>Price: Rs. <?= number_format($price, 2) ?></span><br>

                <label for="qty_<?= $row['id'] ?>">Qty:</label>
                <input type="number" id="qty_<?= $row['id'] ?>" name="qty" value="1" min="1" max="99" class="qty" onchange="updateTotal(<?= $row['id'] ?>, <?= $price ?>)">

                <div id="total_<?= $row['id'] ?>">Total: Rs. <?= number_format($total, 2) ?></div>

                <div class="content">
    <?php if (isset($_SESSION['username'])): ?>
        <a href="checkout.php?action=add&id=<?= $row['id'] ?>&qty=1" onclick="return confirm('Add to cart?')">Add To Cart</a>
        <a href="Cart/buy_now.php?id=<?= $row['id'] ?>" class="btn buy-now">Buy Now</a>
        <button class="btn" onclick="goTocheckout(<?= $row['id'] ?>)">Checkout</button>
        <button class="btn remove-btn" onclick="removeProduct(<?= $row['id'] ?>)">Remove</button>
    
        <?php else: ?>
        <a href="checkout.php">Checkout</a>
    <?php endif; ?>
</div>


            </div>
        <?php
            endwhile;
        else:
            echo "<p>No products found.</p>";
        endif;
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
function updateTotal(id, price) {
    const qty = document.getElementById('qty_' + id).value;
    const total = price * qty;
    document.getElementById('total_' + id).innerText = 'Total: Rs. ' + total.toFixed(2);
}

function goToCheckout(id) {
    const qty = document.getElementById('qty_' + id).value;
    window.location.href = 'checkout.php?product_id=' + id + '&qty=' + qty;
}




</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include 'alert.php'; ?>

</body>
</html>
