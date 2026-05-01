<?php
$pageTitle = "GMAP Admin Manage Referral Codes";
include './layout/admin/head.php';

if ($_SESSION['role_id'] != 61) {
    header("Location: admin-view-transactions.php");
    exit;
}

// Role ID and Code for GMAP
$fixed_role_id = 6;
$fixed_role_code = "GP";
$staff_id = $_SESSION['staff_id'] ?? 0;

// --- Handle Add Referral Code ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_referral_code'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // 1. Validation for Email and Contact (Role Specific)
    $check_dup = $con->prepare("SELECT id FROM tbl_referral_master WHERE role_id = ? AND (email = ? OR contact = ?) AND is_delete = 0");
    $check_dup->bind_param("iss", $fixed_role_id, $email, $contact);
    $check_dup->execute();
    $res_dup = $check_dup->get_result();

    if ($res_dup->num_rows > 0) {
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Duplicate Entry',
            'text' => 'This Email or Contact already has a referral code for this role.'
        ];
    } else {
        // 2. Automatic Code Generation
        // Find last referral_code for role 6
        $last_stmt = $con->prepare("SELECT referral_code FROM tbl_referral_master WHERE role_id = ? ORDER BY id DESC LIMIT 1");
        $last_stmt->bind_param("i", $fixed_role_id);
        $last_stmt->execute();
        $last_res = $last_stmt->get_result();

        $new_num = 111; // Starting number as requested
        if ($last_res->num_rows > 0) {
            $last_code = $last_res->fetch_assoc()['referral_code'];
            $last_num = intval(substr($last_code, strlen($fixed_role_code)));
            $new_num = max(111, $last_num + 1);
        }

        $referral_code = $fixed_role_code . str_pad($new_num, 3, "0", STR_PAD_LEFT);

        // 3. Insert into tbl_referral_master
        $stmt = $con->prepare("INSERT INTO tbl_referral_master (referral_code, name, role_id, contact, email, created_by) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissi", $referral_code, $name, $fixed_role_id, $contact, $email, $staff_id);

        if ($stmt->execute()) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Referral Added',
                'text' => "Referral Code ($referral_code) has been created successfully.",
                'redirect' => 'admin-add-refferal-code.php'
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'Failed to add referral code.'
            ];
        }
    }
}

// --- Handle Edit Referral Code ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_referral'])) {
    $id = (int) $_POST['id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Validation for Email and Contact (Role Specific, excluding current ID)
    $check_dup = $con->prepare("SELECT id FROM tbl_referral_master WHERE role_id = ? AND (email = ? OR contact = ?) AND is_delete = 0 AND id != ?");
    $check_dup->bind_param("issi", $fixed_role_id, $email, $contact, $id);
    $check_dup->execute();
    $res_dup = $check_dup->get_result();

    if ($res_dup->num_rows > 0) {
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Duplicate Entry',
            'text' => 'This Email or Contact already exists for another referral in this role.'
        ];
    } else {
        $stmt = $con->prepare("UPDATE tbl_referral_master SET name = ?, contact = ?, email = ? WHERE id = ? AND role_id = ?");
        $stmt->bind_param("sssii", $name, $contact, $email, $id, $fixed_role_id);

        if ($stmt->execute()) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Referral Updated',
                'text' => 'Referral details have been updated successfully.',
                'redirect' => 'admin-add-refferal-code.php'
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'error',
                'title' => 'Error',
                'text' => 'Failed to update referral details.'
            ];
        }
    }
}

// --- Handle Toggle Status ---
if (isset($_GET['toggle_id'])) {
    $id = (int) $_GET['toggle_id'];
    $con->query("UPDATE tbl_referral_master SET is_active = 1 - is_active WHERE id = $id");
    header("Location: admin-add-refferal-code.php");
    exit;
}

// --- Fetch Referral Codes for Role 6 ---
$referral_codes = $con->query("
    SELECT r.*, rr.role_name 
    FROM tbl_referral_master r
    JOIN tbl_referral_role rr ON r.role_id = rr.role_id
    WHERE r.role_id = $fixed_role_id AND r.is_delete = 0 
    ORDER BY r.id ASC
");

?>

<?php include './layout/admin/navbar.php'; ?>

<main class="flex-grow-1 py-4">
    <div class="container">
        <!-- Page Header -->
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-tags-fill me-2 text-danger"></i>
                        Manage Referral Codes
                    </h5>
                    <small class="text-muted">Automatic generation starting from GP111.</small>
                </div>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Referral
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Referral Code</th>
                                <th>Status</th>
                                <th width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($referral_codes && $referral_codes->num_rows > 0): ?>
                                <?php $i = 1;
                                while ($row = $referral_codes->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td class="fw-semibold"><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['contact']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td class="fw-bold text-danger"><?= htmlspecialchars($row['referral_code']) ?></td>
                                        <td>
                                            <a href="?toggle_id=<?= $row['id'] ?>"
                                                class="btn btn-sm text-decoration-none <?= $row['is_active'] ? 'btn-success' : 'btn-secondary' ?>">
                                                <?= $row['is_active'] ? 'Active' : 'Deactive' ?>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-primary edit-btn"
                                                data-id="<?= $row['id'] ?>" data-name="<?= htmlspecialchars($row['name']) ?>"
                                                data-contact="<?= htmlspecialchars($row['contact']) ?>"
                                                data-email="<?= htmlspecialchars($row['email']) ?>" data-bs-toggle="modal"
                                                data-bs-target="#editModal">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No referral codes found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add Referral</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Contact *</label>
                    <input type="text" name="contact" class="form-control" placeholder="Enter Contact Number" required
                        pattern="[0-9]{10}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email *</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter Email Address" required>
                </div>
                <div class="alert alert-info py-2 mb-0">
                    <small><i class="bi bi-info-circle me-1"></i> Referral Code will be generated automatically (Prefix:
                        GP).</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="add_referral_code" class="btn btn-danger">Create Referral</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Referral</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Name *</label>
                    <input type="text" name="name" id="edit_name" class="form-control" placeholder="Enter Full Name"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Contact *</label>
                    <input type="text" name="contact" id="edit_contact" class="form-control"
                        placeholder="Enter Contact Number" required pattern="[0-9]{10}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email *</label>
                    <input type="email" name="email" id="edit_email" class="form-control"
                        placeholder="Enter Email Address" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="edit_referral" class="btn btn-primary">Update Details</button>
            </div>
        </form>
    </div>
</div>

<?php include './layout/admin/footer.php'; ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.body.addEventListener('click', function (e) {
            const editBtn = e.target.closest('.edit-btn');
            if (editBtn) {
                const id = editBtn.getAttribute('data-id');
                const name = editBtn.getAttribute('data-name');
                const contact = editBtn.getAttribute('data-contact');
                const email = editBtn.getAttribute('data-email');

                document.getElementById('edit_id').value = id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_contact').value = contact;
                document.getElementById('edit_email').value = email;
            }
        });
    });
</script>
<?php include './layout/admin/endlinks.php'; ?>