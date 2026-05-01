<?php
include '../include/checklogin.php';

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = $_POST['description'];
    $type_id = 10;

    // Prepare and execute SQL statement for inserting data into 'tbl_campus'
    $stmt = $con->prepare("INSERT INTO `tbl_campus`(type_id, title, description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $type_id, $title, $description);
    $result = $stmt->execute();
    $mm_id = $con->insert_id;

    // Set session status and code for success
    if ($_FILES['image_uploads']['error'] == 0) { // Check if file upload error is 0 (UPLOAD_ERR_OK)
        $targetDirectory = "../uploads/advance_laboratories/";
        $uploaded_image = upload_single_file($_FILES["image_uploads"], $targetDirectory, 1); // Upload single file

        // Check if image was uploaded successfully
        if ($uploaded_image['status'] == 200) {
            $file_name = $uploaded_image['message']; // Get uploaded file name
            $file_type = "image";
            $type = "advance_laboratories";

            // Prepare and execute SQL statement for inserting image data into 'tbl_site_photos'
            $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $mm_id, $type, $file_name, $file_type);
            $result = $stmt->execute();

            if ($result) {
                // Set session status and code for success
                $_SESSION['status'] = "Advance Laboratories inserted successfully";
                $_SESSION['status_code'] = "success";
                header("Location: advance_laboratories_view.php");
                exit;
            } else {
                // Set session status and code for error if database insertion failed
                $_SESSION['status'] = "Error: Failed to insert Advance Laboratories data";
                $_SESSION['status_code'] = "error";
                header("Location: advance_laboratories_view.php");
                exit;
            }
        } else {
            // Set session status and code for error if image upload failed
            $_SESSION['status'] = $uploaded_image['message'];
            $_SESSION['status_code'] = "error";
            header("Location: advance_laboratories_view.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
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
        <div id="status">&nbsp;</div>
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
                            <h1 class="m-0">Add Advance Laboratories</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Advance Laboratories</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">Add Advance Laboraotories</h3>
                                </div>
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="title">Title<span style="color: red;">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter project exhibition Title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="text_editor">Detailed Description
                                            </label>
                                            <textarea name="description" id="text_editor"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="image_uploads">Upload Advance Laboraotories Photos (Only Single Allowed)</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="image_uploads" name="image_uploads" >
                                                <label class="custom-file-label" for="image_uploads">Choose file</label>
                                            </div>
                                        </div>
                                        <div id="imgPreview"></div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <?php include '../include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>

    <!-- Scripts -->
    <?php include '../include/importjs.php'; ?>

    <!-- dropzonejs -->
    <script src="../../admin_assets/plugins/dropzone/min/dropzone.min.js"></script>

    <!-- Script for image preview -->
    <script>
        const input = document.getElementById('image_uploads');
        const preview = document.getElementById('imgPreview');

        input.addEventListener('change', () => {
            preview.innerHTML = ''; // Clear previous previews

            const files = input.files;
            if (!files) {
                console.error('No files selected.');
                return;
            }

            for (const file of files) {
                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.classList.add('preview-image');
                    img.style.width = 'auto'; // Set width
                    img.style.height = '150px'; // Set height
                    preview.appendChild(img);
                } else {
                    console.error('File is not an image:', file);
                }
            }
        });
    </script>
</body>

</html>