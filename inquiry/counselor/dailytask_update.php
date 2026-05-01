<?php
include '../include/checklogin.php';

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

if (!isset($_GET['id'])) {
    header("Location: dailytask_view.php");
    exit;
}

$id = (int) $_GET['id'];

/* FETCH TASK */
$stmt = $con->prepare("SELECT * FROM tbl_daily_task WHERE id = ? AND is_delete = 0");
$stmt->bind_param("i", $id);
$stmt->execute();
$task = $stmt->get_result()->fetch_assoc();

if (!$task) {
    $_SESSION['status'] = "Task not found";
    $_SESSION['status_code'] = "error";
    header("Location: dailytask_view.php");
    exit;
}

$detectedShift = detectShiftFromSlot($task['time_slot']);
$type = "dailytask_add";

/* FETCH FILES */
$photo_stmt = $con->prepare("SELECT file_name FROM tbl_inquiry_photos WHERE type_id = ? AND type = ?");
$photo_stmt->bind_param("is", $id, $type);
$photo_stmt->execute();
$photos = $photo_stmt->get_result()->fetch_all(MYSQLI_ASSOC);

/* UPDATE TASK */
if (isset($_POST['submit'])) {
    $task_date = $_POST['task_date'];
    $time_slot = $_POST['time_slot'];
    $task_description = $_POST['task_description'];

    $stmt = $con->prepare("
        UPDATE tbl_daily_task 
        SET task_date = ?, time_slot = ?, task_description = ?, updated_at = NOW()
        WHERE id = ?
    ");
    $stmt->bind_param("sssi", $task_date, $time_slot, $task_description, $id);
    $stmt->execute();

    $_SESSION['status'] = "Task Updated Successfully";
    $_SESSION['status_code'] = "success";
    header("Location: dailytask_view.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">

                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Daily Task</h4>
                        </div>
                        <div class="card-body">

                            <form method="POST" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="task_date" class="form-control"
                                        value="<?= $task['task_date'] ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Select Shift</label>
                                    <select id="shift" class="form-control" onchange="updateTimeSlots()">
                                        <option value="shift1" <?= $detectedShift == 'shift1' ? 'selected' : '' ?>>Shift 1
                                        </option>
                                        <option value="shift2" <?= $detectedShift == 'shift2' ? 'selected' : '' ?>>Shift 2
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Time Slot</label>
                                    <select id="timeSlot" name="time_slot" class="form-control" required></select>
                                </div>

                                <div class="form-group">
                                    <label>Task Description</label>
                                    <input type="text" name="task_description" class="form-control"
                                        value="<?= htmlspecialchars($task['task_description']) ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Upload Files</label>
                                    <input type="file" name="photo[]" class="form-control" multiple>
                                </div>

                                <div class="form-group">
                                    <label>Existing Files</label><br>
                                    <?php foreach ($photos as $p): ?>
                                        <a href="../uploads/task_images/<?= $p['file_name'] ?>" target="_blank">
                                            <?= $p['file_name'] ?>
                                        </a><br>
                                    <?php endforeach; ?>
                                </div>

                                <button class="btn btn-primary" name="submit">Update Task</button>

                            </form>

                        </div>
                    </div>

                </div>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>
    </div>

    <?php include '../include/importjs.php'; ?>

    <script>
        const shiftSlots = {
            shift1: [
                "07:00 AM - 08:00 AM", "08:00 AM - 09:00 AM", "09:00 AM - 10:00 AM",
                "10:00 AM - 11:00 AM", "11:00 AM - 12:00 PM", "12:00 PM - 01:00 PM",
                "01:00 PM - 02:00 PM", "02:00 PM - 03:00 PM", "03:00 PM - 03:30 PM"
            ],
            shift2: [
                "09:30 AM - 10:30 AM", "10:30 AM - 11:30 AM", "11:30 AM - 12:30 PM",
                "12:30 PM - 01:30 PM", "01:30 PM - 02:30 PM", "02:30 PM - 03:30 PM",
                "03:30 PM - 04:30 PM", "04:30 PM - 05:45 PM"
            ]
        };

        const selectedSlot = "<?= $task['time_slot'] ?>";

        function updateTimeSlots() {
            const shift = document.getElementById("shift").value;
            const slotSelect = document.getElementById("timeSlot");

            slotSelect.innerHTML = "";

            shiftSlots[shift].forEach(slot => {
                const opt = document.createElement("option");
                opt.value = slot;
                opt.textContent = slot;
                if (slot === selectedSlot) opt.selected = true;
                slotSelect.appendChild(opt);
            });
        }

        window.onload = updateTimeSlots;
    </script>

</body>

</html>