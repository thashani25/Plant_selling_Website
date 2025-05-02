<?php 
 include 'conection.php'; 



//--adding products in wishist-->

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
    echo "<h2>" . $row['name'] . "</h2>";
    echo "<p>$" . $row['price'] . "</p>";
    echo "<img src='" . $row['image'] . "'>";
}


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
    <title>Green Cafee - shop page</title>
   
</head>
<body>
<?php include 'header.php';
?>
  <div class="main">
    <div class="banner">
        <h1>shop </h1>
     </div>
     <div class="title2">
        <a href="home.php">home</a><span>our shop</span> 
     </div>

<!--- gallary--->

<div class="gallery">
  <div class="product-box">
    <img src="img/7a.jpg" alt="">
    <div class="product-info">
      <h2 class="product-title">Power Puff</h2>
      <p class="product-price">R.s. 900.00</p>
      <button class="buy-btn">Buy Now</button>
    </div>
    <div class="icon-dropdown">
      <button class="icon-button">👤</button>
      <div class="icon-menu">
        <a href="#"><span>🛒</span>Cart</a>
        <a href="#"><span>❤️</span>Wishlist</a>
        <a href="view_page.php"><span>🔐</span>Profile</a>
      </div>
    </div>
    <div class="flex">
      <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
    </div>
  </div>



  <div class="gallery">
  <div class="product-box">
    <img src="img/9a.jpg" alt="">
    <div class="product-info">
      <h2 class="product-title">Power Puff</h2>
      <p class="product-price">R.S.600.00</p>
      <button class="buy-btn">Buy Now</button>
    </div>
    <div class="icon-dropdown">
      <button class="icon-button">👤</button>
      <div class="icon-menu">
        <a href="#"><span>🛒</span>Cart</a>
        <a href="#"><span>❤️</span>Wishlist</a>
        <a href="view_page.php"><span>🔐</span>Profile</a>
      </div>
    </div>
    <div class="flex">
      <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
    </div>
  </div>

  <div class="gallery">
  <div class="product-box">
    <img src="img/5a.jpg" alt="">
    <div class="product-info">
      <h2 class="product-title">Power Puff</h2>
      <p class="product-price">R.S.900.00</p>
      <button class="buy-btn">Buy Now</button>
    </div>
    <div class="icon-dropdown">
      <button class="icon-button">👤</button>
      <div class="icon-menu">
        <a href="#"><span>🛒</span>Cart</a>
        <a href="#"><span>❤️</span>Wishlist</a>
        <a href="view_page.php"><span>🔐</span>Profile</a>
      </div>
    </div>
    <div class="flex">
      <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
    </div>
  </div>


  <div class="gallery">
  <div class="product-box">
    <img src="img/12a.jpg" alt="">
    <div class="product-info">
      <h2 class="product-title">Power Puff</h2>
      <p class="product-price">R.S.500.00</p>
      <button class="buy-btn">Buy Now</button>
    </div>
    <div class="icon-dropdown">
      <button class="icon-button">👤</button>
      <div class="icon-menu">
        <a href="#"><span>🛒</span>Cart</a>
        <a href="#"><span>❤️</span>Wishlist</a>
        <a href="view_page.php"><span>🔐</span>Profile</a>
      </div>
    </div>
    <div class="flex">
      <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
    </div>
  </div>


  <div class="gallery">
  <div class="product-box">
    <img src="img/13a.jpg" alt="">
    <div class="product-info">
      <h2 class="product-title">Power Puff</h2>
      <p class="product-price">R.S.300.00</p>
      <button class="buy-btn">Buy Now</button>
    </div>
    <div class="icon-dropdown">
      <button class="icon-button">👤</button>
      <div class="icon-menu">
        <a href="#"><span>🛒</span>Cart</a>
        <a href="#"><span>❤️</span>Wishlist</a>
        <a href="view_page.php"><span>🔐</span>Profile</a>
      </div>
    </div>
    <div class="flex">
      <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
    </div>
  </div>



  <div class="gallery">
  <div class="product-box">
    <img src="img/14a.jpg" alt="">
    <div class="product-info">
      <h2 class="product-title">Power Puff</h2>
      <p class="product-price">R.S.650.00</p>
      <button class="buy-btn">Buy Now</button>
    </div>
    <div class="icon-dropdown">
      <button class="icon-button">👤</button>
      <div class="icon-menu">
        <a href="#"><span>🛒</span>Cart</a>
        <a href="#"><span>❤️</span>Wishlist</a>
        <a href="view_page.php"><span>🔐</span>Profile</a>
      </div>
    </div>
    <div class="flex">
      <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
    </div>
  </div>



</div>
</div>
</div>
</div>
</div>


  <!-- Repeat .product-box as needed -->

</div>
              <?php include 'footer.php'; ?> 
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>



    
</body>
</html>