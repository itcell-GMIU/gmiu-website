<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_GET['exam_id'])) {

    $exam_id = mysqli_real_escape_string($con, $_GET['exam_id']);
    $exam_id = validate_data($exam_id);

    function getExamDetailsById($con, $exam_id)
    {
        global $level_id;
        global $faculty_id;
        $status = 0;
        $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.semester as semester, std.is_active as std_is_active, std.type as type , std.session as session , std.start_date as start_date, std.end_date as end_date, std.year as year,
                                faculty.name as faculty_name, level.name as level_name , program.name as program_name FROM tbl_exam_form as std
                                LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                LEFT JOIN tbl_level level ON std.level_id = level.id 
                                LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = ? AND std.result_status = 1");
        $cmd->bind_param("i", $status);
        $cmd->execute();
        $result = $cmd->get_result();

        while ($row = $result->fetch_assoc()) {
            $level_id = $row['level_id'];
            $program_id = $row['program_id'];
            $faculty_id = $row['faculty_id'];
            $id = $row['id'];
            $semester = $row['semester'];

            $year = $row['year'];

            $faculty_name = !empty($row['faculty_name']) ? ucwords(strtolower($row['faculty_name'])) : "<b>N/A</b>";
            $level_name = !empty($row['level_name']) ? ucwords(strtolower($row['level_name'])) : "<b>N/A</b>";
            $program_name = !empty($row['program_name']) ? ucwords(strtolower($row['program_name'])) : "<b>N/A</b>";
            $sem = !empty($row['semester']) ? ucwords(strtolower($row['semester'])) : "<b>N/A</b>";
            $std_is_active = $row['std_is_active'];
            $exam_type = ucwords(strtolower($row['type']));
            $exam_session = ucwords(strtolower($row['session']));

            if ($row['type'] == "regular") {
                $exam_type = "REGULAR";
            } else {
                $exam_type = "REMEDIAL";
            }

            $cmd33 = "SELECT * FROM tbl_clg_name WHERE is_delete = '0' and is_active='1' and FIND_IN_SET('$faculty_id', faculty_id) > 0 AND FIND_IN_SET('$level_id', level_id) > 0";
            $stmt33 = $con->prepare($cmd33);
            $stmt33->execute();
            $result33 = $stmt33->get_result();

            if ($result33->num_rows > 0) {
                while ($row33 = $result33->fetch_assoc()) {
                    $clg_name =  $row33['clg_name'];
                }
            }

            if ($id == $exam_id) {
                $exam_name = ucwords(strtolower($program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year']));

                return array(
                    'id' => $id,
                    'level_id' => $level_id,
                    'program_id' => $program_id,
                    'semester' => $semester,
                    'faculty_name' => $faculty_name,
                    'level_name' => $level_name,
                    'program_name' => $program_name,
                    'sem' => $sem,
                    'std_is_active' => $std_is_active,
                    'exam_type' => $exam_type,
                    'exam_session' => $exam_session,
                    'year' => $year,
                    'exam_name' => $exam_name,
                    'college_name' => $clg_name
                );
            }
        }

        return array(); // Return an empty array if no matching exam_id is found
    }

    // Fetch exam details
    $exd = getExamDetailsById($con, $exam_id);
} else {
    $faculty_name = "";
    $exam_id = "";
}
$pending = "";
$completed = "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php
    if (isset($_GET['exam_id'])) {
        echo '<title>' . $exd['faculty_name'] . ' ' . $exd['level_name'] . ' ' . $exd['program_name'] . ' ' . 'SEMESTER -' . ' ' . $exd['semester'] . ' ' . $exd['exam_type'] . ' ' . $exd['exam_session'] . ' - ' . $exd['year'] . '</title>';
    } else {
        echo '<title>Exam Report</title>';
    } ?>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div>
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
                                        <div class="col-md-9">
                                            <div class="form-label-group">

                                                <select class="form-control browser-default custom-select select2option" name="exam_id" required id="exam_id">
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
                                                                                                                    if (isset($_GET['exam_id'])) {
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
                                        <!-- <div class="col-md-3">
                                            <select class="form-control browser-default custom-select" name="report_type" id="report_type">
                                                <option value="">--- Student Report For ---</option>
                                                <option value="0" <?= $pending ?>>Failed</option>
                                                <option value="1" <?= $completed ?>>Passed</option>
                                            </select>
                                        </div> -->

                                        <div class="col-md-3">
                                            <input type="submit" class="btn btn-primary btn-block" id="export" style="float:center" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>

                        <!-- /.card-header -->
                        <div class="card-body pt-0">
                            <?php
                            if (isset($_GET['exam_id'])) {

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
                                            <td>ORG_NAME</td>
                                            <td>ACADEMIC_COURSE_ID</td>
                                            <td>COURSE_NAME</td>
                                            <td>STREAM</td>
                                            <td>SESSION</td>
                                            <td>ADMISSION_YEAR</td>
                                            <td>REGN_NO</td>
                                            <td>RROLL</td>
                                            <td>CNAME</td>
                                            <td>AADHAAR_NAME</td>
                                            <td>GENDER</td>
                                            <td>DOB</td>
                                            <td>FNAME</td>
                                            <td>MNAME</td>
                                            <td>PHOTO</td>
                                            <td>MRKS_REC_STATUS</td>
                                            <td>RESULT</td>
                                            <td>YEAR</td>
                                            <td>MONTH</td>
                                            <td>PERCENT</td>
                                            <td>DOI</td>
                                            <td>CERT_NO</td>
                                            <td>SEM</td>
                                            <td>EXAM_TYPE</td>
                                            <td>TOT</td>
                                            <td>TOT_MIN</td>
                                            <td>TOT_MRKS</td>
                                            <td>TOT_TH_MAX</td>
                                            <td>TOT_TH_MIN</td>
                                            <td>TOT_TH_MRKS</td>
                                            <td>TOT_PR_MAX</td>
                                            <td>TOT_PR_MIN</td>
                                            <td>TOT_PR_MRKS</td>
                                            <td>TOT_CE_MAX</td>
                                            <td>TOT_CE_MIN</td>
                                            <td>TOT_CE_MRKS</td>
                                            <td>TOT_VV_MAX</td>
                                            <td>TOT_VV_MIN</td>
                                            <td>TOT_VV_MRKS</td>
                                            <td>TOT_CREDIT</td>
                                            <td>TOT_CREDIT_POINTS</td>
                                            <td>TOT_GRADE_POINTS</td>
                                            <td>PREV_TOT_MRKS</td>
                                            <td>GRAND_TOT_MAX</td>
                                            <td>GRAND_TOT_MIN</td>
                                            <td>GRAND_TOT_MRKS</td>
                                            <td>GRAND_TOT_CREDIT</td>
                                            <td>CGPA</td>
                                            <td>REMARKS</td>
                                            <td>SGPA</td>
                                            <td>ABC_ACCOUNT_ID</td>
                                            <td>TERM_TYPE</td>
                                            <td>TOT_GRADE</td>
                                            <td>DEPARTMENT</td>
                                            <td>SUB1NM</td>
                                            <td>SUB1</td>
                                            <td>SUB1_GRADE</td>
                                            <td>SUB1_GRADE_POINTS</td>
                                            <td>SUB1_CREDIT</td>
                                            <td>SUB1_CREDIT_POINTS</td>
                                            <td>SUB1_REMARKS</td>
                                            <td>SUB1_CREDIT_ELIGIBILITY</td>
                                            <td>SUB2NM</td>
                                            <td>SUB2</td>
                                            <td>SUB2_GRADE</td>
                                            <td>SUB2_GRADE_POINTS</td>
                                            <td>SUB2_CREDIT</td>
                                            <td>SUB2_CREDIT_POINTS</td>
                                            <td>SUB2_REMARKS</td>
                                            <td>SUB2_CREDIT_ELIGIBILITY</td>
                                            <td>SUB3NM</td>
                                            <td>SUB3</td>
                                            <td>SUB3_GRADE</td>
                                            <td>SUB3_GRADE_POINTS</td>
                                            <td>SUB3_CREDIT</td>
                                            <td>SUB3_CREDIT_POINTS</td>
                                            <td>SUB3_REMARKS</td>
                                            <td>SUB3_CREDIT_ELIGIBILITY</td>
                                            <td>SUB4NM</td>
                                            <td>SUB4</td>
                                            <td>SUB4_GRADE</td>
                                            <td>SUB4_GRADE_POINTS</td>
                                            <td>SUB4_CREDIT</td>
                                            <td>SUB4_CREDIT_POINTS</td>
                                            <td>SUB4_REMARKS</td>
                                            <td>SUB4_CREDIT_ELIGIBILITY</td>
                                            <td>SUB5NM</td>
                                            <td>SUB5</td>
                                            <td>SUB5_GRADE</td>
                                            <td>SUB5_GRADE_POINTS</td>
                                            <td>SUB5_CREDIT</td>
                                            <td>SUB5_CREDIT_POINTS</td>
                                            <td>SUB5_REMARKS</td>
                                            <td>SUB5_CREDIT_ELIGIBILITY</td>
                                            <td>SUB6NM</td>
                                            <td>SUB6</td>
                                            <td>SUB6_GRADE</td>
                                            <td>SUB6_GRADE_POINTS</td>
                                            <td>SUB6_CREDIT</td>
                                            <td>SUB6_CREDIT_POINTS</td>
                                            <td>SUB6_REMARKS</td>
                                            <td>SUB6_CREDIT_ELIGIBILITY</td>
                                            <td>SUB7NM</td>
                                            <td>SUB7</td>
                                            <td>SUB7_GRADE</td>
                                            <td>SUB7_GRADE_POINTS</td>
                                            <td>SUB7_CREDIT</td>
                                            <td>SUB7_CREDIT_POINTS</td>
                                            <td>SUB7_REMARKS</td>
                                            <td>SUB7_CREDIT_ELIGIBILITY</td>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        <?php
                                        if (isset($_GET['exam_id'])) {

                                            $query = "SELECT * FROM tbl_exam_student WHERE exam_id = ? AND status = 3";
                                            $stmt = $con->prepare($query);
                                            $stmt->bind_param("i", $exam_id);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            $in = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                $enrollnment_no = $row['enrollnment_no'];
                                                $seat_no = $row['seat_no'];
                                                $id = $row['id'];
                                                $exam_status = $row['is_pass'];
                                                $backlog = $row['total_backlog'];
                                                $exam_cgpa = sprintf("%.2f", $row['exam_cgpa']);
                                                $exam_sgpa = sprintf("%.2f", $row['exam_sgpa']);
                                                $total_credit = $row['total_credit'];
                                                $total_credit_point = $row['total_credit_point'];

                                                // Sanitize $exam_status and $enrollnment_no if necessary

                                                if ($exam_status == 0) {
                                                    $echo_status = 'Fail';
                                                } elseif ($exam_status == 1) {
                                                    $echo_status = 'Pass';
                                                    $btn_action = '<a href="exam_form_ac_rej.php?rej_id=' . $id . '" class="btn btn-danger"><i class="fa fa-times"></i></a>';
                                                }

                                                $query3 = "SELECT semester FROM tbl_exam_form WHERE id = ?";
                                                $stmt3 = $con->prepare($query3);
                                                $stmt3->bind_param("i", $exam_id);
                                                $stmt3->execute();
                                                $result3 = $stmt3->get_result();

                                                if ($row3 = $result3->fetch_assoc()) {
                                                    $sem = $row3['semester'];
                                                }

                                                $cmdSUB = $con->prepare("SELECT * FROM tbl_final_exam_results WHERE enrollnment_no = ? AND seat_no = ? AND exam_id = ? AND is_active = 1");
                                                $cmdSUB->bind_param("sss", $enrollnment_no, $seat_no, $exam_id);
                                                $cmdSUB->execute();
                                                $resultexamSUB = $cmdSUB->get_result();

                                                $exam_results = array(); // Initialize array to store exam results

                                                while ($exmSUB = $resultexamSUB->fetch_assoc()) {

                                                    $crud->readSingleRecordColumn("tbl_short_name", "short_name", ["faculty_id" => $faculty_id, "level_id" => $level_id], $course_name_short);

                                                    $cmdSUBFetch = $con->prepare("SELECT subject_name, credit FROM tbl_subject_master WHERE subject_code = ?");
                                                    $cmdSUBFetch->bind_param("s", $exmSUB['subject_code']);
                                                    $cmdSUBFetch->execute();
                                                    $resultexamSUBFetch = $cmdSUBFetch->get_result();
                                                    $exmSUBFetch = $resultexamSUBFetch->fetch_assoc();
                                                    $subject_name = $exmSUBFetch['subject_name'];
                                                    $credit = $exmSUBFetch['credit'];

                                                    $query44 = "SELECT grade_point FROM tbl_grade_settings WHERE FIND_IN_SET(?, faculty_id) AND FIND_IN_SET(?, level_id) AND letter_grade = ?";
                                                    $stmt44 = $con->prepare($query44);
                                                    $stmt44->bind_param("sss", $faculty_id, $level_id, $exmSUB['gradeFINAL']);
                                                    $stmt44->execute();
                                                    $result44 = $stmt44->get_result();

                                                    if ($row44 = $result44->fetch_assoc()) {
                                                        $subject_grade = $row44['grade_point'];
                                                    }

                                                    // Add each row of data to the exam_results array
                                                    $exam_results[] = array(
                                                        'subject_code' => strtoupper($exmSUB['subject_code']),
                                                        'subject_name' => strtoupper($subject_name),
                                                        'credit' => strtoupper($credit),
                                                        'subject_grade' => $subject_grade,
                                                        'is_absent' => strtoupper(($exmSUB['is_absent'] == 1) ? "Y" : "-"),
                                                        'gradeTHEORY' => strtoupper($exmSUB['gradeTHEORY'] ?? '-'),
                                                        'gradePRACTICAL' => strtoupper($exmSUB['gradePRACTICAL'] ?? '-'),
                                                        'gradeMID' => strtoupper($exmSUB['gradeMID'] ?? '-'),
                                                        'gradeALA' => strtoupper($exmSUB['gradeALA'] ?? '-'),
                                                        'gradeVIVA' => strtoupper($exmSUB['gradeVIVA'] ?? '-'),
                                                        'gradeFINAL' => strtoupper($exmSUB['gradeFINAL'] ?? '-'),
                                                        'credit_point_total' => strtoupper($exmSUB['credit_point_total'])
                                                    );
                                                }
                                                $crud->readSingleRecordColumn("tbl_short_name", "short_name", ["faculty_id" => $faculty_id, "level_id" => $level_id], $course_name_short);
                                                // student data
                                                $std_condition = array("enrollnment_no" =>  $enrollnment_no, "is_active" => 1);
                                                $std_data = $crud->readRecordsWithConditions("tbl_students_2023", $std_condition);

                                                if (is_array($std_data)) {
                                                    foreach ($std_data as $std) {
                                                        $std_name = $std['first_name'] . ' ' . $std['middle_name'] . ' ' . $std['last_name'];

                                                        $cmdMonth = $con->prepare("SELECT date FROM tbl_exam_timetable WHERE exam_id = ?");
                                                        $cmdMonth->bind_param("i", $exam_id);
                                                        $cmdMonth->execute();
                                                        $resultexamMonth = $cmdMonth->get_result();
                                                        $exmSUBMonth = $resultexamMonth->fetch_assoc();
                                                        $MonthExam = $exmSUBMonth['date'];
                                                        $exam_month = date("F", strtotime($MonthExam));
                                                        $exam_year = date("Y", strtotime($MonthExam));
                                                        $exd_sem = $exd['semester'];


                                                        $semester_data = [];

                                                        $exd_sem = $exd['semester'];

                                                        // Query to fetch latest exam data for each semester
                                                        $query_sem_data = "SELECT b.*
                                                            FROM tbl_exam_backlogs b
                                                            JOIN tbl_exam_form f ON b.exam_id = f.id
                                                            WHERE b.enrollnment_no = '$enrollnment_no'
                                                            AND (
                                                                -- For the current semester
                                                                (b.semester = $exd_sem AND (
                                                                    -- Show data for the specified exam_id if it's regular
                                                                    (b.exam_id = $exam_id AND f.type = 'regular')
                                                                    -- Show data for the specified exam_id if it's remedial
                                                                    OR (b.exam_id = $exam_id AND f.type = 'remedial')
                                                                    -- Otherwise, show the latest exam data based on type
                                                                    OR (b.exam_id = (
                                                                        SELECT b1.exam_id
                                                                        FROM tbl_exam_backlogs b1
                                                                        JOIN tbl_exam_form f1 ON b1.exam_id = f1.id
                                                                        WHERE b1.enrollnment_no = '$enrollnment_no'
                                                                        AND b1.semester = $exd_sem
                                                                        ORDER BY b1.exam_id DESC
                                                                        LIMIT 1
                                                                    ))
                                                                ))
                                                                OR
                                                                -- For previous semesters, get the latest exam for each semester
                                                                (b.semester < $exd_sem AND b.exam_id = (
                                                                    SELECT MAX(b1.exam_id)
                                                                    FROM tbl_exam_backlogs b1
                                                                    JOIN tbl_exam_form f1 ON b1.exam_id = f1.id
                                                                    WHERE b1.enrollnment_no = '$enrollnment_no'
                                                                    AND b1.semester = b.semester
                                                                ))
                                                            )
                                                            ORDER BY b.semester ASC, b.exam_id DESC
                                                            ";

                                                        // Execute the query
                                                        $result_sem_data = mysqli_query($con, $query_sem_data);

                                                        if ($result_sem_data && mysqli_num_rows($result_sem_data) > 0) {
                                                            while ($back = mysqli_fetch_assoc($result_sem_data)) {
                                                                $semester = $back['semester'];
                                                                $semester_data[$semester] = [
                                                                    'semester' => $back['semester'],
                                                                    'cgpa' => $back['exam_cgpa'],
                                                                    'sgpa' => $back['exam_sgpa'],
                                                                    'backlog' => $back['backlog_count'],
                                                                    'total_credit' => $back['total_credit'],
                                                                    'total_credit_point' => $back['total_credit_point'],
                                                                ];
                                                            }
                                                        }
                                        ?>

                                                        <tr align="center">
                                                            <td style="color:black;"><?= $exd['college_name'] ?></td>
                                                            <td></td>
                                                            <td><?= $course_name_short ?></td>
                                                            <td style="color:black;"><?= $exd['program_name'] ?></td>
                                                            <td style="color:black;"><?= $exd['year'] ?></td>
                                                            <td><?= $std['admission_year'] ?></td>
                                                            <td><?= $enrollnment_no ?></td>
                                                            <td></td>
                                                            <td><?= $std_name ?></td>
                                                            <td></td>
                                                            <td><?= (strtoupper($std['gender']) == "MALE") ? "M" : "F" ?></td>
                                                            <td><?= date("d/m/Y", strtotime($std['dob'])) ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>O</td>
                                                            <td><?= $echo_status ?></td>
                                                            <td><?= $exam_year ?></td>
                                                            <td><?= $exam_month ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><?= $exd_sem ?></td>
                                                            <td><?= $exd['exam_type'] ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td scope="row">
                                                                <?php
                                                                if ($exam_type == 'REMEDIAL') {
                                                                    echo  $semester_data[$exd_sem]['total_credit'];
                                                                } else {
                                                                    echo $total_credit;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td scope="row">
                                                                <?php
                                                                if ($exam_type == 'REMEDIAL') {
                                                                    echo  $semester_data[$exd_sem]['total_credit_point'];
                                                                } else {
                                                                    echo $total_credit_point;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><?= number_format((float)$semester_data[$exd_sem]['cgpa'], 3, '.', '') ?></td>
                                                            <td></td>
                                                            <td><?= number_format((float)$semester_data[$exd_sem]['sgpa'], 3, '.', '') ?></td>
                                                            <td>ABC_ACCOUNT_ID</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <?php
                                                            $counter = 0;
                                                            // Iterate through exam results
                                                            foreach ($exam_results as $key => $value) {
                                                                // Echo the subject code in a table cell with black color
                                                                echo '<td style="color:black;">' . $value['subject_name'] . '</td>';
                                                                echo '<td style="color:black;">' . $value['subject_code'] . '</td>';
                                                                echo '<td style="color:black;">' . $value['gradeFINAL'] . '</td>';
                                                                echo '<td style="color:black;">' . $value['subject_grade'] . '</td>';
                                                                echo '<td style="color:black;">' . $value['credit'] . '</td>';
                                                                echo '<td style="color:black;">' . $value['credit_point_total'] . '</td>';
                                                                echo '<td style="color:black;"></td>';
                                                                echo '<td style="color:black;"></td>';

                                                                // Increment the counter
                                                                $counter++;

                                                                // Check if we have echoed 7 values
                                                                if ($counter >= 7) {
                                                                    break; // Exit the loop if we have echoed 7 values
                                                                }
                                                            }
                                                            // Echo additional empty table cells if needed to reach 7
                                                            for ($i = $counter; $i < 7; $i++) {
                                                                echo '<td style="color:black;"></td>';
                                                                echo '<td style="color:black;"></td>';
                                                                echo '<td style="color:black;"></td>';
                                                                echo '<td style="color:black;"></td>';
                                                                echo '<td style="color:black;"></td>';
                                                                echo '<td style="color:black;"></td>';
                                                                echo '<td style="color:black;"></td>';
                                                                echo '<td style="color:black;"></td>';
                                                            }
                                                            ?>
                                                        </tr>

                                        <?php
                                                    }
                                                }
                                                $in++;
                                            }
                                        }
                                        ?>
                                    </tbody>
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
    <script>
        $(document).ready(function() {
            $('.select2option').select2();
        });
    </script>
</body>

</html>