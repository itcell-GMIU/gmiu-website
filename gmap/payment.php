<?php
$pageTitle = $pageTitle ?? "GMAP Pay Token";
include './layout/dashboard/head.php';

$student_id = $_SESSION['student_id'] ?? 0;

if (!$student_id) {
    header("Location: login.php");
    exit;
}

/* ================= FETCH DATA ================= */

$stmt = $con->prepare("
    SELECT is_pay, payment_proof, is_seat_alloted, payment_status
    FROM tbl_gmap_students 
    WHERE id = ?
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

$is_pay = $data['is_pay'] ?? 0;
$payment_proof = $data['payment_proof'] ?? null;
$is_seat_alloted = $data['is_seat_alloted'] ?? 0;
$payment_status = $data['payment_status'] ?? 0;


/* ================= HANDLE UPLOAD ================= */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_payment'])) {

    if ($is_seat_alloted != 1) {
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Not Allowed',
            'text' => 'Seat not allotted yet.',
            'redirect' => 'payment.php'
        ];
        header("Location: payment.php");
        exit;
    }

    if (!empty($payment_proof)) {
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Already Uploaded',
            'text' => 'You have already uploaded the attachment.',
            'redirect' => 'payment.php'
        ];
        header("Location: payment.php");
        exit;
    }

    if (!empty($_FILES['payment_file']['name'])) {

        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $maxSize = 5 * 1024 * 1024;

        if (
            !in_array($_FILES['payment_file']['type'], $allowedTypes) ||
            $_FILES['payment_file']['size'] > $maxSize
        ) {

            $_SESSION['alert'] = [
                'type' => 'error',
                'title' => 'Invalid File',
                'text' => 'Only JPG, PNG or PDF allowed. Max size 5MB.',
                'redirect' => 'payment.php'
            ];
            header("Location: payment.php");
            exit;
        }

        $uploadDir = "uploads/payment_proofs/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $cleanName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $_FILES['payment_file']['name']);
        $fileName = time() . "_" . $cleanName;

        if (move_uploaded_file($_FILES['payment_file']['tmp_name'], $uploadDir . $fileName)) {

            $update = $con->prepare("
                UPDATE tbl_gmap_students 
                SET payment_proof = ?
                WHERE id = ?
            ");
            $update->bind_param("si", $fileName, $student_id);
            $update->execute();

            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Uploaded',
                'text' => 'Payment proof uploaded successfully.',
                'redirect' => 'payment.php'
            ];
            header("Location: payment.php");
            exit;
        }
    }
}
?>
<?php
$hasPayment = false;

$stmt = $con->prepare("
    SELECT id, payment_status, created_at 
    FROM tbl_gmap_payments 
    WHERE student_id = ? 
    ORDER BY id DESC 
    LIMIT 1
");
$stmt->bind_param("i", $_SESSION['student_id']);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    $hasPayment = true;
    $pay_id = $row['id'];
    $paymentStatus = $row['payment_status']; // pending / success / failed
    $createdAt = strtotime($row['created_at']);

    // 💡 Logic Correction: If pending for MORE than 1 hour, ignore it 
    // This allows the user to Pay Now again if they abandoned a session yesterday
    if ($paymentStatus === 'pending' && (time() - $createdAt) > 3600) {
        $hasPayment = false;
    }
}
$stmt->close();
?>
<?php include './layout/dashboard/navbar.php'; ?>

