<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_GET['type'])) {
    $type_mark = mysqli_real_escape_string($con, $_GET['type']);
    $type_mark = validate_data($type_mark);

    if ($type_mark == 1) {
        $type_name = 'Mid Marks';
        $cl_name = 'UpMmid';
        $cl_mark = 'passMSE';
    } elseif ($type_mark == 2) {
        $type_name = 'ReMid Marks';
        $cl_name = 'UpMrmid';
        $cl_mark = 'passMSE';
    } elseif ($type_mark == 3) {
        $type_name = 'Ala Marks';
        $cl_name = 'UpMala';
        $cl_mark = 'passALA';
    } elseif ($type_mark == 4) {
        $type_name = 'Viva Marks';
        $cl_name = 'UpMviva';
        $cl_mark = 'passVIVA';
    } elseif ($type_mark == 5) {
        $type_name = 'Practical Marks';
        $cl_name = 'UpMpractical';
        $cl_mark = 'passPRACTICAL';
    }
} else {
    $type_mark = "";
    $type_name = "-";
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
                            <h1 class="m-0">PENDING MARKS REPORT</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">PENDING MARKS REPORT</li>
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
                                    <h5><b><i class="fa fa-check-square-o"></i> PENDING MARKS REPORT</b></h5>
                                </center>
                            </span>
                        </div>
                        <div class="card-body">
                            <form action="" method="get" class="form">
                                <div class="row">
                                    <div class="form-group col-sm-10">
                                        <select class="form-control browser-default custom-select" name="type" required id="type">
                                            <option value="">--- Select Type ---</option>
                                            <option value="1">Mid</option>
                                            <option value="2">Re-Mid</option>
                                            <option value="3">Ala</option>
                                            <option value="4">Viva</option>
                                            <option value="5">Practical</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <button type="submit" class="btn btn-primary form-control">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>



                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered mb-4">
                                <tbody>
                                    <td>Type Of Report : </td>
                                    <td class="font-weight-bold"><?= $type_name ?></td>
                                </tbody>
                            </table>
                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                <thead>
                                    <tr class="">
                                        <th>Exam Name</th>
                                        <th>Subject Code</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    <?php
                                    if ($type_mark != "") {
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.semester as semester, std.is_active as std_is_active, std.type as type , std.session as session , std.start_date as start_date, std.end_date as end_date, std.year as year,
                                    faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_exam_form as std
                                    LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                    LEFT JOIN tbl_level level ON std.level_id = level.id 
                                    LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_active = 1 and result_status = ?");
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

                                            $query22 = "SELECT subject_code, MAX($cl_name) as status FROM tbl_exam_results WHERE exam_id = ? AND is_active = 1";
                                            $stmt22 = $con->prepare($query22);
                                            $stmt22->bind_param("i", $id);
                                            $stmt22->execute();
                                            $result22 = $stmt22->get_result();
                                            $counter = 1;
                                            while ($row22 = $result22->fetch_assoc()) {

                                                $crud->readSingleRecordColumn("tbl_mi_subject_master", "$cl_mark", ["subject_code" => $row22['subject_code']], $passMark);
                                                if ($passMark > 0) {
                                    ?>
                                                    <tr>
                                                        <td><?php echo $faculty_name . ' ' . $level_name . ' ' . $program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year']; ?></td>
                                                        <td><?= $row22['subject_code'] ?></td>
                                                        <td><?php

                                                            // echo  '<br>' . $passMark;
                                                            if ($row22['status'] > 1) {
                                                                echo  "<span class='badge badge-success'><i class='fa fa-lock'></i> Locked</span>";
                                                            } elseif ($row22['status'] == 1) {
                                                                echo "<span class='badge badge-info'><i class='fa fa-file'></i> Saved</span>";
                                                            } else {
                                                                echo "<span class='badge badge-warning'>Pending</span>";
                                                            }
                                                            ?></td>
                                                    </tr>
                                    <?php
                                                    $counter++;
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
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
        var input = document.getElementById('myTextInput');
        input.focus();
    </script>
    <script>
        $(document).ready(function() {
            $('.select2option').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#exam_id').change(function() {
                var examId = $(this).val();
                if (examId !== '') {
                    $.ajax({
                        url: 'fetch_subjects.php', // Path to your PHP script
                        type: 'post',
                        data: {
                            exam_id: examId
                        },
                        dataType: 'json',
                        success: function(response) {
                            var len = response.length;
                            $('#subject_id').empty();
                            $('#subject_id').append("<option value=''>--- Select Subject ---</option>");
                            for (var i = 0; i < len; i++) {
                                var subjectCode = response[i];
                                $('#subject_id').append("<option value='" + subjectCode + "'>" + subjectCode + "</option>");
                            }
                        }
                    });
                } else {
                    $('#subject_id').empty();
                    $('#subject_id').append("<option value=''>--- Select Subject ---</option>");
                }
            });
        });
    </script>
</body>

</html>