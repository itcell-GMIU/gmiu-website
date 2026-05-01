<?php
// Include the checklogin.php file
include '../include/checklogin.php';
if (isset($_POST['upload_csv'])) {
    $assign_staff_id = $_SESSION['staff_id'];
    $userIP = $_SERVER['REMOTE_ADDR'];

    if ($_FILES['csv_file']['error'] == 0) {
        $file = fopen($_FILES['csv_file']['tmp_name'], "r");
        $row = 0;

        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $row++;
            if ($row == 1) continue; // Skip header

            $startingNumeric = intval($data[0]);
            $endingNumeric = intval($data[1]);
            $staff_id = trim($data[2]);

            // Check if any inquiry already has staff assigned
            $check = $con->prepare("SELECT COUNT(*) AS assigned FROM `tbl_inquiry_student` WHERE staff_id IS NOT NULL AND CAST(SUBSTRING(inq_student_id, 4) AS UNSIGNED) BETWEEN ? AND ?");
            $check->bind_param("ii", $startingNumeric, $endingNumeric);
            $check->execute();
            $result = $check->get_result();
            $rowCheck = $result->fetch_assoc();

            if ($rowCheck['assigned'] == 0) {
                // Assign staff
                $stmt = $con->prepare("UPDATE tbl_inquiry_student SET staff_id = ?, assign_by = ?, ip_address_column = ? WHERE CAST(SUBSTRING(inq_student_id, 4) AS UNSIGNED) BETWEEN ? AND ?");
                $stmt->bind_param("sisii", $staff_id, $assign_staff_id, $userIP, $startingNumeric, $endingNumeric);
                $resultUpdate = $stmt->execute();

                if ($resultUpdate) {
                    $totalId = $endingNumeric - $startingNumeric;
                    $startingInquiryId = 'INQ' . str_pad($startingNumeric, 5, '0', STR_PAD_LEFT);
                    $endingInquiryId = 'INQ' . str_pad($endingNumeric, 5, '0', STR_PAD_LEFT);

                    $insertLog = $con->prepare("INSERT INTO tbl_faculty_assign_log (assign_by, staff_id, starting_id, ending_id, total) VALUES (?, ?, ?, ?, ?)");
                    $insertLog->bind_param("isssi", $assign_staff_id, $staff_id, $startingInquiryId, $endingInquiryId, $totalId);
                    $insertLog->execute();
                }
            } else {
                // If the inquiry is already assigned, add it to skipped array
                for ($i = $startingNumeric; $i <= $endingNumeric; $i++) {
                    $inqNumber = 'INQ' . str_pad($i, 5, '0', STR_PAD_LEFT); // Generate the inquiry number
                    $skippedInquiries[] = $inqNumber; // Add to skipped inquiries
                }
                continue;
            }
        }

        fclose($file);
        // Show skipped inquiry numbers if any
        if (!empty($skippedInquiries)) {
            $_SESSION['status'] = "Skipped Inquiry Numbers: " . implode(', ', $skippedInquiries);
            $_SESSION['status_code'] = "warning";  // You can change this to 'info' or 'error' as needed
        } else {
            $_SESSION['status'] = "CSV Processing Completed";
            $_SESSION['status_code'] = "success";
        }
    } else {
        $_SESSION['status'] = "CSV Upload Failed";
        $_SESSION['status_code'] = "error";
    }

    echo "<script>setTimeout(function(){window.location='#'},1000);</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <div class="wrapper">

        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Import Student Assign in Software</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Import Student Assign in Software</li>
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
                                <div class="card-header h-100">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h3 class="card-title h-100 mt-1">Import Student Assign</h3>
                                        </div>
                                        <div class="col-sm-9 text-right">
                                            <a class="btn btn-dark p-1" href="demo_inquiry_student_csv.csv" download="demo_inquiry_student_csv.csv">
                                                <i class="fa fa-download"></i> Download Sample csv
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <form method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="csv_file">Upload CSV<span style="color: red;">*</span></label>
                                            <input type="file" name="csv_file" class="form-control h-100" id="csv_file" accept=".csv" required>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" name="upload_csv" class="btn btn-primary">Import</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <?php include '../include/importjs.php'; ?>
</body>

</html>