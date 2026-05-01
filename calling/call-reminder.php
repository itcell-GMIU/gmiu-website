<?php
include './include/config.php';

// -----------------------------------------------
// ACCESS CONTROL: Only role 15 (Caller) and 16 (Team Lead) can view this page
// -----------------------------------------------
if ($role_id != 15 && $role_id != 16) {
    echo "<script>alert('Access Denied!'); window.location.href='index.php';</script>";
    exit;
}

// -----------------------------------------------
// QUERY: Students who:
//   (a) have NEVER been called, OR
//   (b) whose LAST call was 7+ days ago
// Only open, active, assigned inquiries are shown.
// -----------------------------------------------
$sql = "
    SELECT
        pro.id,
        pro.inq_student_id,
        CONCAT_WS(' ', pro.first_name, pro.middle_name, pro.last_name) AS full_name,
        pro.mobile_number,
        pro.mobile_number2,
        f.shortname  AS faculty_name,
        l.short_name AS level_name,
        p.name       AS program_name,
        s.name       AS staff_name,
        COUNT(cl.id)         AS total_calls,
        MAX(cl.created_at)   AS last_call_date
    FROM tbl_inquiry_student AS pro
    LEFT JOIN tbl_faculty  f  ON f.id  = pro.faculty_id
    LEFT JOIN tbl_level    l  ON l.id  = pro.level_id
    LEFT JOIN tbl_program  p  ON p.id  = pro.program_id
    LEFT JOIN tbl_staff    s  ON s.id  = pro.staff_id
    LEFT JOIN tbl_inquiry_call_logs cl
           ON cl.inq_student_id = pro.inq_student_id
          AND cl.is_active = 1
          AND cl.is_delete = 0
    WHERE pro.is_active          = 1
      AND pro.is_delete          = 0
      AND pro.is_admission_confirm = 0
      AND pro.is_closed          = 0
      AND pro.staff_id IS NOT NULL
      AND pro.staff_id != ''
";

// Role-based filter
if ($role_id == 15 || $role_id == 16) {
    // Caller: see only their own assigned students
    $sql .= " AND pro.staff_id = " . intval($staff_id);
}

$sql .= "
    GROUP BY pro.id
    HAVING
        MAX(cl.created_at) IS NULL                                        -- Never called
        OR MAX(cl.created_at) <= DATE_SUB(NOW(), INTERVAL 7 DAY)         -- Last call 7+ days ago
    ORDER BY last_call_date ASC, pro.id ASC
";

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
        <div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="min-height-200px">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Calls Reminder</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Calls Reminder</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <span class="badge badge-warning" style="font-size:13px; padding:8px 14px;">
                                <i class="fa-solid fa-bell"></i>
                                Students not called in last 7 days (or never called)
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <div class="table-responsive table-sm">
                        <table class="data-table table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Inquiry ID</th>
                                    <th>Full Name</th>
                                    <th><i class="fa-solid fa-phone"></i> Mobile 1</th>
                                    <th><i class="fa-solid fa-phone"></i> Mobile 2</th>
                                    <th>Faculty</th>
                                    <th>Level</th>
                                    <th>Program</th>
                                    <?php if ($role_id == 16) { ?>
                                        <th>Assigned To</th>
                                    <?php } ?>
                                    <th>Total Calls</th>
                                    <th>Last Called On</th>
                                    <th class="datatable-nosort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result && $result->num_rows > 0) {
                                    $sr = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        // Highlight rows never called vs. not called recently
                                        $rowClass = ($row['total_calls'] == 0) ? 'table-danger' : 'table-warning';
                                        $lastCallDisplay = $row['last_call_date']
                                            ? date('d-m-Y h:i A', strtotime($row['last_call_date']))
                                            : '<span class="badge badge-danger">Never Called</span>';
                                        ?>
                                        <tr class="<?= $rowClass ?>">
                                            <td><?= $sr++ ?></td>
                                            <td><strong><?= htmlspecialchars($row['inq_student_id']) ?></strong></td>
                                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                                            <td>
                                                <?php if ($role_id == 15 || $role_id == 16) { ?>
                                                    <?= htmlspecialchars($row['mobile_number']) ?>
                                                <?php } else { ?>
                                                    <span class="text-danger"><i class="fa-solid fa-ban"></i></span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($role_id == 15 || $role_id == 16) { ?>
                                                    <?= htmlspecialchars($row['mobile_number2'] ?: '-') ?>
                                                <?php } else { ?>
                                                    <span class="text-danger"><i class="fa-solid fa-ban"></i></span>
                                                <?php } ?>
                                            </td>
                                            <td><?= htmlspecialchars($row['faculty_name'] ?: '-') ?></td>
                                            <td><?= htmlspecialchars($row['level_name'] ?: '-') ?></td>
                                            <td><?= htmlspecialchars($row['program_name'] ?: '-') ?></td>
                                            <?php if ($role_id == 16) { ?>
                                                <td><?= htmlspecialchars($row['staff_name'] ?: '-') ?></td>
                                            <?php } ?>
                                            <td class="text-center">
                                                <span
                                                    class="badge badge-<?= $row['total_calls'] == 0 ? 'danger' : 'secondary' ?>">
                                                    <?= $row['total_calls'] ?>
                                                </span>
                                            </td>
                                            <td><?= $lastCallDisplay ?></td>
                                            <td>
                                                <a href="candidate-details.php?id=<?= $row['id'] ?>"
                                                    class="btn btn-sm btn-primary" title="View Details">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else { ?>
                                    <tr>
                                        <td colspan="<?= $role_id == 16 ? 12 : 11 ?>" class="text-center text-success">
                                            <i class="fa-solid fa-circle-check"></i>
                                            All assigned students have been called within the last 7 days.
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Legend -->
                    <div class="mt-3">
                        <span class="badge badge-danger" style="padding:6px 10px;">&nbsp;&nbsp;&nbsp;</span>
                        <small class="mr-3">Never Called</small>
                        <span class="badge badge-warning" style="padding:6px 10px;">&nbsp;&nbsp;&nbsp;</span>
                        <small>Not called in last 7 days</small>
                    </div>
                </div>

            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>

    <script>
        $(document).ready(function () {

            var table = $('.data-table').DataTable({

                /* ===== Layout ===== */
                // dom: 'Blfrtip',

                /* ===== Behavior ===== */
                responsive: false,
                autoWidth: false,
                order: [], // preserve server-side order (never-called first, then oldest last-call first)

                /* ===== Disable sort on Action column ===== */
                columnDefs: [
                    {
                        targets: 'datatable-nosort',
                        orderable: false
                    }
                ],

                /* ===== Length menu ===== */
                lengthMenu: [[10, 25, 50], [10, 25, 50]],

                /* ===== Language ===== */
                language: {
                    info: "_START_ - _END_ of _TOTAL_ entries",
                    searchPlaceholder: "Search",
                    emptyTable: "All students have been called recently. Great work!"
                },

                /* ===== Buttons ===== */
                // buttons: [
                //     'copy',
                //     'csv',
                //     'pdf',
                //     'print'
                // ]
            });

            /* ===== Move buttons to custom container ===== */
            table.buttons().container()
                .appendTo('.dataTableLoad_wrapper .col-md-6:eq(0)');

        });
    </script>

</body>

</html>