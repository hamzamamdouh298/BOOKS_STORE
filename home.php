<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {
  $pro_name = $_POST['product_name'];
  $pro_price = $_POST['product_price'];
  $pro_quantity = $_POST['product_quantity'];
  $pro_image = $_POST['product_image'];

  $check = mysqli_query($conn, "SELECT * FROM `cart` where name='$pro_name' and user_id='$user_id'") or die('query failed');

  if (mysqli_num_rows($check) > 0) {
    $message[] = 'Already added to cart!';
  } else {
    mysqli_query($conn, "INSERT INTO `cart`(user_id,name,price,quantity,image) VALUES ('$user_id','$pro_name','$pro_price','$pro_quantity','$pro_image')") or die('query2 failed');
    $message[] = 'Product added to cart!';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="home.css">

</head>

<body>

  <?php
  include 'user_header.php';
  ?>
<style>
* {
    text-decoration: inherit;
    color: black;
}
.home_cont {
    width: 100%;
    height: 70vh;
    background: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)), url(66.png) no-repeat;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}
.main_descrip {
  position: absolute;
right: 230px;
bottom: 0px;
top: 400px;
}
.pro_box p {
  background-color: #235b58;
}
.product_btn {
  background-color: #235b58;
  }
  .about_cont, .questions_cont {
    background-color: #3aafa9;
}
</style>
  <section class="home_cont">
    <div class="main_descrip">
      
      <button>  <a href="shop.php"> Discover More</a>  </button>
    </div>
  </section>

  <section class="products_cont">
    <div class="pro_box_cont">
      <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');

      if (mysqli_num_rows($select_products) > 0) {
        while ($fetch_products = mysqli_fetch_assoc($select_products)) {

      ?>
          <form action="" method="post" class="pro_box">
            <img src="./uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
            <h3><?php echo $fetch_products['name']; ?></h3>
            <p>$ <?php echo $fetch_products['price']; ?>/-</p>
          
            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name'] ?>">
            <input type="number" name="product_quantity" min="1" value="1">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

            <input type="submit" value="Add to Cart" name="add_to_cart" class="product_btn">

          </form>

      <?php
        }
      } else {
        echo '<p class="empty">No Products Added Yet !</p>';
      }
      ?>
    </div>
  </section>

  <section class="about_cont">
    <img src="999.png" alt="">
    <div class="about_descript">
      <h2>DO YOU KNOW THAT!</h2>
      <p>The biggest challenge most people are unaware of is that the mind needs sharpening, stimulation, maintenance, and principally, continual development. A well-maintained mind functions at its best. The neglected mind is dysfunctional all the time.</p>
    <button class="product_btn" onclick="window.location.href='shop.php';">GO NOW!</button>
    </div>
  </section>

  <section class="questions_cont">
    <div class="questions">
    <h2>Have Any problems?</h2>
    <p>if you have any problem dont worry just click on contact us button </p>
    <button class="product_btn">Contact Us</button>
    </div>
    
  </section>
  <?php
  include 'footer.php';
  ?>
  <script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>

  <script src="script.js"></script>

</body>

</html>
