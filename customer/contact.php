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
    <title>Green Cafee - contact page</title>
   
</head>
<body>
<?php include 'header.php';?>
  <div class="main">
    <div class="banner">
        <h1>contact us </h1>
     </div>
     <div class="title2">
        <a hrfe="home.php">home</a><span>contact</span> 
     </div>
<section class="services">
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
         <div class="form-container">
            <form method="post">
                <div class="title">
                    <img src="img/logo.png" class="logo">
                    <h1>leave a message</h1>
                </div>
                <div class="input-field">
                    <p>your name <sub>*</sub></p>
                    <input type="text" name="name">
                </div>
                <div class="input-field">
                    <p>your email<sub>*</sub></p>
                    <input type="email" name="email">
                </div>
                <div class="input-field">
                    <p>your number <sub>*</sub></p>
                    <input type="number" name="number">
                </div>
                <div class="input-field">
                    <p>your message <sub>*</sub></p>
                    <textarea name="message"></textarea>
                </div>
                <button type="submit" name="submit-btn" class="btn">send message</button>
            </form>
         </div>
         <div class="address">
            <div class="title">
                    <img src="img/logo.png" class="logo">
                    <h1>contact detail</h1>
                    <p>contacct us for this</p>
                </div>
                <div class="box-container">
                    <div class="box">
                        <i class="bx bxs-map-pin"></i>
                        <div>
                            <h4>address</h4>
                            <p>1092 buttala, uva-pellwatta</p>
                         </div>
                    </div>
                    <div class="box">
                        <i class="bx bxs-phone-call"></i>
                        <div>
                            <h4>phone number</h4>
                            <p>0783740204</p>
                         </div>
                    </div>
                    <div class="box">
                        <i class="bx bxs-map-pin"></i>
                        <div>
                            <h4>email</h4>
                            <p>piyunilthashani4@gmail.com</p>
                         </div>
                    </div>
                 </div>
             </div>

       
     



                        














              <?php include 'footer.php'; ?> 
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>



    
</body>
</html>