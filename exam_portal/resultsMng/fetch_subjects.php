<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// Check if exam_id is set and not empty
if (isset($_POST['exam_id']) && !empty($_POST['exam_id'])) {
    // Sanitize exam_id to prevent SQL injection
    $exam_id = $con->real_escape_string($_POST['exam_id']);

    // Prepare and execute the query to fetch subjects based on exam_id
    $stmt = $con->prepare("SELECT DISTINCT subject_code FROM tbl_exam_results WHERE exam_id = ?");
    $stmt->bind_param("i", $exam_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are subjects fetched
    if ($result->num_rows > 0) {
        $subjects = array();

        // Fetch subjects and store them in an array
        while ($row = $result->fetch_assoc()) {
            $subjects[] = $row['subject_code'];
        }

        // Close prepared statement
        $stmt->close();

        // Close database connection
        $con->close();

        // Send JSON response
        echo json_encode($subjects);
    } else {
        // If no subjects found, send error response
        echo json_encode(array('error' => 'No subjects found for the provided exam ID'));
    }
} else {
    // If exam_id is not set or empty, send error response
    echo json_encode(array('error' => 'Exam ID is required'));
}
?>