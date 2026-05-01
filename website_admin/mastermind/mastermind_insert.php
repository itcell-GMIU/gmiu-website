<?php
// Include the checklogin.php file
include '../include/checklogin.php';
if (isset($_POST['submit'])) {

   
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $subtitle = mysqli_real_escape_string($con, $_POST['subtitle']);   
    $description = $_POST['description'];   
    $staff_id = mysqli_real_escape_string($con, $_POST['staff_id']);
   

    $staff_id = validate_data($staff_id);
    $type_id = 4;
    // Prepare and execute SQL statement for inserting data into 'tbl_campus'
    $stmt = $con->prepare("INSERT INTO `tbl_campus`(type_id,staff_id,title,subtitle,description)VALUES (?,?,?,?,?)");
    $stmt->bind_param("iisss",$type_id,$staff_id,$title,$subtitle,$description);
    $result = $stmt->execute();
    $mm_id = $con->insert_id;

    // Set session status and code for success
    if ($_FILES['image_uploads']['error'][0]  == 0) {
        $targetDirectory = "../uploads/mastermind/";
        $uploaded_images = upload_multiple_files($_FILES["image_uploads"], $targetDirectory, 1);

        // Check if images were uploaded successfully
        if ($uploaded_images['status'] == 200) {
            foreach ($uploaded_images['message'] as $file_name) {
                $file_type = "image";
                $type = "mastermind";
                $file_name = implode("", $file_name);
             
                // Prepare and execute SQL statement for inserting image data into 'tbl_site_photos'
                $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");

                $stmt->bind_param("ssss", $mm_id, $type, $file_name, $file_type);
                $result = $stmt->execute();
            }

            // Set session status and code for success
            $_SESSION['status'] = " mastermind Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='mastermind_view.php'},1000);</script>";
        } else {
            // Set session status and code for error if image upload failed
            $_SESSION['status'] = $uploaded_images['message'];
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='mastermind_view.php'},1000)</script>";
        }
    
    }
    else {
        if ($result) {
            // Set session status and code for success
            $_SESSION['status'] = "mastermind Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='mastermind_view.php'},1000);</script>";
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
                            <h1 class="m-0">Add Mastermind </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Mastermind </li>

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
                                    <h3 class="card-title">Add Mastermind </h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">

                                    <div class="card-body">

                                    
                                           <div class="form-group">
                                            <label for="name">Title<span style="color: red;">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter mastermind Title" required>
                                           </div>

                                           <div class="form-group">
                                            <label for="name">Sub Title<span style="color: red;">*</span></label>
                                            <input type="text" name="subtitle" class="form-control" id="subtitle" placeholder="Enter mastermind subtitle" required>
                                           </div>

                                           <div class="form-group">
                                            <label for="name">Professor Name<span style="color: red;">*</span></label>
                                            <select class="form-control" name="staff_id" required id="staff_id">
                                                    <option value="">---Select Professor---</option>
                                                    <?php
                                                    $cmd = "SELECT id,name FROM tbl_staff WHERE role_id IN (4, 8) and is_delete = '0' and is_active='1'";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $staff_id = $row['staff_id'];
                                                    ?>
                                                        <option value="<?php echo $row['id'] ?>" <?php if ($staff_id == $row['id']) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                            <?php echo $row['name'] ?></option>
                                                    <?php } ?>

                                                </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="description">Detailed Description
                                                <!-- <span style="color: red;">*</span> -->
                                            </label>
                                            <textarea name="description" class="ckeditor" id="description"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="fileupload">Upload mastermind Photo(Multiple Allowed)
                                                <!-- <span style="color: red;">*</span> -->
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="image_uploads" name="image_uploads[]" multiple>
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
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


<!-- Script for image preview -->
<script>
    // Function to create image element and append to preview
    function previewImage(file, previewElement) {
        const reader = new FileReader();
        reader.onload = () => {
            const img = document.createElement('img');
            img.src = reader.result;
            img.style.width = '150px';
            img.style.height = '150px';
            img.style.marginLeft = '20px';
            img.style.marginTop = '10px';
            previewElement.appendChild(img);
        };
        reader.readAsDataURL(file);
    }

   

    // Second script for image preview
    const input2 = document.getElementById('image_uploads');
    const preview2 = document.getElementById('imgPrev');

    input2.addEventListener('change', () => {
        while (preview2.firstChild) {
            preview2.removeChild(preview2.firstChild);
        }

        const files = input2.files;
        if (!files) {
            return;
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileExtension = file.name.split('.').pop().toLowerCase();
            if (fileExtension === 'jpg' || fileExtension === 'webp') { // Check for webp extension
                previewImage(file, preview2);
            }
        }
    });
</script>
