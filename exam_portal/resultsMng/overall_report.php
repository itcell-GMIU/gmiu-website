<?php
// Include the checklogin.php file
include '../include/checklogin.php';

function convertMarksToPercentage($originalMarks, $targetScale)
{
    // Convert to percentage
    $percentage = ($originalMarks / $targetScale) * 100;
    return $percentage;
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
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>Result Overall Reports</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <!-- + ADD Button End -->
                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                <thead>
                                    <tr align="center">
                                        <th style="color:black;"><b>Id</b></th>
                                        <th style="color:black;"><b>Exam Name</b></th>
                                        <th style="color:black;"><b>Sem</b></th>
                                        <th style="color:black;"><b>Total Student</b></th>
                                        <th style="color:black;"><b>Pass</b></th>
                                        <th style="color:black;"><b>Fail</b></th>
                                        <th style="color:black;"><b>Result Percentage</b></th>
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
                                            std.hallticket_status as hallticket_status, 
                                            std.pr_hallticket_status as pr_hallticket_status, 
                                            std.result_status as result_status,
                                            std.year as year,
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
                                        WHERE std.is_delete = ? and std.result_status = 1");
                                    $cmd->bind_param("i", $status);
                                    $cmd->execute();
                                    $result = $cmd->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $level_id = $row['level_id'];
                                        $program_id = $row['program_id'];
                                        $id = $row['id'];
                                        $hallticket_status = $row['hallticket_status'];
                                        $result_status = $row['result_status'];
                                        $PRhallticket_status = $row['pr_hallticket_status'];
                                        $semester = $row['semester'];
                                        $clg_name = $row['college_name'];

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
                                                <?php echo $id; ?>
                                            </td>
                                            <td scope="row" class="text-uppercase" style="width:250px;">
                                                <?php echo $clg_name . ' ' . $level_name . ' ' . $program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year']; ?>
                                            </td>

                                            <td scope="row">
                                                <?php echo $sem; ?>
                                            </td>

                                            <td scope="row">
                                                <?php
                                                $id_count_total = $con->query("SELECT id FROM tbl_exam_student WHERE exam_id = $id and status = 3");
                                                $std_count_total = mysqli_num_rows($id_count_total);
                                                echo $std_count_total;
                                                ?>
                                            </td>

                                            <td scope="row" style="background-color: #0ef30e52;" class="font-weight-bold">
                                                <?php
                                                $id_count_pass = $con->query("SELECT id FROM tbl_exam_student WHERE exam_id = $id and status = 3 and is_pass = 1");
                                                $std_count_pass = mysqli_num_rows($id_count_pass);
                                                echo $std_count_pass;
                                                ?>
                                            </td>

                                            <td scope="row" style="background-color: #e9000057;" class="font-weight-bold">
                                                <?php
                                                $id_count_fail = $con->query("SELECT id FROM tbl_exam_student WHERE exam_id = $id and status = 3 and is_pass = 0");
                                                $std_count_fail = mysqli_num_rows($id_count_fail);
                                                echo $std_count_fail;
                                                ?>
                                            </td>

                                            <td scope="row">
                                                <?php
                                                $percentage_pass = convertMarksToPercentage($std_count_pass, $std_count_total);
                                                echo number_format($percentage_pass, 3) . '%';

                                                ?>
                                            </td>

                                        </tr>
                                    <?php } ?>

                                </tbody>
                                <tfoot>
                                    <tr align="center">
                                        <th style="color:black;"><b>Id</b></th>
                                        <th style="color:black;"><b>Exam Name</b></th>
                                        <th style="color:black;"><b>Sem</b></th>
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
</body>

</html>