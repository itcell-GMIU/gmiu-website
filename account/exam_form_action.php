<?php
// Include the checklogin.php file
include 'include/checklogin.php';


if (isset($_GET['exam_id'])) {

    $exam_id = mysqli_real_escape_string($con, $_GET['exam_id']);
    $exam_id = validate_data($exam_id);
} else {
    $faculty_name = "";
    $exam_id = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include 'include/importhead.php'; ?>
    <title>Exam Reports</title>
    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
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
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Exam Form Actions</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Exam Form Actions</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i>Exam Form Actions</b></h5>
                                </center>
                            </span>
                        </div>

                        <form method="GET" action="">

                            <div class="card-body">
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

                                        <div class="col-md-3">
                                            <input type="submit" class="btn btn-primary btn-block" id="export" style="float:center" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr align="center">
                                            <th style="color:black;"><b>Id</b></th>
                                            <th style="color:black;"><b>Enrollnment No</b></th>
                                            <th style="color:black;"><b>Student Name</b></th>
                                            <th style="color:black;"><b>Exam Sem</b></th>
                                            <th style="color:black;"><b>Account Status</b></th>
                                            <th style="color:black;"><b>Action</b></th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        <?php
                                        if (isset($_GET['exam_id'])) {
                                            $query = "SELECT id, enrollnment_no, account_status FROM tbl_exam_student WHERE exam_id = ?";
                                            $stmt = $con->prepare($query);
                                            $stmt->bind_param("i", $exam_id);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $in = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                $enrollnment_no = $row['enrollnment_no'];
                                                $id = $row['id'];
                                                $exam_status = $row['account_status'];

                                                // Sanitize $exam_status and $enrollnment_no if necessary

                                                if ($exam_status == 0) {
                                                    $echo_status = '<span class="badge badge-info">Pending</span>';
                                                } elseif ($exam_status == 1) {
                                                    $echo_status = '<span class="badge badge-success">Approved</span>';
                                                    $btn_action = '<a href="exam_form_ac_rej.php?rej_id=' . $id . '" class="btn btn-danger"><i class="fa fa-times"></i></a>';
                                                } elseif ($exam_status == 2) {
                                                    $echo_status = '<span class="badge badge-danger">Rejected</span>';
                                                    $btn_action = '<a href="exam_form_ac_rej.php?ac_id=' . $id . '" class="btn btn-primary"><i class="fa fa-check"></i></a>';
                                                } elseif ($exam_status == 3) {
                                                    $echo_status = '<span class="badge badge-success">Form Filled</span>';
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
                                        ?>

                                                <tr align="center">
                                                    <td scope="row"><?= $in ?></td>
                                                    <td scope="row"><?= $enrollnment_no ?></td>
                                                    <td scope="row"><?= $std_name ?></td>
                                                    <td scope="row"><?= $sem ?></td>
                                                    <td scope="row"><?= $echo_status ?></td>
                                                    <td scope="row"><?= $btn_action ?></td>
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
                                            <th style="color:black;"><b>Enrollnment No</b></th>
                                            <th style="color:black;"><b>Student Name</b></th>
                                            <th style="color:black;"><b>Exam Sem</b></th>
                                            <th style="color:black;"><b>Status</b></th>
                                            <th style="color:black;"><b>Action</b></th>
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
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- footer -->
    <?php include 'include/importjs.php'; ?>
</body>

</html>