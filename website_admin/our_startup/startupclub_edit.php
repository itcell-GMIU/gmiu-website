<?php
include '../include/checklogin.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing data for the given ID
    $stmt = $con->prepare("SELECT heading_name, pdf_path FROM tbl_startup_club WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        $_SESSION['status'] = "Record not found.";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='startupclub_view.php'},1000);</script>";
        exit;
    }

    // Handle form submission
    if (isset($_POST['submit'])) {
        $heading_name = $_POST['heading_name'];
        $pdf = $_FILES['pdf'];
        $pdfPath = $row['pdf_path']; // Default to existing path

        // Validate inputs
        if (!empty($heading_name)) {
            // Handle file upload if a new file is provided
            if (!empty($pdf['name'])) {
                $targetDir = "../uploads/startup_club/";
                $newPdfPath = $targetDir . basename($pdf['name']);
                $pdfFileType = strtolower(pathinfo($newPdfPath, PATHINFO_EXTENSION));

                if ($pdfFileType != "pdf") {
                    $_SESSION['status'] = "Only PDF files are allowed.";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='startupclub_edit.php?id=$id'},1000);</script>";
                    exit;
                }

                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                // Move the uploaded file to the target directory
                if (move_uploaded_file($pdf['tmp_name'], $newPdfPath)) {
                    // Delete old file if a new one is uploaded
                    if (file_exists($pdfPath)) {
                        unlink($pdfPath);
                    }
                    $pdfPath = $newPdfPath; // Update the path to the new file
                } else {
                    $_SESSION['status'] = "Failed to upload the new file.";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='startupclub_edit.php?id=$id'},1000);</script>";
                    exit;
                }
            }

            // Update the database record
            $updateStmt = $con->prepare("UPDATE tbl_startup_club SET heading_name = ?, pdf_path = ? WHERE id = ?");
            $updateStmt->bind_param("ssi", $heading_name, $pdfPath, $id);

            if ($updateStmt->execute()) {
                $_SESSION['status'] = "Record updated successfully.";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Failed to update the record.";
                $_SESSION['status_code'] = "error";
            }

            echo "<script>setTimeout(function(){window.location='startupclub_view.php'},1000);</script>";
            exit;
        } else {
            $_SESSION['status'] = "Please fill in the heading.";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='startupclub_edit.php?id=$id'},1000);</script>";
            exit;
        }
    }
} else {
    $_SESSION['status'] = "Invalid request.";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='startupclub_view.php'},1000);</script>";
    exit;
}
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
                            <h1 class="m-0">Edit Startup Club</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Startup Club</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Form to edit Startup Club -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Startup Club</h3>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="heading_name">Heading Name</label>
                                    <input type="text" name="heading_name" class="form-control" id="heading_name" value="<?php echo htmlspecialchars($row['heading_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="pdf">Upload PDF (Single File Allowed)<span style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="pdf" name="pdf" accept="application/pdf">
                                            <label class="custom-file-label" for="pdf">Choose file</label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Current File: <?php echo basename($row['pdf_path']); ?></small>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                <a href="startupclub_view.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
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
