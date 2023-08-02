<?php include('partials/menu.php'); ?>

<?php
//check if id is set
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    //SQl query to get the selected food
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

    //execute the query
    $res2 = mysqli_query($conn, $sql2);

    //get the value based on the query executed
    $row2 = mysqli_fetch_assoc($res2);

    //get the value based on the query executed
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
}







?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Food Title goes Here" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>

                        <textarea name="description" cols="30" rows="5" placeholder="Description of the food"> <?php echo $description; ?> </textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if ($current_image == '') {
                            //image is not available
                            echo "<div class='error'>Image not Available</div>";
                        } else {

                            //image is available
                        ?>
                            <img src="<?php echo SITEURL; ?>/images/food/<?php echo $current_image; ?>" width="100px">
                        <?php
                        }

                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            //Query to get active category
                            $sql = "SELECT * FROM tbl_category WHERE active ='Yes'";

                            //execute query
                            $res = mysqli_query($conn, $sql);

                            // count number of rows
                            $count = mysqli_num_rows($res);
                            //check if category is available or not
                            if ($count > 0) {
                                //get available category
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                            ?>
                                    <option <?php if ($current_category == $category_id) {
                                                echo "selected";
                                            } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                            <?php
                                }
                            } else {
                                //no category available

                                echo "<option value='0'>Category not available</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if ($featured == 'Yes') {
                                    echo 'checked';
                                } ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if ($featured == 'No') {
                                    echo 'checked';
                                } ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active</td>
                    <td>
                        <input <?php if ($active == 'Yes') {
                                    echo 'checked';
                                } ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if ($active == 'No') {
                                    echo 'checked';
                                } ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            // echo "button clicked";

            //1.get all the details from the form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2.upload the image if selected
            //check whether the image is cliked or not
            if (isset($_FILES['image']['name'])) {

                $image_name = $_FILES['image']['name']; //new image name
                if ($image_name != "") {

                    //image is available
                    $ext = end(explode('.', $image_name)); //get the extension of the image
                    //rename the image

                    $image_name = "Food_Category_" . rand(0000, 9999) . '.' . $ext; //this is the new name of the image

                    //get the source path and destination path for the image
                    $src_path = $_FILES['image']['tmp_name']; //source path of the image
                    $dest_path = "../images/food/" . $image_name; //destination path of the image

                    // upload image
                    $upload = move_uploaded_file($src_path, $dest_path);

                    //check if the image is already uploaded or not
                    if ($upload == false) {
                        //failed to upload
                        $_SESSION['upload'] = "<div class='error'> Failed to upload New Image</div>";
                        //redirect to the manage-food page with the error message
                        header('Location:' . SITEURL . 'admin/manage-food.php');
                        die();
                    }
                    //3.remove the image if the new image is uploaded and current image exist
                    //remove current image if available
                    if ($current_image != "") {

                        //current image is available
                        //remove the image
                        $remove_path = "../images/food/" . $current_image;

                        $remove = unlink($remove_path);

                        //check if the image is removed or not
                        if ($remove == false) {

                            //failed to remove
                            $_SESSION['remove-failed'] = "<div class='error'> Failed to remove Current Image</div>";
                            //redirect to the manage food page
                            header('Location:' . SITEURL . 'admin/manage-food.php');
                            die();
                        }
                    }
                }else{
                    $image_name = $current_image;
                }
            } else {
                $image_name = $current_image;
            }

            //4.update the food in database
            $sql3 = "UPDATE tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name ='$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
                WHERE id = $id
            
            ";

            //execute the query
            $res3 = mysqli_query($conn, $sql3);

            //check if the query is successful or not
            if ($res3 == true) {

                //food is updated
                $_SESSION['update'] = "<div class='success'> Food Updated Successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            } else {

                //failed to update
                $_SESSION['update'] = "<div class='error'>Failed to Update Food. </div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            }

            //redirect to manage food with session message
        }


        ?>
    </div>
</div>


<?php include('partials/footer.php'); ?>