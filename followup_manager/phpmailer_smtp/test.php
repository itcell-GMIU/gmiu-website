<?php
include('smtp/PHPMailerAutoload.php');

// echo smtp_mailer('','Test','Is the Mail is Sent ?');
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
	//$mail->SMTPDebug = 2; 
	$mail->Username = "from_email";
	$mail->Password = "pass_key";
	$mail->SetFrom("from_email");
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
		// echo $mail->ErrorInfo;
	} else {
	   $_SESSION['show'] = "";
	}
}

echo smtp_mailer('to_email', 'Sent OTP for the Assigning Faculty to the Inquiry.', 'This is your OTP for the Verifying Inquiry Assigning... OTP : ' .$_SESSION['otp']);

?>