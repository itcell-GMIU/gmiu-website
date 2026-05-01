<?php
include '../include/checklogin.php';
if (isset($_POST['submit'])) {

    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = $_POST['description']; // New description field
    $date = $_POST['date'];
    $s = $date;
    $year = strtok($s, '-');
    $month = strtok('-');

    // Validate Data
    $title = validate_data($title);

    $stmt = $con->prepare("INSERT INTO `tbl_NSS`(report_title, date, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $date, $description);
    $result = $stmt->execute();
    $id = $con->insert_id;

    if ($result && $_FILES['report_upload']['error'] == 0 && !empty($_FILES['image_upload']['name'][0])) {

        $targetDirectory = "../uploads/NSS/report/";
        $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);

        if ($file_upload_status['status'] == 200) {
            $report_name = $file_upload_status['message'];
            $stmt = $con->prepare("UPDATE `tbl_NSS` SET `report` = ? WHERE `tbl_NSS`.`id` = ?");
            $stmt->bind_param("si", $report_name, $id);
            $stmt->execute();
        } else {
            $stmt = $con->prepare("DELETE FROM `tbl_NSS` WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $_SESSION['status'] = $file_upload_status['message'];
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='NSS_insert.php'},1000)</script>";
        }

        $targetDirectory = "../uploads/NSS/report_thumbnail/";
        foreach ($_FILES["image_upload"]["name"] as $key => $image) {
            if ($_FILES["image_upload"]["error"][$key] == 0) {
                $file_upload_status = upload_single_file([
                    "name" => $_FILES["image_upload"]["name"][$key],
                    "type" => $_FILES["image_upload"]["type"][$key],
                    "tmp_name" => $_FILES["image_upload"]["tmp_name"][$key],
                    "error" => $_FILES["image_upload"]["error"][$key],
                    "size" => $_FILES["image_upload"]["size"][$key],
                ], $targetDirectory, 1);

                if ($file_upload_status['status'] == 200) {
                    $image_name = $file_upload_status['message'];
                    $stmt = $con->prepare("INSERT INTO `tbl_nss_images` (nss_id, image) VALUES (?, ?)");
                    $stmt->bind_param("is", $id, $image_name);
                    $stmt->execute();
                }
            }
        }

        $_SESSION['status'] = "NSS Inserted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='NSS_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "NSS Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='NSS_insert.php'},1000)</script>";
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
                            <h1 class="m-0">Add NSS</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add NSS</li>

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
                                    <h3 class="card-title">Add NSS</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="name">Report Title<span style="color: red;">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title_id" placeholder="Enter NSS Report Title" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Description<span style="color: red;">*</span></label>
                                            <textarea name="description" class="form-control" id="description" placeholder="Enter Report Description" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="date">Date<span style="color: red;">*</span></label>
                                            <input type="date" name="date" class="form-control" id="date" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="report_upload">Upload Report<span style="color: red;">*</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="report_upload" id="report_upload" required>
                                                    <label class="custom-file-label" for="report_upload">Choose file</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="image_upload">Upload Image (Multiple Images)<span style="color: red;">*</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="image_upload[]" id="image_upload" multiple>
                                                    <label class="custom-file-label" for="image_upload">Choose files</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group" id="imgPrev"></div>

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