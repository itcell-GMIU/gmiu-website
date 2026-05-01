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
    $subjectId = $_GET['id'];
    $subjectId = only_digits($subjectId); // Corrected variable name

    if ($subjectId === false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='view_weightage.php'},1000)</script>";
    }
}


// $cmd = $con->prepare("SELECT sub.id as id, sub.faculty_id as faculty_id, sub.level_id as level_id, sub.program_id as 
// program_id, sub.sem as sem, sub.subject_code as subject_code, sub.chapter as chapter,
// sub.chapter_weight as chapter_weight, sub.bl_level as bl_level, sub.bl_weight as bl_weight FROM tbl_weightage as sub WHERE sub.id = ?");

$cmd = $con->prepare("SELECT std.id as id, 
corner.faculty_id as faculty_id, 
corner.level_id as level_id, 
corner.program_id as program_id, 
corner.sem as sem, 
std.subject_code as subject_code, 
std.chapter as chapter, 
std.chapter_weight as chapter_weight

FROM tbl_weightage as std
LEFT JOIN tbl_std_corner_exam AS corner ON std.subject_code = corner.id
LEFT JOIN tbl_faculty AS faculty ON corner.faculty_id = faculty.id 
LEFT JOIN tbl_level AS level ON corner.level_id = level.id 
LEFT JOIN tbl_program AS program ON corner.program_id = program.id 
WHERE std.is_delete = 0 And std.subject_code= ? ");
$cmd->bind_param("i", $subjectId);
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
    $subject_chapter[] = !empty($row['chapter']) ? $row['chapter'] : 'N/A';
    $chapter_weight[] = !empty($row['chapter_weight']) ? $row['chapter_weight'] : 'N/A';
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
// Array of chapters and Bloom's levels
$bloomLevels = array(
    "R" => "Remembering",
    "U" => "Understanding",
    "A" => "Applying",
    "N" => "Analyzing",
    "E" => "Evaluating",
    "C" => "Creating"
);

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
                            <h1 class="m-0">Edit Subject Weightage</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Subject Weightage</li>

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
                                    <h3 class="card-title">Edit Subject Weightage</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="update_weightage.php" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">

                                        <div class="form-group row">



                                            <input type="hidden" name="faculty_id" value="<?php echo $faculty_id; ?>">
                                            <input type="hidden" name="program_id" value="<?php echo $program_id; ?>">
                                            <input type="hidden" name="level_id" value="<?php echo $level_id; ?>">
                                            <input type="hidden" name="id" value="<?php echo $id; ?>">

                                            <div class="form-group col-md-6">
                                                <label>Select sem<span style="color: red;"> *</span></label>
                                                <select name="sem" id="sem" class="form-control" required >
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
                                                    $cmd2 = $con->prepare("SELECT * FROM tbl_std_corner_exam WHERE id = ? AND is_delete = '0'");
                                                    $cmd2->bind_param("i", $subject_code);
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


                                            <div class="form-group col-md-12">
                                                <h4>Chapter Weightage Details</h4>
                                                <hr>
                                                <input type="button" class="btn btn-primary" id="add-quali-field" value="Add More Chapter Details"><br /> <br />
                                               
                                               <?php


                                                // Check if chapters exist
                                                if (!empty($subject_chapter)) {
                                                    // Loop through all chapters
                                                    foreach ($subject_chapter as $index => $s_chapter) {
                                                ?>
                                                        <div class="form-group row" id="additional_fields_container">
                                                            <div class="form-group col-md-4">
                                                                <label for="chapter">Chapter<span style="color: red;">*</span></label>
                                                                <input type="text" name="chapter[]" value="<?php echo $s_chapter; ?>"class="form-control" id="chapter" required>
                                                                                                                                
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="chapter_weight">Chapter Weight (%)<span style="color: red;">*</span></label>
                                                                <input type="text" name="chapter_weight[]" value="<?php echo isset($chapter_weight[$index]) ? $chapter_weight[$index] : ''; ?>" class="form-control" id="chapter_weight" placeholder="Enter Chapter Weight" required>
                                                            </div>
                                                            <div class="form-group col-sm-2">
                                                                <button type="button" id="remove-quali-field" class="form-control btn btn-danger" style="margin-top: 32px;">Remove</button>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>

                                                    <!-- row -->
                                                    <div class="form-group row" id="additional_fields_container">
                                                        <div class="form-group col">
                                                            <label for="chapter">Chapter<span style="color: red;">*</span></label>
                                                            <select name="chapter[]" class="form-control" id="chapter" required>
                                                                <?php foreach ($chapters as $key => $chapter) { ?>
                                                                    <option value="<?php echo $key; ?>"><?php echo $chapter; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-md-5">
                                                            <label for="chapter_weight">Chapter Weight (%)<span style="color: red;">*</span></label>
                                                            <input type="text" name="chapter_weight[]" class="form-control" id="chapter_weight" placeholder="Enter Chapter Weight" required>
                                                        </div>

                                                        <div class="form-group col-sm-2">
                                                            <button type="button" id="remove-quali-field" class="form-control btn btn-danger" style="margin-top: 32px;">Remove</button>
                                                        </div>
                                                    </div>


                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>



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
</body>

</html>
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
    const addButton = document.getElementById('add-quali-field');

    addButton.addEventListener('click', function() {
        const rowDiv = document.getElementById('additional_fields_container');
        const clonedRow = rowDiv.cloneNode(true);
        const removeButton = clonedRow.querySelector('#remove-quali-field');

        removeButton.addEventListener('click', function() {
            const rowToRemove = this.parentNode.parentNode;
            rowToRemove.parentNode.removeChild(rowToRemove);
        });

        rowDiv.parentNode.appendChild(clonedRow);
    });
</script>




<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>

<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>