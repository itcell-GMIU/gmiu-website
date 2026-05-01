<?php
// Include the checklogin.php file
include '../include/checklogin.php';

//  fetch staff details from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $staff_id = mysqli_real_escape_string($con, $_GET['id']);
    $staff_id = only_digits($staff_id);
    if ($staff_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='staff_view.php'},1000)</script>";
    }

    $cmd = $con->prepare("SELECT staff.id as staff_id,
                                 staff.role_id as role_id,
                                 staff.name as staff_name, 
                                 staff.mobile_number as staff_mobile_number,
                                 staff.email as staff_email,
                                 staff.password as staff_password,
                                 staff.is_active as staff_is_active 
                                 FROM tbl_staff as staff WHERE staff.id = ? ");
    $cmd->bind_param("i", $staff_id);
    $cmd->execute();
    $result = $cmd->get_result();

    if ($result->num_rows != 0) {

        // Fetch data from database
        $row = $result->fetch_assoc();
        $staff_name = $row['staff_name'];
        $staff_role = $row['role_id'];
        $staff_mobile_number = $row['staff_mobile_number'];
        $staff_email = $row['staff_email'];
        $staff_password = $row['staff_password'];
        $staff_is_active = $row['staff_is_active'];
    } else {

        $staff_name = "";
        $staff_mobile_number = "";
        $staff_email = "";
        $staff_password = "";
        $staff_is_active = "";
    }
} else {

    $staff_name = "";
    $staff_mobile_number = "";
    $staff_email = "";
    $staff_password = "";
    $staff_is_active = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>


    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
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
                                <li class="breadcrumb-item active">Edit Staff Details</li>
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
                                    <h3 class="card-title">Edit Staff Details</h3>
                                </div> <!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" method="POST" action="staff_update.php"
                                    enctype="multipart/form-data">

                                    <!-- card-body -->
                                    <div class="card-body">
                                        <!-- hidden staff_id -->
                                        <input type="hidden" name="staff_id" value="<?php echo $staff_id; ?>">

                                        <div class="form-group">
                                            <label>Name<span style="color: red;"> *</span></label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                value="<?php echo $staff_name; ?>" placeholder="Enter Name">
                                        </div>

                                        <div class="form-group">
                                            <label>Contact<span style="color: red;"> *</span></label>
                                            <input type="text" name="mobile_number" class="form-control"
                                                id="mobile_number" value="<?php echo $staff_mobile_number; ?>"
                                                placeholder="Enter Mobile Number">
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Email <span style="color: red;"> *</span></label>
                                            <input type="text" name="email" class="form-control" id="email"
                                                value="<?php echo $staff_email; ?>" placeholder="Enter Email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Password <span style="color: red;"> *</span></label>
                                            <input type="text" name="password" class="form-control" id="password"
                                                value="<?php echo $staff_password; ?>" placeholder="Enter Password" required>
                                        </div>



                                        <!-- card-footer -->
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        <!-- /.card-footer -->

                                    </div> <!-- /.card-body -->
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

<!-- Library for image preview -->
<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>