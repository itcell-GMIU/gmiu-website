<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// Include the database connection file
// include '../common/db_connect.php';

if (isset($_POST['submit'])) {

    // Fetch data from HTML form
    $role = mysqli_real_escape_string($con, $_POST['role']);
    // Insert data into database
    $stmt = $con->prepare("INSERT INTO tbl_career_role ( name ) VALUES ( ? )");
    $stmt->bind_param("s",  $role );
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = "Career post inserted successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Insertion failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='insert.php'},1000);</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <!-- header -->
    <?php include '../include/importhead.php'; ?>
    <!-- /.header -->

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> <!-- /.Preloader -->

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
                <!-- container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row mb-2">

                        <!-- col -->
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Role</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Role</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div> <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <!-- container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- card -->
                            <div class="card card-gmiu">

                                <!-- card-header -->
                                <div class="card-header">
                                    <h3 class="card-title">Add Role</h3>
                                </div> <!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">

                                    <!-- card-body -->
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Title<span style="color: red;"> *</span></label>
                                            <input type="text" name="role" class="form-control" id="role"
                                                placeholder="Enter role Title" required>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>

                                    </div> <!-- /.card-body -->
                                </form>
                            </div> <!-- /.card -->
                        </div> <!--/.col (left) -->
                    </div> <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section> <!-- /.content -->
        </div> <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->


    <!-- footer -->
    <?php include '../include/importfooter.php'; ?>
    <!-- /.footer -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>
