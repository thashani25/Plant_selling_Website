<header class="header"> 
    <div class="flex">
        <a href="home.php" class="logo"><img src="img/logo.png"></a>

        <nav class="navbar">
            <a href="home.php">home</a>
            <a href="view_product.php">products</a>
            <a href="order.php">orders</a>
            <a href="about.php">about</a>
            <a href="contact.php">contact us</a>
            <a href="admin/admin_dashboard.php">Admin</a>
            </a>
        </nav>
        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            <a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i><sup>0</sup></a>
            <a href="cart.php" class="cart-btn"><i class="bx bx-cart-download"></i><sup>0</sup></a>
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 2rem;"></i>
        </div>
        <div class="user-box">
           <!-- <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p> -->
          <!--  <p>Email : <span><?php echo $_SESSION['user_email']; ?></span></p> -->
            <a href="login.php" class="btn">login</a>
            <a href="register.php" class="btn">register</a>
            <form method="post">
                 <a href="logout.php" class="btn">logout</a>
            </form>
        </div>
    </div>
</header>
        


