<?php
include './include/config.php';

// Fetch all academic levels for dropdown
$academicLevels = $con->query("SELECT id, name FROM gallery_academic_level WHERE is_delete = 0 ORDER BY id ASC");

// Handle Add or Update
if (isset($_POST['submit'])) {
    $ac_level_id = isset($_POST['ac_level_id']) ? (int) $_POST['ac_level_id'] : 0;
    $name = trim($_POST['name']);
    $video_link = trim($_POST['video_link'] ?? '');
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    if ($ac_level_id > 0 && $name !== '') {
        if ($id > 0) {
            // --- UPDATE EXISTING RECORD ---
            $stmt = $con->prepare("UPDATE gallery_education_level 
                                   SET ac_level_id = ?, name = ?, video_link = ?, updated_at = NOW() 
                                   WHERE id = ?");
            $stmt->bind_param("issi", $ac_level_id, $name, $video_link, $id);
            $action = "Updated";
        } else {
            // --- INSERT NEW RECORD ---
            $stmt = $con->prepare("INSERT INTO gallery_education_level (ac_level_id, name, video_link) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $ac_level_id, $name, $video_link);
            $action = "Added";
        }

        $success = $stmt->execute();
        $stmt->close();

        $_SESSION['status'] = $success
            ? "Education Level {$action} Successfully"
            : "Education Level {$action} Failed";
        $_SESSION['status_code'] = $success ? "success" : "error";
        $_SESSION['status_redirect'] = "education-level.php";
    }
}

// Handle Edit (prefill)
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $stmt = $con->prepare("SELECT * FROM gallery_education_level WHERE id = ? AND is_delete = 0");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Handle Soft Delete / Toggle Active
if (isset($_GET['delete'], $_GET['status'])) {
    $id = (int) $_GET['delete'];
    $status = (int) $_GET['status'];

    $isActive = ($status === 1) ? 1 : 0;
    $isDelete = ($status === 1) ? 0 : 1;
    $action = ($status === 1) ? "Activated" : "Deactivated";

    $stmt = $con->prepare("UPDATE gallery_education_level SET is_active = ?, is_delete = ? WHERE id = ?");
    $stmt->bind_param("iii", $isActive, $isDelete, $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['status'] = "Education Level {$action} Successfully";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_redirect'] = "education-level.php";
}

// Fetch All Records
$query = "
    SELECT e.*, a.name AS academic_level_name 
    FROM gallery_education_level e
    LEFT JOIN gallery_academic_level a ON a.id = e.ac_level_id
    ORDER BY e.id ASC
";
$result = $con->query($query);
?>

<!DOCTYPE html>
<html>

<head>
    <?php include('include/head.php'); ?>
</head>

<body>
    <?php include('include/header.php'); ?>
    <?php include('include/sidebar.php'); ?>

    <div class="main-container">
        <div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Education Level</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Education Level</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- ADD / EDIT FORM -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="mb-20">
                        <?php echo $editData ? "Edit Education Level" : "Add Education Level"; ?>
                    </h5>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">
                        <div class="row">
                            <!-- Academic Level -->
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label for="ac_level_id">Academic Level <span class="text-danger">*</span></label>
                                <select name="ac_level_id" id="ac_level_id" class="form-control" required>
                                    <option value="">Select Academic Level</option>
                                    <?php if ($academicLevels && $academicLevels->num_rows > 0): ?>
                                        <?php while ($row = $academicLevels->fetch_assoc()): ?>
                                            <option value="<?php echo $row['id']; ?>" <?php echo isset($editData['ac_level_id']) && $editData['ac_level_id'] == $row['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($row['name']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Education Level Name -->
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label for="name">Education Level Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter Education Level"
                                    value="<?php echo htmlspecialchars($editData['name'] ?? ''); ?>" required>
                            </div>

                            <!-- Optional Video Link -->
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label for="video_link">Video Link (Optional)</label>
                                <input type="url" name="video_link" id="video_link" class="form-control"
                                    placeholder="https://example.com/video-link"
                                    value="<?php echo htmlspecialchars($editData['video_link'] ?? ''); ?>">
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">
                            <?php echo $editData ? "Update" : "Add"; ?>
                        </button>
                        <?php if ($editData): ?>
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary ml-2">Cancel</a>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- TABLE LIST -->
                <div class="pd-20 bg-white border-radius-4 box-shadow">
                    <h5 class="mb-20">Education Level List</h5>
                    <div class="table-responsive table-sm">
                        <table class="data-table table-striped table-hover nowrap">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Academic Level</th>
                                    <th width="25%">Education Level Name</th>
                                    <th width="30%">Video Link</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo htmlspecialchars($row['academic_level_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td>
                                                <?php if (!empty($row['video_link'])): ?>
                                                    <a href="<?php echo htmlspecialchars($row['video_link']); ?>"
                                                        target="_blank">View Video</a>
                                                <?php else: ?>
                                                    <span class="text-muted">—</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($row['is_active'] == 1 && $row['is_delete'] == 0): ?>
                                                    <span class="badge badge-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                                <?php if ($row['is_active'] == 1 && $row['is_delete'] == 0): ?>
                                                    <a href="?delete=<?php echo $row['id']; ?>&status=0"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to deactivate this record?');">
                                                        Deactivate
                                                    </a>
                                                <?php else: ?>
                                                    <a href="?delete=<?php echo $row['id']; ?>&status=1"
                                                        class="btn btn-sm btn-success"
                                                        onclick="return confirm('Are you sure you want to activate this record?');">
                                                        Activate
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>

    <script>
        $(document).ready(function () {
            $('.data-table').DataTable({
                scrollX: true,
                scrollCollapse: true,
                autoWidth: false,
                responsive: false,
                columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false,
                }],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "language": {
                    "info": "_START_-_END_ of _TOTAL_ entries",
                    searchPlaceholder: "Search"
                },
                dom: '<"d-flex justify-content-between"lBf>rtip',
                buttons: [
                    'copy', 'csv', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>

</html>