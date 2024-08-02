<?php

include 'config.php';

if(isset($_POST['submit'])){

    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=mysqli_real_escape_string($conn,md5($_POST['password']) );
    $cpassword=mysqli_real_escape_string($conn,md5($_POST['cpassword']) );
    $user_type=$_POST['user_type'];

    $select_users=mysqli_query($conn,"SELECT * FROM `register` WHERE email='$email' AND password='$password'") or die('query failed');

    if(mysqli_num_rows($select_users) > 0){
        $message[]='User already exists!';
    }else{
        if($password!=$cpassword){
            $message[]='Confirm password not matched!';
        }
        else{
            mysqli_query($conn,"INSERT INTO `register`(name,email, password, user_type) VALUES('$name','$email','$cpassword','$user_type')") or die('query failed');
            $message[]='Registered Successfully!';
            header('location:login.php');
        }
        
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>

    <!-- Font awesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Css File Link -->
    <link rel="stylesheet" href="login.css">
</head>

<body>

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
<style>
body{
 
    background-color: #3AAFA9;
}
.box form {
    background-color: #dcf7f7;
    
}
.box form input[type="submit"] {
    background: #3AAFA9;
}
.box form .links a {
    margin: 20px 0;
    font-size: 0.9em;
    color: #000000;
    text-decoration: none;
}
</style>
<div class="box">
    <span class="borderline"></span>
    <form action="" method="post">
    <h2>Register</h2>
        <div class="inputbox">
            <input type="text" name="name" required="required">
            <span>Name</span>
            <i></i>
        </div>

        <div class="inputbox">
            <input type="email" name="email" required="required">
            <span>Email</span>
            <i></i>
        </div>

        <div class="inputbox">
            <input type="password" name="password" required="required">
            <span>Password</span>
            <i></i>
        </div>

        <div class="inputbox">
            <input type="password" name="cpassword" required="required">
            <span>Confirm Password</span>
            <i></i>
        </div>
        
        <div class="inputbox">
            <select name="user_type" >
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        <i></i>
        </div>
        
        
        <div class="links">
            <a href="#">Forgot Password</a>
            <a href="login.php">Login</a>
        </div>


        <input type="submit" value="Register Now" name="submit">
    
    </form>
    
</div>

<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
</body>
</html>