<?php
// Include the checklogin.php file
include '../include/checklogin.php';


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $type_id = mysqli_real_escape_string($con, $_POST['type']);
    $participants  = $_POST['participants']; // corrected the variable name
    $date = $_POST['date'];

    // Map type to type_id
    // $type_id = null;
    // if ($type === 'FDP') {
    //     $type_id = 1;
    // } elseif ($type === 'SDP') {
    //     $type_id = 2;
    // } elseif($type === 'workshops&seminars'){
    //     $type_id = 3;

    // }elseif ($type === 'Other Activities'){
    //     $type_id = 4;
    // }  
    // else {
    //     // Handle cases where the type is not recognized
    //     $_SESSION['status'] = "Invalid type provided.";
    //     $_SESSION['status_code'] = "error";
    //     echo "<script>setTimeout(function(){window.location='activities_insert.php'},1000)</script>";
    //     exit;
    // }

    if ($type_id !== null) {
        $targetDirectory = "../uploads/iksve_cell/";
        $file_upload_status = upload_single_file($_FILES["image_uploads"], $targetDirectory, 1);
        
        if ($file_upload_status['status'] == 200) {
            $img_name = $file_upload_status['message'];
            $stmt = $con->prepare("INSERT INTO `tbl_iksve_cell`(name, type_id, img_name, participants, date) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sisss", $name, $type_id, $img_name, $participants, $date);
            $result = $stmt->execute();

            if ($result) {
                $_SESSION['status'] = "Iksve Relation Cell Inserted Successfully";
                $_SESSION['status_code'] = "success";
                 echo "<script>setTimeout(function(){window.location='activities_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "Iksve Relation Cell Insertion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='activities_insert.php'},1000)</script>";
            }
        } else {
            // Handle file upload failure
            $_SESSION['status'] = $file_upload_status['message'];
            $_SESSION['status_code'] = "error";
             echo "<script>setTimeout(function(){window.location='activities_insert.php'},1000)</script>";
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
                            <h1 class="m-0">Add Acitivites</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Acitivites</li>

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
                                    <h3 class="card-title">Add Acitivites</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">

                                    <div class="card-body">

                                    
                                           <div class="form-group">
                                            <label for="name">Event Name<span style="color: red;">*</span></label>
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Event Name" required>
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
                                            <label for="name">Date <span style="color: red;">*</span></label>
                                            <input type="date" name="date" class="form-control" id="date" placeholder="Enter Date" required>
                                        </div>
                                            

                                        <div class="form-group">
                                            <label for="fileupload">Upload  Photo
                                                <!-- <span style="color: red;">*</span> -->
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="image_uploads" name="image_uploads" >
                                                <label class="custom-file-label" for="exampleInputFile">Choose
                                                    file</label>
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


<script>
    const input = document.getElementById('image_uploads');
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