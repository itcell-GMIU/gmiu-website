<?php
include './include/config.php';

/* ============================
   GET PARAMS
============================ */
$taskDate = $_GET['task_date'] ?? '';
$staffId = $_GET['staff_id'] ?? '';
$year = $_GET['year'] ?? '';
$shift = $_GET['shift'] ?? 'shift2'; // default shift2

/* ============================
   SHIFT BASED CONFIG
============================ */
if ($shift === 'shift1') {

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
    MAX(CASE WHEN dt.time_slot = '07:00 AM - 08:00 AM'
        THEN dt.task_description END) AS `07:00 AM - 08:00 AM`,
    MAX(CASE WHEN dt.time_slot = '07:00 AM - 08:00 AM'
        THEN dt.id END) AS id_1,

    MAX(CASE WHEN dt.time_slot = '08:00 AM - 09:00 AM'
        THEN dt.task_description END) AS `08:00 AM - 09:00 AM`,
    MAX(CASE WHEN dt.time_slot = '08:00 AM - 09:00 AM'
        THEN dt.id END) AS id_2,

    MAX(CASE WHEN dt.time_slot = '09:00 AM - 10:00 AM'
        THEN dt.task_description END) AS `09:00 AM - 10:00 AM`,
    MAX(CASE WHEN dt.time_slot = '09:00 AM - 10:00 AM'
        THEN dt.id END) AS id_3,

    MAX(CASE WHEN dt.time_slot = '10:00 AM - 11:00 AM'
        THEN dt.task_description END) AS `10:00 AM - 11:00 AM`,
    MAX(CASE WHEN dt.time_slot = '10:00 AM - 11:00 AM'
        THEN dt.id END) AS id_4,

    MAX(CASE WHEN dt.time_slot = '11:00 AM - 12:00 PM'
        THEN dt.task_description END) AS `11:00 AM - 12:00 PM`,
    MAX(CASE WHEN dt.time_slot = '11:00 AM - 12:00 PM'
        THEN dt.id END) AS id_5,

    MAX(CASE WHEN dt.time_slot = '12:00 PM - 01:00 PM'
        THEN dt.task_description END) AS `12:00 PM - 01:00 PM`,
    MAX(CASE WHEN dt.time_slot = '12:00 PM - 01:00 PM'
        THEN dt.id END) AS id_6,

    MAX(CASE WHEN dt.time_slot = '01:00 PM - 02:00 PM'
        THEN dt.task_description END) AS `01:00 PM - 02:00 PM`,
    MAX(CASE WHEN dt.time_slot = '01:00 PM - 02:00 PM'
        THEN dt.id END) AS id_7,

    MAX(CASE WHEN dt.time_slot = '02:00 PM - 03:00 PM'
        THEN dt.task_description END) AS `02:00 PM - 03:00 PM`,
    MAX(CASE WHEN dt.time_slot = '02:00 PM - 03:00 PM'
        THEN dt.id END) AS id_8,

    MAX(CASE WHEN dt.time_slot = '03:00 PM - 03:30 PM'
        THEN dt.task_description END) AS `03:00 PM - 03:30 PM`,
    MAX(CASE WHEN dt.time_slot = '03:00 PM - 03:30 PM'
        THEN dt.id END) AS id_9
";


} else {

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
    MAX(CASE WHEN dt.time_slot IN ('09:30 AM - 10:30 AM','09:45 AM - 10:45 AM')
        THEN dt.task_description END) AS `09:30 AM - 10:30 AM`,
    MAX(CASE WHEN dt.time_slot IN ('09:30 AM - 10:30 AM','09:45 AM - 10:45 AM')
        THEN dt.id END) AS id_1,

    MAX(CASE WHEN dt.time_slot IN ('10:30 AM - 11:30 AM','10:45 AM - 11:45 AM')
        THEN dt.task_description END) AS `10:30 AM - 11:30 AM`,
    MAX(CASE WHEN dt.time_slot IN ('10:30 AM - 11:30 AM','10:45 AM - 11:45 AM')
        THEN dt.id END) AS id_2,

    MAX(CASE WHEN dt.time_slot IN ('11:30 AM - 12:30 PM','11:45 AM - 12:45 PM')
        THEN dt.task_description END) AS `11:30 AM - 12:30 PM`,
    MAX(CASE WHEN dt.time_slot IN ('11:30 AM - 12:30 PM','11:45 AM - 12:45 PM')
        THEN dt.id END) AS id_3,

    MAX(CASE WHEN dt.time_slot IN ('12:30 PM - 01:30 PM','12:45 PM - 01:45 PM')
        THEN dt.task_description END) AS `12:30 PM - 01:30 PM`,
    MAX(CASE WHEN dt.time_slot IN ('12:30 PM - 01:30 PM','12:45 PM - 01:45 PM')
        THEN dt.id END) AS id_4,

    MAX(CASE WHEN dt.time_slot IN ('01:30 PM - 02:30 PM','01:45 PM - 02:45 PM')
        THEN dt.task_description END) AS `01:30 PM - 02:30 PM`,
    MAX(CASE WHEN dt.time_slot IN ('01:30 PM - 02:30 PM','01:45 PM - 02:45 PM')
        THEN dt.id END) AS id_5,

    MAX(CASE WHEN dt.time_slot IN ('02:30 PM - 03:30 PM','02:45 PM - 03:45 PM')
        THEN dt.task_description END) AS `02:30 PM - 03:30 PM`,
    MAX(CASE WHEN dt.time_slot IN ('02:30 PM - 03:30 PM','02:45 PM - 03:45 PM')
        THEN dt.id END) AS id_6,

    MAX(CASE WHEN dt.time_slot IN ('03:30 PM - 04:30 PM','03:45 PM - 04:45 PM')
        THEN dt.task_description END) AS `03:30 PM - 04:30 PM`,
    MAX(CASE WHEN dt.time_slot IN ('03:30 PM - 04:30 PM','03:45 PM - 04:45 PM')
        THEN dt.id END) AS id_7,

    MAX(CASE WHEN dt.time_slot IN ('04:30 PM - 05:30 PM','04:30 PM - 05:45 PM','04:45 PM - 05:45 PM')
        THEN dt.task_description END) AS `04:30 PM - 05:30 PM`,
    MAX(CASE WHEN dt.time_slot IN ('04:30 PM - 05:30 PM','04:30 PM - 05:45 PM','04:45 PM - 05:45 PM')
        THEN dt.id END) AS id_8,

    MAX(CASE WHEN dt.time_slot IN ('05:30 PM - 06:00 PM','05:45 PM - 06:15 PM')
        THEN dt.task_description END) AS `05:30 PM - 06:00 PM`,
    MAX(CASE WHEN dt.time_slot IN ('05:30 PM - 06:00 PM','05:45 PM - 06:15 PM')
        THEN dt.id END) AS id_9
";

}

