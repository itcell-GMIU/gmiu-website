<?php
// Include the checklogin.php file
include '../include/checklogin.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/image-compressor.js/2.1.5/image-compressor.min.js"></script>

    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
</head>
<?php

if (isset($_GET['fdp_id']) && !empty($_GET['fdp_id'])) {

    $fdp_id = mysqli_real_escape_string($con, $_GET['fdp_id']);
    $fdp_id = only_digits($fdp_id);
    if ($fdp_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='fdp_view.php'},1000)</script>";
    }
    $cmd = "SELECT sp.id as fdp_id, sp.title as title , sp.description as fdp_description, site_photos.file_name as file_name FROM tbl_campus as sp
    LEFT JOIN tbl_site_photos site_photos on sp.id = site_photos.type_id WHERE sp.id = ?";
    $stmt = $con->prepare($cmd);
    $stmt->bind_param('i', $fdp_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {

        $fdp_id = $row['fdp_id'];
        $title = $row['title'];
        $fdp_description = !empty($row['fdp_description']) ? $row['fdp_description'] : "<b>N/A</b>";
        $file_name = $row['file_name'];
    }
}

?>

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
                            <h1 class="m-0">Edit fdp Activity</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit fdp Activity</li>

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
                                    <h3 class="card-title">Edit fdp Activity</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" action="fdp_update.php" enctype="multipart/form-data">
                                    <div class="card-body">
                                        
                                            <input type="hidden" name="fdp_id" value="<?php echo $fdp_id; ?>">

                                            <div class="form-group">
                                                <label for="title">Title <span style="color: red;">*</span> </label>
                                                <input  id="title" class="form-control" name="title" value="<?php echo $title; ?>" require>
                                            </div>
                                          
                                            <div class="form-group">
                                                <label for="description">Description <span style="color: red;">*</span> </label>
                                                <textarea id="description" class="ckeditor" name="description"><?php echo htmlspecialchars_decode($fdp_description); ?></textarea>
                                            </div>

                                            <div name="image1" id="image1" class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload Images<span style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="image_upload[]" id="image_upload" multiple  onchange="compressAndPreviewImages()">
                                                            <label class="custom-file-label" for="exampleInputFile">
                                                                Choose Images</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group" id="imgPrev">
                                            </div>
                                            <div name="image_display_main" id="image_display_main" class="form-group">
                                                <?php
                                                $status = 0;
                                                $type = "fdp";
                                                $cmd = $con->prepare("SELECT photos.file_name as file_name  FROM `tbl_site_photos` as photos  where  photos.type = ? and photos.type_id = ?");
                                                $cmd->bind_param("si", $type, $fdp_id);
                                                $cmd->execute();
                                                $result = $cmd->get_result();

                                                while ($row = $result->fetch_assoc()) {
                                                    $file_name  = !empty($row['file_name']) ? $row['file_name'] : "<b>N/A</b>";



                                                ?>
                                                    <input type="hidden" name="image_uploads" id="id" value="<?php echo $fdp_id; ?>">
                                                    <div name="image_display" id="image_display" class="form-group">
                                                        <img src="<?php echo "../uploads/fdp/" . "$file_name"; ?>" width="200" height="200">

                                                    </div>
                                                <?php
                                                } ?>
                                            </div>


                                            <div class="card-footer">
                                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </section>
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

<script>
    function compressAndPreviewImages() {
        const input = document.getElementById('image_upload');
        const preview = document.getElementById('imgPrev');

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
                // Compress the image
                new ImageCompressor(file, {
                    quality: 0.6, // Adjust the quality as needed
                    success(result) {
                        const img = document.createElement('img');
                        img.src = window.URL.createObjectURL(result);
                        img.style.width = '150px';
                        img.style.height = '150px';
                        img.style.marginLeft = '20px';
                        img.style.marginTop = '10px';
                        preview.appendChild(img);
                    },
                    error(e) {
                        console.error(e.message);
                    },
                });
            };

            reader.readAsDataURL(file);
        }
    }
</script>


<!-- Script for select2 -->
<script> 
$(document).ready(function() {
    $('.select2option').select2();
});
</script>