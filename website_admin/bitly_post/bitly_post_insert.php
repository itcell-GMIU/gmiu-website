<?php
include '../include/checklogin.php';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


if (isset($_POST['submit'])) {
    
$type_file = mysqli_real_escape_string($con, $_POST['type']);
$name = $_POST['file_name'];

if ($type_file == 'pdf') {
    
    
   
          $path = "../uploads/bitly_post/";
          $name = $_POST['file_name'];
          // $type_file = $_POST['file_type'];
          $file_upload_status = upload_image_file($_FILES["pdf_input"], $path, 10, $name); // max_size_mb set to 1MB

          if ($file_upload_status['status'] == 200) {
              $file_name = $file_upload_status['message'];

              $stmt = $con->prepare("INSERT INTO tbl_bitly_post (file_type, file, name) VALUES (?, ?, ?)");
              $stmt->bind_param("sss", $type_file, $file_name, $name);
              $result = $stmt->execute();

              if ($result) {
                  $_SESSION['status'] = "Bitly Post Inserted Successfully";
                  $_SESSION['status_code'] = "success";
                  echo "<script>setTimeout(function(){window.location='bitly_post_view.php'}, 1000);</script>";
              } else {
                  $_SESSION['status'] = "Bitly Post Insertion Failed";
                  $_SESSION['status_code'] = "error";
                  echo "<script>setTimeout(function(){window.location='bitly_post_insert.php'}, 1000);</script>";
              }

              $stmt->close();
              $con->close();
          } else {
              $_SESSION['status'] = $file_upload_status['message'];
              $_SESSION['status_code'] = "error";
              echo "<script>setTimeout(function(){window.location='bitly_post_insert.php'}, 1000);</script>";
          }

} elseif ($type_file == 'image') {
    
        $path = "../uploads/bitly_post/";
        $name = $_POST['file_name'];
        $file_upload_status = upload_image_file($_FILES["file_input"], $path, 1, $name);
        if ($file_upload_status['status'] == 200) {
            $file_name = $file_upload_status['message'];
            
           // $extension = pathinfo($file_name,PATHINFO_EXTENSION);

          //  $newname = $name.'.'.$extension;


            $stmt = $con->prepare("INSERT INTO tbl_bitly_post (file_type, file, name) VALUES (?, ?, ?)");
              $stmt->bind_param("sss", $type_file, $file_name, $name);
            $result = $stmt->execute();
                 if ($result) {
                   $_SESSION['status'] = "Bitly Post Inserted Successfully";
                     $_SESSION['status_code'] = "success";
                   echo "<script>setTimeout(function(){window.location='bitly_post_view.php'},1000);</script>";
                 } else {
                    $_SESSION['status'] = "Bitly Post Insertion Failed";
                     $_SESSION['status_code'] = "error";
                     echo "<script>setTimeout(function(){window.location='bitly_post_insert.php'},1000)</script>";
                 }

            
        } else {
                 $_SESSION['status'] = $file_upload_status['message'];
                 $_SESSION['status_code'] = "error";
              echo "<script>setTimeout(function(){window.location='bitly_post_insert.php'},1000)</script>";
           //error message popup
        }
        // $file_name = $file_array[0]['name'];
        // print_r($file_array[0]['name']);
        
        
        // if ($result) {
        //     if ($result) {
        //         $_SESSION['status'] = "Media Coverage Inserted Successfully";
        //         $_SESSION['status_code'] = "success";
        //         echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000);</script>";
        //     } else {
        //         $_SESSION['status'] = "dailypost Insertion Failed";
        //         $_SESSION['status_code'] = "error";
        //         echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000)</script>";
        //     }
        // }

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
                            <h1 class="m-0">Add Bitly Post </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Bitly Post</li>
                            </ol>
                        </div><!-- /.col -->



                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <form id="post" name="post" method="POST" onsubmit="return validation()" method="POST" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- jquery validation -->
                                <div class="card card-gmiu">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Bitly Post</h3>
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
                                                <option value="pdf">PDF</option>
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


                                        <div class="form-group" name="pdflink" id="pdflink">
                                            <label for="name">PDF Input<span style="color: red;">*</span></label>
                                            <input type="file" name="pdf_input" class="form-control" id="pdf_input"
                                                placeholder="Enter PDF">
                                        </div>

                                        <div class="form-group" name="filename" id="filename">
                                            <label for="name">Name<span style="color: red;">*</span></label>
                                            <input type="text" name="file_name" class="form-control" id="file_name"
                                                placeholder="Enter PDF">
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
        $("#pdflink").hide();
    }
    $("#type").change(function() {
        var selectedOption = $(this).children("option:selected").val();
        if (selectedOption == "image") {
            $("#image").show();
            $("#filename").show();
            $("#pdflink").hide();

        } else if (selectedOption == "pdf") {
            $("#image").hide();
            $("#imgPrev").hide();
            $("#filename").show();
            $("#pdflink").show();
        }
    });
});
</script>
<script>
var img = document.forms ['post']['file_input'];
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