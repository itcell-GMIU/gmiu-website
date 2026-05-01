<?php
include 'include/checklogin.php';

$message = '';

if (isset($_POST['import']) && isset($_FILES['file']) && isset($_POST['role_id'])) {

    $role_id = intval($_POST['role_id']);
    $file = $_FILES['file']['tmp_name'];
    $created_by = $staff_id; // from session

    // 🔹 1. Get role_code
    $role_stmt = $con->prepare("SELECT role_code FROM tbl_referral_role WHERE role_id = ?");
    $role_stmt->bind_param("i", $role_id);
    $role_stmt->execute();
    $role_res = $role_stmt->get_result();
    $role_data = $role_res->fetch_assoc();
    $role_code = $role_data['role_code'];

    // 🔹 2. Get last referral_code for this role
    $last_stmt = $con->prepare("SELECT referral_code FROM tbl_referral_master WHERE role_id = ? ORDER BY id DESC LIMIT 1");
    $last_stmt->bind_param("i", $role_id);
    $last_stmt->execute();
    $last_res = $last_stmt->get_result();
    $last_code = ($last_res->num_rows > 0) ? $last_res->fetch_assoc()['referral_code'] : null;

    // 🔹 3. Extract last number or start fresh
    if ($last_code) {
        // Extract numeric part (assuming format YYYYXX### or similar)
        preg_match('/(\d+)$/', $last_code, $matches);
        $last_num = isset($matches[1]) ? intval($matches[1]) : 0;
    } else {
        $last_num = 0;
    }

    if (($handle = fopen($file, 'r')) !== false) {
        $row = 0;
        $inserted = 0;

        // Skip header row
        fgetcsv($handle);

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $row++;

            if ($inserted >= 50) {
                break; // ✅ Limit 50
            }

            $name = trim($data[0]);
            $contact = trim($data[1]);
            $email = trim($data[2]);

            // Skip empty rows
            if (!$name && !$contact && !$email) continue;

            // 🔹 4. Check duplicate email
            $check_email = $con->prepare("SELECT id FROM tbl_referral_master WHERE email = ? ");
            $check_email->bind_param("s", $email);
            $check_email->execute();
            if ($check_email->get_result()->num_rows > 0) continue; // skip duplicate

            // 🔹 5. Check duplicate contact
            $check_contact = $con->prepare("SELECT id FROM tbl_referral_master WHERE contact = ? ");
            $check_contact->bind_param("s", $contact);
            $check_contact->execute();
            if ($check_contact->get_result()->num_rows > 0) continue; // skip duplicate

            // 🔹 6. Generate new referral_code
            $last_num++;
            $new_num = str_pad($last_num, 3, "0", STR_PAD_LEFT);
            $referral_code = $role_code . $new_num;

            // 🔹 7. Insert
            $stmt = $con->prepare("
                INSERT INTO tbl_referral_master 
                (referral_code, name, role_id, contact, email, is_active, is_delete, created_by, created_at) 
                VALUES (?, ?, ?, ?, ?, 1, 0, ?, NOW())
            ");
            $stmt->bind_param("ssisss", $referral_code, $name, $role_id, $contact, $email, $created_by);

            if ($stmt->execute()) {
                $inserted++;
            }
        }

        fclose($handle);

        if ($inserted == 0) {
            $message = "No new rows inserted. (All rows may be duplicates or invalid)";
        } elseif ($inserted >= 50 && $row > 50) {
            $message = "Only 50 rows imported (limit reached). Extra rows ignored.";
        } else {
            $message = "$inserted rows imported successfully!";
        }
    } else {
        $message = "Error opening the CSV file.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">
        </div><!-- /.Preloader -->
    </div>
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Import Refferal Code CSV</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Import Refferal CSV</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-gmiu">
                                <div class="card-header h-100">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h3 class="card-title h-100 mt-1">Import Staff Member</h3>
                                        </div>
                                        <div class="col-sm-9 text-right">
                                            <a class="btn btn-dark p-1" href="demo_staff_csv.csv" download="demo_staff_csv.csv"><i class="fa fa-download"></i> Download Sample csv</a>
                                        </div>
                                    </div>
                                </div>
                                <?php if (!empty($message)) : ?>
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <?= htmlspecialchars($message) ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>

                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
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
                                            <label for="name">Upload CSV<span style="color: red;">*</span></label>
                                            <input type="file" name="file" class="form-control h-100" id="file" accept=".csv" required>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <input type="submit" name="import" value="Import" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (right) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php include 'include/importfooter.php'; ?>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php include 'include/importjs.php'; ?>
</body>

</html>