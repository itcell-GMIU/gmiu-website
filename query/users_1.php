<?php
include './include/checklogin.php'; // session/login check
// ensure $con is available (if not already inside checklogin)

// ----------------------
// 1. Fetch Data Securely
// ----------------------
$users = [];
$sql_users = "SELECT *
              FROM tbl_runtime_query 
              ORDER BY id DESC";

if ($stmt = $con->prepare($sql_users)) {
    $stmt->execute();
    $result_users = $stmt->get_result();
    while ($row_users = $result_users->fetch_assoc()) {
        $users[] = $row_users;
    }
    $stmt->close();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $query_id = isset($_POST['student_id']) ? intval($_POST['student_id']) : 0;
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($query_id > 0 && in_array($action, ['approve', 'reject'])) {

        // Map action to database value
        $status_value = ($action == 'approve') ? 'approved' : 'rejected';
        $current_time = date('Y-m-d H:i:s');

        // Update tbl_runtime_query
        $sql = "UPDATE tbl_runtime_query 
                SET status = ?, updated_at = ? 
                WHERE id = ?";

        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("ssi", $status_value, $current_time, $query_id);

            if ($stmt->execute()) {
                $_SESSION['status'] = "Query has been " . $status_value . " successfully!";
                $_SESSION['status_code'] = "success";
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "users.php";
                        }, 2000); // 2000ms = 2 seconds
                    </script>';
            } else {
                $_SESSION['status'] = "Database error: " . $stmt->error;
                $_SESSION['status_code'] = "error";
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "users.php";
                        }, 2000); // 2000ms = 2 seconds
                    </script>';
            }
            $stmt->close();
        } else {
            $_SESSION['status'] = "Prepare failed: " . $con->error;
            $_SESSION['status_code'] = "error";
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "users.php";
                    }, 2000); // 2000ms = 2 seconds
                </script>';
        }
    } else {
        $_SESSION['status'] = "Invalid input!";
        $_SESSION['status_code'] = "error";
        echo '<script>
                setTimeout(function() {
                    window.location.href = "users.php";
                }, 2000); // 2000ms = 2 seconds
            </script>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- Sidebar -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Page Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Runtime Queries</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Runtime Queries</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="card">
                        <div class="card-header">
                            <h5><b><i class="fas fa-database"></i> Runtime Queries</b></h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr align="center">

                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Enrollment</th>
                                            <th>Email</th>
                                            <th>College</th>
                                            <th>Branch</th>
                                            <th>Specialization</th>
                                            <th>Sem</th>
                                            <th>HOD</th>
                                            <th>Query</th>
                                            <th>Attachment Type</th>
                                            <th>File</th>
                                            <th>Status</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user): ?>
                                            <?php
                                            // Determine badge class based on status for better UI
                                            $status = htmlspecialchars($user['status']);
                                            $badgeClass = '';
                                            switch (strtolower($status)) {
                                                case 'completed':
                                                    $badgeClass = 'bg-success';
                                                    break;
                                                case 'pending':
                                                    $badgeClass = 'bg-warning text-dark';
                                                    break;
                                                case 'rejected':
                                                    $badgeClass = 'bg-danger';
                                                    break;
                                                default:
                                                    $badgeClass = 'bg-secondary';
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                                <td><?php echo htmlspecialchars($user['student_name']); ?></td>
                                                <td><?php echo htmlspecialchars($user['enrollment_no']); ?></td>
                                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                <td><?php echo htmlspecialchars($user['college']); ?></td>
                                                <td><?php echo htmlspecialchars($user['branch']); ?></td>
                                                <td><?php echo htmlspecialchars($user['specialization']); ?></td>
                                                <td><?php echo htmlspecialchars($user['sem']); ?></td>
                                                <td><?php echo htmlspecialchars($user['hod_name']); ?></td>
                                                <td><?php echo htmlspecialchars($user['query']); ?></td>
                                                <td><?php echo htmlspecialchars($user['attachment_type']); ?></td>
                                                <td>
                                                    <?php
                                                    $filePath = '../website/forms/uploads/query/' . htmlspecialchars($user['attachment_file']);
                                                    $type = strtolower($user['attachment_type']); // normalize to lowercase
                                                
                                                        echo "<a href='{$filePath}' target='_blank'>View File</a>";
                                                   
                                                    ?>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge <?php echo $badgeClass; ?>"><?php echo $status; ?></span>
                                                </td>
                                                <td>
                                                    <?php if (strtolower($user['status']) === 'pending') { ?>
                                                        <form method="POST" style="display:inline;">
                                                            <input type="hidden" name="student_id"
                                                                value="<?php echo $user['id']; ?>">
                                                            <input type="hidden" name="action" value="approve">
                                                            <button type="submit" class="btn btn-sm btn-outline-success py-0"
                                                                title="Approve">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                        </form>

                                                        <form method="POST" style="display:inline;">
                                                            <input type="hidden" name="student_id"
                                                                value="<?php echo $user['id']; ?>">
                                                            <input type="hidden" name="action" value="reject">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger py-0"
                                                                title="Reject">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </form>
                                                    <?php } else { ?>
                                                        <span
                                                            class="badge <?php echo ($user['status'] === 'approved') ? 'bg-success' : 'bg-danger'; ?>">
                                                            <?php echo ucfirst($user['status']); ?>
                                                        </span>
                                                    <?php } ?>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Enrollment</th>
                                            <th>Email</th>
                                            <th>College</th>
                                            <th>Branch</th>
                                            <th>Specialization</th>
                                            <th>Sem</th>
                                            <th>HOD</th>
                                            <th>Query</th>
                                            <th>Attachment Type</th>
                                            <th>File</th>
                                            <th>Status</th>
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

        <!-- Footer -->
        <?php include 'include/importfooter.php'; ?>
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <!-- Scripts -->
    <?php include 'include/importjs.php'; ?>

</body>

</html>