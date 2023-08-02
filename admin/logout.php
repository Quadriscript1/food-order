<?php 
    //include constant.php for siteurl

    include('../config/constant.php');

    
    //destroy the seesion 
    session_destroy();


    //redirect to the login page

    header('Location:'.SITEURL.'admin/login.php')


?>