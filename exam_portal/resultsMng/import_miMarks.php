<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

            $seatNo = $getData[0];
            $subject_code = $getData[1];
            $enrNo = $getData[2];
            $mse = $getData[3];
            $rmse = $getData[4];
            $practical = $getData[5];
            $ala = $getData[5];
            $viva = $getData[6];
            $ala = $getData[7];

            if ($mse == "AB") {
                $mse = "AB";
            }
            if ($mse == "" || empty($mse)) {
                $mse = 0;
            }

            if ($rmse == "" || empty($rmse)) {
                $rmse = NULL;
            }
            if ($rmse == "AB") {
                $rmse = "AB";
            }

            if ($ala == "AB") {
                $ala = "AB";
            }
            if ($ala == "" || empty($ala)) {
                $ala = NULL;
            }

            if ($viva == "" || empty($viva)) {
                $viva = NULL;
            }

            if ($viva == "AB") {
                $viva = "AB";
            }

            if ($practical == "AB") {
                $practical = "AB";
            }

            if ($practical == "" || empty($practical)) {
                $practical = NULL;
            }

            $stmt = $con->prepare("UPDATE tbl_exam_results SET Mpractical = ?, Mmid = ?, Mrmid = ?, Mviva = ?, Mala = ? , MpracticalTime = CURRENT_TIMESTAMP WHERE seat_no = ? AND subject_code = ? AND enrollnment_no = ? ");

            $stmt->bind_param(
                "ssssssss",
                $practical,
                $mse,
                $rmse,
                $viva,
                $ala,
                $seatNo,
                $subject_code,
                $enrNo
            );

            if (!($stmt->execute())) {
                // Handle the error appropriately
                echo "Error inserting data: " . $stmt->error;
            }
        }
        $_SESSION['status'] = "Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='import_miMarks.php'},1000)</script>";
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


    <!-- Navbar -->
    <?php include '../include/importnav.php'; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include '../include/importsidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <div class="wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Import MI marks</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Import MI marks</li>
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


                                <div class="card-header">
                                    <!-- <h3 class="card-title">Import Student-<a href="admission_sq.csv" download="admission_sq.csv">Click Here to download Sample to upload .csv file</a></h3>
                                    <br>
                                    <span><a href="admission_all_relation.xlsx" download="admission_all_relation.xlsx">Click here to download Relational table excel.</a></span> -->
                                    <h3 class="card-title">Import Student</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <div class="card-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="name">Select CSV<span style="color: red;">*</span></label>
                                            <input type="file" name="file" class="form-control" id="file" accept=".csv" required>
                                        </div>
                                        <div class="card-footer text-right">
                                            <input type="submit" name="import" value="Import" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->

            </section>
        </div><!-- /.container-fluid -->
    </div>
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