<main class="flex-grow-1 py-5">
    <div class="container">

        <?php if ($payment_status == 1): ?>

            <!-- ✅ PAYMENT VERIFIED & SEAT ALLOCATED -->
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="text-success fw-bold mb-3">
                        🎉 Payment Verified & Seat Allocated
                    </h5>
                    <p class="mb-3">
                        Your payment has been successfully verified and approved.
                        Your seat has been allocated to you.
                    </p>
                    <?php if (isset($pay_id)): ?>
                        <a href="receipt.php?id=<?= $pay_id ?>" target="_blank" class="btn btn-dark">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Download Receipt
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        <?php elseif (!empty($payment_proof)): ?>

            <!-- ⏳ PAYMENT SUBMITTED -->
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="text-warning fw-bold mb-3">
                        ⏳ Payment Submitted
                    </h5>
                    <p class="mb-0">
                        You have already uploaded the attachment.
                        Wait for the admin approval of payment status.
                        After approval, your seat will be allocated to you.
                    </p>
                </div>
            </div>

        <?php elseif ($is_pay == 1): ?>

            <!-- 💳 PAYMENT OPEN -->
            <!-- <div class="card shadow-sm">
                <div class="card-body">

                    <h5 class="fw-bold mb-3 text-center">
                        💳 Token Fees Payment
                    </h5>

                    <div class="row">

                        <div class="col-md-6 text-center mb-4">
                            <h6 class="fw-semibold">Scan QR to Pay</h6>
                            <img src="dummy-qr.png" class="img-fluid border rounded p-2" style="max-width:250px;">
                        </div>

                        <div class="col-md-6">
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="upload_payment" value="1">

                                <div class="mb-3">
                                    <label class="form-label">
                                        Upload Screenshot / PDF
                                    </label>
                                    <input type="file" name="payment_file" class="form-control" accept="image/*,.pdf"
                                        required>
                                </div>

                                <button type="submit" class="btn btn-success">
                                    Upload Payment Proof
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
            </div> -->

            <!-- 💳 PAYMENT OPEN -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <h5 class="fw-bold mb-3 text-center">
                        💳 Token Fees Payment
                    </h5>

                    <div class="row">

                        <!-- 🔥 ONLINE PAYMENT -->
                        <div class="col-md-6 text-center mb-4">
                            <h6 class="fw-semibold">Pay Online</h6>

                            <p class="mb-3">
                                Click below to proceed with secure payment.
                            </p>

                            <?php if (!$hasPayment): ?>
                                <!-- ✅ No entry → allow payment -->
                                <a href="transaction-file/pay.php" class="btn btn-primary px-4 py-2">
                                    <i class="fa-solid fa-credit-card me-2"></i>
                                    Pay ₹6000 Now
                                </a>

                            <?php else: ?>

                                <?php if ($paymentStatus === 'pending'): ?>
                                    <!-- ⏳ Pending → allow retry/new attempt instead of disabling -->
                                    <a href="transaction-file/pay.php" class="btn btn-warning px-4 py-2">
                                        ⏳ Payment Pending (Retry)
                                    </a>

                                <?php elseif ($paymentStatus === 'success'): ?>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-success px-4 py-2 w-100" disabled>
                                            ✅ Payment Completed
                                        </button>
                                        <a href="receipt.php?id=<?= $pay_id ?>" target="_blank" class="btn btn-outline-dark px-4 py-2 w-100">
                                            <i class="bi bi-printer me-1"></i> View Receipt
                                        </a>
                                    </div>

                                <?php elseif ($paymentStatus === 'failed'): ?>
                                    <a href="transaction-file/pay.php" class="btn btn-danger px-4 py-2">
                                        🔁 Retry Payment
                                    </a>
                                <?php endif; ?>

                            <?php endif; ?>

                            <p class="text-danger mt-2 small">
                                ⚠️ Do not refresh during payment.
                            </p>
                        </div>

                        <!-- 📤 MANUAL UPLOAD -->
                        <div class="col-md-6">
                            <h6 class="fw-semibold text-center mb-3">Upload Payment Proof</h6>

                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="upload_payment" value="1">

                                <div class="mb-3">
                                    <label class="form-label">
                                        Upload Screenshot / PDF
                                    </label>
                                    <input type="file" name="payment_file" class="form-control" accept="image/*,.pdf"
                                        required>
                                </div>

                                <button type="submit" class="btn btn-success w-100">
                                    Upload Payment Proof
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
            </div>

        <?php else: ?>

            <!-- 🔒 PAYMENT LOCKED -->
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="text-danger fw-bold mb-3">
                        🔒 Payment Locked
                    </h5>
                    <p class="mb-0">
                        Finish previous step and wait for the admin approval.
                        Payment will be enabled once approved.
                    </p>
                </div>
            </div>

        <?php endif; ?>

    </div>
</main>

<?php include './layout/dashboard/footer.php'; ?>
<?php include './layout/dashboard/endlinks.php'; ?>