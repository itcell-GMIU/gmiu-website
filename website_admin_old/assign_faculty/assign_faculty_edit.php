<?php
// Include the checklogin.php file
include '../include/checklogin.php';

//  fetch staff details from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $staff_id = $_GET['id'];
    $staff_id = only_digits($staff_id);
    if ($staff_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='assign_faculty_view.php'},1000)</script>";
    }

    $cmd = $con->prepare("SELECT staff.id as staff_id,staff.role_id as role_id,
    staff.name as staff_name,staff.email as staff_email, staff.password as staff_password, staff.is_active as staff_is_active FROM tbl_staff as staff WHERE staff.id = ? ");
    $cmd->bind_param("i", $staff_id);
    $cmd->execute();
    $result = $cmd->get_result();

    if ($result->num_rows != 0) {

        // Fetch data from database
        $row = $result->fetch_assoc();
        $role_id2 = $row['role_id'];
        $staff_name = $row['staff_name'];
        $staff_email = $row['staff_email'];
        $staff_password = $row['staff_password'];
    } else {

        $staff_name = "";
        $staff_email = "";
        $staff_password = "";
        $role_id2 = "";
    }
} else {

    $staff_name = "";
    $staff_email = "";
    $staff_password = "";
    $role_id2 = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>

    <style>
        #row-form {
            display: grid;
        }
    </style>
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
                            <h1 class="m-0">Edit Staff Details</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Assign Role</li>
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
                                    <h3 class="card-title">Assign Role</h3>
                                </div> <!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" method="POST" action="assign_faculty_update.php" enctype="multipart/form-data">

                                    <!-- card-body -->
                                    <div class="card-body">
                                        <!-- hidden staff_id -->
                                        <input type="hidden" name="staff_id" value="<?php echo $staff_id; ?>">

                                        <div class="form-group">
                                            <label>Name<span style="color: red;"> *</span></label>
                                            <input type="text" name="staff_name" class="form-control" id="staff_name" value="<?php echo $staff_name; ?>" placeholder="Enter Name" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Username<span style="color: red;"> *</span></label>
                                            <input type="text" name="email" class="form-control" id="email" value="<?php echo $staff_email; ?>" placeholder="Enter Username">
                                        </div>

                                        <div class="form-group">
                                            <label>Password<span style="color: red;"> *</span></label>
                                            <input type="text" name="password" class="form-control" id="password" value="<?php echo  $staff_password; ?>" placeholder="Enter password">
                                        </div>
                                        <div class="form-group">
                                            <label>Assign Role<span style="color: red;"> *</span></label>
                                            <select class="form-control" name="role_id" required id="role_id">
                                                <option value="">---Assign Role---</option>
                                                <?php
                                                $cmd = "SELECT * FROM tbl_role WHERE is_delete = '0' and is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                ?>

                                                    <option value="<?php echo $row['id'] ?>" <?php if ($role_id2 == $row['id']) {
                                                                                                    echo "selected";
                                                                                                } ?> >
                                                        <?php echo $row['name'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>


                                        <br />


                                        <br />
                                        <!-- card-footer -->
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        <!-- /.card-footer -->

                                    </div> <!-- /.card-body -->

                            </div>
                            </form>
                        </div> <!-- /.card -->
                    </div> <!--/.col (left) -->
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