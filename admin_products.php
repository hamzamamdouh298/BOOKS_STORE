<?php
include 'config.php';
session_start();

$admin_id=$_SESSION['admin_id'];

if(!isset($admin_id)){
  header('location:login.php');
};

if(isset($_POST['add_products_btn'])){
  $name=mysqli_real_escape_string($conn, $_POST['name']);
  $price=$_POST['price'];
  $image=$_FILES['image']['name'];
  $image_size=$_FILES['image']['size'];
  $image_tmp_name=$_FILES['image']['tmp_name'];
  $image_folder="uploaded_img/".$image;

  $select_product_name=mysqli_query($conn, "SELECT name FROM `products` WHERE name='$name'") or die('query failed');

  if(mysqli_num_rows($select_product_name)>0){
    $message[]='The given product is already added';
  }else{
    $add_product_query=mysqli_query($conn,"INSERT INTO `products`(name,price,image) VALUES ('$name','$price','$image')") or die('query2 failed');
    if($add_product_query){
      if($image_size>2000000){
        $message[]='Image size is too large';
      }else{
        move_uploaded_file($image_tmp_name,$image_folder);
        $message[]="Product added successfully!";
      }
    }else{
      $message[]="Product failed to be added!";
    }
  }
};

if(isset($_GET['delete'])){
  $delete_id=$_GET['delete'];

  $delete_img_query=mysqli_query($conn,"SELECT image from `products` WHERE id='$delete_id'") or die('query failed');
  $fetch_del_img=mysqli_fetch_assoc($delete_img_query);
  unlink('./uploaded_img/'.$fetch_del_img);

  mysqli_query($conn, "DELETE FROM `products` WHERE id='$delete_id'") or die('query failed');
  header('location:admin_products.php');
}

if(isset($_POST['update_product'])){
  $update_p_id=$_POST['update_p_id'];
  $update_name=$_POST['update_name'];
  $update_price=$_POST['update_price'];

  mysqli_query($conn,"UPDATE `products` SET name='$update_name', price='$update_price' WHERE id='$update_p_id'") or die('query failed');

  $update_image=$_FILES['update_image']['name'];
  $update_image_tmp_name=$_FILES['update_image']['tmp_name'];
  $update_image_size=$_FILES['update_image']['size'];
  $update_folder='./uploaded_img/'.$update_image;
  $old_image=$_POST['update_old_img'];
  if(!empty($update_image)){
    if($update_image_size>2000000){
      $message[]='Image size is too large';
    }else{
      mysqli_query($conn,"UPDATE `products` SET image='$update_image' WHERE id='$update_p_id'") or die('query failed');

      move_uploaded_file($update_image_tmp_name,$update_folder);
      unlink('./uploaded_img/'.$old_image);

      $message[]="Product added successfully!";
    }
  }
  header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="stylesheet" href="admin.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include 'admin_header.php';
?>
<style>
  .admin_add_products form input[type="submit"] {
    background-color: #3aafa9;
    color: white;
    letter-spacing: 2px;
    font-weight: 900;
}
.product_btn {
    background-color: #3aafa9;
}

</style>
<section class="admin_add_products">
  <form action="" method="post" enctype="multipart/form-data">
    <h3>Add Book</h3>
    <input type="text" name="name" class="admin_input" placeholder="Enter Book Name" required>

    <input type="number" min="0" name="price" class="admin_input" placeholder="Enter Book Price" required>

    <input type="file" name="image" class="admin_input" accept="image/jpg, image/jpeg, image/png" required>

    <input type="submit" name="add_products_btn" class="admin_input" value="Add Product">
  </form>

</section>

<section class="show_products">
  <div class="product_box_cont">
    <?php
      $select_products=mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');

      if(mysqli_num_rows($select_products)>0){
        while($fetch_products=mysqli_fetch_assoc($select_products)){

    ?>

    <div class="product_box">
      <img src="./uploaded_img/<?php echo $fetch_products['image'];?>" alt="">

      <div class="product_name">
      <?php echo $fetch_products['name'];?>
      </div>

      <div class="product_price">$ 
      <?php echo $fetch_products['price'];?> /-
      </div>

      <a href="admin_products.php?update=<?php echo $fetch_products['id']?>" class="product_btn">Update</a>

      <a href="admin_products.php?delete=<?php echo $fetch_products['id']?>" class="product_btn product_del_btn" onclick= "return confirm('Are you sure you want to delete this product ?');">Delete</a>
    </div>
    <?php
      }
    }else{
      echo '<p class="empty">No Product added yet!</p>';
    }
    ?>
  </div>
</section>

<section class="edit_product_form">
  <?php
    if(isset($_GET['update'])){
      $update_id=$_GET['update'];
      $update_query=mysqli_query($conn,"SELECT * FROM `products` WHERE id='$update_id'") or die('query failed');
      if(mysqli_num_rows($update_query)>0){
        while($fetch_update=mysqli_fetch_assoc($update_query)){

  ?>

  <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id'];?>">

    <input type="hidden" name="update_old_img" value="<?php echo $fetch_update['image'];?>">

    <img src="./uploaded_img/<?php echo $fetch_update['image'];?>" alt="">


    <input type="text" name="update_name" value="<?php echo $fetch_update['name'];?>" class="admin_input update_box" required placeholder="Enter Product Name">

    <input type="number" name="update_price" min="0" value="<?php echo $fetch_update['price'];?>" class="admin_input update_box" required placeholder="Enter Product Price">

    <input type="file" name="update_image" value="<?php echo $fetch_update['price'];?>" class="admin_input update_box" accept="image/jpg, image/jpeg, image/png">

    <input type="submit" value="update" name="update_product" class="product_btn">
    <input type="reset" value="cancel" id="close_update" class="product_btn product_del_btn">
    
  </form>

  <?php
      }
    }
  }else{
    echo "<script>
    document.querySelector('.edit_product_form').style.display='none';
    </script>";
  }
  ?>

</section>

<script src="admin_js.js"></script>
<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>

</body>
</html>