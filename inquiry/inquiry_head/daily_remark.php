<?php
include '../include/checklogin.php';

// Get filter values from GET parameters
$date_filter = isset($_GET['task_date']) ? $_GET['task_date'] : '';
$staff_filter = isset($_GET['staff_id']) ? $_GET['staff_id'] : '';

// Query to fetch staff for the filter dropdown
$staffQuery = "SELECT id, name FROM tbl_staff WHERE is_delete = 0 AND role_id IN (20,16,21)";
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

// Apply filters
if ($date_filter) {
    $sql .= " AND dr.task_date = '$date_filter'";
}
if ($staff_filter) {
    $sql .= " AND dr.staff_id = '$staff_filter'";
}

// Execute query
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
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
                                    <div class="col-md-3">
                                        <label for="task_date">Task Date:</label>
                                        <input type="date" class="form-control" name="task_date" value="<?php echo htmlspecialchars($date_filter); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="staff_id">Staff:</label>
                                        <select class="form-control" name="staff_id">
                                            <option value="">Select Staff</option>
                                            <?php if ($staffResult->num_rows > 0) : ?>
                                                <?php while ($staff = $staffResult->fetch_assoc()) : ?>
                                                    <option value="<?php echo $staff['id']; ?>" <?php echo $staff_filter == $staff['id'] ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($staff['name']); ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            <?php endif; ?>
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
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;">Staff Name</th>
                                            <th scope="row" style="color:black;">Task Date</th>
                                            <th scope="row" style="color:black;">Remarks</th>
                                            <th scope="row" style="color:black;">Review By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result && $result->num_rows > 0) : ?>
                                            <?php while ($row = $result->fetch_assoc()) : ?>
                                                <tr align="center">
                                                    <td><?php echo htmlspecialchars($row['task_staff_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['task_date']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['remark']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['reviewer_name']); ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No records found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;">Staff Name</th>
                                            <th scope="row" style="color:black;">Task Date</th>
                                            <th scope="row" style="color:black;">Remarks</th>
                                            <th scope="row" style="color:black;">Review By</th>
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

<?php include '../include/importjs.php'; ?>

</html>
