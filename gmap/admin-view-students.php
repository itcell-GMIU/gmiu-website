<?php
$pageTitle = "GMAP Admin View Students";
include './layout/admin/head.php';

if ($_SESSION['role_id'] != 61) {
    header("Location: admin-view-transactions.php");
    exit;
}

/* ================= HANDLE UNLOCK ================= */

if (isset($_GET['unlock_id']) && is_numeric($_GET['unlock_id'])) {

    $unlock_id = (int) $_GET['unlock_id'];

    // Check current status first
    $checkStmt = $con->prepare("SELECT is_selectable FROM tbl_gmap_students WHERE id = ?");
    $checkStmt->bind_param("i", $unlock_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {

        $student = $checkResult->fetch_assoc();

        // Only unlock if currently locked
        if ($student['is_selectable'] == 0) {

            $updateStmt = $con->prepare("UPDATE tbl_gmap_students SET is_selectable = 1 WHERE id = ?");
            $updateStmt->bind_param("i", $unlock_id);
            $updateStmt->execute();

            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Selection Unlocked',
                'text' => 'Program selection has been unlocked successfully.',
                'redirect' => 'admin-view-students.php'
            ];
        }
    }
}

if (isset($_GET['allote-seat']) && is_numeric($_GET['allote-seat'])) {

    $student_id = (int) $_GET['allote-seat'];

    // Step 1: Fetch student data
    $stmt = $con->prepare("
        SELECT program_json, is_selectable, is_program_lock, email
        FROM tbl_gmap_students 
        WHERE id = ?
    ");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $student = $result->fetch_assoc();

        // Step 2: Check conditions
        if (
            !empty($student['program_json']) &&
            $student['is_selectable'] == 1 &&
            $student['is_program_lock'] == 1
        ) {

            $programArray = json_decode($student['program_json'], true);

            if (!empty($programArray) && isset($programArray[0])) {

                $firstChoice = $programArray[0];

                $faculty_id = $firstChoice['faculty_id'] ?? null;
                $level_id = $firstChoice['level_id'] ?? null;
                $program_id = $firstChoice['program_id'] ?? null;

                if ($faculty_id && $level_id && $program_id) {

                    // Step 3: Update main columns + mark seat allotted
                    $update = $con->prepare("
                        UPDATE tbl_gmap_students 
                        SET faculty_id = ?, 
                            level_id = ?, 
                            program_id = ?, 
                            is_seat_alloted = 1,
                            is_pay = 1
                        WHERE id = ?
                    ");

                    $update->bind_param(
                        "iiii",
                        $faculty_id,
                        $level_id,
                        $program_id,
                        $student_id
                    );

                    $update->execute();

                    $email = $student['email'];

                    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
                    $baseUrl = $protocol . $_SERVER['HTTP_HOST'];
                    $ch = curl_init();

                    curl_setopt_array($ch, [
                        CURLOPT_URL => $baseUrl . "/gmiu/gmap/send-mail.php",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => http_build_query([
                            "email" => $email,
                            "type" => "seat_allotted"
                        ])
                    ]);
                    $response = curl_exec($ch);

                    if (function_exists('curl_close')) {
                        @curl_close($ch);
                    }

                    $_SESSION['alert'] = [
                        'type' => 'success',
                        'title' => 'Seat Allotted',
                        'text' => 'Seat has been successfully allotted and payment is unlocked.',
                        'redirect' => 'admin-view-students.php'
                    ];
                    header("Location: admin-view-students.php");
                    exit;
                }
            }
        }
    }

    // If something fails
    $_SESSION['alert'] = [
        'type' => 'error',
        'title' => 'Seat Not Allotted',
        'text' => 'Student does not meet allotment conditions.',
        'redirect' => 'admin-view-students.php'
    ];
    exit;
}



if (isset($_GET['payment-status']) && is_numeric($_GET['payment-status'])) {

    $student_id = (int) $_GET['payment-status'];

    // Step 1: Fetch student data
    $stmt = $con->prepare("
        SELECT program_json, is_selectable, is_program_lock, is_seat_alloted, is_pay, payment_status, payment_proof, email
        FROM tbl_gmap_students 
        WHERE id = ?
    ");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $student = $result->fetch_assoc();

        // Step 2: Check conditions
        if (
            !empty($student['program_json']) &&
            $student['is_selectable'] == 1 &&
            $student['is_program_lock'] == 1 &&
            $student['is_seat_alloted'] == 1 &&
            $student['is_pay'] == 1 &&
            !empty($student['payment_proof']) &&
            $student['payment_status'] == 0
        ) {
            $updateStmt = $con->prepare("UPDATE tbl_gmap_students SET payment_status = 1 WHERE id = ?");
            $updateStmt->bind_param("i", $student_id);
            $updateStmt->execute();

            $email = $student['email'];

            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
            $baseUrl = $protocol . $_SERVER['HTTP_HOST'];
            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => $baseUrl . "/gmiu/gmap/send-mail.php",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query([
                    "email" => $email,
                    "type" => "payment_verified"
                ])
            ]);
            $response = curl_exec($ch);

            if (function_exists('curl_close')) {
                @curl_close($ch);
            }

            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Payment Veryfied',
                'text' => 'Payment of the Student is Verified and Seat is Allocated!',
                'redirect' => 'admin-view-students.php'
            ];
        }
    }
}

