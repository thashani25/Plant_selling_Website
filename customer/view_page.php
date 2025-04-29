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
    <title>Green Cafee - product details page</title>
   
</head>
<body>
<?php include 'header.php';
?>
  <div class="main">
    <div class="banner">
        <h1>products details </h1>
     </div>
     <div class="title2">
        <a href="home.php">home</a><span>product details</span> 
     </div>
     <section class="view_page">
       
          <form>
          <img src="img/about1.png" alt="">
          <div class="details">
            <div class="price">R.S.650.00</div>
            <div class="name">pmkkbb</div>
            <div class="product-details">
                <p> Ljkklll;asskldhxkepfjkcifjvnfndfj vnffbdkpodf jcdhagvepgv
                    mndiwudfwi hceiogeioh p[ascwofjfjcshufhghghoigh] 
                    nvchv fdhfvaqupfledfgv dhufiv hfg vbeiohh </p>
            </div>
            <input type="hidden" name="product_id">
            <div class="button">
                <button type="submit" name="add_to_wishlist" class="btn">add to wishist<i class="bx bx-heart"></i></button>
                <input type="hidden" name="qty" value="1" min="0" class="quantity">
                <button type="submit" name="add_to_cart" class="btn">add to cart<i class="bx bx-cart"></i></button>
               </form>
          <?php
               

          ?>
</section>
    



 

              <?php include 'footer.php'; ?> 
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>



    
</body>
</html>