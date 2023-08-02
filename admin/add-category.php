<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>
        <?php

        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }



        ?>
        <br><br>
        <!-- add category form start -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Category Title"></td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image" id="">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td><input type="radio" name="featured" value="Yes">Yes</td>
                    <td><input type="radio" name="featured" value="No">No</td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td><input type="radio" name="active" value="Yes">Yes</td>
                    <td><input type="radio" name="active" value="No">No</td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Add Category" class="btn-secondary"></td>
                </tr>

            </table>
        </form>
        <!-- add category form end -->
        <?php

        //check if button is clicked
        if (isset($_POST['submit'])) {
            // echo 'clicked';

            //get the value from the category form data
            $title = $_POST['title'];





            //for radio buttons we need to check if the button is selected 
            if (isset($_POST['featured'])) {

                $featured = $_POST['featured'];
            } else {
                $featured = "No";
            }
            if (isset($_POST['active'])) {

                $active = $_POST['active'];
            } else {

                $active = "No";
            }

            // print_r($_FILES['image']); //testing image file
            // die
            if (isset($_FILES['image']['name'])) {
                //upload image
                //to upload image we need  image name,source path and destination path
                $image_name = $_FILES['image']['name'];

                //upload the image only if image is selected
                if ($image_name != '') {



                    //auto rename image
                    $ext = end(explode('.', $image_name));

                    //rename the image

                    $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/" . $image_name;

                    //finally upload image
                    $upload = move_uploaded_file($source_path, $destination_path);


                    //check if the image is uploaded or not
                    //if the image is not uploaded then we 'll stop the process and redirect with error message

                    if ($upload == false) {

                        $_SESSION['upload'] = "<div class='error'> Failed to upload Image</div>";

                        header('Location:' . SITEURL . 'admin/add-category.php');

                        die();
                    }
                }
            } else {
                //dont upload image and set image value to blank
                $image_name = '';
            }

            //create aSQL query to insert the category into the database 

            $sql = "INSERT INTO tbl_category SET
                 title = '$title',
                 image_name = '$image_name',
                 featured = '$featured',
                 active = '$active'
                 ";

            //execute the SQL and save it in the database

            $res = mysqli_query($conn, $sql);

            //check whetghere the query was executed or not

            if ($res == true) {

                //query executed successfully   
                $_SESSION['add'] = "<div class='success'>Category Added Succesfully</div>";

                //redirect back to manageCategory page
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {

                //query failed
                $_SESSION['add'] = "<div class='error'>Failed to add Category</div>";

                //redirect back to manageCategory page
                header('location:' . SITEURL . 'admin/add-category.php');
            }
        }




        ?>

    </div>
</div>




<?php include('partials/footer.php'); ?>