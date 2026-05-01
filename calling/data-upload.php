<?php
include './include/config.php';

$message = "";
$downloadLink = "";
$stopProcessing = false;

// Handle CSV upload request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validate uploaded file
    if (!isset($_FILES['csvFile']) || $_FILES['csvFile']['error'] !== UPLOAD_ERR_OK) {
        $message = "<div class='alert alert-danger'>Error: Please upload a valid CSV file.</div>";
    } else {
        $fileTmp = $_FILES['csvFile']['tmp_name'];
        $handle = fopen($fileTmp, "r");

        if ($handle === false) {
            $message = "<div class='alert alert-danger'>Error opening the file.</div>";
        } else {
            /**
             * Map exam options to codes
             */
            $examMap = [
                1 => "10",     // 10th
                2 => "12C",    // 12th Commerce
                3 => "12A",    // 12th Science (A Group)
                4 => "12B",    // 12th Science (B Group)
                5 => "12AR",   // 12th Arts
                6 => "UG",     // Graduate
                7 => "PG",     // Post Graduate
                8 => "D",      // Diploma
                9 => "ITI",    // ITI
                10 => "DP",     // Diploma Pharmacy
            ];

            // Inputs from form
            $lastExam = (int) $_POST['last_exam'];
            $isOnline = 6; // fixed for CSV upload (as in your original code)
            $centerCode = strtoupper(trim($_POST['center_code'])); // only for ID generation, not DB

            // Define expected CSV headers
            $expectedHeaders = [
                "first_name",
                "middle_name",
                "last_name",
                "gender",
                "mobile_number",
                "second_mobile_number",
                "email",
                "last_school_name"
            ];

            // Validate header row
            $header = fgetcsv($handle);
            if ($header === false || array_map('trim', $header) !== $expectedHeaders) {
                $message = "<div class='alert alert-danger'>Error: CSV format is invalid. Please use the correct template.</div>";
            } else {
                $rejectedRows = [];
                $emailsInserted = [];
                $rowNumber = 1;

                /** STEP 1: Count rows first (limit 50) */
                $tempHandle = fopen($fileTmp, "r");
                fgetcsv($tempHandle); // skip header
                $rowCount = 0;

                while (($tempRow = fgetcsv($tempHandle)) !== false) {
                    if (count(array_filter($tempRow)) > 0) {  // ignore empty lines
                        $rowCount++;
                    }
                }
                fclose($tempHandle);

                // Reject if more than 50 rows
                if ($rowCount > 50) {
                    $message = "<div class='alert alert-danger'>
                                    CSV rejected! Maximum 50 rows allowed. Your file contains $rowCount rows.
                                </div>";
                    fclose($handle);
                    $stopProcessing = true;    // <-- stops further execution safely
                }


                /** -------------------------------------------
                 *  STEP 2: Process rows normally (≤ 50 only)
                 * ------------------------------------------- */
                if ($stopProcessing) {
                    // Stop CSV import but allow HTML to display the message
                } else {
                    while (($data = fgetcsv($handle)) !== false) {

                        $rowNumber++;

                        if (count(array_filter($data)) == 0) {
                            continue; // skip empty rows
                        }

                        $row = array_combine($expectedHeaders, $data);

                        /** ------------------------------
                         * Validate required fields
                         * We explicitly check if a required field is empty.
                         * NOTE: The original validation included `second_mobile_number` in the exclusion,
                         * but to ensure it's truly optional, we also handle empty string/null values for insertion later.
                         * ------------------------------ */
                        $missing = [];
                        foreach ($expectedHeaders as $field) {
                            // 'second_mobile_number' and 'email' are optional — email is auto-generated if empty
                            if ($field !== "second_mobile_number" && $field !== "email" && empty(trim($row[$field]))) {
                                $missing[] = $field;
                            }
                        }
                        if (!empty($missing)) {
                            $row['reason'] = "Missing required fields: " . implode(", ", $missing);
                            $rejectedRows[] = $row;
                            continue;
                        }

                        // Prepare second mobile number for insert (convert empty string to NULL)
                        $secondMobileNumber = empty(trim($row['second_mobile_number'])) ? NULL : trim($row['second_mobile_number']);

                        /** ------------------------------
                         * Validate email (Required, Unique)
                         * ------------------------------ */
                        // Process email: generate dummy if missing, otherwise validate format
                        $email = strtolower(trim($row['email']));
                        if (empty($email)) {
                            // Generate dummy email using format: firstname.ddmm.mobilenumber.row.random6@dummy.local
                            $datePart = date('dm');
                            $randPart = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);
                            $email = strtolower($row['first_name']) . ".{$datePart}." . $row['mobile_number'] . ".{$rowNumber}.{$randPart}@dummy.local";
                        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $row['reason'] = "Invalid email format";
                            $rejectedRows[] = $row;
                            continue;
                        }



                        // Prevent duplicate emails
                        $stmt = $con->prepare("SELECT COUNT(*) as cnt FROM tbl_inquiry_student WHERE email = ?");
                        $stmt->bind_param("s", $email);
                        $stmt->execute();
                        $res = $stmt->get_result()->fetch_assoc();
                        $stmt->close(); // Close statement used for count

                        if ($res['cnt'] > 0 || in_array($email, $emailsInserted)) {
                            $row['reason'] = "Duplicate email";
                            $rejectedRows[] = $row;
                            continue;
                        }

                        /** ------------------------------
                         * Generate unique inquiry ID
                         * Format: CD-<ExamCode>-<CenterCode>-<Serial>
                         * ------------------------------ */
                        $examCode = isset($examMap[$lastExam]) ? $examMap[$lastExam] : "NA";

                        // Count existing records only for this exam & is_online = 6
                        $stmt = $con->prepare("SELECT COUNT(*) as total 
                        FROM tbl_inquiry_student 
                        WHERE is_online = ? AND last_exam = ?");
                        $stmt->bind_param("ii", $isOnline, $lastExam);
                        $stmt->execute();
                        $countRes = $stmt->get_result()->fetch_assoc();
                        $stmt->close(); // Close statement used for count

                        $serial = str_pad(((int) $countRes['total']) + 1, 5, "0", STR_PAD_LEFT);

                        $inq_student_id = "CD-" . $examCode . "-" . $centerCode . "-" . $serial;

                        /** ------------------------------
                         * Insert student record
                         * ------------------------------ */
                        $stmt = $con->prepare("INSERT INTO tbl_inquiry_student 
                        (inq_student_id, first_name, middle_name, last_name, gender, mobile_number, mobile_number2, email, last_exam, is_online, created_by) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                        // Note: mobile_number2 needs to be handled carefully if you want to insert NULL. 
                        // If the database column allows NULL, using the prepared $secondMobileNumber variable works.
                        $stmt->bind_param(
                            "ssssssssiii",
                            $inq_student_id,
                            $row['first_name'],
                            $row['middle_name'],
                            $row['last_name'],
                            $row['gender'],
                            $row['mobile_number'],
                            $secondMobileNumber, // Use the potentially NULL value here
                            $email,
                            $lastExam,
                            $isOnline,
                            $staff_id
                        );

                        if ($stmt->execute()) {
                            $emailsInserted[] = $email;
                        } else {
                            $row['reason'] = "DB Insert Failed (" . $stmt->error . ")";
                            $rejectedRows[] = $row;
                        }
                        $stmt->close();
                    }

                    fclose($handle);

                    /** ------------------------------
                     * Handle rejected rows
                     * ------------------------------ */
                    if (!empty($rejectedRows)) {

                        $rejectDir = __DIR__ . '/rejected_csv';
                        $rejectUrl = 'rejected_csv';

                        // Create folder if not exists
                        if (!is_dir($rejectDir)) {
                            mkdir($rejectDir, 0777, true);
                        }

                        $rejectFileName = 'rejected_' . time() . '.csv';
                        $rejectFilePath = $rejectDir . '/' . $rejectFileName;

                        $fp = fopen($rejectFilePath, 'w');

                        fputcsv($fp, array_merge($expectedHeaders, ['reason']));

                        foreach ($rejectedRows as $r) {
                            fputcsv($fp, $r);
                        }

                        fclose($fp);

                        // Browser download link
                        $downloadLink = "<a href='{$rejectUrl}/{$rejectFileName}' class='btn btn-warning mt-2'>Download rejected CSV</a>";

                        $message = "<div class='alert alert-info'>Upload completed with some rejections.</div>";

                    } else {

                        $message = "<div class='alert alert-success'>Upload completed successfully with no rejections.</div>";
                    }

                }
            }
        }
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
                                <h4>Data Upload</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data Upload</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <div class="dropdown">
                                <a class="btn btn-primary" href="candidate-view.php">View</a>
                                <a class="btn btn-primary" href="demo_inquiry_student_csv.csv" download>Download Sample
                                    CSV</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="mb-20">Upload Data</h5>

                    <?php if (!empty($message))
                        echo $message; ?>
                    <?php if (!empty($downloadLink))
                        echo $downloadLink; ?>

                    <form action="" method="POST" enctype="multipart/form-data">

                        <!-- Last Exam Dropdown -->
                        <div class="form-group">
                            <label for="lastExam">Last Exam:</label>
                            <select id="lastExam" name="last_exam" class="custom-select col-12" required>
                                <option value="" selected>Choose...</option>
                                <!-- <option value="1">10th</option>
                                <option value="2">12th Commerce</option>
                                <option value="3">12th Science (A Group)</option>
                                <option value="4">12th Science (B Group)</option>
                                <option value="5">12th Arts</option>
                                <option value="6">Graduate</option>
                                <option value="7">Post Graduate</option> -->
                                <option value="1">10th</option>
                                <option value="2">12th Commerce</option>
                                <option value="3">12th Science (A Group)</option>
                                <option value="4">12th Science (B Group)</option>
                                <option value="5">12th Arts</option>
                                <option value="6">Under Graduate</option>
                                <option value="7">Post Graduate</option>
                                <option value="8">Diploma</option>
                                <option value="9">ITI</option>
                                <option value="10">Diploma Pharmacy</option>
                            </select>
                        </div>

                        <!-- Center Code Input -->
                        <div class="form-group">
                            <label for="centerCode">Center Code:</label>
                            <input type="text" id="centerCode" name="center_code" class="form-control"
                                placeholder="Enter Center Code (e.g., DT01)" required>
                        </div>

                        <!-- Inquiry Type (hidden) -->
                        <input type="text" name="is_online" value="6" hidden>

                        <!-- CSV File Upload -->
                        <div class="form-group mt-3">
                            <label for="csvFile">Upload CSV File:</label>
                            <input type="file" class="form-control-file" id="csvFile" name="csvFile" accept=".csv"
                                required>
                        </div>

                        <button type="submit" class="btn btn-success mt-4">Upload</button>
                    </form>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>
</body>

</html>