<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the checklogin.php file
include '../include/checklogin.php';
if (isset($_POST["import"])) {
    $o_faculty_id = $_POST['faculty_id'];
    $semester = $_POST['sem'];
    $year = date("Y");


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
            $enrollnment = $getData[1];
            // Initialize an empty array to store non-empty subjects
            $subjectArray = [];

            // Check and add non-empty subjects to the array
            for ($i = 1; $i <= 14; $i++) {
                $i++;
                if (!empty($getData[$i])) {
                    $subjectArray[] = $getData[$i];
                }
            }

            // Convert the array to a comma-separated string
            $subjects = implode(', ', $subjectArray);

            //subject name 
            $subjectnameArray = [];

            // Check and add non-empty subjects to the array
            for ($i = 2; $i <= 15; $i++) {
                $i++;
                if (!empty($getData[$i])) {
                    $subjectnameArray[] = $getData[$i];
                }
            }
            // Convert the array to a comma-separated string
            $subject_name = implode(', ', $subjectnameArray);

            // Check if a record with the same enrollment number and semester exists
            $checkQuery = "SELECT * FROM tbl_student_subjects WHERE enrollnment_no = '$enrollnment' AND semester = '$semester'";
            $result = $con->query($checkQuery);

            if ($result->num_rows > 0) {
                // Record already exists, update it
                $updateQuery = "UPDATE tbl_student_subjects SET subject_code = '$subjects', subject_name = '$subject_name' WHERE enrollnment_no = '$enrollnment' AND semester = '$semester'";
                $con->query($updateQuery);
            } else {
                // Record doesn't exist, insert a new one
                $insertQuery = "INSERT INTO tbl_student_subjects (enrollnment_no, semester, subject_code, subject_name) VALUES ('$enrollnment', '$semester', '$subjects', '$subject_name')";
                $con->query($insertQuery);
            }
        }
        $_SESSION['status'] = "Imported Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='import_student_subject.php'},2000)</script>";
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
                            <h1 class="m-0">Import Student Subject in Software</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Import Student Subject in Software</li>
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
                                        <h3 class="card-title col-sm-6">Import Student Subject</h3>
                                        <div class="col-sm-6 text-right">
                                            <a href="subject_import.csv" download="subject_import.csv" class="p-1 bg-light rounded"><i class="fa fa-download"></i> Download CSV Format</a>
                                        </div>
                                    </div>
                                    <!-- <h3 class="card-title">Import Student Subject-<a href="admission_sq.csv" download="admission_sq.csv">Click Here to download Sample to upload .csv file</a></h3>
                                    <br>
                                    <span><a href="admission_all_relation.xlsx" download="admission_all_relation.xlsx">Click here to download Relational table excel.</a></span> -->
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <div class="card-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>Select Faculty<span style="color: red;"> *</span></label>
                                            <select class="form-control" name="faculty_id" required id="faculty_id">
                                                <option value="">---Select Faculty---</option>
                                                <?php
                                                $cmd = "SELECT id,name FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    $faculty_id = $row['faculty_id'];
                                                ?>

                                                    <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                        <?php echo $row['name'] ?></option>
                                                <?php } ?>

                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <label>Select Level<span style="color: red;"> *</span></label>
                                            <select name="level_id" id="level_id" class="form-control" required>
                                                <option value="">---Select Level---</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Program<span style="color: red;"> *</span></label>
                                            <select name="program_id" id="program_id" class="form-control" required>
                                                <option value="">---Select Program---</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select sem<span style="color: red;"> *</span></label>
                                            <select name="sem" id="sem" class="form-control" required>
                                                <option value=""> --- Semester--- </option>
                                                <option value="1"> Semester 1</option>
                                                <option value="2"> Semester 2</option>
                                                <option value="3"> Semester 3</option>
                                                <option value="4"> Semester 4</option>
                                                <option value="5"> Semester 5</option>
                                                <option value="6"> Semester 6</option>
                                                <option value="7"> Semester 7</option>
                                                <option value="8"> Semester 8</option>
                                            </select>
                                        </div>

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