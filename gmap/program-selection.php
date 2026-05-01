<?php
$pageTitle = $pageTitle ?? "GMAP Program Selection";
include './layout/dashboard/head.php';
?>
<?php
$student_id = $_SESSION['student_id'];

$stmt = $con->prepare("
    SELECT program_json, is_selectable, is_program_lock, is_seat_alloted,
           faculty_id, level_id, program_id,
           surname, student_name, father_name, mobile, gender, birthdate,
           category, qualification, seat, photo, docs, address
    FROM tbl_gmap_students 
    WHERE id = ?
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$is_selectable = $data['is_selectable'] ?? 0;
$is_program_lock = $data['is_program_lock'] ?? 0;
$is_seat_alloted = $data['is_seat_alloted'] ?? 0;
$disabled = ($is_program_lock == 1 || $is_seat_alloted == 1) ? 'disabled' : '';
$allotedFacultyId = $data['faculty_id'] ?? null;
$allotedLevelId = $data['level_id'] ?? null;
$allotedProgramId = $data['program_id'] ?? null;

$is_profile_complete = !empty($data['surname']) && 
                       !empty($data['student_name']) && 
                       !empty($data['father_name']) && 
                       !empty($data['mobile']) && 
                       !empty($data['gender']) && 
                       !empty($data['birthdate']) && 
                       !empty($data['category']) && 
                       !empty($data['qualification']) && 
                       !empty($data['seat']) && 
                       !empty($data['photo']) && 
                       !empty($data['docs']) && 
                       !empty($data['address']);

$allotedDetails = null;

if ($is_seat_alloted == 1 && $allotedFacultyId && $allotedLevelId && $allotedProgramId) {

    $stmt = $con->prepare("
        SELECT 
            f.name AS faculty_name,
            l.name AS level_name,
            p.name AS program_name
        FROM tbl_faculty f
        JOIN tbl_level l ON l.id = ?
        JOIN tbl_program p ON p.id = ?
        WHERE f.id = ?
    ");

    $stmt->bind_param(
        "iii",
        $allotedLevelId,
        $allotedProgramId,
        $allotedFacultyId
    );

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $allotedDetails = $result->fetch_assoc();
    }
}
// If seat already allotted → force view-only mode
if ($is_seat_alloted == 1) {
    $is_program_lock = 1; // force locked view
}
$programSelections = [];

if (!empty($data['program_json'])) {
    $programSelections = json_decode($data['program_json'], true);
}

// ================= LOCK / UNLOCK HANDLER =================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    $otp = $_POST['otp'] ?? '';

    if (
        !isset($_SESSION['otp_data']) ||
        $_SESSION['otp_data']['purpose'] !== $_POST['action'] ||
        time() > $_SESSION['otp_data']['expires'] ||
        $otp != $_SESSION['otp_data']['code']
    ) {

        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Invalid OTP',
            'text' => 'Incorrect or expired OTP.',
            'redirect' => 'program-selection.php'
        ];

        header("Location: program-selection.php");
        exit;
    }

    if ($_POST['action'] === 'lock_program') {

        if (empty($data['program_json'])) {
            $_SESSION['alert'] = [
                'type' => 'error',
                'title' => 'Program Not Selected !',
                'text' => 'You didnt selected the programs yet, cannot lock choice!',
                'redirect' => 'program-selection.php'
            ];
            header("Location: program-selection.php");
            exit;
        }

        $update = $con->prepare("
        UPDATE tbl_gmap_students 
        SET is_program_lock = 1 
        WHERE id = ?
    ");
        $update->bind_param("i", $student_id);
        $update->execute();

        unset($_SESSION['otp_data']);

        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Locked',
            'text' => 'Your program choices are now locked.',
            'redirect' => 'program-selection.php'
        ];
        header("Location: program-selection.php");
        exit;
    }

    if ($_POST['action'] === 'unlock_program') {

        if ($is_seat_alloted == 1) {
            $_SESSION['alert'] = [
                'type' => 'error',
                'title' => 'Seat Allotted',
                'text' => 'You cannot unlock after seat allotment.',
                'redirect' => 'program-selection.php'
            ];
            header("Location: program-selection.php");
            exit;
        }

        $update = $con->prepare("
        UPDATE tbl_gmap_students 
        SET is_program_lock = 0 
        WHERE id = ?
    ");
        $update->bind_param("i", $student_id);
        $update->execute();

        unset($_SESSION['otp_data']);

        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Unlocked',
            'text' => 'You can now edit your program choices.',
            'redirect' => 'program-selection.php'
        ];
        header("Location: program-selection.php");
        exit;
    }
}

