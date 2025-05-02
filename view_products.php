<?php 
 include 'conection.php'; 

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
    <title>Green Cactus - products </title>
   
</head>
<body>
<?php include 'header.php';
?>
  <div class="main">
    <div class="banner">
        <h1> products details </h1>
     </div>
     <div class="title2">
        <a href="home.php">home</a><span>/ products</span> 
     </div>
    

     <?php




// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the product ID from the URL
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']); // Sanitize input

    // SQL to get product details
    $sql = "SELECT * FROM view_products WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
        ?>

        <!-- HTML to show product -->
        <h2><?= htmlspecialchars($product['name']); ?></h2>
        <img src="images/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" width="300">
        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($product['description'])); ?></p>
        <p><strong>Price:</strong> $<?= htmlspecialchars($product['price']); ?></p>

        <?php
    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>No product ID specified.</p>";
}

$conn->close();
?>




 

              <?php include 'footer.php'; ?> 
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>



    
</body>
</html>