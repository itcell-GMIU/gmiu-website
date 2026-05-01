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

            $name = $getData[0];
            $mobile_number = $getData[1];
            $email = $getData[2]; // Assuming the email is in the third column
            $role = $getData[3];
            $password = $getData[4];
            $program_id = $getData[5];
            $faculty_id = $getData[6];
            $level_id = $getData[7];
            $is_online = 0;       

            // Check if the email already exists with role_id = 15
            $checkQuery = $con->prepare("SELECT id FROM tbl_staff WHERE email = ? AND role_id = 15");
            $checkQuery->bind_param("s", $email);
            $checkQuery->execute();
            $result = $checkQuery->get_result();

            if ($result->num_rows > 0) {
                // Email exists, update the record
                // $updateQuery = $con->prepare("UPDATE tbl_staff SET is_active = 1, is_delete = 0 WHERE email = ? AND role_id = 15");
                // $updateQuery->bind_param("s", $email);
                // $updateQuery->execute();
                $updateQuery = $con->prepare("UPDATE tbl_staff SET is_active = 1, is_delete = 0, password = ? WHERE email = ? AND role_id = 15");
                $updateQuery->bind_param("ss", $password, $email);
                $updateQuery->execute();
            } else {
                // Insert new record into the database
                $stmt = $con->prepare("INSERT INTO `tbl_staff`(faculty_id, level_id, program_id, role_id, name, email, mobile_number, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iiiissss", $faculty_id, $level_id, $program_id, $role, $name, $email, $mobile_number, $password);
                $stmt->execute();
            }
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
                            <h1 class="m-0">Import Staff CSV</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Import Staff CSV</li>
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
                                            <a class="btn btn-dark p-1" href="demo_staff_csv.csv" download="demo_staff_csv.csv"><i class="fa fa-download"></i> Download Sample csv</a>
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