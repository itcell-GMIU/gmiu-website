<?php
include('include/config.php');

// Security Check: Only ADMIN and SUPER ADMIN can access reports
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] == 3) {
    header("Location: index.php");
    exit();
}

// Fetch submissions with date filter
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d', strtotime('-1 month'));
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d');

$is_filtered = isset($_GET['view_data']);
$submissions = [];

if ($is_filtered) {
    $where_clause = "WHERE is_active = 1 AND is_delete = 0 AND form_date BETWEEN '$from_date' AND '$to_date'";
    
    $sql = "SELECT id, unique_id, full_name, duty_category, duty_type, gross_total_amount, pan_card
            FROM tbl_tada_form_data 
            $where_clause
            ORDER BY id DESC";
    $result = $con->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $submissions[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include('include/head.php'); ?>
    <title>Practical Exam Bill (PAN) Report</title>
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
                            <div class="title d-flex align-items-center">
                                <h4>Practical Exam Bill (PAN)</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Practical Exam Bill (PAN) Report</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <!-- DataTables Buttons Rendered via JS -->
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <form method="GET" action="">
                        <div class="row align-items-end">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold">From Date</label>
                                    <input type="date" name="from_date" class="form-control" value="<?= $from_date ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold">To Date</label>
                                    <input type="date" name="to_date" class="form-control" value="<?= $to_date ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <button type="submit" name="view_data" value="1" class="btn btn-outline-primary mr-2"><i class="fa fa-filter mr-2"></i> View Data</button>
                                <a href="tada-pan-report.php" class="btn btn-outline-secondary"><i class="fa fa-refresh mr-2"></i> Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="text-primary h5 mb-20">Submission Overview</h5>
                    <?php if ($is_filtered): ?>
                    <div class="alert alert-info">
                        This view shows a quick summary. Please use the <strong>Export Date-wise Bill</strong> button above to download the grouped excel sheet that perfectly merges records with the same PAN number.
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered data-table">
                            <thead>
                                <tr class="text-nowrap">
                                    <th class="all">#</th>
                                    <th class="all">Form Code</th>
                                    <th class="all">Full Name</th>
                                    <th class="all">PAN Number</th>
                                    <th class="all">Duty Details</th>
                                    <th class="all">Total Amount</th>
                                    <th class="datatable-nosort all text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($submissions as $index => $row): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td class="all"><span class="badge badge-outline-primary fw-bold text-nowrap"><?= htmlspecialchars($row['unique_id'] ?? '') ?></span></td>
                                        <td class="all"><strong><?= htmlspecialchars($row['full_name']) ?></strong></td>
                                        <td class="all"><?= htmlspecialchars($row['pan_card'] ?? 'N/A') ?></td>
                                        <td class="all">
                                            <div class="small">
                                                <div class="mb-1"><strong>Type:</strong> <?= htmlspecialchars($row['duty_type']) ?></div>
                                            </div>
                                        </td>
                                        <td class="all fw-bold text-primary text-nowrap">₹ <?= number_format($row['gross_total_amount'], 2) ?></td>
                                        <td class="all text-center">
                                            <div class="d-flex justify-content-center gap-2" style="gap: 10px;">
                                                <a href="tada-form-details.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-info" title="View Details" data-toggle="tooltip">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-secondary mb-0">
                        Please select a date range and click <strong>View Data</strong> to fetch the records.
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>
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
                    "searchPlaceholder": "Search report data...",
                    "search": "Filter:"
                },
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-outline-primary',
                        text: '<i class="fa fa-copy"></i> Copy'
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-outline-info',
                        text: '<i class="fa fa-file-text-o"></i> CSV'
                    },
                    {
                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                        className: 'btn btn-outline-success',
                        action: function (e, dt, node, config) {
                            window.location.href = 'api/export-pan-bill.php?from_date=<?= $from_date ?>&to_date=<?= $to_date ?>';
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-outline-danger',
                        text: '<i class="fa fa-file-pdf-o"></i> PDF'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-outline-secondary',
                        text: '<i class="fa fa-print"></i> Print'
                    }
                ],
                dom: '<"d-flex justify-content-between align-items-center mb-0"lBf>rtip'
            });
        });
    </script>
</body>
</html>
