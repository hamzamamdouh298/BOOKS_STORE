<?php
include 'config.php';
session_start();

$admin_id=$_SESSION['admin_id'];

if(!isset($admin_id)){
  header('location:login.php');
}

if(isset($_GET['delete'])){
  $delete_id=$_GET['delete'];
  mysqli_query($conn,"DELETE FROM `message` WHERE id='$delete_id'");
  $message[]='1 message has been deleted';
  header("location:admin_messages.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messages</title>
  <link rel="stylesheet" href="admin.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include 'admin_header.php';
?>

<section class="admin_messages">
  <div class="admin_box_container">
    <?php
      $select_msgs=mysqli_query($conn,"SELECT * FROM `message`") or die('query failed');
      if(mysqli_num_rows($select_msgs)>0){
        while($fetch_msgs=mysqli_fetch_assoc($select_msgs)){  
    ?>
    <div class="admin_box">
      <p>Name : <span><?php echo $fetch_msgs['name']; ?></span></p>
      <p>Number : <span><?php echo $fetch_msgs['number']; ?></span></p>
      <p>Email : <span><?php echo $fetch_msgs['email']; ?></span></p>
      <p>Message : <span><?php echo $fetch_msgs['message']; ?></span></p>
      <a href="admin_messages.php?delete=<?php echo $fetch_msgs['id']; ?>" onclick="return confirm('Are you sure you want to delete this message?');" class="delete-btn">delete</a>
    </div>
    <?php
      };
    }
    else{
      echo '<p class="empty">You Have No Messages!</p>';
    }
    ?>
  </div>
</section>

<script src="admin_js.js"></script>
<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>

</body>
</html>