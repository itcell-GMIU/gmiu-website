<?php 
include '../../common/importwebsitefile.php'; ?>

<?php
date_default_timezone_set('Asia/Kolkata'); // set your timezone

// Define cutoff time
// $cutoff_time = strtotime('16:30:00');
$cutin_time = strtotime('18:30:00');
$current_time = time();

// if ($current_time < $cutoff_time) {
//     echo "<h2 style='color:red; text-align:center; margin-top:50px;'>Not opened yet!, Will open after 4:30</h2>";
//     exit;
// }

if ($current_time > $cutin_time) {
    echo "<h2 style='color:red; text-align:center; margin-top:50px;'>It is Closed Now.</h2>";
    exit;
}

// session_destroy();
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['application_submit'])) {

    // --- DUPLICATE ENTRY CHECK ---
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


    // --- IMPROVED FILE UPLOAD HANDLING ---
    $attachment_file_path = '';

    // Check if file is set and there are no initial errors
    if (isset($_FILES["attachmentFile"]) && $_FILES["attachmentFile"]["error"] != UPLOAD_ERR_NO_FILE) {

        // Check for specific upload errors
        $upload_error = $_FILES["attachmentFile"]["error"];
        if ($upload_error == UPLOAD_ERR_OK) { // UPLOAD_ERR_OK is 0
            $target_dir = "./uploads/query/";

            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $file_extension = pathinfo($_FILES["attachmentFile"]["name"], PATHINFO_EXTENSION);
            $unique_filename = uniqid('attachment_', true) . '.' . $file_extension;
            $target_file = $target_dir . $unique_filename;

            if (move_uploaded_file($_FILES["attachmentFile"]["tmp_name"], $target_file)) {
                $attachment_file_path = $unique_filename; // Store only the filename
            } else {
                // This error can be due to folder permissions
                die_with_alert('error', 'Upload Failed', 'Could not move the uploaded file. Check server permissions for the uploads folder.');
            }
        } else {
            // Provide a more specific error message
            $error_message = 'An unknown error occurred.';
            switch ($upload_error) {
                case UPLOAD_ERR_INI_SIZE:
                    $error_message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $error_message = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $error_message = 'The uploaded file was only partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $error_message = 'Missing a temporary folder for uploads.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $error_message = 'Failed to write file to disk.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $error_message = 'A PHP extension stopped the file upload.';
                    break;
            }
            die_with_alert('error', 'File Upload Error', $error_message);
        }
    } else {
        // This is the original error you were seeing
        die_with_alert('error', 'File Error', 'No file was selected for upload.');
    }

    // --- PREPARE DATA FOR INSERTION ---
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

    // --- DATABASE INSERTION ---
    $sql = "INSERT INTO tbl_runtime_query (student_name, enrollment_no, email, college, branch, specialization, sem, hod_name, query, attachment_type, attachment_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssssissss", $student_name, $enrollment_no, $email, $college, $branch, $specialization, $sem, $hod_name, $query_text, $attachment_type, $attachment_file_path);

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

       echo "<script>
                setTimeout(function() {
                alert('!!! Query Submitted successfully !!!');
                    }, 500);
            </script>";
        show_alert('success', 'Query Submitted!', 'Your query has been successfully submitted. We will get back to you soon.');
         header("Location: query.php");
         exit;
    } else {
        show_alert('error', 'Submission Failed', 'There was an error submitting your query. Error: ' . $stmt->error);
    }

    $stmt->close();
    $con->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_query'])) {
    $checkEmail = $_POST['checkEmail'];
    $checkEnrollment = $_POST['checkEnrollment'];

    $_SESSION['query_status'] = [
        'enrollmentNumber' => $checkEnrollment,
        'email' => $checkEmail,
        'message' => 'Your query is Checking.',
        'created_at' => time()
    ];
}

