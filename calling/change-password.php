<?php
include './include/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Minimum length check
    if (strlen($new_password) < 6) {
        $_SESSION['status'] = "Password must be at least 6 characters long.";
        $_SESSION['status_code'] = "error";
        header("Location: change_password.php");
        exit;
    }

    // Fetch existing password
    $stmt = $con->prepare("SELECT password FROM tbl_staff WHERE id = ?");
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        $_SESSION['status'] = "User not found.";
        $_SESSION['status_code'] = "error";
        header("Location: change_password.php");
        exit;
    }

    $row = $result->fetch_assoc();

    /* ===========================
       YOUR ORIGINAL LOGIC (PLAIN TEXT)
       =========================== */

    if ($current_password == $row['password']) {

        if ($new_password == $confirm_password) {

            // Update password as PLAIN TEXT
            $updateStmt = $con->prepare(
                "UPDATE tbl_staff SET password = ? WHERE id = ?"
            );
            $updateStmt->bind_param("si", $new_password, $staff_id);

            if ($updateStmt->execute()) {
                $_SESSION['status'] = "Password Changed Successfully.";
                $_SESSION['status_code'] = "success";

            } else {
                $_SESSION['status'] = "Password Not Changed.";
                $_SESSION['status_code'] = "error";
            }

        } else {
            $_SESSION['status'] = "New Password and Confirm Password do not match.";
            $_SESSION['status_code'] = "error";
        }

    } else {
        $_SESSION['status'] = "Please enter correct current password.";
        $_SESSION['status_code'] = "error";
    }
}

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
                                <h4>Change Password</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="mb-3">Change Password</h5>

                    <form id="changePasswordForm" method="post">

                        <!-- Current Password -->
                        <div class="form-group mb-3">
                            <label for="current_password">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                placeholder="Enter current password" required>
                        </div>

                        <!-- New Password -->
                        <div class="form-group mb-3">
                            <label for="new_password">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                placeholder="Enter new password" minlength="6" required>
                            <small class="text-muted">Password must be at least 6 characters long</small>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group mb-4">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                placeholder="Re-enter new password" required>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary">
                            Update Password
                        </button>
                    </form>
                </div>

            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>

    <script>
        document.getElementById('changePasswordForm').addEventListener('submit', function (e) {
            const newPass = document.getElementById('new_password').value;
            const confirmPass = document.getElementById('confirm_password').value;

            if (newPass.length < 6) {
                alert('New password must be at least 6 characters long.');
                e.preventDefault();
                return;
            }

            if (newPass !== confirmPass) {
                alert('New password and confirm password do not match.');
                e.preventDefault();
            }
        });
    </script>

</body>

</html>