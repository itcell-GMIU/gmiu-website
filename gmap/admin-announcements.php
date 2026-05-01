<?php
$pageTitle = "GMAP Admin Announcements";
include './layout/admin/head.php';

if ($_SESSION['role_id'] != 61) {
    header("Location: admin-view-transactions.php");
    exit;
}

// --- Create table if not exists ---
// $con->query("
//     CREATE TABLE IF NOT EXISTS tbl_gmap_announcements (
//         id INT AUTO_INCREMENT PRIMARY KEY,
//         title VARCHAR(255) NOT NULL,
//         description TEXT,
//         file_path VARCHAR(255),
//         display_date DATE NOT NULL,
//         is_active TINYINT(1) DEFAULT 1,
//         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
//     )
// ");

// --- Handle Add Announcement ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_announcement'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $display_date = $_POST['display_date'];
    $file_path = NULL;

    if (!empty($_FILES['attachment']['name'])) {
        $uploadDir = "uploads/announcements/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $fileName = time() . "_" . basename($_FILES['attachment']['name']);
        if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadDir . $fileName)) {
            $file_path = $fileName;
        }
    }

    $stmt = $con->prepare("INSERT INTO tbl_gmap_announcements (title, description, file_path, display_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $file_path, $display_date);
    
    if ($stmt->execute()) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Announcement Added',
            'text' => 'Announcement has been created successfully.',
            'redirect' => 'admin-announcements.php'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Error',
            'text' => 'Failed to add announcement.'
        ];
    }
}

// --- Handle Toggle Status ---
if (isset($_GET['toggle_id'])) {
    $id = (int)$_GET['toggle_id'];
    $con->query("UPDATE tbl_gmap_announcements SET is_active = 1 - is_active WHERE id = $id");
    header("Location: admin-announcements.php");
    exit;
}

// --- Handle Delete ---
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    // Delete file if exists
    $res = $con->query("SELECT file_path FROM tbl_gmap_announcements WHERE id = $id");
    if ($row = $res->fetch_assoc()) {
        if ($row['file_path'] && file_exists("uploads/announcements/" . $row['file_path'])) {
            unlink("uploads/announcements/" . $row['file_path']);
        }
    }
    $con->query("DELETE FROM tbl_gmap_announcements WHERE id = $id");
    header("Location: admin-announcements.php");
    exit;
}

$announcements = $con->query("SELECT * FROM tbl_gmap_announcements ORDER BY display_date DESC");

?>

<?php include './layout/admin/navbar.php'; ?>

<main class="flex-grow-1 py-4">
    <div class="container">
        <!-- Page Header -->
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-megaphone-fill me-2 text-danger"></i>
                        Manage Announcements
                    </h5>
                    <small class="text-muted">Create and manage announcements for students.</small>
                </div>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Announcement
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Display Date</th>
                            <th>File</th>
                            <th>Status</th>
                            <th width="150" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($announcements->num_rows > 0): ?>
                            <?php while ($row = $announcements->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($row['title']) ?></td>
                                    <td><small class="text-muted"><?= htmlspecialchars(substr($row['description'], 0, 50)) ?>...</small></td>
                                    <td><?= date('d M, Y', strtotime($row['display_date'])) ?></td>
                                    <td>
                                        <?php if ($row['file_path']): ?>
                                            <a href="uploads/announcements/<?= $row['file_path'] ?>" target="_blank" class="btn btn-sm btn-outline-primary py-0">
                                                <i class="bi bi-file-earmark-arrow-down"></i> View
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">None</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="?toggle_id=<?= $row['id'] ?>" class="btn btn-sm text-decoration-none <?= $row['is_active'] ? 'btn-success' : 'btn-secondary' ?>">
                                            <?= $row['is_active'] ? 'Active' : 'Deactive' ?>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="?delete_id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No announcements found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter title" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Enter announcement details"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Display From Date</label>
                        <input type="date" name="display_date" class="form-control" required value="<?= date('Y-m-d') ?>">
                        <small class="text-muted">Will be visible from this date.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Attachment <small>(Optional)</small></label>
                        <input type="file" name="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="add_announcement" class="btn btn-danger">Create Announcement</button>
            </div>
        </form>
    </div>
</div>

<?php include './layout/admin/footer.php'; ?>
<?php include './layout/admin/endlinks.php'; ?>
