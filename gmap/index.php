<?php
$pageTitle = $pageTitle ?? "GMAP Dashboard";
include './layout/dashboard/head.php';
?>
<?php
$student_id = $_SESSION['student_id'];

$stmt = $con->prepare("
    SELECT s.*, 
           f.name AS faculty_name,
           l.name AS level_name,
           p.name AS program_name
    FROM tbl_gmap_students s
    LEFT JOIN tbl_faculty f ON s.faculty_id = f.id
    LEFT JOIN tbl_level l ON s.level_id = l.id
    LEFT JOIN tbl_program p ON s.program_id = p.id
    WHERE s.id = ?
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Fetch latest successful payment ID for the receipt button
$payment_id_query = $con->prepare("SELECT id FROM tbl_gmap_payments WHERE student_id = ? AND payment_status = 'success' ORDER BY id DESC LIMIT 1");
$payment_id_query->bind_param("i", $student_id);
$payment_id_query->execute();
$payment_res = $payment_id_query->get_result();
$payment_row = $payment_res->fetch_assoc();
$success_payment_id = $payment_row['id'] ?? null;

/* ================= STATUS CALCULATION ================= */

$registered = true;

$applicationSubmitted =
    !empty($data['surname']) &&
    !empty($data['mobile']) &&
    !empty($data['address']);

$documentsUploaded = !empty($data['docs']);
$photoUploaded = !empty($data['photo']);
$docsUploaded = !empty($data['docs']);
$programSelected = !empty($data['program_json']);
$programLocked = $data['is_program_lock'] == 1;
$seatAllotted = !empty($data['is_seat_alloted']) && $data['is_seat_alloted'] == 1;
$paymentUploaded = !empty($data['payment_proof']);
$paymentVerified = $data['payment_status'] == 1;

/* ================= PROGRESS CALCULATION ================= */

$progress = 10;

if ($applicationSubmitted)
    $progress += 15;
if ($documentsUploaded)
    $progress += 15;
if ($programSelected)
    $progress += 15;
if ($programLocked)
    $progress += 15;
if ($seatAllotted)
    $progress += 10;
if ($paymentUploaded)
    $progress += 10;
if ($paymentVerified)
    $progress += 10;

if ($progress > 100)
    $progress = 100;



$announcements = $con->query("
    SELECT * FROM tbl_gmap_announcements 
    WHERE is_active = 1 
    AND display_date <= CURDATE() 
    ORDER BY display_date DESC
");

?>
<?php include './layout/dashboard/navbar.php'; ?>


<!-- ================= MAIN CONTENT ================= -->
<main class="flex-grow-1 py-5">
    <div class="container">

        <!-- ================= WELCOME + STATUS ================= -->
        <div class="card shadow-sm mb-4 card-accent">
            <div class="card-body d-md-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 text-theme-secondary fw-bold">
                        Welcome, <?= htmlspecialchars($data['surname'] . ' ' . $data['student_name']) ?> 👋
                    </h5>
                    <small class="text-muted">
                        GMAP Application ID:
                        <strong><?= htmlspecialchars($data['application_id'] ?? 'Not Generated') ?>
                        </strong>
                    </small>
                </div>

                <span class="badge <?= $docStatusClass ?> mt-3 mt-md-0 px-3 py-2">
                    <?= $docStatusText ?>
                </span>
            </div>
        </div>


        <!-- ================= PROGRESS TRACKER ================= -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <h6 class="fw-bold text-theme-secondary mb-3">
                    Application Progress
                </h6>

                <!-- Progress Bar -->
                <div class="progress mb-4" style="height:8px;">
                    <div class="progress-bar bg-success" style="width: <?= $progress ?>%;"></div>
                </div>

                <?php
                $registered = true;

                $applicationSubmitted = !empty($data['surname'])
                    && !empty($data['mobile'])
                    && !empty($data['address']);

                $documentsUploaded = !empty($data['docs']);

                $steps = [
                    ['label' => 'Registered', 'status' => $registered],
                    ['label' => 'Application Submitted', 'status' => $applicationSubmitted],
                    ['label' => 'Documents Uploaded', 'status' => $documentsUploaded],
                    ['label' => 'Program Selected', 'status' => $programSelected],
                    ['label' => 'Program Locked', 'status' => $programLocked],
                    ['label' => 'Seat Allotted', 'status' => $seatAllotted],
                    ['label' => 'Payment Uploaded', 'status' => $paymentUploaded],
                    ['label' => 'Payment Verified', 'status' => $paymentVerified],
                ];
                ?>

                <!-- Stepper -->
                <div class="row">

                    <?php foreach ($steps as $index => $step): ?>
                        <div class="col-12 col-md text-start text-md-center mb-3 mb-md-0">

                            <div class="d-flex align-items-center justify-content-start justify-content-md-center">

                                <!-- Step Circle -->
                                <div class="me-3 me-md-0 mb-0 mb-md-2">
                                    <span class="rounded-circle d-inline-flex align-items-center justify-content-center
                                <?= $step['status'] ? 'bg-success text-white' : 'bg-light border' ?>"
                                        style="width:34px;height:34px;font-size:14px;">
                                        <?= $step['status'] ? '✓' : $index + 1 ?>
                                    </span>
                                </div>

                                <!-- Step Text -->
                                <div>
                                    <small class="<?= $step['status'] ? 'text-success fw-semibold' : 'text-muted' ?>">
                                        <?= $step['label'] ?>
                                    </small>
                                </div>

                            </div>

                        </div>
                    <?php endforeach; ?>

                </div>

            </div>
        </div>
        <!-- ================= SUMMARY + DOCUMENT STATUS ================= -->
        <div class="row">

            <!-- Application Summary -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100 card-accent">
                    <div class="card-body">

                        <div class="row align-items-center">

                            <!-- LEFT SIDE (Current Details) -->
                            <div class="col-md-8">

                                <h6 class="fw-bold text-theme-secondary mb-3">
                                    <i class="bi bi-person-circle me-2 text-theme-primary"></i>
                                    Application Summary
                                </h6>

                                <p class="mb-1"><strong>Mobile:</strong>
                                    <?= htmlspecialchars($data['mobile']) ?>
                                </p>

                                <p class="mb-1"><strong>Email:</strong>
                                    <?= htmlspecialchars($data['email']) ?>
                                </p>

                                <p class="mb-1"><strong>Qualification:</strong>
                                    <?= htmlspecialchars($data['qualification']) ?>
                                </p>

                                <p class="mb-1"><strong>Seat Type:</strong>
                                    <?= htmlspecialchars($data['seat'] ?? 'Not Selected') ?>
                                </p>

                                <?php if ($seatAllotted): ?>
                                    <p class="mb-3"><strong>Allotted Program:</strong>
                                        <?= ($data['program_name'] ?? 'N/A') ?>
                                    </p>
                                <?php elseif ($programSelected): ?>
                                    <p class="mb-3"><strong>Program:</strong>
                                        <span class="badge bg-info text-dark">Selected</span>
                                    </p>
                                <?php else: ?>
                                    <p class="mb-3"><strong>Program:</strong>
                                        <?= ($data['program_name'] ?? 'Not Selected') ?>
                                    </p>
                                <?php endif; ?>

                                <a href="personal-details.php" class="btn btn-danger btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit Application
                                </a>

                            </div>

                            <!-- RIGHT SIDE (Profile Image) -->
                            <div class="col-md-4 text-center mt-4 mt-md-0">

                                <?php if (!empty($data['photo']) && file_exists("uploads/student-photo/" . $data['photo'])): ?>

                                    <img src="uploads/student-photo/<?= htmlspecialchars($data['photo']) ?>"
                                        class="img-fluid rounded-circle shadow"
                                        style="width:150px;height:150px;object-fit:cover;" alt="Profile Photo">

                                <?php else: ?>

                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center shadow"
                                        style="width:150px;height:150px;margin:auto;">
                                        <i class="bi bi-person fs-1 text-muted"></i>
                                    </div>

                                    <small class="text-muted d-block mt-2">
                                        No Photo Uploaded
                                    </small>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- Documents Status -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="fw-bold text-theme-secondary mb-3">
                            <i class="bi bi-folder-check me-2 text-theme-primary"></i>
                            Documents Status
                        </h6>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Photo</span>
                            <span class="<?= $photoUploaded ? 'text-success' : 'text-danger' ?>">
                                <?= $photoUploaded ? '✔ Uploaded' : '❌ Not Uploaded' ?>
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Documents</span>
                            <span class="<?= $docsUploaded ? 'text-success' : 'text-warning' ?>">
                                <?= $docsUploaded ? '✔ Uploaded' : '⏳ Pending' ?>
                            </span>
                        </div>

                        <?php
                        $docsDir = "uploads/student-docs/";
                        ?>
                        <?php if ($docsUploaded): ?>
                            <div class="mt-3">
                                <?php
                                $files = explode(',', $data['docs']);
                                foreach ($files as $file):
                                    $filePath = $docsDir . $file;
                                    if (file_exists($filePath)):
                                        ?>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">
                                                <?= htmlspecialchars($file) ?>
                                            </small>
                                            <a href="<?= $filePath ?>" class="btn btn-success btn-sm" download>
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                        </div>
                                        <?php
                                    endif;
                                endforeach;
                                ?>
                                <a href="personal-details.php" class="btn btn-outline-danger btn-sm mt-2">
                                    Update Documents
                                </a>
                            </div>
                        <?php else: ?>
                            <a href="personal-details.php" class="btn btn-outline-danger btn-sm">
                                Upload Documents
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>


        <!-- ================= CHOICE + ALLOTMENT + PAYMENT ================= -->
        <div class="row">

            <!-- Program Selection -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-mortarboard fs-2 text-theme-primary"></i>
                        <h6 class="mt-3 fw-bold text-theme-secondary">
                            Program Selection
                        </h6>
                        <a href="program-selection.php" class="btn btn-danger btn-sm">
                            <?= $programSelected ? 'View / Edit Program' : 'Select Program' ?>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Seat Allotment -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-building-check fs-2 text-theme-primary"></i>
                        <h6 class="mt-3 fw-bold text-theme-secondary">
                            Seat Allotment
                        </h6>

                        <?php if ($seatAllotted): ?>
                            <p class="small text-success fw-semibold">
                                Seat Allotted in:<br>
                                <?= ($data['faculty_name'] . ' - ' . $data['program_name']) ?>
                            </p>
                            <span class="badge bg-success">Allotted</span>
                        <?php else: ?>
                            <p class="small text-muted">
                                Awaiting seat allotment.
                            </p>
                            <span class="badge bg-secondary">Pending</span>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <!-- Payment -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-credit-card-2-front fs-2 text-theme-primary"></i>
                        <h6 class="mt-3 fw-bold text-theme-secondary">
                            Fee Payment
                        </h6>

                        <?php if ($paymentVerified): ?>
                            <p class="small text-success fw-semibold">
                                Payment Verified & Seat Confirmed
                            </p>
                            <span class="badge bg-success mb-2">Completed</span>
                            
                            <?php if ($success_payment_id): ?>
                                <a href="receipt.php?id=<?= $success_payment_id ?>" target="_blank" class="btn btn-outline-dark btn-sm d-block mt-2">
                                    <i class="bi bi-file-earmark-pdf me-1"></i> Download Receipt
                                </a>
                            <?php endif; ?>

                        <?php elseif ($paymentUploaded): ?>
                            <p class="small text-warning fw-semibold">
                                Payment Uploaded<br>
                                Awaiting Verification
                            </p>
                            <span class="badge bg-warning text-dark">Pending Approval</span>

                        <?php elseif ($seatAllotted && $data['is_pay'] == 1): ?>
                            <p class="small text-muted">
                                Payment Enabled. Please complete payment.
                            </p>
                            <a href="payment.php" class="btn btn-danger btn-sm">
                                Pay Now
                            </a>

                        <?php else: ?>
                            <p class="small text-muted">
                                Payment will be available after seat allotment.
                            </p>
                            <span class="badge bg-secondary">Locked</span>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

        </div>


        <!-- ================= ANNOUNCEMENTS ================= -->
        <div class="card shadow-sm border-start border-4 border-danger">
            <div class="card-body">
                <h6 class="fw-bold text-theme-secondary mb-3">
                    <i class="bi bi-megaphone-fill me-2 text-theme-primary"></i>
                    Latest Announcements
                </h6>

                <div class="announcement-wrapper">
                    <?php if ($announcements->num_rows > 0): ?>
                        <?php while ($ann = $announcements->fetch_assoc()): ?>
                            <div class="p-3 mb-3 bg-light rounded shadow-sm border-start border-3 border-danger">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="fw-bold text-dark mb-1"><?= htmlspecialchars($ann['title']) ?></h6>
                                    <small class="badge bg-danger"><?= date('d M, Y', strtotime($ann['display_date'])) ?></small>
                                </div>
                                <p class="small text-muted mb-2"><?= nl2br(htmlspecialchars($ann['description'])) ?></p>
                                
                                <?php if ($ann['file_path']): ?>
                                    <a href="uploads/announcements/<?= $ann['file_path'] ?>" target="_blank" class="btn btn-sm btn-outline-danger py-1">
                                        <i class="bi bi-file-earmark-text me-1"></i> View Attachment
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center py-3 text-muted">
                            <i class="bi bi-info-circle me-1"></i> No active announcements at this time.
                        </div>
                    <?php endif; ?>
                </div>

                <hr class="my-3">
                <h6 class="fw-bold text-theme-secondary mb-2 small">General Notes:</h6>
                <ul class="small mb-0 text-muted">
                    <li>Keep original documents ready during reporting.</li>
                    <li>All communications will be sent via registered mobile/email.</li>
                </ul>
            </div>
        </div>

    </div>
</main>

<?php include './layout/dashboard/footer.php'; ?>
<?php include './layout/dashboard/endlinks.php'; ?>