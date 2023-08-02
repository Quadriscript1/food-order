<?php 

include('../config/constant.php');
//check whether the id and image_name values are set or not

if(isset($_GET['id']) && isset($_GET['image_name'])){
    //get the vakue and delete
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
 
    //remove the image file if it exists
    if($image_name != ''){

        //image is available  so remove it
        $path = "../images/category/".$image_name;

        //remove the image
        $remove =unlink($path);

        //if failed to remove the image then ad error message and stop the process
        if($remove == false){
            //set the session message
            $_SESSION['remove']="<div class='error'> Failed to Remove Category Image </div>";

            //redirect to the mannage_category page
            header('Location:'.SITEURL.'admin/manage-category.php');
            
            //stop the process
            die();
        }
    }
     //delete data from database
     $sql = "DELETE FROM tbl_category WHERE id = $id";

     //execute query
     $res = mysqli_query($conn, $sql);
     
     //check if data was deleted
     if($res == true){
        $_SESSION['delete'] ="<div class='success'>Category Deleted Successfully.</div>";
        //redirect to the mannage_category page
        header('Location:'.SITEURL.'admin/manage-category.php');
     }else{

        $_SESSION['delete'] ="<div class='error'>Failed to Delete Category.</div>";
        //redirect to the mannage_category page
        header('Location:'.SITEURL.'admin/manage-category.php');

     }

}else{
    //redirect to the mannage_category page
    header('Location:'.SITEURL.'admin/manage-category.php');  
}




?>