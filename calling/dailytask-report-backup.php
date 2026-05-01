<?php
// New template's config include
include './include/config.php';

// --- START: Merged Logic from Old Code ---

// It's assumed session_start() is called in one of the includes
// and the user role_id is available in the session.
// For example: $role_id = $_SESSION['role_id'];

// --- Variable Initialization and GET Parameter Handling ---
$taskDate = isset($_GET['task_date']) ? $_GET['task_date'] : '';
$timeSlot = isset($_GET['time_slot']) ? $_GET['time_slot'] : '';
$staffId = isset($_GET['staff_id']) ? $_GET['staff_id'] : '';

// --- Dynamic Staff List Query based on Role ID ---

$staffQuery = "SELECT id, name FROM tbl_staff WHERE is_delete = 0";
$staffResult = $con->query($staffQuery);


// --- Main Data Fetching Query (Pivoted Table) ---
$sql = "SELECT 
    staff.name AS staff_name,
    staff.id AS staff_id,
    dt.task_date,
    MAX(CASE WHEN dt.time_slot = '09:30 AM - 10:30 AM' THEN dt.task_description ELSE '' END) AS '09:30 AM - 10:30 AM',
    MAX(CASE WHEN dt.time_slot = '10:30 AM - 11:30 AM' THEN dt.task_description ELSE '' END) AS '10:30 AM - 11:30 AM',
    MAX(CASE WHEN dt.time_slot = '11:30 AM - 12:30 PM' THEN dt.task_description ELSE '' END) AS '11:30 AM - 12:30 PM',
    MAX(CASE WHEN dt.time_slot = '12:30 PM - 01:30 PM' THEN dt.task_description ELSE '' END) AS '12:30 PM - 01:30 PM',
    MAX(CASE WHEN dt.time_slot = '01:30 PM - 02:30 PM' THEN dt.task_description ELSE '' END) AS '01:30 PM - 02:30 PM',
    MAX(CASE WHEN dt.time_slot = '02:30 PM - 03:30 PM' THEN dt.task_description ELSE '' END) AS '02:30 PM - 03:30 PM',
    MAX(CASE WHEN dt.time_slot = '03:30 PM - 04:30 PM' THEN dt.task_description ELSE '' END) AS '03:30 PM - 04:30 PM',
    MAX(CASE WHEN dt.time_slot = '04:30 PM - 05:30 PM' THEN dt.task_description ELSE '' END) AS '04:30 PM - 05:30 PM',
    MAX(CASE WHEN dt.time_slot = '05:30 PM - 06:00 PM' THEN dt.task_description ELSE '' END) AS '05:30 PM - 06:00 PM',
    MAX(CASE WHEN dt.time_slot = '09:30 AM - 10:30 AM' THEN dt.id ELSE NULL END) AS id_1,
    MAX(CASE WHEN dt.time_slot = '10:30 AM - 11:30 AM' THEN dt.id ELSE NULL END) AS id_2,
    MAX(CASE WHEN dt.time_slot = '11:30 AM - 12:30 PM' THEN dt.id ELSE NULL END) AS id_3,
    MAX(CASE WHEN dt.time_slot = '12:30 PM - 01:30 PM' THEN dt.id ELSE NULL END) AS id_4,
    MAX(CASE WHEN dt.time_slot = '01:30 PM - 02:30 PM' THEN dt.id ELSE NULL END) AS id_5,
    MAX(CASE WHEN dt.time_slot = '02:30 PM - 03:30 PM' THEN dt.id ELSE NULL END) AS id_6,
    MAX(CASE WHEN dt.time_slot = '03:30 PM - 04:30 PM' THEN dt.id ELSE NULL END) AS id_7,
    MAX(CASE WHEN dt.time_slot = '04:30 PM - 05:30 PM' THEN dt.id ELSE NULL END) AS id_8,
    MAX(CASE WHEN dt.time_slot = '05:30 PM - 06:00 PM' THEN dt.id ELSE NULL END) AS id_9,
    dr.comments AS remark,
    dr.id AS remark_id
