<?php
$pageTitle = "GMAP Admin Dashboard";
include './layout/admin/head.php';

if ($_SESSION['role_id'] != 61) {
    header("Location: admin-view-transactions.php");
    exit;
}

/* ================= STATISTICS QUERIES ================= */

// Total Registered
$totalStudents = $con->query("
    SELECT COUNT(*) AS total 
    FROM tbl_gmap_students 
    WHERE is_delete = 0
")->fetch_assoc()['total'] ?? 0;


// Filled All Details (basic required fields)
$completedStudents = $con->query("
    SELECT COUNT(*) AS total 
    FROM tbl_gmap_students
    WHERE surname IS NOT NULL
    AND mobile IS NOT NULL
    AND address IS NOT NULL
    AND is_delete = 0
")->fetch_assoc()['total'] ?? 0;


// is_selectable = 1
$selectableStudents = $con->query("
    SELECT COUNT(*) AS total 
    FROM tbl_gmap_students
    WHERE is_selectable = 1
    AND is_delete = 0
")->fetch_assoc()['total'] ?? 0;


// Faculty Selected
$facultySelected = $con->query("
    SELECT COUNT(*) AS total
    FROM tbl_gmap_students
    WHERE faculty_id IS NOT NULL
    AND is_delete = 0
")->fetch_assoc()['total'] ?? 0;


// Level Selected
$levelSelected = $con->query("
    SELECT COUNT(*) AS total
    FROM tbl_gmap_students
    WHERE level_id IS NOT NULL
    AND is_delete = 0
")->fetch_assoc()['total'] ?? 0;


// Program Selected
$programSelected = $con->query("
    SELECT COUNT(*) AS total
    FROM tbl_gmap_students
    WHERE program_id IS NOT NULL
    AND is_delete = 0
")->fetch_assoc()['total'] ?? 0;

?>
<?php include './layout/admin/navbar.php'; ?>

<main class="flex-grow-1 py-5">
    <div class="container">

        <!-- Page Header -->
        <div class="card shadow-sm mb-4 card-accent">
            <div class="card-body">
                <h5 class="fw-bold text-theme-secondary">
                    <i class="bi bi-speedometer2 me-2 text-theme-primary"></i>
                    GMAP Admin Dashboard
                </h5>
                <small class="text-muted">
                    Overview of student registrations and application progress.
                </small>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row">

            <!-- Total Registered -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-people fs-2 text-primary"></i>
                        <h6 class="mt-3 fw-bold">Total Registered Students</h6>
                        <h3 class="fw-bold text-theme-secondary">
                            <?= $totalStudents ?>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Completed Profiles -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-check-circle fs-2 text-success"></i>
                        <h6 class="mt-3 fw-bold">Profiles Completed</h6>
                        <h3 class="fw-bold text-success">
                            <?= $completedStudents ?>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Selectable Students -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-toggle-on fs-2 text-warning"></i>
                        <h6 class="mt-3 fw-bold">Selectable Students</h6>
                        <h3 class="fw-bold text-warning">
                            <?= $selectableStudents ?>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Faculty Selected -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-building fs-2 text-info"></i>
                        <h6 class="mt-3 fw-bold">Faculty Selected</h6>
                        <h3 class="fw-bold text-info">
                            <?= $facultySelected ?>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Level Selected -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-layers fs-2 text-secondary"></i>
                        <h6 class="mt-3 fw-bold">Level Selected</h6>
                        <h3 class="fw-bold text-secondary">
                            <?= $levelSelected ?>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Program Selected -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-mortarboard fs-2 text-danger"></i>
                        <h6 class="mt-3 fw-bold">Program Selected</h6>
                        <h3 class="fw-bold text-danger">
                            <?= $programSelected ?>
                        </h3>
                    </div>
                </div>
            </div>

        </div>

    </div>
</main>

<?php include './layout/admin/footer.php'; ?>
<?php include './layout/admin/endlinks.php'; ?>