<?php include('partials/menu.php');  ?>
<!-- menu session ends -->



<!-- main content session start -->
<div class="main-content">
    <div class="wrapper">
        <h1>Dashboard</h1>
        <br>
        <br>

        <?php
        if (isset($_SESSION['login'])) {

            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>
        <br>
        <br>

        <div class="col-4 text-center">
            <?php
            //sqlQuery
            $sql = "SELECT * FROM tbl_category";
            //execute sql query
            $res = mysqli_query($conn, $sql);
            //count rows returned
            $count = mysqli_num_rows($res)

            ?>
            <h1><?php echo $count; ?></h1>
            <br>
            Categories
        </div>
        <div class="col-4 text-center">
            <?php
            //sqlQuery
            $sql2 = "SELECT * FROM tbl_food";
            //execute sql query
            $res2 = mysqli_query($conn, $sql2);
            //count rows returned
            $count2 = mysqli_num_rows($res2)

            ?>
            <h1><?php echo $count2; ?></h1>
            <br>
            Foods
        </div>
        <div class="col-4 text-center">

            <?php
            //sqlQuery
            $sql3 = "SELECT * FROM tbl_order";
            //execute sql query
            $res3 = mysqli_query($conn, $sql3);
            //count rows returned
            $count3 = mysqli_num_rows($res3)

            ?>
            <h1><?php echo $count3; ?></h1>
            <br>
            Total Orders
        </div>
        <div class="col-4 text-center">
            <?php
            //create sql query to get total revenue generated
            //aggregate function in sql query
            $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status= 'Delivered'";

            //execute sql query
            $res4 = mysqli_query($conn, $sql4);

            //get the total
            $row4 = mysqli_fetch_assoc($res4);

            //get total revenue generated
            $total_revenue =$row4['Total'];
            
            ?>
            <h1>$<?php echo $total_revenue; ?></h1>
            <br>
            Revenue Generated
        </div>
        <div class="clearfix"></div>
    </div>

</div>
<!-- main content session ends -->



<?php include('partials/footer.php'); ?>