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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-selection__choice__display {
            color: #000000;
        }
    </style>
    <!-- /.CKeditor custom script -->
</head>
<?php
// Fetch program id and level id from display table
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='program_outcome_view.php'},1000)</script>";
    }
}
$cmd = $con->prepare("SELECT pro.id as id, pro.faculty_id as faculty_id, faculty.name as faculty_name, pro.level_id as level_id, pro.program_id as program_id, pro.title as program_title, pro.content as program_content, pro.is_active as program_is_active FROM tbl_program_outcome as pro 
LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id 
LEFT JOIN tbl_level level ON pro.level_id = level.id
LEFT JOIN tbl_program program ON pro.program_id = program.id WHERE pro.id =?");

$cmd->bind_param("i", $id);
$cmd->execute();
$result1 = $cmd->get_result();



while ($row = $result1->fetch_assoc()) {
    // Fetch data from database    
    $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
    $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
    $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
    $faculty_id = $row['faculty_id'];
    $level_id = $row['level_id'];
    $program_id = $row['program_id'];
    $program_title = !empty($row['program_title']) ? $row['program_title'] : 'N/A';
    $program_content = !empty($row['program_content']) ? $row['program_content'] : 'N/A';
    $program_is_active = $row['program_is_active'];
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
                            <h1 class="m-0">Edit Program Outcome</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Program Outcome</li>

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
                                    <h3 class="card-title">Edit Program Outcome</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" action="program_outcome_update.php">
                                    <div class="card-body">
                                        <?php if ($role_id != 8) { ?>
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
                                                <select name="program_id[]" id="program_id" class="form-control" required multiple>
                                                    <?php
                                                    $cmd = "SELECT * FROM tbl_program WHERE is_delete = '0' AND is_active='1'";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();

                                                    // Ensure $program_id is always an array
                                                    if (!is_array($program_id)) {
                                                        $program_id = explode(',', $program_id); // Convert comma-separated string to array
                                                    }

                                                    while ($row = $result->fetch_assoc()) {
                                                        $selected = in_array($row['id'], $program_id) ? "selected" : "";
                                                        echo "<option value='{$row['id']}' {$selected}>{$row['name']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        <?php } elseif ($role_id == 8) {
                                        ?>
                                            <div class="form-group">
                                                <label>Select level<span style="color: red;"> *</span></label>
                                                <select class="form-control" name="level_id" required id="level_id">
                                                    <option value="">---Select level---</option>
                                                    <?php
                                                    $cmd = "SELECT id,name FROM tbl_level WHERE id IN($level_id) and is_delete = '0' and is_active='1'";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $level_id = $row['level_id'];
                                                    ?>

                                                        <option value="<?php echo $row['id'] ?>" <?php if ($level_id == $row['id']) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                            <?php echo $row['name'] ?></option>
                                                    <?php } ?>

                                                </select>

                                            </div>
                                        <?php
                                        }
                                        ?>



                                        <input type="hidden" name="id" value="<?php echo $id ?>">
                                        <div class="form-group">
                                            <label for="title_id">Title<span style="color: red;">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title_id" value="<?php echo $program_title; ?>" placeholder="Enter program Outcome Name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="text_editor">Description </label>
                                            <textarea id="text_editor" name="program_description"><?php echo htmlspecialchars_decode($program_content); ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Status<span style="color: red;">*</span></label>
                                            <select class="form-control" name="program_status">
                                                <option value="1" <?php if ($program_is_active == "1") {
                                                                        echo "selected";
                                                                    } ?>>Active
                                                </option>
                                                <option value="0" <?php if ($program_is_active == "0") {
                                                                        echo "selected";
                                                                    } ?>>
                                                    InActive</option>

                                            </select>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
    $(document).ready(function() {
        $('#program_id').select2({
            placeholder: "---Select Program---",
            allowClear: true
        });
    });
</script>