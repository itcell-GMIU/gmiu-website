<?php
session_start();
header("Content-Type: application/json");
include '../database/connect.php';
include('./smtp/PHPMailerAutoload.php');

// ======================================
// VALIDATE REQUEST METHOD
// ======================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        "status" => "error",
        "code" => "INVALID_REQUEST",
        "message" => "Only POST request allowed"
    ]);
    exit;
}



// ======================================
// GET DATA
// ======================================

$email = trim($_POST['email'] ?? '');
$type = $_POST['type'] ?? '';
$otp_purpose = $_POST['otp_purpose'] ?? '';


// ======================================
// VALIDATE EMAIL
// ======================================

if (empty($email)) {

    echo json_encode([
        "status" => "error",
        "code" => "EMAIL_REQUIRED",
        "message" => "Email address is required"
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo json_encode([
        "status" => "error",
        "code" => "INVALID_EMAIL",
        "message" => "Invalid email format"
    ]);
    exit;
}



// ======================================
// VALIDATE MAIL TYPE
// ======================================

$allowed_types = [
    "otp",
    "seat_allotted",
    "payment_verified"
];

if (!in_array($type, $allowed_types)) {

    echo json_encode([
        "status" => "error",
        "code" => "INVALID_MAIL_TYPE",
        "message" => "Unsupported mail type"
    ]);
    exit;
}



// ======================================
// GENERATE MAIL BODY BASED ON TYPE
// ======================================

$otp = null;

if ($type === "otp") {

    if (
        isset($_SESSION['otp_data']) &&
        $_SESSION['otp_data']['purpose'] === $otp_purpose &&
        time() <= $_SESSION['otp_data']['expires']
    ) {

        echo json_encode([
            "status" => "exists",
            "code" => "OTP_ALREADY_SENT",
            "message" => "OTP already sent. Please check your email."
        ]);
        exit;
    }
    
    if ($type === "otp" && $otp_purpose === "forgot_password") {

        $stmt = $con->prepare("
        SELECT id 
        FROM tbl_gmap_students 
        WHERE email = ? 
        AND is_delete = 0 AND is_active = 1
    ");

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {

            echo json_encode([
                "status" => "error",
                "code" => "EMAIL_NOT_FOUND",
                "message" => "This email is not registered in our system."
            ]);

            exit;
        }
    }

    // Generate new OTP
    $otp = random_int(100000, 999999);

    $_SESSION['otp_data'] = [
        "code" => $otp,
        "purpose" => $otp_purpose,
        "expires" => time() + (10 * 60)
    ];
}

$body = generate_mail_template($type, $otp, $otp_purpose);

if (!$body) {

    echo json_encode([
        "status" => "error",
        "code" => "MAIL_TEMPLATE_ERROR",
        "message" => "Failed to generate email body"
    ]);
    exit;
}

// ======================================
// SUBJECT
// ======================================

switch ($type) {

    case "otp":
        $subject = "GMAP Verification Code";
        break;

    case "seat_allotted":
        $subject = "GMAP Seat Allotment Notification";
        break;

    case "payment_verified":
        $subject = "GMAP Payment Verification";
        break;

}

// ======================================
// SEND MAIL
// ======================================

$mail = new PHPMailer();

$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;

$mail->Username = "gmap@gmiu.edu.in";
$mail->Password = "omnl klbg zmlk mmct";

$mail->SMTPSecure = "tls";
$mail->Port = 587;

$mail->setFrom(
    "gmap@gmiu.edu.in",
    "Gyanmanjari Admission Portal - GMAP"
);

$mail->addAddress($email);

$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body = $body;



if (!$mail->send()) {

    echo json_encode([
        "status" => "error",
        "code" => "MAIL_SEND_FAILED",
        "message" => "Failed to send email",
        // "smtp_error" => $mail->ErrorInfo

    ]);

    exit;
}



// ======================================
// SUCCESS RESPONSE
// ======================================

echo json_encode([
    "status" => "success",
    "code" => "MAIL_SENT",
    "message" => "Email sent successfully",
    "mail_type" => $type,
    "recipient" => $email
]);

exit;





// ======================================
// TEMPLATE FUNCTION
// ======================================

function generate_mail_template($type, $otp = "", $otp_purpose = "")
{

    $otp_box = "";
    $seat_box = "";
    $payment_box = "";

    $purpose_text = "";

    // OTP purposes
    if ($type === "otp") {

        switch ($otp_purpose) {

            case "forgot_password":
                $purpose_text = "Password Reset Verification";
                break;

            case "registration":
                $purpose_text = "Account Registration Verification";
                break;

            case "lock_program":
                $purpose_text = "Program Lock Confirmation";
                break;

            case "unlock_program":
                $purpose_text = "Program Unlock Confirmation";
                break;

            default:
                $purpose_text = "Account Verification";
        }

    }

    // Seat allotment
    if ($type === "seat_allotted") {
        $purpose_text = "Seat Allotment Notification";
    }

    // Payment verification
    if ($type === "payment_verified") {
        $purpose_text = "Payment Verification Confirmation";
    }

    if ($type === "otp") {

        $otp_box = '

        <table width="100%" cellspacing="0" cellpadding="0" style="margin:30px 0;text-align:center">
        <tr><td>

        <table align="center" cellpadding="0" cellspacing="0" style="
        background:#f8f9fc;
        border:2px dashed #bc2823;
        border-radius:8px;
        padding:20px 30px">

        <tr>
        <td style="
        font-size:36px;
        font-weight:bold;
        letter-spacing:8px;
        color:#1e264a;
        font-family:monospace;
        text-align:center">

        ' . $otp . '

        </td>
        </tr>

        <tr>
        <td style="font-size:13px;color:#666;text-align:center;padding-top:8px">
        Your One Time Password (OTP)
        </td>
        </tr>

        <tr>
        <td style="font-size:12px;color:#888;text-align:center;padding-top:5px">
        This OTP will expire in 10 minutes.
        </td>
        </tr>

        </table>

        </td></tr>
        </table>';

    }



    if ($type === "seat_allotted") {

        $seat_box = '

        <table width="100%" cellspacing="0" cellpadding="0" style="margin:30px 0;text-align:center">
        <tr><td>

        <table align="center" cellpadding="0" cellspacing="0" style="
        background:#f8f9fc;
        border:2px solid #1e264a;
        border-radius:8px;
        padding:22px 32px">

        <tr>
        <td style="font-size:22px;font-weight:bold;color:#1e264a;text-align:center">
        Application Status Update
        </td>
        </tr>

        <tr>
        <td style="font-size:16px;color:#333;text-align:center;padding-top:10px;font-weight:600">
        Your seat has been successfully allotted, kindly pay the token fees to confirm your seat.
        </td>
        </tr>

        </table>

        </td></tr>
        </table>';

    }



    if ($type === "payment_verified") {

        $payment_box = '

        <table width="100%" cellspacing="0" cellpadding="0" style="margin:30px 0;text-align:center">
        <tr><td>

        <table align="center" cellpadding="0" cellspacing="0" style="
        background:#f8f9fc;
        border:2px solid #1e264a;
        border-radius:8px;
        padding:22px 32px">

        <tr>
        <td style="font-size:26px;font-weight:bold;color:#1e264a;text-align:center">
        Payment Verified
        </td>
        </tr>

        <tr>
        <td style="font-size:15px;color:#333;text-align:center;padding-top:10px">
        Your admission payment has been successfully verified.
        </td>
        </tr>

        </table>

        </td></tr>
        </table>';

    }



    return '

<!-- GMAP Professional Email Template -->
<div style="background:#f2f4f8;padding:30px 10px;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table width="600"
                    style="max-width:600px;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e5e5e5"
                    cellspacing="0" cellpadding="0">

                    <!-- HEADER -->
                    <tr>
                        <td align="center" style="padding:25px;background:#ffffff;border-bottom:3px solid #1e264a">

                            <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="GMIU Logo"
                                style="max-width:200px;height:auto">

                        </td>
                    </tr>

                    <!-- TITLE STRIP -->
                    <tr>
                        <td style="background:linear-gradient(90deg,#bc2823,#1e264a);padding:20px;text-align:center">

                            <span style="color:#ffffff;font-size:20px;font-weight:bold;letter-spacing:1px">
                                GMAP Notification
                            </span>

                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:35px 30px;color:#333333;line-height:1.6">

                            <p style="font-size:16px;margin-top:0">
                                Hello Dear Student,
                            </p>

                            <p style="font-size:16px">
                                Greetings from <strong style="color:#1e264a">Gyanmanjari Admission Portal
                                    (GMAP)</strong>.
                            </p>

                            <p style="font-size:16px">
                                This email has been sent regarding an activity on your admission portal account. Please
                                review the information below.
                            </p>

                            <p style="font-size:16px">
                            Your request related to <strong style="color:#1e264a">' . $purpose_text . '</strong> has been received by the system.
                            </p>

                            ' . $otp_box . '

                            ' . $seat_box . '

                            ' . $payment_box . '

                            <!-- HIGHLIGHT BOX -->
                            <table width="100%" cellspacing="0" cellpadding="0" style="margin:25px 0">
                                <tr>
                                    <td
                                        style="background:#f8f9fc;border-left:5px solid #1e264a;border-radius:6px;padding:18px">

                                        <span style="font-size:15px">
                                            If this email contains a verification code or important update, please
                                            follow the instructions provided in the portal to complete the process.
                                        </span>

                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:14px;color:#555555">
                                For security reasons, please do not share your OTP or login credentials with anyone.
                            </p>
                            <p style="font-size:14px;color:#555555">
                                If you did not initiate this request, please contact the university support team
                                immediately.
                            </p>
                        </td>
                    </tr>


                    <!-- INFO STRIP -->
                    <tr>
                        <td style="background:#fff5f5;padding:18px;text-align:center;border-top:1px solid #f0dede">

                            <span style="color:#bc2823;font-size:14px;font-weight:bold">
                                Important: This is an automated system notification.
                            </span>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td
                            style="padding:28px;text-align:center;color:#ffffff;font-size:13px;background:#1e264a;border-top:3px solid #bc2823">

                            <p style="margin:0;color:#d6d9e6">
                                This is an automated email. Please do not reply to this message.
                            </p>

                            <p style="margin:16px 0">

                                <a href="https://gmiu.edu.in"
                                    style="color:#ffffff;text-decoration:none;font-weight:600;margin:0 8px;">
                                    GMIU Website
                                </a>

                                <span style="color:#9aa3c7">|</span>

                                <a href="https://admission.gmiu.edu.in"
                                    style="color:#ffffff;text-decoration:none;font-weight:600;margin:0 8px;">
                                    Admission Website
                                </a>

                                <span style="color:#9aa3c7">|</span>

                                <a href="https://gmiu.edu.in/gmiu/gmap/index.php"
                                    style="color:#ffffff;text-decoration:none;font-weight:600;margin:0 8px;">
                                    GMAP Portal
                                </a>

                            </p>

                            <p style="margin:12px 0 0 0;color:#ffffff">
                                <strong>Gyanmanjari Institute of Technology</strong><br>
                                Bhavnagar, Gujarat, India
                            </p>

                            <p style="margin-top:12px;font-size:12px;color:#c7cbe0">
                                © 2026 Gyanmanjari Admission Portal (GMAP)
                            </p>

                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</div>
';

}