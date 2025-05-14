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

if (isset($_POST['product_id']) && isset($_POST['qty'])) {
    $user_id = (int)$_SESSION['user_id'];
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['qty'];

    $product_stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $product_stmt->bind_param("i", $product_id);
    $product_stmt->execute();
    $product_result = $product_stmt->get_result();

    if ($product_result->num_rows === 1) {
        $product = $product_result->fetch_assoc();
        $price = (float)$product['price'];
        $total_price = $price * $quantity;

        // Check if product already in cart
        $check_stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $check_stmt->bind_param("ii", $user_id, $product_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $update_stmt = $conn->prepare("UPDATE cart SET quantity = quantity + ?, total_price = total_price + ? WHERE user_id = ? AND product_id = ?");
            $update_stmt->bind_param("idii", $quantity, $total_price, $user_id, $product_id);
            $update_stmt->execute();
        } else {
            $insert_stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
            $insert_stmt->bind_param("iiid", $user_id, $product_id, $quantity, $total_price);
            $insert_stmt->execute();
        }

        header("Location: cart.php");
        exit();
    } else {
        echo "Product not found!";
    }
} else {
    echo "Invalid data submitted!";
}
?>

 

              <?php include 'footer.php'; ?> 
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>



    
</body>
</html>