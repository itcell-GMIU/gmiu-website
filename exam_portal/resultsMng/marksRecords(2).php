<?php
include '../include/checklogin.php';

if (isset($_GET['from_date']) && $_GET['from_date'] != "" && isset($_GET['to_date']) && $_GET['to_date'] != "") {
    /* $url_level_id = mysqli_real_escape_string($con, $_GET['url_level_id']);
    $url_level_id = validate_data($url_level_id); */
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
} else {
    $from_date = "";
    $to_date = "";
}
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
        $ExamName = $short_name . ' ' . $level_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year'];
    }
} else {
    $ExamName = "";
    $exid = "";
}

if (isset($_GET['exsbj'])) {
    $exsbj = $_GET['exsbj'];
} else {
    $exsbj = "";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title> <?= $ExamName.' ('.$exsbj.')' ?></title>
    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <!-- <h1 class="m-0">Payment History</h1> -->
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Marks History</li>
                            </ol>
                        </div><!-- /.col -->
                    </div>

                </div>
            </div>
            <section class="content">
                <div class="card mb-3">
                    <div class="card-header">

                        <i class="far fa-hand-pointer"></i>

                        <span> <b>Select Date</b></span>

                    </div>
                    <form method="GET" action="">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">

                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <label for="">Exam:</label>
                                            <select class="form-control" name="exam_id" id="exam_id" style="color:black; border-color:#325d88; border-width:1px">
                                                <option value="">---Select Exam---</option>
                                                <?php
                                                $cmd33 = "SELECT * FROM tbl_exam_results WHERE examinerID = $staff_id AND Mtheory IS NOT NULL GROUP BY exam_id";
                                                $cmd33 = $con->prepare($cmd33);

                                                $cmd33->execute();
                                                $result33 = $cmd33->get_result();
                                                while ($row33 = $result33->fetch_assoc()) {

                                                    $examID = $row33['exam_id'];

                                                    $status = 0;
                                                    $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.semester as semester, std.is_active as std_is_active, std.type as type , std.session as session , std.start_date as start_date, std.end_date as end_date, std.year as year,
                                                        faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_exam_form as std
                                                        LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                                        LEFT JOIN tbl_level level ON std.level_id = level.id 
                                                        LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = ? AND std.id = ?");
                                                    $cmd->bind_param("ii", $status, $examID);
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
                                                <?php }
                                                } ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <label for="">Subject :</label>
                                            <select class="form-control" name="exsbj" id="exsbj" style="color:black; border-color:#325d88; border-width:1px">
                                                <option value="">---Select Exam---</option>
                                                <?php
                                                $cmd44 = "SELECT * FROM tbl_exam_results WHERE examinerID = $staff_id AND Mtheory IS NOT NULL GROUP BY subject_code";
                                                $cmd44 = $con->prepare($cmd44);

                                                $cmd44->execute();
                                                $result44 = $cmd44->get_result();
                                                while ($row44 = $result44->fetch_assoc()) {

                                                    $examSbj = $row44['subject_code'];
                                                ?>
                                                    <option value="<?= $examSbj ?>" class="text-uppercase"><?= $examSbj ?></option>
                                                <?php }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-label-group">
                                            <label for="">From Date:</label>
                                            <input type="date" id="from_date" name="from_date" class="form-control" style="color:black; border-color:#325d88; border-width:1px" value="<?php echo isset($_GET['from_date']) ? htmlspecialchars($_GET['from_date']) : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-label-group">
                                            <label for="">To Date:</label>
                                            <input type="date" id="to_date" name="to_date" class="form-control" style="color:black; border-color:#325d88; border-width:1px" value="<?php echo isset($_GET['to_date']) ? htmlspecialchars($_GET['to_date']) : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="" class="text-white">.</label>
                                        <input type="submit" class="btn btn-primary btn-block" id="export" style="float:center" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="card">
                    <div class="card-header">
                        <p class="font-weight-bold m-0 p-0">Marks History</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="acedemic" class="dataTableLoad table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Code</th>
                                        <th>Subject Code</th>
                                        <th>Marks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cmd = "SELECT * FROM tbl_exam_results WHERE examinerID = $staff_id AND Mtheory IS NOT NULL ";

                                    if ($from_date != "" && $to_date != "") {
                                        $cmd .= " AND DATE(MtheoryTime) BETWEEN DATE(?) AND DATE(?)";
                                    }
                                    if ($exid != "") {
                                        $cmd .= " AND exam_id = $exid";
                                    }
                                    if ($exsbj != "") {
                                        $cmd .= " AND subject_code = '$exsbj'";
                                    }
                                    $cmd = $con->prepare($cmd);

                                    $cmd->execute();
                                    $result1 = $cmd->get_result();
                                    $in = 1;
                                    while ($row1 = $result1->fetch_assoc()) {
                                        // Status and payment status handling using switch statements...

                                        // Access exam form information from the left join
                                        // $session = $row1['session'];
                                        // $year = $row1['year'];
                                        // $program_id = $row1['program_id'];
                                        // $level_id = $row1['level_id'];
                                        // $faculty_id = $row1['faculty_id'];
                                        // $semester = $row1['semester'];

                                    ?>
                                        <tr>
                                            <td><?= $in  ?></td>
                                            <td><?= $row1['barcode']  ?></td>
                                            <td><?= $row1['subject_code']  ?></td>
                                            <td class="text-nowrap"><?= $row1['Mtheory'] ?></td>
                                        </tr>
                                    <?php
                                        $in++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include '../include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include '../include/importjs.php'; ?>
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
    </script>

    <script>
        $(document).ready(function() {
            //call for listing the dropdown and select by default
            load_level();
            load_program();
        });

        function load_level() {
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $url_faculty_id; ?>;
            var level_id = <?php echo $url_level_id; ?>;
            var api_for = "dashboard";
            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id,
                    api_for: api_for
                },
                success: function(result) {
                    $('#level_id').html(result);
                }
            });

        }
    </script>

</body>

</html>