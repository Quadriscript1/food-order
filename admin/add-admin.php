<?php include('partials/menu.php'); ?>




<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br>
        <?php 
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']); //remove session message
            }
        ?>
        <br>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td> <input type="text" name="full_name" placeholder="Enter your name ... "> </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td> <input type="text" name="username" placeholder="Your Username ... "> </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td> <input type="Password" name="password" placeholder="Enter your name ... "> </td>
                </tr>
                <tr>
                    <td colspan="2" > <input type="submit" name="submit" value="Add Admin" class="btn-secondary"></td>
                </tr>
            </table>

        </form>
    </div>
</div>




<?php include('partials/footer.php'); ?>



<?php 

//process the value from form and save it to database
//check whether the button is clicked or not

if(isset($_POST['submit'])){
    //   echo 'button clicked';


    //get data from form
    $full_name=$_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // password encryption with md5 

    //Sql query to save data to database

    $sql = "INSERT INTO tbl_admin SET 
    full_name = '$full_name',
    username = '$username',
    password = '$password'
    ";

   //executing query and saving data into database
    $res = mysqli_query($conn,$sql) ;


    //check if the data is correct

    if($res == true){
        //   echo'success';
        //create a session variable to display the message
        $_SESSION['add']="<div class='success'>Admin added successfully</div>";
        //redirect to manage-admin.php
        header('Location:'.SITEURL.'admin/manage-admin.php');
    }else{
        // echo 'error';

        $_SESSION['add']='Failed to add admin';
        //redirect to add-admin
        header('Location:'.SITEURL.'admin/add-admin.php');
    }

}






?>