<?php
session_start();
include('./smtp/PHPMailerAutoload.php');

$messageStatus = ''; // Will hold status message

if (isset($_POST['sendOtp'])) {

    $to = $_POST['email'];
    $subject = "Test OTP Email";
    $msg = "This is a test OTP email.";

    // SMTP Mailer function
    function smtp_mailer($to, $subject, $msg)
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Username = "admissions@gmiu.edu.in"; // your email
        $mail->Password = "uhna gbjn dtee tsfy"; // your app password
        $mail->SetFrom("admissions@gmiu.edu.in");
        $mail->Subject = $subject;
        $mail->Body = $msg;
        $mail->AddAddress($to);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => false
            )
        );

        if (!$mail->Send()) {
            return ['success' => false, 'error' => $mail->ErrorInfo];
        } else {
            return ['success' => true];
        }
    }

    // Call the function
    $response = smtp_mailer($to, $subject, $msg);
    $messageStatus = json_encode($response); // pass to JS
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Send OTP Email</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card p-4">
            <h4 class="mb-4">Send OTP Email</h4>
            <form method="POST" id="otpForm">
                <div class="form-group">
                    <label for="email">Recipient Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
                </div>
                <button type="submit" name="sendOtp" class="btn btn-primary">Send OTP</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            <?php if (!empty($messageStatus)) { ?>
                var response = <?php echo $messageStatus; ?>;

                if (response.success) {
                    swal({
                        title: "Success!",
                        text: "OTP email has been sent successfully.",
                        icon: "success",
                        button: "OK",
                    });
                } else {
                    swal({
                        title: "Error!",
                        text: "Failed to send OTP email. " + response.error,
                        icon: "error",
                        button: "OK",
                    });
                }
            <?php } ?>
        });
    </script>

</body>

</html>