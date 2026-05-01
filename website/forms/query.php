<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// =================================================================
// IMPORTS & CONFIGURATION
// =================================================================
include '../../common/importwebsitefile.php';
// date_default_timezone_set('Asia/Kolkata'); // set your timezone

// // Define cutoff time
// $cuttoff_start = strtotime('15:00:00');
// $cutoff_time = strtotime('16:30:00');
// $cutin_time = strtotime('18:45:00');
// $current_time = time();

// if ($current_time < $cutoff_time && $current_time > $cuttoff_start) {
//     echo "<h2 style='color:red; text-align:center; margin-top:50px;'>Not opened yet!, Will open after 4:30</h2>";
//     exit;
// }

// if ($current_time > $cutin_time) {
//     $sql_reject_pending = "UPDATE tbl_runtime_query SET status = 'rejected', updated_at = NOW() WHERE status = 'pending'";
//     if ($stmt_reject = $con->prepare($sql_reject_pending)) {
//         $stmt_reject->execute();
//         $stmt_reject->close();
//     }
//     echo "<h2 style='color:red; text-align:center; margin-top:50px;'>It is Closed Now.</h2>";
//     exit;
// }

if(1 === 1){
     echo "<h2 style='color:red; text-align:center; margin-top:50px;'>It is Closed Now.</h2>";
    exit;
}

// =================================================================
// FORM SUBMISSION HANDLING
// =================================================================

