<?php
include './include/config.php';

// --- Logic from Old Code (Adapted for New Template) ---

// Get filter values from GET parameters
$date_filter = isset($_GET['task_date']) ? $_GET['task_date'] : '';
$staff_filter = isset($_GET['staff_id']) ? $_GET['staff_id'] : '';

// Query to fetch staff for the filter dropdown
$staffQuery = "SELECT id, name FROM tbl_staff WHERE is_delete = 0 AND role_id IN (12,13,14,15,16,21,25,57,59)";
$staffResult = $con->query($staffQuery);

// Base query with JOIN to fetch staff and reviewer names
$sql = "SELECT 
            dr.id, 
            rs.name AS reviewer_name, 
            ts.name AS task_staff_name, 
            dr.task_date, 
            dr.comments AS remark, 
            dr.created_at, 
            dr.updated_at, 
            dr.is_active 
        FROM tbl_daily_review dr
        LEFT JOIN tbl_staff rs ON dr.reviewer_staff_id = rs.id
        LEFT JOIN tbl_staff ts ON dr.staff_id = ts.id
        WHERE dr.is_delete = 0";

// Prepare for filtering
$params = [];
$types = '';
if ($date_filter) {
    $sql .= " AND dr.task_date = ?";
    $params[] = $date_filter;
    $types .= 's';
}
if ($staff_filter) {
    $sql .= " AND dr.staff_id = ?";
    $params[] = $staff_filter;
    $types .= 'i';
}
$sql .= " ORDER BY dr.task_date DESC, ts.name ASC";

// Execute query using prepared statements to prevent SQL injection
$stmt = $con->prepare($sql);
if ($stmt) {
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "Error preparing statement: " . $con->error;
    $result = null;
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
        <div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Daily Review Report</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Daily Review Report</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Filter Form -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="mb-20 h5">Filter Review Data</h5>
                    <form method="GET" action="">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Task Date:</label>
                                    <input type="date" class="form-control" name="task_date"
                                        value="<?php echo htmlspecialchars($date_filter); ?>">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Staff:</label>
                                    <select class="form-control" name="staff_id">
                                        <option value="">Select Staff</option>
                                        <?php if ($staffResult && $staffResult->num_rows > 0): ?>
                                            <?php while ($staff = $staffResult->fetch_assoc()): ?>
                                                <option value="<?php echo $staff['id']; ?>" <?php echo $staff_filter == $staff['id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($staff['name']); ?>
                                                </option>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 align-self-end">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                        class="btn btn-secondary">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="mb-20 h5">Review Report Data</h5>
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-striped w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th>Staff Name</th>
                                    <th>Task Date</th>
                                    <th>Remarks</th>
                                    <th>Reviewed By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['task_staff_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['task_date']); ?></td>
                                            <td><?php echo htmlspecialchars($row['remark']); ?></td>
                                            <td><?php echo htmlspecialchars($row['reviewer_name']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>

    <script>
        $(document).ready(function () {
            $('.data-table').DataTable({
                // scrollX: true,
                autoWidth: true,
                responsive: false,
                language: { searchPlaceholder: "Search" },
                dom: '<"d-flex justify-content-between"lBf>rtip',
                buttons: ['copy', 'csv', 'pdf', 'print']
            });
        });
    </script>
</body>

</html>