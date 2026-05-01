<?php
// 1. Process Logic FIRST (Before any output/includes)
include '../database/connect.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "GMAP - Registration";

// Reset form session data
if (isset($_GET['reset'])) {
    unset($_SESSION['old']);
    header("Location: registration.php");
    exit;
}

// Handle Form Submission
if (isset($_POST['register'])) {

    $_SESSION['old'] = $_POST; // Store old values

    $surname = trim($_POST['surname']);
    $student_name = trim($_POST['student_name']);
    $father_name = trim($_POST['father_name']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $otp = $_POST['otp'];
    $referral_code = !empty($_POST['referral_code']) ? trim($_POST['referral_code']) : null;

    // Password Length Check
    if (strlen($password) < 6 || strlen($password) > 10) {
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Password Length',
            'text' => 'Password must be between 6 and 10 characters long.'
        ];
        header("Location: registration.php");
        exit;
    }

    // Password Match Check
    if ($password !== $confirm) {
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Password Error',
            'text' => 'Passwords do not match.'
        ];
        header("Location: registration.php");
        exit;
    }

    if (!isset($_SESSION['otp_data'])) {

        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'OTP Missing',
            'text' => 'Please click Send OTP first.'
        ];
        header("Location: registration.php");
        exit;

    }

    if (time() > $_SESSION['otp_data']['expires']) {

        unset($_SESSION['otp_data']);

        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'OTP Expired',
            'text' => 'Your OTP has expired. Please request a new one.'
        ];
        header("Location: registration.php");
        exit;

    }

    if ($otp != $_SESSION['otp_data']['code']) {

        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Invalid OTP',
            'text' => 'Incorrect OTP entered.'
        ];
        header("Location: registration.php");
        exit;

    }

    // Check Referral Code (Only if provided)
    if ($referral_code !== null) {
        $check_ref = $con->prepare("SELECT id FROM tbl_referral_master WHERE referral_code = ? AND role_id = 6 AND is_active = 1 AND is_delete = 0");
        $check_ref->bind_param("s", $referral_code);
        $check_ref->execute();
        $check_ref->store_result();

        if ($check_ref->num_rows === 0) {
            $_SESSION['alert'] = [
                'type' => 'error',
                'title' => 'Invalid Referral Code',
                'text' => 'The referral code you entered is invalid for this portal.'
            ];
            header("Location: registration.php");
            exit;
        }
    }

    // Check Email Exists
    $check = $con->prepare("SELECT id FROM tbl_gmap_students WHERE email = ? AND is_active = 1 AND is_delete = 0");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Email Exists',
            'text' => 'This email is already registered.'
        ];
        header("Location: registration.php");
        exit;
    }

    // Insert Data
    $stmt = $con->prepare("
        INSERT INTO tbl_gmap_students
        (surname, student_name, father_name, mobile, email, password, referal_code)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssssss",
        $surname,
        $student_name,
        $father_name,
        $mobile,
        $email,
        $password,
        $referral_code
    );

    if ($stmt->execute()) {

        unset($_SESSION['old']);
        unset($_SESSION['otp_data']); // Corrected from session unset earlier

        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Registration Successful',
            'text' => 'Your account has been created successfully.',
            'redirect' => 'login.php'
        ];

    } else {

        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Database Error',
            'text' => 'Something went wrong. Please try again.'
        ];
    }
}

// 2. Load UI AFTER Logic
include './layout/auth/head.php';

// Old values
$old = $_SESSION['old'] ?? [];
?>

