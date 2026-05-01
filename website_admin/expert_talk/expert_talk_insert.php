<?php
include '../include/checklogin.php';
// include '../../common/function.php';
if ($role_id == 8) {
    if (isset($_POST['submit'])) {

        $level_id = $_POST['level_id'];
        $level_id = implode(',', $level_id);
        $program_id = $_POST['program_id'];
        $program_id = implode(',', $program_id);
        
        $allowTypes = array('jpg', 'png', 'jpeg');
        $fileNames = array_filter($_FILES['images']['name']);
        $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $description = $_POST['description'];


        
        $date = $_POST['date'];
        $s = $date;
        $year = strtok($s, '-');
        $month = strtok('-');

        // Validate Data
       // $program_id = validate_data($program_id);
        $faculty_id = validate_data($faculty_id);
        $title = validate_data($title);

        // fetch report
        $targetDirectory = "../uploads/expert_talk/report/";
        $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);
        if ($file_upload_status['status'] == 200) {
            $file_name = $file_upload_status['message'];
        }
        
        $stmt = $con->prepare("INSERT INTO `tbl_expert_talk`(faculty_id,level_id,program_id,date,description,report_file,title)VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("issssss", $faculty_id, $level_id, $program_id, $date, $description, $file_name, $title);
        $result = $stmt->execute();
        $expert_talk_id = $con->insert_id;


        // for multiple image upload in site photos
        if (isset($_FILES['images']['tmp_name'])) {
            $targetDirectory = "../uploads/expert_talk/image/";
            $uploaded_images = upload_multiple_files($_FILES["images"], $targetDirectory, 1);

            if ($uploaded_images['status'] == 200) {
                foreach ($uploaded_images['message'] as $file_name) {
                    $file_type = "image";
                    $type = "expert_talk";
                    $file_name = implode("", $file_name);
                    $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $expert_talk_id, $type, $file_name, $file_type);
                    $result = $stmt->execute();
                }

                $_SESSION['status'] = "Expert Talk Inserted Successfully";
                $_SESSION['status_code'] = "success";

                echo "<script>setTimeout(function(){window.location='expert_talk_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='expert_talk_insert.php'},1000)</script>";
            }
        }
    }
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include '../include/importhead.php'; ?>

        <!-- Google Font: Source Sans Pro -->
        <?php include '../include/importcss.php'; ?>

        <style>
            p {
                margin: 0;
            }

            #upload__inputfile {
                width: 0.1px;
                height: 0.1px;
                opacity: 0;
                overflow: hidden;
                position: absolute;
                z-index: -1;
            }

            .upload__btn {
                display: inline-block;
                font-weight: 600;
                color: #fff;
                text-align: center;
                min-width: 116px;
                padding: 5px;
                transition: all 0.3s ease;
                cursor: pointer;
                border: 2px solid;
                background-color: #4045ba;
                border-color: #4045ba;
                border-radius: 10px;
                line-height: 26px;
                font-size: 14px;
            }

            .upload__btn:hover {
                background-color: unset;
                color: #4045ba;
                transition: all 0.3s ease;
            }

            .upload__btn-box {
                margin-bottom: 10px;
            }

            .upload__img-wrap {
                display: flex;
                flex-wrap: wrap;
                margin: 0 -10px;
            }

            .upload__img-box {
                width: 200px;
                padding: 0 10px;
                margin-bottom: 12px;
            }

            .upload__img-close {
                width: 24px;
                height: 24px;
                border-radius: 50%;
                background-color: rgba(0, 0, 0, 0.5);
                position: absolute;
                top: 10px;
                right: 10px;
                text-align: center;
                line-height: 24px;
                z-index: 1;
                cursor: pointer;
            }

            .upload__img-close:after {
                content: "✖";
                font-size: 14px;
                color: white;
            }

            .img-bg {
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                position: relative;
                padding-bottom: 100%;
            }
        </style>

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
                                <h1 class="m-0">Add Expert Talk</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Expert Talk</li>

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
                                        <h3 class="card-title">Add Expert Talk</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form id="quickForm" method="POST" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Select level<span style="color: red;"> *</span></label>
                                                <div class="selected-items"></div>
                                                <select class="select2option" style="width: 100%" name="level_id[]" multiple="multiple" >
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
                                            <div class="form-group">
                                            <label>Select program<span style="color: red;"> *</span></label>
                                            <!-- <div class="multi-select"> -->
                                            <div class="selected-items"></div>
                                            <select class="select2option" style="width: 100%" name="program_id[]" multiple="multiple" required>

                                              <?php
                                                $cmd= "SELECT p.id, p.name , l.name AS level_name from tbl_program AS p 
                                                INNER JOIN tbl_level AS l on p.level_id = l.id
                                                WHERE p.id IN ($program_id) AND p.is_delete = '0' AND p.is_active = '1' ";
                                                echo $program_id;
                                               // $cmd= "SELECT id,name from tbl_program where id IN ($program_id) and is_delete = '0' and is_active='1' ";
                                                // $cmd = "SELECT pro.id,pro.name,level.name as level_name FROM tbl_program as pro LEFT JOIN tbl_faculty faculty
                                                // ON pro.faculty_id = faculty.id LEFT JOIN tbl_level level
                                                // ON pro.level_id = level.id WHERE pro.is_delete = 0 and pro.is_active=1 ";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    $program_id = $row['id'];
                                                    $program_name = $row['name'];
                                                    $level_name = $row['level_name'];

                                             ?>
                                                    <option value="<?php echo $program_id; ?>">
                                                        <?php echo $program_name . "(" . $level_name . ")"; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                            <div class="form-group">
                                                <label for="name">Title<span style="color: red;">*</span></label>
                                                <input type="text" name="title" class="form-control" id="title_id" placeholder="Enter Expert Talk Title" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="level_name">Date<span style="color: red;">*</span></label>
                                                <input type="date" name="date" class="form-control" id="title" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Detailed Description
                                                    <!-- <span style="color: red;">*</span> -->
                                                </label>
                                                <textarea name="description" class="ckeditor" id="description"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="level_name">Upload Images(Multiple Allowed)<span style="color: red;">*</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="imgInp" name="images[]" multiple>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group" id="imgPrev">
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
                                            <div class="card-footer">
                                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
