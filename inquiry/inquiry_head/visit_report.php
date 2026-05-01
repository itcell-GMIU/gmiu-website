<?php
include '../include/checklogin.php';
$startDate = '';
$endDate = '';
$staff_id_filter = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';
    $staff_id_filter = isset($_GET['staff_id_filter']) ? $_GET['staff_id_filter'] : '';
}

// Fetch staff members with role_id = 21 for the filter dropdown
$staffQuery = "SELECT id, name FROM tbl_staff WHERE role_id IN (21,16)";
$staffResult = $con->query($staffQuery);

$sql = "SELECT 
    mv.id, 
    mv.staff_id, 
    staff.name AS staff_name, 
    mv.date_of_visit, 
    mv.name_of_person, 
    mv.image, 
    mv.purpose, 
    mv.timing_of_departure, 
    mv.timing_of_arrival, 
    mv.travelling_timing, 
    mv.visit_time, 
    mv.contact_info, 
    mv.point_discussion, 
    mv.material_given, 
    mv.response, 
    mv.created_at, 
    mv.updated_at, 
    mv.is_delete, 
    mv.is_active
FROM 
    tbl_marketing_visit mv
LEFT JOIN 
    tbl_staff staff ON mv.staff_id = staff.id
WHERE 1 ";

// Add date range filtering
if (!empty($startDate) && !empty($endDate)) {
    $sql .= " AND `date_of_visit` BETWEEN ? AND ?";
}

// Add staff filtering if selected
if (!empty($staff_id_filter)) {
    $sql .= " AND mv.staff_id = ?";
}

$stmt = $con->prepare($sql);

if ($stmt) {
    if (!empty($startDate) && !empty($endDate) && !empty($staff_id_filter)) {
        $stmt->bind_param('sss', $startDate, $endDate, $staff_id_filter);
    } elseif (!empty($startDate) && !empty($endDate)) {
        $stmt->bind_param('ss', $startDate, $endDate);
    } elseif (!empty($staff_id_filter)) {
        $stmt->bind_param('s', $staff_id_filter);
    }

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "Error: " . $con->error;
}
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
                            <h1 class="m-0">Marketing Visit Report</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Marketing Visit Report</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h5>Filter Marketing Visit Data</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="start_date">Start Date:</label>
                                        <input type="date" class="form-control" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date">End Date:</label>
                                        <input type="date" class="form-control" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="staff_id_filter">Staff Name:</label>
                                        <select class="form-control" name="staff_id_filter">
                                            <option value="">All Staff</option>
                                            <?php if ($staffResult && $staffResult->num_rows > 0): ?>
                                                <?php while ($staff = $staffResult->fetch_assoc()): ?>
                                                    <option value="<?php echo $staff['id']; ?>" <?php echo ($staff_id_filter == $staff['id']) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($staff['name']); ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 align-self-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Report Table -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Marketing Visit Report</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="marketingVisitTable"  class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date of Visit</th>
                                            <th>Name of Person</th>
                                            <th>Purpose</th>
                                            <th>Staff Name</th>
                                            <th>Point Discussion</th>
                                            <th>Timing of Departure</th>
                                            <th>Timing of Arrival</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result && $result->num_rows > 0): ?>
                                            <?php while ($row = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['date_of_visit']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['name_of_person']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['staff_name']); ?></td>                                                
                                                    <td><?php echo htmlspecialchars($row['point_discussion']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['timing_of_departure']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['timing_of_arrival']); ?></td>
                                                    <td>
                                                        <a href="../counselor/marketing_visit_details.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8">No records found for the selected date range.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>
    </div>

    <!-- Include jQuery and DataTables JS -->
    <?php include '../include/importjs.php'; ?>
   

</body>
</html>
