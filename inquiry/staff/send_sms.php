<?php
if (isset($_POST["mobileNumber"])) {
    $mobileNumber = $_POST["mobileNumber"]; // The recipient's mobile number
    $inq_id = $_POST["inq_id"]; 
    $message = "Hello, this is a test SMS message."; // The SMS message content

    // Your SMS gateway or service API endpoint and authentication
    $smsGatewayUrl = "https://example.com/sms-api"; // Replace with your SMS gateway URL
    $apiUsername = "your_api_username"; // Replace with your API username
    $apiPassword = "your_api_password"; // Replace with your API password

    // Prepare the SMS data
    $smsData = [
        "username" => $apiUsername,
        "password" => $apiPassword,
        "to" => $mobileNumber,
        "message" => $message,
    ];

    // Perform an HTTP POST request to send the SMS
    $ch = curl_init($smsGatewayUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $smsData);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    // Check if the SMS was sent successfully
    if ($httpCode == 200) {
        $status = 1;
        $cmd = $con->prepare("UPDATE `tbl_inquiry_remarks` SET `is_sms_sended` = '?' WHERE `tbl_inquiry_remarks`.`inq_student_id` = '?';");
        $cmd->bind_param("ii", $status,$inq_id);
        $cmd->execute();
        echo "success"; // Send a success response to the AJAX request
    } else {
        echo "error"; // Send an error response to the AJAX request
    }
} else {
    echo "Invalid request";
}
?>
