<?php
include './include/config.php';

// Handle Add or Update
if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    if ($name !== '') {
        // Prepare query based on whether it's Add or Update
        if ($id > 0) {
            $query = "UPDATE gallery_academic_level SET name = ?, updated_at = NOW() WHERE id = ?";
            $types = "si";
            $params = [$name, $id];
            $action = "Updated";
        } else {
            $query = "INSERT INTO gallery_academic_level (name) VALUES (?)";
            $types = "s";
            $params = [$name];
            $action = "Added";
        }

        // Execute query
        $stmt = $con->prepare($query);
        $stmt->bind_param($types, ...$params);
        $success = $stmt->execute();
        $stmt->close();

        // Set response messages
        $_SESSION['status'] = $success
            ? "Academic Level {$action} Successfully"
            : "Academic Level {$action} Failed";
        $_SESSION['status_code'] = $success ? "success" : "error";
        $_SESSION['status_redirect'] = "acedemic-level.php";
    }
}


// Handle Edit (prefill)
$editData = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $con->prepare("SELECT * FROM gallery_academic_level WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Handle Soft Delete
if (isset($_GET['delete'], $_GET['status'])) {
    $id = (int) $_GET['delete'];
    $status = (int) $_GET['status'];

    // Determine new values based on status
    $isActive = ($status === 1) ? 1 : 0;
    $isDelete = ($status === 1) ? 0 : 1;
    $action = ($status === 1) ? "Activated" : "Deactivated";

    // Update record
    $stmt = $con->prepare("UPDATE gallery_academic_level SET is_active = ?, is_delete = ? WHERE id = ?");
    $stmt->bind_param("iii", $isActive, $isDelete, $id);
    $stmt->execute();
    $stmt->close();

    // Set session feedback
    $_SESSION['status'] = "Academic Level {$action} Successfully";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_redirect'] = "acedemic-level.php";
}


// Fetch All Records
$query = "SELECT * FROM gallery_academic_level ORDER BY id ASC";
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
                                <h4>Academic Level</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Academic Level</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- ADD / EDIT FORM -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="mb-20">
                        <?php echo $editData ? "Edit Academic Level" : "Add Academic Level"; ?>
                    </h5>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label for="name">Academic Level Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter Academic Level"
                                    value="<?php echo htmlspecialchars($editData['name'] ?? ''); ?>" required>
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
                    <h5 class="mb-20">Academic Level List</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10%">ID</th>
                                    <th width="50%">Name</th>
                                    <th width="20%">Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
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
                                        <td colspan="4" class="text-center">No records found.</td>
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
</body>

</html>