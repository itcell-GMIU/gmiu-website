<?php
include './include/config.php';

function detectShiftFromSlot($slot)
{
    $shift1 = [
        '07:00 AM - 08:00 AM',
        '08:00 AM - 09:00 AM',
        '09:00 AM - 10:00 AM',
        '10:00 AM - 11:00 AM',
        '11:00 AM - 12:00 PM',
        '12:00 PM - 01:00 PM',
        '01:00 PM - 02:00 PM',
        '02:00 PM - 03:00 PM',
        '03:00 PM - 03:30 PM'
    ];

    return in_array($slot, $shift1) ? 'shift1' : 'shift2';
}

// =================== FETCH EXISTING TASK =================== //
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='dailytask-view.php'},1000)</script>";
        exit();
    }

    // Fetch existing task data
    $stmt = $con->prepare("SELECT * FROM tbl_daily_task WHERE id = ? AND is_delete = 0");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $task_result = $stmt->get_result();
    $task_data = $task_result->fetch_assoc();
    $detectedShift = detectShiftFromSlot($task_data['time_slot']);

    if (!$task_data) {
        $_SESSION['status'] = "Task not found";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='dailytask-view.php'},1000)</script>";
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

// =================== UPDATE TASK =================== //
if (isset($_POST['submit'])) {
    $task_date = mysqli_real_escape_string($con, $_POST['task_date']);
    $time_slot = mysqli_real_escape_string($con, $_POST['time_slot']);
    $task_description = mysqli_real_escape_string($con, $_POST['task_description']);
    $staff_id = $_SESSION['staff_id'];

    $stmt = $con->prepare("UPDATE tbl_daily_task SET task_date = ?, time_slot = ?, task_description = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("sssi", $task_date, $time_slot, $task_description, $id);

    if ($stmt->execute()) {
        // Handle file uploads
        if (isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name'][0])) {
            $targetDirectory = "./uploads/task_images/";
            $type = "dailytask_add";

            // Delete old files
            $existing_files_stmt = $con->prepare("SELECT file_name FROM tbl_inquiry_photos WHERE type_id = ? AND type = ?");
            $existing_files_stmt->bind_param("is", $id, $type);
            $existing_files_stmt->execute();
            $existing_files_result = $existing_files_stmt->get_result();

            while ($existing_file = $existing_files_result->fetch_assoc()) {
                $filePath = $targetDirectory . $existing_file['file_name'];
                if (file_exists($filePath))
                    unlink($filePath);
            }

            // Remove old entries
            $delete_stmt = $con->prepare("DELETE FROM tbl_inquiry_photos WHERE type_id = ? AND type = ?");
            $delete_stmt->bind_param("is", $id, $type);
            $delete_stmt->execute();

            // Upload new files
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
                        $insert = $con->prepare("INSERT INTO tbl_inquiry_photos (type_id, type, file_name, file_type) VALUES (?, ?, ?, ?)");
                        $insert->bind_param("isss", $id, $type, $fileName, $file_type);
                        $insert->execute();
                    } else {
                        $_SESSION['status'] = "File Upload Failed!";
                        $_SESSION['status_code'] = "error";
                        echo "<script>setTimeout(function(){window.location='dailytask-edit.php?id=$id'},1000);</script>";
                        exit;
                    }
                } else {
                    $_SESSION['status'] = "Invalid File Type!";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='dailytask-edit.php?id=$id'},1000);</script>";
                    exit;
                }
            }

            $_SESSION['status'] = "Task Updated Successfully with Files!";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Task Updated Successfully. No File Selected!";
            $_SESSION['status_code'] = "success";
        }
        echo "<script>setTimeout(function(){window.location='dailytask-view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Task Update Failed!";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='dailytask-edit.php?id=$id'},1000);</script>";
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
                                <h4>Edit Daily Task</h4>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Daily Task Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- === FORM START === -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <div class="clearfix mb-3">
                        <div class="pull-left">
                            <h4 class="text-blue">Edit a Daily Task</h4>
                        </div>
                    </div>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Date</label>
                            <div class="col-sm-12 col-md-10">
                                <input name="task_date" class="form-control" type="date"
                                    value="<?= isset($task_data['task_date']) ? $task_data['task_date'] : '' ?>"
                                    required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Shift</label>
                            <div class="col-sm-12 col-md-10">
                                <select id="shift" class="custom-select col-12" onchange="updateTimeSlots()" required>
                                    <option value="shift1" <?= $detectedShift == 'shift1' ? 'selected' : '' ?>>Shift 1
                                    </option>
                                    <option value="shift2" <?= $detectedShift == 'shift2' ? 'selected' : '' ?>>Shift 2
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Time Slot</label>
                            <div class="col-sm-12 col-md-10">
                                <select id="timeSlot" name="time_slot" class="custom-select col-12" required></select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Task Description</label>
                            <div class="col-sm-12 col-md-10">
                                <textarea name="task_description" class="form-control"
                                    required><?= isset($task_data['task_description']) ? $task_data['task_description'] : '' ?></textarea>
                            </div>
                        </div>

                        <!-- Upload -->
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

                        <!-- Existing Files -->
                        <?php if (!empty($existing_photos)) { ?>
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Existing Files</label>
                                <div class="col-sm-12 col-md-10">
                                    <?php foreach ($existing_photos as $photo): ?>
                                        <?php
                                        $fileExt = pathinfo($photo, PATHINFO_EXTENSION);
                                        if (in_array(strtolower($fileExt), ['jpg', 'jpeg', 'png', 'gif'])) {
                                            echo "<img src='./uploads/task_images/$photo' style='width:100px;margin-right:10px;'>";
                                        } else {
                                            echo "<a href='./uploads/task_images/$photo' target='_blank'>$photo</a><br>";
                                        }
                                        ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="text-right">
                            <button type="submit" name="submit" class="btn btn-primary">Update Task</button>
                        </div>
                    </form>
                </div>
                <!-- === FORM END === -->
            </div>

            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>

    <script>
        const shiftSlots = {
            shift1: [
                "07:00 AM - 08:00 AM",
                "08:00 AM - 09:00 AM",
                "09:00 AM - 10:00 AM",
                "10:00 AM - 11:00 AM",
                "11:00 AM - 12:00 PM",
                "12:00 PM - 01:00 PM",
                "01:00 PM - 02:00 PM",
                "02:00 PM - 03:00 PM",
                "03:00 PM - 03:30 PM"
            ],
            shift2: [
                "09:30 AM - 10:30 AM",
                "10:30 AM - 11:30 AM",
                "11:30 AM - 12:30 PM",
                "12:30 PM - 01:30 PM",
                "01:30 PM - 02:30 PM",
                "02:30 PM - 03:30 PM",
                "03:30 PM - 04:30 PM",
                "04:30 PM - 05:45 PM"
            ]
        };

        const selectedSlot = <?= json_encode(trim($task_data['time_slot'])); ?>;

        function updateTimeSlots() {
            const shift = document.getElementById("shift").value;
            const slotSelect = document.getElementById("timeSlot");

            slotSelect.innerHTML = "";

            shiftSlots[shift].forEach(slot => {
                const option = document.createElement("option");
                option.value = slot;
                option.textContent = slot;

                if (slot.trim() === selectedSlot.trim()) {
                    option.selected = true;
                }

                slotSelect.appendChild(option);
            });
        }

        document.addEventListener('DOMContentLoaded', updateTimeSlots);
    </script>

</body>

</html>