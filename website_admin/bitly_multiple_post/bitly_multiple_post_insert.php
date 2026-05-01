<?php
// Include the checklogin.php file
include '../include/checklogin.php';
// session_start();
// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Get the date and type of file from the form and escape them to prevent SQL injection
   
  //  $date = mysqli_real_escape_string($con, $_POST['date']);
    $type_file = "page";
    $page_name = $_POST['file_name'];
    $page_name = str_replace(' ','',$page_name);
   if ($type_file == 'page') {

        // Check if file_name already exists in tbl_bitly_post
        $stmt = $con->prepare("SELECT COUNT(*) FROM tbl_bitly_post WHERE name = ?");
        $stmt->bind_param("s", $page_name);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            // File name already exists
           // echo "File name already exists.";
            $_SESSION['status'] = 'File name already exists.';
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='bitly_multiple_post_view.php'},1000)</script>";
        } else {


        // Prepare and execute the SQL statement to insert a new record in the tbl_daily_post table for image
        $stmt = $con->prepare("INSERT INTO `tbl_bitly_post`(file_type, name)VALUES (?, ?)");
        $stmt->bind_param("ss", $type_file, $page_name);
        $result = $stmt->execute();

        

        // After retrieving the last inserted ID
        $type_id = $con->insert_id;
        

        // Check if files were uploaded
        if (isset($_FILES['file_input'])) {
            $targetDirectory = "../uploads/bitly_post/";
            $uploaded_images = upload_multiple_files($_FILES["file_input"], $targetDirectory, 1);
            
            // Check if the file upload was successful
            if ($uploaded_images['status'] == 200) {

                // Loop through the uploaded images and insert records in the tbl_site_photos table
            foreach ($uploaded_images['message'] as $file_name) {
                $file_type = "image";
                $type = "Bitly Multiple Post";
                $file_name = implode("",$file_name);
                $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $type_id, $type, $file_name, $file_type);
                // $result = $stmt->execute();
                if ($stmt->execute()) {
                    // $imageId = $stmt->insert_id;
                    // Create a new PHP page for the uploaded image
                    $newPage = "../../website/post/$page_name.php";
                    // Create the content for the new PHP page
                    $newPageContent = "<?php\n";
                    $newPageContent .= "include '../../common/globalvariable.php';\n";
                    $newPageContent .= "include '../../database/connect.php';\n";
                    $newPageContent .= "include '../../common/function.php';\n";
                    $newPageContent .= "include '../../common/validation.php';\n";

                    $newPageContent .= "// Fetch the current URL\n";
                    $newPageContent .= "\$currentUrl = \"http://\" . \$_SERVER['HTTP_HOST'] . \$_SERVER['REQUEST_URI'];\n";
                    $newPageContent .= "// Extract the last segment of the URL and remove the .php extension\n";
                    $newPageContent .= "\$urlSegments = explode('/', rtrim(\$_SERVER['REQUEST_URI'], '/'));\n";
                    $newPageContent .= "\$lastSegment = end(\$urlSegments);\n";
                    $newPageContent .= "\$lastSegmentName = basename(\$lastSegment, '.php');\n";
                    $newPageContent .= "// Output the current URL and last segment name\n";
                  //  $newPageContent .= "echo 'Current URL: ' . \$currentUrl . '<br>';\n";
                   // $newPageContent .= "echo 'Last segment name: ' . \$lastSegmentName . '<br>';\n";

                    $newPageContent .= "\$cmd = \$con->prepare('SELECT id FROM tbl_bitly_post WHERE name = ?');\n";
                    $newPageContent .= "\$cmd->bind_param('s', \$lastSegmentName);\n";
                    $newPageContent .= "\$cmd->execute();\n";
                    $newPageContent .= "\$photo_result = \$cmd->get_result();\n";
                    $newPageContent .= "\$row1 = \$photo_result->fetch_assoc(); \n";
                    $newPageContent .= "\$type_id = \$row1['id'];\n";
              //      $newPageContent .= "echo 'type: ' . \$type_id . '<br>';\n";

                    $newPageContent .= "\$imageFile = '../../website_admin/uploads/bitly_post/';\n";
                    $newPageContent .= "\$imagetype = 'Bitly Multiple Post';\n";
                    $newPageContent .= "\$cmd = \$con->prepare('SELECT photos.file_name AS file_name FROM `tbl_site_photos` AS photos WHERE photos.type_id = ? AND photos.type = ?');\n";
                    $newPageContent .= "\$cmd->bind_param('is', \$type_id, \$imagetype);\n";
                    $newPageContent .= "\$cmd->execute();\n";
                    $newPageContent .= "\$photo_result = \$cmd->get_result();\n";
                    $newPageContent .= "?>\n";
                    $newPageContent .= "<!DOCTYPE html>\n";
                    $newPageContent .= "<html lang='en'>\n";
                    $newPageContent .= "<head>\n";
                    $newPageContent .= "<meta charset='UTF-8'>\n";
                    $newPageContent .= "<meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
                    $newPageContent .= "<title>Centered Images</title>\n";
                    $newPageContent .= "<style>\n";
                    $newPageContent .= ".image-container {\n";
                    $newPageContent .= "   width: 100%;\n";
                    $newPageContent .= "  padding: 20px;\n";
                    $newPageContent .= "  display: flex;\n";
                    $newPageContent .= "  flex-direction: column;\n";
                    $newPageContent .= "  align-items: center;\n";
                    $newPageContent .= "}\n";
                    $newPageContent .= ".image-container img {\n";
                    $newPageContent .= "  width: 100%;\n";
                    $newPageContent .= "  margin: 10px 0;\n";
                    $newPageContent .= "}\n";
                    $newPageContent .= "@media (max-width: 768px) {\n";
                    $newPageContent .= "  .image-container {\n";
                    $newPageContent .= "    max-width: 100%;\n";
                    $newPageContent .= "  }\n";
                    $newPageContent .= "}\n";
                    $newPageContent .= "</style>\n";
                    $newPageContent .= "</head>\n";
                    $newPageContent .= "<body>\n";
                    $newPageContent .= "<div class='image-container'>\n";
                    $newPageContent .= "<?php\n";
                    $newPageContent .= "while (\$row = \$photo_result->fetch_assoc()) {\n";
                    $newPageContent .= "\$file_name = \$row['file_name'];\n";
                    $newPageContent .= "echo '<img src=\"' . \$imageFile . \$file_name . '\"  alt=\"Image\">';\n";
                    $newPageContent .= "}\n";
                    $newPageContent .= "?>\n";
                    $newPageContent .= "</div>\n";
                    $newPageContent .= "</body>\n";
                    $newPageContent .= "</html>\n";
    
                    file_put_contents($newPage, $newPageContent);
                  //  echo "Image uploaded and new page created: <a href='$newPage'>$newPage</a>";
                    }
                } 
            }else {
                    echo "Error inserting image details into the database.";
                }
            }

            $_SESSION['status'] = "Daily Post  Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='bitly_multiple_post_view.php'},1000);</script>";
        } 
        
    }
        
        else {
            // delete entry if have any error 
            $stmt = $con->prepare("DELETE FROM `tbl_bitly_post` WHERE id = ?");
            $stmt->bind_param("i", $type_id);
            $result = $stmt->execute();

            $_SESSION['status'] = $uploaded_images['message'];
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='bitly_multiple_post_view.php'},1000)</script>";
        }
    }


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

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
                            <h1 class="m-0">Add Multiple Post </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Multiple Post</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <form method="POST" enctype='multipart/form-data'>
                    <div class="container-fluid">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- jquery validation -->
                                <div class="card card-gmiu">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Multiple Post</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <div class="card-body">
                                        <!-- <div class="form-group">
                                            <label>Select Type of file<span style="color: red;"> *</span></label>
                                            <select id="type" onchange="insertContactfields()" class="form-control"
                                                name="type" required>
                                                <option value="">---Select File---</option>
                                                <option value="image">Image</option>
                                                <option value="video">Video</option>
                                            </select>
                                        </div> -->
                                        <!-- <div class="form-group">
                                            <label for="level_name">Date<span style="color: red;">*</span></label>
                                            <input type="date" name="date" class="form-control" id="title" required>
                                        </div> -->
                                        <div name="image" id="image" class="form-group">
                                            <div class="form-group">

                                                <label for="exampleInputFile">Upload Images(Multiple
                                                    Images)</label><span style="color: red;"> *</span>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="file_input[]"
                                                            id="file_input" multiple>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group" id="imgPrev">
                                        </div>
                                        <!-- <div class="table table-striped files" id="previews">
                                        </div> -->
                                        <div class="form-group" name="filename" id="filename">
                                            <label for="name">Name<span style="color: red;">*</span></label>
                                            <input type="text" name="file_name" class="form-control" id="file_name"
                                                placeholder="Enter File Name">
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" id="submit" name="submit"
                                                class="btn btn-primary">Submit</button>
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
$(document).ready(function() {
    {
        $("#image").hide();
        $("#videolink").hide();
    }
    $("#type").change(function() {
        var selectedOption = $(this).children("option:selected").val();
        if (selectedOption == "image") {
            $("#image").show();
            $("#videolink").hide();
            $("#file_input").prop('required', true);

        } else if (selectedOption == "video") {
            $("#image").hide();
            $('#imgPrev').hide();
            $("#videolink").show();
            $("#video_link").prop('required', true);
        }
    });
});
</script> -->
<script>
$(function() {
    bsCustomFileInput.init();
});
</script>


<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

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