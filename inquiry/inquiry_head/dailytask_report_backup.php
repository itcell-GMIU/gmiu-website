<?php
include '../include/checklogin.php';
$taskDate = '';
$timeSlot = '';
$staffId = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $taskDate = isset($_GET['task_date']) ? $_GET['task_date'] : '';
    $timeSlot = isset($_GET['time_slot']) ? $_GET['time_slot'] : '';
    $staffId = isset($_GET['staff_id']) ? $_GET['staff_id'] : '';


    // Handle removing specific filters
    if (isset($_GET['clear_date'])) {
        $taskDate = '';
    }
}

// Fetch the staff list for the dropdown
$staffQuery = "SELECT id, name FROM tbl_staff WHERE role_id IN (20,16) AND is_delete = 0";
$staffResult = $con->query($staffQuery);

$sql = "SELECT 
    staff.name AS staff_name,
    dt.task_date,
    MAX(CASE WHEN dt.time_slot = '09:30 AM - 10:30 AM' THEN dt.task_description ELSE '' END) AS '09:30 AM - 10:30 AM',
    MAX(CASE WHEN dt.time_slot = '10:30 AM - 11:30 AM' THEN dt.task_description ELSE '' END) AS '10:30 AM - 11:30 AM',
    MAX(CASE WHEN dt.time_slot = '11:30 AM - 12:30 PM' THEN dt.task_description ELSE '' END) AS '11:30 AM - 12:30 PM',
    MAX(CASE WHEN dt.time_slot = '12:30 PM - 01:30 PM' THEN dt.task_description ELSE '' END) AS '12:30 PM - 01:30 PM',
    MAX(CASE WHEN dt.time_slot = '01:30 PM - 02:30 PM' THEN dt.task_description ELSE '' END) AS '01:30 PM - 02:30 PM',
    MAX(CASE WHEN dt.time_slot = '02:30 PM - 03:30 PM' THEN dt.task_description ELSE '' END) AS '02:30 PM - 03:30 PM',
    MAX(CASE WHEN dt.time_slot = '03:30 PM - 04:30 PM' THEN dt.task_description ELSE '' END) AS '03:30 PM - 04:30 PM',
    MAX(CASE WHEN dt.time_slot = '04:30 PM - 05:45 PM' THEN dt.task_description ELSE '' END) AS '04:30 PM - 05:45 PM'
    FROM tbl_daily_task dt
    LEFT JOIN tbl_staff staff ON dt.staff_id = staff.id
    WHERE dt.is_delete = 0
    GROUP BY staff.name, dt.task_date
    ORDER BY dt.task_date;
    ";


if (!empty($taskDate)) {
    $sql .= " AND task_date = ?";
}
if (!empty($timeSlot)) {
    $sql .= " AND time_slot = ?";
}
if (!empty($staffId)) {
    $sql .= " AND staff_id = ?";
}

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
        $types .= 'i';  // Assuming staff_id is an integer
    }

    if (!empty($types)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "Error: " . $con->error;
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
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Daily Task Report</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Daily Task Report</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h5>Filter Daily Task Data</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="task_date">Task Date:</label>
                                        <input type="date" class="form-control" name="task_date" value="<?php echo htmlspecialchars($taskDate); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="time_slot">Time Slot:</label>
                                        <select id="time_slot" name="time_slot" class="form-control">
                                            <option value="">Select Time Slot</option>
                                            <option value="09:30 AM - 10:30 AM" <?php echo $timeSlot == '09:30 AM - 10:30 AM' ? 'selected' : ''; ?>>09:30 AM - 10:30 AM</option>
                                            <option value="10:30 AM - 11:30 AM" <?php echo $timeSlot == '10:30 AM - 11:30 AM' ? 'selected' : ''; ?>>10:30 AM - 11:30 AM</option>
                                            <option value="11:30 AM - 12:30 PM" <?php echo $timeSlot == '11:30 AM - 12:30 PM' ? 'selected' : ''; ?>>11:30 AM - 12:30 PM</option>
                                            <option value="12:30 PM - 01:30 PM" <?php echo $timeSlot == '12:30 PM - 01:30 PM' ? 'selected' : ''; ?>>12:30 PM - 01:30 PM</option>
                                            <option value="01:30 PM - 02:30 PM" <?php echo $timeSlot == '01:30 PM - 02:30 PM' ? 'selected' : ''; ?>>01:30 PM - 02:30 PM</option>
                                            <option value="02:30 PM - 03:30 PM" <?php echo $timeSlot == '02:30 PM - 03:30 PM' ? 'selected' : ''; ?>>02:30 PM - 03:30 PM</option>
                                            <option value="03:30 PM - 04:30 PM" <?php echo $timeSlot == '03:30 PM - 04:30 PM' ? 'selected' : ''; ?>>03:30 PM - 04:30 PM</option>
                                            <option value="04:30 PM - 05:45 PM" <?php echo $timeSlot == '04:30 PM - 05:45 PM' ? 'selected' : ''; ?>>04:30 PM - 05:45 PM</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="staff_id">Staff:</label>
                                        <select class="form-control" name="staff_id">
                                            <option value="">Select Staff</option>
                                            <?php if ($staffResult->num_rows > 0): ?>
                                                <?php while ($staff = $staffResult->fetch_assoc()): ?>
                                                    <option value="<?php echo $staff['id']; ?>" <?php echo $staffId == $staff['id'] ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($staff['name']); ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 align-self-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="btn btn-secondary">Clear Filters</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Report Table -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Daily Task Report</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dailyTaskTable" class="dataTableLoad table table-bordered table-striped">
                                   <thead>
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
                                        <th>04:30 PM - 05:45 PM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result && $result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['staff_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['task_date']); ?></td>
                                                <td><?php echo htmlspecialchars($row['09:30 AM - 10:30 AM']); ?></td>
                                                <td><?php echo htmlspecialchars($row['10:30 AM - 11:30 AM']); ?></td>
                                                <td><?php echo htmlspecialchars($row['11:30 AM - 12:30 PM']); ?></td>
                                                <td><?php echo htmlspecialchars($row['12:30 PM - 01:30 PM']); ?></td>
                                                <td><?php echo htmlspecialchars($row['01:30 PM - 02:30 PM']); ?></td>
                                                <td><?php echo htmlspecialchars($row['02:30 PM - 03:30 PM']); ?></td>
                                                <td><?php echo htmlspecialchars($row['03:30 PM - 04:30 PM']); ?></td>
                                                <td><?php echo htmlspecialchars($row['04:30 PM - 05:45 PM']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10">No records found for the selected filters.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoor>
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
                                        <th>04:30 PM - 05:45 PM</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>
    </div>

    <?php include '../include/importjs.php'; ?>
  
   
</body>
</html>
