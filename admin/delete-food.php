<?php
//include constants.php
include('../config/constant.php');

//echo 'delete food';
if(isset($_GET['id'])&& isset($_GET['image_name'])){
    //process to delete
    //echo 'delete food';
    //1. get id and image name

    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
    //2. remove the image if available

    //check if the image exists or not
    if($image_name != ''){

        //it has image and need to be deleted
        //get the image path and delete
        $path ="../images/food/".$image_name;

        $remove = unlink($path);

         //if failed to remove the image then ad error message and stop the process
         if($remove == false){
            //set the session message
            $_SESSION['upload']="<div class='error'> Failed to Remove  Image </div>";

            //redirect to the mannage_food page
            header('Location:'.SITEURL.'admin/manage-food.php');
            
            //stop the process
            die();
        }
    }

    //3. delete food from database
    $sql = "DELETE FROM tbl_food WHERE id =$id";
    //execute SQL statement
    $res = mysqli_query($conn, $sql);

    //check whether the query succeeded or failed
    if($res == true){
        //food deleted
        $_SESSION['delete']="<div class='success'>Food Deleted Successfully.</div>";
        header('Location:'.SITEURL.'admin/manage-food.php');

    }else{
        //food failed to delete
        $_SESSION['delete']="<div class='error'>Failed to Delete Food.</div>";
        header('Location:'.SITEURL.'admin/manage-food.php'); 
    }

    //4. redirect to manage-food page with success message

     

}else{
    //redirect to managefood page
    //cho 'redirect to managefood';  
     $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
     header('Location:'.SITEURL.'admin/manage-food.php');

}


?>