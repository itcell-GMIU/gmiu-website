<?php
include '../include/checklogin.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {

    $title = mysqli_real_escape_string($con, $_POST['title']); // Get the value of 'title' from the form and sanitize it using mysqli_real_escape_string
    // validate data
    $title = validate_data($title);

   
        $targetDirectory = "../uploads/brochure/thumbnail/";
         
        // Upload the 'thumbnail' file using a custom function 'upload_single_file'
        $file_upload_status = upload_single_file($_FILES["thumbnail"], $targetDirectory, 1);
        
        // Check if the file upload was successful
        if ($file_upload_status['status'] == 200) {
            $file_name = $file_upload_status['message'];
        }
    

        $targetDirectory = "../uploads/brochure/document/";

        // Upload the 'document' file using a custom function 'upload_single_file'
        $file_upload_status = upload_single_file($_FILES["document"], $targetDirectory, 0); 
       
        // Check if the file upload was successful
        if ($file_upload_status['status'] == 200) {
            $document = $file_upload_status['message'];
        }

        // Prepare the insert statement
        $stmt = $con->prepare("INSERT INTO `tbl_brochure`(title,thumbnail,document) VALUES (?,?,?)");
        $stmt->bind_param("sss", $title, $file_name, $document);
        $result = $stmt->execute();
        
        // Check if the insertion was successful
        if ($result) {
            $_SESSION['status'] = "E-Brochure Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='brochure_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "E-Brochure Details Insertion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='brochure_view.php'},1000)</script>";
        }
    
}

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
                            <h1 class="m-0">Add E-Brochure & Scope Documents</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add E-Brochure & Scope Documents</li>

                            </ol>
                        </div><!-- /.col -->



                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">Add E-Brochure & Scope Documents</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- form start -->
                                    <form id="quickForm" method="POST" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <label for="name">Title<span style="color: red;">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title_id" placeholder="Enter E-Brochure & Scope Documents Title" required>
                                        </div>

                                        <div name="image" id="image" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Thumbnail</label><span style="color: red;"> *</span>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail" required>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group" id="imgPrev">
                                        </div>

                                        <div name="document" id="document" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload document<span style="color: red;"> *</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="document" id="document" required>
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
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
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
    $(function() {
        bsCustomFileInput.init();
    });
</script>
<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
    const input = document.getElementById('thumbnail');
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