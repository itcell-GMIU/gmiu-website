<?php
$pageTitle = $pageTitle ?? "GMAP Personal Details";
include './layout/dashboard/head.php';
?>
<?php
$student_id = $_SESSION['student_id'];

// Fetch existing data
$stmt = $con->prepare("SELECT * FROM tbl_gmap_students WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$is_profile_complete = !empty($data['surname'] ?? '') && 
                       !empty($data['student_name'] ?? '') && 
                       !empty($data['father_name'] ?? '') && 
                       !empty($data['mobile'] ?? '') && 
                       !empty($data['gender'] ?? '') && 
                       !empty($data['birthdate'] ?? '') && 
                       !empty($data['category'] ?? '') && 
                       !empty($data['qualification'] ?? '') && 
                       !empty($data['seat'] ?? '') && 
                       !empty($data['photo'] ?? '') && 
                       !empty($data['docs'] ?? '') && 
                       !empty($data['address'] ?? '');

// Handle Form Submit (Add or Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $surname = $_POST['surname'];
    $student_name = $_POST['student_name'];
    $father_name = $_POST['father_name'];
    $mobile = $_POST['mobile'];
    $gender = strtolower($_POST['gender']);
    $birth_date = $_POST['birth_date'];
    $category = $_POST['category'];
    $qualification = $_POST['qualification'];
    $seat_type = $_POST['seat_type'];
    $address = $_POST['address'];

    // Define folders
    $photoDir = "uploads/student-photo/";
    $docsDir = "uploads/student-docs/";

    // Create folders if not exist
    if (!is_dir($photoDir)) {
        mkdir($photoDir, 0755, true);
    }

    if (!is_dir($docsDir)) {
        mkdir($docsDir, 0755, true);
    }

    /* ================= PHOTO UPLOAD ================= */

    $photoName = $data['photo'];

    if (!empty($_FILES['photo']['name'])) {

        // Delete old photo if exists
        if (!empty($data['photo']) && file_exists($photoDir . $data['photo'])) {
            unlink($photoDir . $data['photo']);
        }

        // Upload new photo
        $photoName = time() . "_" . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], $photoDir . $photoName);
    }


    /* ================= DOCS UPLOAD ================= */

    $docs = $data['docs'];

    if (!empty($_FILES['docs']['name'][0])) {

        // Delete old documents if exist
        if (!empty($data['docs'])) {

            $oldDocs = explode(',', $data['docs']);

            foreach ($oldDocs as $oldFile) {
                if (file_exists($docsDir . $oldFile)) {
                    unlink($docsDir . $oldFile);
                }
            }
        }

        // Upload new documents
        $uploadedFiles = [];

        foreach ($_FILES['docs']['name'] as $key => $name) {

            if ($_FILES['docs']['error'][$key] == 0) {

                $newName = time() . "_" . uniqid() . "_" . $name;
                move_uploaded_file($_FILES['docs']['tmp_name'][$key], $docsDir . $newName);
                $uploadedFiles[] = $newName;
            }
        }

        $docs = implode(',', $uploadedFiles);
    }

    $referalInput = trim($_POST['referal_code'] ?? '');
    $referalValid = false;
    $referalInvalidMessage = false;

    // Only check if user entered something AND referral not already saved
    if (!empty($referalInput) && empty($data['referal_code'])) {

        $checkRef = $con->prepare("SELECT id FROM tbl_referral_master WHERE referral_code = ? AND is_active = 1 AND is_delete = 0");
        $checkRef->bind_param("s", $referalInput);
        $checkRef->execute();
        $checkRef->store_result();

        if ($checkRef->num_rows > 0) {
            $referalValid = true;
        } else {
            $referalInvalidMessage = true;
        }
    }

    if ($referalValid) {

        $update = $con->prepare("
        UPDATE tbl_gmap_students SET
        surname = ?, student_name = ?, father_name = ?,
        mobile = ?, gender = ?, birthdate = ?,
        category = ?, qualification = ?, seat = ?,
        photo = ?, docs = ?, address = ?,
        referal_code = ?
        WHERE id = ?
    ");

        $update->bind_param(
            "sssssssssssssi",
            $surname,
            $student_name,
            $father_name,
            $mobile,
            $gender,
            $birth_date,
            $category,
            $qualification,
            $seat_type,
            $photoName,
            $docs,
            $address,
            $referalInput,
            $student_id
        );

    } else {

        $update = $con->prepare("
        UPDATE tbl_gmap_students SET
        surname = ?, student_name = ?, father_name = ?,
        mobile = ?, gender = ?, birthdate = ?,
        category = ?, qualification = ?, seat = ?,
        photo = ?, docs = ?, address = ?
        WHERE id = ?
    ");

        $update->bind_param(
            "ssssssssssssi",
            $surname,
            $student_name,
            $father_name,
            $mobile,
            $gender,
            $birth_date,
            $category,
            $qualification,
            $seat_type,
            $photoName,
            $docs,
            $address,
            $student_id
        );
    }

    if ($update->execute()) {

        // Refresh latest data
        $stmt = $con->prepare("SELECT application_id FROM tbl_gmap_students WHERE id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();

        // Generate application_id only if not exists
        if (empty($row['application_id'])) {

            $day = date("d");
            $month = date("m");
            $year = date("y");

            $application_id = "GMAP{$day}A{$month}K{$year}K{$student_id}I";

            $appUpdate = $con->prepare("
            UPDATE tbl_gmap_students 
            SET application_id = ? 
            WHERE id = ?
        ");
            $appUpdate->bind_param("si", $application_id, $student_id);
            $appUpdate->execute();
        }

        if ($referalInvalidMessage) {

            $_SESSION['alert'] = [
                'type' => 'warning',
                'title' => 'Profile Saved',
                'text' => 'Your personal details have been saved. BUT THE REFERRAL CODE IS INVALID.',
                'redirect' => 'personal-details.php'
            ];

        } else {

            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Profile Updated',
                'text' => 'Your personal details have been saved.',
                'redirect' => 'personal-details.php'
            ];

        }

    } else {

        // error_log("Profile Update Error: " . $update->error);

        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Update Failed',
            'text' => 'Something went wrong while saving your details. Please try again.'
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
            <div class="card-body d-md-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 text-theme-secondary fw-bold">
                        Personal Details
                    </h5>
                    <small class="text-muted">
                        Please fill in your personal information carefully.
                    </small>
                </div>
            </div>
        </div>

        <?php if (!$is_profile_complete): ?>
            <div class="alert alert-info border-start border-4 border-info shadow-sm mb-4">
                <div class="d-flex">
                    <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Action Required: Complete Your Profile</h6>
                        <p class="small mb-0">
                            To unlock <strong>Program Selection</strong>, you must fill in all fields below and upload your photo and documents.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- ================= PERSONAL DETAILS FORM ================= -->
        <div class="card shadow-sm">
            <div class="card-body">

                <form action="" method="POST" enctype="multipart/form-data">

                    <div class="row">

                        <!-- Surname -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Surname</label>
                            <input type="text" name="surname" class="form-control"
                                value="<?= htmlspecialchars($data['surname'] ?? '') ?>" placeholder="Enter surname"
                                required>
                        </div>

                        <!-- Student Name -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Student Name</label>
                            <input type="text" name="student_name" class="form-control"
                                value="<?= htmlspecialchars($data['student_name'] ?? '') ?>"
                                placeholder="Enter student name" required>
                        </div>

                        <!-- Father Name -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Father Name</label>
                            <input type="text" name="father_name" class="form-control"
                                value="<?= htmlspecialchars($data['father_name'] ?? '') ?>"
                                placeholder="Enter father name" required>
                        </div>

                        <!-- Mobile -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Mobile Number</label>
                            <input type="tel" name="mobile" class="form-control"
                                value="<?= htmlspecialchars($data['mobile'] ?? '') ?>" maxlength="10"
                                pattern="[0-9]{10}" placeholder="10 digit mobile number" required>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="">Select Gender</option>
                                <option value="Male" <?= ($data['gender'] ?? '') == 'male' ? 'selected' : '' ?>>Male
                                </option>
                                <option value="Female" <?= ($data['gender'] ?? '') == 'female' ? 'selected' : '' ?>>Female
                                </option>
                                <option value="Other" <?= ($data['gender'] ?? '') == 'other' ? 'selected' : '' ?>>Other
                                </option>
                            </select>
                        </div>

                        <!-- Birth Date -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Birth Date</label>
                            <input type="date" name="birth_date" class="form-control"
                                value="<?= htmlspecialchars($data['birthdate'] ?? '') ?>" required>
                        </div>

                        <!-- Category -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category" class="form-select" id="categorySelect" required>
                                <option value="">Select Category</option>
                                <option value="General" <?= ($data['category'] ?? '') == 'General' ? 'selected' : '' ?>>
                                    General</option>
                                <option value="OBC" <?= ($data['category'] ?? '') == 'OBC' ? 'selected' : '' ?>>OBC
                                </option>
                                <option value="SC" <?= ($data['category'] ?? '') == 'SC' ? 'selected' : '' ?>>SC</option>
                                <option value="ST" <?= ($data['category'] ?? '') == 'ST' ? 'selected' : '' ?>>ST</option>
                                <option value="EWS" <?= ($data['category'] ?? '') == 'EWS' ? 'selected' : '' ?>>EWS
                                </option>
                            </select>
                        </div>

                        <!-- Email (NOT EDITABLE) -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control"
                                value="<?= htmlspecialchars($data['email'] ?? '') ?>" readonly>

                            <small class="text-muted">
                                Email cannot be changed once registered.
                            </small>
                        </div>

                        <!-- Photo Upload -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Upload Photo</label>
                            <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png"
                                <?= empty($data['photo']) ? 'required' : '' ?>>
                        </div>

                        <!-- Address -->
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Address</label>
                            <textarea name="address" rows="3" class="form-control" placeholder="Enter full address"
                                required><?= htmlspecialchars($data['address'] ?? '') ?></textarea>
                        </div>

                        <!-- Qualification -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Qualification</label>
                            <select name="qualification" class="form-select" required>
                                <option value="">Select Qualification</option>
                                <option value="10th" <?= ($data['qualification'] ?? '') == '10th' ? 'selected' : '' ?>>10th
                                    Standard</option>
                                <option value="12_science" <?= ($data['qualification'] ?? '') == '12_science' ? 'selected' : '' ?>>12th Science</option>
                                <option value="12_commerce" <?= ($data['qualification'] ?? '') == '12_commerce' ? 'selected' : '' ?>>12th Commerce</option>
                                <option value="12_arts" <?= ($data['qualification'] ?? '') == '12_arts' ? 'selected' : '' ?>>12th Arts</option>
                                <option value="diploma" <?= ($data['qualification'] ?? '') == 'diploma' ? 'selected' : '' ?>>Diploma Graduate</option>
                            </select>
                        </div>

                        <!-- Seat Selection -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold d-block">Seat Selection</label>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="seat_type" value="Regular"
                                    <?= ($data['seat'] ?? '') == 'Regular' ? 'checked' : '' ?> required>
                                <label class="form-check-label">Regular</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="seat_type" value="TFWS"
                                    <?= ($data['seat'] ?? '') == 'TFWS' ? 'checked' : '' ?> required>
                                <label class="form-check-label">TFWS</label>
                            </div>
                        </div>

                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold text-theme-secondary mb-3">
                        <i class="bi bi-folder-check me-2 text-theme-primary"></i>
                        Document Uploads
                    </h6>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold docs-label" id="documentsLabel">
                                Upload Documents (Aadhaar, Marksheet, LC) *
                            </label>

                            <input type="file" name="docs[]" class="form-control" accept=".pdf"
                                <?= empty($data['docs']) ? 'required' : '' ?>>

                            <small class="text-muted">
                                You have to make PDF of every documents according to your cast category, and have to upload here.
                            </small>
                        </div>

                        <?php if (empty($data['referal_code'])): ?>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Have a Referal Code ? <small>(Optional)</small>
                                </label>
                                <input type="text" name="referal_code" class="form-control" placeholder="Referal Code">
                                <small class="text-muted">
                                    Only Valid Referal Code is Acceptable !
                                </small>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="bi bi-save"></i> Save Details
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</main>

<?php include './layout/dashboard/footer.php'; ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        const categorySelect = document.getElementById("categorySelect");
        const documentsLabel = document.getElementById("documentsLabel");

        function updateDocumentsLabel(category) {

            let text = "";

            switch (category) {
                case "General":
                    text = "Upload Documents (Aadhaar, Marksheet, LC) *";
                    break;

                case "OBC":
                    text = "Upload Documents (Aadhaar, Marksheet, LC, Caste Certificate, Non-Creamy Layer Certificate, Income Certificate) *";
                    break;

                case "SC":
                case "ST":
                    text = "Upload Documents (Aadhaar, Marksheet, LC, Caste Certificate, Income Certificate) *";
                    break;

                case "EWS":
                    text = "Upload Documents (Aadhaar, Marksheet, LC, Caste Certificate, Income Certificate) *";
                    break;

                default:
                    text = "Upload Documents (Aadhaar, Marksheet, LC) *";
            }

            documentsLabel.textContent = text;
        }

        // On change
        categorySelect.addEventListener("change", function () {
            updateDocumentsLabel(this.value);
        });

        // On page load (for edit mode)
        if (categorySelect.value) {
            updateDocumentsLabel(categorySelect.value);
        }

    });
</script>
<?php include './layout/dashboard/endlinks.php'; ?>