<?php
include './include/config.php';

// ---------- EDIT MODE ----------
$edit_id = 0;
$edit_conversation = '';
$edit_category = '';

if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);

    $stmt = $con->prepare("
        SELECT conversation, category
        FROM tbl_inquiry_calling_conversations
        WHERE id = ? AND is_delete = 0
    ");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $stmt->bind_result($edit_conversation, $edit_category);
    $stmt->fetch();
    $stmt->close();
}

// ---------- UPDATE ----------
if (isset($_POST['update_conversation'])) {

    $id = intval($_POST['edit_id']);
    $conversation = trim($_POST['conversation']);
    $category = trim($_POST['category']);

    if ($conversation !== '' && in_array($category, ['HOT', 'COLD', 'CLOSE'])) {

        $stmt = $con->prepare("
            UPDATE tbl_inquiry_calling_conversations
            SET conversation = ?, category = ?, updated_at = NOW()
            WHERE id = ?
        ");
        $stmt->bind_param("ssi", $conversation, $category, $id);
        $stmt->execute();

        $_SESSION['status'] = "Conversation updated successfully.";
        $_SESSION['status_code'] = "success";

        header("Location: calling-conversations.php");
        exit;
    }
}

// ---------- ADD ----------
if (isset($_POST['save_conversation'])) {

    $conversation = trim($_POST['conversation']);
    $category = trim($_POST['category']);

    if ($conversation !== '' && in_array($category, ['HOT', 'COLD', 'CLOSE'])) {

        $stmt = $con->prepare("
            INSERT INTO tbl_inquiry_calling_conversations
            (conversation, category, is_active, is_delete, created_at)
            VALUES (?, ?, 1, 0, NOW())
        ");
        $stmt->bind_param("ss", $conversation, $category);
        $stmt->execute();

        $_SESSION['status'] = "Conversation added successfully.";
        $_SESSION['status_code'] = "success";
    }
}

// ---------- DELETE ----------
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $con->query("
        UPDATE tbl_inquiry_calling_conversations
        SET is_delete = 1
        WHERE id = $id
    ");

    $_SESSION['status'] = "Conversation deleted successfully.";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_redirect'] = "calling-conversation-manage.php";
}

// ---------- FETCH ----------
$result = $con->query("
    SELECT * FROM tbl_inquiry_calling_conversations
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
                                <h4>Manage Conversation Remarks</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Manage Conversation Remarks
                                    </li>
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
                                    <label>Conversation <span class="text-danger">*</span></label>
                                    <input type="text" name="conversation" class="form-control"
                                        value="<?= htmlspecialchars($edit_conversation); ?>"
                                        placeholder="Enter conversation" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Category <span class="text-danger">*</span></label>
                                    <select name="category" class="form-control" required>
                                        <option value="">Select</option>
                                        <option value="HOT" <?= $edit_category == 'HOT' ? 'selected' : ''; ?>>HOT</option>
                                        <option value="COLD" <?= $edit_category == 'COLD' ? 'selected' : ''; ?>>COLD
                                        </option>
                                        <option value="CLOSE" <?= $edit_category == 'CLOSE' ? 'selected' : ''; ?>>CLOSE
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="text-right">
                            <?php if ($edit_id > 0) { ?>
                                <button type="submit" name="update_conversation" class="btn btn-warning">
                                    <i class="fa fa-edit"></i> Update Conversation
                                </button>
                                <a href="calling-conversations.php" class="btn btn-secondary">Cancel</a>
                            <?php } else { ?>
                                <button type="submit" name="save_conversation" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save Conversation
                                </button>
                            <?php } ?>
                        </div>

                    </form>
                </div>
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                    <h5 class="mb-3">Calling Conversations List</h5>

                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-striped">

                            <thead class="bg-light">
                                <tr>
                                    <th style="width:5%">#</th>
                                    <th style="width:55%">Conversation</th>
                                    <th style="width:20%">Category</th>
                                    <th style="width:20%">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if ($result->num_rows > 0) {
                                    $i = 1; ?>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td>
                                                <?= $i++; ?>
                                            </td>

                                            <td class="text-wrap-ellipsis"
                                                title="<?= htmlspecialchars($row['conversation']); ?>">
                                                <?= htmlspecialchars($row['conversation']); ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?=
                                                    $row['category'] == 'HOT' ? 'danger' :
                                                    ($row['category'] == 'COLD' ? 'info' : 'success');
                                                ?>">
                                                    <?= $row['category']; ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="?edit_id=<?= $row['id']; ?>" class="btn btn-warning">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="?delete_id=<?= $row['id']; ?>" class="btn btn-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No conversations found</td>
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