FROM 
    tbl_daily_task dt
LEFT JOIN 
    tbl_staff staff ON dt.staff_id = staff.id
LEFT JOIN 
    tbl_daily_review dr ON dr.staff_id = dt.staff_id
WHERE 
    dt.is_delete = 0";



// Append filter conditions
$conditions = [];
if (!empty($taskDate)) {
    $conditions[] = "dt.task_date = ?";
}
if (!empty($timeSlot)) {
    $conditions[] = "dt.time_slot = ?";
}
if (!empty($staffId)) {
    $conditions[] = "dt.staff_id = ?";
}
if (!empty($conditions)) {
    $sql .= " AND " . implode(' AND ', $conditions);
}

$sql .= " GROUP BY staff.name, dt.task_date ORDER BY dt.task_date DESC;";

// --- Prepare and Execute Statement ---
$stmt = $con->prepare($sql);
if ($stmt) {
    $params = [];
    $types = '';
    if (!empty($taskDate)) {
        $params[] = $taskDate;
        $types .= 's';
    }
    if (!empty($timeSlot)) {
        $params[] = $timeSlot;
        $types .= 's';
    }
    if (!empty($staffId)) {
        $params[] = $staffId;
        $types .= 'i';
    }
    if (!empty($types)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Handle query preparation error
    echo "Error: " . $con->error;
    $result = null; // Ensure result is not used if there's an error
}
// --- END: Merged Logic ---
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
                                <h4>Daily Task Report</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Daily Task Report</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="mb-20 h5">Filter Daily Task Data</h5>
                    <form method="GET" action="">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label>Task Date:</label>
                                    <input type="date" class="form-control" name="task_date"
                                        value="<?php echo htmlspecialchars($taskDate); ?>">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label>Time Slot:</label>
                                    <select name="time_slot" class="form-control">
                                        <option value="">Select Time Slot</option>
                                        <option value="09:30 AM - 10:30 AM" <?php echo $timeSlot == '09:30 AM - 10:30 AM' ? 'selected' : ''; ?>>09:30 AM - 10:30 AM</option>
                                        <option value="10:30 AM - 11:30 AM" <?php echo $timeSlot == '10:30 AM - 11:30 AM' ? 'selected' : ''; ?>>10:30 AM - 11:30 AM</option>
                                        <option value="11:30 AM - 12:30 PM" <?php echo $timeSlot == '11:30 AM - 12:30 PM' ? 'selected' : ''; ?>>11:30 AM - 12:30 PM</option>
                                        <option value="12:30 PM - 01:30 PM" <?php echo $timeSlot == '12:30 PM - 01:30 PM' ? 'selected' : ''; ?>>12:30 PM - 01:30 PM</option>
                                        <option value="01:30 PM - 02:30 PM" <?php echo $timeSlot == '01:30 PM - 02:30 PM' ? 'selected' : ''; ?>>01:30 PM - 02:30 PM</option>
                                        <option value="02:30 PM - 03:30 PM" <?php echo $timeSlot == '02:30 PM - 03:30 PM' ? 'selected' : ''; ?>>02:30 PM - 03:30 PM</option>
                                        <option value="03:30 PM - 04:30 PM" <?php echo $timeSlot == '03:30 PM - 04:30 PM' ? 'selected' : ''; ?>>03:30 PM - 04:30 PM</option>
                                        <option value="04:30 PM - 05:30 PM" <?php echo $timeSlot == '04:30 PM - 05:30 PM' ? 'selected' : ''; ?>>04:30 PM - 05:30 PM</option>
                                        <option value="05:30 PM - 06:00 PM" <?php echo $timeSlot == '05:30 PM - 06:00 PM' ? 'selected' : ''; ?>>05:30 PM - 06:00 PM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label>Staff:</label>
                                    <select class="form-control" name="staff_id">
                                        <option value="">Select Staff</option>
                                        <?php if ($staffResult && $staffResult->num_rows > 0): ?>
                                            <?php while ($staff = $staffResult->fetch_assoc()): ?>
                                                <option value="<?php echo $staff['id']; ?>" <?php echo $staffId == $staff['id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($staff['name']); ?>
                                                </option>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 align-self-end">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                        class="btn btn-secondary">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="mb-20 h5">Daily Task Report</h5>
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-striped w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th>Staff Name</th>
                                    <th>Task Date</th>
                                    <th>09:30 AM - 10:30 AM</th>
                                    <th>10:30 AM - 11:30 AM</th>
                                    <th>11:30 AM - 12:30 PM</th>
                                    <th>12:30 PM - 01:30 PM</th>
                                    <th>01:30 PM - 02:30 PM</th>
                                    <th>02:30 PM - 03:30 PM</th>
                                    <th>03:30 PM - 04:30 PM</th>
                                    <th>04:30 PM - 05:30 PM</th>
                                    <th>05:30 PM - 06:00 PM</th>
                                    <th>Remarks</th>
                                    <?php if ($role_id == 22): ?>
                                        <th>Actions</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <?php echo htmlspecialchars($row['staff_name']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($row['task_date']); ?>
                                            </td>
                                            <?php
                                            $time_slots = [
                                                ['time' => '09:30 AM - 10:30 AM', 'id' => 'id_1'],
                                                ['time' => '10:30 AM - 11:30 AM', 'id' => 'id_2'],
                                                ['time' => '11:30 AM - 12:30 PM', 'id' => 'id_3'],
                                                ['time' => '12:30 PM - 01:30 PM', 'id' => 'id_4'],
                                                ['time' => '01:30 PM - 02:30 PM', 'id' => 'id_5'],
                                                ['time' => '02:30 PM - 03:30 PM', 'id' => 'id_6'],
                                                ['time' => '03:30 PM - 04:30 PM', 'id' => 'id_7'],
                                                ['time' => '04:30 PM - 05:30 PM', 'id' => 'id_8'],
                                                ['time' => '05:30 PM - 06:00 PM', 'id' => 'id_9'],
                                            ];
                                            foreach ($time_slots as $slot) {
                                                $time = $slot['time'];
                                                $task_id = $row[$slot['id']];
                                                echo '<td>';
                                                echo htmlspecialchars($row[$time]);
                                                if (!empty($task_id)) {
                                                    // Note: Adjust the path if necessary
                                                    echo '<br><a href="dailytask-view.php?task_id=' . $task_id . '" class="text-primary"><i class="fa fa-eye"></i> View</a>';
                                                }
                                                echo '</td>';
                                            }
                                            ?>
                                            <td>
                                                <?php echo htmlspecialchars($row['remark']); ?>
                                            </td>
                                            <?php if ($role_id == 22): ?>
                                                <td>
                                                    <?php
                                                    if (!empty($row['remark'])): ?>
                                                        <a href="dailytask-edit-remark.php?remark_id=<?php echo $row['remark_id']; ?>"
                                                            class="btn btn-sm btn-warning">Edit</a>
                                                    <?php else: ?>
                                                        <a href="dailytask-add-remark.php?task_date=<?php echo $row['task_date']; ?>&staff_id=<?php echo $row['staff_id']; ?>"
                                                            class="btn btn-sm btn-primary">Add</a>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="13" class="text-center text-muted">No records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>

    <script>
        $(document).ready(function () {
            $('.data-table').DataTable({
                // scrollX: true,
                autoWidth: true,
                responsive: false,
                language: { searchPlaceholder: "Search" },
                dom: '<"d-flex justify-content-between"lBf>rtip',
                buttons: ['copy', 'csv', 'pdf', 'print']
            });
        });
    </script>
</body>

</html>