// --- HELPER FUNCTIONS ---
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
    <head><title>Submission Status</title><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head>
    <body>
        <script>
            Swal.fire({
                icon: '{$icon}', title: '{$title}', text: '{$text}', confirmButtonText: 'OK'
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
        xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

<?php
if (isset($_SESSION['query_status'])) {
    ?>

    <body>
        <div class="container form-container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="card form-card shadow">
                        <div class="card-body p-4 p-md-5 text-center">
                            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center">
                                <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="Company Logo"
                                    class="form-logo mb-3 mb-md-0 me-md-3">
                                <img src="https://gmiu.edu.in/gmiu/website_assets/images/logo-raas.png" alt="Company Logo"
                                    class="form-logo ms-md-3">
                            </div>
                            <h2 class="mb-3">Query Status</h2>

                            <?php
                            $createdAt = $_SESSION['query_status']['created_at'];
                            if (time() - $createdAt > 3600) {
                                session_unset();
                                session_destroy();
                                echo "<div class='alert alert-danger'>Session expired. Please submit a new query.</div>";
                            } else {

                                $email = $con->real_escape_string($_SESSION['query_status']['email']);
                                $enrollmentNumber = $con->real_escape_string($_SESSION['query_status']['enrollmentNumber']);

                                $result = $con->query("SELECT student_name, enrollment_no, email, query, status 
                                                FROM tbl_runtime_query 
                                                WHERE email = '$email' AND enrollment_no = '$enrollmentNumber'");
                                if ($result && $row = $result->fetch_assoc()) {

                                    if ($row['status'] == 'pending') {
                                        $showMessage = "<div class='alert alert-warning fs-5'> Your query is in progress. Please wait 30min. Make sure you Refresh in 5mins interval.</div>";
                                        $color = 'warning';
                                    } elseif ($row['status'] == 'approved') {
                                        $showMessage = "<div class='alert alert-success fs-5'> Your query is Approved. You Have an Access of Rasmanjari. </div>";
                                        $color = 'success';
                                    } elseif ($row['status'] == 'rejected') {
                                        $showMessage = "<div class='alert alert-danger fs-5'> Your query is Rejected. You Do not have Access of Rasmanjari. </div>";
                                        $color = 'danger';
                                    }

                                    echo "
                                        <div class='mt-4 text-start'>
                                            <p><strong>Student Name:</strong> {$row['student_name']}</p>
                                            <p><strong>Enrollment No:</strong> {$row['enrollment_no']}</p>
                                            <p><strong>Email:</strong> {$row['email']}</p>
                                            <p><strong>Query:</strong> {$row['query']}</p>
                                            <p><strong>Status:</strong> <span class='btn btn-$color py-1'>{$row['status']}</span></p>
                                        </div>
                                    ";

                                    echo $showMessage;


                                } else {
                                    echo "<div class='alert alert-warning'>No record found for the given details.</div>";
                                    echo "<a href='query.php' class='btn btn-primary'>Home</a>";
                                    session_destroy();
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

    <?php
} else {
    ?>

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
                                <!-- V V V V V  THE FIX IS HERE V V V V V -->
                                <form action="query.php" method="post" enctype="multipart/form-data">
                                    <!-- Form fields remain the same -->
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
                                            <option value="adhar-fees">Aadhar & Fee Receipt</option>
                                            <option value="adhar-icard">Aadhar & I-Card</option>
                                            <option value="fees-icard">Fee Receipt & I-Card</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="attachmentFile" class="form-label">Upload Attachment <span
                                                class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control rounded-0 bg-custom-light border-0 border-bottom border-primary"
                                            id="attachmentFile" name="attachmentFile" required>
                                        <span class="text-danger">
                                            <ul>
                                                <li>Attach two required documents in a single PDF file.</li>
                                                <li>Ensure that the PDF is clear, readable, and does not exceed the maximum
                                                    file size limit (if applicable).</li>
                                                <li>Once the PDF is ready, upload it using the provided upload option.</li>
                                            </ul>
                                        </span>
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
            xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
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
            });
        </script>
    </body>
    <?php

}
?>

</html>