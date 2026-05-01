<?php
include 'include/checklogin.php';

if (isset($_POST['submit'])) {
    $sname       = mysqli_real_escape_string($con, $_POST['name']);
    $role_id    = intval($_POST['role_id']);
    $contact    = mysqli_real_escape_string($con, $_POST['contact']);
    $email      = mysqli_real_escape_string($con, $_POST['email']);
    $created_by = $staff_id; // from session

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = "Invalid Email Format";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='add_refferal_code.php'},1000)</script>";
       
    }

    // 🔹 Check duplicate email
    $check_email = $con->prepare("SELECT id FROM tbl_referral_master WHERE email = ? AND is_delete = 0");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $res_email = $check_email->get_result();
    if ($res_email->num_rows > 0) {
        $_SESSION['status'] = "Email already exists";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='add_refferal_code.php'},1000)</script>";
       
    }

    // 🔹 Check duplicate contact
    $check_contact = $con->prepare("SELECT id FROM tbl_referral_master WHERE contact = ? AND is_delete = 0");
    $check_contact->bind_param("s", $contact);
    $check_contact->execute();
    $res_contact = $check_contact->get_result();
    if ($res_contact->num_rows > 0) {
        $_SESSION['status'] = "Contact already exists";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='add_refferal_code.php'},1000)</script>";
       
    }

    // 1. Get role_code
    $role_stmt = $con->prepare("SELECT role_code FROM tbl_referral_role WHERE role_id = ?");
    $role_stmt->bind_param("i", $role_id);
    $role_stmt->execute();
    $role_res = $role_stmt->get_result();
    $role_data = $role_res->fetch_assoc();
    $role_code = $role_data['role_code'];

    // 2. Find last referral_code for this role
    $last_stmt = $con->prepare("SELECT referral_code FROM tbl_referral_master WHERE role_id = ? ORDER BY id DESC LIMIT 1");
    $last_stmt->bind_param("i", $role_id);
    $last_stmt->execute();
    $last_res = $last_stmt->get_result();
    $last_code = ($last_res->num_rows > 0) ? $last_res->fetch_assoc()['referral_code'] : null;

    // 3. Extract last number
    if ($last_code) {
        $last_num = intval(substr($last_code, strlen($role_code)));
        $new_num  = str_pad($last_num + 1, 3, "0", STR_PAD_LEFT);
    } else {
        $new_num = "001";
    }

    // 4. Generate new referral_code
    $referral_code = $role_code . $new_num;

    // 5. Insert
    $stmt = $con->prepare("INSERT INTO tbl_referral_master (referral_code, name, role_id, contact, email, created_by) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissi", $referral_code, $sname, $role_id, $contact, $email, $created_by);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Referral Added Successfully (Code: $referral_code)";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Referral Insertion Failed";
        $_SESSION['status_code'] = "error";
    }

    echo "<script>setTimeout(function(){window.location='add_refferal_code.php'},1000)</script>";
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
                            <h1 class="m-0">Add Referral</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Referral</li>
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
                                    <h3 class="card-title">Add Referral</h3>
                                </div>

                                <form method="POST">
                                    <div class="card-body">


                                        <div class="form-group">
                                            <label>Name<span style="color: red;"> *</span></label>
                                            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Role<span style="color: red;"> *</span></label>
                                            <select name="role_id" class="form-control" required>
                                                <option value="">--Select Role--</option>
                                                <?php
                                                $role_query = "SELECT role_id, role_name FROM tbl_referral_role WHERE is_active=1 AND is_delete=0";
                                                $roles = $con->query($role_query);
                                                while ($row = $roles->fetch_assoc()) {
                                                    echo "<option value='{$row['role_id']}'>{$row['role_name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Contact<span style="color: red;"> *</span></label>
                                            <input type="text" name="contact" class="form-control" placeholder="Enter Contact" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Email<span style="color: red;"> *</span></label>
                                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div> <!-- /.card -->
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