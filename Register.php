<?php
include 'config.php';

$message = array();

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'User already exists'; 
   }else{
      if($pass != $cpass){
         $message[] = 'Confirm password not matched!';
      }elseif($image_size > 2000000){
         $message[] = 'Image size is too large!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `user_form`(name, email, password, image) VALUES('$name', '$email', '$pass', '$image')") or die('query failed');

         if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Registration successful!';
         }else{
            $message[] = 'Registration failed!';
         }
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <title>Register</title>
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
                        <header>Create account</header>
                        <?php
                        if(isset($message)){
                            foreach($message as $msg){
                                echo '<div class="alert alert-success">'.$msg.'</div>';
                            }
                        }
                        ?>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                            <div class="input-field">
                                <input type="text" name="name" class="input" id="Name" required="" autocomplete="off">
                                <label for="Name">Username</label>
                            </div>
                            <div class="input-field">
                                <input type="email" name="email" class="input" id="email" required="" autocomplete="off">
                                <label for="email">Email</label>
                            </div>
                            <div class="input-field">
                                <input type="password" name="password" class="input" id="pass" required="">
                                <label for="pass">Password</label>
                            </div>
                            <div class="input-field">
                                <input type="password" name="cpassword" class="input" id="cpass" required="">
                                <label for="cpass">Confirm Password</label>
                            </div>
                            <div class="input-field">
                                <input type="file" name="image" class="input">
                            </div>
                            <div class="input-field">
                                <input type="submit" name="submit" class="submit" value="Sign Up">
                            </div>
                        </form>
                        <div class="signin">
                            <span>Already have an account? <a href="Login.php">Login here</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
