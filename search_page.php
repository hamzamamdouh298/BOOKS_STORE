<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {
  
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $product_image = $_POST['product_image'];
  $product_quantity = $_POST['product_quantity'];

  $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

  if (mysqli_num_rows($check_cart_numbers) > 0) {
    $message[] = 'already added to cart!';
  } else {
    mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
    $message[] = 'product added to cart!';
  }
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Page</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="home.css">

</head>

<body>

  <?php
  include 'user_header.php';
  ?>

  <section class="search_cont">
    <form action="" method="post">
      <input type="text" name="search" placeholder="Search Products......">
      <input type="submit" value="Search" name="submit" class="product_btn">
    </form>
  </section>

  <section class="products_cont">
    <div class="pro_box_cont">
      <?php
      if (isset($_POST['submit'])) {
        $search_item = $_POST['search'];
        $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$search_item}%'") or die('query failed');
        if (mysqli_num_rows($select_products) > 0) {
          while ($fetch_products = mysqli_fetch_assoc($select_products)) {
      ?>
            <form action="" method="post" class="pro_box">
              <img src="./uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
              <h3><?php echo $fetch_products['name']; ?></h3>
              <p>Rs. <?php echo $fetch_products['price']; ?>/-</p>

              <input type="hidden" name="product_name" value="<?php echo $fetch_products['name'] ?>">
              <input type="number" name="product_quantity" min="1" value="1">
              <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
              <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

              <input type="submit" value="Add to Cart" name="add_to_cart" class="product_btn">

            </form>

      <?php
          }
        } else {
          echo '<p class="empty">No result found!</p>';
        }
      } else {
        echo '<p class="empty">Search Something!</p>';
      }
      ?>
    </div>
  </section>

  <?php
  include 'footer.php';
  ?>
  <script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>

  <script src="script.js"></script>

</body>

</html>