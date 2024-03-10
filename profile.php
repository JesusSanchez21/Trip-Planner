<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
    exit(); // Terminate script after redirection
}

if(isset($_GET['logout'])){
    unset($user_id);
    session_destroy();
    header('location:login.php');
    exit(); // Terminate script after redirection
}

$select = mysqli_prepare($conn, "SELECT name, image FROM user_form WHERE id = ?");
mysqli_stmt_bind_param($select, 'i', $user_id);
mysqli_stmt_execute($select);
mysqli_stmt_store_result($select);
if(mysqli_stmt_num_rows($select) > 0){
    mysqli_stmt_bind_result($select, $name, $image);
    mysqli_stmt_fetch($select);
}
mysqli_stmt_close($select);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Add your custom CSS styles here */
    </style>
</head>

<body id="top">
    <header>
        <!-----------------------#HEADER--------------------->
        <nav>
            <ul class="sidebar">
                <li onclick="hideSidebar()"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="26" viewBox="0 96 960 960" width="26"><path d="m249 849-42-42 231-231-231-231 42-42 231 231 231-231 42 42-231 231 231 231-42 42-231-231-231 231Z"/></svg></a></li>
                <li><a href="HomePage.html">Home</a></li>
                <li><a href="apiFlights.html">Flights</a></li>
                <li><a href="api.html">Best Restaurants</a></li>
                <li><a href="FAQ.html">FAQ</a></li>
                <li><a href="Contact.html">Contact</a></li>
                <li><a href="profile.php">Profile</a></li>

            </ul>
            <ul>
                <li> <a class="navbar-brand" href="index.html"><img src="Images/logo.png" alt="Logo" class="img-fluid"></a></li>
                <li class="hideOnMobile"><a href="HomePage.html">Home</a></li>
                <li class="hideOnMobile"><a href="apiFlights.html">Flights</a></li>
                <li class="hideOnMobile"><a href="api.html">Best Restaurants</a></li>
                <li class="hideOnMobile"><a href="FAQ.html">FAQ</a></li>
                <li class="hideOnMobile"><a href="Contact.html">Contact</a></li>
                <li class="hideOnMobile"><a href="profile.php">Profile</a></li>

                <li class="menu-button" onclick="showSidebar()"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="26" viewBox="0 96 960 960" width="26"><path d="M120 816v-60h720v60H120Zm0-210v-60h720v60H120Zm0-210v-60h720v60H120Z"/></svg></a></li>
            </ul>
        </nav>
    </header>

    <main>
        <article>
            <!---------------------------------- #SEARCH------------------------------------------------------>

            <!-- Profile Section -->
            <div class="container">
                <div class="profile">
                    <?php
                        if(empty($image)){
                            echo '<img src="images/default-avatar.png">';
                        } else {
                            echo '<img src="uploaded_img/'.$image.'">';
                        }
                    ?>
                    <h3><?php echo $name; ?></h3>
                    <a href="update_profile.php" class="btn">update profile</a>
                    <a href="index.html?logout=<?php echo $user_id; ?>" class="delete-btn">logout</a>
                </div>
            </div>

            <!-- Insert other sections from the provided HTML template here -->
        </article>
    </main>

    <script>
        function showSidebar(){
            const sidebar = document.querySelector('.sidebar')
            sidebar.style.display = 'flex'
        }
        function hideSidebar(){
            const sidebar = document.querySelector('.sidebar')
            sidebar.style.display = 'none'
        }
    </script>

    <!-- 
        - ionicon link
    -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
