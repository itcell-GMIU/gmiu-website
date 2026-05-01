<?php
include '../include/checklogin.php';
?>
<?php
// Fetch program id and level id from display table
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $id = only_digits($id);

    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='view_generate_paper.php'},1000)</script>";
    }
}

$cmd = $con->prepare("SELECT std.id as id, 
corner.faculty_id as faculty_id, 
corner.level_id as level_id, 
corner.program_id as program_id, 
corner.sem as sem, 
std.subject_code as subject_code, 
std.total_mark  as total_mark,
std.question as question,
std.clg_name as clg_name,
std.exam_name as exam_name,
std.exam_time as exam_time,
std.end_time as end_time,
std.exam_date as exam_date,
faculty.name as faculty_name, 
level.name as level_name, 
program.name as program_name 
FROM tbl_paper as std
LEFT JOIN tbl_std_corner_exam AS corner ON std.subject_code = corner.id
LEFT JOIN tbl_faculty AS faculty ON corner.faculty_id = faculty.id 
LEFT JOIN tbl_level AS level ON corner.level_id = level.id 
LEFT JOIN tbl_program AS program ON corner.program_id = program.id 
WHERE std.is_delete = 0 And std.id= ? ");
$cmd->bind_param("i", $id);

$cmd->execute();
$result = $cmd->get_result();



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>
     <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- ClockPicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
    <!-- /.CKeditor custom script -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
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
                            <h1 class="m-0">Edit Generate Question Paper</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Generate Question Paper</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">

                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->



                            
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Generate Question Paper</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form  action="update_generate_paper.php" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">

                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        $faculty_id = $row['faculty_id'];
                                        $level_id = $row['level_id'];
                                        $program_id = $row['program_id'];
                                        $id = $row['id'];
                                        $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                        $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                        $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                        $sem = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                                        $subject_code = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                                        $marks = !empty($row['total_mark']) ? $row['total_mark'] : "<b>N/A</b>";
                                        $question = !empty($row['question']) ? $row['question'] : "<b>N/A</b>";
                                        $clg_name = !empty($row['clg_name']) ? $row['clg_name'] : "<b>N/A</b>";
                                        $exam_name = !empty($row['exam_name']) ? $row['exam_name'] : "<b>N/A</b>";
                                        $exam_time = !empty($row['exam_time']) ? $row['exam_time'] : "<b>N/A</b>";
                                        $end_time = !empty($row['end_time']) ? $row['end_time'] : "<b>N/A</b>";
                                        $exam_date = !empty($row['exam_date']) ? $row['exam_date'] : "<b>N/A</b>";
                                  
                                    ?>


                                        <div class="form-group row">
                                            <!--<div class="form-group col-md-4">-->
                                            <!--    <label for="clg_name">college Name <span style="color: red;">*</span></label>-->
                                            <!--    <input type="text" name="clg_name" class="form-control" id="clg_name" placeholder="ex. GYANMANJARI INSTITUTE OF TECHNOLOGY" required>-->
                                            <!--</div>-->

                                        
                                            <div class="form-group col-md-4">
                                                <label> Faculty Name <span style="color: red;"> *</span></label>
                                                <input type="text" name="faculty_name" class="form-control" id="faculty_name" value="<?php echo $faculty_name; ?>" readonly>
                                            </div>

                                            <div class="form-group col-md-4 ">
                                                 <label> Leval Name <span style="color: red;"> *</span></label>
                                                <input type="text" name="leval_name" class="form-control" id="leval_name" value="<?php echo $level_name; ?>" readonly>
                                            </div>

                                            <div class="form-group col-md-4 ">
                                                <label> Program Name <span style="color: red;"> *</span></label>
                                                <input type="text" name="program_name" class="form-control" id="program_name" value="<?php echo $program_name; ?>" readonly>
                                             </div>

                                            <div class="form-group col-md-4 ">
                                                <label>Semester<span style="color: red;"> *</span></label>
                                                <input type="text" name="sem" class="form-control" id="sem" value="<?php echo $sem; ?>" readonly>
                                           
                                            </div>

                         

                                            <div class="form-group col-md-4 ">
                                                <label for="t_marks">Total Marks <span style="color: red;">*</span></label>
                                                <input type="text" name="marks" class="form-control" id="marks" value="<?php echo $marks; ?>" readonly>

                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="exam_date">Subject Code <span style="color: red;">*</span></label>

                                                <?php
                                                    $cmd2 = $con->prepare("SELECT subject_code , subject_name from tbl_std_corner_exam where id = $subject_code ");
                                                    $cmd2->execute();
                                                    $result1 = $cmd2->get_result();
                                                    while ($row = $result1->fetch_assoc()) {
                                                        $subject_code1 = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                                                        $subject_name = !empty($row['subject_name']) ? $row['subject_name'] : "<b>N/A</b>";
                                                    ?>

                                                <input type="text" name="subject_code" class="form-control" id="subject_code" value="<?php echo $subject_code1; ?>" readonly>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="exam_date">Subject Name  <span style="color: red;">*</span></label>

                                                <?php
                                                    $cmd2 = $con->prepare("SELECT subject_code , subject_name from tbl_std_corner_exam where id = $subject_code ");
                                                    $cmd2->execute();
                                                    $result1 = $cmd2->get_result();
                                                    while ($row = $result1->fetch_assoc()) {
                                                        $subject_code1 = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                                                        $subject_name = !empty($row['subject_name']) ? $row['subject_name'] : "<b>N/A</b>";
                                                    ?>

                                                <input type="text" name="subject_code" class="form-control" id="subject_code" value="<?php echo $subject_name; ?>" readonly>
                                                <?php } ?>
                                            </div>



                                            <div class="form-group col-md-4">
                                                <label for="clg_name">College Name <span style="color: red;">*</span></label>
                                                <select name="clg_name" class="form-control" id="clg_name" required>
                                                    <!-- <option value="" disabled selected>Select a College</option> -->
                                                    <option value="<?php echo $clg_name; ?>" selected><?php echo $clg_name; ?></option>
                                                    <option value="Gyanmanjari Institute of Technology">Gyanmanjari Institute of Technology</option>
                                                    <option value="Gyanmanjari Diploma Engineering College">Gyanmanjari Diploma Engineering College</option>
                                                    <option value="Gyanmanjari Pharmacy College">Gyanmanjari Pharmacy College</option>
                                                    <option value="Gyanmanjari Science College">Gyanmanjari Science College</option>
                                                    <option value="Gyanmanjari Institute of Commerce">Gyanmanjari Institute of Commerce</option>
                                                    <option value="Gyanmanjari Institute of Management Studies">Gyanmanjari Institute of Management Studies</option>
                                                    <option value="Gyanmanjari Institute of Arts">Gyanmanjari Institute of Arts</option>
                                                    <option value="Gyanmanjari College of Computer Application">Gyanmanjari College of Computer Application</option>
                                                    <option value="Gyanmanjari Institute of Design">Gyanmanjari Institute of Design</option>
                                                    <option value="Gyanmanjari Institute of Home Science">Gyanmanjari Institute of Home Science</option>
                                                    <option value="Gyanmanjari Institute of Medical Science and Health Care">Gyanmanjari Institute of Medical Science and Health Care</option>
                                                    <option value="Gyanmanjari Institute of Social Work">Gyanmanjari Institute of Social Work</option>
                                                    <option value="Gyanmanjari Institute of Hotel Management">Gyanmanjari Institute of Hotel Management</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="exam_name">Exam Name <span style="color: red;">*</span></label>
                                                <input type="text" name="exam_name" class="form-control" id="exam_name" value="<?php echo $exam_name; ?>" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="exam_time">Start Time <span style="color: red;">*</span></label>
                                                <div class="input-group clockpicker">
                                                    <input type="text" name="exam_time" class="form-control" id="exam_time" value="<?php echo $exam_time; ?>" required>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="end_time">End Time <span style="color: red;">*</span></label>
                                                <div class="input-group clockpicker">
                                                    <input type="text" name="end_time" class="form-control" id="end_time" value="<?php echo $end_time; ?>" required>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label for="exam_date">Exam Date <span style="color: red;">*</span></label>
                                                <input type="text" name="exam_date" class="form-control" id="exam_date" value="<?php echo $exam_date; ?>" required>
                                            </div>
                                           
                                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>

                                    <?php } ?>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
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

    <?php include '../include/importjs.php'; ?>
</body>

</html>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Bootstrap JS for ClockPicker -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- ClockPicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>

<!-- Initialize Datepicker and Timepicker -->
<script>
    $(document).ready(function() {
        $('#exam_time').clockpicker({
            donetext: 'Done',
            autoclose: true,
            twelvehour: true
        });
        $('#end_time').clockpicker({
            donetext: 'Done',
            autoclose: true,
            twelvehour: true
        });

        $('#exam_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
