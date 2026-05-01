<?php
include 'include/checklogin.php';


header('Content-Type: application/json');

// Include PHPMailer
include '../inquiry/smtp/PHPMailerAutoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['referral_code'])) {
    $referral_code = trim($_POST['referral_code']);
    $otp = rand(100000, 999999);

    // Fetch referral email from DB
    $sql = "SELECT email FROM tbl_referral_master WHERE referral_code = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $referral_code);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();

    if ($email) {
        $_SESSION['otp_for_referral'] = $otp;

        $mail = new PHPMailer();

        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "admissions@gmiu.edu.in";      // Gmail address
        $mail->Password = "uhna gbjn dtee tsfy";        // Gmail app password
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        // Email headers
        $mail->setFrom("admissions@gmiu.edu.in", "Admissions");
        $mail->addAddress($email);

        // Content
        $mail->isHTML(false);
        $mail->Subject = "Your Verification OTP";
        $mail->Body    = "Your OTP for referral code $referral_code is: $otp";

        if ($mail->send()) {
            echo json_encode(["success" => true, "message" => "OTP sent to $email"]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Mailer Error: " . $mail->ErrorInfo
            ]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Referral code not found"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
