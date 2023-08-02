<?php include('partials/menu.php'); ?>



<!-- main content session start -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br>
        <br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']); //remove session message
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']); //remove session message
        }

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']); //remove session message
        }
        if (isset($_SESSION['user-not-found'])) {
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']); //remove session message
        }
        if (isset($_SESSION['pwd-not-match'])) {
            echo $_SESSION['pwd-not-match'];
            unset($_SESSION['pwd-not-match']); //remove session message
        }
        if (isset($_SESSION['change-pwd'])) {
            echo $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']); //remove session message
        }
        ?>
        <br>
        <br>
        <br>


        <a href="add-admin.php" class="btn-primary"> Add Admin</a>
        <br>
        <br>

        <table class="tbl-full">
            <tr>
                <th>S/N </th>
                <th>Full Name </th>
                <th> Username </th>
                <th>Actions </th>
            </tr>

            <?php
            //query to get all thge admin tables
            $sql = "SELECT * FROM tbl_admin";

            //execute query
            $res = mysqli_query($conn, $sql);


            if ($res == true) {
                //count used to check if theres data in the database
                $count = mysqli_num_rows($res); //function to get all rows in the database
                $sn = 1;

                //check the number of rows
                if ($count > 0) {
                    //we have data in database
                    while ($rows = mysqli_fetch_assoc($res)) {
                        //using while loop to get data from the database
                        //while loop will run if data is available


                        //get indivdual data from the database
                        $id = $rows['id'];
                        $username = $rows['username'];
                        $full_name = $rows['full_name'];

                        //displaythe value on the table
            ?>
                        <tr>
                            <td><?php echo $sn++ ?></td>
                            <td><?php echo $full_name ?></td>
                            <td><?php echo $username ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary"> Update Admin</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                            </td>
                        </tr>
            <?php

                    }
                }
            }





            ?>
           
        </table>

    </div>

</div>
<!-- main content session ends -->

<?php include('partials/footer.php'); ?>