<?php
// Include necessary files
include '../include/checklogin.php';


// Fetch the ID from URL
$id = $_GET['id'];

// Fetch existing record
$query = "SELECT * FROM tbl_career_role WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (isset($_POST['update'])) {
    // Fetch data from form
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
  

    // Update database
    $updateQuery = "UPDATE tbl_career_role SET name=? , is_active=? WHERE id=?";
    $stmt = $con->prepare($updateQuery);
    $stmt->bind_param("sii", $role ,$status, $id);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Career post updated successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Update failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='edit.php?id=$id'},1000);</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
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
                            <h1 class="m-0">Edit role Name</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit role Name</li>
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
                                    <h3 class="card-title">Edit role Name</h3>
                                </div> <!-- /.card-header -->

                                <!-- form start -->
                                <form method="POST" enctype="multipart/form-data">

                                    <!-- card-body -->
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Title<span style="color: red;"> *</span></label>
                                            <input type="text" name="role" class="form-control"
                                                value="<?php echo $row['name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Status <span style="color: red;"> *</span></label>
                                            <select name="status" class="form-control" required>
                                                <option value="1" <?php echo ($row['is_active'] == 1) ? 'selected' : ''; ?>>Active</option>
                                                <option value="0" <?php echo ($row['is_active'] == 0) ? 'selected' : ''; ?>>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" name="update" class="btn btn-primary">Update</button>
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