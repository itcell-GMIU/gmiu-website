<?php
if (isset($_POST["mobileNumber"])) {
    $mobileNumber = $_POST["mobileNumber"];
    $inq_id = $_POST["inq_id"]; // The recipient's WhatsApp number in international format (e.g., +1234567890)
    $message = "Hello, this is a test WhatsApp message."; // The WhatsApp message content

    // Your WhatsApp messaging service API endpoint and authentication
    $whatsappApiUrl = "https://example.com/whatsapp-api"; // Replace with your WhatsApp API URL
    $apiToken = "your_api_token"; // Replace with your API token

    // Prepare the WhatsApp message data
    $whatsappData = [
        "token" => $apiToken,
        "to" => $mobileNumber,
        "message" => $message,
    ];

    // Perform an HTTP POST request to send the WhatsApp message
    $ch = curl_init($whatsappApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($whatsappData));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    // Check if the WhatsApp message was sent successfully
    if ($httpCode == 200) {
        $status = 1;
        $cmd = $con->prepare("UPDATE `tbl_inquiry_remarks` SET `is_wp_msg_sended` = ? WHERE `tbl_inquiry_remarks`.`inq_student_id` = ?");
        $cmd->bind_param("ii", $status, $inq_id);
        $cmd->execute();
        echo "success"; // Send a success response to the AJAX request
    } else {
        echo "error"; // Send an error response to the AJAX request
    }
} else {
    echo "Invalid request";
}
?>
