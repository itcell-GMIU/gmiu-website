<?php
// Include the checklogin.php file
include '../include/checklogin.php';
if (isset($_POST["import"])) {

    $filename = $_FILES["file"]["tmp_name"];

    if ($_FILES["file"]["size"] > 0) {
       

        $file = fopen($filename, "r");
        // Flag to skip the first row
        $skipFirstRow = true;

        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
            // Skip the first row
            if ($skipFirstRow) {
                $skipFirstRow = false;
                continue;
            }

            $cmd = $con->prepare("SELECT COUNT(*) FROM tbl_inquiry_student ");
            $cmd->execute();
            $result = $cmd->get_result();
            $row = $result->fetch_row();
            $inq_student_id = $row[0] + 1;
            $inq_student_id_padded = str_pad($inq_student_id, 3, '0', STR_PAD_LEFT);
        
            $inq_student_id_final = "INQ" . "$inq_student_id_padded";
            $first_name = $getData[0];
            $middle_name = $getData[1];
            $last_name = $getData[2]; // Assuming the last name is in the third column
            $gender = $getData[3];
            $mobile_number = $getData[4];
            $second_mobile_number = $getData[5];
            $email = $getData[6];   
            $last_exam = $getData[7];
            $is_online = 0;
        

            $stmt = $con->prepare("INSERT INTO `tbl_inquiry_student`(`inq_student_id`, `first_name`, `middle_name`, `last_name`, `gender`,  `mobile_number`, `mobile_number2`, `email`, `last_exam`, `last_exam_marks`, `is_online`,created_by) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssssssiii", $inq_student_id_final, $first_name, $middle_name, $last_name, $gender,  $mobile_number, $second_mobile_number, $email, $last_exam, $last_exam_marks, $is_online,$staff_id);
            $result = $stmt->execute();
        }

        fclose($file);

        $_SESSION['status'] = "Imported Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='upload_csv.php'},2000)</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
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
                            <h1 class="m-0">Import Student in Software</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Import Student in Software</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-gmiu">
                                <div class="card-header h-100">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h3 class="card-title h-100 mt-1">Import Student</h3>
                                        </div>
                                        <div class="col-sm-9 text-right">
                                            <a class="btn btn-dark p-1" href="demo_inquiry_student_csv.csv" download="demo_inquiry_student_csv.csv"><i class="fa fa-download"></i> Download Sample csv</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Upload CSV<span style="color: red;">*</span></label>
                                            <input type="file" name="file" class="form-control h-100" id="file" accept=".csv" required>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <input type="submit" name="import" value="Import" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
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
</body>

</html>