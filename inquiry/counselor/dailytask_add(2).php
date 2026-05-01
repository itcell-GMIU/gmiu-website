<?php
include '../include/checklogin.php';
if (isset($_POST['submit'])) {
    // Sanitize form data
    $task_date = mysqli_real_escape_string($con, $_POST['task_date']);
    $time_slot = mysqli_real_escape_string($con, $_POST['time_slot']);
    $task_description = mysqli_real_escape_string($con, $_POST['task_description']);
    $staff_id = $_SESSION['staff_id']; // Assuming staff_id is stored in session

    // Insert data into the tbl_daily_task table
    $stmt = $con->prepare("INSERT INTO tbl_daily_task (task_date, time_slot, task_description, staff_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $task_date, $time_slot, $task_description, $staff_id);

    if ($stmt->execute()) {
        $task_id = $con->insert_id; // Get the ID of the newly inserted task

        // Handle multiple file uploads
        if (isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name'][0])) {
            $targetDirectory = "../uploads/task_images/";

            // Loop through each uploaded file
            for ($i = 0; $i < count($_FILES['photo']['name']); $i++) {
                $file = $_FILES['photo'];

                // Validate file
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
                if (in_array($file['type'][$i], $allowedTypes)) {
                    $fileName = date('Y-m-d') . "_" . basename($file['name'][$i]);
                    $targetFilePath = $targetDirectory . $fileName;

                    if (move_uploaded_file($file['tmp_name'][$i], $targetFilePath)) {
                        $file_type = (strpos($file['type'][$i], 'image/') !== false) ? "image" : "file";
                        $type = "dailytask_add";

                        // Insert file details into tbl_inquiry_photos
                        $stmt = $con->prepare("INSERT INTO `tbl_inquiry_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("isss", $task_id, $type, $fileName, $file_type);
                        $stmt->execute();
                    } else {
                        $_SESSION['status'] = "File Upload Failed!";
                        $_SESSION['status_code'] = "error";
                        echo "<script>setTimeout(function(){window.location='add_task.php'},1000);</script>";
                        exit;
                    }
                } else {
                    $_SESSION['status'] = "Invalid File Type!";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='add_task.php'},1000);</script>";
                    exit;
                }
            }
            $_SESSION['status'] = "Task Submitted Successfully with Files!";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Data Inserted. No File Selected!";
            $_SESSION['status_code'] = "success";
        }

        echo "<script>setTimeout(function(){window.location='dailytask_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Task Submission Failed!";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='add_task.php'},1000);</script>";
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
                            <h1 class="m-0">Add Daily Task</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Daily Task</li>
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
                                    <input type="date" class="form-control" id="task_date" name="task_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="time_slot">Time Slot:</label>
                                    <select id="time_slot" name="time_slot" class="form-control" required>
                                        <!--<option value="09:45 AM - 10:45 AM">09:45 AM - 10:45 AM</option>-->
                                        <!--<option value="10:45 AM - 11:45 AM">10:45 AM - 11:45 AM</option>-->
                                        <!--<option value="11:45 AM - 12:45 PM">11:45 AM - 12:45 PM</option>-->
                                        <!--<option value="12:45 PM - 01:45 PM">12:45 PM - 01:45 PM</option>-->
                                        <!--<option value="01:45 PM - 02:45 PM">01:45 PM - 02:45 PM</option>-->
                                        <!--<option value="02:45 PM - 03:45 PM">02:45 PM - 03:45 PM</option>-->
                                        <!--<option value="03:45 PM - 04:45 PM">03:45 PM - 04:45 PM</option>-->
                                        <!--<option value="04:45 PM - 05:45 PM">04:45 PM - 05:45 PM</option>-->
                                        <!--<option value="05:45 PM - 06:15 PM">05:45 PM - 06:15 PM</option>-->
                                        <option value="09:30 AM - 10:30 AM">09:30 AM - 10:30 AM</option>
                                        <option value="10:30 AM - 11:30 AM">10:30 AM - 11:30 AM</option>
                                        <option value="11:30 AM - 12:30 PM">11:30 AM - 12:30 PM</option>
                                        <option value="12:30 PM - 01:30 PM">12:30 PM - 01:30 PM</option>
                                        <option value="01:30 PM - 02:30 PM">01:30 PM - 02:30 PM</option>
                                        <option value="02:30 PM - 03:30 PM">02:30 PM - 03:30 PM</option>
                                        <option value="03:30 PM - 04:30 PM">03:30 PM - 04:30 PM</option>
                                        <option value="04:30 PM - 05:30 PM">04:30 PM - 05:30 PM</option>
                                        <option value="05:30 PM - 06:00 PM">05:30 PM - 06:00 PM</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="task_description">Task Description:</label>
                                    <input type="text" id="task_description" name="task_description" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Upload Files (Photos, Word, PDF, Excel):</label>
                                    <input type="file" id="photo" name="photo[]" class="form-control" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" multiple>
                                    <small>Allowed file types: Images, PDF, Word, Excel</small>
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary">Submit Task</button>
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