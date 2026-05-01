<?php
$pageTitle = "GMAP Successful Transactions";
include './layout/admin/head.php';

if ($_SESSION['role_id'] != 2) {
    header("Location: admin-index.php");
    exit;
}

// Fetch Only Successful Transactions
// Role 61 (Admin) and Role 2 (Accounting) can both access this via head.php check
$query = $con->prepare("
    SELECT p.*, s.application_id, s.surname, s.student_name, s.mobile, s.email,
           f.name as faculty_name, l.name as level_name, pr.name as program_name
    FROM tbl_gmap_payments p
    JOIN tbl_gmap_students s ON p.student_id = s.id
    LEFT JOIN tbl_faculty f ON s.faculty_id = f.id
    LEFT JOIN tbl_level l ON s.level_id = l.id
    LEFT JOIN tbl_program pr ON s.program_id = pr.id
    WHERE p.payment_status = 'success'
    ORDER BY p.id DESC
");
$query->execute();
$result = $query->get_result();

?>

<?php include './layout/admin/navbar.php'; ?>

<main class="flex-grow-1 py-4">
    <div class="container">
        <!-- Page Header -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-cash-coin me-2 text-success"></i>
                    Confirmed Transactions
                </h5>
                <small class="text-muted">Viewing all successfully completed payments.</small>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="transTable" class="table table-bordered table-striped align-middle nowrap"
                        style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th width="50">#</th>
                                <th>App ID</th>
                                <th>Student Name</th>
                                <th>Faculty</th>
                                <th>Level</th>
                                <th>Program</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Transaction ID</th>
                                <th>Gateway ID</th>
                                <th>Amount</th>
                                <th>Mode</th>
                                 <th>Date</th>
                                <th>Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php $i = 1;
                                while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= htmlspecialchars($row['application_id'] ?? 'N/A') ?></td>
                                        <td class="fw-semibold">
                                            <?= htmlspecialchars($row['surname'] . ' ' . $row['student_name']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['faculty_name'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($row['level_name'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($row['program_name'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($row['mobile']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><code><?= htmlspecialchars($row['transaction_id']) ?></code></td>
                                        <td><?= htmlspecialchars($row['easepay_id'] ?? 'Manual') ?></td>
                                        <td class="fw-bold text-success">
                                            <?= number_format($row['amount'], 2) ?>
                                        </td>
                                        <td><?= htmlspecialchars(strtoupper($row['mode'] ?? 'Online')) ?></td>
                                        <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
                                        <td><?= date('h:i A', strtotime($row['created_at'])) ?></td>
                                        <td>
                                            <a href="receipt.php?id=<?= $row['id'] ?>" target="_blank"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="bi bi-printer me-1"></i> Receipt
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <!-- <tr>
                                    <td colspan="14" class="text-center py-4 text-muted">No successful transactions found.
                                    </td>
                                </tr> -->
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include './layout/admin/footer.php'; ?>
<?php include './layout/admin/endlinks.php'; ?>

<!-- jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables Core & Bootstrap -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables Buttons for Export -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#transTable').DataTable({
            pageLength: 25,
            ordering: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="bi bi-file-earmark-excel me-1"></i> Export to Excel',
                    className: 'btn btn-success btn-sm',
                    title: 'GMAP_Successful_Transactions_' + new Date().toISOString().slice(0, 10)
                }
            ],
            language: {
                searchPlaceholder: "Search transactions..."
            },
            scrollX: false,
            autoWidth: false
        });
    });
</script>