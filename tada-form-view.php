<?php
include('include/config.php');

// Fetch submissions with date filter
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d', strtotime('-1 month'));
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d');

$is_filtered = isset($_GET['view_data']);
$forms = [];

if ($is_filtered) {
    $where_clause = "WHERE t1.is_active = 1 AND t1.is_delete = 0 AND t1.form_date BETWEEN '$from_date' AND '$to_date'";
    $current_role = (isset($_SESSION['role_id'])) ? (int)$_SESSION['role_id'] : 0;

    if ($current_role == 3) {
        $current_staff_id = (int)$_SESSION['staff_id'];
        $where_clause .= " AND t1.created_by = $current_staff_id";
    }

    // PHP logic to fetch form data
    $sql = "SELECT t1.id, t1.unique_id, t1.full_name, t1.phone_no, t1.form_date, t1.designation, t1.gross_total_amount, t1.pan_card,
                   (SELECT COUNT(*) FROM tbl_tada_form_data t2 WHERE t2.pan_card = t1.pan_card AND t2.is_active = 1 AND t2.is_delete = 0) as pan_count
            FROM tbl_tada_form_data t1 
            $where_clause
            ORDER BY t1.id DESC";
    $result = $con->query($sql);

    if ($result) {
        $forms = $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Function to handle deletion (Add this block if you want delete functionality)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $delete_id = (int) $_GET['id'];

    // Begin transaction (optional, but good for multi-table ops)
    // $con->begin_transaction(); 

    try {

        // Delete main TADA form record
        $sql_delete_main = "UPDATE tbl_tada_form_data SET is_active = 0, is_delete = 1 WHERE id = ?";
        $stmt_main = $con->prepare($sql_delete_main);
        $stmt_main->bind_param("i", $delete_id);
        $stmt_main->execute();

        // $con->commit(); // Commit transaction
        echo "<script>
            setTimeout(function() {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'TADA Form has been deleted successfully.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(function() {
                    window.location.href = 'tada-form-view.php';
                });
            }, 100);
        </script>";
    } catch (Exception $e) {
        // $con->rollback(); // Rollback on error
        echo "<script>alert('Error deleting form: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include('include/head.php'); ?>
    <title>TA/DA Form List</title>
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
                                <h4>TADA Form Submissions</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Form List</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <a class="btn btn-outline-primary" href="tada-form-fill.php">New TADA Form</a>
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
                                <a href="tada-form-view.php" class="btn btn-outline-secondary"><i class="fa fa-refresh mr-2"></i> Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="text-primary h5 mb-20">Submission List</h5>
                    <?php if ($is_filtered): ?>
                        <?php if (empty($forms)): ?>
                            <div class="alert alert-info">No TADA forms found for the selected date range.</div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped data-table">
                                    <thead>
                                        <tr class="text-nowrap">
                                            <th class="all">Form Code</th>
                                            <th class="all">Full Name</th>
                                            <th class="d-none d-lg-table-cell">Mobile Number</th>
                                            <th class="d-none d-xl-table-cell">PAN Card No.</th>
                                            <th class="d-none d-md-table-cell">Designation</th>
                                            <th class="d-none d-lg-table-cell">Form Date</th>
                                            <th class="all">Total Amount</th>
                                            <th class="datatable-nosort all">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($forms as $form): ?>
                                            <tr>
                                                <td class="all"><span class="badge badge-outline-primary fw-bold text-nowrap"><?= htmlspecialchars($form['unique_id'] ?? '') ?></span></td>
                                                <td class="all"><strong><?= htmlspecialchars($form['full_name']) ?></strong></td>
                                                <td class="d-none d-lg-table-cell"><?= htmlspecialchars($form['phone_no']) ?></td>
                                                <td class="d-none d-xl-table-cell"><span class="badge badge-secondary"><?= htmlspecialchars($form['pan_card']) ?></span></td>
                                                <td class="d-none d-md-table-cell"><?= htmlspecialchars($form['designation']) ?></td>
                                                <td class="d-none d-lg-table-cell text-nowrap"><?= date('d-M-Y', strtotime($form['form_date'])) ?></td>
                                                <td class="all"><span class="badge badge-outline-success fw-bold">₹ <?= number_format($form['gross_total_amount'], 2) ?></span></td>
                                                <td class="all">
                                                    <div class="d-flex flex-wrap gap-4 py-1" style="min-width: 150px;gap:10px;">
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

                                                        <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                            onclick="confirmDelete(<?= $form['id'] ?>)" title="Delete Form" data-toggle="tooltip">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        <?php endif; ?>

                                                        <a href="tada-form-print.php?id=<?= $form['id'] ?>"
                                                            class="btn btn-sm btn-outline-primary" title="Print Form" data-toggle="tooltip">
                                                            <i class="fas fa-print"></i>
                                                        </a>
                                                        
                                                        <?php if($form['pan_count'] >= 2 && isset($_SESSION['role_id']) && $_SESSION['role_id'] != 3): ?>
                                                            <a href="tada-form-history.php?pan=<?= $form['pan_card'] ?>"
                                                                class="btn btn-sm btn-outline-dark" title="View History" data-toggle="tooltip">
                                                                <i class="fas fa-history"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-secondary mb-0">
                            Please select a date range and click <strong>View Data</strong> to load the submission list.
                        </div>
                    <?php endif; ?>

                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to delete TADA Form ID ' + id + '? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'tada-form-view.php?action=delete&id=' + id;
                }
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            // Check if DataTable is already initialized and destroy it to avoid conflicts
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
                    "searchPlaceholder": "Search by Name, Mobile, Code (TADA...), or PAN...",
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
                        extend: 'excel',
                        className: 'btn btn-outline-success',
                        text: '<i class="fa fa-file-excel-o"></i> Excel'
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