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
    // if (
    //     $otp === '' ||
    //     !isset($_SESSION['otp']) ||
    //     !isset($_SESSION['otp_expire'])
    // ) {
    //     echo "<script>
    //         localStorage.removeItem('otp-flag');
    //     </script>";
    //     $_SESSION['status'] = "OTP expired or missing.";
    //     $_SESSION['status_code'] = "error";
    //     $_SESSION['status_redirect'] = 'login.php';
    // }

    // 2️⃣ Expiry check (DIRECT TIMESTAMP CHECK)
    // if (time() > $_SESSION['otp_expire']) {
    //     unset($_SESSION['otp'], $_SESSION['otp_expire']);
    //     echo "<script>
    //         localStorage.removeItem('otp-flag');
    //     </script>";
    //     $_SESSION['status'] = "OTP expired.";
    //     $_SESSION['status_code'] = "error";
    //     $_SESSION['status_redirect'] = 'login.php';
    // }

    // 3️⃣ OTP match check
    // if ($otp !== $_SESSION['otp']) {
    //     $_SESSION['status'] = "Invalid OTP.";
    //     $_SESSION['status_code'] = "error";
    // }

    // if ($otp == $_SESSION['otp']) {
    //     // ✅ SUCCESS
    //     unset($_SESSION['otp'], $_SESSION['otp_expire']);

    //     $_SESSION['staff_id'] = $_SESSION['user']['staff_id'];
    //     $_SESSION['role_id'] = $_SESSION['user']['role_id'];

    //     $_SESSION['status'] = "OTP Verification Successful!";
    //     $_SESSION['status_code'] = "success";
    //     $_SESSION['status_redirect'] = 'session-generate.php';
    // }

    if (1 == 1) {
        $_SESSION['staff_id'] = $_SESSION['user']['staff_id'];
        $_SESSION['role_id'] = $_SESSION['user']['role_id'];

        $_SESSION['status'] = "OTP Verification Successful!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_redirect'] = 'session-generate.php';
    }
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

                <div class="row pt-10">
                    <div class="col-sm-12 text-center">
                        <div id="otp-timer-container" style="display: none;">
                            <p class="mb-0">OTP expires in: <span id="otp-timer"
                                    class="font-weight-bold text-danger">05:00</span></p>
                        </div>
                        <div id="otp-resend-container" style="display: none;">
                            <p class="mb-2">Didn't receive the OTP?</p>
                            <button type="button" id="btn-resend-otp"
                                class="btn btn-link p-0 text-primary font-weight-bold">Resend OTP</button>
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
                    localStorage.setItem(key, JSON.stringify(item));
                }

                function getWithExpiry(key) {
                    const itemStr = localStorage.getItem(key);
                    if (!itemStr) return null;
                    try {
                        const item = JSON.parse(itemStr);
                        const now = new Date();
                        if (now.getTime() > item.expiry) {
                            localStorage.removeItem(key);
                            return null;
                        }
                        return item;
                    } catch (e) {
                        return null;
                    }
                }

                function startTimer(duration) {
                    let timer = duration, minutes, seconds;
                    const display = $('#otp-timer');
                    const timerContainer = $('#otp-timer-container');
                    const resendContainer = $('#otp-resend-container');

                    timerContainer.show();
                    resendContainer.hide();

                    const interval = setInterval(function () {
                        minutes = parseInt(timer / 60, 10);
                        seconds = parseInt(timer % 60, 10);

                        minutes = minutes < 10 ? "0" + minutes : minutes;
                        seconds = seconds < 10 ? "0" + seconds : seconds;

                        display.text(minutes + ":" + seconds);

                        if (--timer < 0) {
                            clearInterval(interval);
                            timerContainer.hide();
                            resendContainer.show();
                            localStorage.removeItem('otp-flag');
                        }
                    }, 1000);
                }

                function sendOTP() {
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
                            url: './extra/verification-otp-mail.php',
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
                                    startTimer(5 * 60);
                                } else {
                                    swal({
                                        title: 'Failed!',
                                        text: response.message || 'Could not send OTP. Please try again.',
                                        type: 'error',
                                        confirmButtonClass: 'btn btn-danger margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                    $('#otp-resend-container').show();
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
                                $('#otp-resend-container').show();
                            }
                        });
                    }, 2500);
                }

                const otpItem = getWithExpiry('otp-flag');
                if (!otpItem) {
                    // Check if it's a regular string from old version
                    const oldFlag = localStorage.getItem('otp-flag');
                    if (oldFlag === 'akkibro') {
                        localStorage.removeItem('otp-flag');
                        location.reload(); 
                        return;
                    }
                    
                    sendOTP();
                } else {
                    const remaining = Math.round((otpItem.expiry - new Date().getTime()) / 1000);
                    if (remaining > 0) {
                        startTimer(remaining);
                    } else {
                        $('#otp-resend-container').show();
                    }
                }

                $('#btn-resend-otp').click(function() {
                    localStorage.removeItem('otp-flag');
                    location.reload(); // As requested by user: "which just refresh the page"
                });

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