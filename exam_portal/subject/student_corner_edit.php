<?php
// Include the checklogin.php file
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Header -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <!-- CKeditor custom script -->
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
    <!-- /.CKeditor custom script -->
</head>
<?php
// Fetch program id and level id from display table
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $id = only_digits($id);

    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000)</script>";
    }
}

$cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.sem as sem,std.Syllabus as Syllabus, std.subject_code as subject_code, std.subject_name as subject_name, std.subject_short_name as subject_short_name, std.lectures as lectures, std.tutorial as tutorial, std.practical as practical, std.credit as credit, std.is_active as std_is_active FROM tbl_std_corner as std WHERE std.id = ?");
$cmd->bind_param("i", $id);
$cmd->execute();
$result = $cmd->get_result();

while ($row = $result->fetch_assoc()) {
    // Fetch data from database
    $id = $row['id'];
    $faculty_id = !empty($row['faculty_id']) ? $row['faculty_id'] : 'N/A';
    $level_id = !empty($row['level_id']) ? $row['level_id'] : 'N/A';
    $program_id = !empty($row['program_id']) ? $row['program_id'] : 'N/A';
    $sem = !empty($row['sem']) ? $row['sem'] : 'N/A';
    $subject_code = !empty($row['subject_code']) ? $row['subject_code'] : 'N/A';
    $subject_name = !empty($row['subject_name']) ? $row['subject_name'] : 'N/A';
    $subject_short_name = !empty($row['subject_short_name']) ? $row['subject_short_name'] : 'N/A';
    $lectures = !empty($row['lectures']) ? $row['lectures'] : 'N/A';
    $tutorial = !empty($row['tutorial']) ? $row['tutorial'] : 'N/A';
    $practical = !empty($row['practical']) ? $row['practical'] : 'N/A';
    $credit = !empty($row['credit']) ? $row['credit'] : 'N/A';
    $std_is_active = $row['std_is_active'];
    $Syllabus = !empty($row['Syllabus']) ? $row['Syllabus'] : "<b>N/A</b>";
}
?>


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
                            <h1 class="m-0">Edit Student Corner</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Student Corner</li>

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
                                    <h3 class="card-title">Edit Student Corner</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="student_corner_update.php" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <?php if ($role_id != 8) {


                                        ?>
                                            <div class="form-group">
                                                <label>Select Faculty</label>
                                                <select class="form-control" name="faculty_id" id="faculty_id">
                                                    <?php
                                                    $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {

                                                    ?>

                                                        <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                            <?php echo $row['name'] ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Select Level</label>
                                                <select name="level_id" id="level_id" class="form-control" required>
                                                    <?php
                                                    $cmd = "SELECT * FROM tbl_level WHERE is_delete = '0' and is_active='1'";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {

                                                    ?>

                                                        <option value="<?php echo $row['id'] ?>" <?php if ($level_id == $row['id']) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                            <?php echo $row['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            
                                            <div class="form-group">
                                                <label>Select Program</label>
                                                <select name="program_id" id="program_id" class="form-control" required>
                                                    <?php
                                                    $cmd = "SELECT * FROM tbl_program WHERE is_delete = '0' and is_active='1'";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {

                                                    ?>

                                                        <option value="<?php echo $row['id'] ?>" <?php if ($program_id == $row['id']) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                            <?php echo $row['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="form-group">
                                            <label for="name">sem<span style="color: red;">*</span></label>
                                            <input type="text" name="sem" class="form-control" id="sem" value="<?php echo $sem ?>" placeholder="Enter Sem" required>
                                        </div>


                                        <div class="form-group">
                                            <label for="name">subject code<span style="color: red;">*</span></label>
                                            <input type="text" name="subject code" class="form-control" id="subject_code_id" value="<?php echo $subject_code ?>" placeholder="Enter Subject Code" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">subject name<span style="color: red;">*</span></label>
                                            <input type="text" name="subject_name" class="form-control" id="subject_name" value="<?php echo $subject_name ?>" placeholder="Enter Subject Name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">subject short name<span style="color: red;">*</span></label>
                                            <input type="text" name="subject_short_name" class="form-control" id="subject_short_id" value="<?php echo $subject_short_name ?>" placeholder="Enter subject short name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">lectures<span style="color: red;">*</span></label>
                                            <input type="text" name="lectures" class="form-control" id="lectures" value="<?php echo $lectures ?>" placeholder="Enter lectures" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">tutorial<span style="color: red;">*</span></label>
                                            <input type="text" name="tutorial" class="form-control" id="tutorial" value="<?php echo $tutorial ?>" placeholder="Enter lectures" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">practical<span style="color: red;">*</span></label>
                                            <input type="text" name="practical" class="form-control" id="practical" value="<?php echo $practical ?>" placeholder="Enter practical" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">credit<span style="color: red;">*</span></label>
                                            <input type="text" name="credit" class="form-control" id="credit" value="<?php echo $credit ?>" placeholder="Enter credit" required>
                                        </div>
                                        <div name="report" id="report" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Report</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="report_upload" id="report_upload">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="card-footer"> -->
                                        <a href="<?php echo '../uploads/Syllabus/' . $Syllabus; ?>" class="btn btn-primary">View Report</a>

                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                    <!-- right column -->
                    <div class="col-md-6">

                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
        </div><!-- /.container-fluid -->
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

    <?php include '../include/importjs.php'; ?>
    <script>
    $(document).ready(function() {
        //call for listing the dropdown and select by default
        load_level();
        load_program();
    });

    function load_level() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo $faculty_id; ?>;
        var level_id = <?php echo $level_id; ?>;
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

    function load_program() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo $faculty_id; ?>;
        var level_id = <?php echo $level_id; ?>;
        var program_id = <?php echo $program_id; ?>;
        var api_for = "dashboard";
        $.ajax({
            url: path + 'program.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_data: level_id,
                program_id: program_id,
                api_for: api_for
            },
            success: function(result) {
                $('#program_id').html(result);
            }
        });

    }
</script>
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

    $('#level_id').on('change', function() {
        var path = '<?php echo "$base_url_api"; ?>';
        var level_id = this.value;
        var faculty_id = $("select#faculty_id option:checked").val();

        $.ajax({
            url: path + 'program.php',
            type: "POST",
            data: {
                level_data: level_id,
                faculty_data: faculty_id
            },
            cache: false,
            success: function(data) {
                $('#program_id').html(data);
            }
        })
    });
</script>
<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>

<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
</body>

</html>
