<?php
include '../include/checklogin.php';

if ($role_id == 8) {
    ///////////////////////////////////////////////////////////////////////////////// website admin  ///////////////////////////////////////////////////////////////
} else {

 } ?>
<?php
    if (isset($_POST['submit'])) {
       
           $description = $_POST['program_description'];
           $title = mysqli_real_escape_string($con, $_POST['title']);

      //     $title = validate_data($title);


        if (isset($_POST["submit"])) {

            $targetDirectory = "../uploads/international_cell/";
            $file_upload_status = upload_single_file($_FILES["image_upload"], $targetDirectory, 1);
            if ($file_upload_status['status'] == 200) {
            $type_id = 1;
                $img_name = $file_upload_status['message'];
                $stmt = $con->prepare("INSERT INTO `tbl_international_cell`(type_id,title,img_name,description)VALUES (?,?,?,?)");
                $stmt->bind_param("isss", $type_id,$title, $img_name, $description);
                $result = $stmt->execute();
              //  $id = $con->insert_id;
                if ($result) {
                    $_SESSION['status'] = "International Relation Cell Inserted Successfully";
                    $_SESSION['status_code'] = "success";

                    echo "<script>setTimeout(function(){window.location='international_cell_view.php'},1000);</script>";
                } else {
                    $_SESSION['status'] = "International Relation Cell Insertion Failed";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='international_cell_insert.php'},1000)</script>";
                }
            } else {
                // delete entry if get any update in upload
                $stmt = $con->prepare("DELETE FROM `tbl_international_cell` WHERE id = ?");
                $stmt->bind_param("i", $id);
                $result = $stmt->execute();
                $_SESSION['status'] = $file_upload_status['message'];
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='international_cell_insert.php'},1000)</script>";
                //error message popup
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

           <!-- CKeditor custom script -->
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
    <!-- /.CKeditor custom script -->

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
                                <h1 class="m-0">Add International  Relation Cell</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add International  Relation Cell</li>

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
                                        <h3 class="card-title">Add International  Relation Cell</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form id="quickForm" method="POST" enctype="multipart/form-data">

                                        <div class="card-body">
                                           <div class="form-group">
                                            <label for="name">Title<span style="color: red;">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title_id" placeholder="Enter International  Relation Cell Title" required>
                                           </div>

                                           <div name="image2" id="image2" class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload Image<span style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">

                                                            <input type="file" class="custom-file-input" id="image_upload" name="image_upload" required>
                                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                                file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group" id="imgPrev">
                                            </div>

                                            <div class="form-group">
                                            <label for="text_editor">Detailed Description
                                                <!-- <span style="color: red;">*</span> -->
                                            </label>
                                            <textarea name="program_description" id="text_editor"></textarea>
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


<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>
<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

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