// --- Handle New Query Submission ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['application_submit'])) {

    // --- 0. DEFINE FILE SIZE LIMITS ---
    $max_image_size = 2 * 1024 * 1024; // 2 MB
    $max_pdf_size = 5 * 1024 * 1024; // 5 MB

    // --- 1. DUPLICATE ENTRY CHECK ---
    $enrollment_no_check = $_POST['enrollmentNumber'];
    $email_check = $_POST['email'];

    $sql_check = "SELECT id FROM tbl_runtime_query WHERE enrollment_no = ? OR email = ?";
    $stmt_check = $con->prepare($sql_check);
    $stmt_check->bind_param("ss", $enrollment_no_check, $email_check);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $stmt_check->close();
        $con->close();
        die_with_alert('error', 'Duplicate Entry', 'A query has already been submitted with this Email or Enrollment Number.');
    }
    $stmt_check->close();

    // --- 2. STUDENT IMAGE UPLOAD HANDLING ---
    $student_img_path = '';
    if (isset($_FILES["studentImage"]) && $_FILES["studentImage"]["error"] == UPLOAD_ERR_OK) {

        // Check file size
        if ($_FILES["studentImage"]["size"] > $max_image_size) {
            die_with_alert('error', 'File Too Large', 'The student photo must be under 2 MB.');
        }

        $target_dir_student = "./uploads/query_student/";
        if (!file_exists($target_dir_student)) {
            mkdir($target_dir_student, 0777, true);
        }

        $check = getimagesize($_FILES["studentImage"]["tmp_name"]);
        if ($check === false) {
            die_with_alert('error', 'Upload Failed', 'The student photo file is not a valid image.');
        }

        $file_extension = strtolower(pathinfo($_FILES["studentImage"]["name"], PATHINFO_EXTENSION));
        $unique_filename = uniqid('student_', true) . '.' . $file_extension;
        $target_file = $target_dir_student . $unique_filename;

        if (move_uploaded_file($_FILES["studentImage"]["tmp_name"], $target_file)) {
            $student_img_path = $unique_filename;
        } else {
            die_with_alert('error', 'Upload Failed', 'Could not move the student image. Check server permissions.');
        }
    } else {
        die_with_alert('error', 'File Missing', 'Student photo is required. An upload error occurred.');
    }


    // --- 3. ATTACHMENT FILE UPLOAD HANDLING ---
    $attachment_file_path = '';
    if (isset($_FILES["attachmentFile"]) && $_FILES["attachmentFile"]["error"] == UPLOAD_ERR_OK) {

        // Check file size
        if ($_FILES["attachmentFile"]["size"] > $max_pdf_size) {
            die_with_alert('error', 'File Too Large', 'The attachment PDF must be under 5 MB.');
        }

        $target_dir_docs = "./uploads/query/";
        if (!file_exists($target_dir_docs)) {
            mkdir($target_dir_docs, 0777, true);
        }

        $file_extension = pathinfo($_FILES["attachmentFile"]["name"], PATHINFO_EXTENSION);
        $unique_filename = uniqid('attachment_', true) . '.' . $file_extension;
        $target_file = $target_dir_docs . $unique_filename;

        if (move_uploaded_file($_FILES["attachmentFile"]["tmp_name"], $target_file)) {
            $attachment_file_path = $unique_filename;
        } else {
            die_with_alert('error', 'Upload Failed', 'Could not move the attachment file. Check server permissions.');
        }
    } else {
        die_with_alert('error', 'File Missing', 'The required attachment PDF was not uploaded or an error occurred.');
    }

    // --- 4. GENERATE UNIQUE gen_id ---
    $prefix = 'RASMAN';
    $sql_get_last_id = "SELECT gen_id FROM tbl_runtime_query ORDER BY id DESC LIMIT 1";
    $result_last_id = $con->query($sql_get_last_id);
    $new_id_num = 1;

    if ($result_last_id && $result_last_id->num_rows > 0) {
        $last_row = $result_last_id->fetch_assoc();
        $last_gen_id = $last_row['gen_id'];
        $last_id_num = (int) substr($last_gen_id, strlen($prefix));
        $new_id_num = $last_id_num + 1;
    }
    $gen_id = $prefix . str_pad($new_id_num, 3, '0', STR_PAD_LEFT);

    // --- 5. PREPARE DATA FOR INSERTION ---
    $student_name = $_POST['studentName'];
    $enrollment_no = $_POST['enrollmentNumber'];
    $email = $_POST['email'];
    $college = $_POST['college'];
    $branch = $_POST['branch'];
    $specialization = !empty($_POST['specialization']) ? $_POST['specialization'] : NULL;
    $sem = $_POST['semester'];
    $hod_name = $_POST['hodName'];
    $attachment_type = $_POST['attachmentType'];
    $query_text = $_POST['queryType'];
    if ($query_text === 'Other') {
        $query_text = !empty($_POST['otherQuery']) ? $_POST['otherQuery'] : 'Other';
    }

    // --- 6. DATABASE INSERTION ---
    $sql = "INSERT INTO tbl_runtime_query (gen_id, student_name, enrollment_no, email, college, branch, specialization, sem, hod_name, query, attachment_type, attachment_file, student_img) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssssisssss", $gen_id, $student_name, $enrollment_no, $email, $college, $branch, $specialization, $sem, $hod_name, $query_text, $attachment_type, $attachment_file_path, $student_img_path);

    if ($stmt->execute()) {
        $_SESSION['query_status'] = [
            'enrollmentNumber' => $enrollment_no,
            'email' => $email,
            'message' => 'Your query is in progress. Please wait until it is solved.',
            'created_at' => time()
        ];
        echo "
        <script>
            localStorage.setItem('queryUserEnrollmentNumber', '$enrollment_no');
            localStorage.setItem('queryUserEmail', '$email');
        </script>
        ";
        show_alert('success', 'Query Submitted!', 'Your query has been successfully submitted. We will get back to you soon.');
    } else {
        show_alert('error', 'Submission Failed', 'There was an error submitting your query. Error: ' . $stmt->error);
    }

    $stmt->close();
    $con->close();
}


// --- Handle Status Check Submission ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_query'])) {
    $checkEmail = $_POST['checkEmail'];
    $checkEnrollment = $_POST['checkEnrollment'];

    $_SESSION['query_status'] = [
        'enrollmentNumber' => $checkEnrollment,
        'email' => $checkEmail,
        'message' => 'Checking your query status...',
        'created_at' => time()
    ];

    echo "<script>window.location.href = 'query.php';</script>";
    exit();
}


// =================================================================
// HELPER FUNCTIONS
// =================================================================
function show_alert($icon, $title, $text)
{
    echo get_alert_html($icon, $title, $text, true);
}
function die_with_alert($icon, $title, $text)
{
    die(get_alert_html($icon, $title, $text, true));
}
function get_alert_html($icon, $title, $text, $redirect)
{
    $redirect_script = $redirect ? "window.location.href = 'query.php';" : "";
    return <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Submission Status</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: '{$icon}',
                title: '{$title}',
                text: '{$text}',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) { {$redirect_script} }
            });
        </script>
    </body>
    </html>
