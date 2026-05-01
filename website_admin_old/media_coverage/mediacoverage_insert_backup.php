<?php
include '../include/checklogin.php';
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
                            <h1 class="m-0">Add Media Coverage </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Media Coverage</li>
                            </ol>
                        </div><!-- /.col -->



                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <form id="post" name="post" method="POST" onsubmit="return validation()" method="POST"
                    enctype='multipart/form-data' action="mediacoverage_upload.php">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- jquery validation -->
                                <div class="card card-gmiu">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Media Coverage</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Select Type of file<span style="color: red;"> *</span></label>
                                            <select id="type" onchange="insertContactfields()" class="form-control"
                                                name="type" required>
                                                <option value="">---Select File---</option>
                                                <option value="image">Image</option>
                                                <option value="video">Video</option>
                                            </select>
                                        </div>
                                        
                                        <div name="image" id="image" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">File input</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="file_input"
                                                            id="file_input">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group" id="imgPrev">
                                        </div>


                                        <div class="form-group" name="videolink" id="videolink">
                                            <label for="name">video link<span style="color: red;">*</span></label>
                                            <input type="text" name="videolink" class="form-control" id="videolink"
                                                placeholder="Enter video link">
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
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

<!-- <script>
imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
        blah.src = URL.createObjectURL(file)
    }
}
</script> -->
<script>
$(document).ready(function() {
    {
        $("#image").hide();
        // $("#imgPrev").hide();
        $("#videolink").hide();
    }
    $("#type").change(function() {
        var selectedOption = $(this).children("option:selected").val();
        if (selectedOption == "image") {
            $("#image").show();
            $("#videolink").hide();

        } else if (selectedOption == "video") {
            $("#image").hide();
            $("#imgPrev").hide();
            $("#videolink").show();
        }
    });
});
</script>
<script>
var img = document.forms['post']['file_input'];
var validExt = ["jpeg", "png", "jpg", "webp"];

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