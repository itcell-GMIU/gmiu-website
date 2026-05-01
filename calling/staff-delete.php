<?php
include './include/config.php';

// --- DELETION LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    if ($_POST['action'] === 'deleteMultiple' && !empty($_POST['ids'])) {
        $ids = implode(',', array_map('intval', $_POST['ids']));
        $stmt = $con->prepare("UPDATE tbl_staff SET is_delete = 1, is_active = 0 WHERE id IN ($ids)");
        if ($stmt->execute()) {
            $_SESSION['status'] = "Selected users were deleted successfully.";
            $_SESSION['status_code'] = "success";
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete selected users.']);
        }
    } elseif ($_POST['action'] === 'deleteSingle' && !empty($_POST['id'])) {
        $id = intval($_POST['id']);
        $stmt = $con->prepare("UPDATE tbl_staff SET is_delete = 1, is_active = 0 WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $_SESSION['status'] = "User was deleted successfully.";
            $_SESSION['status_code'] = "success";
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete the user.']);
        }
    }
    exit;
}

// --- DATA FETCHING LOGIC ---
$role_id1 = "3,13,14,15,16,20,21,22,23,25,26,27,28,29";
$status = 0;
$roleFilter = isset($_GET['roleFilter']) ? $_GET['roleFilter'] : null;
$query = "SELECT role.name as role_name, staff.password as pass, staff.id as staff_id, staff.name as staff_name, staff.email as staff_email, staff.mobile_number as staff_mobile_number, staff.is_active as staff_is_active
    FROM tbl_staff as staff
    LEFT JOIN tbl_role role ON staff.role_id = role.id
    WHERE staff.is_delete = ? AND staff.role_id IN ($role_id1)";
if ($roleFilter) {
    $query .= " AND role.id = ?";
}
$query .= " ORDER BY staff.id DESC";
$cmd2 = $con->prepare($query);
if ($roleFilter) {
    $cmd2->bind_param("ii", $status, $roleFilter);
} else {
    $cmd2->bind_param("i", $status);
}
$cmd2->execute();
$result = $cmd2->get_result();
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
                                <h4>User Management</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <a class="btn btn-primary" href="staff_insert.php">
                                <i class="fa fa-plus"></i> Add User
                            </a>
                        </div>
                    </div>
                </div>
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <!-- Role Filter Form -->
                    <form method="GET" action="" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="roleFilter">Filter by Role:</label>
                                <select name="roleFilter" id="roleFilter" class="form-control"
                                    onchange="this.form.submit()">
                                    <option value="">All Roles</option>
                                    <?php
                                    $roles = $con->query("SELECT id, name FROM tbl_role WHERE id IN ($role_id1) ORDER BY name");
                                    while ($role = $roles->fetch_assoc()) {
                                        $selected = ($role['id'] == $roleFilter) ? 'selected' : '';
                                        echo "<option value='{$role['id']}' $selected>{$role['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </form>

                    <!-- Data Table -->
                    <div class="table-responsive table-sm">
                        <table class="data-table table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
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
                                while ($row = $result->fetch_assoc()) {
                                    $sr++;
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="deleteIds[]" value="<?= $row['staff_id']; ?>"></td>
                                        <td><?= $sr; ?></td>
                                        <td><?= htmlspecialchars($row['staff_name']); ?></td>
                                        <td><?= htmlspecialchars($row['staff_mobile_number']); ?></td>
                                        <td><?= htmlspecialchars($row['staff_email']); ?></td>
                                        <td><?= htmlspecialchars($row['role_name']); ?></td>
                                        <td><?= htmlspecialchars($row['pass']); ?></td>
                                        <td>
                                            <?php if ($row['staff_is_active']) {
                                                echo '<span class="badge badge-success">Active</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">Inactive</span>';
                                            } ?>
                                        </td>
                                        <td>
                                            <a href="staff_edit.php?id=<?= $row['staff_id'] ?>"
                                                class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <button class="btn btn-danger btn-sm deleteSingle"
                                                data-id="<?= $row['staff_id'] ?>" title="Delete"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" id="deleteSelected" class="btn btn-danger mt-3"><i class="fa fa-trash"></i>
                        Delete Selected</button>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>

    <script>
        $(document).ready(function () {
            // --- DATATABLE INITIALIZATION ---
            var table = $('.data-table').DataTable({ // <-- Store table in a variable
                // scrollX: true,
                // scrollCollapse: true,
                autoWidth: false,
                responsive: false,
                columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false,
                }],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "language": {
                    "info": "_START_-_END_ of _TOTAL_ entries",
                    searchPlaceholder: "Search"
                },
            });

            // --- DELETION & SELECTION SCRIPT ---

            // 'Select All' checkbox functionality
            $('#selectAll').on('click', function () {
                var rows = table.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            // ** NEW ** When a row checkbox is changed, update the header checkbox
            $('.data-table tbody').on('change', 'input[type="checkbox"]', function () {
                // If this checkbox is unchecked, uncheck the 'selectAll'
                if (!this.checked) {
                    $('#selectAll').prop('checked', false);
                }
                // Otherwise, check if all other checkboxes are checked
                else {
                    var totalCheckboxes = table.rows({ 'search': 'applied' }).nodes().to$().find('tbody input[type="checkbox"]').length;
                    var checkedCheckboxes = table.rows({ 'search': 'applied' }).nodes().to$().find('tbody input[type="checkbox"]:checked').length;
                    // If they are all checked, check the 'selectAll' checkbox
                    if (totalCheckboxes === checkedCheckboxes) {
                        $('#selectAll').prop('checked', true);
                    }
                }
            });

            // ** NEW ** Update header checkbox state on table draw (e.g., pagination, search)
            table.on('draw', function () {
                var totalCheckboxes = table.rows({ 'search': 'applied' }).nodes().to$().find('tbody input[type="checkbox"]').length;
                var checkedCheckboxes = table.rows({ 'search': 'applied' }).nodes().to$().find('tbody input[type="checkbox"]:checked').length;
                $('#selectAll').prop('checked', totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes);
            });

            // Function to handle the delete AJAX call
            function performDelete(action, ids) {
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success margin-5',
                    cancelButtonClass: 'btn btn-danger margin-5',
                    buttonsStyling: false
                }).then(function () {
                    // ✅ User confirmed delete
                    $.ajax({
                        url: '', // same page
                        type: 'POST',
                        data: { action: action, ids: ids, id: ids },
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === 'success') {
                                location.reload();
                            } else {
                                swal(
                                    'Error!',
                                    response.message || 'An unknown error occurred.',
                                    'error'
                                );
                            }
                        },
                        error: function () {
                            swal(
                                'Error!',
                                'Could not connect to the server.',
                                'error'
                            );
                        }
                    });
                }, function (dismiss) {
                    // ❌ User clicked cancel
                    if (dismiss === 'cancel') {
                        swal(
                            'Cancelled',
                            'Your data is safe :)',
                            'error'
                        )
                    }
                });
            }

            // 'Delete Selected' button click event
            $('#deleteSelected').on('click', function () {
                let selectedIds = [];
                table.$('input[name="deleteIds[]"]:checked').each(function () {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length === 0) {
                    Swal.fire("No Selection", "Please select at least one user to delete.", "warning");
                    return;
                }
                performDelete('deleteMultiple', selectedIds);
            });

            // Single delete button click event (uses event delegation)
            $('.data-table tbody').on('click', '.deleteSingle', function () {
                let staffId = $(this).data('id');
                performDelete('deleteSingle', staffId);
            });
        });
    </script>

</body>

</html>