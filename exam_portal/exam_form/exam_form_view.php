<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_POST['new_std'])) {
    $cmd11 = $con->prepare("SELECT `id`, `faculty_id`, `level_id`, `program_id`, `semester`, `year`, `batch`, `type` FROM `tbl_exam_form` WHERE `is_delete` = 0");
    $cmd11->execute();
    $result11 = $cmd11->get_result();
    while ($row11 = $result11->fetch_assoc()) {
        $sem = $row11['semester'];
        $new_id = $row11['id'];
        $faculty_id = $row11['faculty_id'];
        $level_id = $row11['level_id'];
        $program_id = $row11['program_id'];
        $type = $row11['type'];

        // if($new_id == 191){
        //     echo $new_id;
        //     echo '<br>'.$type;
        //     exit;
        // }
        if ($type == 'remedial') {

            $stmtEXID = $con->prepare("SELECT id FROM tbl_exam_form WHERE faculty_id = ? AND level_id = ? AND program_id = ? AND semester = ? AND result_status = 1 AND is_active = 1");
            $stmtEXID->bind_param("iiii", $faculty_id, $level_id, $program_id, $sem);
            $stmtEXID->execute();
            $resultEXID = $stmtEXID->get_result();

            while ($rowEXID = $resultEXID->fetch_assoc()) {

                $remedial_exID = $rowEXID['id'];

                
                // if($remedial_exID == 10 && $new_id == 191){
                //     echo $remedial_exID;
                //     exit;
                // }

                $stmt = $con->prepare("INSERT INTO tbl_exam_student (enrollnment_no, exam_id)
                SELECT enrollnment_no, ? 
                FROM tbl_exam_student
                WHERE exam_id = ? AND is_pass = 0 AND enrollnment_no NOT IN (SELECT enrollnment_no FROM tbl_exam_student WHERE exam_id = ?)");

                $stmt->bind_param("iii", $new_id, $remedial_exID, $new_id);
                $result1 = $stmt->execute();

            }
        } else {

            $stmt = $con->prepare("INSERT INTO tbl_exam_student (enrollnment_no, exam_id)
            SELECT enrollnment_no, ? 
            FROM tbl_students_2023
            WHERE `semester` = ? 
            AND `faculty_id` = ? 
            AND `level_id` = ? 
            AND `program_id` = ? 
            AND enrollnment_no NOT IN (SELECT enrollnment_no FROM tbl_exam_student WHERE exam_id = ?)");

            $stmt->bind_param("iiiiii", $new_id, $sem, $faculty_id, $level_id, $program_id, $new_id);
            $result1 = $stmt->execute();
        }
    }

    if ($result1) {
        $_SESSION['status'] = "New Student Inserted Successfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='exam_form_view.php'},1000)</script>";
    } else {
        $_SESSION['status'] = "New Student Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='exam_form_view.php'},1000)</script>";
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
                            <h1 class="m-0">View Exam Forms</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Exam Forms</li>
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
                           <div class="row">
                                <div class="col-sm-10 text-center">
                                    <h5><b><i class="fas fa-book-reader"></i>View Exam Forms</b></h5>
                                </div>
                                <div class="col-sm-2 text-center">
                                    <form action="" method="post">
                                        <button type="submit" name="new_std" class="btn btn-info"> New Student</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="exam_form_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr align="center">
                                        <th style="color:black;"><b>Id</b></th>
                                        <th style="color:black;"><b>Exam Id</b></th>
                                        <th style="color:black;"><b>Exam Name</b></th>
                                        <th style="color:black;"><b>Sem</b></th>
                                        <th style="color:black;"><b>Date</b></th>
                                        <th style="color:black;"><b>Subject Fees</b></th>
                                        <th style="color:black; width:200px;"><b>Late Fee</b></th>
                                        <th style="color:black;"><b>Total Student</b></th>
                                        <th style="color:black;"><b>Form Filled Student</b></th>
                                        <th style="color:black;"><b>Status</b></th>
                                        <th style="color:black;"><b>Action</b></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $status = 0;
                                    $cmd = $con->prepare("SELECT
                                            std.id as id, 
                                            std.faculty_id as faculty_id, 
                                            std.level_id as level_id, 
                                            std.program_id as program_id, 
                                            std.semester as semester, 
                                            std.is_active as std_is_active, 
                                            std.type as type, 
                                            std.session as session, 
                                            std.start_date as start_date, 
                                            std.end_date as end_date, 
                                            std.year as year,
                                            std.subject_fee as sub_fee,
                                            std.late_fee as late_fee,
                                            faculty.name as faculty_name,
                                            level.name as level_name,
                                            program.name as program_name,
                                            clg.clg_name as college_name
                                        FROM tbl_exam_form as std
                                        LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id
                                        LEFT JOIN tbl_level level ON std.level_id = level.id
                                        LEFT JOIN tbl_program program ON std.program_id = program.id
                                        LEFT JOIN tbl_clg_name clg ON std.faculty_id = clg.faculty_id AND std.level_id = clg.level_id
                                        WHERE std.is_delete = ?");
                                    $cmd->bind_param("i", $status);
                                    $cmd->execute();
                                    $result = $cmd->get_result();
                                    $in = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        $level_id = $row['level_id'];
                                        $program_id = $row['program_id'];
                                        $id = $row['id'];
                                        $semester = $row['semester'];
                                        $sub_fee = $row['sub_fee'];
                                        $clg_name = $row['college_name'];

                                        $start_date = $row['start_date'];
                                        $stdate = new DateTime($start_date);
                                        $start_date = $stdate->format("d-m-Y");

                                        $end_date = $row['end_date'];
                                        $eddate = new DateTime($end_date);
                                        $end_date = $eddate->format("d-m-Y");

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
                                        <tr align="center">
                                            <td scope="row">
                                                <?php echo $in; ?>
                                            </td>
                                            <td scope="row">
                                                <?= $id ?>
                                            </td>
                                            <td scope="row" class="text-uppercase" style="width:250px;">
                                                <?php echo $clg_name . ' ' . $level_name . ' ' . $program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year']; ?>
                                            </td>

                                            <td scope="row">
                                                <?php echo $sem; ?>
                                            </td>

                                            <td scope="row" style="width:150px;">
                                                <?php echo $start_date . ' To ' . $end_date; ?>
                                            </td>

                                            <td scope="row">
                                                <?php echo $sub_fee; ?>
                                            </td>

                                            <td scope="row">
                                                <?php
                                                $jsonData = $row['late_fee'];

                                                // Decode the JSON data into a PHP array
                                                $dataArray = json_decode($jsonData, true);

                                                // Check if the decoding was successful
                                                if ($dataArray !== null) {
                                                    // Iterate through the entries
                                                    foreach ($dataArray as $entry) {
                                                        $startingDate = $entry['starting_date'];
                                                        $sdate = new DateTime($startingDate);
                                                        $startingDate = $sdate->format("d-m-Y");

                                                        $endingDate = $entry['ending_date'];
                                                        $edate = new DateTime($endingDate);
                                                        $endingDate = $edate->format("d-m-Y");

                                                        $lateFeeAmount = $entry['late_fee_amount'];


                                                        // Use these variables for each entry
                                                        echo "Date: $startingDate To <br> $endingDate";
                                                        echo "<br> Late Fee Amount: $lateFeeAmount<br>";
                                                        echo "<br>"; // Add a line break between entriess
                                                    }
                                                } else {
                                                    echo "No data.";
                                                }

                                                ?>
                                            </td>

                                            <td scope="row">
                                                <?php
                                                $id_count = $con->query("SELECT id FROM tbl_exam_student WHERE exam_id = $id");
                                                $std_count = mysqli_num_rows($id_count);
                                                echo $std_count;
                                                ?>
                                            </td>

                                            <td scope="row">
                                                <?php
                                                $id_count = $con->query("SELECT id FROM tbl_exam_student WHERE exam_id = $id AND  status = 3");
                                                $std_count = mysqli_num_rows($id_count);
                                                echo $std_count;
                                                ?>
                                            </td>

                                            <td scope="row">
                                                <?php if ($std_is_active) {
                                                    echo "Active";
                                                } else {
                                                    echo "Inactive";
                                                } ?>
                                            </td>
                                            <td scope="row">
                                                <!-- <a href="student_corner_edit.php?id=<?php echo $row['id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a> -->
                                                <a href="exam_form_delete.php?id=<?php echo $row['id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                <a href="exam_form_edit.php?id=<?php echo $row['id'] ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>

                                    <?php
                                    $in++;
                                    } ?>

                                </tbody>
                                <tfoot>
                                    <tr align="center">
                                        <th style="color:black;"><b>Id</b></th>
                                        <th style="color:black;"><b>Exam Id</b></th>
                                        <th style="color:black;"><b>Exam Name</b></th>
                                        <th style="color:black;"><b>Sem</b></th>
                                        <th style="color:black;"><b>Date</b></th>
                                        <th style="color:black;"><b>Subject Fee</b></th>
                                        <th style="color:black;"><b>Late Fee</b></th>
                                        <th style="color:black;"><b>Total Student</b></th>
                                        <th style="color:black;"><b>Form Filled Student</b></th>
                                        <th style="color:black;"><b>Status</b></th>
                                        <th style="color:black;"><b>Action</b></th>
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
</body>

</html>