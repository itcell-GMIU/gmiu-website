<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// Include the checklogin.php file
include '../include/checklogin.php';

if ($mid_status != 1) {
    header("Location:../common/dashboard.php");
    exit;
}
$upmidStat = 3;

if (isset($_GET['exm']) && isset($_GET['sbj'])) {
    $exm = mysqli_real_escape_string($con, $_GET['exm']);
    $exm = validate_data($exm);

    $sbj = $_GET['sbj'];
} else {
    $exm = "";
}

if (isset($_POST['update'])) {

    extract($_POST);

    $id = implode(',', $id);
    $idNEW = explode(',', $id);
    if (isset($_POST['is_absent'])) {
        $is_absent = implode(',', $_POST['is_absent']);
    } else {
        $is_absent = ''; // or whatever default value you prefer
    }

    $upmid++;

    $i = 0;
    // Loop through each subject
    foreach ($idNEW as $in) {

        $numbersArray = explode(",", $is_absent);

        // Check if the number exists in the array
        if (in_array($in, $numbersArray)) {
            $newmark[$i] = "AB";
        }

        // Insert the JSON data into the database
        $stmt = $con->prepare("UPDATE tbl_exam_results SET Mrmid = ?, UpMrmid = ? WHERE id = ? ");
        $stmt->bind_param("sss", $newmark[$i], $upmid, $in);
        $result1 = $stmt->execute();
        $i++;
    }

    // Error handling if insertion fails
    if ($result1 == 1) {
        $_SESSION['status'] = "Mark Locked Successfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location=''},100)</script>";
    } else {
        $_SESSION['status'] = "Marks Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location=''},100)</script>";
    }
    exit;
}

