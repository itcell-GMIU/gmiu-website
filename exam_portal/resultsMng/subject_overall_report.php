<?php
// Include the checklogin.php file
include '../include/checklogin.php';

function convertMarksToPercentage($originalMarks, $targetScale)
{
    // Convert to percentage
    $percentage = ($originalMarks / $targetScale) * 100;
    return $percentage;
}

if (isset($_GET['exid'])) {

    $exam_id = $_GET['exid'];
    $exid = $_GET['exid'];

    $status = 0;
    $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.semester as semester, std.is_active as std_is_active, std.type as type , std.session as session , std.start_date as start_date, std.end_date as end_date, std.year as year,
                                                        faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_exam_form as std
                                                        LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                                        LEFT JOIN tbl_level level ON std.level_id = level.id 
                                                        LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = ? AND std.id = ?");
    $cmd->bind_param("ii", $status, $exid);
    $cmd->execute();
    $result = $cmd->get_result();
    while ($row = $result->fetch_assoc()) {
        $level_id = $row['level_id'];
        $faculty_id = $row['faculty_id'];
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
        $cmd12 = $con->prepare("SELECT short_name FROM tbl_short_name WHERE level_id = ? AND faculty_id = ? AND is_delete = ?");
        $cmd12->bind_param("iii", $level_id, $faculty_id, $status);
        $cmd12->execute();
        $result12 = $cmd12->get_result();
        while ($row12 = $result12->fetch_assoc()) {
            $short_name = $row12['short_name'];
        }
        $ExamName = $short_name  . ' ' . $level_name . ' ' . $program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year'];
    }
} else {
    $ExamName = "";
    $exid = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <title> <?= $ExamName . ' (' . $exsbj . ')' ?></title>
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
    <!-- wrapper -->
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
                            <h1 class="m-0">Result Overall Reports</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Result Overall Reports</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!--   Program list code  -->
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="get">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-sm-10">
                                            <label for="">Exam : </label>
                                            <select class="sl2-1 form-control browser-default custom-select select2option" name="exid" required id="exam_id">
                                                <option value="">---Select Exam---</option>
                                                <?php
                                                $status = 0;
                                                $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.semester as semester, std.is_active as std_is_active, std.type as type , std.session as session , std.start_date as start_date, std.end_date as end_date, std.year as year,
                                                        faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_exam_form as std
                                                        LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                                        LEFT JOIN tbl_level level ON std.level_id = level.id 
                                                        LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = ? AND std.is_active = 1 AND std.result_status = 1");
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

                                                    $exam_name = $faculty_name . ' ' . $level_name . ' ' . $program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year'];
                                                ?>
                                                    <option value="<?php echo $id; ?>" class="text-uppercase">
                                                        <?php echo $faculty_name . ' ' . $level_name . ' ' . $program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year']; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">&nbsp;</label>
                                            <input type="submit" class="btn btn-primary btn-block" id="export" style="float:center" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <!-- + ADD Button End -->
                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                <thead>
                                    <tr align="center">
                                        <th style="color:black;"><b>Subject Code</b></th>
                                        <th style="color:black;"><b>Subject Name</b></th>
                                        <th style="color:black;"><b>Total Student</b></th>
                                        <th style="color:black;"><b>Pass</b></th>
                                        <th style="color:black;"><b>Fail</b></th>
                                        <th style="color:black;"><b>Result Percentage</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_GET['exid'])) {
                                        $exm_id = $_GET['exid'];
                                        $query = "SELECT subject_code FROM tbl_final_exam_results WHERE is_active = 1 AND exam_id = $exam_id GROUP BY subject_code";
                                        // Execute the query
                                        $result2 = $con->query($query);
                                        while ($row22 = $result2->fetch_assoc()) {
                                            $subject_code = $row22['subject_code'];
                                            // total students 
                                            $collation = 'utf8mb4_general_ci';
                                            $id_count_total = $con->query("SELECT tf.id FROM tbl_final_exam_results AS tf LEFT JOIN tbl_exam_student AS tes ON tes.enrollnment_no COLLATE $collation = tf.enrollnment_no COLLATE $collation AND tes.exam_id = tf.exam_id WHERE tf.exam_id = '$exam_id' AND tf.subject_code COLLATE $collation = '$subject_code' COLLATE $collation AND tf.is_active = 1    AND tes.status = 3");
                                            $std_count_total = mysqli_num_rows($id_count_total);

                                            // total students pass
                                            $id_count_pass = $con->query("SELECT tf.id FROM tbl_final_exam_results AS tf LEFT JOIN tbl_exam_student AS tes ON tes.enrollnment_no COLLATE $collation = tf.enrollnment_no COLLATE $collation AND tes.exam_id = tf.exam_id WHERE tf.exam_id = '$exam_id' AND tf.subject_code COLLATE $collation = '$subject_code' COLLATE $collation AND tf.is_active = 1    AND tes.status = 3 AND tf.status = 1");
                                            $std_count_pass = mysqli_num_rows($id_count_pass);

                                            // total students pass
                                            $id_count_fail = $con->query("SELECT tf.id FROM tbl_final_exam_results AS tf LEFT JOIN tbl_exam_student AS tes ON tes.enrollnment_no COLLATE $collation = tf.enrollnment_no COLLATE $collation AND tes.exam_id = tf.exam_id WHERE tf.exam_id = '$exam_id' AND tf.subject_code COLLATE $collation = '$subject_code' COLLATE $collation AND tf.is_active = 1    AND tes.status = 3 AND tf.status = 0");
                                            $std_count_fail = mysqli_num_rows($id_count_fail);

                                            // result percentage
                                            $percentage_pass = convertMarksToPercentage($std_count_pass, $std_count_total);
                                            $percentage_pass =  number_format($percentage_pass, 3) . '%';

                                            // subject name
                                            $crud->readSingleRecordColumn("tbl_subject_master", "subject_name", ["subject_code" => $subject_code], $subject_name);
                                    ?>
                                            <tr>

                                                <td><?= $subject_code ?></td>
                                                <td><?= $subject_name ?></td>
                                                <td><?= $std_count_total ?></td>
                                                <td style="background-color: #0ef30e52;" class="font-weight-bold"><?= $std_count_pass ?></td>
                                                <td style="background-color: #e9000057;" class="font-weight-bold"><?= $std_count_fail ?></td>
                                                <td><?= $percentage_pass ?></td>

                                            </tr>
                                    <?php }
                                    } ?>

                                </tbody>
                                <tfoot>
                                    <tr align="center">
                                        <th style="color:black;"><b>Subject Code</b></th>
                                        <th style="color:black;"><b>Subject Name</b></th>
                                        <th style="color:black;"><b>Total Student</b></th>
                                        <th style="color:black;"><b>Pass</b></th>
                                        <th style="color:black;"><b>Fail</b></th>
                                        <th style="color:black;"><b>Result Percentage</b></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div><!-- /.container-fluid -->
                </div>
            </section>
            <!-- /.content -->
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
    <!-- footer -->
    <?php include '../include/importjs.php'; ?>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for elements with class starting with "sl2-"
            $('[class^="sl2-"]').each(function() {
                $(this).select2();
            });
        });
    </script>
</body>

</html>