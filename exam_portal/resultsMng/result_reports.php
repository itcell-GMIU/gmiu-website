<?php
// Include the checklogin.php file
include '../include/checklogin.php';
if (isset($_GET['exam_id'])) {
    $exid = $_GET['exam_id'];

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
        $ExamName = $short_name  .' ' . $level_name . ' ' . $program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year'];
    }
} else {
    $ExamName = "";
    $exid = "";
}

if (isset($_GET['exam_id'])  && isset($_GET['report_type'])) {

    $exam_id = mysqli_real_escape_string($con, $_GET['exam_id']);
    $exam_id = validate_data($exam_id);

    $report_type = mysqli_real_escape_string($con, $_GET['report_type']);
    $report_type = validate_data($report_type);
} else {
    $faculty_name = "";
    $exam_id = "";
}
$pending = "";
$completed = "";
if (isset($_GET['exam_id'])  && isset($_GET['report_type'])) {
    if ($report_type == 0) {
        $pending = "selected";
    }
    if ($report_type == 1) {
        $completed = "selected";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title> <?= $ExamName . ' (' . $exsbj . ')' ?></title>
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
                            <h1 class="m-0">Exam Result Reports</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Exam Result Reports</li>
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
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>Exam Result Reports</b></h5>
                                </center>
                            </span>
                        </div>

                        <form method="GET" action="">

                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-label-group">

                                                <select class="form-control browser-default custom-select" name="exam_id" required id="exam_id">
                                                    <option value="">---Select Exam---</option>
                                                    <?php
                                                    $status = 0;
                                                    $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.semester as semester, std.is_active as std_is_active, std.type as type , std.session as session , std.start_date as start_date, std.end_date as end_date, std.year as year,
                                                        faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_exam_form as std
                                                        LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                                        LEFT JOIN tbl_level level ON std.level_id = level.id 
                                                        LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = ? AND std.result_status = 1");
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
                                                        <option value="<?php echo $id; ?>" class="text-uppercase" <?php
                                                                                                                    if (isset($_GET['exam_id'])  && isset($_GET['report_type'])) {
                                                                                                                        if ($id == $exam_id) {
                                                                                                                            echo "selected";
                                                                                                                        }
                                                                                                                    }
                                                                                                                    ?>>
                                                            <?php echo $faculty_name . ' ' . $level_name . ' ' . $program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year']; ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control browser-default custom-select" name="report_type" id="report_type">
                                                <option value="">--- Student Report For ---</option>
                                                <option value="0" <?= $pending ?>>Failed</option>
                                                <option value="1" <?= $completed ?>>Passed</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <input type="submit" class="btn btn-primary btn-block" id="export" style="float:center"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- /.card-header -->
                        <div class="card-body pt-0">
                            <?php
                            if (isset($_GET['exam_id'])  && isset($_GET['report_type'])) {

                                $id_count = $con->query("SELECT id FROM tbl_exam_student WHERE exam_id = $exam_id and status = 3");
                                $std_count = mysqli_num_rows($id_count);

                                $id_count2 = $con->query("SELECT id FROM tbl_exam_student WHERE exam_id = $exam_id and is_pass = 1 and status = 3");
                                $std_success_count = mysqli_num_rows($id_count2);

                                $id_count3 = $con->query("SELECT id FROM tbl_exam_student WHERE exam_id = $exam_id and is_pass = 0 and status = 3");
                                $std_pending_count = mysqli_num_rows($id_count3);

                            ?>
                                <div class="row mt-2">
                                    <table class="table table-bordered">
                                        <tbody class="text-center">
                                            <tr>
                                                <td class="bg-light">Total Student </td>
                                                <th class="bg-light"><?= $std_count ?></th>
                                                <td class="bg-light">Passed</td>
                                                <th class="bg-success"><?= $std_success_count ?></th>
                                                <td class="bg-light">Failed</td>
                                                <th class="bg-warning"><?= $std_pending_count ?></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            }
                            ?>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr align="center">
                                            <th style="color:black;"><b>Id</b></th>
                                            <th style="color:black;"><b>Student Name</b></th>
                                            <th style="color:black;"><b>Enrollment no</b></th>
                                            <th style="color:black;"><b>Sem</b></th>
                                            <th style="color:black;"><b>SGPA</b></th>
                                            <th style="color:black;"><b>CGPA</b></th>
                                            <th style="color:black;"><b>Backlogs</b></th>
                                            <th style="color:black;"><b>Status</b></th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        <?php
                                        if (isset($_GET['exam_id'])) {
                                            if ($_GET['report_type'] != "") {
                                                $query = "SELECT id, enrollnment_no, status, is_pass, total_backlog , exam_sgpa, exam_cgpa FROM tbl_exam_student WHERE exam_id = ? and is_pass IN (?) AND status = 3";
                                                $stmt = $con->prepare($query);
                                                $stmt->bind_param("ii", $exam_id, $report_type);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                            } else {
                                                $query = "SELECT id, enrollnment_no, status, is_pass, total_backlog , exam_sgpa, exam_cgpa FROM tbl_exam_student WHERE exam_id = ? AND status = 3";
                                                $stmt = $con->prepare($query);
                                                $stmt->bind_param("i", $exam_id);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                            }

                                            $in = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                $enrollnment_no = $row['enrollnment_no'];
                                                $id = $row['id'];
                                                $exam_status = $row['is_pass'];
                                                $backlog = $row['total_backlog'];
                                                // $exam_cgpa = $row['exam_cgpa'];
                                                $exam_sgpa = $row['exam_sgpa'];

                                                // Sanitize $exam_status and $enrollnment_no if necessary

                                                if ($exam_status == 0) {
                                                    $echo_status = '<span class="badge badge-warning">Failed</span>';
                                                } elseif ($exam_status == 1) {
                                                    $echo_status = '<span class="badge badge-success">Passed</span>';
                                                    $btn_action = '<a href="exam_form_ac_rej.php?rej_id=' . $id . '" class="btn btn-danger"><i class="fa fa-times"></i></a>';
                                                }

                                                $query2 = "SELECT id, first_name, middle_name, last_name FROM tbl_students_2023 WHERE enrollnment_no = ?";
                                                $stmt2 = $con->prepare($query2);
                                                $stmt2->bind_param("s", $enrollnment_no);
                                                $stmt2->execute();
                                                $result2 = $stmt2->get_result();

                                                if ($row2 = $result2->fetch_assoc()) {
                                                    $std_name = $row2['first_name'] . ' ' . $row2['middle_name'] . ' ' . $row2['last_name'];
                                                }
                                                $query3 = "SELECT semester FROM tbl_exam_form WHERE id = ?";
                                                $stmt3 = $con->prepare($query3);
                                                $stmt3->bind_param("i", $exam_id);
                                                $stmt3->execute();
                                                $result3 = $stmt3->get_result();

                                                if ($row3 = $result3->fetch_assoc()) {
                                                    $sem = $row3['semester'];
                                                }

                                                $crud->readSingleRecordColumn("tbl_exam_backlogs", "exam_cgpa", ["enrollnment_no" => $enrollnment_no, "exam_id" => $exam_id, "is_active" => 1], $exam_cgpa);
                                        ?>

                                                <tr align="center">
                                                    <td scope="row"><?= $in ?></td>
                                                    <td scope="row"><?= $std_name ?></td>
                                                    <td scope="row"><?= $enrollnment_no ?></td>
                                                    <td scope="row"><?= $sem ?></td>
                                                    <td scope="row"><?= $exam_sgpa ?></td>
                                                    <td scope="row"><?= $exam_cgpa ?></td>
                                                    <td scope="row"><?= $backlog ?></td>
                                                    <td scope="row"><?= $echo_status ?></td>
                                                </tr>

                                        <?php

                                                $in++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th style="color:black;"><b>Id</b></th>
                                            <th style="color:black;"><b>Student Name</b></th>
                                            <th style="color:black;"><b>Enrollment no</b></th>
                                            <th style="color:black;"><b>Sem</b></th>
                                            <th style="color:black;"><b>SGPA</b></th>
                                            <th style="color:black;"><b>CGPA</b></th>
                                            <th style="color:black;"><b>Backlogs</b></th>
                                            <th style="color:black;"><b>Status</b></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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
</body>

</html>