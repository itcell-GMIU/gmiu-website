<?php
include('include/config.php');

// Security Check: Only SUPER ADMIN or ADMIN can edit users
if (!isset($_SESSION['role_id']) || ($_SESSION['role_id'] != 1 && $_SESSION['role_id'] != 2)) {
    header("Location: index.php");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = '';
$message_type = '';

if ($id <= 0) {
    header("Location: user-list.php");
    exit();
}

// Handle Form Submission
if (isset($_POST['btn-update-user'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $role_id = (int)$_POST['role_id'];
    $is_active = (int)$_POST['is_active'];

    $update_sql = "UPDATE tbl_staff SET name = ?, email = ?, password = ?, role_id = ?, is_active = ?";
    $update_sql .= " WHERE id = ?";
    $stmt = $con->prepare($update_sql);
    $stmt->bind_param("sssiii", $name, $email, $password, $role_id, $is_active, $id);
    
    if ($stmt->execute()) {
        $message = "User updated successfully!";
        $message_type = "success";
    } else {
        $message = "Error updating user.";
        $message_type = "error";
    }
}

// Fetch User Data
$sql = "SELECT * FROM tbl_staff WHERE id = $id";
$res = $con->query($sql);
$user = $res ? $res->fetch_assoc() : null;

if (!$user) {
    header("Location: user-list.php");
    exit();
}

// Fetch Roles (Excluding Super Admin)
$roles_sql = "SELECT id, name FROM tbl_role WHERE is_delete = 0 AND id != 1";
$roles_result = $con->query($roles_sql);
$roles = $roles_result ? $roles_result->fetch_all(MYSQLI_ASSOC) : [];

?>

<!DOCTYPE html>
<html>
<head>
    <?php include('include/head.php'); ?>
    <title>Edit User | TADA Portal</title>
</head>
<body>
    <?php include('include/header.php'); ?>
    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="title">
                                <h4>Edit User</h4>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item"><a href="user-list.php">User List</a></li>
                                    <li class="breadcrumb-item active">Edit User</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-16 box-shadow mb-30" style="max-width: 600px; margin: 0 auto;">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label class="font-weight-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Password</label>
                            <input type="text" name="password" class="form-control" value="<?= htmlspecialchars($user['password']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Role</label>
                            <select name="role_id" class="form-control" required>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>" <?= $user['role_id'] == $role['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($role['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Status</label>
                            <select name="is_active" class="form-control">
                                <option value="1" <?= $user['is_active'] == 1 ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= $user['is_active'] == 0 ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" name="btn-update-user" class="btn btn-primary btn-block btn-lg">Update User Details</button>
                            <a href="user-list.php" class="btn btn-outline-secondary btn-block mt-2">Back to List</a>
                        </div>
                    </form>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>
    <?php if ($message): ?>
    <script>
        swal({
            title: "<?= $message ?>",
            icon: "<?= $message_type ?>",
        }).then(function() {
            <?php if($message_type == 'success'): ?>
            window.location.href = 'user-list.php';
            <?php endif; ?>
        });
    </script>
    <?php endif; ?>
</body>
</html>
