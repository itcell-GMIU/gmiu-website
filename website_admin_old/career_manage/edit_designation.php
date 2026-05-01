<?php
include '../include/checklogin.php';

// Check for ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['status'] = "Invalid request!";
    $_SESSION['status_code'] = "error";
    echo "<script>window.location='view_designation.php';</script>";
    exit;
}

$id = (int)$_GET['id'];

// Fetch all active roles for dropdown
$roles_query = "SELECT id, name  FROM tbl_career_role WHERE is_active = '1' ORDER BY name ASC";
$roles_result = mysqli_query($con, $roles_query);

// Fetch current designation
$query = "SELECT * FROM tbl_designation WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['status'] = "Designation not found!";
    $_SESSION['status_code'] = "error";
    echo "<script>window.location='view_designation.php';</script>";
    exit;
}

$row = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $designation = mysqli_real_escape_string($con, $_POST['designation']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    $updateQuery = "UPDATE tbl_designation SET role_id = ?, name = ? , is_active=?  WHERE id = ?";
    $stmt = $con->prepare($updateQuery);
    $stmt->bind_param("issi", $role, $designation, $status, $id);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Designation updated successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='view_designation.php'}, 1000);</script>";
    } else {
        $_SESSION['status'] = "Update failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='edit_designation.php?id=$id'}, 1000);</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <title>Edit Designation</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include '../include/importnav.php'; ?>
    <?php include '../include/importsidebar.php'; ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Designation</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Edit Designation</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-gmiu">
                            <div class="card-header">
                                <h3 class="card-title">Edit Designation</h3>
                            </div>

                            <form method="POST" enctype="multipart/form-data">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label>Role <span style="color: red;">*</span></label>
                                        <select name="role" class="form-control" required>
                                            <option value="">-- Select Role --</option>
                                            <?php while ($role = mysqli_fetch_assoc($roles_result)) { ?>
                                                <option value="<?= $role['id']; ?>" <?= ($row['role_id'] == $role['id']) ? 'selected' : ''; ?>>
                                                    <?= htmlspecialchars($role['name']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Designation Title <span style="color: red;">*</span></label>
                                        <input type="text" name="designation" class="form-control"
                                               value="<?= htmlspecialchars($row['name']); ?>" required>
                                    </div>
                                      <div class="form-group">
                                            <label>Status <span style="color: red;"> *</span></label>
                                            <select name="status" class="form-control" required>
                                                <option value="1" <?php echo ($row['is_active'] == 1) ? 'selected' : ''; ?>>Active</option>
                                                <option value="0" <?php echo ($row['is_active'] == 0) ? 'selected' : ''; ?>>Inactive</option>
                                            </select>
                                        </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                                    <a href="view_designation.php" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

<?php include '../include/importfooter.php'; ?>
<?php include '../include/importjs.php'; ?>
</body>
</html>
