<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_POST['submit'])) {

    //Fetch data from HTML Form
    $level_name = mysqli_real_escape_string($con, $_POST['level_name']);

    // Validate Data
    $level_name = validate_data($level_name);
    
    // Prepare and execute the SQL statement to insert a new record in the tbl_level
    $stmt = $con->prepare("INSERT INTO `tbl_level` (name) VALUES (?)");
    $stmt->bind_param("s", $level_name);
    $result = $stmt->execute();

    if ($result) {
        //Sweet Alert of Success Message
        $_SESSION['status'] = "Level Inserted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='level_view.php'},1000);</script>";
    } else {
        //Sweet Alert of Error Message
        $_SESSION['status'] = "Level Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='level_view.php'},1000)</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Header file -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>


<body class="hold-transition sidebar-mini layout-fixed">

    <!-- PreLoader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>

    <!-- Wrapper Class Start -->
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
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Level</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Level</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div><!-- /.content-header -->

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
                                    <h3 class="card-title">Add Level</h3>
                                </div><!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" method="POST">
                                    <!-- card-body -->
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="level_name">Level Name <span style="color: red;">*</span></label>
                                            <input type="text" name="level_name" class="form-control" id="level_name" placeholder="Enter Level Name" required>
                                        </div>

                                        <!-- card-footer -->
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div><!-- /.card-footer -->

                                    </div><!-- /.card-body -->
                                </form>
                            </div><!-- /.card -->
                        </div><!--/.col (left) -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
        </div><!-- /.content-wrapper -->

        <!-- Footer -->
        <?php include '../include/importfooter.php'; ?>

    </div>
    <!-- ./Wrapper -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body><!-- ./body -->

</html>