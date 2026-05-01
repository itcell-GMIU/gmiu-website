<?php
// Include the checklogin.php file
include '../include/checklogin.php';
include('../smtp/PHPMailerAutoload.php');
// Initialize error and success messages
$error_message = '';
$success_message = '';
// Check if the file is uploaded or preview is requested
if (isset($_POST["preview"])) {
    // Process the CSV file for preview
    if (!empty($_FILES["file"]["tmp_name"])) {
        $filename = $_FILES["file"]["tmp_name"];
        // Store the file in a session so it can be reused during final import
        $_SESSION['uploaded_file'] = base64_encode(file_get_contents($filename)); // Storing the CSV content in session
    } elseif (isset($_SESSION['uploaded_file'])) {
        // Reuse the uploaded file content from the session
        $filename = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($filename, base64_decode($_SESSION['uploaded_file'])); // Decode and create a temp file
    }
    if (file_exists($filename)) {
        $file = fopen($filename, "r");
        $csvData = [];
        $skipFirstRow = true;
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
            if ($skipFirstRow) {
                $skipFirstRow = false;
                continue;
            }
            $csvData[] = $getData;  // Store CSV data in an array for preview
        }
        fclose($file);
        // Check for duplicate names in the preview
        $duplicateNames = [];
        foreach ($csvData as $row) {
            $firstName = $row[0];
            $middleName = $row[1];
            $lastName = $row[2];

            if ($firstName === $middleName && $firstName === $lastName) {
                $duplicateNames[] = "$firstName $middleName $lastName";
            }
        }
        // Set error message if duplicates are found
        if (!empty($duplicateNames)) {
            $error_message = "Error: The following names are duplicates and will not be imported: " . implode(", ", array_unique($duplicateNames));
        }
    }
    $_SESSION['otp'] = rand(100000, 999999); // Generate a 6-digit OTP
    // Send OTP via email
    $mail = new PHPMailer();
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'admissions@gmiu.edu.in'; // Your email address
        $mail->Password = 'uhna gbjn dtee tsfy'; // Your email password
        $mail->SMTPSecure = 'tls'; // Encryption to use (ssl/tls)
        $mail->Port = 587; // TCP port to connect to
        $mail->setFrom('admissions@gmiu.edu.in', 'ADMISSIONS GMIU'); // Your email address and name
        $mail->addAddress('ckgohel@gmiu.edu.in'); // Recipient email address (to whom you want to send OTP)   
        $mail->isHTML(true);
        $mail->Subject = 'OTP for CSV Import';
        $mail->Body = 'Your OTP for CSV import is: ' . $_SESSION['otp'];
        $mail->send();
        // echo 'OTP sent successfully!';
    } catch (Exception $e) {
        $error_message = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo; // Display detailed error
    }
}

