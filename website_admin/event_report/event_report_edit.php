<?php
include '../include/checklogin.php';

// Get event ID from URL or form submission
$event_id = isset($_GET['id']) ? $_GET['id'] : null;

// Initialize $event_data to avoid undefined variable errors
$event_data = null;

if ($event_id) {
    // Retrieve existing event data from the database
    $stmt = $con->prepare("SELECT * FROM tbl_event_report WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Fetch event data if the query was successful
        $event_data = $result->fetch_assoc();
    } else {
        // Handle case where no data is returned (event does not exist)
        $_SESSION['status'] = "Event report not found.";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000);</script>";
        exit;
    }
} else {
    // If no event ID is provided, handle the error
    $_SESSION['status'] = "Invalid event ID.";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000);</script>";
    exit;
}

// Check if the form was submitted
if (isset($_POST["submit"])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = $_POST['description'];
    $date = $_POST['date'];
    
     if($_FILES['image_upload']['error'][0]  == 0)
        {
                //delete tbl_site photos
                $type = "event_report";
                $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? and type = ?  ");
                $stmt->bind_param("is", $event_id, $type);
                $result = $stmt->execute();
                 // Check if photos are deleted
                if($result)
                {
                    $targetDirectory = "../uploads/event_report/image/";
                     // Upload new photos
                    $uploaded_images = upload_multiple_files($_FILES["image_upload"], $targetDirectory, 1);
        
                    if ($uploaded_images['status'] == 200) {
                        foreach ($uploaded_images['message'] as $file_name) {
                            $file_type = "image";
                            $type = "event_report";
                            $file_name = implode("", $file_name);
                            $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $event_id, $type, $file_name, $file_type);
                            $result = $stmt->execute(); // Upload new photos

                        }

                    } else {
                        $_SESSION['status'] = $uploaded_images['message'];
                        $_SESSION['status_code'] = "error";
                       echo "<script>setTimeout(function(){window.location='event_report_edit.php'},1000)</script>";
                    }
                }
                else
                { 
                    $_SESSION['status'] = "Report Update Failed ";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='event_report_edit.php'},1000);</script>";
                }
        }


    // Handle report upload
    $targetDirectory = "../uploads/event_report/report/";
    if (!empty($_FILES["report_upload"]["name"])) {
        $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);
        if ($file_upload_status['status'] == 200) {
            $file_name = $file_upload_status['message'];
        } else {
            $_SESSION['status'] = $file_upload_status['message'];
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='event_report_edit.php?id=$event_id'},1000);</script>";
            exit;
        }
    } else {
        $file_name = $_POST['existing_report'];
    }
    
    

    // Update the event report in the database
    $stmt = $con->prepare("UPDATE tbl_event_report SET event_name = ?, event_description = ?, date = ?, report = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $title, $description, $date, $file_name, $event_id);
    $result = $stmt->execute();

    if ($result) {
        // Success: Redirect to the event report view page
        $_SESSION['status'] = "Event Report Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000);</script>";
        exit;
    } else {
        // Error: Display an error message and stay on the same page
        $_SESSION['status'] = "Failed to update the event report.";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='event_report_edit.php?id=$event_id'},1000);</script>";
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
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

        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit Event Report</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Event Report</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Event Report</h3>
                                </div>

                                <form id="event_report_upload" method="POST" enctype="multipart/form-data">

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="title_name">Title<span style="color: red;">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title" value="<?php echo $event_data['event_name']; ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Detailed Description</label>
                                            <textarea name="description" class="ckeditor" id="description"><?php echo htmlspecialchars_decode($event_data['event_description']); ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="level_name">Date<span style="color: red;">*</span></label>
                                            <input type="date" name="date" class="form-control" id="date" value="<?php echo $event_data['date']; ?>" required>
                                        </div>

                                        <div name="image1" id="image1" class="form-group">
                                            <label for="image_upload">Upload New Images (optional)</label>
                                            <input type="file" class="form-control" name="image_upload[]" id="image_upload" multiple>
                                            <div id="imgPrev"></div>
                                        </div>

                                        <div name="report" id="report" class="form-group">
                                            <label for="report_upload">Upload New Report (optional)</label>
                                            <input type="file" class="form-control" name="report_upload" id="report_upload">
                                            <input type="hidden" name="existing_report" value="<?php echo $event_data['report']; ?>">
                                            <p>Current Report: <?php echo $event_data['report']; ?></p>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>

        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <?php include '../include/importjs.php'; ?>
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