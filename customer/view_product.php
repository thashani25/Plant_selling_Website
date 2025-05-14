
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
  <?php
  $sql = "SELECT * FROM products";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
      echo '<div class="product-box">';
      echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
      echo "<p>R.S. " . htmlspecialchars($row['price']) . "</p>";
      echo "<img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
      ?>
      <form action="" method="post" class="box">
  <div class="button">
    <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
    <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
    <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="bx bxs-show"></a>
</div>
  
  </form>
  <form action="wishlist.php" method="post" class="box">
  <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
  <div class="button">
    <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
    <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
    <a href="view_page.php?pid=<?php echo $row['id']; ?>" class="bx bxs-show"></a>
  </div>
</form>


</form>
  <form action="cart.php" method="post" class="box">
  <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
  <div class="button">
    <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
    <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
    <a href="view_page.php?pid=<?php echo $row['id']; ?>" class="bx bxs-show"></a>
  </div>
</form>

      <?php
      // Buy Now Button with a form
      echo '<form action="checkout.php" method="POST">';
      echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
      echo '<input type="number" name="qty" value="1" min="1" max="99" class="qty" required>';
      echo '<button type="submit" name="add_to_cart" class="buy-btn">Buy Now</button>';
      echo '</form>';
      
      echo '</div>';
    
  }
  ?>
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