<div class="container py-4">
    <!-- Logo -->
    <div class="admin-logo">
        <img src="gmap-logo.png" alt="GMAP Logo">
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">

            <div class="card shadow-lg border-0 rounded p-4 p-md-5 position-relative overflow-hidden form-card">

                <!-- Heading -->
                <div class="text-center mb-4">
                    <h4 class="fw-bold mb-1">
                        <span style="color:#1e264a;">Gyanmanjari Admission Portal</span>
                        <span style="color:#bc2823;"> (GMAP)</span>
                    </h4>
                    <p class="text-muted mb-2">Registration Form</p>
                    <div class="mx-auto rounded-pill" style="width:70px;height:4px;background:#bc2823;"></div>
                </div>

                <!-- Notice Download Buttons -->
                <div class="text-center mb-4">
                    <div class="d-flex flex-wrap justify-content-center gap-2 mb-2">
                        <a href="gmap-notice.pdf" target="_blank" class="btn btn-sm text-white fw-semibold px-3 py-2 shadow-sm" style="background:#bc2823; border-radius: 50px; min-width: 180px;">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Download Notice
                        </a>
                        <a href="gmap-schedule.pdf" target="_blank" class="btn btn-sm btn-outline-dark fw-semibold px-3 py-2 shadow-sm" style="border-radius: 50px; min-width: 180px;">
                            <i class="bi bi-calendar-date me-1"></i> Download Schedule
                        </a>
                    </div>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="gmap-admission-procedure.pdf" target="_blank" class="btn btn-sm btn-outline-dark fw-semibold px-3 py-2 shadow-sm" style="border-radius: 50px; min-width: 180px;">
                            <i class="bi bi-info-circle me-1"></i> Admission Procedure
                        </a>
                        <a href="gmap-pg-admission-notice.pdf" target="_blank" class="btn btn-sm btn-outline-dark fw-semibold px-3 py-2 shadow-sm" style="border-radius: 50px; min-width: 180px;">
                            <i class="bi bi-megaphone me-1"></i> PG Admission Notice
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="">

                    <!-- Name as per Marksheet -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name as per Marksheet *</label>

                        <div class="row">

                            <!-- Surname -->
                            <div class="col-md-4 mb-2">
                                <input type="text" name="surname" class="form-control"
                                    value="<?= htmlspecialchars($old['surname'] ?? '') ?>" placeholder="Surname"
                                    required>
                            </div>

                            <!-- Student Name -->
                            <div class="col-md-4 mb-2">
                                <input type="text" name="student_name" class="form-control"
                                    value="<?= htmlspecialchars($old['student_name'] ?? '') ?>"
                                    placeholder="Student Name" required>
                            </div>

                            <!-- Father Name -->
                            <div class="col-md-4 mb-2">
                                <input type="text" name="father_name" class="form-control"
                                    value="<?= htmlspecialchars($old['father_name'] ?? '') ?>" placeholder="Father Name"
                                    required>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <!-- Mobile -->
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label fw-semibold">Mobile *</label>
                            <input type="text" name="mobile" class="form-control" pattern="[0-9]{10}" maxlength="10"
                                value="<?= htmlspecialchars($old['mobile'] ?? '') ?>" placeholder="Enter mobile number"
                                required>
                        </div>

                        <!-- Email -->
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email *</label>
                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($old['email'] ?? '') ?>" placeholder="Enter email address"
                                required>
                        </div>

                        <!-- Password -->
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label fw-semibold">Password *</label>
                            <input type="password" name="password" class="form-control" placeholder="Create password"
                                minlength="6" maxlength="10" required>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label fw-semibold">Confirm Password *</label>
                            <input type="password" name="confirm_password" class="form-control"
                                placeholder="Confirm password" minlength="6" maxlength="10" required>
                        </div>
                    </div>

                    <!-- Instruction -->
                    <small class="text-muted d-block mb-3">
                        After filling the form, click <strong>Send OTP</strong>.
                        OTP will be sent to your registered email. Enter it below and submit.
                    </small>

                    <!-- OTP Row -->
                    <div class="row g-2 align-items-end mb-3">
                        <div class="col-12 col-md-8">
                            <label class="form-label fw-semibold">Enter OTP *</label>
                            <input type="text" name="otp" class="form-control" maxlength="6" pattern="[0-9]{6}"
                                value="<?= htmlspecialchars($old['otp'] ?? '') ?>"
                                placeholder="Enter OTP received on email" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <button type="button" id="sendOtpBtn" class="btn btn-outline-danger w-100">
                                Send OTP
                            </button>

                            <small id="otpTimer" class="text-danger d-block mt-1"></small>
                        </div>
                    </div>

                    <!-- Referral Code Option -->
                    <div class="mb-3">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="referralSwitch" <?= !empty($old['referral_code']) ? 'checked' : '' ?>>
                            <label class="form-check-label fw-semibold" for="referralSwitch">I have a Referral Code</label>
                        </div>
                        <div id="referralInputContainer" style="<?= !empty($old['referral_code']) ? 'display: block;' : 'display: none;' ?>">
                            <input type="text" name="referral_code" id="referralCode" class="form-control"
                                value="<?= htmlspecialchars($old['referral_code'] ?? '') ?>"
                                placeholder="Enter referral code" <?= !empty($old['referral_code']) ? 'required' : '' ?>>
                        </div>
                    </div>

                    <!-- Consent Checkbox -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="consent" id="consent" value="1" required>

                        <label class="form-check-label" for="consent">
                            I hereby give my consent to communicate with me about new
                            initiatives of <strong>GMIU</strong>, through my Email ID and mobile number.
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit" name="register" class="btn w-100 fw-semibold text-white mb-3"
                        style="background:#bc2823;">
                        REGISTER & APPLY NOW
                    </button>

                    <!-- Refresh / Clear Form -->
                    <a href="registration.php?reset=1" class="btn w-100 fw-semibold mb-3"
                        style="border:1px solid #bc2823; color:#bc2823;">
                        RESET FORM
                    </a>

                    <!-- Already Account -->
                    <div class="text-center mt-2">
                        <small class="text-muted">
                            Already have an account?
                            <a href="login.php" class="fw-semibold text-decoration-none" style="color:#1e264a;">
                                <i class="bi bi-box-arrow-in-right"></i> Login Here
                            </a>
                        </small>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

