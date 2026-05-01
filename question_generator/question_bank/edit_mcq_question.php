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
        echo "<script>setTimeout(function(){window.location='view_mcq_question_bank.php'},1000)</script>";
    }
}

$cmd = $con->prepare("SELECT std.id as id, 
corner.faculty_id as faculty_id, 
corner.level_id as level_id, 
corner.program_id as program_id, 
corner.sem as sem, 
std.subject_code as subject_code, 
std.chapter as chapter, 
std.question as question, 
std.marks as marks,
std.mcq_choice_a as a,
std.mcq_choice_b as b,
std.mcq_choice_c as c,
std.mcq_choice_d as d
FROM tbl_questions as std
LEFT JOIN tbl_std_corner_exam AS corner ON std.subject_code = corner.id
LEFT JOIN tbl_faculty AS faculty ON corner.faculty_id = faculty.id 
LEFT JOIN tbl_level AS level ON corner.level_id = level.id 
LEFT JOIN tbl_program AS program ON corner.program_id = program.id 
WHERE std.is_delete = 0 And std.id= ? ");
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
    $chapter = !empty($row['chapter']) ? $row['chapter'] : 'N/A';
    $question = !empty($row['question']) ? $row['question'] : 'N/A';
    $marks = !empty($row['marks']) ? $row['marks'] : 'N/A';
    $a = !empty($row['a']) ? $row['a'] : 'N/A';
    $b = !empty($row['b']) ? $row['b'] : 'N/A';
    $c = !empty($row['c']) ? $row['c'] : 'N/A';
    $d = !empty($row['d']) ? $row['d'] : 'N/A';
}

$chapters = array(
    1 => 'Chapter 1',
    2 => 'Chapter 2',
    3 => 'Chapter 3',
    4 => 'Chapter 4',
    5 => 'Chapter 5',
    6 => 'Chapter 6',
    7 => 'Chapter 7',
    8 => 'Chapter 8',
    9 => 'Chapter 9',
    10 => 'Chapter 10'
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
    <meta charset="UTF-8">
    <!-- CKeditor custom script -->
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
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
                            <h1 class="m-0">Edit Question </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Question </li>
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
                                <div class="card-header h-100">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h3 class="card-title h-100 mt-1">Edit Question </h3>
                                        </div>

                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="update_question_bank.php" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">

                                        <div class="form-group row">
                                            <div class="form-group col-md-4">
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

                                            <div class="form-group col-md-4">
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

                                            <div class="form-group col-md-4">
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

                                            <input type="hidden" name="id" value="<?php echo $id; ?>">

                                            <div class="form-group col-md-4">
                                                <label>Select sem<span style="color: red;"> *</span></label>
                                                <select name="sem" id="sem" class="form-control" required>
                                                    <option value=""> --- Semester--- </option>
                                                    <option value="1" <?php if ($sem == "1") echo "selected"; ?>> Semester 1</option>
                                                    <option value="2" <?php if ($sem == "2") echo "selected"; ?>> Semester 2</option>
                                                    <option value="3" <?php if ($sem == "3") echo "selected"; ?>> Semester 3</option>
                                                    <option value="4" <?php if ($sem == "4") echo "selected"; ?>> Semester 4</option>
                                                    <option value="5" <?php if ($sem == "5") echo "selected"; ?>> Semester 5</option>
                                                    <option value="6" <?php if ($sem == "6") echo "selected"; ?>> Semester 6</option>
                                                    <option value="7" <?php if ($sem == "7") echo "selected"; ?>> Semester 7</option>
                                                    <option value="8" <?php if ($sem == "8") echo "selected"; ?>> Semester 8</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6 ">
                                                <label for="subject_code_id">Subject Code<span style="color: red;">*</span></label>
                                                <select class="form-control" name="subject_code" required id="subject_code_id">
                                                    <?php
                                                    // Fetch subject codes from the database
                                                    $cmd2 = $con->prepare("SELECT * FROM tbl_std_corner_exam where id = $subject_code and is_delete = '0' ");
                                                    $cmd2->execute();
                                                    $result1 = $cmd2->get_result();
                                                    while ($row1 = $result1->fetch_assoc()) {    ?>
                                                        <option value="<?php echo $row1['id'] ?>" <?php if ($subject_code == $row1['id']) {
                                                                                                        echo "selected";
                                                                                                    }
                                                                                                    echo $subject_code; ?>>

                                                            <?php echo $row1['subject_code'] . '(' . $row1['subject_name'] . ')' ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="chapter">Chapter<span style="color: red;">*</span></label>
                                                <select name="chapter" class="form-control" id="chapter" required>
                                                    <?php foreach ($chapters as $key => $chapterName) { ?>
                                                        <option value="<?php echo $key; ?>" <?php echo ($key == $chapter) ? 'selected' : ''; ?>>
                                                            <?php echo $chapterName; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>


                                            <div class="form-group col-md-12">
                                                <label for="question">Question<span style="color: red;">*</span></label>
                                                <!-- <input type="text" name="question" value="<?php echo $question; ?> " class="form-control" id="question" placeholder="Enter Question" required> -->
                                                <textarea id="text_editor" name="question"><?php echo htmlspecialchars_decode($question); ?></textarea>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="marks">Marks<span style="color: red;">*</span></label>
                                                <input type="text" name="marks" value="<?php echo $marks; ?>" class="form-control" id="marks" required pattern="1|2" title="Only 1 or 2 is allowed">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="mcq_a">Option A<span style="color: red;">*</span></label>
                                                <input type="text" name="mcq_a" value="<?php echo $a; ?> " class="form-control" id="mcq_a" required>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="mcq_b">Option B<span style="color: red;">*</span></label>
                                                <input type="text" name="mcq_b" value="<?php echo $b; ?> " class="form-control" id="mcq_b" required>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="mcq_c">Option C<span style="color: red;">*</span></label>
                                                <input type="text" name="mcq_c" value="<?php echo $c; ?> " class="form-control" id="mcq_c" required>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="mcq_d">Option D<span style="color: red;">*</span></label>
                                                <input type="text" name="mcq_d" value="<?php echo $d; ?> " class="form-control" id="mcq_d" required>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-footer text-left">
                                        <input type="submit" name="submit" value="update" class="btn btn-primary">
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
<?php // } 
?>

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

<script type="text/javascript">
    var path = '<?php echo $base_url_question_paper; ?>';
    $(document).ready(function() {
        // Function to load subject codes based on selected parameters
        function loadSubjectCodes() {
            var faculty_id = $('#faculty_id').val();
            var level_id = $('#level_id').val();
            var program_id = $('#program_id').val();
            var sem = $('#sem').val();
            var subject_code = '<?php echo $subject_code; ?>'; // Get the subject code from PHP

            $.ajax({
                url: path + 'get_subject_codes.php',
                type: 'POST',
                data: {
                    faculty_id: faculty_id,
                    level_id: level_id,
                    program_id: program_id,
                    sem: sem,
                    subject_code: subject_code // Pass the subject code to the PHP script
                },
                success: function(response) {
                    // Populate the subject code dropdown with the fetched options
                    $('#subject_code_id').html(response);
                }
            });
        }

        // Call the function initially and whenever any of the selection changes
        loadSubjectCodes();

        $('#faculty_id, #level_id, #program_id, #sem').on('change', function() {
            loadSubjectCodes();
        });

    });
</script>

<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>

<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>