HTML;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Query Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --background-color: #f0f2f5;
            --card-background: #ffffff;
            --text-color: #495057;
            --border-color: #dee2e6;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .form-container {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .form-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            border-top: 5px solid var(--primary-color);
        }

        .card-header-custom {
            text-align: center;
            padding: 1.5rem 1rem;
        }

        .form-logo {
            width: auto;
            height: 60px;
            margin-bottom: 1rem;
        }

        .card-header-custom h2 {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.75rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
        }

        .form-control.rounded-0,
        .form-select.rounded-0 {
            border-radius: 0;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .btn-primary,
        .btn-secondary {
            border-radius: 8px;
            padding: 0.85rem;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
        }

        .btn-primary:hover {
            background: #0b5ed7;
        }

        .bg-custom-light {
            background-color: #ededed;
        }

        .btn-back {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 10;
        }

        @media (min-width: 768px) {
            .form-container {
                padding-top: 5rem;
                padding-bottom: 5rem;
            }

            .card-header-custom {
                padding: 2rem 1rem;
            }

            .form-logo {
                height: 80px;
            }

            .card-header-custom h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<?php if (isset($_SESSION['query_status'])): ?>

    <body>
        <div class="container form-container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="card form-card shadow">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="mb-4 text-center">Query Status</h2>
                            <?php
                            $createdAt = $_SESSION['query_status']['created_at'];
                            if (time() - $createdAt > 3600) {
                                session_unset();
                                session_destroy();
                                echo "<div class='alert alert-danger'>Session expired. Please check your query status again.</div>";
                                echo "<a href='query.php' class='btn btn-primary mt-2'>Go Back</a>";
                            } else {
                                $email = $_SESSION['query_status']['email'];
                                $enrollmentNumber = $_SESSION['query_status']['enrollmentNumber'];
                                $sql = "SELECT gen_id, student_name, student_img, enrollment_no, email, query, status 
                                        FROM tbl_runtime_query WHERE email = ? AND enrollment_no = ?";
                                $stmt = $con->prepare($sql);
                                $stmt->bind_param("ss", $email, $enrollmentNumber);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result && $row = $result->fetch_assoc()) {
                                    $showMessage = '';
                                    $color = '';
                                    if ($row['status'] == 'pending') {
                                        $showMessage = "<div class='alert alert-warning fs-5'>Your query is in progress. Please wait up to 30 minutes. Refresh the page every 5 minutes to check for updates.</div>";
                                        $color = 'warning';
                                    } elseif ($row['status'] == 'approved') {
                                        $showMessage = "<div class='alert alert-success fs-5'>Your query is Approved. You now have access to Rasmanjari.</div>";
                                        $color = 'success';
                                    } elseif ($row['status'] == 'rejected') {
                                        $showMessage = "<div class='alert alert-danger fs-5'>Your query has been Rejected. You do not have access to Rasmanjari.</div>";
                                        $color = 'danger';
                                    }
                                    echo "<div class='text-center mb-4'><img src='./uploads/query_student/{$row['student_img']}' alt='Student Photo' class='img-thumbnail rounded-circle' style='width: 120px; height: 120px; object-fit: cover;'></div>";
                                    echo "<div class='mt-2 text-start'><p><strong>Generated ID:</strong> {$row['gen_id']}</p><p><strong>Student Name:</strong> {$row['student_name']}</p><p><strong>Enrollment No:</strong> {$row['enrollment_no']}</p><p><strong>Email:</strong> {$row['email']}</p><p><strong>Query:</strong> {$row['query']}</p><p><strong>Status:</strong> <span class='badge bg-{$color} p-2 fs-6'>{$row['status']}</span></p></div>";
                                    echo $showMessage;
                                } else {
                                    echo "<div class='alert alert-warning'>No record found. Please submit a new query.</div>";
                                    echo "<a href='query.php' class='btn btn-primary mt-2'>Submit New Query</a>";
                                    session_destroy();
                                }
                                $stmt->close();
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
<?php else: ?>

    <body>
        <div class="container form-container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="card form-card">
                        <div class="card-body p-4 p-md-5 position-relative">
                            <button id="backBtn" class="btn btn-sm btn-outline-secondary btn-back"
                                style="display: none;">&larr; Back</button>
                            <div id="initialView">
                                <div class="card-header-custom">
                                    <div class="d-flex flex-column flex-md-row justify-content-center align-items-center">
                                        <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png"
                                            alt="Company Logo" class="form-logo mb-3 mb-md-0 me-md-3">
                                        <img src="https://gmiu.edu.in/gmiu/website_assets/images/logo-raas.png"
                                            alt="Company Logo" class="form-logo ms-md-3">
                                    </div>
                                    <h2 class="mt-3">Student Query Portal</h2>
                                    <p class="text-muted">How can we help you today?</p>
                                </div>
                                <div class="d-grid gap-3 mt-4">
                                    <button id="showNewQueryFormBtn" class="btn btn-primary fs-5">Submit New Query</button>
                                    <button id="showCheckStatusFormBtn" class="btn btn-secondary fs-5">Check Query
                                        Status</button>
                                </div>
                            </div>
                            <div id="newQueryView" style="display: none;">
                                <div class="card-header-custom">
                                    <div class="d-flex flex-column flex-md-row justify-content-center align-items-center">
                                        <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png"
                                            alt="Company Logo" class="form-logo mb-3 mb-md-0 me-md-3">
                                        <img src="https://gmiu.edu.in/gmiu/website_assets/images/logo-raas.png"
                                            alt="Company Logo" class="form-logo ms-md-3">
                                    </div>
                                    <h2 class="mt-3">Student Query Form</h2>
                                </div>
                                <form action="query.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
                                    <div class="mb-3">
                                        <label for="studentName" class="form-label">Student Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                            id="studentName" name="studentName" placeholder="Enter full name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="enrollmentNumber" class="form-label">Enrollment or Roll Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                            id="enrollmentNumber" name="enrollmentNumber"
                                            placeholder="Enter enrollment number" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email ID <span
                                                class="text-danger">*</span></label>
                                        <input type="email"
                                            class="form-control rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                            id="email" name="email" placeholder="name@example.com" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="studentImage" class="form-label">Student Photo <span
                                                class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                            id="studentImage" name="studentImage" accept="image/jpeg, image/png" required>
                                        <div class="form-text">Photo must be a clear, passport-style image (JPG or PNG).
                                        </div>
                                        <div class="form-text text-danger fw-bold">Max file size: 2 MB.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="college" class="form-label">College <span
                                                class="text-danger">*</span></label>
                                        <select
                                            class="form-select rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                            id="college" name="college" required>
                                            <option value="" selected disabled>Select...</option>
                                            <option value="GTU">GTU</option>
                                            <option value="GMIU">GMIU</option>
                                            <option value="GGC">GGC</option>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="branch" class="form-label">Branch Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                                id="branch" name="branch" placeholder="e.g., Computer Engineering" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="specialization" class="form-label">Specialization <span
                                                    class="text-muted">(Optional)</span></label>
                                            <input type="text"
                                                class="form-control rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                                id="specialization" name="specialization" placeholder="e.g., AI & ML">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="semester" class="form-label">Semester <span
                                                class="text-danger">*</span></label>
                                        <select
                                            class="form-select rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                            id="semester" name="semester" required>
                                            <option value="" selected disabled>Select...</option>
                                            <option value="1">1</option>
                                            <option value="3">3</option>
                                            <option value="5">5</option>
                                            <option value="7">7</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="hodName" class="form-label">Head of Department Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                            id="hodName" name="hodName" placeholder="Enter HOD's full name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="queryType" class="form-label">Query <span
                                                class="text-danger">*</span></label>
                                        <select
                                            class="form-select rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                            id="queryType" name="queryType" required>
                                            <option value="" selected disabled>Select a query...</option>
                                            <option
                                                value="Temporary icard without department stamp or signature, but turnstile done">
                                                Temporary icard without department stamp or signature, but turnstile done
                                            </option>
                                            <option
                                                value="Temporary icard without department stamp or signature, but turnstile not done">
                                                Temporary icard without department stamp or signature, but turnstile not
                                                done</option>
                                            <option value="No hard copy of adhar card">No hard copy of adhar card</option>
                                            <option value="No Permanent or temporary Icard">No Permanent or temporary Icard
                                            </option>
                                            <option value="Not done biometric but permanent Icard available.">Not done
                                                biometric but permanent Icard available.</option>
                                            <option value="Not done biometric but Temporary Icard available.">Not done
                                                biometric but Temporary Icard available.</option>
                                            <option
                                                value="Not done biometric but temporary icard without departmental stamp or signature">
                                                Not done biometric but temporary icard without departmental stamp or
                                                signature</option>
                                            <option
                                                value="No traditional dress code but temporary icard available and turnstile done.">
                                                No traditional dress code but temporary icard available and turnstile done.
                                            </option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="otherQueryContainer" style="display: none;">
                                        <label for="otherQuery" class="form-label">Please specify your query <span
                                                class="text-danger">*</span></label>
                                        <textarea
                                            class="form-control rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                            id="otherQuery" name="otherQuery" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="attachmentType" class="form-label">Attachment Type <span
                                                class="text-danger">*</span></label>
                                        <select
                                            class="form-select rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                            id="attachmentType" name="attachmentType" required>
                                            <option value="" selected disabled>Select attachment type...</option>
                                            <option value="fees-receipt-adhar-card">fees receipt - adhar card</option>
                                            <option value="icard-permanent-adhar-card">i card permanent - adhar card
                                            </option>
                                            <option value="icard-temporary-adhar-card">i card temporary - adhar card
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="attachmentFile" class="form-label">Upload Attachment <span
                                                class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                            id="attachmentFile" name="attachmentFile" accept=".pdf" required>
                                        <div class="form-text text-danger mt-2">
                                            <ul>
                                                <li>Attach required documents in a <strong>single PDF file</strong>.</li>
                                                <li class="fw-bold">Max file size: 5 MB.</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mb-4 form-check">
                                        <input type="checkbox" class="form-check-input" id="consentCheck"
                                            name="consentCheck" required>
                                        <label class="form-check-label" for="consentCheck">I hereby declare that I am
                                            providing the attached documents to the university with my full consent. <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 fs-5"
                                        name="application_submit">Submit Application</button>
                                </form>
                            </div>
                            <div id="checkStatusView" style="display: none;">
                                <div class="card-header-custom">
                                    <h2 class="mt-3">Check Query Status</h2>
                                </div>
                                <form method="post">
                                    <div class="mb-3">
                                        <label for="checkEmail" class="form-label">Email ID</label>
                                        <input type="email"
                                            class="form-control rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                            id="checkEmail" name="checkEmail" placeholder="Enter your email" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="checkEnrollment" class="form-label">Enrollment or Roll Number</label>
                                        <input type="text"
                                            class="form-control rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                            id="checkEnrollment" name="checkEnrollment"
                                            placeholder="Enter your enrollment number" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 fs-5" name="check_query">Check
                                        Status</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const initialView = document.getElementById('initialView'), newQueryView = document.getElementById('newQueryView'), checkStatusView = document.getElementById('checkStatusView');
                const showNewQueryBtn = document.getElementById('showNewQueryFormBtn'), showCheckStatusBtn = document.getElementById('showCheckStatusFormBtn'), backBtn = document.getElementById('backBtn');
                function showView(viewToShow) {
                    initialView.style.display = 'none'; newQueryView.style.display = 'none'; checkStatusView.style.display = 'none';
                    viewToShow.style.display = 'block';
                    backBtn.style.display = (viewToShow === initialView) ? 'none' : 'block';
                }
                showNewQueryBtn.addEventListener('click', () => showView(newQueryView));
                showCheckStatusBtn.addEventListener('click', () => showView(checkStatusView));
                backBtn.addEventListener('click', () => showView(initialView));
                const queryTypeSelect = document.getElementById('queryType'), otherQueryContainer = document.getElementById('otherQueryContainer'), otherQueryInput = document.getElementById('otherQuery');
                queryTypeSelect.addEventListener('change', function () {
                    if (this.value === 'Other') {
                        otherQueryContainer.style.display = 'block'; otherQueryInput.required = true;
                    } else {
                        otherQueryContainer.style.display = 'none'; otherQueryInput.required = false;
                    }
                });
                const checkEmailInput = document.getElementById('checkEmail'), checkEnrollmentInput = document.getElementById('checkEnrollment');
                const storedEmail = localStorage.getItem('queryUserEmail'), storedEnrollment = localStorage.getItem('queryUserEnrollmentNumber');
                if (storedEmail) { checkEmailInput.value = storedEmail; }
                if (storedEnrollment) { checkEnrollmentInput.value = storedEnrollment; }
            });
        </script>
    </body>
<?php endif; ?>

</html>