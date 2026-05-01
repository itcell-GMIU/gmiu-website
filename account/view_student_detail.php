<?php
include './include/checklogin.php';

if (isset($_GET['stu_id'])) {
    $stu_id = mysqli_real_escape_string($con, $_GET['stu_id']);
    $stu_id = validate_data($stu_id);
} else {
    $stu_id = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">



        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Payment Details</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Payment Details</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i> Payment Details</b></h5>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="techevent" class="dataTableLoad table table-bordered table-hover">
                                    <thead>
                                        <tr align="center">

                                            <th scope="row" style="color:black;"><b>Transaction Id & Payment Id</b>
                                            </th>
                                            <th scope="row" style="color:black;"><b>Payment Status</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty</b></th>
                                            <th scope="row" style="color:black;"><b>Level</b></th>
                                            <th scope="row" style="color:black;"><b>Program</b></th>
                                            <th scope="row" style="color:black;"><b>Mode</b></th>
                                            <th scope="row" style="color:black;"><b>Payment Mode</b></th>
                                            <th scope="row" style="color:black;"><b>Token Amount </b></th>
                                            <th scope="row" style="color:black;"><b>Payment Date and Time</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                    $cmd = "Select stu.payment_date_time,stu.transaction_id,stu.payment_id,stu.mode,stu.payment_status,stu.payment_mode,stu.token_amount,pro.name as program_name,level.name as level_name,faculty.shortname as faculty_shortname,faculty.name as faculty_name from tbl_admission_student as stu LEFT JOIN tbl_program pro
                                    ON stu.program_id = pro.id LEFT JOIN tbl_faculty faculty
                                    ON stu.faculty_id = faculty.id LEFT JOIN tbl_level level
                                    ON stu.level_id = level.id where stu.id=? ";
                                    $stmt = $con->prepare($cmd);
                                    $stmt->bind_param("i", $stu_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($result->num_rows != 0) {
                                        $row = $result->fetch_assoc();
                                        $stu_transaction_id = $row['transaction_id'];
                                        $stu_payment_id = $row['payment_id'];
                                       
                                        $stu_mode = $row['mode'];
                                        $stu_token_amount = $row['token_amount'];
                                        $stu_payment_status = $row['payment_status'];
                                        $stu_payment_status = $row['payment_status'];
                                        $stu_payment_mode = $row['payment_mode'];
                                        $stu_faculty_name = $row['faculty_name'];
                                        $stu_level_name = $row['level_name'];
                                        $stu_program_name = $row['program_name'];
                                        $stu_payment_date_time = $row['payment_date_time'];
                                        
                                    ?>
                                        <tr align="center">
                                            <td scope="row"><?php echo $stu_transaction_id; ?>
                                                <?php echo "," . "<br>"; ?>
                                                <?php echo $stu_payment_id; ?>
                                            </td>
                                            <td scope="row"><?php echo $stu_payment_status; ?></td>
                                            <td scope="row"><?php echo $stu_faculty_name; ?></td>
                                            <td scope="row"><?php echo $stu_level_name; ?></td>
                                            <td scope="row"><?php echo $stu_program_name; ?></td>
                                            <td scope="row"><?php echo $stu_mode; ?></td>
                                            <td scope="row"><?php echo $stu_payment_mode; ?></td>
                                            <td scope="row"><?php echo $stu_token_amount; ?></td>
                                            <td scope="row"><?php echo $stu_payment_date_time; ?></td>


                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include 'include/importjs.php'; ?>
</body>

</html>