/* ============================
   STAFF LIST
============================ */
$staffQuery = "SELECT id, name FROM tbl_staff WHERE is_delete = 0 and role_id IN (12,13,14,15,16,21,25,57,59)";
$staffResult = $con->query($staffQuery);

/* ============================
   FINAL SQL
============================ */
$inSlots = "'" . implode("','", $timeSlots) . "'";

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
  AND dt.time_slot IN ($inSlots)
";

if ($taskDate)
    $sql .= " AND dt.task_date = '$taskDate'";
if ($staffId)
    $sql .= " AND dt.staff_id = '$staffId'";
if ($year)
    $sql .= " AND YEAR(dt.task_date) = '$year'";

$sql .= " GROUP BY staff.name, dt.task_date ORDER BY dt.task_date DESC";

$result = $con->query($sql);
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
        <div class="pd-ltr-20">

            <!-- FILTER -->
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <form method="GET">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Date</label>
                            <input type="date" name="task_date" class="form-control" value="<?= $taskDate ?>">
                        </div>

                        <div class="col-md-2">
                            <label>Shift</label>
                            <select name="shift" class="form-control">
                                <option value="shift1" <?= $shift == 'shift1' ? 'selected' : '' ?>>Shift 1</option>
                                <option value="shift2" <?= $shift == 'shift2' ? 'selected' : '' ?>>Shift 2</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Staff</label>
                            <select name="staff_id" class="form-control">
                                <option value="">Select</option>
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
                                <option value="">All</option>
                                <?php for ($y = 2024; $y <= date('Y'); $y++): ?>
                                    <option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-md-2 align-self-end">
                            <button class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- TABLE -->
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <h5 class="mb-20 h5">Review Remark Data</h5>
                <div class="table-responsive">
                    <table class="data-table table table-bordered table-striped w-100">
                        <thead class="thead-light">
                            <tr>
                                <th>Staff Name</th>
                                <th>Task Date</th>

                                <?php foreach ($timeSlots as $slot): ?>
                                    <th><?= $slot ?></th>
                                <?php endforeach; ?>

                                <th>Remarks</th>

                                <?php if ($role_id == 22): ?>
                                    <th>Actions</th>
                                <?php endif; ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr align="center">
                                    <td><?= htmlspecialchars($row['staff_name']) ?></td>
                                    <td><?= htmlspecialchars($row['task_date']) ?></td>

                                    <?php
                                    $i = 1;
                                    foreach ($timeSlots as $slot):
                                        $taskIdKey = 'id_' . $i;
                                        $taskId = $row[$taskIdKey] ?? null;
                                        ?>
                                        <td style="max-width: 250px;
                                            white-space: normal;
                                            word-break: break-word;
                                            overflow-wrap: anywhere;
                                        ">
                                            <?= htmlspecialchars($row[$slot] ?? '') ?>

                                            <?php if (!empty($taskId)): ?>
                                                <br>
                                                <a href="dailytask-view.php?task_id=<?= $taskId ?>" class="text-primary">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            <?php endif; ?>
                                        </td>

                                        <?php $i++; endforeach; ?>


                                    <td><?= htmlspecialchars($row['remark']) ?></td>
                                    <?php if ($role_id == 22): ?>
                                        <td>
                                            <?php if (!empty($row['remark'])): ?>
                                                <a href="dailytask-edit-remark.php?remark_id=<?= $row['remark_id'] ?>"
                                                    class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>
                                            <?php else: ?>
                                                <a href="dailytask-add-remark.php?task_date=<?= $row['task_date'] ?>&staff_id=<?= $row['staff_id'] ?>"
                                                    class="btn btn-sm btn-primary">
                                                    Add
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>

                                </tr>
                            <?php endwhile; ?>
                        </tbody>

                    </table>
                </div>
            </div>

            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>

    <script>
        $('.data-table').DataTable({
            autoWidth: true,
            dom: '<"d-flex justify-content-between"lf>rtip',
            buttons: ['copy', 'csv', 'print']
        });
    </script>

</body>

</html>