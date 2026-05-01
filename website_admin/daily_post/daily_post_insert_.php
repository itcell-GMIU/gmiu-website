<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Get the date and type of file from the form and escape them to prevent SQL injection

    $date = mysqli_real_escape_string($con, $_POST['date']);
    $type_file = mysqli_real_escape_string($con, $_POST['type']);
    $faculty = mysqli_real_escape_string($con, $_POST['faculty']);

    // Extract the year and month from the date
    $s = $date;
    $year = strtok($s, '-');
    $month = strtok('-');

    // Check the type of file selected
    if ($type_file == 'video') {

         // Get the video link from the form
        $video_link = $_POST['video_link'];

        // Prepare and execute the SQL statement to insert a new record in the tbl_daily_post table for video
        $stmt = $con->prepare("INSERT INTO `tbl_daily_post`(date,file_type,file,year,month,faculty_id)VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("sssiii", $date, $type_file, $video_link, $year, $month, $faculty);
        $result = $stmt->execute();

        // Check if the insertion was successful
        if ($result) {
            $_SESSION['status'] = "Daily Post  Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='daily_post_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Daily Post  Inserted Successfully";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='daily_post_view.php'},1000)</script>";
        }
    } elseif ($type_file == 'image') {
        // Prepare and execute the SQL statement to insert a new record in the tbl_daily_post table for image
        $stmt = $con->prepare("INSERT INTO `tbl_daily_post`(date,file_type,year,month,faculty_id)VALUES (?,?,?,?,?)");
        $stmt->bind_param("ssiii", $date, $type_file, $year, $month ,$faculty);
        $result = $stmt->execute();

        //last inserted id
        $type_id = $con->insert_id;

        // Check if files were uploaded
        if (isset($_FILES['file_input'])) {
            $targetDirectory = "../uploads/daily_post/";
            $uploaded_images = upload_multiple_files($_FILES["file_input"], $targetDirectory, 1);
            
            // Check if the file upload was successful
            if ($uploaded_images['status'] == 200) {

                // Loop through the uploaded images and insert records in the tbl_site_photos table
            foreach ($uploaded_images['message'] as $file_name) {
                $file_type = "image";
                $type = "daily_post";
                $file_name = implode("",$file_name);
                $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $type_id, $type, $file_name, $file_type);
                $result = $stmt->execute();
            }

            $_SESSION['status'] = "Daily Post  Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='daily_post_view.php'},1000);</script>";
        } else {
            // delete entry if have any error 
            $stmt = $con->prepare("DELETE FROM `tbl_daily_post` WHERE id = ?");
            $stmt->bind_param("i", $type_id);
            $result = $stmt->execute();

            $_SESSION['status'] = $uploaded_images['message'];
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='daily_post_insert.php'},1000)</script>";
        }
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
                            <h1 class="m-0">Add Daily Post </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Daily Post</li>
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
                                        <h3 class="card-title">Add Daily Post</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <div class="card-body">
                                          <!-- form start -->
                                   
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="faculty">Select Faculty<span style="color: red;">
                                                        *</span></label>
                                                <select id="faculty" name="faculty" class="form-control" >
                                                    <option value="">---Select Faculty---</option>
                                                    <?php
                                                    // Fetch faculty names from the database
                                                    $query = "SELECT id, name FROM tbl_faculty where is_delete = '0' and is_active='1'";
                                                    $result = mysqli_query($con, $query);

                                                    // Check if records exist
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                                        }
                                                    } else {
                                                        echo "<option value=''>No Faculty Found</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Type of file<span style="color: red;"> *</span></label>
                                            <select id="type" onchange="insertContactfields()" class="form-control"
                                                name="type" required>
                                                <option value="">---Select File---</option>
                                                <option value="image">Image</option>
                                                <option value="video">Video</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="level_name">Date<span style="color: red;">*</span></label>
                                            <input type="date" name="date" class="form-control" id="title" required>
                                        </div>
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
                                        <div class="form-group" name="videolink" id="videolink">
                                            <label for="name">Video link (Embedded YouTube Video Link Only)<span
                                                    style="color: red;">*</span></label>
                                            <input type="text" name="video_link" class="form-control" id="video_link"
                                                placeholder="Enter video link">
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
<script>
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
</script>
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