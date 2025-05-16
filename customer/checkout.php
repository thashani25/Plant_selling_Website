<?php
include 'conection.php';
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Green Cactus</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>checkout summary</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a><span> / checkout summary </span>
    </div>

    <section class="checkout">
        <div class="title2">
            <img src="img/logo.png" class="logo">
            <h1>checkout summary </h1>
            <p>bbjxsdjweijfjdwebcqwoiodklc  cdbcdhc loqfkcvb olqlqkd cb okfcw </p>
        </div>
            <div class="row">
                <form method="post">
                    <h3>billing details</h3>
                    <div class="flex">
                        <div class="box">
                            <div class="input-field">
                                <p>your name <span>*</span></p>
                                <input type="text" name="name" required maxlength="50" placeholder="Enter Your Name" class="input">
                                </div>
                                 <div class="input-field">
                                <p>your number <span>*</span></p>
                                <input type="number" name="number" required maxlength="50" placeholder="Enter Your Number" class="input">
                                </div>
                                 <div class="input-field">
                                <p>your email <span>*</span></p>
                                <input type="email" name="email" required maxlength="50" placeholder="Enter Your Email" class="input">
                                </div>  
                                 <div class="input-field">
                                <p>payment method<span>*</span></p>
                                <select name="method" class="input">
                                    <option value="cash on delivery">cash on delivery</option>
                                    <option value="credit or debit card">credit or debit card</option>
                                </select>
                            </div>
                              <div class="input-field">
                                 <p>address type<span>*</span></p>
                                <select name="address_type" class="input">
                                    <option value="home">home</option>
                                    <option value="office">office</option>
                                </select>
                            </div>
                        </div>
                        <div class="box">
                            <div class="input-field">
                                <p>address line 01 <span>*</span></p>
                                <input type="text" name="flat" required maxlength="50" placeholder="E.g flat & building number" class="input">
                                </div>
                                 <div class="input-field">
                                <p>address line 02 <span>*</span></p>
                                <input type="text" name="street" required maxlength="50" placeholder="E.g. street name" class="input">
                                </div>
                                 <div class="input-field">
                                <p>city name <span>*</span></p>
                                <input type="text" name="city" required maxlength="50" placeholder="Enter your city" class="input">
                                </div>
                            </div>           
                         </div>
                     </div>
                     <button type="submit" name="place_order" class="btn">place order</button>
                </form>
                <div class="summary">
                    <h3>my bag </h3>
                    <div class="box-container">
                       <?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);

$user_id = $_SESSION['user_id'] ?? 0;

$select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
$select_cart->execute([$user_id]);

if ($select_cart->rowCount() > 0) {
    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
        $select_products->execute([$fetch_cart['product_id']]);
        $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);

        if (!$fetch_product) {
            echo "Error: Product not found for ID: " . $fetch_cart['product_id'];
            continue;
        }

        $sub_total = $fetch_cart['qty'] * $fetch_product['price'];
        $grand_total += $sub_total;
        ?>
        <div class="flex">
            <img src="image/<?= $fetch_product['image']; ?>">
            <div>
                <h3 class="name"><?= $fetch_product['name']; ?></h3>
                <p class="name"><?= $fetch_product['price']; ?> x <?= $fetch_cart['qty']; ?></p>
            </div>
        </div>
        <?php
    }
} else {
    echo "Cart is empty.";
}
?>



                                </div>
                          </div>
                    </div>
                    </section>









    
              <?php include 'footer.php'; ?> 
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>



    
</body>
</html>