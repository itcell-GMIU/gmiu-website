<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include the checklogin.php file
include 'include/checklogin.php';
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
            $exam_id = $getData[0];
            $enrollnmet = $getData[1];
            $status = $getData[2];
            $gmiu_id = $getData[3];
            $ebz_id = $getData[4];
            $amount = $getData[5];
            $date = $getData[6];

            if ($status == "success") {
                $sts = 3;
            } else {
                $sts = 1;
            }

            // $inputDateTime = $date;
            // // Create a DateTime object from the input string
            // $dateTime = DateTime::createFromFormat('M-d-Y h:i:s A', $inputDateTime);
            // // Format the DateTime object into the desired format
            // $outputDateTime = $dateTime->format('Y-m-d H:i:s');
            
              // Create a DateTime object from the input string with error handling
            $dateTime = DateTime::createFromFormat('M-d-Y h:i:s A', $date);

            if ($dateTime === false) {
                // Handle the error, e.g., invalid date format
                // echo "Invalid date format: $date";
                continue; // Skip this row
            }

            // Format the DateTime object into the desired format
            $outputDateTime = $dateTime->format('Y-m-d H:i:s');

            $stmt = $con->prepare("UPDATE tbl_exam_student SET status = ? , transaction_id = ?, payment_id = ?, payment_status = ? , payment_date = ? , fee_amount = ? WHERE enrollnment_no = ? AND exam_id = ?");
            $stmt->bind_param("issssisi",$sts,$gmiu_id,$ebz_id,$status,$outputDateTime,$amount,$enrollnmet,$exam_id);
            $result = $stmt->execute();
        }
        // Error handling if update fails
        if ($result) {
            // If update is successful, redirect
            $_SESSION['status'] = "Exam Form Updated Successfully!";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='update_exam_txn.php'},1000)</script>";
        } else {
            $_SESSION['status'] = "Exam Form Update Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='update_exam_txn.php'},1000)</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">


    <!-- Navbar -->
    <?php include 'include/importnav.php'; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include 'include/importsidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <div class="wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Update Exam Transactions in Software</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Update Exam Transactions in Software</li>
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
                                        <h3 class="card-title col-sm-6">Update Exam Transactions</h3>
                                        <div class="col-sm-6 text-right">
                                            <a href="TimeTableCSV.csv" download="TimeTableCSV.csv" class="p-1 bg-light rounded"><i class="fa fa-download"></i> Download CSV Format</a>
                                        </div>
                                    </div>
                                    <!-- <h3 class="card-title">Update Exam Transactions-<a href="admission_sq.csv" download="admission_sq.csv">Click Here to download Sample to upload .csv file</a></h3>
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