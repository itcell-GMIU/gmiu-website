<?php
session_start();

// Load only important files
include '../../database/connect.php';

header('Content-Type: application/json');

// ---------------------------------------------
// FASTEST input extraction (GET → POST → JSON)
// ---------------------------------------------
if (!empty($_GET["mobile"])) {
    $mobile = trim($_GET["mobile"]);
} else if (!empty($_POST["mobile"])) {
    $mobile = trim($_POST["mobile"]);
} else {
    $data = json_decode(file_get_contents("php://input"), true);
    $mobile = isset($data["mobile"]) ? trim($data["mobile"]) : "";
}

// Validate
if ($mobile == "" || strlen($mobile) < 10) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid Mobile Number"
    ]);
    exit;
}

// Check DB
if (!isset($con) || !$con) {
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed!"
    ]);
    exit;
}

// ---------------------------------------------
// 1) FAST search in tbl_inquiry_student
//    Select only the columns we will return
// ---------------------------------------------
$sql1 = "SELECT id, inq_student_id, first_name, middle_name, last_name, gender, mobile_number, email FROM tbl_inquiry_student WHERE mobile_number = ? LIMIT 1";
$stmt1 = $con->prepare($sql1);
if (!$stmt1) {
    echo json_encode(["status" => "error", "message" => "Prepare failed (inquiry)."]);
    exit;
}
$stmt1->bind_param("s", $mobile);
$stmt1->execute();
$stmt1->store_result();

if ($stmt1->num_rows > 0) {
    // bind_result must match number of selected columns (3 here)
    $stmt1->bind_result(
        $id,
        $inq_student_id,
        $first_name,
        $middle_name,
        $last_name,
        $gender,
        $mobile_number,
        $email
    );

    $stmt1->fetch();

    // close statement
    $stmt1->close();

    echo json_encode([
        "status" => "success",
        "found_in" => "Inquiry Student",
        "data" => [
            "id" => $id,
            "inq_student_id" => $inq_student_id,
            "first_name" => $first_name,
            "middle_name" => $middle_name,
            "last_name" => $last_name,
            "gender" => $gender,
            "mobile_number" => $mobile_number,
            "email" => $email,
        ]
    ]);
    exit;
}
$stmt1->close();

// ---------------------------------------------
// 2) If NOT found → FAST search tbl_gate_pass
//    Select only the columns we will return
// ---------------------------------------------
// $sql2 = "SELECT id, visitor_name, visitor_phone FROM tbl_gate_pass WHERE visitor_phone = ? ORDER BY id DESC LIMIT 1";
// $stmt2 = $con->prepare($sql2);
// if (!$stmt2) {
//     echo json_encode(["status" => "error", "message" => "Prepare failed (gate_pass)."]);
//     exit;
// }
// $stmt2->bind_param("s", $mobile);
// $stmt2->execute();
// $stmt2->store_result();

// if ($stmt2->num_rows > 0) {

//     $stmt2->bind_result($id2, $visitor_name, $visitor_phone);
//     $stmt2->fetch();
//     $stmt2->close();

//     // --------------------------------------------
//     // SPLIT FULL NAME INTO FIRST, MIDDLE, LAST
//     // --------------------------------------------
//     $name_parts = explode(" ", trim($visitor_name));

//     $first_name = $name_parts[0] ?? "";
//     $middle_name = "";
//     $last_name = "";

//     if (count($name_parts) == 2) {
//         // FIRST + LAST
//         $last_name = $name_parts[1];
//     } elseif (count($name_parts) >= 3) {
//         // FIRST + MIDDLE... + LAST
//         $last_name = array_pop($name_parts); // last element
//         array_shift($name_parts); // remove first name
//         $middle_name = implode(" ", $name_parts); // remaining middle names
//     }

//     echo json_encode([
//         "status" => "success",
//         "found_in" => "Gate Pass",
//         "data" => [
//             "id" => $id2,
//             "first_name" => $first_name,
//             "middle_name" => $middle_name,
//             "last_name" => $last_name,
//             "visitor_phone" => $visitor_phone
//         ]
//     ]);
//     exit;
// }

// $stmt2->close();


// ---------------------------------------------
// No data
// ---------------------------------------------
echo json_encode([
    "status" => "not_found",
    "mobile" => $mobile,
    "message" => "No record found"
]);
exit;
?>