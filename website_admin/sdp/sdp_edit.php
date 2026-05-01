<?php
include '../include/checklogin.php';
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
    <style>
        #image_display_main {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
    </style>
</head>
<?php

if (isset($_GET['sdp_id'])) {
    if (isset($_GET['sdp_id']) && !empty($_GET['sdp_id'])) {
        $sdp_id = mysqli_real_escape_string($con, $_GET['sdp_id']);
        $sdp_id = only_digits($sdp_id);
        if ($sdp_id == false) {
            $_SESSION['status'] = "Invalid data in url";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='sdp_view.php'},1000)</script>";
        }

        $status = 0;
        $cmd = $con->prepare("SELECT sdp.level_id as level_id, sdp.id as sdp_id , sdp.date as date,
        sdp.faculty_id as faculty_id ,sdp.program_id as program_id , sdp.title as sdp_title, 
        sdp.description as sdp_description ,sdp.report as report_name, sdp.img_name as img_name, 
        faculty.name as faculty_name,  level.name as level_name ,program.name as program_name 
        FROM tbl_sdp as sdp  
        LEFT JOIN tbl_faculty faculty ON sdp.faculty_id = faculty.id 
        LEFT JOIN tbl_level level ON sdp.level_id = level.id
        LEFT JOIN tbl_program program ON sdp.program_id = program.id  WHERE sdp.is_delete = ? and sdp.id = ?");
        $cmd->bind_param("ii", $status, $sdp_id);
        $cmd->execute();
        $result = $cmd->get_result();
        while ($row = $result->fetch_assoc()) {
 
            // $program_id = $row['program_id'];
            $sdp_id = $row['sdp_id'];
            $sdp_title = $row['sdp_title'];
            $report_name = $row['report_name'];
            $img_name = $row['img_name'];
            $level_name = $row['level_name'];
            $program_id = $row['program_id'];
            $faculty_id = $row['faculty_id'];
            $level_id = $row['level_id'];
            $date = $row['date'];
            $sdp_description = $row['sdp_description'];
        }
    }
}
?>

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
                            <h1 class="m-0">Update SDP</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Update SDP</li>

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
                                    <h3 class="card-title">Update SDP</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" action="sdp_update.php" method="POST" enctype="multipart/form-data">

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
                                                <label>Select Level<span style="color: red;"> *</span></label>
                                                <div class="selected-items"></div>
                                                <select class="select2option" style="width: 100%" name="level_id[]" multiple="multiple" required>
                                                    <option value="">---Select level---</option>
                                                    <?php
                                                    // Prepare and execute the query to fetch level IDs from tbl_staff where faculty_id is a specific value
                                                    $cmd = "SELECT DISTINCT ts.level_id, tl.name FROM tbl_staff ts
                                                     INNER JOIN tbl_level tl ON ts.level_id = tl.id
                                                     WHERE ts.faculty_id = ?";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->bind_param("i", $faculty_id); // Assuming $faculty_id holds the faculty ID you want to filter by
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        // Check if the level ID exists in the array of selected level IDs or matches sdp.level_id
                                                        $selected = (in_array($row['level_id'], explode(',', $level_id)) || $row['level_id'] == $sdp['level_id']) ? 'selected' : '';
                                                    ?>
                                                        <option value="<?php echo $row['level_id'] ?>" <?php echo $selected ?>>
                                                            <?php echo $row['name'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label>Select Program<span style="color: red;"> *</span></label>

                                                <!-- <select name="program_id" id="program_id" class="form-control" required> -->
                                                <div class="selected-items"></div>
                                                <select class="select2option" style="width: 100%" name="program_id[]" multiple="multiple" required>

                                                    <option value="">---Select Program---</option>
                                                    <?php
                                                    $cmd = "SELECT id, name FROM tbl_program WHERE is_delete = '0' AND is_active = '1'";
                                                    // Fetch programs from tbl_staff table where program_id is available

                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $selected = (in_array($row['id'], explode(',', $program_id))) ? 'selected' : '';
                                                        // $selected = ($program_id == $row['id']) ? 'selected' : ''; // Check if the program is selected
                                                    ?>
                                                        <option value="<?php echo $row['id'] ?>" <?php echo $selected ?>>
                                                            <?php echo $row['name'] ?>
                                                        </option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <input type="hidden" name="id" id="id" value="<?php echo $sdp_id; ?>">
                                        <div class="form-group">
                                            <label for="name">Title<span style="color: red;">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title_id" value="<?php echo $sdp_title; ?>" placeholder="Enter SDP Title" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="level_name">Date<span style="color: red;">*</span></label>
                                            <input type="date" name="date" class="form-control" value="<?php echo $date; ?>" id="title" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Detailed Description
                                                <!-- <span style="color: red;">*</span> -->
                                            </label>
                                            <textarea name="description" class="ckeditor" id="description"><?php echo htmlspecialchars_decode($sdp_description); ?></textarea>
                                        </div>

                                        <div name="image1" id="image1" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Image</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="image_upload" id="image_upload">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group" id="imgPrev">
                                        </div>
                                        <div name="image_display_main" id="image_display_main" class="form-group">

                                            <div name="image_display" id="image_display" class="form-group">
                                                <img src="<?php echo "../uploads/sdp/image/" . "$img_name"; ?>" width="200" height="200">

                                            </div>

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
                                        <a href="<?php echo '../uploads/sdp/report/' . $report_name; ?>" class="btn btn-primary" target="_BLANK">View Report</a>
                                        <!-- <button type="button" ></button> -->
                                        <!-- </div> -->

                                    </div>


                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </div>
                            </div>
                        </div>
                        </form>
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
        $('#program_id').select2({
            placeholder: "---Select Program---",
            allowClear: true
        });
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
    const input = document.getElementById('image_upload');
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

<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>

<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
    $(document).ready(function() {
        {

            $("#image_display_main").show();
        }
        $("#image_upload").change(function() {
            var selectedOption = $(this).children("option:selected").val();

            $("#image_display_main").hide();


        });
    });
</script>