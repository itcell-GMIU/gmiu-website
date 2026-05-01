<?php
include './include/config.php';

// --- PHP LOGIC FROM OLD TEMPLATE ---
if ($role_id == 60) {
    $role_id1 = "12,13,14,15,16,21,25,57,59,11,22";
} else {
    $role_id1 = "12,13,14,15,16,21,25,57,59";
}
$status = 0;

// Prepare the SQL query to fetch all staff details
$cmd2 = $con->prepare("
    SELECT 
        staff.faculty_id,
        staff.level_id,
        staff.program_id,
        role.name AS role_name,
        staff.password AS pass,
        staff.id AS staff_id,
        staff.name AS staff_name,
        staff.email AS staff_email,
        staff.mobile_number AS staff_mobile_number,
        staff.is_active AS staff_is_active,
        faculty.name AS faculty_name,
        level.name AS level_name,
        program.name AS program_name,
        GROUP_CONCAT(under_staff.name SEPARATOR ', ') AS under_staff_names
    FROM 
        tbl_staff AS staff
    LEFT JOIN 
        tbl_faculty AS faculty ON staff.faculty_id = faculty.id 
    LEFT JOIN 
        tbl_level AS level ON staff.level_id = level.id 
    LEFT JOIN 
        tbl_program AS program ON staff.program_id = program.id  
    LEFT JOIN 
        tbl_role AS role ON staff.role_id = role.id
    LEFT JOIN 
        tbl_staff AS under_staff 
        ON FIND_IN_SET(under_staff.id, staff.under_staff_id) 
        AND under_staff.is_delete = '0'
    WHERE 
        staff.is_delete = ? 
        AND staff.role_id IN ($role_id1)
    GROUP BY 
        staff.id
    ORDER BY
        staff.id DESC
");

$cmd2->bind_param("i", $status);

// =================== DELETE DAILY TASK ===================
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {

    // Optional: restrict delete by role
    if ($role_id != 57) {
        $_SESSION['status'] = "Unauthorized action!";
        $_SESSION['status_code'] = "error";
        header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
        exit;
    }

    $delete_id = (int) $_GET['delete_id'];

    // Soft delete task
    $stmt = $con->prepare("
        UPDATE tbl_staff 
        SET is_delete = 1, is_active = 0
        WHERE id = ?
    ");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();

    // Optional: also soft-delete related photos
    $stmt2 = $con->prepare("
        UPDATE tbl_inquiry_photos 
        SET is_delete = 1 
        WHERE type_id = ? AND type = 'dailytask_add'
    ");
    $stmt2->bind_param("i", $delete_id);
    $stmt2->execute();

    $_SESSION['status'] = "Staff deleted successfully";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_redirect'] = "staff-veiw.php";
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
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
        <div class="pd-ltr-20  height-100-p xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>View Staff Details</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Staff Details</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <a class="btn btn-primary" href="staff_insert.php">
                                <i class="fa fa-plus"></i> Add Staff
                            </a>
                        </div>
                    </div>
                </div>
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <div class="table-responsive table-sm">
                        <table class="data-table table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Staff Name</th>
                                    <th>Faculty</th>
                                    <th>Level</th>
                                    <th>Program</th>
                                    <th>Under Staff</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Password</th>
                                    <th>Status</th>
                                    <th class="datatable-nosort">Manage</th>
                                    <?php if ($role_id == 60) { ?>
                                        <th class="datatable-nosort">Login</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sr = 0;
                                $cmd2->execute();
                                $result = $cmd2->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    $sr++;
                                    ?>
                                    <tr>
                                        <td><?= $sr; ?></td>
                                        <td><?= htmlspecialchars($row['staff_name'] ?? 'N/A'); ?></td>
                                        <td><?= ($row['faculty_name'] ?? 'N/A'); ?></td>
                                        <td><?= ($row['level_name'] ?? 'N/A'); ?></td>
                                        <td><?= ($row['program_name'] ?? 'N/A'); ?></td>
                                        <td>
                                            <?php
                                            if (!empty($row['under_staff_names'])) {
                                                $names = explode(',', $row['under_staff_names']); // assuming names are comma separated
                                                foreach ($names as $i => $name) {
                                                    echo htmlspecialchars(trim($name));
                                                    if (($i + 1) % 2 == 0) {
                                                        echo "<br>"; // new line after every 2 names
                                                    } else {
                                                        echo ", "; // separator for readability
                                                    }
                                                }
                                            } else {
                                                echo "N/A";
                                            }
                                            ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['staff_mobile_number'] ?? 'N/A'); ?></td>
                                        <td><?= htmlspecialchars($row['staff_email'] ?? 'N/A'); ?></td>
                                        <td><?= htmlspecialchars($row['role_name'] ?? 'N/A'); ?></td>
                                        <td><?= htmlspecialchars($row['pass'] ?? 'N/A'); ?></td>
                                        <td>
                                            <?php if ($row['staff_is_active']) {
                                                echo '<span class="badge badge-success">Active</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">Inactive</span>';
                                            } ?>
                                        </td>
                                        <td>
                                            <a href="staff-edit.php?id=<?= $row['staff_id'] ?>"
                                                class="btn btn-primary btn-sm" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="staff-veiw.php?delete_id=<?= $row['staff_id'] ?>"
                                                class="btn btn-danger btn-sm delete-task" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                        <?php if ($role_id == 60) { ?>
                                            <td>
                                                <a href="staff-login.php?staff_id=<?= $row['staff_id'] ?>"
                                                    class="btn btn-success btn-sm" title="Login">
                                                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                </a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>

    <!-- <script>
        $(document).ready(function () {
            $('.data-table').DataTable({
                scrollX: true,          // ✅ Enables horizontal scrolling
                scrollCollapse: true,
                autoWidth: false,
                responsive: false,      // ✅ Turn off collapsing mode for full control
                columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false,
                }],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "language": {
                    "info": "_START_-_END_ of _TOTAL_ entries",
                    searchPlaceholder: "Search"
                },
                dom: '<"d-flex justify-content-between"lBf>rtip',
                buttons: [
                    'copy', 'csv', 'pdf', 'print'
                ]
            });
        });
    </script> -->

    <script>
        $(document).ready(function () {

            var table = $('.data-table').DataTable({

                /* ===== Layout ===== */
                dom: 'Blfrtip',

                /* ===== Scrolling ===== */
                // scrollX: true,          // horizontal scroll
                // scrollCollapse: true,

                /* ===== Behavior ===== */
                responsive: false,
                autoWidth: false,
                order: [],

                /* ===== Disable sort on specific columns ===== */
                columnDefs: [
                    {
                        targets: 'datatable-nosort',
                        orderable: false
                    }
                ],

                /* ===== Length menu ===== */
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],

                /* ===== Language ===== */
                language: {
                    info: "_START_ - _END_ of _TOTAL_ entries",
                    searchPlaceholder: "Search"
                },

                /* ===== Buttons ===== */
                buttons: [
                    'copy',
                    'csv',
                    'pdf',
                    'print'
                ]
            });

            /* ===== Move buttons to custom container ===== */
            table.buttons().container()
                .appendTo('.dataTableLoad_wrapper .col-md-6:eq(0)');

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-task').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');

                    if (confirm("Are you sure you want to delete this task?")) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>

</body>

</html>