<?php
include '../include/checklogin.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current data for the given ID
    $stmt = $con->prepare("SELECT report_ename, company_name, location, date, report FROM tbl_event WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $report_ename = $row['report_ename'];
        $company_name = $row['company_name'];
        $location = $row['location'];
        $date = $row['date'];
        $report = $row['report'];
    } else {
        $_SESSION['status'] = "Event record not found.";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='event_list_view.php'},1000);</script>";
        exit;
    }
} else {
    $_SESSION['status'] = "Invalid request.";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='event_list_view.php'},1000);</script>";
    exit;
}

if (isset($_POST['submit'])) {
    $report_ename = $_POST['report_ename'];
    $company_name = $_POST['company_name'];
    $location = $_POST['location'];
    $date = date('Y-m-d', strtotime($_POST['date']));

    // Handle file upload
    $report = $_FILES['report']['name'];
    $report_tmp_name = $_FILES['report']['tmp_name'];
    $report_folder = '../uploads/reports/' . $report;

    if ($report) {
        move_uploaded_file($report_tmp_name, $report_folder);
    } else {
        $report = $row['report']; // If no new file is uploaded, retain the old file
    }

    // Update the record in the database
    $stmt = $con->prepare("UPDATE tbl_event SET report_ename = ?, company_name = ?, location = ?, date = ?, report = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $report_ename, $company_name, $location, $date, $report, $id);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Event report updated successfully.";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Failed to update the event report.";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000);</script>";
    }

    $stmt->close();
}

$con->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit Event Report</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Event Report</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Form start -->
                    <div class="card card-gmiu">
                        <div class="card-header">
                            <h3 class="card-title">Edit Event Report</h3>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="report_ename">Report Name<span style="color: red;">*</span></label>
                                    <input type="text" name="report_ename" class="form-control" id="report_ename" value="<?php echo htmlspecialchars($report_ename, ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="company_name">Company Name<span style="color: red;">*</span></label>
                                    <input type="text" name="company_name" class="form-control" id="company_name" value="<?php echo htmlspecialchars($company_name, ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="location">Location<span style="color: red;">*</span></label>
                                    <input type="text" name="location" class="form-control" id="location" value="<?php echo htmlspecialchars($location, ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="month">Date<span style="color: red;">*</span></label>
                                    <input type="date" name="date" class="form-control" id="date" value="<?php echo isset($date) ? date('Y-m-d', strtotime($date)) : ''; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="report">Report File<span style="color: red;">*</span></label>
                                    <input type="file" name="report" class="form-control" id="report" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt" required>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include '../include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include '../include/importjs.php'; ?>
</body>

</html>