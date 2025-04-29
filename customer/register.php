<?php
    include 'conection.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id = '';

    }
      //registter user 
     

?>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>green tea - register now </title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="img/download.png">
                <h1>register now</h1>
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis pariatur mollitia ad nemo. Nisi quae 
                    voluptatem consequatur placeat sequi aperiam! Natus rem molestias velit quibusdam dolorum voluptatem 
                    dolore tempora optio.</p>
            </div>
            <form action="" method="post">
                <div class="input-filed">
                    <p>your name <sub>*</sub></p>
                    <input type="text" name="name" required placeholder="enter your name" maxlength="50">
                 </div>
                 <div class="input-filed">
                    <p>your email <sub>*</sub></p>
                    <input type="email" name="email" required placeholder="enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                 </div>
                 <div class="input-filed">
                    <p>your password <sub>*</sub></p>
                    <input type="password" name="pass" required placeholder="enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                 </div>
                 <div class="input-filed">
                    <p>confirm password <sub>*</sub></p>
                    <input type="password" name="cpass" required placeholder="enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                 </div>
                 
                 <input type="submit" name="submit" value="register now" class="btn">
                 <p>already have  an account? <a href="login.php">login now</a></p>
    </form>
    </section>
    
</body>
</html>