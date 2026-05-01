<?php
// Define allowed IP addresses
// $allowed_ips = array('3.7.50.30','117.247.54.20','2409:40c1:5c:86a5:23aa:cb6e:5a06:9c6b','65.2.118.222');

// $allowed_ips = array('43.250.159.201');

// Check if the request originates from an allowed IP address
// if (!in_array($_SERVER['REMOTE_ADDR'], $allowed_ips)) {
//     http_response_code(403); // Forbidden
//     exit("Access Forbidden");
// }

// header("Access-Control-Allow-Origin: https://beta.gmgc.edu.in");


$tok = '863a7405dcb019dcb71a33454eaffc1354ad2a1627140c99b01a1dedb4c8febd6f909fa99d19e1f908eb8e5d8c51fafbd91f61be8b67dac731fe674f50c7a18a';

$data = json_decode(file_get_contents('php://input'), true);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['token'])) {
    if ($data['token'] != $tok) {
        $response = array(
            'error' => "Invalid Token"
        );
        // Set response headers to JSON
        header('Content-Type: application/json');

        // Output the response as JSON
        die (json_encode($response, JSON_PRETTY_PRINT));

        exit;
    }
} else {
    $response = array(
        'error' => "Invalid Request"
    );
    // Set response headers to JSON
    header('Content-Type: application/json');

    // Output the response as JSON
    die (json_encode($response, JSON_PRETTY_PRINT));
    exit;
}
