<?php
include 'config.php';
session_start();

$admin_id=$_SESSION['admin_id'];

if(!isset($admin_id)){
  header('location:login.php');
}

if(isset($_GET['delete'])){
  $delete_id=$_GET['delete'];
  mysqli_query($conn,"DELETE FROM `register` WHERE id='$delete_id'");
  $message[]='1 user has been deleted';
  header("location:admin_users.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>
  <link rel="stylesheet" href="admin.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include 'admin_header.php';
?>
<style>
  .delete-btn {
    background-color: #235b58;
}
</style>
<section class="admin_users">
  <div class="admin_box_container">
    <?php
      $select_users=mysqli_query($conn,"SELECT * FROM `register`");

      while($fetch_users=mysqli_fetch_assoc($select_users)){

    ?>
    <div class="admin_box">
      <p>Username : <span><?php echo $fetch_users['name']?></span></p>
      <p>Email : <span><?php echo $fetch_users['email']?></span></p>
      <p>Usertype : <span style="color:<?php if($fetch_users['user_type']=='admin'){echo 'blue';}else{echo 'green';}?>"><?php echo $fetch_users['user_type']?></span></p>
      <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');" class="delete-btn">delete</a>
    </div>
      <?php
        };
      ?>
    
  </div>
</section>



<script src="admin_js.js"></script>
<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>

</body>
</html>