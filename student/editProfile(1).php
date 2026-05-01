<?php
include './include/checklogin.php';

if (isset($_POST['update'])) {
    extract($_POST);
    if (isset($_POST['first_name']) && isset($_POST['middle_name']) && isset($_POST['last_name'])) {
        $stmt = $con->prepare("UPDATE tbl_students_2023 SET first_name=?,middle_name=?, last_name=?, email = ?, mobile_number = ? WHERE id = ?");
        $stmt->bind_param("ssssii", $first_name, $middle_name, $last_name, $email, $mobile, $student_id);
        $result = $stmt->execute();
    } else {
        $stmt = $con->prepare("UPDATE tbl_students_2023 SET email = ?, mobile_number = ? WHERE id = ?");
        $stmt->bind_param("sii", $email, $mobile, $student_id);
        $result = $stmt->execute();
    }
    // Error handling if update fails
    if ($result) {
        // If update is successful, redirect
        $_SESSION['status'] = "Update Successfull!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='editProfile.php'},1000)</script>";
    } else {
        $_SESSION['status'] = "Update Failed!";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='editProfile.php'},1000)</script>";
    }
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
                            <h1 class="m-0">Edit User Profile</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid ">
                    <div class="card card-primary">

                        <!-- form start -->
                        <form class="form" method="post">
                            <div class="card-body">
                                <?php
                                if ($first_name == "N/A" || $middle_name == "N/A" || $last_name == "N/A") {
                                ?>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" value="<?php echo $first_name ?>">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="middle_name">Middle Name</label>
                                            <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter Middle Name" value="<?php echo $middle_name ?>">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" value="<?php echo $last_name ?>">
                                        </div>
                                    </div>
                                <?php }
                                ?>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?php echo $email ?>">
                                </div>
                                <div class="form-group">
                                    <label for="mobile">Mobile Number</label>
                                    <input type="number" class="form-control" name="mobile" id="mobile" placeholder="Enter mobile number" value="<?php echo $mobile_number ?>">
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.container-fluid -->
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