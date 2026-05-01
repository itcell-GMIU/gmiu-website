<?php
include '../../database/connect.php';
include '../../common/validation.php';
include '../../common/globalvariable.php';
include './inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $enrNo = $data['erNo'];

    // Prepare and execute the SQL query to fetch all exam details
    $stmt = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.semester as semester, std.is_active as std_is_active, std.type as type , std.session as session , std.start_date as start_date, std.end_date as end_date, std.year as year,
                                faculty.name as faculty_name, level.name as level_name , program.name as program_name FROM tbl_exam_form as std
                                LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                LEFT JOIN tbl_level level ON std.level_id = level.id 
                                LEFT JOIN tbl_program program ON std.program_id = program.id
                                LEFT JOIN tbl_exam_student tes ON tes.exam_id = std.id WHERE tes.enrollnment_no = '$enrNo' AND std.result_status = 1 AND std.is_active = 1 AND tes.is_approved = 1");
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        // Fetch all exam details as an associative array
        $examDetails = $result->fetch_all(MYSQLI_ASSOC);

        // Close the prepared statement
        $stmt->close();

        // Decode HTML entities
        foreach ($examDetails as &$detail) {
            foreach ($detail as &$value) {
                $value = htmlspecialchars_decode($value);
            }
        }

        // Convert all strings in the array to uppercase
        foreach ($examDetails as &$detail) {
            $detail = array_map('strtoupper', $detail);
        }

        // Return exam details as JSON response
        header('Content-Type: application/json');
        echo json_encode($examDetails);
    } else {
        // No exams found
        http_response_code(404);
        echo json_encode(["error" => "NO EXAMS FOUND"]); // Response content in uppercase
    }
}
