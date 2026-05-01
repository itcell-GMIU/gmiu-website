<?php
session_start();

include '../../database/connect.php';
include('../smtp/PHPMailerAutoload.php');

header('Content-Type: application/json');

// ========================================
// ✅ SMTP MAILER FUNCTION (for PHPMailerAutoload.php)
// ========================================
function smtp_mailer($to, $subject, $msg)
{
    $mail = new PHPMailer(); // no namespaces needed

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';         // 🔹 Replace with your SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = 'admissions@gmiu.edu.in'; // 🔹 Your Gmail or SMTP email
    $mail->Password = 'uhna gbjn dtee tsfy';   // 🔹 App password (not your real Gmail password)
    $mail->SMTPSecure = 'tls';               // or 'ssl'
    $mail->Port = 587;                       // 465 for SSL

    $mail->setFrom('admissions@gmiu.edu.in', 'Calling Software');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $msg;

    if ($mail->send()) {
        return true;
    } else {
        return false;
    }
}

// ========================================
// ✅ MAIN OTP LOGIC
// ========================================

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

$email = $_SESSION['user']['email'];
// $email = 'asrathod@gmiu.edu.in';

// Generate 6-digit OTP
$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expire'] = time() + (5 * 60); // 5 minutes expiry

$subject = "OTP Code For the Loging into Calling Software - " . date("d M Y");
$body = "
<div style='background-color: #f4f4f4; margin: 0; padding: 20px 0; font-family: Arial, sans-serif;'>
    <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e0e0e0;'>

        <div style='text-align: center; padding: 20px; border-bottom: 1px solid #e0e0e0;'>
            <img src='https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png' alt='Company Logo' style='max-width: 200px;'>
        </div>

        <div style='padding: 25px 30px; color: #333333; line-height: 1.6;'>
            <p style='font-size: 16px;'>Hello, <strong>Calling Staff</strong></p>

            <p style='font-size: 16px;'>You requested a one-time password to login into your account. Use the code below to log in securely.</p>

            <p style='font-size: 16px;'><strong style='color: #c7254e;'>Important:</strong> This code will expire in <strong>5 minutes</strong> for your security.</p>

            <div style='background-color: #f7f7f7; border-radius: 5px; text-align: center; padding: 20px; margin: 25px 0;'>
                <p style='font-size: 36px; font-weight: bold; color: #3498db; letter-spacing: 5px; margin: 0;'>
                    {$otp}
                </p>
            </div>

            <div style='background-color: #fcf8e3; border: 1px solid #faebcc; border-radius: 4px; padding: 15px;'>
                <p style='margin: 0; font-size: 14px; color: #8a6d3b;'>
                    <strong>Security Notice:</strong><br>
                    If you did not request this OTP code, please ignore this email and <strong>report this incident immediately</strong> to our support team at <a href='mailto:itcell@gmiu.edu.in' style='color: #0056b3; text-decoration: underline;'>itcell@gmiu.edu.in</a>.
                </p>
            </div>

            <p style='font-size: 16px; margin-top: 25px;'>For security reasons, this OTP code can only be used once and will expire after 5 minutes.</p>
        </div>

        <div style='background-color: #ffffff; padding: 20px 30px; text-align: center; border-top: 1px solid #e0e0e0;'>
            <p style='font-size: 12px; color: #888888; margin: 0;'>This is an automated message. Please do not reply to this email.</p>
            <p style='font-size: 12px; color: #888888; margin: 10px 0 0 0;'>
                <a href='https://gmiu.edu.in/gmiu/website/' style='color: #0056b3; text-decoration: none;'>GMIU</a>
            </p>
        </div>

    </div>
</div>
";


// Send mail
if (smtp_mailer($email, $subject, $body)) {
    echo json_encode([
        'status' => 'success',
        'message' => 'OTP sent successfully to your email.'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to send OTP. Please check SMTP settings or try again.'
    ]);
}
//  echo json_encode([
//         'status' => 'success',
//         'message' => 'OTP sent successfully to your email.'
//     ]);
?>