<?php 
 include 'conection.php'; ?>

 <style type="text/css">
    <?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Green Cactus - about us page</title>
   
</head>
<body>
  <?php include 'header.php';?>
  <div class="main">
    <div class="banner">
        <h1>about us </h1>
     </div>
     <div class="title2">
      <div class="title2"><a href="home.php">Home</a><span> / about</span></div>
     </div>
     
    <section class="services">
        <div class="title">
            <img src="img/logo.png" class="logo">
            <h1></h1>
            <p></p>
         </div>
           
            <div class="box-container">
                <div class="box">
                    <img src="img/icon2.png">
                    <div class="detail">
                        <h3>great savings</h3>
                        <p>save big every oder</p>
                     </div>
                </div>
                <div class="box">
                    <img src="img/icon1.png">
                    <div class="detail">
                        <h3>24*7 support</h3>
                        <p>one on one support</p>
                     </div>
                </div>
                <div class="box">
                    <img src="img/icon0.png">
                    <div class="detail">
                        <h3>gift vauchers</h3>
                        <p>vauchers on every festivels</p>
                     </div>
                </div>
                <div class="box">
                    <img src="img/icon.png">
                    <div class="detail">
                        <h3>worldwide delevery</h3>
                        <p>dropship worldwide</p>
                     </div>
                </div>
            </div>
         </section>
         
        <div class="testimonial-container">
            <div class="title">
                
                <h1>what pepole say about us</h1>
                <p> the customer feedback for our service </p>
                </div>
                <div class="container">
                    <div class="testimonial-item active">
                       <img src="img/omesh.jpg"> 
                       <h1> Omesh Tharaka</h1>
                       <p></p>
                     </div>
                     <div class="testimonial-item">
                       <img src="img/kalani.jpg"> 
                       <h1>Kalani Lanka</h1>
                       <p> </p>
                     </div>
                     <div class="testimonial-item">
                       <img src="img/chamo.jpg"> 
                       <h1>Chamodya Nimeshi</h1>
                       <p>  </p>
                     </div>
                     <div class="left-arrow" onclick="nextSlide()"><i class="bx bxs-left-arrow-alt"></i></div>
                     <div class="right-arrow" onclick="prevSlide()"><i class="bx bxs-right-arrow-alt"></i></div>
                </div>
        </div>
        







                        














              <?php include 'footer.php'; ?> 
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>



    
</body>
</html>