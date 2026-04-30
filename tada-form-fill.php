<?php
include('include/config.php');

// FORM SUBMISSION
if (isset($_POST['submit'])) {

    // ----------------------------
// Collect Section 1 Inputs
// ----------------------------
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $full_name = isset($_POST['full_name']) ? $_POST['full_name'] : '';
    $bank_name = isset($_POST['bank_name']) ? $_POST['bank_name'] : '';
    $account_no = isset($_POST['account_no']) ? $_POST['account_no'] : '';
    $ifsc_code = isset($_POST['ifsc_code']) ? $_POST['ifsc_code'] : '';
    $form_date = isset($_POST['date']) ? $_POST['date'] : '';
    $designation = isset($_POST['designation']) ? $_POST['designation'] : '';
    $institute_name = isset($_POST['institute_name']) ? $_POST['institute_name'] : '';
    $institute_address = isset($_POST['institute_address']) ? $_POST['institute_address'] : '';
    $phone_no = isset($_POST['phone_no']) ? $_POST['phone_no'] : '';
    $email_id = isset($_POST['email_id']) ? $_POST['email_id'] : '';
    $pan_card = isset($_POST['pan_card']) ? $_POST['pan_card'] : '';
    $branch = isset($_POST['branch']) ? $_POST['branch'] : '';

    $bank_branch = isset($_POST['bank_branch']) ? $_POST['bank_branch'] : '';
    $bank_acc_type = isset($_POST['bank_acc_type']) ? $_POST['bank_acc_type'] : '';
    $faculty_id = isset($_POST['faculty_id']) ? (int)$_POST['faculty_id'] : 0;
    $level_id = isset($_POST['level_id']) ? (int)$_POST['level_id'] : 0;
    $program_id = isset($_POST['program_id']) ? (int)$_POST['program_id'] : 0;
    $subject_code_input = isset($_POST['subject_code']) ? $_POST['subject_code'] : '';
    $subject_code = is_array($subject_code_input) ? implode(', ', $subject_code_input) : $subject_code_input;
    $semester = isset($_POST['semester']) ? $_POST['semester'] : 0;
    $subject_name = isset($_POST['subject_name']) ? $_POST['subject_name'] : '';

    // ----------------------------
// Section 3, 4, 5, 6 Inputs
// ----------------------------
    $da_no_of_days = isset($_POST['da_no_of_days']) ? $_POST['da_no_of_days'] : 0;
    $da_rate_per_day = isset($_POST['da_rate_per_day']) ? $_POST['da_rate_per_day'] : 0;
    $total_da_amount_b = isset($_POST['total_da_amount_b']) ? $_POST['total_da_amount_b'] : 0;

    $honorarium_no_of_days = isset($_POST['hon_days']) ? $_POST['hon_days'] : 0;
    $honorarium_rate_per_day = isset($_POST['hon_rate']) ? $_POST['hon_rate'] : 0;
    $total_honorarium_amount_c = isset($_POST['total_honorarium_amount_c']) ? $_POST['total_honorarium_amount_c'] : 0;

    $accommodation_no_of_days = isset($_POST['acc_days']) ? $_POST['acc_days'] : 0;
    $accommodation_rate_per_day = isset($_POST['acc_rate']) ? $_POST['acc_rate'] : 0;
    $total_accommodation_amount_d = isset($_POST['total_accommodation_amount_d']) ? $_POST['total_accommodation_amount_d'] : 0;

    $gross_total_amount = isset($_POST['gross_total_amount']) ? $_POST['gross_total_amount'] : 0;
    $staff_id = $_SESSION['staff_id']; // Captured from session for ownership tracking
    // Handling simplified duty selects
    $duty_type = ($_POST['duty_external'] ?? '') ?: (($_POST['duty_internal'] ?? '') ?: ($_POST['duty_lab'] ?? ''));
    $duty_category = $duty_type; 

    $internal_examiner_name = $_POST['internal_examiner_name'] ?? '';
    $lab_examiner_name = $_POST['lab_examiner_name'] ?? '';
    $cert_rail_bus = isset($_POST['cert_rail_bus']) ? 1 : 0;
    $cert_air = isset($_POST['cert_air']) ? 1 : 0;
    $cert_car = isset($_POST['cert_car']) ? 1 : 0;
    $vehicle_no = $_POST['vehicle_no'] ?? '';
    $fuel_type = $_POST['fuel_type'] ?? '';

    // Generate Unique Form ID (Format: TADA + 5 Digits)
    $last_id_sql = $con->query("SELECT MAX(id) as max_id FROM tbl_tada_form_data");
    $last_row = $last_id_sql->fetch_assoc();
    $next_id_num = ($last_row['max_id'] ?? 0) + 1;
    $unique_id = "TADA" . str_pad($next_id_num, 5, '0', STR_PAD_LEFT);

    // Double check existence (just in case of parallel inserts)
    $check_unique = $con->query("SELECT id FROM tbl_tada_form_data WHERE unique_id = '$unique_id'");
    while($check_unique->num_rows > 0) {
        $next_id_num++;
        $unique_id = "TADA" . str_pad($next_id_num, 5, '0', STR_PAD_LEFT);
        $check_unique = $con->query("SELECT id FROM tbl_tada_form_data WHERE unique_id = '$unique_id'");
    }

    // =========================================================================
    $sql = "INSERT INTO tbl_tada_form_data (
        title, unique_id, full_name, form_date, designation, institute_name, institute_address, phone_no, email_id, pan_card, branch,
        subject_code, semester, subject_name,
        da_no_of_days, da_rate_per_day, total_da_amount_b,
        honorarium_no_of_days, honorarium_rate_per_day, total_honorarium_amount_c,
        accommodation_no_of_days, accommodation_rate_per_day, total_accommodation_amount_d,
        gross_total_amount, created_by, faculty_id, level_id, program_id, duty_category, duty_type,
        internal_examiner_name, lab_examiner_name,
        cert_rail_bus, cert_air, cert_car, vehicle_no, fuel_type,
        bank_name, account_no, ifsc_code, bank_branch, bank_acc_type
    ) VALUES (
        ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
    )";

    $stmt = $con->prepare($sql);
    $stmt->bind_param(
        "ssssssssssssssddddddddddiiiissssiiisssssss",
        $title, $unique_id, $full_name, $form_date, $designation, $institute_name, $institute_address, $phone_no, $email_id, $pan_card, $branch,
        $subject_code, $semester, $subject_name,
        $da_no_of_days, $da_rate_per_day, $total_da_amount_b,
        $honorarium_no_of_days, $honorarium_rate_per_day, $total_honorarium_amount_c,
        $accommodation_no_of_days, $accommodation_rate_per_day, $total_accommodation_amount_d,
        $gross_total_amount, $staff_id, $faculty_id, $level_id, $program_id, $duty_category, $duty_type,
        $internal_examiner_name, $lab_examiner_name,
        $cert_rail_bus, $cert_air, $cert_car, $vehicle_no, $fuel_type,
        $bank_name, $account_no, $ifsc_code, $bank_branch, $bank_acc_type
    );

    if ($stmt->execute()) {

        $tada_form_id = $stmt->insert_id;

        // INSERT TA ROWS
        $travel_sql = "INSERT INTO tbl_tada_form_travelling_allowance 
(tada_form_id, journey_date, journey_from, journey_to, distance_km, mode_of_journey, class_of_travel, fare_paid) 
VALUES (?,?,?,?,?,?,?,?)";

        $travel_stmt = $con->prepare($travel_sql);

        for ($i = 1; $i <= 3; $i++) {

            $j_date = isset($_POST["journey_date_$i"]) ? $_POST["journey_date_$i"] : '';
            $j_from = isset($_POST["journey_from_$i"]) ? $_POST["journey_from_$i"] : '';
            $j_to = isset($_POST["journey_to_$i"]) ? $_POST["journey_to_$i"] : '';
            $km = isset($_POST["distance_km_$i"]) ? $_POST["distance_km_$i"] : 0;
            $mode = isset($_POST["mode_of_journey_$i"]) ? $_POST["mode_of_journey_$i"] : '';
            $class = isset($_POST["class_of_travel_$i"]) ? $_POST["class_of_travel_$i"] : '';
            $fare = isset($_POST["fare_paid_$i"]) ? $_POST["fare_paid_$i"] : 0;
            // Skip empty rows
            if ($j_date == "" && $j_from == "" && $j_to == "" && $fare == 0) {
                continue;
            }

            $travel_stmt->bind_param(
                "isssdssi",
                $tada_form_id,
                $j_date,
                $j_from,
                $j_to,
                $km,
                $mode,
                $class,
                $fare
            );

            $travel_stmt->execute();
        }

        $_SESSION['tada_success_id'] = $tada_form_id;
        $_SESSION['tada_success'] = true;
        header("Location: tada-form-fill.php?success=1");
        exit();

    } else {
        $error_msg = "Error while submitting form!";
        header("Location: tada-form-fill.php?error=" . urlencode($error_msg));
        exit();
    }
}

