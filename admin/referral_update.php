<?php
include 'include/checklogin.php';

$id = intval($_GET['id']);

// Fetch existing data
$stmt = $con->prepare("
    SELECT r.id, r.referral_code, r.name, r.role_id, r.contact, r.email, rr.role_name
    FROM tbl_referral_master r
    JOIN tbl_referral_role rr ON r.role_id = rr.role_id
    WHERE r.id = ? AND r.is_delete = 0
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$referral = $result->fetch_assoc();

if (!$referral) {
    $_SESSION['status'] = "Referral not found";
    $_SESSION['status_code'] = "error";
    header("Location: view_refferal_code.php");
    exit;
}

if (isset($_POST['update'])) {
    $name    = mysqli_real_escape_string($con, $_POST['name']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $email   = mysqli_real_escape_string($con, $_POST['email']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = "Invalid Email Format";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='referral_update.php?id=$id'},1000)</script>";
        exit;
    }

    // Check duplicate email
    $emailcheck = $con->prepare("SELECT id FROM tbl_referral_master WHERE email = ? AND id != ? AND is_delete=0");
    $emailcheck->bind_param("si", $email, $id);
    $emailcheck->execute();
    $emailres = $emailcheck->get_result();

    // Check duplicate contact
    $contactcheck = $con->prepare("SELECT id FROM tbl_referral_master WHERE contact = ? AND id != ? AND is_delete=0");
    $contactcheck->bind_param("si", $contact, $id);
    $contactcheck->execute();
    $contactres = $contactcheck->get_result();

    if ($emailres->num_rows > 0) {
        $_SESSION['status'] = "Email already exists";
        $_SESSION['status_code'] = "error";
    } elseif ($contactres->num_rows > 0) {
        $_SESSION['status'] = "Contact already exists";
        $_SESSION['status_code'] = "error";
    } else {
        // Update query (role_id and referral_code not touched)
        $update_stmt = $con->prepare("UPDATE tbl_referral_master SET name=?, contact=?, email=? WHERE id=?");
        $update_stmt->bind_param("sssi", $name, $contact, $email, $id);

        if ($update_stmt->execute()) {
            $_SESSION['status'] = "Referral Updated Successfully";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Update Failed";
            $_SESSION['status_code'] = "error";
        }
    }

    echo "<script>setTimeout(function(){window.location='view_refferal_code.php'},1000)</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include 'include/importnav.php'; ?>
        <?php include 'include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit Referral</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="view_refferal_code.php">Referral List</a></li>
                                <li class="breadcrumb-item active">Edit Referral</li>
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
                                    <h3 class="card-title">Update Referral</h3>
                                </div>
                                <form method="POST">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Referral Code</label>
                                            <input type="text" class="form-control" value="<?php echo $referral['referral_code']; ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Name<span style="color:red;"> *</span></label>
                                            <input type="text" name="name" class="form-control" value="<?php echo $referral['name']; ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Role</label>
                                            <input type="text" class="form-control" value="<?php echo $referral['role_name']; ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Contact<span style="color:red;"> *</span></label>
                                            <input type="text" name="contact" class="form-control" value="<?php echo $referral['contact']; ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Email<span style="color:red;"> *</span></label>
                                            <input type="email" name="email" class="form-control" value="<?php echo $referral['email']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                                        <a href="view_refferal_code.php" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include 'include/importfooter.php'; ?>
    <?php include 'include/importjs.php'; ?>
</body>

</html>