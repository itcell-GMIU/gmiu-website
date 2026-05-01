<?php
session_start();

include '../../common/globalvariable.php';
include '../../database/connect.php';
// include '../../common/function.php';
// include '../../common/validation.php';
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
// $user_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$user_email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : '';
// $user_email = 'trjaiswal@gmiu.edu.in';
$role_id = isset($_SESSION['role_id']) ? $_SESSION['role_id'] : '';
$name;
if ($role_id == 12) {
    $name = 'Inquiry Admin';
} elseif ($role_id == 57) {
    $name = 'Lead Manager';
} else {
    $user_email = '';
    $name = '';
}

if (empty($user_email)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Email not found in session.'
    ]);
    exit;
}

// Generate 6-digit OTP
$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expire'] = time() + (3 * 60); // 3 minutes expiry

$subject = "OTP Code For the Assigning Inquiry (Calling Software) - " . date("d M Y");
$body = "
<div style='background-color: #f4f4f4; margin: 0; padding: 20px 0; font-family: Arial, sans-serif;'>
    <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e0e0e0;'>

        <div style='text-align: center; padding: 20px; border-bottom: 1px solid #e0e0e0;'>
            <img src='https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png' alt='Company Logo' style='max-width: 200px;'>
        </div>

        <div style='padding: 25px 30px; color: #333333; line-height: 1.6;'>
            <p style='font-size: 16px;'>Hello, <strong>{$name}</strong></p>

            <p style='font-size: 16px;'>You requested a one-time password to assign inquiry from your account. Use the code below to log in securely.</p>

            <p style='font-size: 16px;'><strong style='color: #c7254e;'>Important:</strong> This code will expire in <strong>3 minutes</strong> for your security.</p>

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

            <p style='font-size: 16px; margin-top: 25px;'>For security reasons, this OTP code can only be used once and will expire after 3 minutes.</p>
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
if (smtp_mailer($user_email, $subject, $body)) {
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
?>