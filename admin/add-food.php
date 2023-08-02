<?php include('partials/menu.php'); ?>


<div class="min-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>
        <?php 
             if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description"  cols="30" rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>
                        <select name="category" id="">

                            <?php 
                                //create PHP code to display category from database
                                //create sql to display category from database
                                $sql = "SELECT * FROM tbl_category WHERE active ='Yes'";

                                //execute SQL
                                $res = mysqli_query($conn, $sql);

                                //count number of rows in category
                                $count = mysqli_num_rows($res);

                                //if count is greater 0 then we have category
                                if($count >0){
                                    while($row = mysqli_fetch_assoc($res)){
                                        //get the details of the category
                                        $id =$row['id'];
                                        $title = $row['title'];

                                        ?>
                                        <option value="<?php echo $id ; ?>"><?php echo $title;  ?></option>
                                        <?php

                                    }

                                }else{
                                    ?>
                                    <option value="0">NO Categories Found</option>
                                    <?php
                                }
                            
                             ?>





                            
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
        //check if button has been clicked
        if(isset($_POST['submit'])){
            //1.get data from form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category']; 

            //check whether radio button for featured and active has been clicked
            if(isset($_POST['featured'])){

                $featured = $_POST['featured']; 
            }else{
                $featured ="No"; //setting default value
            }
            if(isset($_POST['active'])){

                $active = $_POST['active']; 
            }else{
                $active ="No"; //setting default value
            }

            //2.upload the image if selected
            //check whether the image is clicked or not and upload the image only if the image is selected 
            if(isset($_FILES['image']['name'])){
                //get the details of the image selected
                $image_name = $_FILES['image']['name']; 

                //check whether the image is clicked or not and upload the image only if the image is selected
                if($image_name != ""){
                     //auto rename image
                    $ext = end(explode('.', $image_name));

                    //create new name for the image
                    $image_name = "Food_Category_".rand(0000, 9999).'.'. $ext;

                    //sourec path is the current location of the image
                    $src =$_FILES['image']['tmp_name'];

                    //estinaton path for the image to be uploaded
                    $dst ="../images/food/".$image_name; 

                    //finally upload the image
                    $upload =move_uploaded_file($src, $dst);

                    //check whether image uploaded or not
                    if ($upload == false) {

                        //redirect to addfood page with error message
                        $_SESSION['upload'] = "<div class='error'> Failed to Upload Image</div>";
                        header('Location:'.SITEURL.'admin/add-food.php');

                        die();//stop this process
                    }
                }

            }else{
                $image_name = "";
            }

            //3.insert into database
            //create sql query to save data into database
            $sql2 = "INSERT INTO tbl_food SET
            title ='$title',
            description ='$description',
            price = $price,
            image_name ='$image_name',
            category_id ='$category',
            featured ='$featured',
            active ='$active'
            ";

            //execute sql query
            $res2 = mysqli_query($conn, $sql2);

            //check whether the data is inserted  or not
            if ($res2 == true) {

                //query executed successfully   
                $_SESSION['add'] = "<div class='success'>Food Added Succesfully</div>";
                //redirect back to manageCategory page
                header('Location:'.SITEURL.'admin/manage-food.php');
                // header('location:'.SITEURL.'admin/manage-food.php');
            } else {

                //query failed
                $_SESSION['add'] = "<div class='error'>Failed to Add Food</div>";
                //redirect back to manageCategory page
                header('location:'.SITEURL.'admin/manage-food.php');
            }

            //4.redirect with message to manage- food

        }
        
        
        
        ?>
    </div>
</div>




<?php include('partials/footer.php'); ?>