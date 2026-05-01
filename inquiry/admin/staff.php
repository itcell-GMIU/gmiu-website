<?php
include '../include/checklogin.php';


$role_id1 = "3,13,14,15,16,20,21,22,23,25,26,27,28,29";
$status = 0;

// Check for role filter
$roleFilter = isset($_GET['roleFilter']) ? $_GET['roleFilter'] : null;

$query = "SELECT role.name as role_name, staff.password as pass, staff.id as staff_id, staff.name as staff_name, staff.email as staff_email, staff.mobile_number as staff_mobile_number, staff.is_active as staff_is_active, 
    faculty.name as faculty_name, level.name as level_name, program.name as program_name, level.id as level_id FROM tbl_staff as staff
    LEFT JOIN tbl_faculty faculty ON staff.faculty_id = faculty.id 
    LEFT JOIN tbl_level level ON staff.level_id = level.id 
    LEFT JOIN tbl_program program ON staff.program_id = program.id  
    LEFT JOIN tbl_role role ON staff.role_id = role.id
    WHERE staff.is_delete = ? AND role_id IN ($role_id1)";

if ($roleFilter) {
    $query .= " AND role.id = ?";
}

$cmd2 = $con->prepare($query);
if ($roleFilter) {
    $cmd2->bind_param("ii", $status, $roleFilter);
} else {
    $cmd2->bind_param("i", $status);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Staff Details</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Staff Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-center"><b>View Staff Details</b></h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="staff.php">
                                <label for="roleFilter">Filter by Role:</label>
                                <select name="roleFilter" id="roleFilter" class="form-control" onchange="this.form.submit()">
                                    <option value="">All</option>
                                    <?php
                                    $roles = $con->query("SELECT id, name FROM tbl_role WHERE id IN ($role_id1)");
                                    while ($role = $roles->fetch_assoc()) {
                                        $selected = ($role['id'] == $roleFilter) ? 'selected' : '';
                                        echo "<option value='{$role['id']}' $selected>{$role['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </form>
                            <form id="deleteForm">
                                <div class="table-responsive">
                                    <table id="acedemic" class="table table-bordered table-striped">
                                        <thead>
                                            <tr align="center">
                                                <th><input type="checkbox" id="selectAll"></th>
                                                <th>SN</th>
                                                <th>Staff Name</th>
                                                <th>Contact</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Password</th>
                                                <th>Status</th>
                                                <th>Actions</th>
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
                                                <tr align="center" data-id="<?php echo $row['staff_id']; ?>">
                                                    <td><input type="checkbox" name="deleteIds[]" value="<?php echo $row['staff_id']; ?>"></td>
                                                    <td><?php echo $sr; ?></td>
                                                    <td><?php echo $row['staff_name']; ?></td>
                                                    <td><?php echo $row['staff_mobile_number']; ?></td>
                                                    <td><?php echo $row['staff_email']; ?></td>
                                                    <td><?php echo $row['role_name']; ?></td>
                                                    <td><?php echo $row['pass']; ?></td>
                                                    <td><?php echo $row['staff_is_active'] ? 'Active' : 'Inactive'; ?></td>
                                                    <td><a href="#" class="btn btn-danger deleteSingle" data-id="<?php echo $row['staff_id']; ?>">Delete</a></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" id="deleteSelected" class="btn btn-danger">Delete Selected</button>

                            </form>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div><!-- /.container-fluid -->
            </section> <!-- /.content -->
        </div> <!-- /.content-wrapper -->

        <?php include '../include/importfooter.php'; ?>
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>
    <!-- Import JavaScript -->
    <?php include "../include/importjs.php"; ?>
</body>
<script>
    document.getElementById('selectAll').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('input[name="deleteIds[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>

<!-- JavaScript Section -->

<script>
    $(document).ready(function() {
        // Delete selected rows
        $('#deleteSelected').on('click', function() {
            let selectedIds = [];
            $('input[name="deleteIds[]"]:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire({
                    title: "No Selection",
                    text: "Please select at least one staff member to delete.",
                    icon: "warning",
                    confirmButtonText: "OK"
                });
                return;
            }

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '', // If the PHP logic is on the same page
                        type: 'POST',
                        data: {
                            action: 'deleteMultiple',
                            ids: selectedIds
                        },
                        success: function() {
                            location.reload(); // Reload to trigger PHP session-based SweetAlert
                        }
                    });
                }
            });
        });

        // Handle single-row deletion
        $('.deleteSingle').on('click', function(e) {
            e.preventDefault();
            let staffId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '', // Same page for processing
                        type: 'POST',
                        data: {
                            action: 'deleteSingle',
                            id: staffId
                        },
                        success: function() {
                            location.reload(); // Reload to trigger PHP session-based SweetAlert
                        }
                    });
                }
            });
        });
    });
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'deleteMultiple' && !empty($_POST['ids'])) {
            $ids = implode(',', array_map('intval', $_POST['ids']));

            // Prepare the UPDATE query to set is_delete = 1 and is_active = 0
            $stmt = $con->prepare("UPDATE tbl_staff SET is_delete = 1, is_active = 0 WHERE id IN ($ids)");
            if ($stmt->execute()) {
                $_SESSION['status'] = "Selected staff members marked as deleted successfully.";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Failed to mark selected staff members as deleted.";
                $_SESSION['status_code'] = "error";
            }
        } elseif ($_POST['action'] === 'deleteSingle' && !empty($_POST['id'])) {
            $id = intval($_POST['id']);

            // Prepare the UPDATE query to set is_delete = 1 and is_active = 0 for a single staff member
            $stmt = $con->prepare("UPDATE tbl_staff SET is_delete = 1, is_active = 0 WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $_SESSION['status'] = "Staff member marked as deleted successfully.";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Failed to mark the staff member as deleted.";
                $_SESSION['status_code'] = "error";
            }
        }
    }
    // Redirect back to the staff page to show the SweetAlert message
    header("Location: staff.php");
    exit;
}
?>


</html>