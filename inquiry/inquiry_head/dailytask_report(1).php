<?php
include '../include/checklogin.php';
$taskDate = '';
$timeSlot = '';
$staffId = '';
$year = '';

// Handle GET params
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $taskDate = $_GET['task_date'] ?? '';
    $timeSlot = $_GET['time_slot'] ?? '';
    $staffId = $_GET['staff_id'] ?? '';
    $year = $_GET['year'] ?? '';

    if (isset($_GET['clear_date'])) {
        $taskDate = '';
    }
}

// Staff listing
if ($role_id == 23) {
    $staffQuery = "SELECT id, name FROM tbl_staff WHERE role_id IN (20, 21) AND is_delete = 0";
} elseif ($role_id == 11) {
    $staffQuery = "SELECT id, name FROM tbl_staff WHERE id IN (2123,2122,2282,2266) AND is_delete = 0";
} else {
    $staffQuery = "SELECT id, name FROM tbl_staff WHERE role_id IN (20,16) AND is_delete = 0";
}
$staffResult = $con->query($staffQuery);

// -----------------------------------------
// UPDATED SQL WITH NEW TIME SLOTS
// -----------------------------------------

$sql = "
SELECT 
    staff.id   AS staff_id,
    staff.name AS staff_name,
    dt.task_date,

    /* SLOT DATA */
    MAX(CASE WHEN dt.time_slot IN ('09:30 AM - 10:30 AM','09:45 AM - 10:45 AM')
        THEN dt.task_description END) AS `09:30 AM - 10:30 AM`,

    MAX(CASE WHEN dt.time_slot IN ('10:30 AM - 11:30 AM','10:45 AM - 11:45 AM')
        THEN dt.task_description END) AS `10:30 AM - 11:30 AM`,

    MAX(CASE WHEN dt.time_slot IN ('11:30 AM - 12:30 PM','11:45 AM - 12:45 PM')
        THEN dt.task_description END) AS `11:30 AM - 12:30 PM`,

    MAX(CASE WHEN dt.time_slot IN ('12:30 PM - 01:30 PM','12:45 PM - 01:45 PM')
        THEN dt.task_description END) AS `12:30 PM - 01:30 PM`,

    MAX(CASE WHEN dt.time_slot IN ('01:30 PM - 02:30 PM','01:45 PM - 02:45 PM')
        THEN dt.task_description END) AS `01:30 PM - 02:30 PM`,

    MAX(CASE WHEN dt.time_slot IN ('02:30 PM - 03:30 PM','02:45 PM - 03:45 PM')
        THEN dt.task_description END) AS `02:30 PM - 03:30 PM`,

    MAX(CASE WHEN dt.time_slot IN ('03:30 PM - 04:30 PM','03:45 PM - 04:45 PM')
        THEN dt.task_description END) AS `03:30 PM - 04:30 PM`,

    MAX(CASE WHEN dt.time_slot IN (
        '04:30 PM - 05:30 PM',
        '04:30 PM - 05:45 PM',
        '04:45 PM - 05:45 PM'
    ) THEN dt.task_description END) AS `04:30 PM - 05:30 PM`,

    MAX(CASE WHEN dt.time_slot IN ('05:30 PM - 06:00 PM','05:45 PM - 06:15 PM')
        THEN dt.task_description END) AS `05:30 PM - 06:00 PM`,

    /* SLOT IDS FOR VIEW ICON */
    MAX(CASE WHEN dt.time_slot IN ('09:30 AM - 10:30 AM','09:45 AM - 10:45 AM') THEN dt.id END) AS id_1,
    MAX(CASE WHEN dt.time_slot IN ('10:30 AM - 11:30 AM','10:45 AM - 11:45 AM') THEN dt.id END) AS id_2,
    MAX(CASE WHEN dt.time_slot IN ('11:30 AM - 12:30 PM','11:45 AM - 12:45 PM') THEN dt.id END) AS id_3,
    MAX(CASE WHEN dt.time_slot IN ('12:30 PM - 01:30 PM','12:45 PM - 01:45 PM') THEN dt.id END) AS id_4,
    MAX(CASE WHEN dt.time_slot IN ('01:30 PM - 02:30 PM','01:45 PM - 02:45 PM') THEN dt.id END) AS id_5,
    MAX(CASE WHEN dt.time_slot IN ('02:30 PM - 03:30 PM','02:45 PM - 03:45 PM') THEN dt.id END) AS id_6,
    MAX(CASE WHEN dt.time_slot IN ('03:30 PM - 04:30 PM','03:45 PM - 04:45 PM') THEN dt.id END) AS id_7,
    MAX(CASE WHEN dt.time_slot IN (
        '04:30 PM - 05:30 PM',
        '04:30 PM - 05:45 PM',
        '04:45 PM - 05:45 PM'
    ) THEN dt.id END) AS id_8,
    MAX(CASE WHEN dt.time_slot IN ('05:30 PM - 06:00 PM','05:45 PM - 06:15 PM') THEN dt.id END) AS id_9,

    dr.comments AS remark,
    dr.id       AS remark_id