<?php


} else {
    if (isset($_POST['submit'])) {

        $allowTypes = array('jpg', 'png', 'jpeg');
        $fileNames = array_filter($_FILES['images']['name']);
        $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
        $program_id = mysqli_real_escape_string($con, $_POST['program_id']); 
        $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $description = $_POST['description'];

        $date = $_POST['date'];
        $s = $date;
        $year = strtok($s, '-');
        $month = strtok('-');

        // Validate Data
        $title = validate_data($title);

        // fetch report
        $targetDirectory = "../uploads/expert_talk/report/";
        $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);
        if ($file_upload_status['status'] == 200) {
            $file_name = $file_upload_status['message'];
        }

        $stmt = $con->prepare("INSERT INTO `tbl_expert_talk`(faculty_id,level_id,program_id,date,description,report_file,title)VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("iiissss", $faculty_id, $level_id, $program_id, $date, $description, $file_name, $title);
        $result = $stmt->execute();
        $expert_talk_id = $con->insert_id;


        // for multiple image upload in site photos
        if (isset($_FILES['images']['tmp_name'])) {
            $targetDirectory = "../uploads/expert_talk/image/";
            $uploaded_images = upload_multiple_files($_FILES["images"], $targetDirectory, 1);

            if ($uploaded_images['status'] == 200) {
                foreach ($uploaded_images['message'] as $file_name) {
                    $file_type = "image";
                    $type = "expert_talk";
                    $file_name = implode("", $file_name);
                    $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $expert_talk_id, $type, $file_name, $file_type);
                    $result = $stmt->execute();
                }

                $_SESSION['status'] = "Expert Talk Inserted Successfully";
                $_SESSION['status_code'] = "success";

                echo "<script>setTimeout(function(){window.location='expert_talk_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='expert_talk_insert.php'},1000)</script>";
            }
        }
    }
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include '../include/importhead.php'; ?>

        <!-- Google Font: Source Sans Pro -->
        <?php include '../include/importcss.php'; ?>

        <style>
            p {
                margin: 0;
            }

            #upload__inputfile {
                width: 0.1px;
                height: 0.1px;
                opacity: 0;
                overflow: hidden;
                position: absolute;
                z-index: -1;
            }

            .upload__btn {
                display: inline-block;
                font-weight: 600;
                color: #fff;
                text-align: center;
                min-width: 116px;
                padding: 5px;
                transition: all 0.3s ease;
                cursor: pointer;
                border: 2px solid;
                background-color: #4045ba;
                border-color: #4045ba;
                border-radius: 10px;
                line-height: 26px;
                font-size: 14px;
            }

            .upload__btn:hover {
                background-color: unset;
                color: #4045ba;
                transition: all 0.3s ease;
            }

            .upload__btn-box {
                margin-bottom: 10px;
            }

            .upload__img-wrap {
                display: flex;
                flex-wrap: wrap;
                margin: 0 -10px;
            }

            .upload__img-box {
                width: 200px;
                padding: 0 10px;
                margin-bottom: 12px;
            }

            .upload__img-close {
                width: 24px;
                height: 24px;
                border-radius: 50%;
                background-color: rgba(0, 0, 0, 0.5);
                position: absolute;
                top: 10px;
                right: 10px;
                text-align: center;
                line-height: 24px;
                z-index: 1;
                cursor: pointer;
            }

            .upload__img-close:after {
                content: "✖";
                font-size: 14px;
                color: white;
            }

            .img-bg {
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                position: relative;
                padding-bottom: 100%;
            }
        </style>

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
                                <h1 class="m-0">Add Expert Talk</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Expert Talk</li>

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
                                        <h3 class="card-title">Add Expert Talk</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form id="quickForm" method="POST" enctype="multipart/form-data">
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
                                                <label>Select Program<span style="color: red;"> *</span></label>
                                                <select name="program_id" id="program_id" class="form-control" required>
                                                    <option value="">---Select Program---</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">Title<span style="color: red;">*</span></label>
                                                <input type="text" name="title" class="form-control" id="title_id" placeholder="Enter Expert Talk Title" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="level_name">Date<span style="color: red;">*</span></label>
                                                <input type="date" name="date" class="form-control" id="title" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Detailed Description
                                                    <!-- <span style="color: red;">*</span> -->
                                                </label>
                                                <textarea name="description" class="ckeditor" id="description"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="level_name">Upload Images(Multiple Allowed)<span style="color: red;">*</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="imgInp" name="images[]" multiple>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group" id="imgPrev">
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
                                            <div class="card-footer">
                                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
<?php } ?>
<!-- Script for select2 -->
<script> 
$(document).ready(function() {
    $('.select2option').select2();
});
</script>

<script>
$(document).ready(function() {
    $('.select2option').select2().on('change', function() {
        var selectedLevels = $(this).val();
        console.log(selectedLevels); // This will log the array of selected level ids

        // If you want to store it globally for use elsewhere on the page
        window.selectedLevelIds = selectedLevels;

        // Example usage
        // You can now use window.selectedLevelIds anywhere in your JS code on this page
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
    const input = document.getElementById('imgInp');
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
