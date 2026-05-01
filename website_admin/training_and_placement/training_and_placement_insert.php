<?php
include '../include/checklogin.php';

// Check if the form was submitted
if (isset($_POST["submit"])) {

    // Get other form inputs and escape special characters
  
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $department = mysqli_real_escape_string($con, $_POST['department']);


    
    $name = validate_data($name);
    $department = validate_data($department);


    $stmt = $con->prepare("INSERT INTO `tbl_tpa_coordinator`(name,department)VALUES (?,?)");
    $stmt->bind_param("ss",$name,$department);
    $result = $stmt->execute();
    $id = $con->insert_id;
    // Move uploaded report file to a directory
    if($_FILES['image_upload']['error'] == 0 )
    { 
            $targetDirectory = "../uploads/training_and_placement/";
            $file_upload_status = upload_single_file($_FILES["image_upload"], $targetDirectory, 1);
            if ($file_upload_status['status'] == 200) {
                $file_name = $file_upload_status['message'];
                $stmt = $con->prepare("UPDATE `tbl_tpa_coordinator` SET `img_name` = ? WHERE `tbl_tpa_coordinator`.`id` = ?");
                $stmt->bind_param("si",$file_name,$id);
                $result = $stmt->execute();
                     if ($result) {
                       $_SESSION['status'] = "Training and Placement Inserted Successfully";
                         $_SESSION['status_code'] = "success";
                     echo "<script>setTimeout(function(){window.location='training_and_placement_view.php'},1000);</script>";
                     } else {
                          // delete entry if get any update in upload
                    
                        $_SESSION['status'] = "Training and Placement Insertion Failed";
                         $_SESSION['status_code'] = "error";
                        echo "<script>setTimeout(function(){window.location='training_and_placement_insert.php'},1000)</script>"; 
                     }

                
            } else {
                  // delete entry if get any update in upload
                $stmt = $con->prepare("DELETE FROM `tbl_tpa_coordinator` WHERE id = ?");
                $stmt->bind_param("i", $id);
                $result = $stmt->execute();

                     $_SESSION['status'] = $file_upload_status['message'];
                     $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='training_and_placement_insert.php'},1000)</script>";
               //error message popup
            }
        }else{
            if ($result) {
                $_SESSION['status'] = "Training and Placement Inserted Successfully";
                  $_SESSION['status_code'] = "success";
              echo "<script>setTimeout(function(){window.location='training_and_placement_view.php'},1000);</script>";
              } else {
                  // delete entry if get any update in upload
                 $_SESSION['status'] = "Training and Placement Insertion Failed";
                  $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='training_and_placement_insert.php'},1000)</script>";
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
                            <h1 class="m-0">Add Training and Placement</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Training and Placement</li>

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
                                    <h3 class="card-title">Add Training and Placement</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="industryvisit_upload" method="POST" enctype="multipart/form-data">

                                    <div class="card-body">
                                        
                                        <div class="form-group">
                                            <label for="title_name">Name of staff<span style="color: red;">*</span></label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                placeholder="Enter Name of staff" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="title_name">Department<span style="color: red;">*</span></label>
                                            <input type="text" name="department" class="form-control" id="department"
                                                placeholder="Enter Department" required>
                                            </div>

                                      

                                        <div name="image1" id="image1" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Image</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            name="image_upload" id="image_upload" >
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
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