// Fetch Initial Faculties
$faculty_res = $con->query("SELECT id, name FROM tbl_faculty WHERE is_active = 1 ORDER BY name ASC");
$faculties = $faculty_res ? $faculty_res->fetch_all(MYSQLI_ASSOC) : [];

// City list for Journey From / To dropdowns
$gujarat_cities = [
    // --- Bhavnagar City: Main Areas & Localities ---
    'Bhavnagar',
    'Atabhai Chowk',
    'Akashwani Road',
    'Anandnagar',
    'Ashok Nagar',
    'Bahumali Bhavan Area',
    'Bandhav Nagar',
    'Bhavnagar Airport',
    'Bhavnagar Port',
    'Bhavnagar Railway Station',
    'Bhathela',
    'Bholav',
    'Chakravati Road',
    'Chitra',
    'Chhani Jakat Naka',
    'Clock Tower',
    'College Road',
    'Crescent Circle',
    'Dakshinamurti Circle',
    'Diamond Chowk',
    'Dharmanagar',
    'Dhal Road',
    'Gadhia Society',
    'Gandhi Smruti Bhavan',
    'Gayatri Nagar',
    'Ghogha Circle',
    'GK General Hospital',
    'Gondal Road',
    'Gopnath',
    'Hadamtala',
    'Indira Circle',
    'Isanpur',
    'Jawahar Road',
    'Jivaraj Park',
    'Joshipura',
    'Kalo Dungar',
    'Kamalnayan Nagar',
    'Kamnath Road',
    'Kalanala',
    'Kaliyabid',
    'Khodiyarnagar',
    'Krushnanagar',
    'Kuvadva Road',
    'Lal Dairy',
    'Lalbhai Contractor Stadium',
    'Limbdi Naka',
    'Mahuva Road',
    'Manibhadra',
    'Maruti Nagar',
    'Mithi Road',
    'MJ College Area',
    'Moti Baug',
    'Nilambag Palace Area',
    'Nirmala Convent Road',
    'Old Bus Stand',
    'Old City Area',
    'Paliyadchowk',
    'Parshwanath Society',
    'Pathashala Road',
    'Ratnagiri',
    'RC Technical Institute',
    'Rupani Circle',
    'Sadhu Vasvani Road',
    'Sardar Nagar',
    'Sardar Patel Colony',
    'Sector 1 - Bhavnagar',
    'Sector 2 - Bhavnagar',
    'Sector 3 - Bhavnagar',
    'Sector 4 - Bhavnagar',
    'Sector 5 - Bhavnagar',
    'Sector 6 - Bhavnagar',
    'Sector 7 - Bhavnagar',
    'Shakti Nagar',
    'Shastri Nagar',
    'Shiyabaug',
    'Shri Nagar',
    'SP Ring Road',
    'ST Bus Stand',
    'State Bank Colony',
    'Subhash Nagar',
    'Swaminarayan Temple Area',
    'Takhteshwar Plot',
    'Talsanwada',
    'Tura Gate',
    'Udhna Naka',
    'Vadva',
    'Vaidyanath Road',
    'Vijay Nagar',
    'Vidhyanagar',
    'Wagher Road',
    'Waghawadi Road',
    'Waghawadi',
    // --- Bhavnagar District Towns & Villages ---
    'Akwada',
    'Alang',
    'Ambardi',
    'Bholad',
    'Botad',
    'Chorvad',
    'Deva',
    'Dhola',
    'Dhundhoraji',
    'Gariadhar',
    'Ghogha',
    'Gogha',
    'Jesar',
    'Jhunjhuwav',
    'Kavi Kanbha',
    'Khijadiya',
    'Koliyak',
    'Kotda Sangani',
    'Kukavav',
    'Lathidad',
    'Limbuda',
    'Mahuva',
    'Mithapur',
    'Nichlapur',
    'Palitana',
    'Pipaliya',
    'Rajula',
    'Sanosara',
    'Shihor',
    'Sihor',
    'Songarh',
    'Talaja',
    'Trapaj',
    'Umrala',
    'Vallabhipur',
    'Vartej',
    'Wadhvan',
    // --- Major Gujarat Cities ---
    'Ahmedabad',
    'Ahmedabad Airport',
    'Amreli',
    'Anand',
    'Bharuch',
    'Dahod',
    'Gandhinagar',
    'Godhra',
    'Jamnagar',
    'Junagadh',
    'Kheda',
    'Mehsana',
    'Morbi',
    'Navsari',
    'Patan',
    'Porbandar',
    'Rajkot',
    'Rajkot Airport',
    'Sabarkantha',
    'Surat',
    'Surat Airport',
    'Surendranagar',
    'Vadodara',
    'Vadodara Airport',
    'Valsad',
];
sort($gujarat_cities);

?>