/* ================= FETCH ALL STUDENTS ================= */

$query = $con->prepare("
    SELECT id, application_id, surname, student_name, mobile, email,
           faculty_id, level_id, program_id, is_selectable, is_active, program_json, is_program_lock, is_seat_alloted, is_pay, payment_proof, payment_status,
           referal_code
    FROM tbl_gmap_students
    WHERE is_delete = 0
    ORDER BY id DESC
");
$query->execute();
$result = $query->get_result();

?>
<style>
    table.dataTable {
        width: 100% !important;
    }

    .dataTables_wrapper {
        width: 100%;
        overflow-x: auto;
    }
</style>
<?php include './layout/admin/navbar.php'; ?>

<main class="flex-grow-1 py-4">
    <div class="container">

        <!-- Page Header -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold">
                    <i class="bi bi-people-fill me-2"></i>
                    All Registered Students
                </h5>
                <small class="text-muted">
                    Manage students, view details and control program access.
                </small>
            </div>
        </div>

        <!-- Students Table -->
        <div class="card shadow-sm">
            <div class="card-body">

                <table id="studentsTable" class="table table-bordered table-striped align-middle nowrap"
                    style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Application ID</th>
                            <th>Student Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Referral Code</th>
                            <th>Selectable</th>
                            <th>Program</th>
                            <th>Choice</th>
                            <th>Seat</th>
                            <th>Payment Proof</th>
                            <th>Payment Status</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while ($row = $result->fetch_assoc()): ?>

                            <tr>
                                <td><?= $row['id'] ?></td>

                                <td>
                                    <?= htmlspecialchars($row['application_id'] ?? 'Not Generated') ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['surname'] . ' ' . $row['student_name']) ?>
                                </td>

                                <td><?= htmlspecialchars($row['mobile']) ?></td>

                                <td><?= htmlspecialchars($row['email']) ?></td>

                                <td class="fw-bold text-danger"><?= htmlspecialchars($row['referal_code'] ?? '-') ?></td>

                                <td class="text-center">
                                    <?= $row['is_selectable'] ?
                                        '<span class="badge bg-success">Yes</span>' :
                                        '<span class="badge bg-danger">No</span>' ?>
                                </td>

                                <td class="text-center">
                                    <?= $row['program_json'] ?
                                        '<span class="badge bg-success">Selected</span>' :
                                        '<span class="badge bg-secondary">Not Selected</span>' ?>
                                </td>

                                <td class="text-center">
                                    <?= $row['is_program_lock'] ?
                                        '<span class="badge bg-success">Locked</span>' :
                                        '<span class="badge bg-secondary">Not Locked</span>' ?>
                                </td>

                                <td class="text-center">
                                    <?= $row['is_seat_alloted'] ?
                                        '<span class="badge bg-success">Alloted</span>' :
                                        '<span class="badge bg-danger">Not Alloted</span>' ?>
                                </td>

                                <td class="text-center">
                                    <?php if (!empty($row['payment_proof'])): ?>

                                        <a href="uploads/payment_proofs/<?= htmlspecialchars($row['payment_proof']); ?>"
                                            target="_blank" class="badge bg-success text-decoration-none">
                                            View Proof
                                        </a>

                                    <?php else: ?>

                                        <span class="badge bg-danger">
                                            No Proof
                                        </span>

                                    <?php endif; ?>
                                    
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-info view-payment-btn" data-student-id="<?= $row['id'] ?>" title="View Payment Details">
                                            <i class="bi bi-info-circle"></i> Details
                                        </button>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <?= $row['payment_status'] ?
                                        '<span class="badge bg-success">Paid</span>' :
                                        '<span class="badge bg-danger">Not Paid</span>' ?>
                                </td>

                                <td>

                                    <!-- View Button -->
                                    <a href="admin-student-details.php?id=<?= $row['id'] ?>" title="View Details"
                                        class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <!-- Toggle Selectable -->
                                    <?php if ($row['is_selectable'] == 0): ?>
                                        <a href="?unlock_id=<?= $row['id'] ?>" class="btn btn-sm btn-success unlock-btn"
                                            title="Unlock Program">
                                            <i class="bi bi-unlock"></i>
                                        </a>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" disabled
                                            title="Program Unlocked">
                                            <i class="bi bi-unlock-fill"></i>
                                        </button>
                                    <?php endif; ?>

                                    <?php if ($row['is_seat_alloted'] == 1): ?>

                                        <!-- Seat Already Allotted -->
                                        <button class="btn btn-sm btn-secondary" disabled title="Seat Already Allotted">
                                            <i class="bi bi-person-check-fill"></i>
                                        </button>

                                    <?php elseif (
                                        $row['is_selectable'] == 1 &&
                                        !empty($row['program_json']) &&
                                        $row['is_program_lock'] == 1
                                    ): ?>

                                        <!-- Eligible for Allotment -->
                                        <a href="?allote-seat=<?= $row['id']; ?>" class="btn btn-sm btn-primary allote-seat"
                                            title="Allote Seat">
                                            <i class="bi bi-person-check-fill"></i>
                                        </a>

                                    <?php else: ?>

                                        <!-- Not Eligible -->
                                        <button class="btn btn-sm btn-primary" disabled title="Not Eligible">
                                            <i class="bi bi-person-check-fill"></i>
                                        </button>

                                    <?php endif; ?>



                                    <?php
                                    $eligibleForPay =
                                        $row['is_selectable'] == 1 &&
                                        !empty($row['program_json']) &&
                                        $row['is_program_lock'] == 1 &&
                                        $row['is_seat_alloted'] == 1 &&
                                        $row['is_pay'] == 1 &&
                                        !empty($row['payment_proof']);
                                    ?>

                                    <?php if ($eligibleForPay && $row['payment_status'] == 0): ?>

                                        <!-- ✅ Approved Payment Status -->
                                        <a href="?payment-status=<?= $row['id']; ?>"
                                            class="btn btn-sm btn-success payment-status" title="Approve Payment Status">
                                            <i class="bi bi-cash-coin"></i>
                                        </a>

                                    <?php elseif ($eligibleForPay && $row['payment_status'] == 1): ?>

                                        <!-- 🟢 Payment Verified -->
                                        <button class="btn btn-sm btn-secondary" disabled title="Payment Verified">
                                            <i class="bi bi-patch-check-fill"></i>
                                        </button>

                                    <?php else: ?>

                                        <!-- 🔴 Not Eligible -->
                                        <button class="btn btn-sm btn-danger" disabled title="Not Eligible for Payment">
                                            <i class="bi bi-ban-fill"></i>
                                        </button>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</main>

