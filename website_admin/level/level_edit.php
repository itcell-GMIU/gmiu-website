<?php
// Include the checklogin.php file
include '../include/checklogin.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Header  -->
    <?php include '../include/importhead.php'; ?>`

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<?php

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $level_id = mysqli_real_escape_string($con, $_GET['id']);
    $level_id = only_digits($level_id);
    if ($level_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='level_view.php'},1000)</script>"; 
        }
    // Fetch level id from display table
    $cmd = $con->prepare("SELECT level.name as level_name, level.is_active as level_is_active FROM tbl_level as `level` WHERE id = ?");
    $cmd->bind_param("i", $level_id);
    $cmd->execute();
    $result = $cmd->get_result();

    while ($row = $result->fetch_assoc()) {

        // Fetch data from database
        $level_name = !empty($row['level_name']) ? $row['level_name'] : 'N/A';
        $level_is_active = $row['level_is_active'];
    }
}
?>

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
                <!-- Container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row mb-2">
                        <!-- col -->
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit Level</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Level</li>
                            </ol>
                        </div> <!-- /.col -->
                    </div> <!-- /.row -->
                </div> <!-- /.container-fluid -->
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
                                <!-- card header -->
                                <div class="card-header">
                                    <h3 class="card-title">Edit Level</h3>
                                </div> <!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" method="POST" action="level_update.php">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <input type="hidden" name="level_id" value="<?php echo $level_id; ?>">

                                        <div class="form-group">
                                            <label for="name">Name <span style="color: red;">*</span></label>
                                            <input type="text" name="level_name" class="form-control" id="name" placeholder="Enter Name" value="<?php echo $level_name; ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="is_active">Status <span style="color: red;">*</span></label>
                                            <select class="form-control" name="level_is_active" id="is_active" required>
                                                <option value="1" <?php if ($level_is_active == "1") {
                                                                        echo "selected";
                                                                    } ?>>Active
                                                </option>
                                                <option value="0" <?php if ($level_is_active == "0") {
                                                                        echo "selected";
                                                                    } ?>>
                                                    InActive</option>
                                            </select>
                                        </div>

                                        <!-- card footer -->
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div> <!-- /.card footer -->
                                    </div> <!-- /.card-body -->
                                </form> <!-- /.form end -->
                            </div> <!-- /.card -->
                        </div> <!--/.left column -->
                    </div> <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section> <!-- /.content -->
        </div> <!-- /.content-wrapper -->

        <!-- footer -->
        <?php include '../include/importfooter.php'; ?>
        <!-- /.footer -->

    </div> <!-- ./wrapper -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>