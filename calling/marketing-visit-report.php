<?php
include './include/config.php';

$startDate = '';
$endDate = '';
$staff_id_filter = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $startDate = $_GET['start_date'] ?? '';
    $endDate = $_GET['end_date'] ?? '';
    $staff_id_filter = $_GET['staff_id_filter'] ?? '';
}

/* Fetch staff list */
$staffQuery = "SELECT id, name FROM tbl_staff WHERE role_id IN (21,16)";
$staffResult = $con->query($staffQuery);

/* Base Query */
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
FROM tbl_marketing_visit mv
LEFT JOIN tbl_staff staff ON mv.staff_id = staff.id
WHERE mv.is_active = 1 AND mv.is_delete = 0";

/* Filters */
if (!empty($startDate) && !empty($endDate)) {
    $sql .= " AND date_of_visit BETWEEN ? AND ?";
}
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
    die("SQL Error: " . $con->error);
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

            <!-- PAGE HEADER -->
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Marketing Visit Report</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Marketing Visit Report</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- FILTER CARD -->
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <h5 class="mb-3">Filter Marketing Visit Data</h5>

                <form method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Start Date</label>
                            <input type="date" class="form-control" name="start_date"
                                value="<?= htmlspecialchars($startDate) ?>">
                        </div>

                        <div class="col-md-3">
                            <label>End Date</label>
                            <input type="date" class="form-control" name="end_date"
                                value="<?= htmlspecialchars($endDate) ?>">
                        </div>

                        <div class="col-md-3">
                            <label>Staff Name</label>
                            <select class="form-control" name="staff_id_filter">
                                <option value="">All Staff</option>
                                <?php if ($staffResult):
                                    while ($staff = $staffResult->fetch_assoc()): ?>
                                        <option value="<?= $staff['id'] ?>" <?= ($staff_id_filter == $staff['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($staff['name']) ?>
                                        </option>
                                    <?php endwhile; endif; ?>
                            </select>
                        </div>

                        <div class="col-md-3 align-self-end">
                            <button class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- REPORT TABLE -->
            <div class="pd-20 bg-white border-radius-4 box-shadow">
                <h5 class="mb-3">Marketing Visit Report</h5>

                <div class="table-responsive">
                    <table class="dataTableLoad table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date of Visit</th>
                                <th>Name of Person</th>
                                <th>Purpose</th>
                                <th>Staff Name</th>
                                <th>Point Discussion</th>
                                <th>Departure</th>
                                <th>Arrival</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['date_of_visit']) ?></td>
                                        <td><?= htmlspecialchars($row['name_of_person']) ?></td>
                                        <td><?= htmlspecialchars($row['purpose']) ?></td>
                                        <td><?= htmlspecialchars($row['staff_name']) ?></td>
                                        <td><?= htmlspecialchars($row['point_discussion']) ?></td>
                                        <td><?= htmlspecialchars($row['timing_of_departure']) ?></td>
                                        <td><?= htmlspecialchars($row['timing_of_arrival']) ?></td>
                                        <td>
                                            <a href="marketing-visit-details.php?id=<?= $row['id'] ?>"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">
                                        No records found for selected filters
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>

            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>
     <script>
        $(document).ready(function () {
            var table = $('.dataTableLoad').DataTable({
                "dom": 'Blfrtip',
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('.dataTableLoad_wrapper .col-md-6:eq(0)');
        });
    </script>
</body>

</html>