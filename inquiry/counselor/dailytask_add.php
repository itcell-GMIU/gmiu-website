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

                                    <label for="shift">Select Shift</label>
                                    <select id="shift" onchange="updateTimeSlots()" class="form-control">
                                        <option value="">-- Select Shift --</option>
                                        <option value="shift1">Shift 1</option>
                                        <option value="shift2">Shift 2</option>
                                    </select>

                                    <br>

                                    <label for="timeSlot">Select Time Slot</label>
                                    <select id="timeSlot" class="form-control" name="time_slot">
                                        <option value="">-- Select Time Slot --</option>
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for="task_description">Task Description:</label>
                                    <input type="text" id="task_description" name="task_description"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Upload Files (Photos, Word, PDF, Excel):</label>
                                    <input type="file" id="photo" name="photo[]" class="form-control"
                                        accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" multiple>
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
    <script>
        function updateTimeSlots() {
            const shift = document.getElementById("shift").value;
            const timeSlot = document.getElementById("timeSlot");

            // Clear previous options
            timeSlot.innerHTML = '<option value="">-- Select Time Slot --</option>';

            let slots = [];

            if (shift === "shift1") {
                // Shift 1 → 7:00 AM to 3:30 PM
                slots = [
                    "07:00 AM - 08:00 AM",
                    "08:00 AM - 09:00 AM",
                    "09:00 AM - 10:00 AM",
                    "10:00 AM - 11:00 AM",
                    "11:00 AM - 12:00 PM",
                    "12:00 PM - 01:00 PM",
                    "01:00 PM - 02:00 PM",
                    "02:00 PM - 03:00 PM",
                    "03:00 PM - 03:30 PM"
                ];
            }
            else if (shift === "shift2") {
                // Shift 2 → existing slots
                slots = [
                    "09:30 AM - 10:30 AM",
                    "10:30 AM - 11:30 AM",
                    "11:30 AM - 12:30 PM",
                    "12:30 PM - 01:30 PM",
                    "01:30 PM - 02:30 PM",
                    "02:30 PM - 03:30 PM",
                    "03:30 PM - 04:30 PM",
                    "04:30 PM - 05:45 PM"
                ];
            }

            // Append options
            slots.forEach(slot => {
                const option = document.createElement("option");
                option.value = slot;
                option.textContent = slot;
                timeSlot.appendChild(option);
            });
        }
    </script>

</body>

</html>