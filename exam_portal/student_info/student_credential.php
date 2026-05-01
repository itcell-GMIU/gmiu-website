<?php
// Include the checklogin.php file
include '../include/checklogin.php';


if (isset($_GET['std_er'])) {

    $std_er = mysqli_real_escape_string($con, $_GET['std_er']);
    $std_er = validate_data($std_er);
} else {
    $std_er = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>
    <title>Exam Reports</title>
    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
    <!-- wrapper -->
    <div class="wrapper">

        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Student Info</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Student Info</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!--   Program list code  -->

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>Student Info</b></h5>
                                </center>
                            </span>
                        </div>

                        <form method="GET" action="">

                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-9">
                                            <div class="form-label-group">
                                                <input type="text" class="form-control" name="std_er" placeholder="Enter Student Enrollment Number">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary btn-block" id="export" style="float:center"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                    <table id="acedemic" class="table table-bordered table-striped">
                                        <thead>
                                            <tr align="center">
                                                <th style="color:black;"><b>Enrollment no</b></th>
                                                <th style="color:black;"><b>Student Name</b></th>
                                                <th style="color:black;"><b>Sem</b></th>
                                                <th style="color:black;"><b>Email</b></th>
                                                <th style="color:black;"><b>Mobile No.</b></th>
                                                <th style="color:black;"><b>Password</b></th>
                                                <th style="color:black;"><b>Login</b></th>
                                            </tr>
                                        </thead>
                                <?php
                                if (isset($_GET['std_er'])) {

                                    $query2 = "SELECT id, first_name, middle_name, last_name,email,mobile_number,  password, semester, enrollnment_no FROM tbl_students_2023 WHERE enrollnment_no = ?";
                                    $stmt2 = $con->prepare($query2);
                                    $stmt2->bind_param("s", $std_er);
                                    $stmt2->execute();
                                    $result2 = $stmt2->get_result();

                                    if ($row2 = $result2->fetch_assoc()) {
                                        $std_name = $row2['first_name'] . ' ' . $row2['middle_name'] . ' ' . $row2['last_name'];
                                        $sem = $row2['semester'];
                                        $enrollnment_no = $row2['enrollnment_no'];
                                        $password = $row2['password'];
                                        $mobile_no = $row2['mobile_number'];
                                        $email = $row2['email'];

                                    
                                ?>
                                    
                                        <tbody class="tbody">
                                            <tr align="center">
                                                <td scope="row"><?= $enrollnment_no ?></td>
                                                <td scope="row"><?= $std_name ?></td>
                                                <td scope="row"><?= $sem ?></td>
                                                <td scope="row" class="text-lowercase"><?= $email ?></td>
                                                <td scope="row"><?= $mobile_no ?></td>
                                                <td scope="row"><?= $password ?></td>
                                                <td scope="row"><a href="../../student/index.php?enr=<?= $enrollnment_no?>&pass=<?= $password ?>" class="btn btn-primary text-nowrap"><i class="fa fa-arrow-right"></i></a></td>
                                            </tr>

                                        <?php
                                    }else{
                                            ?>
                                            
                                            <tr align="center">
                                                <td scope="row" colspan="4">No Student Found With This Enrollment Number!</td>
                                            </tr>
                                                
                                            <?php
                                        }
                                    }
                                        ?>
                                        </tbody>
                                    </table>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div><!-- /.container-fluid -->
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include '../include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- footer -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>