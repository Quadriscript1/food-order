<?php 

    include('../config/constant.php');
    //get the id of admin to be deleted

    echo $id =$_GET['id'];

    //create sql query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id = $id";

    //execute sql query
    $res = mysqli_query($conn, $sql);

    //check if the queryis executed successfully or failed
    if($res == true){
        $_SESSION['delete']="<div class='success'>Admin successfully deleted</div>";
        header('Location:'.SITEURL.'/admin/manage-admin.php');
    }else{
        $_SESSION['delete']="<div class='error'>admin failed to delete admin</div>";
    }

    //redirect to manage-admin page with message (success/error)






?>