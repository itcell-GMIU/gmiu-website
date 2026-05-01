<?php
include('include/config.php');

// Security Check: Only SUPER ADMIN or ADMIN can manage users
if (!isset($_SESSION['role_id']) || ($_SESSION['role_id'] != 1 && $_SESSION['role_id'] != 2)) {
    header("Location: index.php");
    exit();
}

$message = '';
$message_type = '';

// Handle Delete (Strictly Super Admin Only)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    if ($_SESSION['role_id'] != 1) {
        $_SESSION['flash_message'] = "Error: You do not have permission to delete users.";
        $_SESSION['flash_type'] = "error";
    } else {
        $delete_id = (int)$_GET['id'];
        
        // Check if trying to delete self
        if ($delete_id == $_SESSION['staff_id']) {
            $_SESSION['flash_message'] = "Error: You cannot delete your own account!";
            $_SESSION['flash_type'] = "error";
        } else {
            $sql = "DELETE FROM tbl_staff WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $delete_id);
            if ($stmt->execute()) {
                $_SESSION['flash_message'] = "User deleted successfully!";
                $_SESSION['flash_type'] = "success";
            } else {
                $_SESSION['flash_message'] = "Error deleting user.";
                $_SESSION['flash_type'] = "error";
            }
        }
    }
    // Redirect to self without query params to prevent re-execution on refresh
    header("Location: user-list.php");
    exit();
}

// Get flash message if exists
$message = isset($_SESSION['flash_message']) ? $_SESSION['flash_message'] : '';
$message_type = isset($_SESSION['flash_type']) ? $_SESSION['flash_type'] : '';

// Important: Clear flash message from session so it won't show again on next refresh
if (!empty($message)) {
    unset($_SESSION['flash_message']);
    unset($_SESSION['flash_type']);
}

$users = [];
$is_view_clicked = isset($_GET['view_data']);

if ($is_view_clicked) {
    $sql = "SELECT s.id, s.name, s.email, s.password, r.name as role_name, s.is_active 
            FROM tbl_staff s 
            LEFT JOIN tbl_role r ON s.role_id = r.id 
            WHERE s.is_delete = 0 AND s.role_id != 1
            ORDER BY s.id DESC";
    $res = $con->query($sql);
    $users = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

?>

<!DOCTYPE html>
<html>
<head>
    <?php include('include/head.php'); ?>
    <title>User Management | TADA Portal</title>
</head>
<body>
    <?php include('include/header.php'); ?>
    <div class="main-container">
        <div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>User Management</h4>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active">User List</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <a href="create-user.php" class="btn btn-outline-primary"><i class="fa fa-user-plus mr-2"></i> Create New User</a>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <form method="GET" action="">
                        <div class="row align-items-end mb-3">
                            <div class="col-md-12 col-sm-12 text-right">
                                <button type="submit" name="view_data" value="1" class="btn btn-outline-primary"><i class="fa fa-eye mr-2"></i> View Data</button>
                            </div>
                        </div>
                    </form>
                    
                    <?php if ($is_view_clicked): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped data-table">
                            <thead>
                                <tr class="text-nowrap">
                                    <th class="all">Sr. No.</th>
                                    <th class="all">Full Name</th>
                                    <th class="d-none d-lg-table-cell">Email</th>
                                    <th class="d-none d-xl-table-cell">Password</th>
                                    <th class="d-none d-md-table-cell">Role</th>
                                    <th class="d-none d-lg-table-cell">Status</th>
                                    <th class="datatable-nosort all">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                foreach ($users as $user): 
                                ?>
                                    <tr>
                                        <td class="all"><span class="badge badge-outline-primary fw-bold"><?= $i++ ?></span></td>
                                        <td class="all"><strong><?= htmlspecialchars($user['name']) ?></strong></td>
                                        <td class="d-none d-lg-table-cell"><?= htmlspecialchars($user['email']) ?></td>
                                        <td class="d-none d-xl-table-cell"><code class="text-primary font-weight-bold"><?= htmlspecialchars($user['password']) ?></code></td>
                                        <td class="d-none d-md-table-cell"><span class="badge badge-secondary"><?= htmlspecialchars($user['role_name']) ?></span></td>
                                        <td class="d-none d-lg-table-cell">
                                            <?php if($user['is_active']): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="all">
                                            <div class="d-flex flex-wrap gap-2 py-1" style="min-width: 150px; gap: 10px;">
                                                <a class="btn btn-sm btn-outline-warning" href="user-edit.php?id=<?= $user['id'] ?>" title="Edit User" data-toggle="tooltip">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <?php if($_SESSION['role_id'] == 1 && $user['id'] != $_SESSION['staff_id']): ?>
                                                <a class="btn btn-sm btn-outline-danger" href="javascript:void(0);" onclick="confirmDelete(<?= $user['id'] ?>, '<?= htmlspecialchars($user['name']) ?>')" title="Delete User" data-toggle="tooltip">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-secondary mb-0">
                        Please click <strong>View Data</strong> to load the user list.
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>
    <script>
        function confirmDelete(id, name) {
            swal({
                title: "Are you sure?",
                text: "You want to delete user: " + name,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = "user-list.php?action=delete&id=" + id;
                }
            });
        }
    </script>
    <script>
        $(document).ready(function () {
            if ($.fn.DataTable.isDataTable('.data-table')) {
                $('.data-table').DataTable().destroy();
            }

            $('.data-table').DataTable({
                scrollCollapse: true,
                autoWidth: false,
                responsive: true,
                columnDefs: [{ targets: "datatable-nosort", orderable: false }],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "language": {
                    "info": "_START_-_END_ of _TOTAL_ entries",
                    "searchPlaceholder": "Search by Name, Email, or Role...",
                    "search": "Filter:"
                },
                dom: '<"d-flex justify-content-between mb-2"lf>rtip'
            });
        });
    </script>
    <?php if ($message): ?>
    <script>
        swal({
            title: "<?= $message ?>",
            icon: "<?= $message_type ?>",
        });
    </script>
    <?php endif; ?>
</body>
</html>