<!DOCTYPE html>
<html>

    <?php include('include/head.php'); ?>
    <title>TA/DA Form</title>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include('include/header.php'); ?>
    <?php include('include/sidebar.php'); ?>

    <!-- PAN Check Modal -->
    <div class="modal fade" id="panModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="modal-title text-white">Enter PAN Card Number</h5>
                    <a href="index.php" class="text-white" style="font-size: 24px; text-decoration: none;">&times;</a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enter PAN Number to check for existing details:</label>
                        <div id="panError" class="text-danger small mb-1" style="display: none; font-weight: bold;"></div>
                        <input type="text" id="initial_pan" class="form-control" maxlength="10" placeholder="ABCDE1234F" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase(); $('#panError').hide();">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-block" onclick="checkPan()">Verify & Proceed</button>
                </div>
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>TADA Form</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">TADA Form</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <div class="tada-form">
                        <form method="POST" action="" enctype="multipart/form-data" id="tadaForm" novalidate>


                            <h4 class="mb-3 text-primary fw-bold">TADA FORM</h4>
                            <hr>

                            <div id="step_1_container">
                                <div class="card shadow-sm mb-4">
                                    <div class="card-header py-2 bg-primary text-white">
                                        <strong>SECTION 1: PERSONAL & PROFESSIONAL DETAILS</strong>
                                    </div>

                                    <div class="card-body p-3">
                                        <div class="row g-3">

                                             <div class="col-md-2">
                                                 <label>Title</label>
                                                 <select name="title" id="title" class="form-control" required>
                                                     <option value="">Select</option>
                                                     <option value="Mr.">Mr.</option>
                                                     <option value="Ms.">Ms.</option>
                                                     <option value="Dr.">Dr.</option>
                                                     <option value="Prof.">Prof.</option>
                                                 </select>
                                             </div>
                                             <div class="col-md-5">
                                                 <label>Full Name (As per Bank Account)</label>
                                                 <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Enter Full Name" required>
                                             </div>
                                             <div class="col-md-5">
                                                 <label>Date</label>
                                                 <input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                             </div>
                                             <div class="col-md-6">
                                                 <label>Designation</label>
                                                 <select name="designation" id="designation" class="form-control" required>
                                                     <option value="">Select Designation</option>
                                                     <option value="Professor">Professor</option>
                                                     <option value="Associate Professor">Associate Professor</option>
                                                     <option value="Assistant Professor">Assistant Professor</option>
                                                     <option value="Lecturer">Lecturer</option>
                                                     <option value="HOD">HOD</option>
                                                     <option value="Principal">Principal</option>
                                                     <option value="Other">Other</option>
                                                 </select>
                                             </div>
                                             <div class="col-md-6">
                                                 <label>Name of Institute</label>
                                                 <input type="text" name="institute_name" id="institute_name" class="form-control" placeholder="Enter Institute Name" required>
                                             </div>
                                             <div class="col-md-12">
                                                 <label>Institute Address</label>
                                                 <textarea name="institute_address" id="institute_address" class="form-control" rows="2" placeholder="Enter Full Address" required></textarea>
                                             </div>
                                             <div class="col-md-4">
                                                 <label>Phone No</label>
                                                 <input type="text" name="phone_no" id="phone_no" class="form-control" placeholder="Enter Phone No" pattern="^[0-9]{10}$" maxlength="10" title="Please enter a valid 10-digit mobile number" required>
                                             </div>
                                             <div class="col-md-4">
                                                 <label>Email ID</label>
                                                 <input type="email" name="email_id" id="email_id" class="form-control" placeholder="Enter Email ID" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" title="Please enter a properly structured email address" required>
                                             </div>
                                             <div class="col-md-4">
                                                 <label>PAN Card No.</label>
                                                 <input type="text" name="pan_card" id="pan_card" class="form-control" placeholder="Enter PAN Card No" maxlength="10" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase()" required>
                                             </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="card shadow-sm mb-4">
                                    <div class="card-header py-2 bg-info text-white">
                                        <strong>SECTION 2: BANK DETAILS</strong>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row g-3">
                                             <div class="col-md-4">
                                                 <label>Bank Name</label>
                                                 <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Enter Bank Name" required>
                                             </div>
                                             <div class="col-md-4">
                                                 <label>Branch &amp; Branch Code</label>
                                                 <input type="text" name="bank_branch" id="bank_branch" class="form-control" placeholder="Enter Branch & Code" required>
                                             </div>
                                             <div class="col-md-4">
                                                 <label>A/C Type (SB/CB)</label>
                                                 <select name="bank_acc_type" id="bank_acc_type" class="form-control" required>
                                                     <option value="">Select Type</option>
                                                     <option value="SB">SB (Savings Bank)</option>
                                                     <option value="CB">CB (Current Bank)</option>
                                                 </select>
                                             </div>
                                             <div class="col-md-4">
                                                 <label>IFSC Code</label>
                                                 <input type="text" name="ifsc_code" id="ifsc_code" class="form-control" placeholder="Enter IFSC Code" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase()" minlength="11" maxlength="11" title="IFSC code must be exactly 11 characters" required>
                                             </div>
                                             <div class="col-md-4">
                                                 <label>Account Number</label>
                                                 <input type="password" name="account_no" id="account_no" class="form-control" placeholder="Enter Account Number" required>
                                             </div>
                                             <div class="col-md-4">
                                                 <label>Re-enter Account Number</label>
                                                 <input type="text" id="account_no_confirm" class="form-control" placeholder="Confirm Account Number" required>
                                                 <small id="accMatchError" class="text-danger" style="display:none;">Account numbers do not match!</small>
                                             </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mb-4">
                                    <button type="button" class="btn btn-primary px-5" onclick="showStep2()">Next Section <i class="fas fa-arrow-right ms-2"></i></button>
                                </div>
                            </div>

                            <div id="step_2_container" style="display:none;">
                                <div class="card shadow-sm mb-4">
                                    <div class="card-header py-2 bg-secondary text-white">
                                        <strong>SECTION 3: ACADEMIC DETAILS</strong>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label>Faculty</label>
                                                <select name="faculty_id" id="faculty_id" class="form-control">
                                                    <option value="">Select Faculty</option>
                                                    <?php foreach ($faculties as $fac) { ?>
                                                        <option value="<?= $fac['id'] ?>"><?= htmlspecialchars($fac['name'], ENT_QUOTES, 'UTF-8', false) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Level</label>
                                                <select name="level_id" id="level_id" class="form-control">
                                                    <option value="">Select Level</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Program / Branch</label>
                                                <select name="program_id" id="program_id" class="form-control">
                                                    <option value="">Select Program</option>
                                                </select>
                                                <input type="hidden" name="branch" id="branch" value="">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Semester</label>
                                                <select name="semester" id="semester" class="form-control">
                                                    <option value="">Select Semester</option>
                                                </select>
                                                <input type="hidden" name="subject_name" id="subject_name" value="">
                                            </div>

                                            <div class="col-md-8">
                                                <label>Subject</label>
                                                <select name="subject_code[]" id="subject_code" class="form-control" multiple="multiple" style="width: 100%;" disabled>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-start mt-4 d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary px-5" onclick="showStep1()"><i class="fas fa-arrow-left me-2"></i> Back to Personal</button>
                                    <button type="button" class="btn btn-primary px-5" onclick="showStep3()">Next: Duty Selection <i class="fas fa-arrow-right ms-2"></i></button>
                                </div>
                            </div>

                            <div id="step_3_container" style="display:none;">
                                <!-- INTERNAL EXAMINER -->
                                <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                                    <div class="card-header py-3 bg-success text-white d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-tie me-2"></i>
                                            <strong class="text-uppercase">Internal Examiner Duty</strong>
                                        </div>
                                        <div class="custom-control custom-checkbox custom-checkbox-white">
                                            <input type="checkbox" class="duty-toggle" id="toggle_internal" data-target="internal_body">
                                            <label class="text-white small mb-0 fw-bold" for="toggle_internal" style="cursor: pointer;"> SELECT THIS DUTY</label>
                                        </div>
                                    </div>
                                    <div class="card-body p-4 duty-card-body" id="internal_body" style="opacity: 0.5; pointer-events: none; background: #fafafa;">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-muted small">ASSIGNED RESPONSIBILITY</label>
                                                <select name="duty_internal" id="duty_internal" class="form-control duty-select" disabled>
                                                    <option value="">Choose Duty Type...</option>
                                                    <!-- Populated via JS -->
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-muted small">EXAMINER NAME (IF APPLICABLE)</label>
                                                <input type="text" name="internal_examiner_name" class="form-control" placeholder="Enter full name" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- EXTERNAL EXAMINER -->
                                <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                                    <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-graduate me-2"></i>
                                            <strong class="text-uppercase">External Examiner Duty</strong>
                                        </div>
                                        <div class="custom-control custom-checkbox custom-checkbox-white">
                                            <input type="checkbox" class="duty-toggle" id="toggle_external" data-target="external_body">
                                            <label class="text-white small mb-0 fw-bold" for="toggle_external" style="cursor: pointer;"> SELECT THIS DUTY</label>
                                        </div>
                                    </div>
                                    <div class="card-body p-4 duty-card-body" id="external_body" style="opacity: 0.5; pointer-events: none; background: #fafafa;">
                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <label class="form-label fw-bold text-muted small">ASSIGNED RESPONSIBILITY</label>
                                                <select name="duty_external" id="duty_external" class="form-control duty-select" disabled>
                                                    <option value="">Choose Duty Type...</option>
                                                    <!-- Populated via JS -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- LAB EXAMINER -->
                                <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                                    <div class="card-header py-3 bg-info text-white d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-flask me-2"></i>
                                            <strong class="text-uppercase">Lab Examiner Duty</strong>
                                        </div>
                                        <div class="custom-control custom-checkbox custom-checkbox-white">
                                            <input type="checkbox" class="duty-toggle" id="toggle_lab" data-target="lab_body">
                                            <label class="text-white small mb-0 fw-bold" for="toggle_lab" style="cursor: pointer;"> SELECT THIS DUTY</label>
                                        </div>
                                    </div>
                                    <div class="card-body p-4 duty-card-body" id="lab_body" style="opacity: 0.5; pointer-events: none; background: #fafafa;">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-muted small">ASSIGNED RESPONSIBILITY</label>
                                                <select name="duty_lab" id="duty_lab" class="form-control duty-select" disabled>
                                                    <option value="">Choose Duty Type...</option>
                                                    <!-- Populated via JS -->
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-muted small">EXAMINER NAME (IF APPLICABLE)</label>
                                                <input type="text" name="lab_examiner_name" class="form-control" placeholder="Enter full name" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-start mt-4 d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary px-5" onclick="showStep2()"><i class="fas fa-arrow-left me-2"></i> Back to Academic</button>
                                    <button type="button" class="btn btn-primary px-5" onclick="showStep4()">Next: Claim Details <i class="fas fa-arrow-right ms-2"></i></button>
                                </div>
                            </div>

                            <div id="step_4_container" style="display:none;">
                                <div class="card shadow-sm mb-4" id="section_ta">
                                <div class="card-header py-2 bg-primary text-white">
                                    <strong>SECTION A: TRAVELLING ALLOWANCE</strong>
                                </div>

                                <div class="card-body p-3">

                                    <?php 
                                    $journeys = [
                                        1 => 'JOURNEY FROM',
                                        3 => 'JOURNEY TO'
                                    ];
                                    foreach ($journeys as $i => $title) { 
                                        $isDisabled = ($i == 3) ? 'disabled style="background-color: #e9ecef;"' : '';
                                    ?>
                                        <div class="border rounded p-3 mb-3 bg-light">
                                            <h6 class="text-primary fw-bold mb-2"><?= $title ?></h6>

                                            <div class="row g-3">

                                                <div class="col-md-3">
                                                    <label>Mode of Journey</label>
                                                    <select name="mode_of_journey_<?= $i ?>" id="mode_<?= $i ?>" class="form-control calcA-trigger mode-select" data-index="<?= $i ?>" <?= $isDisabled ?>>
                                                        <option value="">Select</option>
                                                        <option>Car</option>
                                                        <option>Scooter/Motorcycle</option>
                                                        <option>Local Conveyance</option>
                                                        <option>Bus</option>
                                                        <option>Train</option>
                                                        <option>Flight</option>
                                                        <option>Taxi</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Class of Travel</label>
                                                    <div id="class_wrapper_<?= $i ?>">
                                                        <input type="text" name="class_of_travel_<?= $i ?>" id="class_<?= $i ?>"
                                                            class="form-control calcA-trigger" <?= $isDisabled ?>>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Date</label>
                                                    <input type="date" name="journey_date_<?= $i ?>" id="date_<?= $i ?>" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>From</label>
                                                    <select name="journey_from_<?= $i ?>" id="from_<?= $i ?>" class="form-control city-select" <?= $isDisabled ?>>
                                                        <option value="">Select City</option>
                                                        <?php foreach($gujarat_cities as $city): ?>
                                                            <option value="<?= $city ?>"><?= $city ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>To</label>
                                                    <select name="journey_to_<?= $i ?>" id="to_<?= $i ?>" class="form-control city-select" <?= $isDisabled ?>>
                                                        <option value="">Select City</option>
                                                        <?php foreach($gujarat_cities as $city): ?>
                                                            <option value="<?= $city ?>"><?= $city ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-3" id="dist_wrapper_<?= $i ?>">
                                                    <label>Distance (KM)</label>
                                                    <input type="number" name="distance_km_<?= $i ?>" id="dist_<?= $i ?>" class="form-control calcA-trigger" <?= $isDisabled ?>>
                                                </div>

                                                <div class="col-md-3" id="vehicle_no_wrapper_<?= $i ?>" style="display:none;">
                                                    <label>Vehicle No.</label>
                                                    <input type="text" id="j_vehicle_no_<?= $i ?>" class="form-control text-uppercase j-vehicle-no" placeholder="Enter No." oninput="this.value = this.value.toUpperCase()" pattern="^[A-Za-z]{2}[0-9]{1,2}[A-Za-z]{1,2}[0-9]{4}$" title="Please enter a valid vehicle number format like GJ01AB1234 without spaces" <?= $isDisabled ?>>
                                                </div>


                                                <div class="col-md-3">
                                                    <label>Fare Paid</label>
                                                    <input type="number" name="fare_paid_<?= $i ?>" id="fare_<?= $i ?>" class="form-control calcA" <?= $isDisabled ?>>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Total TA Amount (A)</label>
                                            <input type="number" id="total_ta_amount_a"
                                                class="form-control fw-bold text-primary" readonly>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card shadow-sm mb-4" id="section_da">
                                <div class="card-header py-2 bg-primary text-white">
                                    <strong>SECTION B: DAILY ALLOWANCE</strong>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label>No. of Days</label>
                                            <input type="number" name="da_no_of_days" id="da_no_of_days"
                                                class="form-control calcB">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Rate / Day</label>
                                            <select name="da_rate_per_day" id="da_rate_per_day" class="form-control calcB">
                                                <option value="0">Select Rate</option>
                                                <option value="200">Up to 50km (₹200/day)</option>
                                                <option value="400">More than 50km (₹400/day)</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Total DA (B)</label>
                                            <input type="number" name="total_da_amount_b" id="total_da_amount_b"
                                                class="form-control fw-bold text-primary" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-sm mb-4" id="section_honorarium">
                                <div class="card-header py-2 bg-primary text-white">
                                    <strong>SECTION C: HONORARIUM</strong>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label>No. of Days / Units</label>
                                            <input type="number" name="hon_days" id="hon_days"
                                                class="form-control calcC" value="1">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Rate / Day / Unit</label>
                                            <input type="number" name="hon_rate" id="hon_rate" class="form-control calcC" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Total Honorarium (C)</label>
                                            <input type="number" name="total_honorarium_amount_c"
                                                id="total_honorarium_amount_c" class="form-control fw-bold text-primary"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-sm mb-4">
                                <div class="card-header py-2 bg-primary text-white">
                                    <strong>SECTION D: ACCOMMODATION</strong>
                                </div>

                                <div class="card-body p-3">
                                    <div class="row g-3">

                                        <div class="col-md-3">
                                            <label>No. of Days</label>
                                            <input type="number" name="acc_days" id="acc_days"
                                                class="form-control calcD">
                                        </div>

                                        <div class="col-md-3">
                                            <label>Actual Total Charge Paid</label>
                                            <input type="number" name="acc_rate" id="acc_rate"
                                                class="form-control calcD">
                                        </div>

                                        <div class="col-md-3">
                                            <label>Total Accommodation (D)</label>
                                            <input type="number" name="total_accommodation_amount_d"
                                                id="total_accommodation_amount_d"
                                                class="form-control fw-bold text-primary" readonly>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-sm mb-4">
                                <div class="card-header py-2 bg-primary text-white">
                                    <strong>SECTION 6: GROSS TOTAL & DECLARATION</strong>
                                </div>

                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label>Gross Total Amount</label>
                                            <input type="number" name="gross_total_amount" id="gross_total_amount"
                                                class="form-control fw-bold text-danger" readonly>
                                        </div>
                                    </div>

                                    <div class="mt-4 p-3 bg-light border rounded">
                                        <h6 class="fw-bold mb-3">This is to Certify that: —</h6>
                                        
                                        <div id="cert_rail_bus_wrapper" class="form-check mb-2" style="display:none;">
                                            <input class="form-check-input" type="checkbox" name="cert_rail_bus" id="cert_rail_bus" value="1">
                                            <label class="form-check-label" for="cert_rail_bus">
                                                I have travelled by Rail/Bus <input type="text" id="cert_class" class="form-control d-inline-block mx-1 text-center fw-bold" style="width: 120px; height: 30px; background-color: #f8f9fa;" readonly placeholder="Class"> class / Bus-luxury/ordinary. (Attach copy of Rail Ticket if travelled by AC & upper class or Luxury Bus.)
                                            </label>
                                        </div>

                                        <div id="cert_air_wrapper" class="form-check mb-2" style="display:none;">
                                            <input class="form-check-input" type="checkbox" name="cert_air" id="cert_air" value="1">
                                            <label class="form-check-label" for="cert_air">
                                                I have travelled by Air & the air fare claimed is limited to Economic Class. (Attach copy of air ticket & boarding pass.)
                                            </label>
                                        </div>

                                        <div id="cert_car_wrapper" class="mb-3" style="display:none;">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="cert_car" id="cert_car" value="1">
                                                <label class="form-check-label" for="cert_car">
                                                    I have travelled by my own car with vehicle No. 
                                                    <input type="text" name="vehicle_no" id="cert_vehicle_no" class="form-control d-inline-block mx-1" style="width: 150px; height: 30px; text-transform: uppercase;" placeholder="Enter No." oninput="this.value = this.value.toUpperCase()" pattern="^[A-Za-z]{2}[0-9]{1,2}[A-Za-z]{1,2}[0-9]{4}$" title="Please enter a valid vehicle number format like GJ01AB1234 without spaces" readonly>
                                                    & it is 

                                                    <input type="text" name="fuel_type" id="cert_fuel_type" class="form-control d-inline-block mx-1 text-center fw-bold" style="width: 120px; height: 30px; background-color: #f8f9fa;" readonly placeholder="Fuel Type">
                                                    vehicle. (Attach Copy of R/C book.)
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="cert_general" checked required>
                                            <label class="form-check-label" for="cert_general">
                                                I confirm that this amount is not claimed elsewhere, and if it is found at any stage that the above claim/part of the claim paid/received to me due to mistake; I undertake to refund same to the University.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <div class="text-start mt-4 d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary px-5" onclick="showStep3()"><i class="fas fa-arrow-left me-2"></i> Back to Duty</button>
                                    <button type="submit" name="submit" class="btn btn-primary px-5">Submit TADA Form <i class="fas fa-check-circle ms-2"></i></button>
                                </div>
                            </div> <!-- End Step 4 Container -->

                            </form>
                    </div>

                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>

    <script>
        $(document).ready(function() {
            $('#panModal').modal('show');

            // Auto-fill form when PAN is entered directly in Section 1
            $('#pan_card').on('input', function() {
                let pan = $(this).val().trim().toUpperCase();
                if(pan.length === 10) {
                    const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
                    if (panRegex.test(pan)) {
                        fetch('api/check-pan.php?pan=' + pan)
                            .then(response => response.json())
                            .then(res => {
                                if (res.status === 'success') {
                                    let d = res.data;
                                    if (d.title) $('#title').val(d.title);
                                    if (d.full_name) $('#full_name').val(d.full_name);
                                    if (d.phone_no) $('#phone_no').val(d.phone_no);
                                    if (d.email_id) $('#email_id').val(d.email_id);
                                    if (d.designation) $('#designation').val(d.designation);
                                    if (d.institute_name) $('#institute_name').val(d.institute_name);
                                    if (d.institute_address) $('#institute_address').val(d.institute_address);
                                    if (d.bank_name) $('#bank_name').val(d.bank_name);
                                    if (d.bank_branch) $('#bank_branch').val(d.bank_branch);
                                    if (d.bank_acc_type) $('#bank_acc_type').val(d.bank_acc_type);
                                    if (d.account_no) {
                                        $('#account_no').val(d.account_no);
                                        $('#account_no_confirm').val(d.account_no);
                                    }
                                    if (d.ifsc_code) $('#ifsc_code').val(d.ifsc_code);
                                    
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Details auto-filled from previous PAN records',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                }
                            })
                            .catch(err => console.error(err));
                    }
                }
            });
        });

        function skipPanCheck() {
            $('#panModal').modal('hide');
        }

        function checkPan() {
            let pan = $('#initial_pan').val().trim().toUpperCase();
            const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;

            if (pan === "") {
                alert("Please enter a PAN number");
                return;
            }

            if (!panRegex.test(pan)) {
                $('#panError').html("Invalid PAN format! (Expected: 5 Letters + 4 Digits + 1 Letter)").show();
                return;
            }

            fetch('api/check-pan.php?pan=' + pan)
                .then(response => response.json())
                .then(res => {
                    if (res.status === 'success') {
                        let d = res.data;
                        // Pre-filled but editable fields
                        if (d.title) $('#title').val(d.title);
                        $('#full_name').val(d.full_name).prop('readonly', false);
                        $('#phone_no').val(d.phone_no).prop('readonly', false);
                        $('#email_id').val(d.email_id).prop('readonly', false);
                        
                        // Keep PAN locked to current session check
                        $('#pan_card').val(d.pan_card).prop('readonly', true);
                        
                        // Editable fields (pre-filled)
                        $('#designation').val(d.designation);
                        $('#institute_name').val(d.institute_name);
                        $('#institute_address').val(d.institute_address);

                        // Bank details
                        $('#bank_name').val(d.bank_name);
                        $('#bank_branch').val(d.bank_branch);
                        $('#bank_acc_type').val(d.bank_acc_type);
                        $('#account_no').val(d.account_no);
                        $('#account_no_confirm').val(d.account_no);
                        $('#ifsc_code').val(d.ifsc_code);
                        
                        // Note: Academic fields (Faculty, Level, Program, Semester, Subjects) 
                        // are intentionally left empty for the user to select fresh for a new form.
                    } else if (res.status === 'not_found') {
                        $('#pan_card').val(pan);
                        // Automatically proceeds to full form
                    }
                    $('#panModal').modal('hide');
                })
                .catch(err => {
                    console.error(err);
                    alert("Error checking PAN");
                });
        }
        
        // Duty Data Grouped as requested: Internal, External, Lab
        const dutyInternal = [
            { type: "Center-in-charge", rate: 350 },
            { type: "Squad Member / Sr Supervisor", rate: 300 },
            { type: "Jr. Supervisor", rate: 250 },
            { type: "Assessment (100 marks)", rate: 20 },
            { type: "Assessment (50 marks)", rate: 10 },
            { type: "OMR sheet Assessment", rate: 5 },
            { type: "Internal Examiner (Practical/Viva)", rate: 300 },
            { type: "Internal Examiner (PG Dissertation)", rate: 500 },
            { type: "Supervisor (Ph.D. Review)", rate: 1500 }
        ];

        const dutyExternal = [
            { type: "Manuscript (Diploma & UG)", rate: 1000 },
            { type: "Manuscript (PG & Ph.D)", rate: 1200 },
            { type: "External Examiner (Practical/Viva)", rate: 400 },
            { type: "External Examiner (PG Dissertation)", rate: 1500 },
            { type: "External Expert (Ph.D. Review)", rate: 2000 },
            { type: "Thesis Evaluator (National)", rate: 5000 },
            { type: "Thesis Evaluator (International)", rate: 8000 }
        ];

        const dutyLab = [
            { type: "Lab supportive staff (Practical/Viva)", rate: 200 }
        ];

        // Populate selects on load
        function populateDuties() {
            dutyInternal.forEach(d => $('#duty_internal').append(`<option value="${d.type}" data-rate="${d.rate}">${d.type}</option>`));
            dutyExternal.forEach(d => $('#duty_external').append(`<option value="${d.type}" data-rate="${d.rate}">${d.type}</option>`));
            dutyLab.forEach(d => $('#duty_lab').append(`<option value="${d.type}" data-rate="${d.rate}">${d.type}</option>`));
        }
        populateDuties();

        $(document).on('change', '.duty-toggle', function() {
            const isChecked = $(this).is(':checked');
            const targetId = $(this).data('target');
            const $targetBody = $('#' + targetId);

            if (isChecked) {
                // Enable target body visually
                $targetBody.css({ 'opacity': '1', 'pointer-events': 'auto' });
                // Initially enable all inputs/selects in the body
                $targetBody.find('input, select').prop('disabled', false);
            } else {
                // Disable target body visually and reset values
                $targetBody.css({ 'opacity': '0.5', 'pointer-events': 'none' });
                $targetBody.find('input, select').prop('disabled', true).val('');
                
                // If nothing checked, reset hon_rate
                if ($('.duty-toggle:checked').length === 0) {
                    $('#hon_rate').val(0).trigger('change');
                }
            }

            // Sync interactions and TA/DA locking
            syncDutyInteractions();
        });

        function syncDutyInteractions() {
            const isExternalChecked = $('#toggle_external').is(':checked');
            const isInternalChecked = $('#toggle_internal').is(':checked');
            const isLabChecked = $('#toggle_lab').is(':checked');

            // --- Duty Component Interactions ---
            if (isExternalChecked) {
                // If External is checked, disable Internal and Lab duty dropdowns but keep name inputs enabled (if checked)
                if (isInternalChecked) {
                    $('#duty_internal').prop('disabled', true).val('');
                    $('input[name="internal_examiner_name"]').prop('disabled', false);
                }
                if (isLabChecked) {
                    $('#duty_lab').prop('disabled', true).val('');
                    $('input[name="lab_examiner_name"]').prop('disabled', false);
                }
            } else {
                // If External is NOT checked, keep Internal/Lab dropdowns enabled (if checked)
                if (isInternalChecked) {
                    $('#duty_internal').prop('disabled', false);
                }
                if (isLabChecked) {
                    $('#duty_lab').prop('disabled', false);
                }
            }

            // --- TA/DA Locking Logic ---
            // Rule: Lock TA/DA ONLY if (Internal OR Lab) is selected AND External is NOT selected.
            // If External is selected (even with others), TA/DA should be open.
            let lockTADA = (isInternalChecked || isLabChecked) && !isExternalChecked;

            const $taSection = $('#section_ta');
            const $daSection = $('#section_da');

            if (lockTADA) {
                $taSection.find('input:not([readonly]), select').prop('disabled', true).val('');
                $('#total_ta_amount_a').val(0);
                $daSection.find('input:not([readonly])').prop('disabled', true).val('0');
                $daSection.find('select').prop('disabled', true).val('0');
                $('#total_da_amount_b').val(0);

                $taSection.css({ 'opacity': '0.6', 'pointer-events': 'none', 'background-color': '#f8f9fa' });
                $daSection.css({ 'opacity': '0.6', 'pointer-events': 'none', 'background-color': '#f8f9fa' });
            } else {
                $taSection.find('input, select').prop('disabled', false);
                $daSection.find('input, select').prop('disabled', false);

                $taSection.css({ 'opacity': '1', 'pointer-events': 'auto', 'background-color': '' });
                $daSection.css({ 'opacity': '1', 'pointer-events': 'auto', 'background-color': '' });
                
                // Re-trigger mode logic to ensure certifications/vehicle fields are correct
                $('.mode-select').trigger('change');
            }
            
            // Recalculate totals
            if (window.calcTA) window.calcTA();
            if (window.calcB) window.calcB();
            if (window.calcGross) window.calcGross();
        }

        $(document).on('change', '.duty-select', function() {
            const $selected = $(this).find(':selected');
            const rate = $selected.data('rate') || 0;
            
            // Update honorarium rate
            if (rate > 0) {
                $('#hon_rate').val(rate).trigger('change');
            }
        });

        // Subject Code Select2
        $('#subject_code').select2({
            tags: true,
            multiple: true,
            placeholder: "Select or type Subjects",
            allowClear: true
        });

        $('.city-select').select2({
            placeholder: "Select City",
            width: '100%'
        });

        // Distance Lookup Database (Distances from Bhavnagar)
        const gmuDistances = {
            "Ahmedabad": 170, "Surat": 360, "Vadodara": 200, "Rajkot": 175, "Gandhinagar": 200,
            "Jamnagar": 260, "Junagadh": 190, "Bhuj": 340, "Gandhidham": 300, "Morbi": 190,
            "Mehsana": 240, "Surendranagar": 120, "Botad": 75, "Amreli": 120, "Anand": 160,
            "Nadiad": 175, "Bharuch": 300, "Ankleshwar": 310, "Navsari": 380, "Vapi": 420,
            "Valsad": 400, "Sihor": 20, "Palitana": 50, "Talaja": 55, "Mahuva": 95, "Alang": 50,
            "Songadh": 25, "Gariyadhar": 80, "Vallabhipur": 35, "Umrala": 45
        };

        $(document).on('change', '.city-select', function() {
            let i = $(this).attr('id').split('_')[1];
            let from = $('#from_' + i).val();
            let to = $('#to_' + i).val();
            let distField = $('#dist_' + i);

            if (from && to) {
                let distance = 0;
                if (from === "Bhavnagar" && gmuDistances[to]) distance = gmuDistances[to];
                else if (to === "Bhavnagar" && gmuDistances[from]) distance = gmuDistances[from];

                if (distance > 0) {
                    distField.val(distance).trigger('input');
                }
            }
        });

        // Semester Dynamic Cascade
        $('#program_id').change(function() {
            let pid = $(this).val();
            let $semSelect = $('#semester');
            let $subSelect = $('#subject_code');
            let progName = $(this).find('option:selected').text();
            
            $semSelect.empty().append('<option value="">Select Semester</option>');
            $subSelect.empty().prop('disabled', true);
            $('#subject_name').val('');
            $('#branch').val(pid ? progName : '');
            
            if (pid) {
                fetch(`api/get-semesters.php?program_id=${pid}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            let semOptions = '<option value="">Select Semester</option>';
                            data.data.forEach(item => {
                                semOptions += `<option value="${item.sem}">${item.sem}</option>`;
                            });
                            $semSelect.html(semOptions);
                        }
                    });
            }
        });

        // Subject Code Cascade - Trigger strictly on Semester change
        $('#semester').change(function() {
            let pid = $('#program_id').val();
            let sem = $(this).val();
            let $subSelect = $('#subject_code');
            
            $subSelect.empty();
            $('#subject_name').val('');
            
            if (pid && sem) {
                $subSelect.prop('disabled', false);
                fetch(`api/get-subjects.php?program_id=${pid}&sem=${sem}`)
                    .then(res => res.json())
                    .then(data => {
                        window.subjectDataMap = {};
                        if (data.status === 'success') {
                            let options = '';
                            data.data.forEach(item => {
                                options += `<option value="${item.subject_code}">${item.subject_code} - ${item.subject_name}</option>`;
                                window.subjectDataMap[item.subject_code] = item.subject_name;
                            });
                            $subSelect.html(options);
                        }
                    });
            } else {
                $subSelect.prop('disabled', true);
            }
        });

        $('#subject_code').change(function() {
            let selectedCodes = $(this).val();
            if (Array.isArray(selectedCodes)) {
                let subjectNames = [];
                selectedCodes.forEach(code => {
                    if (window.subjectDataMap && window.subjectDataMap[code]) {
                        subjectNames.push(window.subjectDataMap[code]);
                    } else {
                        subjectNames.push(code); // Fallback for manual inputs
                    }
                });
                $('#subject_name').val(subjectNames.join(', '));
            } else {
                $('#subject_name').val('');
            }
        });

        // Cascading Dropdown Logic
        $('#faculty_id').change(function() {
            let fid = $(this).val();
            $('#level_id').html('<option value="">Select Level</option>');
            $('#program_id').html('<option value="">Select Program</option>');
            $('#branch').val('');
            
            if (fid) {
                fetch('api/get-levels.php?faculty_id=' + fid)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            let options = '<option value="">Select Level</option>';
                            data.data.forEach(item => {
                                options += `<option value="${item.id}">${item.name}</option>`;
                            });
                            $('#level_id').html(options);
                        }
                    });
            }
        });

        $('#level_id').change(function() {
            let fid = $('#faculty_id').val();
            let lid = $(this).val();
            $('#program_id').html('<option value="">Select Program</option>');
            $('#branch').val('');

            if (fid && lid) {
                fetch(`api/get-programs.php?faculty_id=${fid}&level_id=${lid}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            let options = '<option value="">Select Program</option>';
                            data.data.forEach(item => {
                                options += `<option value="${item.id}">${item.name}</option>`;
                            });
                            $('#program_id').html(options);
                        }
                    });
            }
        });

        // Moved submit listener to the end

        // Auto-fill Journey 3 as reverse of Journey 1 (Journey 2 is free)
        function autoFillJourney3() {
            let from1  = $('#from_1').val();
            let to1    = $('#to_1').val();
            let dist1  = $('#dist_1').val();
            let mode1  = $('#mode_1').val();
            let class1 = $('#class_1').val();
            let fare1  = $('#fare_1').val();
            let date1  = $('#date_1').val();
            let veh1   = $('#j_vehicle_no_1').val();

            // Reverse-fill From and To first, because triggering change on them
            // auto-calculates the distance based on default routes.
            if (from1 && to1) {
                $('#from_3').val(to1).trigger('change');
                $('#to_3').val(from1).trigger('change');
            }

            // Sync structural fields to J3 (Journey To) AFTER setting From/To
            // This ensures we override any auto-calculated city distance with the explicit dist1.
            $('#date_3').val(date1);
            $('#dist_3').val(dist1).trigger('input');
            $('#mode_3').val(mode1).trigger('change'); 
            $('#class_3').val(class1).trigger('change');
            $('#fare_3').val(fare1).trigger('input');
            $('#j_vehicle_no_3').val(veh1).trigger('input');
            
            // Recalculate everything once J3 fields are updated
            if (window.calcTA) window.calcTA();
            
            // Re-enforce disabled status for Journey 3 (Return)
            $('#from_3, #to_3, #dist_3, #mode_3, #class_3, #fare_3, #j_vehicle_no_3').prop('disabled', true).css('background-color', '#e9ecef');
        }

        // Dynamic Class of Travel based on Mode
        $(document).on('change', '.mode-select', function() {
            let i = $(this).data('index');
            let mode = $(this).val();
            let wrapper = $('#class_wrapper_' + i);
            let distWrapper = $('#dist_wrapper_' + i);
            let isDisabled = (i == 3);

            // Hide Distance for specified modes
            const hideDistModes = ['Local Conveyance', 'Bus', 'Train', 'Flight', 'Taxi'];
            if (hideDistModes.includes(mode)) {
                distWrapper.hide();
                $('#dist_' + i).val(0);
            } else {
                distWrapper.show();
            }

            if (mode === 'Car') {
                let currentVal = $('#class_' + i).val() || '';
                let selectHtml = `<select name="class_of_travel_${i}" id="class_${i}" class="form-control calcA-trigger" ${isDisabled ? 'disabled style="background-color: #e9ecef;"' : ''}>
                                    <option value="">Select Fuel</option>
                                    <option value="Petrol" ${currentVal === 'Petrol' ? 'selected' : ''}>Petrol</option>
                                    <option value="Diesel" ${currentVal === 'Diesel' ? 'selected' : ''}>Diesel</option>
                                    <option value="CNG" ${currentVal === 'CNG' ? 'selected' : ''}>CNG</option>
                                  </select>`;
                wrapper.html(selectHtml);
            } else {
                let currentVal = $('#class_' + i).val() || '';
                if (['Petrol', 'Diesel', 'CNG'].includes(currentVal)) currentVal = '';
                let inputHtml = `<input type="text" name="class_of_travel_${i}" id="class_${i}" class="form-control calcA-trigger" value="${currentVal}" ${isDisabled ? 'disabled style="background-color: #e9ecef;"' : ''}>`;
                wrapper.html(inputHtml);
            }
            calcTA();

            // --- Certification Visibility Logic ---
            let allModes = [];
            let isCar = false;
            $('.mode-select').each(function() { 
                let m = $(this).val();
                if(m) allModes.push(m);
                if(m === 'Car') isCar = true;
            });
            
            // Show vehicle input directly in journey section when mode is Car
            let vehWrapper = $('#vehicle_no_wrapper_' + i);
            if (mode === 'Car') {
                vehWrapper.show();
            } else {
                vehWrapper.hide();
                $('#j_vehicle_no_' + i).val('');
                if (i === 1) { $('#cert_vehicle_no').val(''); }
            }

            // Auto-tick Certification (#cert_car) if any mode is Car
            if (isCar) {
                $('#cert_car_wrapper').show();
                $('#cert_car').prop('checked', true).trigger('change');
            } else {
                $('#cert_car_wrapper').hide();
                $('#cert_car').prop('checked', false).trigger('change');
                $('#cert_vehicle_no').val('');
            }
            
            if (allModes.includes('Bus') || allModes.includes('Train')) {
                $('#cert_rail_bus_wrapper').show();
            } else {
                $('#cert_rail_bus_wrapper').hide();
                $('#cert_rail_bus').prop('checked', false);
            }

            if (allModes.includes('Flight')) {
                $('#cert_air_wrapper').show();
            } else {
                $('#cert_air_wrapper').hide();
                $('#cert_air').prop('checked', false);
            }

            if (allModes.includes('Car')) {
                $('#cert_car_wrapper').show();
            } else {
                $('#cert_car_wrapper').hide();
                $('#cert_car').prop('checked', false);
            }
        });

        // Sync Journey Class/Fuel to Certification
        $(document).on('change input', 'select[id^="class_"], input[id^="class_"]', function() {
            let i = $(this).attr('id').split('_')[1];
            let val = $(this).val();
            let mode = $('#mode_' + i).val();
            
            if (mode === 'Bus' || mode === 'Train') {
                if (val) {
                    $('#cert_class').val(val);
                    $('#cert_rail_bus').prop('checked', true);
                }
            } else if (mode === 'Car') {
                if (val) {
                    $('#cert_fuel_type').val(val);
                    $('#cert_car').prop('checked', true);
                }
            }
        });

        // Mandatory Vehicle No if Car is checked
        $('#cert_car').change(function() {
            if ($(this).is(':checked')) {
                $('#cert_vehicle_no').prop('required', true).addClass('border-danger');
            } else {
                $('#cert_vehicle_no').prop('required', false).removeClass('border-danger');
            }
        });

        // Mirror j_vehicle_no_1 typing directly to Section 6 certification
        $(document).on('input', '#j_vehicle_no_1', function() {
            $('#cert_vehicle_no').val($(this).val());
        });

        // Mirror j_vehicle_no_3 typing directly to Section 6 certification (if they type directly in 3)
        $(document).on('input', '#j_vehicle_no_3', function() {
            $('#cert_vehicle_no').val($(this).val());
        });

        // Trigger on load for prepopulated fields (especially for J3)
        $('.mode-select').trigger('change');

        // Trigger auto-fill when any Journey 1 field changes (delegated for dynamic class field)
        $(document).on('change blur input', '#from_1, #to_1, #dist_1, #mode_1, #date_1, #class_1, #fare_1, #j_vehicle_no_1', function() {

            autoFillJourney3();
        });

        function calcTA() {
            for(let i=1; i<=3; i++) {
                let distObj = document.getElementById('dist_' + i);
                let modeObj = document.getElementById('mode_' + i);
                let fareObj = document.getElementById('fare_' + i);
                if(distObj && modeObj && fareObj) {
                    let d = parseFloat(distObj.value) || 0;
                    let m = modeObj.value;
                    let rate = 0;
                    let isCalculated = false;

                    let classVal = document.getElementById('class_' + i).value;
                    if (m === 'Car') {
                        if (classVal === 'Petrol') { rate = 11; isCalculated = true; }
                        else if (classVal === 'Diesel') { rate = 10; isCalculated = true; }
                        else if (classVal === 'CNG') { rate = 6; isCalculated = true; }
                    }
                    else if (m === 'Scooter/Motorcycle') { rate = 2.5; isCalculated = true; }
                    
                    if (isCalculated) {
                        fareObj.value = (d * rate);
                        fareObj.readOnly = true;
                    } else {
                        fareObj.readOnly = false;
                        if (m === 'Local Conveyance') {
                            let f = parseFloat(fareObj.value) || 0;
                            if (f > 150) fareObj.value = 150;
                        }
                    }
                }
            }

            let total = 0;
            document.querySelectorAll('.calcA').forEach(i => {
                let v = parseFloat(i.value) || 0;
                total += v;
            });
            document.getElementById('total_ta_amount_a').value = total;
            calcGross();
        }

        $(document).on('input change', '.calcA, .calcA-trigger', function() {
            calcTA();
        });

        function calcB() {
            let d = parseFloat(document.getElementById('da_no_of_days').value) || 0;
            let r = parseFloat(document.getElementById('da_rate_per_day').value) || 0;
            document.getElementById('total_da_amount_b').value = d * r;
            calcGross();
        }
        $(document).on('input change', '.calcB', function() {
            calcB();
        });

        function calcC() {
            let d = parseFloat(document.getElementById('hon_days').value) || 0;
            let r = parseFloat(document.getElementById('hon_rate').value) || 0;
            document.getElementById('total_honorarium_amount_c').value = d * r;
            calcGross();
        }
        $(document).on('input change', '.calcC', function() {
            calcC();
        });

        function calcD() {
            let days = parseFloat(document.getElementById('acc_days').value) || 0;
            let actual = parseFloat(document.getElementById('acc_rate').value) || 0;
            let rateInput = document.getElementById('acc_rate');
            
            // Enable/Disable actual charge input based on days
            if (days > 0) {
                rateInput.readOnly = false;
                rateInput.style.backgroundColor = "";
            } else {
                rateInput.readOnly = true;
                rateInput.value = 0;
                rateInput.style.backgroundColor = "#e9ecef";
                actual = 0;
            }

            let maxAllowable = days * 1000;
            let finalAmt = 0;

            if (days > 0) {
                // Total is the actual charge, but capped at (Days * 1000)
                finalAmt = (actual > maxAllowable) ? maxAllowable : actual;
            }
            
            document.getElementById('total_accommodation_amount_d').value = finalAmt;
            calcGross();
        }
        $(document).on('input change', '.calcD', function() {
            calcD();
        });

        function calcGross() {
            let a = parseFloat(document.getElementById('total_ta_amount_a').value) || 0;
            let b = parseFloat(document.getElementById('total_da_amount_b').value) || 0;
            let c = parseFloat(document.getElementById('total_honorarium_amount_c').value) || 0;
            let d = parseFloat(document.getElementById('total_accommodation_amount_d').value) || 0;
            document.getElementById('gross_total_amount').value = a + b + c + d;
        }

        calcTA();
        calcB();
        calcC();
        calcD();

        // Account Number Matching
        $('#account_no_confirm, #account_no').on('input', function() {
            const acc = $('#account_no').val();
            const confirm = $('#account_no_confirm').val();
            if (acc !== confirm && confirm !== "") {
                $('#accMatchError').show();
            } else {
                $('#accMatchError').hide();
            }
        });

        $('#tadaForm').on('submit', function(e) {
            const acc = $('#account_no').val();
            const confirm = $('#account_no_confirm').val();
            if (acc !== confirm) {
                $('#step_1_container, #step_3_container, #step_4_container').hide();
                $('#step_2_container').show();
                Swal.fire('Error', 'Account numbers do not match!', 'error');
                e.preventDefault();
                return;
            }

            // Vehicle No mandatory if Car is selected
            if ($('#cert_car').is(':checked') && $('#cert_vehicle_no').val().trim() === "") {
                Swal.fire('Error', 'Please enter Vehicle Number for Car travel!', 'error');
                $('#cert_vehicle_no').focus();
                e.preventDefault();
                return;
            }

            // Centralized DOM Validation for Hidden Elements across Multistep Form
            if (!this.checkValidity()) {
                e.preventDefault(); // Stop submission
                
                // Find the very first invalid element across the entire form
                let firstInvalid = this.querySelector(':invalid');
                if (firstInvalid) {
                    let stepContainer = $(firstInvalid).closest('div[id^="step_"]');
                    if (stepContainer.length > 0) {
                        $('#step_1_container, #step_2_container, #step_3_container, #step_4_container').hide();
                        stepContainer.show();
                    }
                    firstInvalid.reportValidity();
                }
                return;
            }

            // If all validation passes, enable disabled fields for POST payload
            $(this).find(':disabled').prop('disabled', false);
        });

        <?php if (isset($_GET['success']) && isset($_SESSION['tada_success_id'])): 
            $sid = $_SESSION['tada_success_id'];
            unset($_SESSION['tada_success_id']);
            unset($_SESSION['tada_success']);
        ?>
            Swal.fire({
                title: 'Success!',
                text: 'TADA Form Submitted Successfully!',
                icon: 'success',
                confirmButtonText: 'View/Print Form'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'tada-form-print.php?id=<?= $sid ?>';
                } else {
                    window.location.href = 'tada-form-view.php';
                }
            });
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            Swal.fire({
                title: 'Error!',
                text: '<?= htmlspecialchars($_GET['error']) ?>',
                icon: 'error'
            });
        <?php endif; ?>
        function validateContainer(containerId) {
            let isValid = true;
            let container = document.getElementById(containerId);
            if (!container) return true;
            
            // Check all inputs, selects, textareas within the container
            let elements = container.querySelectorAll('input, select, textarea');
            for (let i = 0; i < elements.length; i++) {
                if (elements[i].disabled) continue; // Skip disabled fields
                if (!elements[i].checkValidity()) {
                    elements[i].reportValidity();
                    return false;
                }
            }
            
            // Step 1 Custom validations
            if (containerId === 'step_1_container') {
                const ifsc = $('#ifsc_code').val();
                if (ifsc.length !== 11) {
                    Swal.fire('Error', 'IFSC Code must be exactly 11 characters!', 'error');
                    $('#ifsc_code').focus();
                    return false;
                }
                
                const acc = $('#account_no').val();
                const confirm = $('#account_no_confirm').val();
                if (acc !== confirm) {
                    Swal.fire('Error', 'Account numbers do not match!', 'error');
                    $('#account_no').focus();
                    return false;
                }
            }
            
            return true;
        }

        function showStep1() {
            $('#step_2_container, #step_3_container, #step_4_container').fadeOut(300, function() {
                $('#step_1_container').fadeIn(300);
                window.scrollTo(0,0);
            });
        }

        function showStep2() {
            if (!validateContainer('step_1_container')) return;

            $('#step_1_container, #step_3_container, #step_4_container').fadeOut(300, function() {
                $('#step_2_container').fadeIn(300);
                window.scrollTo(0,0);
            });
        }

        function showStep3() {
            if (!validateContainer('step_2_container')) return;

            $('#step_1_container, #step_2_container, #step_4_container').fadeOut(300, function() {
                $('#step_3_container').fadeIn(300);
                window.scrollTo(0,0);
            });
        }

        function showStep4() {
            if (!validateContainer('step_3_container')) return;

            // Check if at least one duty is selected
            if ($('#duty_internal').val() === "" && $('#duty_external').val() === "" && $('#duty_lab').val() === "") {
                Swal.fire('Error', 'Please Select at least one Duty', 'error');
                return;
            }

            $('#step_1_container, #step_2_container, #step_3_container').fadeOut(300, function() {

                $('#step_4_container').fadeIn(300);
                window.scrollTo(0,0);
            });
        }
    </script>
</body>

</html>
