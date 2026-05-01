<?php
include('include/config.php');

$pan = isset($_GET['pan']) ? $_GET['pan'] : '';
$forms = [];

if ($pan != '') {
    $sql = "SELECT id, unique_id, full_name, form_date, designation, gross_total_amount FROM tbl_tada_form_data WHERE pan_card = ? AND is_active = 1 AND is_delete = 0 ORDER BY id DESC";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $pan);
    $stmt->execute();
    $result = $stmt->get_result();
    $forms = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include('include/head.php'); ?>
    <title>TA/DA Form History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                <h4>Form History for PAN: <?= htmlspecialchars($pan) ?></h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item"><a href="tada-form-view.php">Form List</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">History</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h4 class="mb-3 text-primary fw-bold">Records Found (<?= count($forms) ?>)</h4>
                    <hr>

                    <?php if (empty($forms)): ?>
                        <div class="alert alert-info">No history found for this PAN.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th class="all">Form Code</th>
                                        <th class="all">Full Name</th>
                                        <th class="d-none d-md-table-cell">Designation</th>
                                        <th class="d-none d-lg-table-cell">Form Date</th>
                                        <th class="datatable-nosort all">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($forms as $form): ?>
                                        <tr>
                                            <td class="all"><span class="badge badge-outline-primary fw-bold text-nowrap"><?= htmlspecialchars($form['unique_id'] ?? '') ?></span></td>
                                            <td class="all"><strong><?= htmlspecialchars($form['full_name']) ?></strong></td>
                                            <td class="d-none d-md-table-cell"><?= htmlspecialchars($form['designation']) ?></td>
                                            <td class="d-none d-lg-table-cell text-nowrap"><?= date('d-M-Y', strtotime($form['form_date'])) ?></td>
                                            <td class="all">
                                                <div class="d-flex flex-wrap gap-2 py-1" style="min-width: 100px; gap: 10px;">
                                                    <a href="tada-form-details.php?id=<?= $form['id'] ?>"
                                                        class="btn btn-sm btn-outline-info" title="View Details" data-toggle="tooltip">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] != 3): ?>
                                                    <a href="tada-form-edit.php?id=<?= $form['id'] ?>"
                                                        class="btn btn-sm btn-outline-warning" title="Edit Form" data-toggle="tooltip">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <?php endif; ?>

                                                    <a href="tada-form-print.php?id=<?= $form['id'] ?>"
                                                        class="btn btn-sm btn-outline-primary" title="Print Form" data-toggle="tooltip">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-3">
                        <a href="tada-form-view.php" class="btn btn-secondary">Back to All Forms</a>
                    </div>
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
                    "searchPlaceholder": "Search history...",
                    "search": "Filter:"
                },
                dom: '<"d-flex justify-content-between mb-2"lf>rtip'
            });
        });
    </script>
</body>
</html>
