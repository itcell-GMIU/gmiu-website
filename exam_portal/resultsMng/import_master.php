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

            $subject_code = $getData[2];
            $subject_name = $getData[3];
            $subject_name = str_replace("?", " ", $subject_name);
            $L = $getData[4];
            $T = $getData[5];
            $P = $getData[6];
            $credit = $getData[7];
            $entESE = $getData[8];
            $contESE = $getData[9];
            $passESE = $getData[10];
            $entPRACTICAL = $getData[11];
            $contPRACTICAL = $getData[12];
            $passPRACTICAL = $getData[13];
            $entMSE = $getData[14];
            $contMSE = $getData[15];
            $passMSE = $getData[16];
            $entVIVA = $getData[17];
            $contVIVA = $getData[18];
            $passVIVA = $getData[19];
            $entALA = $getData[20];
            $contALA = $getData[21];
            $passALA = $getData[22];
            $passingMARK = $getData[23];

            // Check if the subject code already exists in the database
            $stmt_check = $con->prepare("SELECT * FROM tbl_subject_master WHERE subject_code = ?");
            $stmt_check->bind_param("s", $subject_code);
            $stmt_check->execute();
            $result = $stmt_check->get_result();

            // If a record with the subject code exists, update it. Otherwise, insert a new record.
            if ($result->num_rows > 0) {
                $stmt = $con->prepare("
        UPDATE tbl_subject_master 
        SET 
            subject_name = ?,
            L = ?,
            T = ?,
            P = ?,
            credit = ?,
            entESE = ?,
            contESE = ?,
            passESE = ?,
            entPRACTICAL = ?,
            contPRACTICAL = ?,
            passPRACTICAL = ?,
            entMSE = ?,
            contMSE = ?,
            passMSE = ?,
            entVIVA = ?,
            contVIVA = ?,
            passVIVA = ?,
            entALA = ?,
            contALA = ?,
            passALA = ?,
            passingMARK = ?
        WHERE subject_code = ?
    ");
                $stmt->bind_param(
                    "ssssssssssssssssssssss",
                    $subject_name,
                    $L,
                    $T,
                    $P,
                    $credit,
                    $entESE,
                    $contESE,
                    $passESE,
                    $entPRACTICAL,
                    $contPRACTICAL,
                    $passPRACTICAL,
                    $entMSE,
                    $contMSE,
                    $passMSE,
                    $entVIVA,
                    $contVIVA,
                    $passVIVA,
                    $entALA,
                    $contALA,
                    $passALA,
                    $passingMARK,
                    $subject_code
                );
            } else {
                $stmt = $con->prepare("
        INSERT INTO tbl_subject_master (
            subject_code, subject_name, L, T, P, credit, entESE, contESE, passESE, 
            entPRACTICAL, contPRACTICAL, passPRACTICAL, entMSE, contMSE, passMSE, 
            entVIVA, contVIVA, passVIVA, entALA, contALA, passALA, passingMARK
        ) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
                $stmt->bind_param(
                    "ssssssssssssssssssssss",
                    $subject_code,
                    $subject_name,
                    $L,
                    $T,
                    $P,
                    $credit,
                    $entESE,
                    $contESE,
                    $passESE,
                    $entPRACTICAL,
                    $contPRACTICAL,
                    $passPRACTICAL,
                    $entMSE,
                    $contMSE,
                    $passMSE,
                    $entVIVA,
                    $contVIVA,
                    $passVIVA,
                    $entALA,
                    $contALA,
                    $passALA,
                    $passingMARK
                );
            }
            // $stmt = $con->prepare("INSERT INTO `tbl_subject_master` 
            // (`subject_code`, `subject_name`, `L`, `T`, `P`, `credit`, `entESE`, `contESE`, `passESE`, 
            //  `entPRACTICAL`, `contPRACTICAL`, `passPRACTICAL`, `entMSE`, `contMSE`, `passMSE`, 
            //  `entVIVA`, `contVIVA`, `passVIVA`, `entALA`, `contALA`, `passALA`, `passingMARK`) 
            // VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            // $stmt->bind_param(
            //     "ssssssssssssssssssssss",
            //     $subject_code,
            //     $subject_name,
            //     $L,
            //     $T,
            //     $P,
            //     $credit,
            //     $entESE,
            //     $contESE,
            //     $passESE,
            //     $entPRACTICAL,
            //     $contPRACTICAL,
            //     $passPRACTICAL,
            //     $entMSE,
            //     $contMSE,
            //     $passMSE,
            //     $entVIVA,
            //     $contVIVA,
            //     $passVIVA,
            //     $entALA,
            //     $contALA,
            //     $passALA,
            //     $passingMARK
            // );



            if (!($stmt->execute())) {
                // Handle the error appropriately
                echo "Error inserting data: " . $stmt->error;
            }
        }
        $_SESSION['status'] = "Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='import_master.php'},1000)</script>";
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
                            <h1 class="m-0">Import Master Data in Software</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Import Master Data in Software</li>
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