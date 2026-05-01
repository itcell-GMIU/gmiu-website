<?php
// Define the valid token
$valid_token = '123';

// Check if the token is provided in the request
if (isset($_POST['token'])) {
    // Retrieve the token from the POST data
    $token = $_POST['token'];

    // Validate the token
    if ($token === $valid_token) {
        // Sample success response
        $response = [
            'status' => 'success',
            'data' => [
                'message' => 'API request successful.',
                'timestamp' => time(),
            ]
        ];
    } else {
        // Invalid token response
        $response = [
            'status' => 'error',
            'message' => 'Invalid token.',
        ];
    }
} else {
    // Token is missing in the request
    $response = [
        'status' => 'error',
        'message' => 'Token is required.',
    ];
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