<!-- Payment Details Modal -->
<div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-labelledby="paymentDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentDetailsModalLabel"><i class="bi bi-credit-card me-2"></i>Payment Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="paymentDetailsBody">
        <div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include './layout/admin/footer.php'; ?>
<?php include './layout/admin/endlinks.php'; ?>

<!-- jQuery FIRST -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables CDN -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#studentsTable').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            ordering: true,
            scrollX: false,
            autoWidth: false
        });
    });
</script>

<script>
    $(document).on('click', '.unlock-btn', function (e) {
        e.preventDefault();

        let link = $(this).attr('href');

        Swal.fire({
            title: 'Unlock Program Selection?',
            text: "This action cannot be reversed!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Unlock',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            }
        });
    });
    $(document).on('click', '.allote-seat', function (e) {
        e.preventDefault();

        let link = $(this).attr('href');

        // Swal.fire({
        //     title: 'Under Maintenance',
        //     text: 'Seat allotment and payment are currently under maintenance. Please try again later.',
        //     icon: 'info',
        //     confirmButtonColor: '#3085d6',
        //     confirmButtonText: 'OK'
        // });

        Swal.fire({
            title: 'Allote First Seat?',
            text: "First Choosen Seat will be Alloted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Allote',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            }
        });
    });

    $(document).on('click', '.payment-status', function (e) {
        e.preventDefault();

        let link = $(this).attr('href');

        Swal.fire({
            title: 'Verify Payment?',
            text: "Do you want to Verify Payment!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Allow',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            }
        });
    });

    $(document).on('click', '.view-payment-btn', function () {
        let studentId = $(this).data('student-id');
        
        $('#paymentDetailsBody').html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#paymentDetailsModal').modal('show');

        $.ajax({
            url: 'payment-details-ajax.php',
            type: 'POST',
            data: { student_id: studentId },
            success: function (response) {
                $('#paymentDetailsBody').html(response);
            },
            error: function () {
                $('#paymentDetailsBody').html('<div class="alert alert-danger mb-0">Error fetching details. Please try again.</div>');
            }
        });
    });
</script>