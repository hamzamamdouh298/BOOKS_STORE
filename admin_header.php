
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

<header class="admin_header">
    <div class="header_navigation">
      <a href="admin_page.php" class="header_logo">Admin <span>Dashboard</span></a>
<style>
  .header_navigation .header_navbar a {
    background-color: #3aafa9;
}
.admin_box_container .admin_box {
    margin: 1rem;
    background-color: #3aafa9;
    width: 20%;
    padding: 1rem;
    border-radius: .5rem;
    box-shadow: 2px 2px 10px #c7dfde;
    cursor: pointer;
}
</style>
      <nav class="header_navbar">
        <a href="admin_page.php">Home</a>
        <a href="admin_products.php">Products</a>
        <a href="admin_orders.php">Orders</a>
        <a href="admin_users.php">Users</a>
        <a href="admin_messages.php">Messages</a>
      </nav>
      <div class="header_icons">
        <div id="menu_btn" class="fas fa-bars"></div>
        <div id="user_btn" class="fas fa-user"></div>
      </div>
      <div class="header_acc_box">
        <p>Username : <span><?php echo $_SESSION['admin_name'];?></span></p>
        <p>Email : <span><?php echo $_SESSION['admin_email'];?></span></p>
        <a href="logout.php" class="delete-btn">Logout</a>
      </div>
    </div>
  </header>

  <!-- <script src="admin_js.js"></script> -->