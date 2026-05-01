<?php
$pageTitle = "GMAP - Forgot Password";
include './layout/auth/head.php';

$step = 1;

/* ================= CAPTURE EMAIL AFTER AJAX ================= */
if (isset($_GET['email'])) {
    $_SESSION['reset_email'] = $_GET['email'];
}

/* ================= STEP 2 - VERIFY OTP ================= */
if (isset($_POST['verify_otp'])) {

    if (
        isset($_SESSION['otp_data']) &&
        time() <= $_SESSION['otp_data']['expires'] &&
        $_POST['otp'] == $_SESSION['otp_data']['code']
    ) {

        $_SESSION['otp_verified'] = true;
        $step = 3;

    } else {

        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Invalid OTP',
            'text' => 'OTP incorrect or expired.'
        ];

        $step = 2;
    }
}

/* ================= STEP 3 - RESET PASSWORD ================= */
if (isset($_POST['reset_password']) && isset($_SESSION['otp_verified'])) {

    if (strlen($_POST['new_password']) < 6 || strlen($_POST['new_password']) > 10) {

        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Password Length',
            'text' => 'Password must be between 6 and 10 characters long.'
        ];
        $step = 3;

    } elseif ($_POST['new_password'] !== $_POST['confirm_password']) {

        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Mismatch',
            'text' => 'Passwords do not match.'
        ];
        $step = 3;

    } else {

        $password = $_POST['new_password'];

        $update = $con->prepare("
            UPDATE tbl_gmap_students
            SET password = ?
            WHERE email = ?
        ");
        $update->bind_param("ss", $password, $_SESSION['reset_email']);
        $update->execute();

        unset($_SESSION['otp']);
        unset($_SESSION['otp_expiration']);
        unset($_SESSION['otp_verified']);
        unset($_SESSION['reset_email']);

        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Success',
            'text' => 'Password updated successfully.',
            'redirect' => 'login.php'
        ];

        header("Location: forgot-password.php");
        exit;
    }
}

/* Maintain step */
if (isset($_SESSION['otp_verified'])) {
    $step = 3;
} elseif (isset($_SESSION['reset_email'])) {
    $step = 2;
}
?>

<div class="container">
    <!-- Logo -->
    <div class="admin-logo">
        <img src="gmap-logo.png" alt="GMAP Logo">
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5">

            <div class="card shadow-lg border-0 rounded p-4 position-relative overflow-hidden form-card">

                <!-- HEADING SAME AS LOGIN -->
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-dark">
                        <span style="color:#1e264a;">Gyanmanjari Admission Portal</span>
                        <span style="color:#bc2823;"> (GMAP)</span>
                    </h4>
                    <p class="text-muted mb-2">Reset Your Password</p>
                    <div class="mx-auto rounded-pill" style="width:70px;height:4px;background:#bc2823;"></div>
                </div>

                <?php if ($step == 1): ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Registered Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <button type="button" id="sendOtpBtn" class="btn w-100 fw-semibold text-white"
                            style="background:#bc2823;">
                            Send OTP
                        </button>
                    </form>

                <?php elseif ($step == 2): ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control"
                                value="<?= htmlspecialchars($_SESSION['reset_email']) ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Enter OTP</label>
                            <input type="text" name="otp" class="form-control" required>
                            <small class="text-muted">OTP valid for 10 minutes</small>
                        </div>

                        <button type="submit" name="verify_otp" class="btn w-100 fw-semibold text-white"
                            style="background:#bc2823;">
                            Verify OTP
                        </button>

                    </form>

                <?php elseif ($step == 3): ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control"
                                value="<?= htmlspecialchars($_SESSION['reset_email']) ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>
                            <input type="password" name="new_password" class="form-control" minlength="6" maxlength="10" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" minlength="6" maxlength="10" required>
                        </div>

                        <button type="submit" name="reset_password" class="btn w-100 fw-semibold text-white"
                            style="background:#bc2823;">
                            Update Password
                        </button>

                    </form>

                <?php endif; ?>

                <!-- BACK TO LOGIN ALWAYS VISIBLE -->
                <div class="text-center mt-4">
                    <small>
                        <a href="login.php" class="text-decoration-none" style="color:#1e264a;">
                            <i class="bi bi-arrow-left"></i> Back to Login
                        </a>
                    </small>
                </div>

            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {

        $("#sendOtpBtn").click(function () {

            let email = $("input[name='email']").val();

            if (email === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Email Required',
                    text: 'Please enter your registered email.'
                });
                return;
            }

            Swal.fire({
                title: 'Sending OTP...',
                text: 'Please wait',
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
                    otp_purpose: "forgot_password"
                },

                success: function (res) {

                    Swal.close();

                    if (res.status === "success") {

                        Swal.fire({
                            icon: "success",
                            title: "OTP Sent",
                            text: "OTP sent to your email."
                        }).then(() => {
                            location.href = "forgot-password.php?email=" + encodeURIComponent(email);
                        });

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

    });

</script>

<?php include './layout/auth/endlink.php'; ?>