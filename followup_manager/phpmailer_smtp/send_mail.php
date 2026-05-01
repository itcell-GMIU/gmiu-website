<?php
include('smtp/PHPMailerAutoload.php'); // Ensure the path is correct

// Function to send email using PHPMailer
function smtp_mailer($to, $subject, $msg)
{
    $mail = new PHPMailer(true); // Enable exceptions for better error handling
    try {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        //$mail->SMTPDebug = 2; 
        $mail->Username = "admissions@gmiu.edu.in";
        $mail->Password = "uhnagbjndteetsfy";
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

        $mail->send();
        return true;
    } catch (Exception $e) {
        return $e->getMessage(); // Return error message on failure
    }
}

?>