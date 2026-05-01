<?php
include '../include/checklogin.php';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


if ($role_id == 8) {
    if (isset($_POST["submit"])) {

        $level_id = $_POST['level_id'];

        $level_id = implode(',', $level_id);

        $program_id = $_POST['program_id'];

        $program_id = implode(',', $program_id);
        $date = mysqli_real_escape_string($con, $_POST['date']);
        $s = $date;
        $year = strtok($s, '-');
        $month = strtok('-');
        $description = $_POST['description'];
        $title = mysqli_real_escape_string($con, $_POST['title']);
        //$level_id = mysqli_real_escape_string($con, $_POST['level_id']);

        $title = validate_data($title);
        $date = validate_data($date);

        // fetch report
        $targetDirectory = "../uploads/workshop/reports/";
        $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);
        if ($file_upload_status['status'] == 200) {
            $file_name = $file_upload_status['message'];
        }


        $stmt = $con->prepare("INSERT INTO `tbl_workshop` (faculty_id,program_id,level_id,year, title, description, date) VALUES (?,?,?,?, ?, ?, ?)");
        $stmt->bind_param("issssss", $faculty_id, $program_id, $level_id, $year, $title, $description, $date);
        $result = $stmt->execute();
        $workshop_id = $con->insert_id;

        // check file is uploaded or not

        if ($_FILES['image_uploads']['error'][0]  == 0) {
            $targetDirectory = "../uploads/workshop/";
            $uploaded_images = upload_multiple_files($_FILES["image_uploads"], $targetDirectory, 1);

            if ($uploaded_images['status'] == 200) {
                foreach ($uploaded_images['message'] as $file_name) {
                    $file_type = "image";
                    $type = "workshop";
                    $file_name = implode("", $file_name);
                    $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $workshop_id, $type, $file_name, $file_type);
                    $result = $stmt->execute();
                }

                $_SESSION['status'] = "Workshop Inserted Successfully";
                $_SESSION['status_code'] = "success";

                echo "<script>setTimeout(function(){window.location='workshop_view.php'},1000);</script>";
            } else {

                $stmt = $con->prepare("DELETE FROM `tbl_workshop` WHERE id = ?");
                $stmt->bind_param("i", $workshop_id);
                $result = $stmt->execute();

                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='workshop_insert.php'},1000)</script>";
            }
        } else {
            if ($result) {
                $_SESSION['status'] = "Workshop Inserted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='industryvisit_view.php'},1000);</script>";
            } else {

                $_SESSION['status'] = "Workshop  Inserted Successfully";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='industryvisit_edit.php'},1000);</script>";
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
                                <h1 class="m-0">Add Workshop</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Workshop</li>

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
                                        <h3 class="card-title">Add Workshop</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form id="workshop_upload" method="POST" enctype="multipart/form-data">

                                        <div class="card-body">

                                            <div class="form-group">
                                                <label>Select level<span style="color: red;"> *</span></label>
                                                <div class="selected-items"></div>

                                                <select class="select2option" style="width: 100%" name="level_id[]" multiple="multiple">
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
                                                    $cmd = "SELECT p.id, p.name , l.name AS level_name from tbl_program AS p 
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
                                                <label for="title_name">Title<span style="color: red;">*</span></label>
                                                <input type="text" name="title" class="form-control" id="title" placeholder="Enter Workshop Title" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Detailed Description
                                                    <!-- <span style="color: red;">*</span> -->
                                                    <span style="color: red;">*</span>
                                                </label>
                                                <textarea name="description" class="ckeditor" id="description" required></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="level_name">Date<span style="color: red;">*</span></label>
                                                <input type="date" name="date" class="form-control" id="title" required>
                                            </div>

                                            <div name="image1" id="image1" class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload Images(Multipart Image)<span style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="image_uploads[]" id="image_uploads" multiple required>
                                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                                file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group" id="imgPrev">
                                            </div>


                                            <div class="card-footer">
                                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
