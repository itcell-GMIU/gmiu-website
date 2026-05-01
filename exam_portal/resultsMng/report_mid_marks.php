<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_GET['exm']) && isset($_GET['sbj'])) {
    $exm = mysqli_real_escape_string($con, $_GET['exm']);
    $exm = validate_data($exm);

    $sbj = $_GET['sbj'];
} else {
    $exm = "";
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
                            <h1 class="m-0">MID MARKS REPORT</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">MID MARKS REPORT</li>
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
                                    <h5><b><i class="fa fa-check-square-o"></i> MID MARKS REPORT</b></h5>
                                </center>
                            </span>
                        </div>
                        <div class="card-body">
                            <form action="" method="get" class="form">
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <select class="form-control browser-default custom-select select2option" name="exm" required id="exam_id">
                                            <option value="">--- Select Exam ---</option>
                                            <?php
                                            $status = 0;
                                            if ($role_id == 51) {
                                                $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.semester as semester, std.is_active as std_is_active, std.type as type , std.session as session , std.start_date as start_date, std.end_date as end_date, std.year as year,
                                            faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_exam_form as std
                                            LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                            LEFT JOIN tbl_level level ON std.level_id = level.id 
                                            LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = ? and result_status = ?");
                                            } elseif ($role_id == 53) {
                                                $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.semester as semester, std.is_active as std_is_active, std.type as type , std.session as session , std.start_date as start_date, std.end_date as end_date, std.year as year,
                                                faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_exam_form as std
                                                LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                                LEFT JOIN tbl_level level ON std.level_id = level.id 
                                                LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = ? and std.program_id IN ($HODprogram_id)");
                                            }
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
                                    <div class="form-group col-sm-10">
                                        <select class="form-control browser-default custom-select" name="sbj" required id="subject_id">
                                            <option value="">--- Select Subject ---</option>
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

                            <?php
                            $query33 = "SELECT `entMSE`, `passMSE` FROM tbl_mi_subject_master WHERE subject_code = ?";
                            $stmt33 = $con->prepare($query33);
                            $stmt33->bind_param("s", $sbj);
                            $stmt33->execute();
                            $result33 = $stmt33->get_result();

                            while ($row33 = $result33->fetch_assoc()) {
                                $entMSE = $row33['entMSE'];
                                $entMSE = intval($entMSE);

                                $passMSE = intval($row33['passMSE']);
                            }
                            ?>
                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                <thead>
                                    <tr class="">
                                        <th>Enrollment No</th>
                                        <th>Subject Code</th>
                                        <th>Locked Marks</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    <?php
                                    $query22 = "SELECT subject_code, enrollnment_no, id, Mmid, Mrmid FROM tbl_exam_results WHERE exam_id = ? AND subject_code = ?";
                                    $stmt22 = $con->prepare($query22);
                                    $stmt22->bind_param("is", $exm, $sbj);
                                    $stmt22->execute();
                                    $result22 = $stmt22->get_result();

                                    $counter = 1;
                                    while ($row22 = $result22->fetch_assoc()) {

                                        if ($row22['Mmid']  != "" || $row22['Mmid']  != NULL || !empty($row22['Mmid'])) {

                                            $midmark = $row22['Mmid'];
                                    ?>
                                            <tr>
                                                <td><?= $row22['enrollnment_no'] ?></td>
                                                <td><?= $row22['subject_code'] ?></td>
                                                <td><?= $midmark ?></td>
                                                <td><?php
                                                    if ((intval($midmark) < intval($passMSE))  && $midmark != "AB") {
                                                        echo  '<span class="badge badge-warning">Fail</span>';
                                                    } elseif ($midmark >= $passMSE && $midmark != "AB") {
                                                        echo  '<span class="badge badge-success">Pass</span>';
                                                    } elseif ($midmark == "AB") {
                                                        echo  '<span class="badge badge-dark">Absent</span>';
                                                    } elseif ($midmark == "AB") {
                                                        echo  '<span class="badge badge-dark">Absent</span>';
                                                    }
                                                    ?></td>
                                            </tr>
                                    <?php
                                            $counter++;
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
        function myFunction() {
            var txt;
            if (confirm("Are You Sure For Locking This Marks!")) {
                txt = "You pressed OK!";
            } else {
                txt = "You pressed Cancel!";
            }
            document.getElementById("demo").innerHTML = txt;
        }
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
    <script>
        function checkMaxValue(input, counter) {
            var maxValue = <?= $entMSE ?>; // Your maximum value here
            var inputValue = input.value;
            var warningDiv = document.getElementById("warning" + counter);
            var form = input.form;
            var button = document.getElementById('update');

            button.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Prevent form submission on Enter key
                }
            });

            if (parseInt(inputValue) > maxValue) {
                warningDiv.innerHTML = "Warning: Entered value is greater than the maximum marks!";
                // input.disabled = true; // Disable the input field
                input.value = "";
                button.disabled = true;
            } else {
                warningDiv.innerHTML = ""; // Clear the warning if input value is within limits
                input.disabled = false; // Enable the input field
                button.disabled = false;

            }
        }

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>
</body>

</html>