<?php
include '../include/checklogin.php';

if (isset($_POST['submit'])) {
    // Sanitize and validate input
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $participants = mysqli_real_escape_string($con, $_POST['participants']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $date = $_POST['date'];

    // Insert event details
    $stmt = $con->prepare("INSERT INTO `tbl_iksve_cell` (name, date, type_id, participants, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $date, $type, $participants, $description);
    $result = $stmt->execute();
    $id = $con->insert_id; // Get the last inserted ID

    if ($result) {
        // File upload directories
        $reportDirectory = "../uploads/iksve_cell/";
        $imageDirectory = "../uploads/iksve_cell/";

        // Upload report
        if ($_FILES['report_upload']['error'] == 0) {
            $report_upload_status = upload_single_file($_FILES['report_upload'], $reportDirectory, 0);

            if ($report_upload_status['status'] == 200) {
                $report_name = $report_upload_status['message'];
                $stmt = $con->prepare("UPDATE `tbl_iksve_cell` SET `report` = ? WHERE `id` = ?");
                $stmt->bind_param("si", $report_name, $id);
                $stmt->execute();
            } 
        }
                // Upload images
                if (isset($_FILES['image_upload']['name'][0]) && !empty($_FILES['image_upload']['name'][0])) {
                    // Use the upload_multiple_files function to handle all images at once
                    $uploadedImages = upload_multiple_files($_FILES['image_upload'], $imageDirectory, 1);

                    if ($uploadedImages['status'] === 200) {
                        foreach ($uploadedImages['message'] as $image) {
                            $image_name = $image['name'];
                            $imageStmt = $con->prepare("INSERT INTO tbl_iksve_cell_images (iksve_cell_id, image) VALUES (?, ?)");
                            $imageStmt->bind_param("is", $id, $image_name);
                            if (!$imageStmt->execute()) {
                                $_SESSION['status'] = "Failed to save image: " . $imageStmt->error;
                                $_SESSION['status_code'] = "error";
                                header("Location: activitie_view.php");
                                exit();
                            }
                        }
                    } else {
                        $_SESSION['status'] = $uploadedImages['message'];
                        $_SESSION['status_code'] = "error";
                        header("Location: activitie_view.php");
                        exit();
                    }
                }


        // Success
        $_SESSION['status'] = "IKSVE Cell Inserted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='activitie_view.php'},1000);</script>";
    } else {
        // Insertion failed
        $_SESSION['status'] = "IKSVE Cell Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='activitie_insert.php'},1000);</script>";
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
                            <h1 class="m-0">Add IKSVE</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add IKSVE</li>

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
                                    <h3 class="card-title">Add IKSVE</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="name">Event Name <span style="color: red;">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title_id" placeholder="Activities Name" required>
                                        </div>
                                        <div class="form-group">
                                                <label for="event-type">Event Type<span style="color: red;">*</span></label>
                                                <select name="type" class="form-control" id="event-type" required>
                                                    <option value="" disabled selected>Select Event Type</option>
                                                    <option value="1">FDP</option>
                                                    <option value="2">SDP</option>
                                                    <option value="3">Workshops & Seminars</option>
                                                    <option value="4">Other Activities</option>
                                                </select>
                                            </div>

                                           <div class="form-group">
                                            <label for="name">Participants<span style="color: red;">*</span></label>
                                            <input type="text" name="participants" class="form-control" id="participants" placeholder="Enter Participants" required>
                                           </div>
                                        <div class="form-group">
                                            <label for="description">Description<span style="color: red;">*</span></label>
                                            <textarea name="description" class="form-control" id="description" placeholder="Enter Report Description"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="date">Date<span style="color: red;">*</span></label>
                                            <input type="date" name="date" class="form-control" id="date" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="report_upload">Upload Report (Upload Report Only under 1000 KB)<span style="color: red;">*</span></label>
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