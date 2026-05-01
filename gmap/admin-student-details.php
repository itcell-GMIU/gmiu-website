<?php
$pageTitle = "GMAP Admin View Student Details";
include './layout/admin/head.php';
include './layout/admin/navbar.php';


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin-view-students.php");
    exit;
}

$student_id = (int) $_GET['id'];

$stmt = $con->prepare("SELECT * FROM tbl_gmap_students WHERE id = ? AND is_active = 1 AND is_delete = 0");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: admin-view-students.php");
    exit;
}

$student = $result->fetch_assoc();
?>


<main class="flex-grow-1 py-4">
    <div class="container">
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1">Student Details</h5>
                    <small class="text-muted">
                        Application ID: <?= htmlspecialchars($student['application_id'] ?? 'Not Generated') ?>
                    </small>
                </div>
                <a href="admin-view-students.php" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">

            <!-- PROFILE CARD -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">

                        <?php
                        $photoPath = !empty($student['photo']) && file_exists("uploads/student-photo/" . $student['photo'])
                            ? "uploads/student-photo/" . $student['photo']
                            : "https://via.placeholder.com/150x150?text=No+Image";
                        ?>

                        <img src="<?= $photoPath ?>" class="rounded-circle mb-3" width="150" height="150"
                            style="object-fit:cover;">

                        <h5 class="fw-bold">
                            <?= htmlspecialchars($student['surname'] . ' ' . $student['student_name']) ?>
                        </h5>

                        <span class="badge bg-info text-dark">
                            Application ID : <?= htmlspecialchars($student['application_id'] ?? 'Pending') ?>
                        </span>

                        <div class="mt-3">
                            <small class="text-muted d-block">Email</small>
                            <?= htmlspecialchars($student['email']) ?>
                        </div>

                        <div class="mt-2">
                            <small class="text-muted d-block">Mobile</small>
                            <?= htmlspecialchars($student['mobile']) ?>
                        </div>

                    </div>
                </div>
            </div>

            <!-- DETAILS CARD -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Father Name:</strong><br>
                                <?= htmlspecialchars($student['father_name']) ?>
                            </div>

                            <div class="col-md-6">
                                <strong>Birth Date:</strong><br>
                                <?= htmlspecialchars($student['birthdate']) ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Gender:</strong><br>
                                <?= ucfirst(htmlspecialchars($student['gender'])) ?>
                            </div>

                            <div class="col-md-6">
                                <strong>Category:</strong><br>
                                <?= htmlspecialchars($student['category']) ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Qualification:</strong><br>
                                <?= htmlspecialchars($student['qualification']) ?>
                            </div>

                            <div class="col-md-6">
                                <strong>Seat Type:</strong><br>
                                <?= htmlspecialchars($student['seat']) ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>Address:</strong><br>
                            <?= nl2br(htmlspecialchars($student['address'])) ?>
                        </div>

                        <hr>

                        <h6 class="fw-bold">Documents</h6>

                        <?php if (!empty($student['docs'])): ?>
                            <?php
                            $docs = explode(',', $student['docs']);
                            foreach ($docs as $doc):
                                $docPath = "uploads/student-docs/" . $doc;
                                if (file_exists($docPath)):
                                    ?>
                                    <a href="<?= $docPath ?>" target="_blank" class="btn btn-outline-primary btn-sm me-2 mb-2">
                                        <i class="bi bi-file-earmark-pdf"></i> View Document
                                    </a>
                                    <?php
                                endif;
                            endforeach;
                            ?>
                        <?php else: ?>
                            <p class="text-muted">No documents uploaded.</p>
                        <?php endif; ?>

                        <?php if (!empty($student['referal_code'])): ?>
                            <hr>
                            <strong>Referral Code Used:</strong><br>
                            <span class="badge bg-success">
                                <?= htmlspecialchars($student['referal_code']) ?>
                            </span>
                        <?php endif; ?>

                        <hr>
                        <h6 class="fw-bold">Program Choices (Selected by Student)</h6>

                        <?php if (!empty($student['program_json'])): ?>

                            <?php
                            $programSelections = json_decode($student['program_json'], true);

                            foreach ($programSelections as $index => $choice):

                                // Fetch Faculty
                                $f = $con->prepare("SELECT name FROM tbl_faculty WHERE id = ?");
                                $f->bind_param("i", $choice['faculty_id']);
                                $f->execute();
                                $faculty = $f->get_result()->fetch_assoc()['name'] ?? 'N/A';

                                // Fetch Level
                                $l = $con->prepare("SELECT name FROM tbl_level WHERE id = ?");
                                $l->bind_param("i", $choice['level_id']);
                                $l->execute();
                                $level = $l->get_result()->fetch_assoc()['name'] ?? 'N/A';

                                // Fetch Program
                                $p = $con->prepare("SELECT name FROM tbl_program WHERE id = ?");
                                $p->bind_param("i", $choice['program_id']);
                                $p->execute();
                                $program = $p->get_result()->fetch_assoc()['name'] ?? 'N/A';
                                ?>

                                <div class="border rounded p-2 mb-2 bg-light">
                                    <strong>Choice
                                        <?= $index + 1 ?>:
                                    </strong><br>
                                    <?= ($faculty) ?> |
                                    <?= ($level) ?> |
                                    <?= ($program) ?>
                                </div>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <p class="text-muted">No program selected.</p>

                        <?php endif; ?>

                        <hr>
                        <h6 class="fw-bold">Seat Allotted (Final Assignment)</h6>

                        <?php if ($student['is_seat_alloted'] == 1): ?>

                            <?php
                            // Fetch Allotted Faculty
                            $af = $con->prepare("SELECT name FROM tbl_faculty WHERE id = ?");
                            $af->bind_param("i", $student['faculty_id']);
                            $af->execute();
                            $allotedFaculty = $af->get_result()->fetch_assoc()['name'] ?? 'N/A';

                            // Fetch Allotted Level
                            $al = $con->prepare("SELECT name FROM tbl_level WHERE id = ?");
                            $al->bind_param("i", $student['level_id']);
                            $al->execute();
                            $allotedLevel = $al->get_result()->fetch_assoc()['name'] ?? 'N/A';

                            // Fetch Allotted Program
                            $ap = $con->prepare("SELECT name FROM tbl_program WHERE id = ?");
                            $ap->bind_param("i", $student['program_id']);
                            $ap->execute();
                            $allotedProgram = $ap->get_result()->fetch_assoc()['name'] ?? 'N/A';
                            ?>

                            <div class="border rounded p-3 bg-success text-white">
                                <strong>Allotted Seat:</strong><br>
                                <?= ($allotedFaculty) ?> |
                                <?= ($allotedLevel) ?> |
                                <?= ($allotedProgram) ?>
                            </div>

                        <?php else: ?>

                            <span class="badge bg-secondary">Seat Not Allotted</span>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include './layout/admin/footer.php'; ?>
<?php include './layout/admin/endlinks.php'; ?>