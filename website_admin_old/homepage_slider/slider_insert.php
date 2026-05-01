<?php
include '../include/checklogin.php';

// Check if the form is submitted   
if (isset($_POST["submit"])) {
    $slider_img =  $_FILES['file_input'];
    $image_type = "slider_image";
      
// Check if the image type is 'slider_image'
    if ($image_type == 'slider_image') {
        if (isset($_FILES['file_input'])) {
            $targetDirectory = "../uploads/slider_image/";
            $file_upload_status = upload_single_file($_FILES["file_input"], $targetDirectory, 1); // Upload the single file using a custom function 'upload_single_file'
            // Check if the file upload was successful
            if ($file_upload_status['status'] == 200) {
                $file_name = $file_upload_status['message'];

                $stmt = $con->prepare("INSERT INTO `tbl_site_photos`(`type`, `file_name`)VALUES (?,?)");
                $stmt->bind_param("ss", $image_type, $file_name);
                $result = $stmt->execute();
                if ($result) {
                    $_SESSION['status'] = "Slider image Inserted Successfully";
                    $_SESSION['status_code'] = "success";
                    echo "<script>setTimeout(function(){window.location='slider_view.php'},1000);</script>";
                } else {
                    $_SESSION['status'] = "Slider image Insertion Failed";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='slider_insert.php'},1000)</script>";
                }
            } else {
                $_SESSION['status'] = $file_upload_status['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='slider_insert.php'},1000)</script>";
                //error message popup
            }
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
                            <h1 class="m-0">Add Homepage Slider</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Homepage Slider</li>

                            </ol>
                        </div><!-- /.col -->



                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <form method="POST" enctype='multipart/form-data' action="slider_insert.php">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- jquery validation -->
                                <div class="card card-gmiu">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Homepage Slider</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <div class="card-body">
                                        <label for="exampleInputFile">Upload Photos</label><span style="color: red;">
                                            *</span>
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="file_input"
                                                    id="file_input">
                                                <label class="custom-file-label" for="exampleInputFile">Choose
                                                    file</label>
                                            </div>
                                            <div class="input-group" id="imgPrev">
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" id="submit" name="submit"
                                                class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
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
</body>

</html>
<script>
$(document).ready(function() {
    {
        $("#image").hide();
        $("#videolink").hide();
    }
    $("#type").change(function() {
        var selectedOption = $(this).children("option:selected").val();
        if (selectedOption == "image") {
            $("#image").show();
            $("#videolink").hide();
            $("#file_input").prop('required', true);

        } else if (selectedOption == "video") {
            $("#image").hide();
            $('#imgPrev').hide();
            $("#videolink").show();
            $("#videolink").prop('required', true);
        }
    });
});
</script>
<script>
$(function() {
    bsCustomFileInput.init();
});
</script>


<script src="../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
const input = document.getElementById('file_input');
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