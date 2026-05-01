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
            $exam_id = $getData[0];
            $date = $getData[1];
            $start_time = $getData[2];
            $end_time = $getData[3];
            $subject_code = $getData[4];
            $subject_name = $getData[5];
            $sub_type = $getData[6];

            // $cmd = "INSERT INTO `tbl_exam_timetable`(`exam_id`, `subject_code`, `date`, `start_time`, `end_time`, `sub_type`, `subject_name`) VALUES ('$exam_id','$subject_code','$date','$start_time','$end_time','$sub_type','$subject_name')";
            // $stmt = $con->prepare($cmd);
            // $stmt->execute();
            // $result = $stmt->get_result();
            
             $checkCmd = "SELECT * FROM `tbl_exam_timetable` WHERE `exam_id` = ? AND `subject_code` = ? AND `sub_type` = ?";
            $checkStmt = $con->prepare($checkCmd);
            $checkStmt->bind_param("sss", $exam_id, $subject_code, $sub_type);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                // Entry exists, update it
                $updateCmd = "UPDATE `tbl_exam_timetable` SET 
                              `date` = ?,
                              `start_time` = ?,
                              `end_time` = ?,
                              `subject_name` = ?
                              WHERE `exam_id` = ? AND `subject_code` = ? AND `sub_type` = ?";
                
                $updateStmt = $con->prepare($updateCmd);
                $updateStmt->bind_param("sssssss", $date, $start_time, $end_time, $subject_name, $exam_id, $subject_code, $sub_type);
                $updateStmt->execute();
            } else {
                // Entry does not exist, insert a new one
                $insertCmd = "INSERT INTO `tbl_exam_timetable`(`exam_id`, `subject_code`, `date`, `start_time`, `end_time`, `sub_type`, `subject_name`) 
                              VALUES (?, ?, ?, ?, ?, ?, ?)";
                
                $insertStmt = $con->prepare($insertCmd);
                $insertStmt->bind_param("sssssss", $exam_id, $subject_code, $date, $start_time, $end_time, $sub_type, $subject_name);
                $insertStmt->execute();
            }
        }
        $_SESSION['status'] = "Imported Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='upload_schedule.php'},1000)</script>";
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
                                            <a href="TimeTableCSV.csv" download="TimeTableCSV.csv" class="p-1 bg-light rounded"><i class="fa fa-download"></i> Download CSV Format</a>
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
                                            <label for="name">Select Excel<span style="color: red;">*</span></label>
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

    <script>
        $(document).ready(function() {
            //call for listing the dropdown and select by default
            load_level();
            load_program();
        });

        function load_level() {
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $faculty_id; ?>;
            var level_id = <?php echo $level_id; ?>;

            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id
                },
                success: function(result) {
                    $('#level_id').html(result);

                    // console.log(result);
                }
            });

        }

        function load_program() {
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $faculty_id; ?>;
            var level_id = <?php echo $level_id; ?>;

            $.ajax({
                url: path + 'program.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id
                },
                success: function(result) {
                    $('#program_id').html(result);

                    // console.log(result);
                }
            });

        }
    </script>
    <script type="text/javascript">
        $('#faculty_id').on('change', function() {
            var path = '<?php echo "$base_url_api"; ?>';
            var faculty_id = this.value;
            // alert("hii");
            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id
                },
                success: function(result) {
                    $('#level_id').html(result);

                    // console.log(result);
                }
            })
        });

        $('#level_id').on('change', function() {
            var path = '<?php echo "$base_url_api"; ?>';
            var level_id = this.value;
            var faculty_id = $("select#faculty_id option:checked").val();
            /*  alert(level_id); */

            $.ajax({
                url: path + 'program.php',
                type: "POST",
                data: {
                    level_data: level_id,
                    faculty_data: faculty_id
                },
                cache: false,
                success: function(data) {
                    $('#program_id').html(data);
                    // console.log(data);
                }
            })
        });
    </script>

</body>

</html>