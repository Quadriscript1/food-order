<?php include('../config/constant.php') ?>
<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>

        <div class="login">
            <h1 class="text-center">Login</h1> <br><br>

            <?php
            if(isset($_SESSION['login'])) {

                echo $_SESSION['login']; 
                unset($_SESSION['login']) ;
               
                
            }
            if(isset($_SESSION['no-login-message'])){
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
            ?>
            <!-- login form start here -->
                <form action="" method="POST" class="text-center">
                    Username: <br> <input type="text" name="username" placeholder="Enter Username"><br><br>

                    Password: <br> <input type="password" name="password" placeholder="Enter Password" > <br><br>

                    <input type="submit" name="submit" value="Login" class="btn-primary">
                </form><br><br>






            <!-- login form end here -->

            <p class="text-center">Credited By - <a href="#">G.A .OPAy </a></p>

        </div>
        
    </body>
</html>

<?php 
    if(isset($_POST['submit'])){
        //get the data from the login form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        //sql query
        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";

        //execute the query
        $res = mysqli_query($conn,$sql);

        //count rows to check whether the user exist or not
        $count = mysqli_num_rows($res);

        if($count == 1){
            //user available and login success
            $_SESSION['login'] = "<div class='success'> Login Successful </div>";
            $_SESSION['user'] = $username;


            //redeirect to homepage
            header('location:'.SITEURL.'admin/');
        }else{
            //user not available and login failed
            $_SESSION['login'] = "<div class='error text-center'> Login Failed </div>";
            //redeirect to homepage
            header('location:'.SITEURL.'admin/login.php');

        }
    }

?>