<?php
session_start();

if (isset($_SESSION['staff_id']) && strlen($_SESSION['staff_id']) > 0) {
    header("Location: index.php");
    exit();
} else {
    if (
        !isset($_SESSION['user']) ||
        !isset($_SESSION['user']['staff_id']) ||
        !isset($_SESSION['user']['role_id']) ||
        !isset($_SESSION['user']['email'])
    ) {
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

if (isset($_POST['btn-verify-otp'])) {

    $otp = trim($_POST['otp'] ?? '');

    // 1️⃣ Basic checks
    if (
        $otp === '' ||
        !isset($_SESSION['otp']) ||
        !isset($_SESSION['otp_expire'])
    ) {
        echo "<script>
            localStorage.removeItem('otp-flag');
        </script>";
        $_SESSION['status'] = "OTP expired or missing.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_redirect'] = 'login.php';
    }

    // 2️⃣ Expiry check (DIRECT TIMESTAMP CHECK)
    if (time() > $_SESSION['otp_expire']) {
        unset($_SESSION['otp'], $_SESSION['otp_expire']);
        echo "<script>
            localStorage.removeItem('otp-flag');
        </script>";
        $_SESSION['status'] = "OTP expired.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_redirect'] = 'login.php';
    }

    // 3️⃣ OTP match check
    if ($otp !== $_SESSION['otp']) {
        $_SESSION['status'] = "Invalid OTP.";
        $_SESSION['status_code'] = "error";
    }

    if ($otp == $_SESSION['otp']) {
        // ✅ SUCCESS
        unset($_SESSION['otp'], $_SESSION['otp_expire']);

        $_SESSION['staff_id'] = $_SESSION['user']['staff_id'];
        $_SESSION['role_id'] = $_SESSION['user']['role_id'];

        $_SESSION['status'] = "OTP Verification Successful!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_redirect'] = 'session-generate.php';
    }
    
    // if(1 == 1){
    //     $_SESSION['staff_id'] = $_SESSION['user']['staff_id'];
    //     $_SESSION['role_id'] = $_SESSION['user']['role_id'];

    //     $_SESSION['status'] = "OTP Verification Successful!";
    //     $_SESSION['status_code'] = "success";
    //     $_SESSION['status_redirect'] = 'index.php';
    // }
}


?>

<!DOCTYPE html>
<html>

<head>
    <?php include './include/head.php'; ?>
</head>

<body>
    <div class="login-wrap customscroll d-flex align-items-center flex-wrap justify-content-center pd-20">
        <div class="login-box bg-white box-shadow pd-30 border-radius-5">
            <img src="./src/images/logo-single.jpg" alt="login" class="login-img">
            <h2 class="text-center mb-30">OTP Verification</h2>
            <form method="POST" action="">

                <div class="input-group custom input-group-lg mb-3">
                    <input type="text" class="form-control" name="otp" placeholder="Enter OTP" maxlength="6" required>
                    <div class="input-group-append custom">
                        <span class="input-group-text">
                            <i class="fa fa-key" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <button type="submit" name="btn-verify-otp"
                                class="btn btn-outline-primary btn-lg btn-block">
                                Verify OTP
                            </button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

    <?php include './include/script.php'; // This should include the SweetAlert library ?>

    <?php
    if (
        isset($_SESSION['user']) &&
        isset($_SESSION['user']['staff_id']) &&
        isset($_SESSION['user']['role_id']) &&
        isset($_SESSION['user']['email'])
    ) {
        ?>
         <script>
            $(document).ready(function () {

                function setWithExpiry(key, value, ttl) {
                    const now = new Date();
                    const item = {
                        value: value,
                        expiry: now.getTime() + ttl
                    };
                    localStorage.setItem(key, value);
                }

                // 5 minutes = 5 * 60 * 1000

                const otpFlag = localStorage.getItem('otp-flag');
                if (otpFlag !== 'akkibro') {
                    // Show initial loader for 2.5 seconds ONLY if OTP hasn't been sent yet
                    swal({
                        title: 'Initializing...',
                        text: 'Please wait while the system loads.',
                        type: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        timer: 2500
                    });

                    setTimeout(function () {
                        $.ajax({
                            url: './extra/verification-otp-mail.php', // ✅ your backend file that calls smtp_mailer()
                            type: 'POST',
                            dataType: 'json',
                            beforeSend: function () {
                                swal({
                                    title: 'Sending...',
                                    text: 'Please wait while we send the OTP.',
                                    type: 'info',
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    setWithExpiry("otp-flag", "akkibro", 5 * 60 * 1000);
                                    swal({
                                        title: 'OTP Sent!',
                                        text: 'Check your email inbox for the OTP.',
                                        type: 'success',
                                        confirmButtonClass: 'btn btn-success margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    swal({
                                        title: 'Failed!',
                                        text: response.message || 'Could not send OTP. Please try again.',
                                        type: 'error',
                                        confirmButtonClass: 'btn btn-danger margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function () {
                                swal({
                                    title: 'Server Error!',
                                    text: 'Something went wrong while sending the OTP.',
                                    type: 'error',
                                    confirmButtonClass: 'btn btn-danger margin-5',
                                    buttonsStyling: false,
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }, 2500);
                }
            });

        </script>

    <?php } ?>

    <?php
    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
        ?>
        <script>
            swal({
                title: "<?php echo addslashes($_SESSION['status']); ?>",
                icon: "<?php echo addslashes($_SESSION['status_code']); ?>",
            });
        </script>
        <?php
        unset($_SESSION['status']);
        unset($_SESSION['status_code']);
    }
    ?>
</body>

</html>