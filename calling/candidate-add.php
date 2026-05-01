<?php
include './include/config.php';
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitInquiry'])) {

    /**
     * ---------------------------------------------------------
     * STEP 1: Collect and sanitize form data
     * ---------------------------------------------------------
     * - Converts names to uppercase for consistency
     * - Ensures mobile number contains only digits
     * - Handles optional fields gracefully
     */
    $first_name = !empty($_POST['first_name']) ? strtoupper(trim($_POST['first_name'])) : '';
    $middle_name = !empty($_POST['middle_name']) ? strtoupper(trim($_POST['middle_name'])) : '';
    $last_name = !empty($_POST['last_name']) ? strtoupper(trim($_POST['last_name'])) : '';
    $mobile = !empty($_POST['mobile']) ? preg_replace('/\D/', '', $_POST['mobile']) : '';
    $gender = !empty($_POST['gender']) ? trim($_POST['gender']) : '';
    $completed_study = !empty($_POST['completed_study']) ? (int) $_POST['completed_study'] : 0;
    $specify_degree = !empty($_POST['specify_degree']) ? trim($_POST['specify_degree']) : '';
    $faculty_id = !empty($_POST['faculty_id']) ? (int) $_POST['faculty_id'] : 0;
    $level_id = !empty($_POST['level_id']) ? (int) $_POST['level_id'] : 0;
    $program_id = !empty($_POST['program_id']) ? (int) $_POST['program_id'] : 0;

    // Inquiry type selected by user (e.g., Website, Walk-in, Whatsapp, etc.)
    $inquiry_type = !empty($_POST['is_online']) ? (int) $_POST['is_online'] : 0;

    // Last exam (used later for ID generation)
    $last_exam = (string) $completed_study;

    // ---------------------------------------------------------
    // STEP X: Check if mobile already exists
    // ---------------------------------------------------------

    $checkStmt = $con->prepare("SELECT inq_student_id, first_name, middle_name, last_name, mobile_number, gender, last_exam, is_online, created_at 
                            FROM tbl_inquiry_student 
                            WHERE mobile_number = ?
                            ORDER BY id DESC LIMIT 1");
    $checkStmt->bind_param("s", $mobile);
    $checkStmt->execute();
    $existing = $checkStmt->get_result();
    $checkStmt->close();

    if ($existing && $existing->num_rows > 0) {
        // Fetch existing inquiry
        $data = $existing->fetch_assoc();


        $message = "Mobile Number Already Exists! ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎  ";
        $message .= "Inquiry ID: {$data['inq_student_id']} ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ";
        $message .= "Name: " . trim($data['first_name'] . " " . $data['middle_name'] . " " . $data['last_name']) . "‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎  ";
        $message .= "Gender: {$data['gender']} ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ";
        $message .= "Last Exam: {$data['last_exam']} ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎  ";
        $message .= "Inquiry Type: {$data['is_online']} ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ";
        $message .= "Created At: {$data['created_at']}";

        $clean = [
            "message" => $message,
            "code" => "duplicate"
        ];

        $_SESSION['status'] = $message;
        $_SESSION['status_code'] = "error";

    } else {


        /**
         * ---------------------------------------------------------
         * STEP 2: Define mappings for inquiry types
         * ---------------------------------------------------------
         * - Maps database inquiry_type values to ID prefixes
         */
        $inqTypeMap = [
            1 => "WB",   // Website
            2 => "WA",   // Whatsapp
            3 => "OT",   // Other
            4 => "WI",   // Walk In
            5 => "EM"    // E-Mail
        ];


        /**
         * ---------------------------------------------------------
         * STEP 3: Define mappings for last exam codes
         * ---------------------------------------------------------
         * - Maps completed_study values to exam codes in the ID
         */
        $examMap = [
            1 => "10",    // 10th
            2 => "12C",   // 12th Commerce
            3 => "12A",   // 12th Science (A Group)
            4 => "12B",   // 12th Science (B Group)
            5 => "12AR",  // 12th Arts
            6 => "UG",    // Graduate
            7 => "PG",     // Post Graduate
            8 => "D",     // Diploma
            9 => "ITI",     // ITI
            10 => "DP",     // Diploma Pharmacy
        ];


        /**
         * ---------------------------------------------------------
         * STEP 4: Generate unique Inquiry Student ID
         * ---------------------------------------------------------
         * Format:
         *   <InquiryTypePrefix>-<ExamCode>-<DDMMYY>-<Serial>
         *
         * Example:
         *   WI-10-300925-00001
         *
         * Components:
         *   - InquiryTypePrefix : Derived from inquiry_type
         *   - ExamCode          : Derived from completed_study (last_exam)
         *   - DDMMYY            : Current date in day-month-year (2-digit year)
         *   - Serial            : Incremental, unique per inquiry_type + last_exam
         */

        // Resolve prefix values
        $inqPrefix = $inqTypeMap[$inquiry_type] ?? "XX";
        $examCode = $examMap[$last_exam] ?? "NA";

        // Current date in DDMMYY format
        $datePart = date("dmy");

        // Fetch the current count for this combination (inquiry_type + last_exam)
        $stmtCount = $con->prepare("
        SELECT COUNT(*) AS total 
        FROM tbl_inquiry_student 
        WHERE is_online = ? AND last_exam = ?
    ");
        $stmtCount->bind_param("ii", $inquiry_type, $last_exam);
        $stmtCount->execute();
        $result = $stmtCount->get_result();
        $row = $result ? $result->fetch_assoc() : ['total' => 0];
        $stmtCount->close();

        // Generate next serial (5-digit padded)
        $serial = str_pad(((int) $row['total']) + 1, 5, "0", STR_PAD_LEFT);

        // Construct final Inquiry Student ID
        $inq_student_id = $inqPrefix . "-" . $examCode . "-" . $datePart . "-" . $serial;


        /**
         * ---------------------------------------------------------
         * STEP 5: Insert student inquiry into database
         * ---------------------------------------------------------
         * - Uses prepared statements to prevent SQL injection
         * - Records student details along with generated ID
         */
        $sql = "INSERT INTO tbl_inquiry_student 
        (inq_student_id, first_name, middle_name, last_name, mobile_number, gender, specify_degree, last_exam, is_online, faculty_id, level_id, program_id, created_at, created_by) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param(
                "ssssisssiiiii",
                $inq_student_id,
                $first_name,
                $middle_name,
                $last_name,
                $mobile,
                $gender,
                $specify_degree,
                $last_exam,
                $inquiry_type,
                $faculty_id,
                $level_id,
                $program_id,
                $staff_id
            );

            if ($stmt->execute()) {
                $_SESSION['status'] = "Student Inquiry inserted successfully.";
                $_SESSION['status_code'] = "success";
                $_SESSION['status_redirect'] = "candidate-add.php?mob=$mobile";
            } else {
                $_SESSION['status'] = "Insertion Failed: " . $stmt->error;
                $_SESSION['status_code'] = "error";
            }
            $stmt->close();
        } else {
            $_SESSION['status'] = "Insertion Failed, Something Went Wrong: " . $con->error;
            $_SESSION['status_code'] = "error";
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
                                <h4>Student Inquiry Form</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">New Inquiry</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <form id="mobileSearchForm">
                        <div class="row align-items-center">

                            <!-- Label -->
                            <div class="col-md-2">
                                <label class="col-form-label mb-0">Mobile Number</label>
                            </div>

                            <!-- Input -->
                            <div class="col-md-4">
                                <input class="form-control" type="tel" id="search_mobile" name="search_mobile"
                                    placeholder="98765 43210">
                            </div>

                            <!-- Button -->
                            <div class="col-md-2 d-flex">
                                <button type="submit" class="btn btn-primary w-100" id="mobileSearchFormButton">
                                    Search
                                </button>
                                <a href="candidate-add.php" class="btn btn-secondary w-100 ml-2">
                                    Cancel
                                </a>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- Result Box -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 d-none" id="resultCard">
                    <div class="inquiry-result">

                        <!-- WHERE RECORD WAS FOUND -->
                        <div class="alert alert-info mb-20">
                            <strong>Record Found In:</strong>
                            <span id="result_foundIn" class="text-primary font-weight-bold"></span>
                        </div>

                        <a href="candidate-details.php?id=" class="btn btn-primary" id="printLink">Print</a>

                        <!-- STUDENT INFO CARD -->
                        <div class="card border-left-primary shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Student Details</h5>

                                <!-- Student ID -->
                                <div class="row mb-2">
                                    <div class="col-md-4"><strong>Student ID:</strong></div>
                                    <div class="col-md-8" id="result_inq_student_id"></div>
                                </div>

                                <!-- FIRST + MIDDLE + LAST NAME IN ONE ROW -->
                                <div class="row mb-2">
                                    <div class="col-md-2"><strong>First Name:</strong></div>
                                    <div class="col-md-2" id="result_first_name"></div>

                                    <div class="col-md-2"><strong>Middle Name:</strong></div>
                                    <div class="col-md-2" id="result_middle_name"></div>

                                    <div class="col-md-2"><strong>Last Name:</strong></div>
                                    <div class="col-md-2" id="result_last_name"></div>
                                </div>


                                <!-- GENDER + MOBILE + EMAIL IN ONE ROW -->
                                <div class="row mb-2">
                                    <div class="col-md-2"><strong>Gender:</strong></div>
                                    <div class="col-md-2" id="result_gender"></div>

                                    <div class="col-md-2"><strong>Mobile:</strong></div>
                                    <div class="col-md-2" id="result_mobile_number"></div>

                                    <div class="col-md-2"><strong>Email:</strong></div>
                                    <div class="col-md-2" id="result_email"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <form id="inquiryForm" method="POST">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>First Name (Student Name)</label>
                                    <input type="text" name="first_name" class="form-control" id="first_name"
                                        placeholder="Enter First Name">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Middle Name (Father's Name)</label>
                                    <input type="text" name="middle_name" class="form-control" id="middle_name"
                                        placeholder="Enter Middle Name">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Last Name (Surname)</label>
                                    <input type="text" name="last_name" class="form-control" id="last_name"
                                        placeholder="Enter Last Name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Select Faculty (only for head)</label>
                                    <select class="form-control" name="faculty_id" id="faculty_id">
                                        <option value="">---Select Faculty---</option>
                                        <?php
                                        $cmd = "SELECT id,name FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                        $stmt = $con->prepare($cmd);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Select Level (only for head)</label>
                                    <select name="level_id" id="level_id" class="form-control">
                                        <option value="">---Select Level---</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Select Program (only for head)</label>
                                    <select name="program_id" id="program_id" class="form-control">
                                        <option value="">---Select Program---</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Mobile Number</label>
                            <div class="col-sm-12 col-md-4">
                                <input class="form-control" type="tel" name="mobile" id="mobile"
                                    placeholder="98765 43210">
                            </div>

                            <label class="col-sm-12 col-md-2 col-form-label">Gender</label>
                            <div class="col-sm-12 col-md-4">
                                <select class="form-control" name="gender" id="gender">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">

                            <!-- Completed Study (label + input in same line) -->
                            <div class="col-md-6 d-flex align-items-center">
                                <label class="col-form-label col-md-4 px-0" style="white-space: nowrap;">Completed
                                    Study</label>
                                <select id="completedStudy" name="completed_study"
                                    class="custom-select flex-grow-1 col-md-8">
                                    <option selected="">Choose...</option>
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

                            <!-- Specify Degree (label + input in same line) -->
                            <div class="col-md-6 align-items-center" id="graduationDetails" style="display: none;">
                                <div class="d-flex">
                                    <label class="col-form-label col-md-4 px-0" style="white-space: nowrap;">Specify
                                        Degree</label>
                                    <input class="form-control flex-grow-1 col-md-8" type="text" name="specify_degree"
                                        placeholder="e.g., Bachelor of Commerce, Master of Science">
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Inquiry Type</label>
                            <div class="col-sm-12 col-md-4">
                                <select id="inquiryType" name="is_online" class="custom-select col-12" required>
                                    <option value="">---Select Type Of Inquiry---</option>
                                    <!-- <option value="1">Website</option> -->
                                    <!-- <option value="2">Whatsapp</option> -->
                                    <!-- <option value="3">Other</option> -->
                                    <option value="4">Walk In</option>
                                    <!-- <option value="5">E-Mail</option> -->
                                </select>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary" id="submitInquiry" name="submitInquiry">Submit
                                Inquiry</button>
                        </div>

                    </form>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>

    <script>
        $(document).ready(function () {

            // --- Script to handle conditional field ---
            $('#completedStudy').on('change', function () {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check if the selected value is 'graduate' or 'post graduate'
                let validValue = ['6', '7', '8', '9', '10'];
                if (validValue.includes(selectedValue)) {
                    // If it is, show the graduation details input field
                    $('#graduationDetails').slideDown();
                } else {
                    // Otherwise, hide it
                    $('#graduationDetails').slideUp();
                }
            });
        });
    </script>

    <script>
        // 🔹 Main search handler function
        function handleMobileSearch({ form = null, mobile = null }) {

            let searchMobile = "";

            // Case 1: Called from FORM submit
            if (form) {
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                searchMobile = data.search_mobile;
            }

            // Case 2: Called from URL (?mob=...)
            if (mobile) {
                searchMobile = mobile;
            }

            if (!searchMobile) {
                alert("Mobile number missing!");
                return;
            }

            fetch(`./extra/search_student.php?mobile=${searchMobile}`, {
                method: "GET",
            })
                .then(async res => {
                    const text = await res.text();
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error("Raw server response:", text);
                        throw new Error("Invalid JSON from API");
                    }
                })
                .then(result => {
                    if (result.status === "success") {
                        document.getElementById("resultCard").classList.remove("d-none");

                        const data = result.data;

                        if (result.found_in === "Inquiry Student") {
                            document.getElementById("result_foundIn").textContent = result.found_in;
                            document.getElementById("result_inq_student_id").textContent = data.inq_student_id || "-";
                            document.getElementById("result_first_name").textContent = data.first_name || "-";
                            document.getElementById("result_middle_name").textContent = data.middle_name || "-";
                            document.getElementById("result_last_name").textContent = data.last_name || "-";
                            document.getElementById("result_gender").textContent = "-";
                            document.getElementById("result_mobile_number").textContent = data.mobile_number || "-";
                            document.getElementById("result_email").textContent = "-";

                            document.getElementById("printLink").href =
                                `candidate-details.php?id=${data.id}`;
                        }
                    } else {
                        document.getElementById("resultCard").classList.add("d-none");
                        alert("Record not found!");
                    }
                })
                .catch(err => {
                    console.error("Fetch error:", err);
                    alert("Error fetching inquiry!");
                });
        }

        // 🔹 Event listener for form submit
        document.getElementById("mobileSearchForm").addEventListener("submit", function (e) {
            e.preventDefault();
            handleMobileSearch({ form: this });
        });

        // 🔹 Auto search from URL (?mob=...)
        document.addEventListener("DOMContentLoaded", function () {
            <?php if (isset($_GET['mob'])) { ?>
                handleMobileSearch({ mobile: "<?= htmlspecialchars($_GET['mob']) ?>" });
            <?php } ?>
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {

            // ** INITIALIZE SELECT2 **
            $('#staff_id').select2();

            // This is for dynamic dropdowns when a user makes a selection
            $('#faculty_id').on('change', function () {
                var faculty_id = this.value;
                $.ajax({
                    url: 'level.php',
                    type: "POST",
                    data: {
                        faculty_data: faculty_id
                    },
                    success: function (result) {
                        $('#level_id').html(result);
                        $('#program_id').html('<option value="">---Select Program---</option>');
                    }
                })
            });

            $('#level_id').on('change', function () {
                var level_id = this.value;
                var faculty_id = $("#faculty_id").val();

                $.ajax({
                    url: 'program.php',
                    type: "POST",
                    data: {
                        level_data: level_id,
                        faculty_data: faculty_id
                    },
                    cache: false,
                    success: function (data) {
                        $('#program_id').html(data);
                    }
                })
            });
        });
    </script>

</body>

</html>