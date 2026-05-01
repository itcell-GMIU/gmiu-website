<?php
include './include/config.php';

// ---------- EDIT MODE ----------
$edit_id = 0;
$edit_remark = '';
$edit_category = '';

if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);

    $editQuery = $con->prepare("
        SELECT remark, category 
        FROM tbl_inquiry_calling_short_remarks 
        WHERE id = ? AND is_delete = 0
    ");
    $editQuery->bind_param("i", $edit_id);
    $editQuery->execute();
    $editQuery->bind_result($edit_remark, $edit_category);
    $editQuery->fetch();
    $editQuery->close();
}

// ---------- ADD REMARK ----------
if (isset($_POST['save_remark'])) {

    $remark = trim($_POST['remark'] ?? '');
    $category = trim($_POST['category'] ?? '');

    if ($remark !== '' && in_array($category, ['HOT', 'COLD', 'CLOSE'])) {

        // Duplicate check
        $check = $con->prepare("
            SELECT id FROM tbl_inquiry_calling_short_remarks 
            WHERE remark = ? AND is_delete = 0
        ");
        $check->bind_param("s", $remark);
        $check->execute();
        $check->store_result();

        if ($check->num_rows == 0) {
            $stmt = $con->prepare("
                INSERT INTO tbl_inquiry_calling_short_remarks 
                (remark, category, is_active, is_delete, created_at)
                VALUES (?, ?, 1, 0, NOW())
            ");
            $stmt->bind_param("ss", $remark, $category);
            $stmt->execute();
            $_SESSION['status'] = "Calling remark added successfully.";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Remark already exists.";
            $_SESSION['status_code'] = "error";
        }
        $check->close();
    } else {
        $_SESSION['status'] = "All fields are required.";
        $_SESSION['status_code'] = "error";
    }
}

// ---------- DELETE REMARK ----------
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $con->query("
        UPDATE tbl_inquiry_calling_short_remarks 
        SET is_delete = 1 
        WHERE id = $id
    ");
    $_SESSION['status'] = "Remark deleted successfully.";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_redirect'] = "calling-remarks-manage.php";

}

// ---------- UPDATE REMARK ----------
if (isset($_POST['update_remark'])) {

    $id = intval($_POST['edit_id']);
    $remark = trim($_POST['remark']);
    $category = trim($_POST['category']);

    if ($remark !== '' && in_array($category, ['HOT', 'COLD', 'CLOSE'])) {

        $stmt = $con->prepare("
            UPDATE tbl_inquiry_calling_short_remarks
            SET remark = ?, category = ?, updated_at = NOW()
            WHERE id = ?
        ");
        $stmt->bind_param("ssi", $remark, $category, $id);
        $stmt->execute();

        $_SESSION['status'] = "Calling remark updated successfully.";
        $_SESSION['status_code'] = "success";

        header("Location: calling-remarks.php");
        exit;
    } else {
        $_SESSION['status'] = "All fields are required.";
        $_SESSION['status_code'] = "error";
    }
}

// ---------- FETCH REMARKS ----------
$result = $con->query("
    SELECT * FROM tbl_inquiry_calling_short_remarks
    WHERE is_delete = 0
    ORDER BY id DESC
");
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
                                <h4>Manage Calling Remarks</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Manage Calling Remarks</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <form method="POST">

                        <input type="hidden" name="edit_id" value="<?= $edit_id; ?>">

                        <div class="row">

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Calling Remark <span class="text-danger">*</span></label>
                                    <input type="text" name="remark" class="form-control"
                                        value="<?= htmlspecialchars($edit_remark); ?>"
                                        placeholder="Enter calling remark" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Category <span class="text-danger">*</span></label>
                                    <select name="category" class="form-control" required>
                                        <option value="">Select Category</option>
                                        <option value="HOT" <?= $edit_category == 'HOT' ? 'selected' : ''; ?>>HOT</option>
                                        <option value="COLD" <?= $edit_category == 'COLD' ? 'selected' : ''; ?>>COLD
                                        </option>
                                        <option value="CLOSE" <?= $edit_category == 'CLOSE' ? 'selected' : ''; ?>>CLOSE
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="form-group text-right">
                            <?php if ($edit_id > 0) { ?>
                                <button type="submit" name="update_remark" class="btn btn-warning">
                                    <i class="fa fa-edit"></i> Update Remark
                                </button>
                                <a href="calling-remarks-manage.php" class="btn btn-secondary">Cancel</a>
                            <?php } else { ?>
                                <button type="submit" name="save_remark" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save Remark
                                </button>
                            <?php } ?>
                        </div>

                    </form>

                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                    <h5 class="mb-3">Calling Remarks List</h5>

                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-striped">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Remark</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0) {
                                    $i = 1; ?>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= htmlspecialchars($row['remark']); ?></td>
                                            <td>
                                                <span class="badge badge-<?=
                                                    $row['category'] == 'HOT' ? 'danger' :
                                                    ($row['category'] == 'COLD' ? 'info' : 'success');
                                                ?>">
                                                    <?= $row['category']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="?edit_id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a href="?delete_id=<?= $row['id']; ?>" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            No remarks found
                                        </td>
                                    </tr>
                                <?php } ?>
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
            var table = $('.data-table').DataTable({
                "dom": 'Blfrtip',
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('.dataTableLoad_wrapper .col-md-6:eq(0)');
        });
    </script>
</body>

</html>