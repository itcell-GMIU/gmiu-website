<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// Include the database connection file
// include '../common/db_connect.php';

// Fetch roles from tbl_career_role
$roles_query = "SELECT id, name FROM tbl_career_role WHERE is_active = '1' ORDER BY name ASC";
$roles_result = mysqli_query($con, $roles_query);

if (isset($_POST['submit'])) {
    // Fetch data from HTML form
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $designation = mysqli_real_escape_string($con, $_POST['designation']);

    // Insert data into database
    $stmt = $con->prepare("INSERT INTO tbl_designation (role_id, name) VALUES (?, ?)");
    $stmt->bind_param("ss", $role, $designation);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = "Designation inserted successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='view_designation.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Insertion failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='insert_designation.php'},1000);</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>

    <div class="wrapper">

        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">

            <!-- Page Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Designation</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Designation</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">Add Designation</h3>
                                </div>

                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="role">Select Role<span style="color: red;"> *</span></label>
                                            <select name="role" class="form-control" id="role" required>
                                                <option value="">-- Select Role --</option>
                                                <?php
                                                while ($row = mysqli_fetch_assoc($roles_result)) {
                                                    echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="designation">Designation Title<span style="color: red;"> *</span></label>
                                            <input type="text" name="designation" class="form-control" id="designation" placeholder="Enter designation title" required>
                                        </div>

                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
