<?php
include '../include/checklogin.php';


if (isset($_POST['submit'])) {

    // Get data from the form
    $exam_date = $_POST['exam_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // $exam_id = $_POST['exam_id'];
    // Sanitize and prepare the values for insertion
    $exam_id = array_map('intval', $_POST['exam_id']);
    $all_exam_id = implode(',', $exam_id);


    $subject_code = $_POST['subject_code'];
    // $class = $_POST['class'];
    $sub_type = $_POST['sub_type'];

    for ($i = 0; $i < count($exam_date); $i++) {
        // Insert the JSON data into the database
        $stmt = $con->prepare("INSERT INTO tbl_exam_timetable(`exam_id`, `subject_code`, `sub_type`, `date`, `start_time`, `end_time`) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $all_exam_id, $subject_code[$i], $sub_type[$i], $exam_date[$i], $start_time[$i], $end_time[$i]);
        $result1 = $stmt->execute();
    }

    // Error handling if insertion fails
    if ($result1) {
        // If insertion is successful, redirect
        $_SESSION['status'] = "Exam Form Inserted Successfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location=''},1000)</script>";
    } else {
        $_SESSION['status'] = "Program Outcome Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location=''},1000)</script>";
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

    <!-- CKeditor custom script -->
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
    <!-- /.CKeditor custom script -->
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
                            <h1 class="m-0">Exam Time Table</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Exam Time Table</li>
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
                                    <h3 class="card-title">Exam Time Table</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label>Select Exams<span style="color: red;"> *</span></label>
                                                <div class="form-group">
                                                    <div class="selected-items"></div>
                                                    <select class="select2option" style="width: 100%" name="exam_id[]" multiple="multiple" required>
                                                        <?php
                                                        $status = 0;
                                                        $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.semester as semester, std.is_active as std_is_active, std.type as type , std.session as session , std.start_date as start_date, std.end_date as end_date, std.year as year,
                                                        faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_exam_form as std
                                                        LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                                        LEFT JOIN tbl_level level ON std.level_id = level.id 
                                                        LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = ?");
                                                        $cmd->bind_param("i", $status);
                                                        $cmd->execute();
                                                        $result = $cmd->get_result();
                                                        while ($row = $result->fetch_assoc()) {
                                                            $level_id = $row['level_id'];
                                                            $program_id = $row['program_id'];
                                                            $id = $row['id'];
                                                            $semester = $row['semester'];

                                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                                            $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                                            $Syllabus = !empty($row['Syllabus']) ? $row['Syllabus'] : "<b>N/A</b>";
                                                            $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                                            $sem = !empty($row['semester']) ? $row['semester'] : "<b>N/A</b>";
                                                            $std_is_active = $row['std_is_active'];
                                                            $exam_type = $row['type'];
                                                            $exam_session = $row['session'];
                                                            if ($row['type'] == "regular") {
                                                                $exam_type = "REGULAR";
                                                            } else {
                                                                $exam_type = "REMEDIAL";
                                                            }
                                                        ?>
                                                            <option value="<?php echo $id; ?>" class="text-uppercase">
                                                                <?php echo $faculty_name . ' ' . $level_name . ' ' . $program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div id="late_fee_entries">
                                                    <div class="late_fee_entry row">
                                                        <div class="form-group col-sm-2">
                                                            <label for="starting_date_1">Date:</label>
                                                            <input class="form-control" type="date" name="exam_date[]" required>
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <label for="ending_date_1">Time:</label>
                                                            <input class="form-control" type="time" name="start_time[]" required>
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <label for="ending_date_1">Time:</label>
                                                            <input class="form-control" type="time" name="end_time[]" required>
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <label for="late_fee_amount_1">Subject Type :</label>
                                                            <select class="form-control" name="sub_type[]" required>
                                                                <option value="theory">Theory</option>
                                                                <option value="practical">Practical</option>
                                                                <option value="external">External</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            <label for="late_fee_amount_1">For Subject :</label>
                                                            <input class="form-control" type="text" name="subject_code[]" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 align-self-center">
                                                <button class="btn btn-info mt-3" type="button" id="add_entry"><i class="fa fa-plus"></i> Add More Late Fee Entry</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </div>
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
    <script>
        $(document).ready(function() {
            $('.select2option').select2();
        });
    </script>


    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>

    <script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        document.getElementById('add_entry').addEventListener('click', function() {
            const lateFeeEntries = document.getElementById('late_fee_entries');
            const newEntry = document.querySelector('.late_fee_entry').cloneNode(true);

            // Reset input values in the new entry
            newEntry.querySelectorAll('input').forEach(input => {
                input.value = '';
            });

            lateFeeEntries.appendChild(newEntry);
        });
    </script>
</body>

</html>