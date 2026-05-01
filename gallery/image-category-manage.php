<?php
include './include/config.php';

// Handle Add or Update
if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    if ($title !== '') {

        // If ID exists → Update
        if ($id > 0) {
            $query = "UPDATE gallery_images_category SET title = ?, updated_at = NOW() WHERE id = ?";
            $types = "si";
            $params = [$title, $id];
            $action = "Updated";
        }
        // Else Add New Record
        else {
            $query = "INSERT INTO gallery_images_category (title) VALUES (?)";
            $types = "s";
            $params = [$title];
            $action = "Added";
        }

        // Execute prepared query
        $stmt = $con->prepare($query);
        $stmt->bind_param($types, ...$params);
        $success = $stmt->execute();
        $stmt->close();

        // Session messages
        $_SESSION['status'] = "Category {$action} " . ($success ? "Successfully" : "Failed");
        $_SESSION['status_code'] = $success ? "success" : "error";
        $_SESSION['status_redirect'] = "image-category-manage.php";
    }
}

// Handle Edit (Load Data)
$editData = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $con->prepare("SELECT * FROM gallery_images_category WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Handle Soft Delete (Activate / Deactivate)
if (isset($_GET['delete'], $_GET['status'])) {
    $id = (int) $_GET['delete'];
    $status = (int) $_GET['status'];

    // Toggle values
    $isActive = ($status === 1) ? 1 : 0;
    $isDelete = ($status === 1) ? 0 : 1;
    $action = ($status === 1) ? "Activated" : "Deactivated";

    // Update record
    $stmt = $con->prepare("UPDATE gallery_images_category SET is_active = ?, is_delete = ? WHERE id = ?");
    $stmt->bind_param("iii", $isActive, $isDelete, $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['status'] = "Category {$action} Successfully";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_redirect'] = "image-category-manage.php";
}

// Fetch all data
$result = $con->query("SELECT * FROM gallery_images_category ORDER BY id ASC");

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

                <!-- PAGE HEADER -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Manage Images Category</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Manage Images Category</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- ADD / EDIT FORM -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="mb-20">
                        <?php echo $editData ? "Edit Category" : "Add Category"; ?>
                    </h5>

                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">

                        <div class="form-group">
                            <label for="title">Title <span style="color:red">*</span></label>
                            <input type="text" id="title" name="title" class="form-control"
                                placeholder="Enter Category Title"
                                value="<?php echo htmlspecialchars($editData['title'] ?? ''); ?>" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">
                            <?php echo $editData ? "Update" : "Add"; ?>
                        </button>

                        <?php if ($editData): ?>
                            <a href="image-category-manage.php" class="btn btn-secondary ml-2">Cancel</a>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- TABLE LIST -->
                <div class="pd-20 bg-white border-radius-4 box-shadow">
                    <h5 class="mb-20">Category List</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10%">ID</th>
                                    <th width="50%">Title</th>
                                    <th width="20%">Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo htmlspecialchars($row['title']); ?></td>

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
                                                        onclick="return confirm('Deactivate this category?');"
                                                        class="btn btn-sm btn-danger">Deactivate</a>
                                                <?php else: ?>
                                                    <a href="?delete=<?php echo $row['id']; ?>&status=1"
                                                        onclick="return confirm('Activate this category?');"
                                                        class="btn btn-sm btn-success">Activate</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>

                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No Records Found.</td>
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