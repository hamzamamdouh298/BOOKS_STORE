<?php
include 'config.php';
session_start();

$user_id=$_SESSION['user_id'];

if(!isset($user_id)){
  header('location:login.php');
}

if(isset($_POST['order_btn'])){
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $number = $_POST['number'];
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $method = mysqli_real_escape_string($conn, $_POST['method']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $placed_on = date('d-M-Y');

  $cart_total = 0;
  $cart_products[] = '';

  $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(' ',$cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }else{
      if(mysqli_num_rows($order_query) > 0){
         $message[] = 'order already placed!'; 
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $message[] = 'order placed successfully!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout Page</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="home.css">

</head>
<body>
  
<?php
include 'user_header.php';
?>

<section class="display_order">
  <h2>Ordered Products</h2>
  <?php
    $grand_total=0;
    $select_cart=mysqli_query($conn,"SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');

    if(mysqli_num_rows($select_cart)>0){
      while($fetch_cart=mysqli_fetch_assoc($select_cart)){
        $total_price=($fetch_cart['price'] * $fetch_cart['quantity']);
        $grand_total+=$total_price;
      
  ?>
  <div class="single_order_product">
    <img src="./uploaded_img/<?php echo$fetch_cart['image'];?>" alt="">
    <div class="single_des">
    <h3><?php echo $fetch_cart['name'];?></h3>
    <p>$ <?php echo $fetch_cart['price'];?></p>
    <p>Quantity : <?php echo $fetch_cart['quantity'];?></p>
    </div>

  </div>
  
  
  <?php
  }
}else{
  echo '<p class="empty">your cart is empty</p>';
}
  ?>
  <div class="checkout_grand_total"> GRAND TOTAL : <span>$<?php echo $grand_total; ?>/-</span> </div>
</section>



<section class="contact_us">

<form action="" method="post">
   <h2>Add Your Details</h2>
   <input type="text" name="name" required placeholder="Enter your name" >

   <input type="phone" name="number" required placeholder="Enter your number">

   <input type="email" name="email" required placeholder="Enter your email">

   <select name="method" id="">
    <option value="cash on delivery">cash on delivery</option>
    <option value="gpay">gpay</option>
   </select>
  
   <textarea name="address" placeholder="Enter your address" id="" cols="30" rows="10"></textarea>
   
   <input type="submit" value="Place Your Order" name="order_btn" class="product_btn">
</form>
</section>
<?php
include 'footer.php';
?>
<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>

<script src="script.js"></script>

</body>
</html>