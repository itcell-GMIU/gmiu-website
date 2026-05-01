<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include the checklogin.php file
include '../include/checklogin.php';


function send_mail2($to, $subject, $message)
{
    $from = "exam@gmiu.edu.in";
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

    $check = mail($to, $subject, $message, $headers);

    if ($check) {
        return true;
    } else {
        $error = error_get_last();
        $error_message = $error['message'];
        //echo "An error occurred while sending the email: $error_message";
        return $error_message;
    }
}

$link = "https://ems.gmgc.edu.in/";
$getExam = array("is_active" => 1, "role_id" => 53);
$recExam = $crud->readRecordsWithConditions("tbl_exam_staff", $getExam);

// print_r($recExam);
$start_date = '10-01-2025';
$end_date = '18-01-2025';
$i = 1;
if (is_array($recExam)) {
foreach ($recExam as $hod) {
    sleep(10);
    echo $i . ' - ' . $hod['name'] . ' ->Mail : ' . $hod['email'] . '<br>';
    $i++;

    $subject = "GMIU MIV Mark Entry Credential";
    $message = '<!DOCTYPE html>
                        <html>

                        <head>
                        <title>Exam Cell</title>
                        </head>

                        <body style="font-family: Arial, sans-serif; background-color: #f2f2f2; margin: 0; padding: 10px;">
                        <div
                        style="max-width: 600px; margin: 5px auto; background-color: #ffffff; padding: 30px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                        <h1 style="color: #003366; font-size: 24px; margin-bottom: 20px; text-align: center;"><b>Exam Cell - GMIU</b></h1>

                        <hr>

                        <p style="margin-bottom: 20px; font-size: 16px;">Dear ';
    $message .= strtoupper($hod['name']);
    $message .=  '<b>';
    $message .= '</b>,</p>';
    $message .= '<p style="margin-bottom: 20px; font-size: 16px;">You are informed to submit GMIU Sem-1(Regular/remedial),Sem-2 (Remedial) and Sem-3 (Regular) M,I,P and V mark entry through below mentioned link : <br>';
    $message .=  "=> Link : <b><a target='_blank' href='$link'>" . $link . "</a></b><br>";
    $message .=  "=> Username : <b>" . $hod['email'] . "</b><br>";
    $message .=  "=> Password : <b>" . $hod['password'] . "</b><br>";

    // Close the paragraph tag
    $message .= '<hr>Strictly follow the schedule given .After end dare you will not enter any mark on the portal.If You have any query regarding mark entry contact me </p>';
    $message .=  "=> Start Date : <b>$start_date</b><br>";
    $message .=  "=> End Date : <b>$end_date</b><br>";
    $message .= '
                    <div style="text-align: left;">
                        <p style="margin-bottom: 0; font-size: 16px;"><b>First give the priority of Sem-3</b></p>
                        <p style="margin-bottom: 0; font-size: 16px;">Thanks and Regards,</p>
                        <p style="margin-bottom: 0; font-size: 16px;">Exam Cell, GMIU</p>
                    </div>

                    </div>
                    </body>

                    </html>';

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'From: ' . "\r\n" .
        'Reply-To: ' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    echo $message;
    $email = $hod['email'];
    if (send_mail2($email, $subject, $message)) {
        echo "sent";
    }
}
}
