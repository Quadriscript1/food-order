<?php
include('partials/menu.php')
?>

<div class="main-content">
    <div class="wrapper">
        <h1>update admin</h1>
        <br><br>
        <?php
        //get the id of the selected admin
        $id = $_GET['id'];

        //create a query to get the admin details
        $sql = "SELECT * FROM tbl_admin WHERE id=$id";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //check whether the query is executed successfully
        if ($res == true) {

            $count = mysqli_num_rows($res);

            if ($count == 1) {
               // echo 'admin available';
               $rows = mysqli_fetch_assoc($res);

               $full_name =$rows['full_name'];
               $username =$rows['username'];
            }else{
                header('Location:'.SITEURL.'/admin/manage-admin.php');
            }
        }




        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>FullName:</td>
                    <td><input type="text" name="full_name" value="<?php echo $full_name ;?>"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" value="<?php echo $username ; ?>"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Add Admin " class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<?php
    if(isset($_POST['submit'])){
        //get the value of the form to update

        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username']; 

        //create a sql query to update admin table
        $sql = "UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$username' WHERE id = '$id'";

        //execute the query
        $res =mysqli_query($conn, $sql);

        //check if the query succeed execution

        if($res == true){
            $_SESSION['update'] ="<div class='success'>Admin added successfully</div>";

            header('Location:'.SITEURL.'admin/manage-admin.php');
        }else{
            $_SESSION['update'] ="<div class='error'> failed to update</div>";

            header('Location:'.SITEURL.'admin/manage-admin.php');
        }

    }
?>







<?php
include('partials/footer.php')
?>