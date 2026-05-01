<?php
include '../include/checklogin.php';

// Check if the form was submitted

if (isset($_POST["submit"])) {

    // Get other form inputs and escape special characters
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $description = $_POST['description'];

    // Prepare and execute the SQL statement to insert data into the database
    $stmt = $con->prepare("INSERT INTO `tbl_faq_management`(faculty_id,level_id,faq_description)VALUES (?,?,?)");
    $stmt->bind_param("iis", $faculty_id, $level_id, $description);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = "FAQ Content Inserted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='faq_view.php'},1000);</script>";
    } else {
        // delete entry if get any update in upload

        $_SESSION['status'] = "FAQ Content  Inserted Successfully";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='faq_edit.php'},1000);</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
    <!-- dropzonejs -->
    <link rel="stylesheet" href="../../admin_assets/plugins/dropzone/min/dropzone.min.css">
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
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
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Add FAQ Content</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add FAQ Content</li>

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
                                    <h3 class="card-title">Add FAQ Content</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="faq" method="POST" enctype="multipart/form-data">

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Select Faculty<span style="color: red;"> *</span></label>
                                            <select class="form-control" name="faculty_id" required id="faculty_id">
                                                <option value="">---Select Faculty---</option>
                                                <?php
                                                $cmd = "SELECT id,name FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    $faculty_id = $row['faculty_id'];
                                                ?>
                                                    <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                        <?php echo $row['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Level<span style="color: red;"> *</span></label>
                                            <select name="level_id" id="level_id" class="form-control" required>
                                                <option value="">---Select Level---</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Detailed Description
                                                <!-- <span style="color: red;">*</span> -->
                                            </label>
                                            <textarea name="description" class="ckeditor" id="description"></textarea>
                                        </div>
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

    <!-- dropzonejs -->
    <script src="../../admin_assets/plugins/dropzone/min/dropzone.min.js"></script>
</body>

</html>

<!-- Script for select2 -->
<script>
    $(document).ready(function() {
        $('.select2option').select2();
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