// Handle Form Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_selection'])) {

    if ($is_selectable != 1 || !$is_profile_complete) {
        $_SESSION['alert'] = [
            'type' => 'warning',
            'title' => 'Selection Locked',
            'text' => (!$is_profile_complete) ? 'Please complete your personal details first!' : 'Program selection is currently locked by admin.',
            'redirect' => 'program-selection.php'
        ];
        header("Location: program-selection.php");
        exit;
    }

    if ($is_program_lock == 1 || $is_seat_alloted == 1) {
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Not Allowed',
            'text' => 'You cannot modify after seat allotment.',
            'redirect' => 'program-selection.php'
        ];
        exit;
    }

    $faculties = $_POST['faculty_id'] ?? [];
    $levels = $_POST['level_id'] ?? [];
    $programs = $_POST['program_id'] ?? [];

    $programData = [];
    $uniqueCheck = [];

    for ($i = 0; $i < count($faculties); $i++) {

        if (
            empty($faculties[$i]) ||
            empty($levels[$i]) ||
            empty($programs[$i])
        ) {
            continue;
        }

        $key = $faculties[$i] . '-' . $levels[$i] . '-' . $programs[$i];

        if (in_array($key, $uniqueCheck)) {
            $_SESSION['alert'] = [
                'type' => 'error',
                'title' => 'Duplicate Selection',
                'text' => 'Duplicate program combinations are not allowed.'
            ];
            header("Location: program-selection.php");
            exit;
        }

        $uniqueCheck[] = $key;

        $programData[] = [
            "faculty_id" => (int) $faculties[$i],
            "level_id" => (int) $levels[$i],
            "program_id" => (int) $programs[$i]
        ];
    }

    if (empty($programData)) {
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Incomplete Selection',
            'text' => 'Please select at least one valid program.'
        ];
        header("Location: program-selection.php");
        exit;
    }

    $jsonData = json_encode($programData);

    $update = $con->prepare("
        UPDATE tbl_gmap_students 
        SET program_json = ?
        WHERE id = ?
    ");

    $update->bind_param("si", $jsonData, $student_id);

    if ($update->execute()) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Program Updated',
            'text' => 'Your program selections have been saved successfully.',
            'redirect' => 'program-selection.php'
        ];
    }
}

?>
<?php include './layout/dashboard/navbar.php'; ?>

