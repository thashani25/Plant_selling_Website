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
    <title>Green Cactus - wishist </title>
   
</head>
<body>
<?php include 'header.php';
?>
  <div class="main">
    <div class="banner">
        <h1> my whishlist </h1>
     </div>
     <div class="title2">
        <a href="home.php">home</a><span>/ whishlist</span> 
     </div>
     <section class="products">
        <h1 class="title">products added in wishist </h1>
        <div class="box-container">
            
         
</section>
    



 

              <?php include 'footer.php'; ?> 
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>



    
</body>
</html>