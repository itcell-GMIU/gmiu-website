<?php
include '../include/checklogin.php';

// Get the value of 'id' from the query string
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $paper_id = mysqli_real_escape_string($con, $_GET['id']);
    $paper_id = only_digits($paper_id);
    if ($paper_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='paper_view.php'},1000)</script>";
    }

    $status = 0;
    $cmd = $con->prepare("SELECT 
                       paper.id as paper_id, 
                       faculty.id as faculty_name,
                       level.id as level_name,
                       program.id as program_name,
                       paper.year as paper_year,
                       paper.sem as sem,
                       paper.session as paper_session,
                       paper.title as paper_title,
                       paper.document as paper_document, 
                       paper.is_active as paper_is_active 
                       FROM tbl_exam_paper as paper  
                       LEFT JOIN tbl_faculty as faculty ON paper.faculty_id = faculty.id 
                       LEFT JOIN tbl_level as level ON paper.level_id = level.id  
                       LEFT JOIN tbl_program as program ON paper.program_id = program.id  
                       WHERE paper.is_delete = ? AND paper.id = ?");
    $cmd->bind_param("ii", $status, $paper_id); // Bind the parameters for the prepared statement
    $cmd->execute(); // Get the result of the executed query
    $result = $cmd->get_result();
    while ($row = $result->fetch_assoc()) {
        // Loop through the result rows and assign values to variables
        $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
        $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
        $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
        $sem = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
        $paper_year = !empty($row['paper_year']) ? $row['paper_year'] : "<b>N/A</b>";
        $paper_session = !empty($row['paper_session']) ? $row['paper_session'] : "<b>N/A</b>";
        $paper_title = !empty($row['paper_title']) ? $row['paper_title'] : "<b>N/A</b>";
        $paper_document = !empty($row['paper_document']) ? $row['paper_document'] : "<b>N/A</b>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
</head>




<body class="hold-transition sidebar-mini layout-fixed">
    <div id="preloader">
        <div id="status">&nbsp;

        </div>
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
                            <h1 class="m-0">Edit Exam Paper</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Exam Paper</li>

                            </ol>
                        </div><!-- /.col -->



                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Exam Paper</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- form start -->
                                    <form id="quickForm" method="POST" action="paper_update.php" enctype="multipart/form-data">

                                        <input type="hidden" name="id" value="<?php echo $paper_id ?>">

                                        <div class="form-group">
                                            <label>Select Faculty</label>
                                            <select class="form-control" name="faculty_name" id="faculty_id">
                                                <?php
                                                $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {

                                                ?>

                                                    <option value="<?php echo $row['id'] ?>" <?php if ($faculty_name == $row['id']) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                        <?php echo $row['name'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Level</label>
                                            <select name="level_name" id="level_id" class="form-control" required>
                                                <?php
                                                $cmd = "SELECT * FROM tbl_level WHERE is_delete = '0' and is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {

                                                ?>

                                                    <option value="<?php echo $row['id'] ?>" <?php if ($level_name == $row['id']) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                        <?php echo $row['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Program</label>
                                            <select name="program_name" id="program_id" class="form-control" required>
                                                <?php
                                                $cmd = "SELECT * FROM tbl_program WHERE is_delete = '0' and is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {

                                                ?>

                                                    <option value="<?php echo $row['id'] ?>" <?php if ($program_name == $row['id']) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                        <?php echo $row['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
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
                                        <div class="form-group">
                                            <label for="name">Exam Year<span style="color: red;">*</span></label>
                                            <input type="text" name="year" class="form-control" id="year" placeholder="Enter Exam Year" value="<?php echo $paper_year ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Exam Session<span style="color: red;">*</span></label>
                                            <input type="text" name="session" class="form-control" id="session" placeholder="Enter Exam Session" value="<?php echo $paper_session ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Title<span style="color: red;">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title_id" placeholder="Enter Subject Title" value="<?php echo $paper_title ?>" required>
                                        </div>
                                        <div name="document" id="document" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload document<span style="color: red;"> *</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="document" id="document">
                                                        <label class="custom-file-label" for="exampleInputFile"><?php echo  $paper_document; ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="olddocument" value="<?php echo $paper_document; ?>">



                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
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

    });

    function load_level() {
        var path = '<?php echo $base_url_website_admin; ?>';
        var faculty_id = <?php echo $faculty_id; ?>;
        var level_id = <?php echo $level_id; ?>;

        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_id: level_id
            },
            success: function(result) {
                $('#level_id').html(result);

                // console.log(result);
            }
        });
    }
</script>
<script type="text/javascript">
    $('#faculty_id').on('change', function() {
        var path = '<?php echo "$base_url_website_admin"; ?>';
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
        var faculty_id = <?php echo $faculty_id; ?>;
        var level_id = <?php echo $level_id; ?>;

        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_id: level_id
            },
            success: function(result) {
                $('#level_id').html(result);

                // console.log(result);
            }
        });

    }

    function load_program() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo $faculty_id; ?>;
        var level_id = <?php echo $level_id; ?>;

        $.ajax({
            url: path + 'program.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_id: level_id
            },
            success: function(result) {
                $('#program_id').html(result);

                // console.log(result);
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
        /*  alert(level_id); */

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
                // console.log(data);
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

<script>
    const input = document.getElementById('thumbnail');
    const preview = document.getElementById('imgPrev');

    input.addEventListener('change', () => {
        while (preview.firstChild) {
            preview.removeChild(preview.firstChild);
        }

        const files = input.files;
        if (!files) {
            return;
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = () => {
                const img = document.createElement('img');
                img.src = reader.result;
                img.style.width = '150px';
                img.style.height = '150px';
                img.style.marginLeft = '20px';
                img.style.marginTop = '10px';
                preview.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    });
</script>