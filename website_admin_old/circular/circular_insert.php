<?php
include '../include/checklogin.php';

// Check if the form is submitted   
if (isset($_POST["submit"])) {
    $circular_img =  $_FILES['file_input'];
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $type = mysqli_real_escape_string($con, $_POST['c_type']);
    $date = mysqli_real_escape_string($con, $_POST['date']);

    // Check if the image type is 'circular _image'

    if (isset($_FILES['file_input'])) {
        $targetDirectory = "../uploads/circular/";
        $file_upload_status = upload_single_file($_FILES["file_input"], $targetDirectory, 0); // Upload the single file using a custom function 'upload_single_file'
        // Check if the file upload was successful
        if ($file_upload_status['status'] == 200) {
            $file_name = $file_upload_status['message'];

            $stmt = $con->prepare("INSERT INTO `tbl_circular`(`file_name`,`title`,`type`,date)VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $file_name, $title, $type, $date);
            $result = $stmt->execute();
            if ($result) {
                $_SESSION['status'] = "Circular Inserted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='circular_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "Circular Insertion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='circular_insert.php'},1000)</script>";
            }
        } else {
            $_SESSION['status'] = $file_upload_status['message'];
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='circular_insert.php'},1000)</script>";
            //error message popup
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

</head>



<body class="hold-transition sidebar-mini layout-fixed">
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
                            <h1 class="m-0">Add Circular</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Circular</li>

                            </ol>
                        </div><!-- /.col -->



                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <form method="POST" enctype='multipart/form-data'>
                    <div class="container-fluid">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- jquery validation -->
                                <div class="card card-gmiu">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Circular</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="title_name">Title<span style="color: red;">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter Circular Title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="c_type_i">Type Of Circular<span style="color: red;">*</span></label>
                                            <select id="c_type_i" onchange="insertContactfields()" class="form-control" name="c_type" required>
                                                <option value="">---Select Circular Type---</option>
                                                <option value="Regular">Regular</option>
                                                <option value="Exam">Exam</option>
                                                <option value="Academic">Academic</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="level_name">Date<span style="color: red;">*</span></label>
                                            <input type="date" name="date" class="form-control" id="title" required>
                                        </div>
                                        <label for="exampleInputFile">Upload Circular</label><span style="color: red;">*</span>
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="file_input" id="file_input" required>
                                                <label class="custom-file-label" for="exampleInputFile">Choose
                                                    file</label>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
        </div>
        <!-- /.card -->
    </div>
    <!--/.col (left) -->
    <!-- right column -->
    <div class="col-md-6">

    </div>
    <!--/.col (right) -->
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
    </section>
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

    <?php include '../include/importjs.php'; ?>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
    <script src="../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
</body>

</html>