<?php

include 'config.php';
session_start();
$message = array();

if(isset($_POST['submit'])){
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:homePage.html');
   }else{
      $message[] = 'Incorrect email or password!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                    <img src="images/logo.png" alt="">
                </div>
                <div class="col-md-6 right">
                    <div class="input-box">
                        <header>Log In</header>
                        <?php
                        if(!empty($message)){
                            foreach($message as $msg){
                                echo '<div class="alert alert-danger">'.$msg.'</div>';
                            }
                        }
                        ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="input-field">
                                <input type="email" class="input" name="email" placeholder="Email" required="" autocomplete="off">
                            </div>
                            <div class="input-field">
                                <input type="password" class="input" name="password" placeholder="Password" required="">
                            </div>
                            <div class="input-field">
                                <input type="submit" class="submit" name="submit" value="Sign In">
                            </div>
                        </form>
                        <div class="signin">
                            <span>Haven't got any account? <a href="Register.php">Register here</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