<script>

    $(document).ready(function () {

        let timerInterval;

        // ===============================
        // CHECK TIMER ON PAGE LOAD
        // ===============================

        let expireTime = localStorage.getItem("gmapOtpExpire");

        if (expireTime) {

            let remaining = Math.floor((expireTime - Date.now()) / 1000);

            if (remaining > 0) {
                startTimer(remaining);
            } else {
                localStorage.removeItem("gmapOtpExpire");
            }
        }


        // ===============================
        // SEND OTP BUTTON
        // ===============================

        $("#sendOtpBtn").click(function () {

            let email = $("input[name='email']").val().trim();

            if (email === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Email Required',
                    text: 'Please enter your email first.'
                });
                return;
            }

            Swal.fire({
                title: 'Sending OTP...',
                text: 'Please wait while we send OTP to your email.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "send-mail.php",
                type: "POST",
                dataType: "json",
                data: {
                    email: email,
                    type: "otp",
                    otp_purpose: "registration"
                },

                success: function (res) {

                    Swal.close();

                    if (res.status === "success") {

                        Swal.fire({
                            icon: "success",
                            title: "OTP Sent",
                            text: "OTP has been sent to your email."
                        });

                        // store expiry time (10 minutes)
                        let expire = Date.now() + (10 * 60 * 1000);

                        localStorage.setItem("gmapOtpExpire", expire);

                        startTimer(600);

                    } else {

                        Swal.fire({
                            icon: "error",
                            title: "Mail Error",
                            text: res.message
                        });

                    }

                },

                error: function () {

                    Swal.close();

                    Swal.fire({
                        icon: "error",
                        title: "Server Error",
                        text: "Unable to send OTP right now."
                    });

                }

            });

        });



        // ===============================
        // TIMER FUNCTION
        // ===============================

        function startTimer(seconds) {

            $("#sendOtpBtn").hide();

            clearInterval(timerInterval);

            timerInterval = setInterval(function () {

                let minutes = Math.floor(seconds / 60);
                let secs = seconds % 60;

                if (secs < 10) secs = "0" + secs;

                $("#otpTimer").text(
                    "Resend OTP available in " + minutes + ":" + secs
                );

                seconds--;

                if (seconds < 0) {

                    clearInterval(timerInterval);

                    $("#otpTimer").text("");

                    $("#sendOtpBtn").show().text("Resend OTP");

                    localStorage.removeItem("gmapOtpExpire");

                }

            }, 1000);

        }

        // ===============================
        // REFERRAL SWITCH TOGGLE
        // ===============================
        $("#referralSwitch").change(function () {
            if ($(this).is(":checked")) {
                $("#referralInputContainer").slideDown();
                $("#referralCode").attr("required", true);
            } else {
                $("#referralInputContainer").slideUp();
                $("#referralCode").removeAttr("required");
            }
        });

    });

</script>

<?php include './layout/auth/endlink.php'; ?>