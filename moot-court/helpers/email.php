<?php
// helpers/email.php - Simple SMTP Email Utility

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../vendor/autoload.php'; // PHPMailer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendHTMLEmail($to, $subject, $htmlMessage)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;

        // Recipients
        $mail->setFrom(FROM_EMAIL, FROM_NAME);
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true); // HTML email
        $mail->Subject = $subject;
        $mail->Body = $htmlMessage;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log the error
        $logFile = __DIR__ . '/../logs/email_errors.log';
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] HTML Email sending failed: " . $mail->ErrorInfo . "\n";
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
        return false;
    }
}

// Keep the old function for backward compatibility (but simplified)
function sendConfirmationEmail($email, $registrationData = [], $transactionData = [])
{
    $subject = "GMIU Moot Court Registration Confirmation";

    // Build the HTML email content using the provided template
    $htmlContent = "
    <div style='background-color: #f4f4f4; margin: 0; padding: 20px 0; font-family: Arial, sans-serif;'>
        <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e0e0e0;'>

            <div style='text-align: center; padding: 20px; border-bottom: 1px solid #e0e0e0;'>
                <img src='" . BASE_DOMAIN . "/gmiu/website_assets/images/gmiulogo.png' alt='GMIU Logo' style='max-width: 200px;'>
            </div>

            <div style='padding: 25px 30px; color: #333333; line-height: 1.6;'>
                <h2 style='color: #1e3a8a; margin-bottom: 20px; text-align: center;'>Registration Confirmed!</h2>

                <p style='font-size: 16px;'>Dear <strong>" . htmlspecialchars($registrationData['team_member_1']) . "</strong>,</p>

                <p style='font-size: 16px;'>Congratulations! Your registration for the GMIU Moot Court Competition has been successfully confirmed. Your payment has been processed and your team is now officially registered.</p>

                <div style='background-color: #f7f7f7; border-radius: 5px; padding: 20px; margin: 25px 0; border-left: 4px solid #1e3a8a;'>
                    <h3 style='margin-top: 0; color: #1e3a8a;'>Registration Details:</h3>
                    <table style='width: 100%; border-collapse: collapse;'>
                        <tr>
                            <td style='padding: 8px 0; border-bottom: 1px solid #ddd; font-weight: bold;'>Team Members:</td>
                            <td style='padding: 8px 0; border-bottom: 1px solid #ddd;'>" . htmlspecialchars($registrationData['team_member_1']) . "<br>" . htmlspecialchars($registrationData['team_member_2']) . "<br>" . htmlspecialchars($registrationData['team_member_3']) . "</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; border-bottom: 1px solid #ddd; font-weight: bold;'>College/University:</td>
                            <td style='padding: 8px 0; border-bottom: 1px solid #ddd;'>" . htmlspecialchars($registrationData['college_name']) . "</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; border-bottom: 1px solid #ddd; font-weight: bold;'>Email:</td>
                            <td style='padding: 8px 0; border-bottom: 1px solid #ddd;'>" . htmlspecialchars($registrationData['email']) . "</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; border-bottom: 1px solid #ddd; font-weight: bold;'>Mobile:</td>
                            <td style='padding: 8px 0; border-bottom: 1px solid #ddd;'>" . htmlspecialchars($registrationData['mobile']) . "</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; border-bottom: 1px solid #ddd; font-weight: bold;'>Side:</td>
                            <td style='padding: 8px 0; border-bottom: 1px solid #ddd;'>" . htmlspecialchars(ucfirst($registrationData['side'])) . "</td>
                        </tr>
                    </table>
                </div>

                <div style='background-color: #f7f7f7; border-radius: 5px; text-align: center; padding: 20px; margin: 25px 0;'>
                    <h3 style='margin-top: 0; color: #1e3a8a;'>Payment Information:</h3>
                    <p style='font-size: 24px; font-weight: bold; color: #27ae60; margin: 10px 0;'>₹" . number_format($transactionData['payment_amount'], 2) . "</p>
                    <p style='margin: 5px 0;'><strong>Transaction ID:</strong> " . htmlspecialchars($transactionData['transaction_id']) . "</p>
                    <p style='margin: 5px 0;'><strong>Payment Method:</strong> " . htmlspecialchars($transactionData['payment_method']) . "</p>
                    <p style='margin: 5px 0;'><strong>Payment Time:</strong> " . date('d M Y, h:i A', strtotime($transactionData['payment_time'])) . "</p>
                </div>

                <div style='background-color: #fcf8e3; border: 1px solid #faebcc; border-radius: 4px; padding: 15px; margin: 25px 0;'>
                    <p style='margin: 0; font-size: 14px; color: #8a6d3b;'>
                        <strong>Important Notice:</strong><br>
                        Please keep this email as proof of your registration and payment. You will receive further updates about the competition schedule and venue details closer to the event date.
                    </p>
                </div>

                <div style='text-align: center; margin: 25px 0;'>
                    <a href='" . APP_URL . "/receipt.php?reg_id=" . $registrationData['id'] . "&token=" . urlencode($registrationData['receipt_token']) . "' style='background-color: #1e3a8a; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;'>Download Receipt</a>
                </div>

                <p style='font-size: 16px; margin-top: 25px;'>If you have any questions or need assistance, please contact our support team at <a href='mailto:" . CONTACT_EMAIL . "' style='color: #0056b3; text-decoration: underline;'>" . CONTACT_EMAIL . "</a>.</p>

                <p style='font-size: 16px;'>Best regards,<br><strong>GMIU Moot Court Competition Team</strong></p>
            </div>

            <div style='background-color: #1e3a8a; padding: 20px 30px; text-align: center; color: white;'>
                <p style='font-size: 14px; margin: 0; font-weight: bold;'>Gyanmanjari Innovative University</p>
                <p style='font-size: 12px; margin: 5px 0 0 0; opacity: 0.8;'>Gyanmanjari Institute of Law - Moot Court Competition 2026</p>
            </div>

            <div style='background-color: #ffffff; padding: 20px 30px; text-align: center; border-top: 1px solid #e0e0e0;'>
                <p style='font-size: 12px; color: #888888; margin: 0;'>This is an automated message. Please do not reply to this email.</p>
                <p style='font-size: 12px; color: #888888; margin: 10px 0 0 0;'>
                    <a href='" . BASE_DOMAIN . "/gmiu/website/' style='color: #0056b3; text-decoration: none;'>Visit GMIU Website</a>
                </p>
            </div>

        </div>
    </div>";

    return sendHTMLEmail($email, $subject, $htmlContent);
}
?>