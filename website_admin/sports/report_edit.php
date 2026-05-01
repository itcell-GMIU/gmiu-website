<?php
include '../include/checklogin.php';
if (!isset($_GET['ssports_id'])) {
    $_SESSION['status'] = "No Report ID provided.";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='report_view.php'},1000);</script>";
    exit();
}

$report_id = intval($_GET['ssports_id']);

// Fetch report data
$stmt = $con->prepare("SELECT report_type, report_title, date, description, report FROM tbl_ssports WHERE id = ?");
$stmt->bind_param("i", $report_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $_SESSION['status'] = "Report not found.";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='report_view.php'},1000);</script>";
    exit();
}
$row = $result->fetch_assoc();

// Assign fetched values
$report_type = $row['report_type'];
$report_title = $row['report_title'];
$report_date = $row['date'];
$report_description = $row['description'];
$report_file = $row['report'];


if (isset($_POST['submit'])) {

    // Ensure report_type is being captured correctly
    if (isset($_POST['ssports_id']) && !empty($_POST['ssports_id'])) {
        $report_type = mysqli_real_escape_string($con, $_POST['ssports_id']);
    } else {
        $_SESSION['status'] = "Please select a valid Activity Type";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='ssports_update.php'},1000)</script>";
        exit();
    }

    // Get the other fields
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = $_POST['description'];
    $date = $_POST['date'];

    // Assume $id is the report id you want to update
    $id = $_POST['report_id'];

    // Validate data
    $title = validate_data($title);

    // Prepare the SQL statement for updating the existing record
    $stmt = $con->prepare("UPDATE `tbl_ssports` SET report_type=?, report_title=?, date=?, description=? WHERE id=?");
    $stmt->bind_param("ssssi", $report_type, $title, $date, $description, $id);
    $result = $stmt->execute();

    // Check for file uploads and update the report upload if necessary
    if ($_FILES['report_upload']['error'] == 0) {
        $targetDirectory = "../uploads/ssports/report/";
        $file_upload_status = upload_single_file($_FILES["report_upload"], $targetDirectory, 0);

        if ($file_upload_status['status'] == 200) {
            $report_name = $file_upload_status['message'];
            $stmt = $con->prepare("UPDATE `tbl_ssports` SET `report` = ? WHERE `id` = ?");
            $stmt->bind_param("si", $report_name, $id);
            $stmt->execute();
        } else {
            $_SESSION['status'] = $file_upload_status['message'];
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='ssports_update.php'},1000)</script>";
            exit();
        }
    }

    // Check if image uploads are available and update images
    if (!empty($_FILES['image_upload']['name'][0])) {
        $targetDirectory = "../uploads/ssports/report_thumbnail/";
        foreach ($_FILES["image_upload"]["name"] as $key => $image) {
            if ($_FILES["image_upload"]["error"][$key] == 0) {
                $file_upload_status = upload_single_file([
                    "name" => $_FILES["image_upload"]["name"][$key],
                    "type" => $_FILES["image_upload"]["type"][$key],
                    "tmp_name" => $_FILES["image_upload"]["tmp_name"][$key],
                    "error" => $_FILES["image_upload"]["error"][$key],
                    "size" => $_FILES["image_upload"]["size"][$key],
                ], $targetDirectory, 1);

                if ($file_upload_status['status'] == 200) {
                    $image_name = $file_upload_status['message'];
                    $stmt = $con->prepare("INSERT INTO `tbl_ssports_images` (ssports_id, image) VALUES (?, ?)");
                    $stmt->bind_param("is", $id, $image_name);
                    $stmt->execute();
                }
            }
        }
    }

    // Final success message
    if ($result) {
        $_SESSION['status'] = "sports_report Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='report_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "sports_report Update Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='ssports_update.php'},1000)</script>";
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
        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Update Sports Report</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Update Sports Report</li>
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
                            <!-- form start -->
                            <form id="quickForm" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="report_type">Type Of Activity<span style="color: red;">*</span></label>
                                      <select id="report_type" class="form-control" name="report_type" required>
                                        <option value="">---Select Activity Type---</option>
                                        <option value="Sports" <?php if ($report_type == 'Sports') echo 'selected'; ?>>Sports</option>
                                        <option value="Culture" <?php if ($report_type == 'Culture') echo 'selected'; ?>>Culture</option>
                                    </select>

                                    </div>
                                    <div class="form-group">
                                        <label for="name">Report Title<span style="color: red;">*</span></label>
                                      <input type="text" name="title" class="form-control" id="title_id" value="<?= htmlspecialchars($report_title); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description<span style="color: red;">*</span></label>
                                       <textarea name="description" class="ckeditor" id="description"><?= htmlspecialchars($report_description); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Date<span style="color: red;">*</span></label>
                                        <input type="date" name="date" class="form-control" id="date" value="<?= $report_date; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="report_upload">Upload Report<span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="report_upload" id="report_upload">
                                                <label class="custom-file-label" for="report_upload">Choose file</label>
                                            </div>
                                        </div>
                                         <?php if (!empty($report_file)): ?>
                                             <p>Current Report: <a href="../uploads/ssports/report/<?= $report_file; ?>" target="_blank"><?= $report_file; ?></a></p>
                                            <?php endif; ?>
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

                                    <!-- Hidden field for report ID -->
                                    <input type="hidden" name="report_id" value="<?= $report_id; ?>">

                                    <div class="input-group" id="imgPrev"></div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <?php include '../include/importfooter.php'; ?>
    </div>

    <?php include '../include/importjs.php'; ?>

    <!-- dropzonejs -->
    <script src="../../admin_assets/plugins/dropzone/min/dropzone.min.js"></script>

    <!-- File upload preview script -->
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
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.style.width = "100px";
                img.style.height = "100px";
                img.style.margin = "5px";
                preview.appendChild(img);
            }
        });
    </script>
</body>

</html>
