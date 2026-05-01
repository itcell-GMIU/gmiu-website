<?php
include '../include/checklogin.php';

if ($role_id == 8) {

    if (isset($_POST["submit"])) {
        $date = $_POST['date'];

        $level_id = $_POST['level_id'];
        $level_id = implode(',', $level_id);
        $program_id = $_POST['program_id'];
        $program_id = implode(',', $program_id);
        // Extract year and month from the date
        $s = $date;
        $year = strtok($s, '-');
        $month = strtok('-');

        // Get other form inputs and escape special characters
        $description = $_POST['description'];
        $title = $title = mysqli_real_escape_string($con, $_POST['title']);
        //$level_id = mysqli_real_escape_string($con, $_POST['level_id']);

        
            // Move uploaded report file to a directory
            $targetDirectory = "../uploads/industry_visit/report/";
            $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);
        
            // Check if the file was moved successfully
            if ($file_upload_status['status'] == 200) {
                $file_name = $file_upload_status['message'];
            } else {
                $stmt = $con->prepare("DELETE FROM `tbl_Industry_visit` WHERE id = ?");
                $stmt->bind_param("i", $type_id);
                $result = $stmt->execute();
        
                $_SESSION['status'] = $file_upload_status['message']; // Corrected variable name
                $_SESSION['status_code'] = "error";
                // Redirect to another page after a delay (uncomment this line if needed)
                 echo "<script>setTimeout(function(){window.location='industryvisit_insert.php'},1000)</script>";
            }
        // Prepare and execute the SQL statement to insert data into the database
        $stmt = $con->prepare("INSERT INTO `tbl_Industry_visit`(faculty_id,program_id,level_id,date,visit_year,visit_name,visit_description,report)VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("isssssss", $faculty_id, $program_id, $level_id, $date, $year, $title, $description, $file_name,);
        $result = $stmt->execute();
        $type_id = $con->insert_id;

        // Check if input for image upload is set
        if ($_FILES['image_upload']['error'][0]  == 0) {
            $targetDirectory = "../uploads/industry_visit/image/";
            // file move to target directory
            $uploaded_images = upload_multiple_files($_FILES["image_upload"], $targetDirectory, 1);
            // check file is uploaded successfully or not

            if ($uploaded_images['status'] == 200) {
                // check file is uploaded successfully or not
                foreach ($uploaded_images['message'] as $file_name) {

                    $file_type = "image";
                    $type = "industry_visit";
                    $file_name = implode("", $file_name);
                    // Insert image file data into the database
                    $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $type_id, $type, $file_name, $file_type);
                    $result = $stmt->execute();
                }

                $_SESSION['status'] = "Industry Visit  Inserted Successfully";
                $_SESSION['status_code'] = "success";
              echo "<script>setTimeout(function(){window.location='industryvisit_view.php'},1000);</script>";
            } else {
                // delete entry if get any update in upload
                $stmt = $con->prepare("DELETE FROM `tbl_Industry_visit` WHERE id = ?");
                $stmt->bind_param("i", $type_id);
                $result = $stmt->execute();

                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
              echo "<script>setTimeout(function(){window.location='industryvisit_insert.php'},1000)</script>";
            }
        } else {
            if ($result) {
                $_SESSION['status'] = "Industry Visit Inserted Successfully";
                $_SESSION['status_code'] = "success";
               echo "<script>setTimeout(function(){window.location='industryvisit_view.php'},1000);</script>";
            } else {
                // delete entry if get any update in upload

                $_SESSION['status'] = "Industry Visit  Inserted Successfully";
                $_SESSION['status_code'] = "error";
               echo "<script>setTimeout(function(){window.location='industryvisit_insert.php'},1000);</script>";
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
                                <h1 class="m-0">Add Industry Visit</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Industry Visit</li>

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
                                        <h3 class="card-title">Add Industry Visit</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form id="industryvisit_upload" method="POST" enctype="multipart/form-data">

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
                                                <label for="title_name">Title<span style="color: red;">*</span></label>
                                                <input type="text" name="title" class="form-control" id="title" placeholder="Enter Industry Visit Title" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Detailed Description
                                                    <!-- <span style="color: red;">*</span> -->
                                                </label>
                                                <textarea name="description" class="ckeditor" id="description"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="level_name">Date<span style="color: red;">*</span></label>
                                                <input type="date" name="date" class="form-control" id="title" required>
                                            </div>

                                            <div name="image1" id="image1" class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload Images<span style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="image_upload[]" id="image_upload" multiple required>
                                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                                file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group" id="imgPrev">
                                            </div>


                                            <div name="report" id="report" class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload Report<span style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="report_upload" id="report_upload" required>
                                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                                file</label>
                                                        </div>
                                                    </div>
                                                </div>
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
<?php
    ////////////////////////////////////////////////////////////////////////// website admin /////////////////////////////////////////////////////////////////////////////////
} else {
    // Check if the form was submitted

    if (isset($_POST["submit"])) {
        $date = $_POST['date'];

        // Extract year and month from the date
        $s = $date;
        $year = strtok($s, '-');
        $month = strtok('-');

        // Get other form inputs and escape special characters
        $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
        $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
        $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
        $description = $_POST['description'];
        $title = $title = mysqli_real_escape_string($con, $_POST['title']);

       
            // Move uploaded report file to a directory
            $targetDirectory = "../uploads/industry_visit/report/";
            $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);
            // Check if the file was moved successfully
            if ($file_upload_status['status'] == 200) {
                $file_name = $file_upload_status['message'];
            } else {
                $stmt = $con->prepare("DELETE FROM `tbl_Industry_visit` WHERE id = ?");
                $stmt->bind_param("i", $type_id);
                $result = $stmt->execute();

                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='industryvisit_insert.php'},1000)</script>";
            }
        
        // Prepare and execute the SQL statement to insert data into the database
        $stmt = $con->prepare("INSERT INTO `tbl_Industry_visit`(faculty_id,program_id,level_id,date,visit_year,visit_name,visit_description,report)VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("iiisssss", $faculty_id, $program_id, $level_id, $date, $year, $title, $description, $file_name,);
        $result = $stmt->execute();
        $type_id = $con->insert_id;

        // Check if input for image upload is set
        if ($_FILES['image_upload']['error'][0]  == 0) {
            $targetDirectory = "../uploads/industry_visit/image/";
            // file move to target directory
            $uploaded_images = upload_multiple_files($_FILES["image_upload"], $targetDirectory, 1);
            // check file is uploaded successfully or not

            if ($uploaded_images['status'] == 200) {
                // check file is uploaded successfully or not
                foreach ($uploaded_images['message'] as $file_name) {

                    $file_type = "image";
                    $type = "industry_visit";
                    $file_name = implode("", $file_name);
                    // Insert image file data into the database
                    $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $type_id, $type, $file_name, $file_type);
                    $result = $stmt->execute();
                }

                $_SESSION['status'] = "Industry Visit  Inserted Successfully";
                $_SESSION['status_code'] = "success";
               // echo "<script>setTimeout(function(){window.location='industryvisit_view.php'},1000);</script>";
            } else {
                // delete entry if get any update in upload
                $stmt = $con->prepare("DELETE FROM `tbl_Industry_visit` WHERE id = ?");
                $stmt->bind_param("i", $type_id);
                $result = $stmt->execute();

                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='industryvisit_insert.php'},1000)</script>";
            }
        } else {
            if ($result) {
                    $_SESSION['status'] = "Industry Visit Inserted Successfully";
                    $_SESSION['status_code'] = "success";
               echo "<script>setTimeout(function(){window.location='industryvisit_view.php'},1000);</script>";
            } else {
                // delete entry if get any update in upload

                $_SESSION['status'] = "Industry Visit  Inserted Successfully";
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
                                <h1 class="m-0">Add Industry Visit</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Industry Visit</li>

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
                                        <h3 class="card-title">Add Industry Visit</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form id="industryvisit_upload" method="POST" enctype="multipart/form-data">

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
                                                <input type="text" name="title" class="form-control" id="title" placeholder="Enter Industry Visit Title" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Detailed Description
                                                    <!-- <span style="color: red;">*</span> -->
                                                </label>
                                                <textarea name="description" class="ckeditor" id="description"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="level_name">Date<span style="color: red;">*</span></label>
                                                <input type="date" name="date" class="form-control" id="title" required>
                                            </div>

                                            <div name="image1" id="image1" class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload Images<span style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="image_upload[]" id="image_upload" multiple required>
                                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                                file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group" id="imgPrev">
                                            </div>


                                            <div name="report" id="report" class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload Report<span style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="report_upload" id="report_upload" required>
                                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                                file</label>
                                                        </div>
                                                    </div>
                                                </div>
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
<?php } ?>
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
    var img = document.forms['industryvisit_upload']['image_upload1'];
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
</script>
<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>
<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

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