// Final submit after checkbox confirmation
if (isset($_POST["final_import"]) && isset($_POST['confirm'])) {
    // Verify the OTP
    if (isset($_POST['otp']) && $_POST['otp'] == $_SESSION['otp']) {
        // Reuse the file content from the session
        $filename = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($filename, base64_decode($_SESSION['uploaded_file'])); // Decode and recreate the file
        $duplicatesFound = [];
        if (file_exists($filename)) {
            $file = fopen($filename, "r");
            $skipFirstRow = true;
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($skipFirstRow) {
                    $skipFirstRow = false;
                    continue;
                }
                $firstName = $getData[0];
                $middleName = $getData[1];
                $lastName = $getData[2];
                // Check for duplicate names in the database
                $checkStmt = $con->prepare("SELECT COUNT(*) FROM tbl_inquiry_student WHERE first_name = ? AND middle_name = ? AND last_name = ?");
                $checkStmt->bind_param("sss", $firstName, $middleName, $lastName);
                $checkStmt->execute();
                $checkStmt->bind_result($count);
                $checkStmt->fetch();
                $checkStmt->close();
                if ($count > 0) {
                    $duplicatesFound[] = "$firstName $middleName $lastName"; // Collect duplicate names
                    continue; // Skip this row
                }
                // Generate inquiry ID
                $cmd = $con->prepare("SELECT COUNT(*) FROM tbl_inquiry_student ");
                $cmd->execute();
                $result = $cmd->get_result();
                $row = $result->fetch_row();
                $inq_student_id = $row[0] + 1;
                $inq_student_id_padded = str_pad($inq_student_id, 3, '0', STR_PAD_LEFT);
                $inq_student_id_final = "INQ" . "$inq_student_id_padded";
                // Get data from CSV
                $gender = $getData[3];
                $mobile_number = $getData[4];
                $second_mobile_number = $getData[5];
                $email = $getData[6];
                $last_exam = $getData[7];
                $last_school_name = $getData[8];
                $is_online = 0;
                // Insert new student record
                $stmt = $con->prepare("INSERT INTO `tbl_inquiry_student`(`inq_student_id`, `first_name`, `middle_name`, `last_name`, `gender`, `mobile_number`, `mobile_number2`, `email`, `last_exam`, `is_online`,`last_school_name`, created_by) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("ssssssssiisi", $inq_student_id_final, $firstName, $middleName, $lastName, $gender,  $mobile_number, $second_mobile_number, $email, $last_exam, $is_online,$last_school_name, $staff_id);
                $stmt->execute();
            }
            fclose($file);
            unset($_SESSION['uploaded_file']); // Clear the session after final import
            // Prepare error message for duplicates
            if (!empty($duplicatesFound)) {
                $error_message = "Error: The following names were duplicates and were not imported: " . implode(", ", array_unique($duplicatesFound));
            } else {
                $success_message = "Imported Successfully";
            }
        }
    } else {
        $error_message = "Error: Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            position: relative;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .alert .close {
            position: absolute;
            top: 10px;
            right: 15px;
            border: none;
            background: none;
            font-size: 1.5rem;
            color: inherit;
        }

        .alert strong {
            font-weight: bold;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <div class="wrapper">
        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Import Student in Software</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Import Student in Software</li>
                            </ol>
                        </div><!-- /.col -->
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Single Card for the Entire Section -->
                            <div class="card card-gmiu">
                                <div class="card-header h-100">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h3 class="card-title h-100 mt-1">Import Student</h3>
                                        </div>
                                        <div class="col-sm-9 text-right">
                                            <a class="btn btn-dark p-1" href="demo_inquiry_student_csv.csv" download="demo_inquiry_student_csv.csv"><i class="fa fa-download"></i> Download Sample csv</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Display Success or Error Messages -->
                                <?php if ($success_message) : ?>
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                                        <strong><?php echo $success_message; ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if ($error_message) : ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                                        <strong><?php echo $error_message; ?></strong>
                                    </div>
                                <?php endif; ?>

                                <!-- Upload Form -->
                                <form method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Upload CSV<span style="color: red;">*</span></label>
                                            <input type="file" name="file" class="form-control h-100" id="file" accept=".csv" required>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" name="preview" class="btn btn-primary">Preview</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Preview Section -->
                            <?php if (isset($_SESSION['uploaded_file']) && !empty($csvData)) : ?>
                                <form method="post">
                                    <h3>Preview of Uploaded CSV Data:</h3>
                                    <table class="table table-bordered mt-3">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Middle Name</th>
                                                <th>Last Name</th>
                                                <th>Gender</th>
                                                <th>Mobile Number</th>
                                                <th>Second Mobile Number</th>
                                                <th>Email</th>
                                                <th>Last Exam</th>
                                                <th>Last School Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Display the preview data
                                            foreach ($csvData as $row) {
                                                echo "<tr>";
                                                foreach ($row as $data) {
                                                    echo "<td>" . htmlspecialchars($data) . "</td>";
                                                }
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="card card-gmiu">
                                        <div class="card-body">
                                            <div class="form-check mt-4">
                                                <input type="checkbox" class="form-check-input" id="confirm" name="confirm" required>
                                                <label class="form-check-label" for="confirm">I confirm the above data is correct.</label>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="otp">Enter OTP:</label>
                                                <input type="text" class="form-control" name="otp" required>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" name="final_import" class="btn btn-success mt-2">Import Data</button>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Footer -->
        <?php include '../include/importfooter.php'; ?>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>

    <?php include '../include/importjs.php'; ?>
</body>

</html>