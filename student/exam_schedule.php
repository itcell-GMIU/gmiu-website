<?php
// Include the checklogin.php file
include 'include/checklogin.php';


if (isset($_GET['exam_id'])) {

    $exam_id = mysqli_real_escape_string($con, $_GET['exam_id']);
    $exam_id = validate_data($exam_id);
} else {
    $exam_id = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include 'include/importhead.php'; ?>
    <title>Exam Time Table</title>
    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">

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

                    <!--   Program list code  -->

                    <div class="card">
                        <!-- <div class="card-header">
                            <span>
                                <center>
                                    <h5><b>Exam Time Table</b></h5>
                                </center>
                            </span>
                        </div> -->

                        <form method="GET" action="">

                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-9">
                                            <div class="form-label-group">
                                                <select class="form-control browser-default custom-select text-uppercase" name="exam_id" required id="exam_id">
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
                                                        <option value="<?php echo $id; ?>" class="text-uppercase" <?php
                                                                                                                    if ($id == $exam_id) {
                                                                                                                        echo "selected";
                                                                                                                    }
                                                                                                                    ?>>
                                                            <?php echo $level_name.' '. $program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year']; ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary btn-block" id="export" style="float:center"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button End -->
                            <?php if (isset($_GET['exam_id'])) { ?>
                                <div class="table-responsive">
                                    <table id="acedemic" class="table table-bordered table-striped">
                                        <thead>
                                            <tr align="center">
                                                <th class="bg-light" colspan="5"><b>Theory Exam</b></th>
                                            </tr>
                                            <tr align="center">
                                                <th style="color:black;"><b>Sr.No.</b></th>
                                                <th style="color:black;"><b>Subject</b></th>
                                                <th style="color:black;"><b>Subject Name</b></th>
                                                <th style="color:black;"><b>Date</b></th>
                                                <th style="color:black;"><b>Exam Time</b></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            <?php
                                            $sub_type = "theory";
                                            $query = "SELECT `exam_id`, `subject_code`, `subject_name`, `date`, `start_time`, `end_time`, `class` FROM tbl_exam_timetable WHERE FIND_IN_SET(?, exam_id) > 0 AND sub_type = ? ";
                                            $stmt = $con->prepare($query);
                                            $stmt->bind_param("is", $exam_id, $sub_type);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $in = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                $subject_code = $row['subject_code'];
                                                $subject_name = $row['subject_name'];
                                                $date = $row['date'];
                                                $dateTime = new DateTime($date);
                                                $formattedDate = $dateTime->format("d-m-Y");
                                                $start_time = $row['start_time'];
                                                $end_time = $row['end_time'];
                                                $start_time = date("h:i A", strtotime($start_time));
                                                $end_time = date("h:i A", strtotime($end_time));
                                                $time = $start_time . ' To ' . $end_time;
                                            ?>

                                                <tr align="center">
                                                    <td scope="row"><?= $in ?></td>
                                                    <td scope="row"><?= $subject_code ?></td>
                                                    <td scope="row"><?= $subject_name ?></td>
                                                    <td scope="row"><?= $formattedDate ?></td>
                                                    <td scope="row"><?= $time ?></td>
                                                </tr>

                                            <?php
                                                $in++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php

                                $sub_type = "practical";
                                $query = "SELECT `exam_id`, `subject_code`, `date`, `start_time`, `end_time`, `class` FROM tbl_exam_timetable WHERE FIND_IN_SET(?, exam_id) > 0 AND sub_type = ? ";
                                $stmt = $con->prepare($query);
                                $stmt->bind_param("is", $exam_id, $sub_type);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                // Check if there is data to display
                                if ($result->num_rows > 0) {
                                ?>
                                    <div class="table-responsive">
                                        <table id="academic" class="table table-bordered table-striped">
                                            <thead>
                                                <tr align="center">
                                                    <th class="bg-light" colspan="4"><b>Practical Exam</b></th>
                                                </tr>
                                                <tr align="center">
                                                    <th style="color: black;"><b>Sr.No.</b></th>
                                                    <th style="color: black;"><b>Subject</b></th>
                                                    <th style="color: black;"><b>Date</b></th>
                                                    <th style="color: black;"><b>Exam Time</b></th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody">
                                                <?php

                                                $in = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    $subject_code = $row['subject_code'];
                                                    $date = $row['date'];
                                                    $dateTime = new DateTime($date);
                                                    $formattedDate = $dateTime->format("d-m-Y");
                                                    $start_time = $row['start_time'];
                                                    $end_time = $row['end_time'];
                                                    $start_time = date("h:i A", strtotime($start_time));
                                                    $end_time = date("h:i A", strtotime($end_time));
                                                    $time = $start_time . ' To ' . $end_time;
                                                ?>
                                                    <tr align="center">
                                                        <td scope="row"><?= $in ?></td>
                                                        <td scope="row"><?= $subject_code ?></td>
                                                        <td scope="row"><?= $formattedDate ?></td>
                                                        <td scope="row"><?= $time ?></td>
                                                    </tr>
                                            <?php
                                                    $in++;
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } ?>
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