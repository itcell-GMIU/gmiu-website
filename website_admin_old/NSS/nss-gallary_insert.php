<?php
include '../include/checklogin.php';

if (isset($_POST['submit'])) {

    $allowTypes = array('jpg', 'png', 'jpeg');
    $fileNames = array_filter($_FILES['images']['name']);
    $title = mysqli_real_escape_string($con, $_POST['title']);

    // Validate Data
    $title = validate_data($title);

    // $stmt = $con->prepare("INSERT INTO `tbl_nss_gallary` (title, file_name) VALUES (?,?)");
    // $stmt->bind_param("s", $title, $file_name);
    // $result = $stmt->execute();
    // $type_id = $con->insert_id;

    // for multiple image upload in site photos
    if (isset($_FILES['images']['tmp_name'])) {
        $targetDirectory = "../uploads/nss_gallary/image/";
        $uploaded_images = upload_multiple_files($_FILES["images"], $targetDirectory, 1);

        if ($uploaded_images['status'] == 200) {
            foreach ($uploaded_images['message'] as $file_name) {
                $file_type = "image";
                $type = "NSS";
                $file_name = implode("", $file_name);

                $stmt = $con->prepare("INSERT INTO `tbl_nss_gallary` (title, file_name) VALUES (?,?)");
                $stmt->bind_param("ss", $title, $file_name);
                $result = $stmt->execute();
                $type_id = $con->insert_id;
                
            }

            $_SESSION['status'] = "NSS Post Inserted Successfully";
            $_SESSION['status_code'] = "success";

            echo "<script>setTimeout(function(){window.location='nss-gallary_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = $uploaded_images['message'];
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='nss-gallary_insert.php'},1000)</script>";
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
                                <h1 class="m-0">Add NSS Post</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add NSS Post</li>

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
                                        <h3 class="card-title">Add NSS Post</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form id="quickForm" method="POST" enctype="multipart/form-data">
                                        <div class="card-body">
                                          

                                            <div class="form-group">
                                                <label for="name">Title<span style="color: red;">*</span></label>
                                                <input type="text" name="title" class="form-control" id="title_id" placeholder="Enter Our NSS Post Title" required>
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
