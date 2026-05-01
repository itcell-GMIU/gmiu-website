<?php
include './include/config.php';

if (isset($_POST['submit'])) {
    // Sanitize form data
    $task_date = mysqli_real_escape_string($con, $_POST['task_date']);
    $time_slot = mysqli_real_escape_string($con, $_POST['time_slot']);
    $task_description = mysqli_real_escape_string($con, $_POST['task_description']);
    $staff_id = $_SESSION['staff_id']; // Assuming staff_id is stored in session

    // Insert into tbl_daily_task
    $stmt = $con->prepare("INSERT INTO tbl_daily_task (task_date, time_slot, task_description, staff_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $task_date, $time_slot, $task_description, $staff_id);

    if ($stmt->execute()) {
        $task_id = $con->insert_id; // last inserted id

        // Handle file uploads
        if (isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name'][0])) {
            $targetDirectory = "./uploads/task_images/";

            for ($i = 0; $i < count($_FILES['photo']['name']); $i++) {
                $file = $_FILES['photo'];

                $allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ];

                if (in_array($file['type'][$i], $allowedTypes)) {
                    $fileName = date('Y-m-d') . "_" . basename($file['name'][$i]);
                    $targetFilePath = $targetDirectory . $fileName;

                    if (move_uploaded_file($file['tmp_name'][$i], $targetFilePath)) {
                        $file_type = (strpos($file['type'][$i], 'image/') !== false) ? "image" : "file";
                        $type = "dailytask_add";

                        $stmtFile = $con->prepare("INSERT INTO `tbl_inquiry_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                        $stmtFile->bind_param("isss", $task_id, $type, $fileName, $file_type);
                        $stmtFile->execute();
                    } else {
                        $_SESSION['status'] = "File Upload Failed!";
                        $_SESSION['status_code'] = "error";
                        exit;
                    }
                } else {
                    $_SESSION['status'] = "Invalid File Type!";
                    $_SESSION['status_code'] = "error";
                    exit;
                }
            }
            $_SESSION['status'] = "Task Submitted Successfully with Files!";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Data Inserted. No File Selected!";
            $_SESSION['status_code'] = "success";
        }

    } else {
        $_SESSION['status'] = "Task Submission Failed!";
        $_SESSION['status_code'] = "error";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include('include/head.php'); ?>
</head>

<body>
    <?php include('include/header.php'); ?>
    <?php include('include/sidebar.php'); ?>

    <div class="main-container">
        <div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Daily Task Add</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Daily Task Add</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <div class="clearfix mb-3">
                        <div class="pull-left">
                            <h4 class="text-blue">Add a New Daily Task</h4>
                            <p class="mb-30 font-14">Fill in the details for the task below.</p>
                        </div>
                    </div>

                    <!-- === FORM START === -->
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Date</label>
                            <div class="col-sm-12 col-md-10">
                                <input name="task_date" id="taskDate" class="form-control" type="date" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Shift</label>
                            <div class="col-sm-12 col-md-10">
                                <select id="shift" class="custom-select col-12" onchange="updateTimeSlots()" required>
                                    <option value="">-- Select Shift --</option>
                                    <option value="shift1">Shift 1</option>
                                    <option value="shift2">Shift 2</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Time Slot</label>
                            <div class="col-sm-12 col-md-10">
                                <select id="timeSlot" name="time_slot" class="custom-select col-12" required>
                                    <option value="">-- Select Time Slot --</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Task Description</label>
                            <div class="col-sm-12 col-md-10">
                                <textarea name="task_description" class="form-control"
                                    placeholder="Describe the task in detail..." required></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Upload Files</label>
                            <div class="col-sm-12 col-md-10">
                                <div class="custom-file">
                                    <input type="file" name="photo[]" class="custom-file-input" multiple
                                        accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                                    <label class="custom-file-label">Choose files...</label>
                                </div>
                                <small>Allowed file types: Images, PDF, Word, Excel</small>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" name="submit" class="btn btn-primary">Add Task</button>
                        </div>
                    </form>
                    <!-- === FORM END === -->
                </div>
            </div>

            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>

    <script>
        function updateTimeSlots() {
            const shift = document.getElementById("shift").value;
            const timeSlot = document.getElementById("timeSlot");

            // Reset dropdown
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
                // Shift 2 → 9:30 AM to 5:45 PM
                slots = [
                    "09:30 AM - 10:30 AM",
                    "10:30 AM - 11:30 AM",
                    "11:30 AM - 12:30 PM",
                    "12:30 PM - 01:30 PM",
                    "01:30 PM - 02:30 PM",
                    "02:30 PM - 03:30 PM",
                    "03:30 PM - 04:30 PM",
                    "04:30 PM - 05:30 PM",
                    "05:30 PM - 06:00 PM"
                ];
            }

            // Populate slots
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