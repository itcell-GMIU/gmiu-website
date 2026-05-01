<?php
include '../include/checklogin.php';

// Check if the form is submitted  successfully 
if (isset($_POST['submit'])) {

    $program_id = $_POST['program_id'];
    $program_id = implode(',', $program_id);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    
    // Validate Data
    $type = validate_data($type);
    $photo = "";
    $stmt = $con->prepare("INSERT INTO `tbl_achievement`(photo,program_id,type)VALUES (?,?,?)");
    $stmt->bind_param("sss",$photo,$program_id, $type);
    $result = $stmt->execute();
    
    // Get the inserted ID
    $type_id = $con->insert_id;

    // for multiple image upload in site photos
    if (isset($_FILES['images']['tmp_name'])) {  // Check if any images are uploaded
        $targetDirectory = "../uploads/achievement/";
        $uploaded_images = upload_multiple_files($_FILES["images"], $targetDirectory, 1); // Upload the multiple images using a custom function 'upload_multiple_files'

        // Check if the image upload was successful
        if ($uploaded_images['status'] == 200) {
            // Loop through the uploaded images
            foreach ($uploaded_images['message'] as $file_name) {
                $file_type = "image";
                $type1 = "achievement";
                $file_name = implode("", $file_name);
                // Prepare the insert statement for site photos
                $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $type_id, $type1, $file_name, $file_type);
                $result = $stmt->execute();
            }

            $_SESSION['status'] = "Achievement Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='achievement_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = $uploaded_images['message'];
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='achievement_insert.php'},1000)</script>";
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
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
    <link rel="stylesheet" href="../admin_assets/plugins/dropzone/min/dropzone.min.css">

    <script type="text/javascript" src="../admin_assets/ckeditor/ckeditor.js"></script>
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
                            <h1 class="m-0">Add Achievement</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Achievement</li>

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
                                    <h3 class="card-title">Add Achievement</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">

                                    <div class="card-body">

                                    <div class="form-group">
                                            <label>Select program<span style="color: red;"> *</span></label>
                                            <!-- <div class="multi-select"> -->
                                            <div class="selected-items"></div>
                                            <select class="select2option" style="width: 100%" name="program_id[]" multiple="multiple" required>

                                                <?php
                                                $cmd = "SELECT pro.id,pro.name,level.name as level_name FROM tbl_program as pro LEFT JOIN tbl_faculty faculty
                                                ON pro.faculty_id = faculty.id LEFT JOIN tbl_level level
                                                ON pro.level_id = level.id WHERE pro.is_delete = 0 and pro.is_active=1 ";
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
                                            <label>Achievement<span style="color: red;"> *</span></label>
                                            <select id="type" onchange="insertContactfields()" class="form-control"
                                                name="type" required>
                                                <option value="">---Select Achievement---</option>
                                                <option value="student">Student Achievement</option>
                                                <option value="faculty">Faculty Achievement</option>
                                            </select>
                                        </div>

                                        <label for="exampleInputFile">Upload Image<span style="color: red;">*</span></label>
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="imgInp" name="images[]"
                                                    multiple required>
                                                <label class="custom-file-label" for="exampleInputFile">Choose
                                                    Image</label>
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
    <script src="../admin_assets/plugins/dropzone/min/dropzone.min.js"></script>
</body>

</html>
<!-- Script for select2 -->
<script>
    $(document).ready(function() {
        $('.select2option').select2();
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
