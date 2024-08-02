<?php
if(isset($message)){
    foreach($message as $message){
        echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="fa-solid fa-xmark" onclick="this.parentElement.remove();"></i>
        </div>
    ';    
    } 
}
?>

<header class="user_header">
  <div class="header_1">
    <div class="user_flex">
      <div class="logo_cont">
        <img src="22.png" alt="">

        <a href="home.php" class="book_logo">Ｓａｍ　</a>
      </div>


      <nav class="navbar">
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
        <a href="shop.php">Shop</a>
        <a href="contact.php">Contact</a>
        <a href="orders.php">Orders</a>
      </nav>

      <div class="last_part">
        <div class="loginorreg">
          <p> <a href="register.php">Logout</a> </p>
        </div>

        <div class="icons">
          <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
          <a class="fa-solid fa-magnifying-glass" href="search_page.php" style="color: white;"></a>

          <div class="fas fa-user" id="user_btn" style="color: white;"></div>
          <?php
          $select_cart_number=mysqli_query($conn,"SELECT * FROM `cart` where user_id='$user_id'") or die('query failed');
          $cart_row_number=mysqli_num_rows($select_cart_number);
          ?>

          <a href="cart.php"><i class="fas fa-shopping-cart" style="color: white;"></i><span class="quantity" style="color: white;">(<?php echo $cart_row_number?>)</span></a>

          <div class="fas fa-bars" id="user_menu_btn" style="color: white;"></div>

        </div>

      </div>
      <div class="header_acc_box">
        <p>Username : <span><?php echo $_SESSION['user_name'];?></span></p>
        <p>Email : <span><?php echo $_SESSION['user_email'];?></span></p>
        <a href="logout.php" class="delete-btn">Logout</a>
      </div>

    </div>

  </div>

</header>
