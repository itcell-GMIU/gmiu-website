<?php
include './include/config.php';

// Assuming $staff_id is available from the session or a previous include
// For the purpose of this example, I'll set a dummy value if it's not defined

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

            /**
             * Map inquiry options to codes
             */
            $inqTypeMap = [
                1 => "WB",   // Website
                2 => "WA",   // Whatsapp
                3 => "OT",   // Other
                4 => "WI",   // Walk In
                5 => "EM"    // E-Mail
            ];

            // Inputs from form
            $lastExam = (int) $_POST['last_exam'];
            $isOnline = (int) $_POST['is_online'];

            // Date component for the ID (DDMMYY)
            $ddmmyy = date("dmy");


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
            $expectedCount = count($expectedHeaders); // Store the expected count once

            // Validate header row
            $header = fgetcsv($handle);
            if ($header === false || array_map('trim', $header) !== $expectedHeaders) {
                $message = "<div class='alert alert-danger'>Error: CSV format is invalid. Please use the correct template.</div>";
            } else {
                $rejectedRows = [];
                $mobileNumbersInserted = []; // Track mobile numbers in the batch
                $emailsInserted = [];        // Track emails in the batch
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
                 * STEP 2: Process rows normally (<= 50 only)
                 * ------------------------------------------- */
                if ($stopProcessing) {
                    // Stop CSV import but allow HTML to display the message
                } else {

                    // Pre-calculate the starting serial number for the batch 
                    $stmt = $con->prepare("SELECT COUNT(*) AS total 
                                            FROM tbl_inquiry_student 
                                            WHERE is_online = ? AND last_exam = ?");
                    $stmt->bind_param("ii", $isOnline, $lastExam);
                    $stmt->execute();
                    $countRes = $stmt->get_result()->fetch_assoc();
                    $baseSerial = (int) $countRes['total'];
                    $currentSerial = $baseSerial;
                    $stmt->close(); // Close the count statement

                    while (($data = fgetcsv($handle)) !== false) {

                        $rowNumber++;

                        if (count(array_filter($data)) == 0) {
                            continue; // skip empty rows
                        }

                        // Check Column Count (FIX for array_combine error)
                        $dataCount = count($data);
                        if ($dataCount !== $expectedCount) {
                            // Pad or truncate the data array for consistent output in the rejection CSV
                            $rowToReject = array_pad($data, $expectedCount, '');

                            // Combine headers with the row to create the rejected array entry
                            $row = array_combine($expectedHeaders, array_slice($rowToReject, 0, $expectedCount));

                            $row['reason'] = "Invalid column count: Expected $expectedCount columns, found $dataCount. Row skipped.";
                            $rejectedRows[] = $row;
                            continue; // Skip processing this bad row
                        }

                        // Line 128: This line is now safe because $dataCount == $expectedCount
                        $row = array_combine($expectedHeaders, $data);

                        /** ------------------------------
                         * Validate required fields (second_mobile_number is now explicitly excluded)
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

                        /** ------------------------------
                         * Validate email (Required, Unique)
                         * ------------------------------ */
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

                        // Prevent duplicate emails (check DB and current batch)
                        $stmt = $con->prepare("SELECT COUNT(*) as cnt FROM tbl_inquiry_student WHERE email = ?");
                        $stmt->bind_param("s", $email);
                        $stmt->execute();
                        $resEmail = $stmt->get_result()->fetch_assoc();
                        $stmt->close();

                        if ($resEmail['cnt'] > 0 || in_array($email, $emailsInserted)) {
                            $row['reason'] = "Duplicate email address";
                            $rejectedRows[] = $row;
                            continue;
                        }

                        /** ------------------------------
                         * Validate Mobile Number for Uniqueness
                         * ------------------------------ */
                        $mobileNumber = trim($row['mobile_number']);
                        $secondMobileNumber = empty(trim($row['second_mobile_number'])) ? NULL : trim($row['second_mobile_number']);

                        // Check for existing mobile number in DB
                        $stmt = $con->prepare("SELECT COUNT(*) as cnt FROM tbl_inquiry_student WHERE mobile_number = ?");
                        $stmt->bind_param("s", $mobileNumber);
                        $stmt->execute();
                        $res = $stmt->get_result()->fetch_assoc();
                        $stmt->close();

                        // Check for existing mobile number in DB OR in the current batch
                        if ($res['cnt'] > 0 || in_array($mobileNumber, $mobileNumbersInserted)) {
                            $row['reason'] = "Duplicate mobile number";
                            $rejectedRows[] = $row;
                            continue;
                        }

                        // Increment serial number only for valid rows
                        $currentSerial++;

                        /** ------------------------------
                         * Generate unique inquiry ID
                         * ------------------------------ */
                        $examCode = isset($examMap[$lastExam]) ? $examMap[$lastExam] : "NA";
                        $inqCode = isset($inqTypeMap[$isOnline]) ? $inqTypeMap[$isOnline] : "NA";
                        $serial = str_pad($currentSerial, 5, "0", STR_PAD_LEFT);

                        // New ID format: <InqType>-<ExamCode>-<DDMMYY>-<SerialNo>
                        $inq_student_id = $inqCode . "-" . $examCode . "-" . $ddmmyy . "-" . $serial;

                        /** ------------------------------
                         * Insert student record
                         * ------------------------------ */
                        $stmt = $con->prepare("INSERT INTO tbl_inquiry_student 
                        (inq_student_id, first_name, middle_name, last_name, gender, mobile_number, mobile_number2, email, last_exam, is_online, created_by) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                        // 's' for string (inq_student_id, names, numbers, email), 'i' for integer (last_exam, is_online, created_by)
                        // Note: $secondMobileNumber is handled as NULL if empty string was passed.
                        $stmt->bind_param(
                            "ssssssssiii",
                            $inq_student_id,
                            $row['first_name'],
                            $row['middle_name'],
                            $row['last_name'],
                            $row['gender'],
                            $mobileNumber, // Use sanitized mobile number
                            $secondMobileNumber, // Use NULL or sanitized number
                            $email, // Use sanitized email
                            $lastExam,
                            $isOnline,
                            $staff_id
                        );

                        if ($stmt->execute()) {
                            // Track inserted mobile number and email
                            $mobileNumbersInserted[] = $mobileNumber;
                            $emailsInserted[] = $email;
                        } else {
                            $row['reason'] = "DB Insert Failed (" . $stmt->error . ")";
                            $rejectedRows[] = $row;
                            $currentSerial--; // Decrement if insert fails, so the serial is correct for the next row
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

                        <!-- Inquiry Type -->
                        <div class="form-group row">
                            <label for="inquiryType" class="col-sm-12 col-md-3 col-form-label">
                                Inquiry Type <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-12 col-md-6">
                                <select id="inquiryType" name="is_online" class="custom-select" required>
                                    <option value="">--- Select Type Of Inquiry ---</option>
                                    <!-- <option value="1">Website (WB)</option> -->
                                    <option value="2">Whatsapp (WA)</option>
                                    <option value="3">Other (OT)</option>
                                    <!-- <option value="4">Walk In (WI)</option> -->
                                    <option value="5">E-Mail (EM)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Last Exam -->
                        <div class="form-group row">
                            <label for="lastExam" class="col-sm-12 col-md-3 col-form-label">
                                Last Exam <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-12 col-md-6">
                                <select id="lastExam" name="last_exam" class="custom-select" required>
                                    <option value="">--- Select Last Exam ---</option>
                                    <option value="1">10th (10)</option>
                                    <option value="2">12th Commerce (12C)</option>
                                    <option value="3">12th Science (A Group) (12A)</option>
                                    <option value="4">12th Science (B Group) (12B)</option>
                                    <option value="5">12th Arts (12AR)</option>
                                    <option value="6">Under Graduate (UG)</option>
                                    <option value="7">Post Graduate (PG)</option>
                                    <option value="8">Diploma (D)</option>
                                    <option value="9">ITI</option>
                                    <option value="10">Diploma Pharmacy (DP)</option>
                                </select>
                            </div>
                        </div>

                        <!-- CSV Upload -->
                        <div class="form-group row">
                            <label for="csvFile" class="col-sm-12 col-md-3 col-form-label">
                                Upload CSV <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-12 col-md-6">
                                <input type="file" class="form-control-file" id="csvFile" name="csvFile" accept=".csv"
                                    required>
                                <small class="text-muted">Only .csv files are allowed</small>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group row mt-4">
                            <div class="col-md-9 text-right">
                                <button type="submit" class="btn btn-success px-4">
                                    Upload CSV
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>
</body>

</html>