<?php
} else {
    if (isset($_POST["submit"])) {

        $date = mysqli_real_escape_string($con, $_POST['date']);
        $s = $date;
        $year = strtok($s, '-');
        $month = strtok('-');
        $description = $_POST['description'];
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
        $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
        // $report_file = mysqli_real_escape_string($con, $_POST['report_file']);




        $title = validate_data($title);
        $date = validate_data($date);
        $faculty_id = validate_data($faculty_id);
        // $program_id = validate_data($program_id);
        //$level_id = validate_data($level_id);

        // fetch report
        // $targetDirectory = "../uploads/workshop/reports/";
        // $file_upload_status = upload_single_file($_FILES["report_uplode"], $targetDirectory, 0);
        // if ($file_upload_status['status'] == 200) {
        //     $report_file = $file_upload_status['message'];
        // }

        // insert data into database
        $stmt = $con->prepare("INSERT INTO `tbl_workshop` (faculty_id,program_id,level_id,year, title, description, date) VALUES (?,?,?,?, ?, ?, ?)");
        $stmt->bind_param("issssss", $faculty_id, $program_id, $level_id, $year, $title, $description, $date);
        $result = $stmt->execute();
        $workshop_id = $con->insert_id;

        // check file is uploaded or not

        if ($_FILES['image_uploads']['error'][0]  == 0) {
            $targetDirectory = "../uploads/workshop/";
            $uploaded_images = upload_multiple_files($_FILES["image_uploads"], $targetDirectory, 1);

            if ($uploaded_images['status'] == 200) {
                foreach ($uploaded_images['message'] as $file_name) {
                    $file_type = "image";
                    $type = "workshop";
                    $file_name = implode("", $file_name);
                    $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $workshop_id, $type, $file_name, $file_type);
                    $result = $stmt->execute();
                }

                $_SESSION['status'] = "Workshop Inserted Successfully";
                $_SESSION['status_code'] = "success";

                echo "<script>setTimeout(function(){window.location='workshop_view.php'},1000);</script>";
            } else {

                $stmt = $con->prepare("DELETE FROM `tbl_workshop` WHERE id = ?");
                $stmt->bind_param("i", $workshop_id);
                $result = $stmt->execute();

                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='workshop_insert.php'},1000)</script>";
            }
        } else {
            if ($result) {
                $_SESSION['status'] = "Workshop Inserted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='industryvisit_view.php'},1000);</script>";
            } else {

                $_SESSION['status'] = "Workshop  Inserted Successfully";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='industryvisit_edit.php'},1000);</script>";
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
                                <h1 class="m-0">Add Workshop</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Workshop</li>

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
                                        <h3 class="card-title">Add Workshop</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form id="workshop_upload" method="POST" enctype="multipart/form-data">

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
                                                <label for="title_name">Title<span style="color: red;">*</span></label>
                                                <input type="text" name="title" class="form-control" id="title" placeholder="Enter Workshop Title" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Detailed Description
                                                    <!-- <span style="color: red;">*</span> -->
                                                    <span style="color: red;">*</span>
                                                </label>
                                                <textarea name="description" class="ckeditor" id="description" required></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="level_name">Date<span style="color: red;">*</span></label>
                                                <input type="date" name="date" class="form-control" id="title" required>
                                            </div>

                                            <div name="image1" id="image1" class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload Images(Multipart Image)<span style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="image_uploads[]" id="image_uploads" multiple required>
                                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                                file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group" id="imgPrev">
                                            </div>
                                            <!--<div name="report" id="report" class="form-group">-->
                                            <!--    <div class="form-group">-->
                                            <!--        <label for="exampleInputFile">Upload Report</label>-->
                                            <!--        <div class="input-group">-->
                                            <!--            <div class="custom-file">-->
                                            <!--                <input type="file" class="custom-file-input" name="report_uplode" id="report_uplode">-->
                                            <!--                <label class="custom-file-label" for="exampleInputFile">Choose-->
                                            <!--                    file</label>-->
                                            <!--            </div>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--</div>-->

                                            <div class="card-footer">
                                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
        <script>
            $(function() {
                bsCustomFileInput.init();
            });
        </script>
        <script src="../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
        <script src="../../admin_assets/plugins/dropzone/min/dropzone.min.js"></script>
    </body>

    </html>
<?php
}
?>

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

<!-- <script>
    var img = document.forms['workshop_upload']['image_uploads'];
    var validExt = ["jpeg", "png", "jpg"];

    function validation() {
        if (img.value != '') {
            var img_ext = img.value.substring(img.value.lastIndexOf('.') + 1);
            var img_extlower = img_ext.toLowerCase()
            var result = validExt.includes(img_extlower);

            if (result == false) {
                alert("Selected Files is Not an Image....");
                return false;
            } else {
                if (parseFloat(img.files[0].size / (1024 * 1024)) >= 3) {
                    alert("File Size must be Smaller Than 3 MB. Current File Size : " + parseFloat(img.files[0].size / (
                        1024 * 1024)));
                    return false;
                }
            }
        }
        return true;
    }
</script> -->


<script>
    const input = document.getElementById('image_uploads');
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
<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>