<!-- ================= MAIN CONTENT ================= -->
<main class="flex-grow-1 py-5">
    <div class="container">


        <!-- ================= PAGE HEADER ================= -->
        <div class="card shadow-sm mb-4 card-accent">
            <div class="card-body">
                <h5 class="mb-1 text-theme-secondary fw-bold">
                    Program Selection
                </h5>
                <small class="text-muted">
                    Please select your Faculty, Level and Program carefully.
                </small>
            </div>
        </div>

        <!-- ================= PROGRAM FORM ================= -->
        <?php if ($is_selectable == 1 && $is_profile_complete): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-body">

                    <form method="POST" id="programForm">

                        <div id="programWrapper">

                            <?php
                            $facultyList = [];
                            $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' AND is_active='1'";
                            $stmt = $con->prepare($cmd);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                                $facultyList[] = $row;
                            }

                            if (!empty($programSelections)) {

                                foreach ($programSelections as $index => $selection) {

                                    $faculty_id = $selection['faculty_id'];
                                    $level_id = $selection['level_id'];
                                    $program_id = $selection['program_id'];
                                    ?>

                                    <div class="row program-row align-items-end mb-3">

                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Faculty</label>
                                            <select class="form-control faculty-select" name="faculty_id[]" id="faculty_id" <?= $disabled ?>>
                                                <option value="">--Please select--</option>
                                                <?php 
                                                $qualification = $data['qualification'] ?? '';
                                                foreach ($facultyList as $row) { 
                                                    $showFac = true;
                                                    if ($qualification == '10th' && $row['id'] != 1) $showFac = false;
                                                    if ($qualification == 'diploma' && $row['id'] != 1) $showFac = false;
                                                    if ($qualification == '12_science' && !in_array($row['id'], [1, 2, 3])) $showFac = false;
                                                    if (in_array($qualification, ['12_arts', '12_commerce']) && !in_array($row['id'], [4, 5, 6, 8, 9])) $showFac = false;

                                                    if (!$showFac) continue;
                                                ?>
                                                    <option value="<?= $row['id'] ?>" <?= ($faculty_id == $row['id']) ? 'selected' : '' ?>>
                                                        <?= $row['name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Level</label>
                                            <select name="level_id[]" 
                                            class="form-select level-select" 
                                            data-selected="<?= $level_id ?>" <?= $disabled ?>>
                                                <option value="">---Select Level---</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Program</label>
                                            <select name="program_id[]" 
                                            class="form-control program-select" 
                                            data-selected="<?= $program_id ?>" <?= $disabled ?>>
                                                <option value="">---Select Program---</option>
                                            </select>
                                        </div>

                                        <?php if ($is_program_lock == 0): ?>
                                            <div class="col-md-3 text-end action-buttons">
                                                <button type="button" class="btn btn-danger removeRow me-2">X</button>
                                                <button type="button" class="btn btn-success addRow">+</button>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                    <?php
                                }

                            } else {
                                ?>

                                <!-- If no data, show single empty row -->

                                <div class="row program-row align-items-end mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Faculty</label>
                                        <select class="form-control faculty-select" name="faculty_id[]" id="faculty_id" <?= $disabled ?>>
                                            <option value="">--Please select--</option>
                                                <?php
                                                $qualification = $data['qualification'] ?? '';
                                                $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' AND is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    $showFac = true;
                                                    if ($qualification == '10th' && $row['id'] != 1) $showFac = false;
                                                    if ($qualification == 'diploma' && $row['id'] != 1) $showFac = false;
                                                    if ($qualification == '12_science' && !in_array($row['id'], [1, 2, 3])) $showFac = false;
                                                    if (in_array($qualification, ['12_arts', '12_commerce']) && !in_array($row['id'], [4, 5, 6, 8, 9])) $showFac = false;

                                                    if (!$showFac) continue;
                                                ?>
                                                    <option value="<?= $row['id'] ?>">
                                                        <?= $row['name']; ?>
                                                    </option>
                                                <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Level</label>
                                        <select name="level_id[]" class="form-select level-select" id="level_id" <?= $disabled ?>>
                                            <option value="">---Select Level---</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Program</label>
                                        <select name="program_id[]" class="form-control program-select" id="program_id" <?= $disabled ?>>
                                            <option value="">---Select Program---</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 text-end">
                                        <button type="button" class="btn btn-success addRow">+</button>
                                    </div>
                                </div>

                            <?php } ?>

                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" name="confirm_selection" class="btn btn-danger px-4" <?= $disabled ?>>
                                Confirm Selection
                            </button>
                        </div>

                    </form>

                        <div class="mt-4 text-start">
                            <?php if ($is_seat_alloted == 1 && $allotedDetails): ?>
                                <div class="alert alert-success shadow-sm mb-4">
                                    <h6 class="fw-bold mb-3">
                                        🎉 Seat Allotted Successfully
                                    </h6>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <strong>Faculty:</strong><br>
                                            <?= htmlspecialchars($allotedDetails['faculty_name']) ?>
                                        </div>
                                
                                        <div class="col-md-4">
                                            <strong>Level:</strong><br>
                                            <?= htmlspecialchars($allotedDetails['level_name']) ?>
                                        </div>
                                
                                        <div class="col-md-4">
                                            <strong>Program:</strong><br>
                                            <?= htmlspecialchars($allotedDetails['program_name']) ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <p class="mb-2 fw-semibold text-dark">
                                        To confirm your seat, please pay the token fees.
                                    </p>
                                    <a href="payment.php" class="btn btn-success">
                                        💳 Pay Token Fees
                                    </a>
                                </div>
                            <?php elseif ($is_program_lock == 0): ?>
                                <button type="button" id="lockBtn" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#lockModal">
                                    🔒 Lock Choices
                                </button>
                            <?php else: ?>
                                <div class="alert alert-success mb-3">
                                    🔒 Your program choices are locked.
                                </div>
                                <button type="button" id="unlockBtn" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#unlockModal">
                                    🔓 Unlock Choices
                                </button>
                            <?php endif; ?>
                        </div>
                </div>
            </div>
        <?php else: ?>

            <div class="card shadow-sm border-start border-4 border-warning mb-4">
                <div class="card-body text-center py-5">

                    <i class="bi bi-lock-fill fs-1 text-warning mb-3"></i>

                    <h5 class="fw-bold text-warning">
                        <?= (!$is_profile_complete) ? 'Please Complete Personal Details' : 'Program Selection is Currently Locked' ?>
                    </h5>

                    <p class="text-muted mt-3 mb-0">
                        <?php if (!$is_profile_complete): ?>
                            You must fill all your personal details and upload required documents before you can select your programs.
                            <br><br>
                            <a href="personal-details.php" class="btn btn-warning">
                                <i class="bi bi-person-fill"></i> Go to Personal Details
                            </a>
                        <?php else: ?>
                            Please wait for the admin to approve your application. 
                            <br>
                            Once approved, program selection will be enabled for you.
                        <?php endif; ?>
                    </p>

                </div>
            </div>

        <?php endif; ?>

        <!-- ================= IMPORTANT NOTE ================= -->
        <div class="card shadow-sm border-start border-4 border-warning">
            <div class="card-body">
                <h6 class="fw-bold text-warning mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Important Note
                </h6>

                <ul class="small mb-0">
                    <li>Program once selected cannot be changed after seat allotment.</li>
                    <li>Eligibility will be verified during document verification.</li>
                    <li>Incorrect selection may lead to application rejection.</li>
                    <li>Seat allotment will be based on merit and availability.</li>
                </ul>
            </div>
        </div>

    </div>
</main>

<!-- LOCK MODAL -->
<div class="modal fade" id="lockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="">
                <input type="hidden" name="action" value="lock_program">
                <div class="modal-header">
                    <h5 class="modal-title">Enter OTP to Lock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted">OTP has been sent to your registered email.</p>
                    <input type="text" name="otp" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Verify & Lock</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- UNLOCK MODAL -->
<div class="modal fade" id="unlockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="">
                <input type="hidden" name="action" value="unlock_program">
                <div class="modal-header">
                    <h5 class="modal-title">Enter OTP to Unlock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted">OTP has been sent to your registered email.</p>
                    <input type="text" name="otp" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary">Verify & Unlock</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
$faculty_id = $faculty_id ?? null;
$level_id = $level_id ?? null;
$program_id = $program_id ?? null;
?>
<?php include './layout/dashboard/footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js">
</script>

<script>
    $(document).ready(function () {

        // =============================
        // Refresh Add / Remove Buttons
        // =============================
        function refreshButtons() {

            $('.program-row').each(function (index) {

                var total = $('.program-row').length;
                var removeBtn = $(this).find('.removeRow');
                var addBtn = $(this).find('.addRow');

                // Hide all add buttons first
                addBtn.hide();

                // Show remove only if more than 1 row
                if (total > 1) {
                    removeBtn.show();
                } else {
                    removeBtn.hide();
                }

                // Show add button only on last row
                if (index === total - 1) {
                    addBtn.show();
                }
            });
        }


        // =============================
        // Load existing selections
        // =============================
        $('.program-row').each(function () {

            var row = $(this);
            var faculty_id = row.find('.faculty-select').val();
            var levelSelected = row.find('.level-select').data('selected');
            var programSelected = row.find('.program-select').data('selected');

            if (faculty_id) {

                $.post('level.php', {
                    faculty_data: faculty_id,
                    level_id: levelSelected
                }, function (data) {

                    // Filter Level Options based on qualification
                    var qualification = "<?= $data['qualification'] ?? '' ?>";
                    var $filteredLevels = $(data).filter(function() {
                        var lvlId = $(this).val();
                        if (lvlId === "") return true; // Always keep default select option
                        
                        if (qualification === '10th') return lvlId == '5';
                        if (qualification === 'diploma') return lvlId == '9';
                        if (['12_science', '12_arts', '12_commerce'].includes(qualification)) return lvlId == '1';
                        
                        return true;
                    });

                    row.find('.level-select').html($filteredLevels);

                    if (levelSelected) {
                        $.post('program.php', {
                            faculty_data: faculty_id,
                            level_data: levelSelected,
                            program_id: programSelected
                        }, function (data2) {
                            row.find('.program-select').html(data2);
                        });
                    }

                });
            }

        });


        // =============================
        // Add new row
        // =============================
        $(document).on('click', '.addRow', function () {

            var newRow = $('.program-row:first').clone();

            newRow.find('select').val('');
            newRow.find('.level-select').html('<option value="">---Select Level---</option>');
            newRow.find('.program-select').html('<option value="">---Select Program---</option>');

            $('#programWrapper').append(newRow);

            refreshButtons();

            // Optional smooth scroll to new row (mobile friendly)
            $('html, body').animate({
                scrollTop: newRow.offset().top - 100
            }, 400);
        });


        // =============================
        // Remove row
        // =============================
        $(document).on('click', '.removeRow', function () {
            $(this).closest('.program-row').remove();
            refreshButtons();
        });


        // =============================
        // Faculty change
        // =============================
        $(document).on('change', '.faculty-select', function () {

            var faculty_id = $(this).val();
            var row = $(this).closest('.program-row');
            var levelDropdown = row.find('.level-select');
            var programDropdown = row.find('.program-select');

            levelDropdown.html('<option value="">---Select Level---</option>');
            programDropdown.html('<option value="">---Select Program---</option>');

            $.post('level.php', { faculty_data: faculty_id }, function (data) {
                
                // Filter Level Options based on qualification
                var qualification = "<?= $data['qualification'] ?? '' ?>";
                var $filteredLevels = $(data).filter(function() {
                    var lvlId = $(this).val();
                    if (lvlId === "") return true; // Always keep default select option
                    
                    if (qualification === '10th') return lvlId == '5';
                    if (qualification === 'diploma') return lvlId == '9';
                    if (['12_science', '12_arts', '12_commerce'].includes(qualification)) return lvlId == '1';
                    
                    return true;
                });

                levelDropdown.html($filteredLevels);
            });
        });


        // =============================
        // Level change
        // =============================
        $(document).on('change', '.level-select', function () {

            var level_id = $(this).val();
            var row = $(this).closest('.program-row');
            var faculty_id = row.find('.faculty-select').val();
            var programDropdown = row.find('.program-select');

            programDropdown.html('<option value="">---Select Program---</option>');

            $.post('program.php', {
                level_data: level_id,
                faculty_data: faculty_id
            }, function (data) {
                programDropdown.html(data);
            });
        });


        // Initial button setup
        refreshButtons();

    });


// Script for the OTP  
$(document).ready(function () {

    function sendOtp(purpose) {

        Swal.fire({
            title: 'Sending OTP...',
            text: 'Please wait while we send the OTP to your email.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "send-mail.php",
            type: "POST",
            dataType: "json",

            data: {
                email: "<?= $_SESSION['student_email'] ?>",
                    type: "otp",
                    otp_purpose: purpose
                },

                success: function (res) {

                    Swal.close();

                    if (res.status === "success") {

                        Swal.fire({
                            icon: "success",
                            title: "OTP Sent",
                            text: "OTP has been sent to your registered email.",
                            confirmButtonColor: "#bc2823"
                        });

                    } else {

                        Swal.fire({
                            icon: "error",
                            title: "Mail Error",
                            text: res.message,
                            confirmButtonColor: "#bc2823"
                        });

                    }

                },

                error: function () {

                    Swal.close();

                    Swal.fire({
                        icon: "error",
                        title: "Server Error",
                        text: "Unable to send OTP right now. Please try again later.",
                        confirmButtonColor: "#bc2823"
                    });

                }

            });

        }

        $("#lockBtn").click(function () {
            sendOtp("lock_program");
        });

        $("#unlockBtn").click(function () {
            sendOtp("unlock_program");
        });

    });
</script>

<?php include './layout/dashboard/endlinks.php'; ?>