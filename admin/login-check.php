<?php
//authorisation access control
//check whether the user is logged in or out
if (!isset($_SESSION['user'])){ //if user sessii is not set in

    $_SESSION['no-login-message']="<div class='error text-center'>Please Login to access Admin Panel</div>";

    header('Location:'.SITEURL.'admin/login.php');

}

?>