<?php
include '../include/checklogin.php';

$taskDate = '';
$staffId = '';
$year = '';
$shift = $_GET['shift'] ?? 'shift2'; // default shift2

// Handle GET params
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $taskDate = $_GET['task_date'] ?? '';
    $staffId = $_GET['staff_id'] ?? '';
    $year = $_GET['year'] ?? '';
}

/* ============================
   SHIFT BASED SQL DEFINITIONS
============================ */

if ($shift === 'shift1') {

    // SHIFT 1 TIME SLOTS
    $timeSlots = [
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

    $selectSlotsSQL = "
        MAX(CASE WHEN dt.time_slot = '07:00 AM - 08:00 AM' THEN dt.task_description END) AS `07:00 AM - 08:00 AM`,
        MAX(CASE WHEN dt.time_slot = '08:00 AM - 09:00 AM' THEN dt.task_description END) AS `08:00 AM - 09:00 AM`,
        MAX(CASE WHEN dt.time_slot = '09:00 AM - 10:00 AM' THEN dt.task_description END) AS `09:00 AM - 10:00 AM`,
        MAX(CASE WHEN dt.time_slot = '10:00 AM - 11:00 AM' THEN dt.task_description END) AS `10:00 AM - 11:00 AM`,
        MAX(CASE WHEN dt.time_slot = '11:00 AM - 12:00 PM' THEN dt.task_description END) AS `11:00 AM - 12:00 PM`,
        MAX(CASE WHEN dt.time_slot = '12:00 PM - 01:00 PM' THEN dt.task_description END) AS `12:00 PM - 01:00 PM`,
        MAX(CASE WHEN dt.time_slot = '01:00 PM - 02:00 PM' THEN dt.task_description END) AS `01:00 PM - 02:00 PM`,
        MAX(CASE WHEN dt.time_slot = '02:00 PM - 03:00 PM' THEN dt.task_description END) AS `02:00 PM - 03:00 PM`,
        MAX(CASE WHEN dt.time_slot = '03:00 PM - 03:30 PM' THEN dt.task_description END) AS `03:00 PM - 03:30 PM`
    ";

} else {

    // SHIFT 2 (YOUR EXISTING)
    $timeSlots = [
        '09:30 AM - 10:30 AM',
        '10:30 AM - 11:30 AM',
        '11:30 AM - 12:30 PM',
        '12:30 PM - 01:30 PM',
        '01:30 PM - 02:30 PM',
        '02:30 PM - 03:30 PM',
        '03:30 PM - 04:30 PM',
        '04:30 PM - 05:30 PM',
        '05:30 PM - 06:00 PM'
    ];

    $selectSlotsSQL = "
        MAX(CASE WHEN dt.time_slot IN ('09:30 AM - 10:30 AM','09:45 AM - 10:45 AM') THEN dt.task_description END) AS `09:30 AM - 10:30 AM`,
        MAX(CASE WHEN dt.time_slot IN ('10:30 AM - 11:30 AM','10:45 AM - 11:45 AM') THEN dt.task_description END) AS `10:30 AM - 11:30 AM`,
        MAX(CASE WHEN dt.time_slot IN ('11:30 AM - 12:30 PM','11:45 AM - 12:45 PM') THEN dt.task_description END) AS `11:30 AM - 12:30 PM`,
        MAX(CASE WHEN dt.time_slot IN ('12:30 PM - 01:30 PM','12:45 PM - 01:45 PM') THEN dt.task_description END) AS `12:30 PM - 01:30 PM`,
        MAX(CASE WHEN dt.time_slot IN ('01:30 PM - 02:30 PM','01:45 PM - 02:45 PM') THEN dt.task_description END) AS `01:30 PM - 02:30 PM`,
        MAX(CASE WHEN dt.time_slot IN ('02:30 PM - 03:30 PM','02:45 PM - 03:45 PM') THEN dt.task_description END) AS `02:30 PM - 03:30 PM`,
        MAX(CASE WHEN dt.time_slot IN ('03:30 PM - 04:30 PM','03:45 PM - 04:45 PM') THEN dt.task_description END) AS `03:30 PM - 04:30 PM`,
        MAX(CASE WHEN dt.time_slot IN ('04:30 PM - 05:30 PM','04:30 PM - 05:45 PM','04:45 PM - 05:45 PM') THEN dt.task_description END) AS `04:30 PM - 05:30 PM`,
        MAX(CASE WHEN dt.time_slot IN ('05:30 PM - 06:00 PM','05:45 PM - 06:15 PM') THEN dt.task_description END) AS `05:30 PM - 06:00 PM`
    ";
}

/* ============================
   STAFF LISTING
============================ */
if ($role_id == 23) {
    $staffQuery = "SELECT id, name FROM tbl_staff WHERE role_id IN (20,21) AND is_delete = 0";
} elseif ($role_id == 11) {
    $staffQuery = "SELECT id, name FROM tbl_staff WHERE id IN (2123,2122,2282,2266) AND is_delete = 0";
} else {
    $staffQuery = "SELECT id, name FROM tbl_staff WHERE role_id IN (20,16) AND is_delete = 0";
}
$staffResult = $con->query($staffQuery);

/* ============================
   FINAL SQL
============================ */

$sql = "
SELECT 
    staff.id AS staff_id,
    staff.name AS staff_name,
    dt.task_date,
    $selectSlotsSQL,
    dr.comments AS remark,
    dr.id AS remark_id
FROM tbl_daily_task dt
JOIN tbl_staff staff ON staff.id = dt.staff_id
LEFT JOIN tbl_daily_review dr 
    ON dr.staff_id = dt.staff_id 
   AND dr.task_date = dt.task_date
WHERE dt.is_delete = 0
";

/* role filters */
if ($role_id == 23)
    $sql .= " AND staff.role_id IN (20,21)";
if ($role_id == 11)
    $sql .= " AND staff.id IN (2123,2122,2282,2266)";

/* shift filter */
$inSlots = "'" . implode("','", $timeSlots) . "'";
$sql .= " AND dt.time_slot IN ($inSlots)";

/* other filters */
if ($taskDate)
    $sql .= " AND dt.task_date = '$taskDate'";
if ($staffId)
    $sql .= " AND dt.staff_id = '$staffId'";
if ($year)
    $sql .= " AND YEAR(dt.task_date) = '$year'";

$sql .= " GROUP BY staff.name, dt.task_date ORDER BY dt.task_date";

$result = $con->query($sql);
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
            <section class="content">
                <div class="container-fluid">

                    <!-- FILTER -->
                    <div class="card">
                        <div class="card-body">
                            <form method="GET">
                                <div class="row">

                                    <div class="col-md-2">
                                        <label>Task Date</label>
                                        <input type="date" name="task_date" class="form-control"
                                            value="<?= $taskDate ?>">
                                    </div>

                                    <div class="col-md-2">
                                        <label>Shift</label>
                                        <select name="shift" class="form-control">
                                            <option value="shift1" <?= $shift == 'shift1' ? 'selected' : '' ?>>Shift 1
                                            </option>
                                            <option value="shift2" <?= $shift == 'shift2' ? 'selected' : '' ?>>Shift 2
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Staff</label>
                                        <select name="staff_id" class="form-control">
                                            <option value="">Select Staff</option>
                                                                                        <?php while ($s = $staffResult->fetch_assoc()): ?>
                                                <option value="<?= $s['id'] ?>" <?= $staffId == $s['id'] ? 'selected' : '' ?>>
                                                                                                        <?= htmlspecialchars($s['name']) ?>
                                                </option>
                                                                                        <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Year</label>
                                        <select name="year" class="form-control">
                                            <option value="">Select Year</option>
                                                                                        <?php for ($y = 2024; $y <= date('Y'); $y++): ?>
                                                <option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>><?= $y ?>
                                                </option>
                                                                                        <?php endfor; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2 align-self-end">
                                        <button class="btn btn-primary">Filter</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- TABLE -->
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr align="center">
                                        <th>Staff Name</th>
                                        <th>Task Date</th>
                                                                                <?php foreach ($timeSlots as $slot): ?>
                                            <th><?= $slot ?></th>
                                                                                <?php endforeach; ?>
                                        <th>Remarks</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                                                        <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr align="center">
                                            <td><?= htmlspecialchars($row['staff_name']) ?></td>
                                            <td><?= $row['task_date'] ?></td>

                                                                                        <?php foreach ($timeSlots as $slot): ?>
                                                <td><?= htmlspecialchars($row[$slot] ?? '') ?></td>
                                                                                        <?php endforeach; ?>

                                            <td><?= htmlspecialchars($row['remark']) ?></td>
                                            <td>
                                                                                                <?php if ($row['remark']): ?>
                                                    <a href="edit_remark.php?remark_id=<?= $row['remark_id'] ?>"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                                                                <?php else: ?>
                                                    <a href="add_remark.php?task_date=<?= $row['task_date'] ?>&staff_id=<?= $row['staff_id'] ?>"
                                                        class="btn btn-primary btn-sm">Add</a>
                                                                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                                                        <?php endwhile; ?>
                                </tbody>

                                <tfoot>
                                    <tr align="center">
                                        <th>Staff Name</th>
                                        <th>Task Date</th>
                                                                                <?php foreach ($timeSlots as $slot): ?>
                                            <th><?= $slot ?></th>
                                                                                <?php endforeach; ?>
                                        <th>Remarks</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>

                            </table>
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