FROM tbl_daily_task dt
JOIN tbl_staff staff 
    ON staff.id = dt.staff_id

LEFT JOIN tbl_daily_review dr
    ON dr.staff_id = dt.staff_id
   AND dr.task_date = dt.task_date

WHERE dt.is_delete = 0
 
";

// role-based filter
if ($role_id == 23) $sql .= " AND staff.role_id IN (20,21)";
if ($role_id == 11) $sql .= " AND staff.id IN (2123,2122,2282,2266)";

// dynamic filters
$conditions = [];
if (!empty($taskDate)) $conditions[] = "dt.task_date = ?";
if (!empty($timeSlot)) $conditions[] = "dt.time_slot = ?";
if (!empty($staffId)) $conditions[] = "dt.staff_id = ?";
if (!empty($year)) $conditions[] = "YEAR(dt.task_date) = ?";

if (!empty($conditions)) {
    $sql .= " AND " . implode(' AND ', $conditions);
}

$sql .= " GROUP BY staff.name, dt.task_date ORDER BY dt.task_date;";

$stmt = $con->prepare($sql);
if ($stmt) {
    $params = [];
    $types = '';

    if (!empty($taskDate)) { $params[] = $taskDate; $types .= 's'; }
    if (!empty($timeSlot)) { $params[] = $timeSlot; $types .= 's'; }
    if (!empty($staffId))  { $params[] = $staffId;  $types .= 'i'; }
    if (!empty($year))     { $params[] = $year;     $types .= 'i'; }

    if (!empty($types)) $stmt->bind_param($types, ...$params);

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
                                    <div class="col-md-2">
                                        <label for="task_date">Task Date:</label>
                                        <input type="date" class="form-control" name="task_date" value="<?php echo htmlspecialchars($taskDate); ?>">
                                    </div>
                                  <div class="col-md-3">
                                        <label for="time_slot">Time Slot:</label>
                                        <select id="time_slot" name="time_slot" class="form-control">
                                            <option value="">---Select Time Slot---</option>
                                            <option value="09:30 AM - 10:30 AM" <?= $timeSlot == '09:30 AM - 10:30 AM' ? 'selected' : ''; ?>>09:30 AM - 10:30 AM</option>
                                            <option value="10:30 AM - 11:30 AM" <?= $timeSlot == '10:30 AM - 11:30 AM' ? 'selected' : ''; ?>>10:30 AM - 11:30 AM</option>
                                            <option value="11:30 AM - 12:30 PM" <?= $timeSlot == '11:30 AM - 12:30 PM' ? 'selected' : ''; ?>>11:30 AM - 12:30 PM</option>
                                            <option value="12:30 PM - 01:30 PM" <?= $timeSlot == '12:30 PM - 01:30 PM' ? 'selected' : ''; ?>>12:30 PM - 01:30 PM</option>
                                            <option value="01:30 PM - 02:30 PM" <?= $timeSlot == '01:30 PM - 02:30 PM' ? 'selected' : ''; ?>>01:30 PM - 02:30 PM</option>
                                            <option value="02:30 PM - 03:30 PM" <?= $timeSlot == '02:30 PM - 03:30 PM' ? 'selected' : ''; ?>>02:30 PM - 03:30 PM</option>
                                            <option value="03:30 PM - 04:30 PM" <?= $timeSlot == '03:30 PM - 04:30 PM' ? 'selected' : ''; ?>>03:30 PM - 04:30 PM</option>
                                            <option value="04:30 PM - 05:30 PM" <?= $timeSlot == '04:30 PM - 05:30 PM' ? 'selected' : ''; ?>>04:30 PM - 05:30 PM</option>
                                            <option value="05:30 PM - 06:00 PM" <?= $timeSlot == '05:30 PM - 06:00 PM' ? 'selected' : ''; ?>>05:30 PM - 06:00 PM</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="staff_id">Staff:</label>
                                        <select class="form-control" name="staff_id">
                                            <option value="">Select Staff</option>
                                            <?php if ($staffResult->num_rows > 0) : ?>
                                                <?php while ($staff = $staffResult->fetch_assoc()) : ?>
                                                    <option value="<?php echo $staff['id']; ?>" <?php echo $staffId == $staff['id'] ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($staff['name']); ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="year">Year:</label>
                                        <select name="year" class="form-control">
                                            <option value="">Select Year</option>
                                            <?php 
                                            $currentYear = date("Y");
                                            for ($y = 2024; $y <= $currentYear; $y++) {
                                                $selected = ($year == $y) ? 'selected' : '';
                                                echo "<option value='$y' $selected>$y</option>";
                                            }
                                            ?>
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

                    <div class="card">
                        <div class="card-header">
                            <h3>Daily Task Report</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                   <thead>
                                    <tr align="center">
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
                                        <th>Actions</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <?php if ($result && $result->num_rows > 0) : ?>
                                            <?php while ($row = $result->fetch_assoc()) : ?>
                                                <tr align="center">
                                                    <td scope="row"><?php echo htmlspecialchars($row['staff_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['task_date']); ?></td>

                                                    <?php
                                                    // Loop through each time slot
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


                                                    // Iterate through the time slots
                                                    foreach ($time_slots as $slot) {
                                                        $time = $slot['time'];
                                                        $id = $slot['id'];
                                                        $task_id = $row[$id];

                                                        echo '<td scope="row">';
                                                        echo htmlspecialchars($row[$time]);

                                                        // Check if task_id is not null and show the View button accordingly
                                                        if (!empty($task_id)) {
                                                            
                                                            echo '<br> <a href="../counselor/dailytask_view.php?task_id=' . $task_id . '"><i class="fa fa-eye"></i></a>';
                                                        }

                                                        echo '</td>';
                                                    }
                                                    ?>

                                                    <td scope="row"><?php echo htmlspecialchars($row['remark']); ?></td>
                                                    <td scope="row">
                                                        <?php if (!empty($row['remark'])) : ?>
                                                            <!-- If remarks exist, show View and Edit buttons -->
                                                            <a href="edit_remark.php?remark_id=<?php echo $row['remark_id']; ?>" class="btn btn-warning">Edit</a>
                                                        <?php else : ?>
                                                            <!-- If no remarks exist, show Add Remark button -->
                                                            <a href="add_remark.php?task_date=<?php echo $row['task_date']; ?>&staff_id=<?php echo $row['staff_id']; ?>" class="btn btn-primary">Add</a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>

                                            <?php endwhile; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="10" class="text-center">No records found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
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
                                            <th>Actions</th>
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
</body>
<!-- Include jQuery and DataTables JS -->
<?php include '../include/importjs.php'; ?>

</html>