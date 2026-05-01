<?php
include '../include/checklogin.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='dailytask_view.php'},1000)</script>";
        exit();
    }

    // Fetch existing task data
    $stmt = $con->prepare("SELECT * FROM tbl_daily_task WHERE id = ? AND is_delete = 0");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $task_result = $stmt->get_result();
    $task_data = $task_result->fetch_assoc();

    if (!$task_data) {
        $_SESSION['status'] = "Task not found";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='dailytask_view.php'},1000)</script>";
        exit();
    }

    // Fetch existing photos
    $type = "dailytask_add";
    $photo_stmt = $con->prepare("SELECT file_name FROM tbl_inquiry_photos WHERE type_id = ? AND type = ?");
    $photo_stmt->bind_param("is", $id, $type);
    $photo_stmt->execute();
    $photo_result = $photo_stmt->get_result();
    $existing_photos = [];
    while ($row = $photo_result->fetch_assoc()) {
        $existing_photos[] = $row['file_name'];
    }
}

if (isset($_POST['submit'])) {
    // Sanitize form data
    $task_date = mysqli_real_escape_string($con, $_POST['task_date']);
    $time_slot = mysqli_real_escape_string($con, $_POST['time_slot']);
    $task_description = mysqli_real_escape_string($con, $_POST['task_description']);
    $staff_id = $_SESSION['staff_id'];

    // Update data in tbl_daily_task
    $stmt = $con->prepare("UPDATE tbl_daily_task SET task_date = ?, time_slot = ?, task_description = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("sssi", $task_date, $time_slot, $task_description, $id);

    if ($stmt->execute()) {
        // Handle multiple file uploads
        if (isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name'][0])) {
            $targetDirectory = "../uploads/task_images/";
            // Fetch existing photos to delete
            $existing_files_stmt = $con->prepare("SELECT file_name FROM tbl_inquiry_photos WHERE type_id = ? AND type = ?");
            $existing_files_stmt->bind_param("is", $id, $type);
            $existing_files_stmt->execute();
            $existing_files_result = $existing_files_stmt->get_result();
        
            // Delete existing files from the server
            while ($existing_file = $existing_files_result->fetch_assoc()) {
                $existingFilePath = $targetDirectory . $existing_file['file_name'];
                if (file_exists($existingFilePath)) {
                    unlink($existingFilePath); // Delete the file
                }
            }
        
            // Remove old file references from the database
            $delete_stmt = $con->prepare("DELETE FROM tbl_inquiry_photos WHERE type_id = ? AND type = ?");
            $delete_stmt->bind_param("is", $id, $type);
            $delete_stmt->execute();

            // Loop through each uploaded file
            for ($i = 0; $i < count($_FILES['photo']['name']); $i++) {
                $file = $_FILES['photo'];

                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
                if (in_array($file['type'][$i], $allowedTypes)) {
                    $fileName = date('Y-m-d') . "_" . basename($file['name'][$i]);
                    $targetFilePath = $targetDirectory . $fileName;

                    if (move_uploaded_file($file['tmp_name'][$i], $targetFilePath)) {
                        $file_type = (strpos($file['type'][$i], 'image/') !== false) ? "image" : "file";
                        $type = "dailytask_add";

                        // Insert file details into tbl_inquiry_photos
                        $stmt = $con->prepare("INSERT INTO `tbl_inquiry_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("isss", $id, $type, $fileName, $file_type);
                        $stmt->execute();
                    } else {
                        $_SESSION['status'] = "File Upload Failed!";
                        $_SESSION['status_code'] = "error";
                        echo "<script>setTimeout(function(){window.location='dailytask_update.php?id=$id'},1000);</script>";
                        exit;
                    }
                } else {
                    $_SESSION['status'] = "Invalid File Type!";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='dailytask_update.php?id=$id'},1000);</script>";
                    exit;
                }
            }
            $_SESSION['status'] = "Task Updated Successfully with Files!";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Task Updated Successfully. No File Selected!";
            $_SESSION['status_code'] = "success";
        }
        echo "<script>setTimeout(function(){window.location='dailytask_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Task Update Failed!";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='dailytask_update.php?id=$id'},1000);</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit Daily Task</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Daily Task</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="task_date">Date:</label>
                                    <input type="date" class="form-control" id="task_date" name="task_date" value="<?= $task_data['task_date'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="time_slot">Time Slot:</label>
                                    <select id="time_slot" name="time_slot" class="form-control" required>
                                        <!--<option value="09:45 AM - 10:45 AM" <?= $task_data['time_slot'] == '09:45 AM - 10:45 AM' ? 'selected' : '' ?>>09:45 AM - 10:45 AM</option>-->
                                        <!--<option value="10:45 AM - 11:45 AM" <?= $task_data['time_slot'] == '10:45 AM - 11:45 AM' ? 'selected' : '' ?>>10:45 AM - 11:45 AM</option>-->
                                        <!--<option value="11:45 AM - 12:45 PM" <?= $task_data['time_slot'] == '11:45 AM - 12:45 PM' ? 'selected' : '' ?>>11:45 AM - 12:45 PM</option>-->
                                        <!--<option value="12:45 PM - 01:45 PM" <?= $task_data['time_slot'] == '12:45 PM - 01:45 PM' ? 'selected' : '' ?>>12:45 PM - 01:45 PM</option>-->
                                        <!--<option value="01:45 PM - 02:45 PM" <?= $task_data['time_slot'] == '01:45 PM - 02:45 PM' ? 'selected' : '' ?>>01:45 PM - 02:45 PM</option>-->
                                        <!--<option value="02:45 PM - 03:45 PM" <?= $task_data['time_slot'] == '02:45 PM - 03:45 PM' ? 'selected' : '' ?>>02:45 PM - 03:45 PM</option>-->
                                        <!--<option value="03:45 PM - 04:45 PM" <?= $task_data['time_slot'] == '03:45 PM - 04:45 PM' ? 'selected' : '' ?>>03:45 PM - 04:45 PM</option>-->
                                        <!--<option value="04:45 PM - 05:45 PM" <?= $task_data['time_slot'] == '04:45 PM - 05:45 PM' ? 'selected' : '' ?>>04:45 PM - 05:45 PM</option>-->
                                        <!--<option value="05:45 PM - 06:15 PM" <?= $task_data['time_slot'] == '05:45 PM - 06:15 PM' ? 'selected' : '' ?>>05:45 PM - 06:15 PM</option>-->
                                        
                                        <option value="09:30 AM - 10:30 AM" <?= $task_data['time_slot'] == '09:30 AM - 10:30 AM' ? 'selected' : '' ?>>09:30 AM - 10:30 AM</option>
                                        <option value="10:30 AM - 11:30 AM" <?= $task_data['time_slot'] == '10:30 AM - 11:30 AM' ? 'selected' : '' ?>>10:30 AM - 11:30 AM</option>
                                        <option value="11:30 AM - 12:30 PM" <?= $task_data['time_slot'] == '11:30 AM - 12:30 PM' ? 'selected' : '' ?>>11:30 AM - 12:30 PM</option>
                                        <option value="12:30 PM - 01:30 PM" <?= $task_data['time_slot'] == '12:30 PM - 01:30 PM' ? 'selected' : '' ?>>12:30 PM - 01:30 PM</option>
                                        <option value="01:30 PM - 02:30 PM" <?= $task_data['time_slot'] == '01:30 PM - 02:30 PM' ? 'selected' : '' ?>>01:30 PM - 02:30 PM</option>
                                        <option value="02:30 PM - 03:30 PM" <?= $task_data['time_slot'] == '02:30 AM - 03:30 PM' ? 'selected' : '' ?>>02:30 PM - 03:30 PM</option>
                                        <option value="03:30 PM - 04:30 PM" <?= $task_data['time_slot'] == '03:30 PM - 04:30 PM' ? 'selected' : '' ?>>03:30 PM - 04:30 PM</option>
                                        <option value="04:30 PM - 05:30 PM" <?= $task_data['time_slot'] == '04:30 PM - 05:30 PM' ? 'selected' : '' ?>>04:30 PM - 05:30 PM</option>
                                        <option value="05:30 PM - 06:00 PM" <?= $task_data['time_slot'] == '05:30 PM - 06:00 PM' ? 'selected' : '' ?>>05:30 PM - 06:00 PM</option>

                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for="task_description">Task Description:</label>
                                    <input type="text" id="task_description" name="task_description" class="form-control" value="<?= $task_data['task_description'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Upload Files (Photos, Word, PDF, Excel):</label>
                                    <input type="file" id="photo" name="photo[]" class="form-control" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" multiple>
                                    <small>Allowed file types: Images, PDF, Word, Excel</small>
                                </div>


                                <!-- Display existing photos -->
                                <div class="form-group">
                                    <label>Existing File:</label>
                                    <div>
                                        <?php foreach ($existing_photos as $photo) : ?>
                                            <?php
                                            $fileExtension = pathinfo($photo, PATHINFO_EXTENSION);
                                            if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
                                                // Display image for valid image extensions
                                                echo "<img src='../uploads/task_images/{$photo}' alt='Photo' style='width: 100px; height: auto; margin-right: 10px;'>";
                                            } else {
                                                // Display a link for non-image file types
                                                echo "<a href='../uploads/task_images/{$photo}' target='_blank'>{$photo}</a>";
                                            }
                                            ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>


                                <button type="submit" name="submit" class="btn btn-primary">Update Task</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include '../include/importfooter.php'; ?>
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>
    <?php include '../include/importjs.php'; ?>
</body>

</html>