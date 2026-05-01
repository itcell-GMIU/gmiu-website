<?php

include 'include/checklogin.php';

$payment_status = $_GET['status'];
$p_email = $email;
$name = $first_name .' '.$middle_name.' '.$last_name;
if($payment_status=="success")
        {
            $subject = "Successfull  Payment";
            $message = "Dear , ".$name." <br>
                        We are pleased to inform you that your recent payment for the examination fee has been successfully
                        processed. We appreciate your timely payment.
                        <br>
                        // Payment Details:
                        // Payment Date:
                        // Payment Amount:
                        // Reference Number:
                        // <br>
                        Your payment for the examination fee is now confirmed, and you are officially registered for the
                        upcoming exam. We recommend that you keep a copy of this confirmation for your records.
                        <br>
                        -Gyanmajari innovative University
                        ";
            $to = $p_email;
            send_mail($to, $subject, $message);
            
            if(send_mail($to, $subject, $message)){
        $_SESSION['status'] = "Payment Successful!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='examform.php'},1000)</script>";
        }
        
        }elseif($payment_status=="failed")
            {
            $subject = "Payment Failed!";
            $message = "Dear , ".$name." <br>
                        We regret to inform you that there was an issue with the online payment you recently attempted for
                        your examination fee. We understand how important this payment is, and we are here to assist you in
                        resolving this matter.
                        // <br>
                        // Payment Details:
                        // Payment Date:
                        // Payment Amount:
                        // Reference Number:
                        <br>
                        The specific reason for the payment failure can vary, and it could be due to issues with your payment
                        method, network problems, or other technical difficulties.
                        To address this issue promptly, we recommend the following steps:
                        Double-Check Payment Information: Ensure that the payment details you entered, including the card
                        number, expiration date, and security code, are accurate. If there was an error, please try the payment
                        again with the correct information.
                        Check Your Internet Connection: A stable internet connection is crucial for successful online payments.
                        Please ensure you have a stable and secure internet connection when attempting the payment.
                        Best Regards
                        <br>
                        -Gyanmajari innovative University
                        ";
            $to = $p_email;
            send_mail($to, $subject, $message);
            
            if(send_mail($to, $subject, $message)){
        $_SESSION['status'] = "Payment Failed!";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='examform.php'},1000)</script>";
        }
        
        }

?>