function isStudentStatusThree($student_id, $exm_id)
{
    global $con;

    // Prepare the SQL statement
    $stmt = $con->prepare("SELECT status FROM tbl_exam_student WHERE enrollnment_no = ? AND exam_id = ? AND is_active = 1");
    $stmt->bind_param("si", $student_id, $exm_id);

    // Execute the statement
    $stmt->execute();

    // Bind the result
    $stmt->bind_result($status);

    // Fetch the result
    if ($stmt->fetch()) {
        // Check if the status is 3
        if ($status == 3) {
            return true;
        } else {
            return false;
        }
    } else {
        // If no result is found
        return false;
    }

    // Close the statement
    $stmt->close();
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
                            <h1 class="m-0">RE-MID MARKS</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Re-MID MARKS</li>
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
                                    <h5><b><i class="fa fa-check-square-o"></i> RE-MID MARKS</b></h5>
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
                                            LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = ? and result_status = ? and std.is_active = 1");
                                            } elseif ($role_id == 53) {
                                                $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.semester as semester, std.is_active as std_is_active, std.type as type , std.session as session , std.start_date as start_date, std.end_date as end_date, std.year as year,
                                                faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_exam_form as std
                                                LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                                LEFT JOIN tbl_level level ON std.level_id = level.id 
                                                LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = ? and std.program_id IN ($HODprogram_id) and result_status = ? and std.is_active = 1");
                                            }
                                            $cmd->bind_param("ii", $status, $status);
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
                                                $examType = $row['type'];
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
                                $passingMark = $row33['entMSE'];
                                $passingMark = intval($passingMark);

                                $minimumMark = $row33['passMSE'];
                                $minimumMark = intval($minimumMark);
                            ?>
                                <table class="table table-bordered mb-3">
                                    <thead>
                                        <tr>
                                            <th>Enter From : <?= $row33['entMSE'] ?></th>
                                            <th>Passing Marks : <?= $row33['passMSE'] ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            <?php
                            }
                            ?>
                            <form action="" class="form" method="post" id="myForm">
                                <table class="table table-bordered">
                                    <tbody class="tbody">
                                        <tr class="bg-dark">
                                            <th>Sr. No.</th>
                                            <th>Enrollment No</th>
                                            <th>Subject Code</th>
                                            <th>Add Marks</th>
                                            <th>Is Absent ?</th>
                                        </tr>
                                        <?php
                                        if (isset($_GET['exm']) && isset($_GET['sbj'])) {

                                            $ex_type = (string) mysqli_fetch_assoc(mysqli_query($con, "SELECT type FROM tbl_exam_form WHERE id = $exm"))['type'];
                                        }

                                        if (isset($_GET['exm']) && isset($_GET['sbj']) && $ex_type == 'remedial') {
                                            $query22 = "SELECT exam_id,subject_code, enrollnment_no, id, Mmid, UpMrmid, Mrmid FROM tbl_exam_results WHERE exam_id = ? AND subject_code = ? AND ((Mmid < $minimumMark OR Mmid = 'AB' OR Mmid IS NULL) OR (Mrmid < $minimumMark OR Mrmid = 'AB' OR Mrmid IS NULL)) ORDER BY enrollnment_no ASC";
                                        } else {
                                            $query22 = "SELECT exam_id,subject_code, enrollnment_no, id, Mmid, UpMrmid, Mrmid FROM tbl_exam_results WHERE exam_id = ? AND subject_code = ? ORDER BY enrollnment_no ASC";
                                        }

                                        $stmt22 = $con->prepare($query22);
                                        $stmt22->bind_param("is", $exm, $sbj);
                                        $stmt22->execute();
                                        $result22 = $stmt22->get_result();

                                        $counter = 1;

                                        $upmidStat = 0;

                                        while ($row22 = $result22->fetch_assoc()) {

                                            $student_id = $row22['enrollnment_no'];
                                            $exm_id = $row22['exam_id'];

                                            if (isStudentStatusThree($student_id, $exm_id)) {

                                                if ($minimumMark > $row22['Mmid'] || $row22['Mmid'] == 'AB') {
                                                    $MidMark = $row22['Mrmid'];
                                                }

                                                if (($row22['Mrmid'] < $minimumMark || $minimumMark > $row22['Mmid']) || $row22['Mrmid'] == 'AB') {

                                                    // $upmidStatus = $row22['UpMrmid'];


                                                    $upmid1 = $row22['UpMrmid'];

                                                    if ($upmid1 > $upmidStat) {
                                                        $upmidStat = $upmid1;
                                                    }

                                                    if ($role_id == 51 || $upmidStat < 2) {

                                                        // if ($row22['Mmid']  == "" || $row22['Mmid']  == NULL || empty($row22['Mmid'])) {
                                                        if ($ex_type == 'remedial') {

                                                            if ($minimumMark > $row22['Mmid'] || $row22['Mmid'] == 'AB') {
                                        ?>
                                                                <tr>
                                                                    <td><?= $counter ?></td>
                                                                    <td><?= $row22['enrollnment_no'] ?></td>
                                                                    <td><?= $row22['subject_code'] ?></td>
                                                                    <td>
                                                                        <input type="text" name="newmark[]" class="form-control" placeholder="Enter Marks" onchange="checkMaxValue(this, <?= $counter ?>)" onkeypress="return isNumberKey(event)" value="<?= $MidMark ?>">
                                                                        <div id="warning<?= $counter ?>" class="warning" style="color: red;"></div>
                                                                        <input type="hidden" name="id[]" class="form-control" value="<?= $row22['id'] ?>">
                                                                    </td>
                                                                    <td>
                                                                        <label for="">
                                                                            <input type="checkbox" name="is_absent[]" value="<?= $row22['id'] ?>" <?php echo ($row22['Mrmid'] == 'AB') ? 'checked' : ''; ?>> <b> Yes</b>
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                                $counter++;
                                                            }
                                                        } elseif ($ex_type == 'regular') {
                                                            if ($minimumMark > $row22['Mmid'] || $row22['Mmid'] == 'AB') {
                                                            ?>
                                                                <tr>
                                                                    <td><?= $counter ?></td>
                                                                    <td><?= $row22['enrollnment_no'] ?></td>
                                                                    <td><?= $row22['subject_code'] ?></td>
                                                                    <td>
                                                                        <input type="text" name="newmark[]" class="form-control" placeholder="Enter Marks" onchange="checkMaxValue(this, <?= $counter ?>)" onkeypress="return isNumberKey(event)" value="<?= $MidMark ?>">
                                                                        <div id="warning<?= $counter ?>" class="warning" style="color: red;"></div>
                                                                        <input type="hidden" name="id[]" class="form-control" value="<?= $row22['id'] ?>">
                                                                    </td>
                                                                    <td>
                                                                        <label for="">
                                                                            <input type="checkbox" name="is_absent[]" value="<?= $row22['id'] ?>" <?php echo ($row22['Mrmid'] == 'AB') ? 'checked' : ''; ?>> <b> Yes</b>
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                        <?php
                                                                $counter++;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        <input type="hidden" name="upmid" class="form-control" value="<?= $upmidStat ?>">
                                    </tbody>
                                </table>
                                <div class="text-center">
                                    <?php
                                    if ($role_id == 51 || $upmidStat < 1) {
                                    ?>
                                        <!-- The modal -->
                                        <div class="modal fade" id="flipFlop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">

                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">

                                                        <h4 class="modal-title" id="modalLabel">Are You Sure For Save This Marks ?</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa fa-cancel"></i> No</button>
                                                        <button id="update" type="submit" class="btn btn-success" name="update"><i class="fa fa-check"></i> Yes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="ml-2 btn btn-success text-nowrap" id="export" style="float:center" data-toggle="modal" data-target="#flipFlop">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                    <?php
                                    } elseif ($upmidStat == 1) {
                                    ?>
                                        <div class="modal fade" id="flipFlop2" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">

                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">

                                                        <h4 class="modal-title" id="modalLabel">Are You Sure For Locking This Marks ?</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa fa-cancel"></i> No</button>
                                                        <button id="update" type="submit" class="btn btn-success" name="update"><i class="fa fa-check"></i> Yes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="ml-2 btn btn-warning text-nowrap" id="export" style="float:center" data-toggle="modal" data-target="#flipFlop2">
                                            <i class="fa fa-lock"></i> Lock Marks
                                        </button>
                                    <?php
                                    } elseif ($upmidStat > 1) {
                                    ?>
                                        <div class="badge badge-warning">This Re-Mid Mark is Locked Already</div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="badge badge-light">Select Exam And Subject</div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </form>
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
        document.getElementById("myForm").addEventListener("keypress", function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent default Enter key action
            }
        });

        function checkMaxValue(input, counter) {
            var maxValue = <?= $passingMark ?>; // Your maximum value here
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