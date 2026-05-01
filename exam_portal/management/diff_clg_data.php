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
            $erNo = $getData[0];
            $seatNo = $getData[1];
            $clgCode = $getData[2];

            $cmd = "UPDATE `tbl_exam_results` SET college_code = '$clgCode' WHERE enrollnment_no = '$erNo' AND seat_no = '$seatNo'";
            $stmt = $con->prepare($cmd);
            $stmt->execute();
            $result = $stmt->get_result();
        }
        $_SESSION['status'] = "Imported Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='diff_clg_data.php'},1000)</script>";
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
                            <h1 class="m-0">Import Time Table in Software</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Import Time Table in Software</li>
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
                                    <div class="row">
                                        <h3 class="card-title col-sm-6">Import Time Table</h3>
                                        <div class="col-sm-6 text-right">
                                            <a href="" download="newCollegeData.csv" class="p-1 bg-light rounded"><i class="fa fa-download"></i> Download CSV Format</a>
                                        </div>
                                    </div>
                                    <!-- <h3 class="card-title">Import Time Table-<a href="admission_sq.csv" download="admission_sq.csv">Click Here to download Sample to upload .csv file</a></h3>
                                    <br>
                                    <span><a href="admission_all_relation.xlsx" download="admission_all_relation.xlsx">Click here to download Relational table excel.</a></span> -->
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