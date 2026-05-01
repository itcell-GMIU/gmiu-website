<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_GET['exam_id'])) {

    $exam_id = mysqli_real_escape_string($con, $_GET['exam_id']);
    $exam_id = validate_data($exam_id);

    function getExamDetailsById($con, $exam_id)
    {
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
                                                        $exm_type = $row['type'];
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
                                            <!-- <th style="color:black;"><b>Id</b></th> -->
                                            <th style="color:black;"><b>Academic Year</b></th>
                                            <th style="color:black;"><b>Year of Examination</b></th>
                                            <th style="color:black;"><b>Semester</b></th>
                                            <th style="color:black;"><b>Statement No.</b></th>
                                            <th style="color:black;"><b>Student Name</b></th>
                                            <th style="color:black;"><b>Program Name</b></th>
                                            <th style="color:black;"><b>Institute Name</b></th>
                                            <!-- <th style="color:black;"><b>Branch Name</b></th> -->
                                            <th style="color:black;"><b>Enrollment no</b></th>
                                            <th style="color:black;"><b>ABC ID</b></th>
                                            <th style="color:black;"><b>Seat no</b></th>

                                            <?php
                                            $semi = 1;
                                            while ($semi < 11) { ?>
                                                <th style="color:black;"><b>SUB <?= $semi ?></b></th>
                                                <th style="color:black;"><b>SUB NAME <?= $semi ?></b></th>
                                                <th style="color:black;"><b>SUB CRED <?= $semi ?></b></th>
                                                <th style="color:black;"><b>SUB <?= $semi ?> SEE ABSENT</b></th>
                                                <th style="color:black;"><b>SUB <?= $semi ?> T GRADE</b></th>
                                                <th style="color:black;"><b>SUB <?= $semi ?> P GRADE</b></th>
                                                <th style="color:black;"><b>SUB <?= $semi ?> M GRADE</b></th>
                                                <th style="color:black;"><b>SUB <?= $semi ?> I GRADE</b></th>
                                                <th style="color:black;"><b>SUB <?= $semi ?> V GRADE</b></th>
                                                <th style="color:black;"><b>SUB <?= $semi ?> Course GRADE</b></th>
                                                <th style="color:black;"><b>SUB <?= $semi ?> Credit Point</b></th>
                                            <?php $semi++;
                                            } ?>


                                            <th style="color:black;"><b>SEM 1 BACKLOG</b></th>
                                            <th style="color:black;"><b>SEM 2 BACKLOG</b></th>
                                            <th style="color:black;"><b>SEM 3 BACKLOG</b></th>
                                            <th style="color:black;"><b>SEM 4 BACKLOG</b></th>
                                            <th style="color:black;"><b>SEM 5 BACKLOG</b></th>
                                            <th style="color:black;"><b>SEM 6 BACKLOG</b></th>
                                            <th style="color:black;"><b>SEM 7 BACKLOG</b></th>
                                            <th style="color:black;"><b>SEM 8 BACKLOG</b></th>
                                            <th style="color:black;"><b>Credits</b></th>
                                            <th style="color:black;"><b>Credit Point</b></th>
                                            <th style="color:black;"><b>SGPA</b></th>
                                            <th style="color:black;"><b>Total Credits</b></th>
                                            <th style="color:black;"><b>Total Credit Point</b></th>
                                            <th style="color:black;"><b>CGPA</b></th>
                                            <th style="color:black;"><b>Attempt</b></th>
                                            <th style="color:black;"><b>Status</b></th>
                                            <th style="color:black;"><b>Result declared on</b></th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        <?php
                                        if (isset($_GET['exam_id'])) {


                                            $crud->readSingleRecordColumn("tbl_exam_form", "type", ["id" => $exam_id, "is_active" => 1], $extype);

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

                                                $cmdSUB = $con->prepare("SELECT * FROM tbl_final_exam_results WHERE enrollnment_no = ? AND seat_no = ? AND exam_id = ? AND is_active = 1");
                                                $cmdSUB->bind_param("sss", $enrollnment_no, $seat_no, $exam_id);
                                                $cmdSUB->execute();
                                                $resultexamSUB = $cmdSUB->get_result();

                                                $exam_results = array(); // Initialize array to store exam results

                                                while ($exmSUB = $resultexamSUB->fetch_assoc()) {
                                                    $cmdSUBFetch = $con->prepare("SELECT subject_name, credit FROM tbl_subject_master WHERE subject_code = ?");
                                                    $cmdSUBFetch->bind_param("s", $exmSUB['subject_code']);
                                                    $cmdSUBFetch->execute();
                                                    $resultexamSUBFetch = $cmdSUBFetch->get_result();
                                                    $exmSUBFetch = $resultexamSUBFetch->fetch_assoc();
                                                    $subject_name = $exmSUBFetch['subject_name'];
                                                    $credit = $exmSUBFetch['credit'];

                                                    // Add each row of data to the exam_results array
                                                    $exam_results[] = array(
                                                        'subject_code' => strtoupper($exmSUB['subject_code']),
                                                        'subject_name' => strtoupper($subject_name),
                                                        'credit' => strtoupper($credit),
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
                                                    <!-- <td scope="row"><?= $in ?></td> -->
                                                    <td style="color:black;"><?= $exd['year'] ?></td>
                                                    <td style="color:black;"><?= $exd['year'] ?></td>
                                                    <td style="color:black;"><?= $exd['semester'] ?></td>
                                                    <td style="color:black;"></td>
                                                    <td scope="row"><?= $std_name ?></td>
                                                    <td style="color:black;"><?= $exd['program_name'] ?></td>
                                                    <td style="color:black;"><?= $exd['college_name'] ?></td>
                                                    <!-- <td style="color:black;"><?= $exd['faculty_name'] ?></td> -->
                                                    <td scope="row"><?= $enrollnment_no ?></td>
                                                    <td scope="row"></td>
                                                    <td scope="row"><?= $seat_no ?></td>
                                                    <?php
                                                    $counter = 0;
                                                    // Iterate through exam results
                                                    foreach ($exam_results as $key => $value) {
                                                        // Echo the subject code in a table cell with black color
                                                        echo '<td style="color:black;">' . $value['subject_code'] . '</td>';
                                                        echo '<td style="color:black;">' . $value['subject_name'] . '</td>';
                                                        echo '<td style="color:black;">' . $value['credit'] . '</td>';
                                                        echo '<td style="color:black;">' . $value['is_absent'] . '</td>';
                                                        echo '<td style="color:black;">' . $value['gradeTHEORY'] . '</td>';
                                                        echo '<td style="color:black;">' . $value['gradePRACTICAL'] . '</td>';
                                                        echo '<td style="color:black;">' . $value['gradeMID'] . '</td>';
                                                        echo '<td style="color:black;">' . $value['gradeALA'] . '</td>';
                                                        echo '<td style="color:black;">' . $value['gradeVIVA'] . '</td>';
                                                        echo '<td style="color:black;">' . $value['gradeFINAL'] . '</td>';
                                                        echo '<td style="color:black;">' . $value['credit_point_total'] . '</td>';

                                                        // Increment the counter
                                                        $counter++;

                                                        // Check if we have echoed 7 values
                                                        if ($counter >= 10) {
                                                            break; // Exit the loop if we have echoed 7 values
                                                        }
                                                    }
                                                    // Echo additional empty table cells if needed to reach 7
                                                    for ($i = $counter; $i < 10; $i++) {
                                                        echo '<td style="color:black;"></td>';
                                                        echo '<td style="color:black;"></td>';
                                                        echo '<td style="color:black;"></td>';
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

                                                    <?php
                                                    for ($i = 1; $i <= 8; $i++) {
                                                        if (isset($semester_data[$i])) {
                                                            echo '<td>' . $semester_data[$i]['backlog'] . '</td>';
                                                        } else {
                                                            echo '<td></td>';
                                                        }
                                                    }

                                                    ?>


                                                    <td scope="row">
                                                        <?php
                                                        if ($extype == 'remedial') {
                                                            echo  $semester_data[$exd_sem]['total_credit'];
                                                        } else {
                                                            echo $total_credit;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td scope="row">
                                                        <?php
                                                        if ($extype == 'remedial') {
                                                            echo  $semester_data[$exd_sem]['total_credit_point'];
                                                        } else {
                                                            echo $total_credit_point;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= number_format((float)$semester_data[$exd_sem]['sgpa'], 3, '.', '') ?></td>
                                                    <td scope="row">
                                                        <?php
                                                            echo  $semester_data[$exd_sem]['total_credit'];
                                                        ?>
                                                    </td>
                                                    <td scope="row">
                                                        <?php
                                                            echo  $semester_data[$exd_sem]['total_credit_point'];
                                                        ?>
                                                    </td>
                                                    <td><?= number_format((float)$semester_data[$exd_sem]['cgpa'], 3, '.', '') ?></td>
                                                    <td scope="row">First</td>
                                                    <td scope="row"><?= $echo_status ?></td>
                                                    <td scope="row"></td>
                                                </tr>

                                        <?php

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