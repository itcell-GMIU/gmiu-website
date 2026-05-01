<?php
include '../include/checklogin.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Start the session
// Include your database connection file or any necessary configurations
if ($role_id == 51 || $name== 'Prof. Prashant Viradiya') {
    // Check if form data is received
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Extract form data
        $clg_name  =  mysqli_real_escape_string($con, $_POST['clg_name']);
        $exam_name =  mysqli_real_escape_string($con, $_POST['exam_name']);
        $exam_time =  mysqli_real_escape_string($con, $_POST['exam_time']);
        $exam_date =  mysqli_real_escape_string($con, $_POST['exam_date']);
        $subject_code = $_POST['subject_code'];
        $t_marks = $_POST['t_marks'];
        $checkboxIDs = $_POST['checkboxID'];

        // Check if checkboxIDs is not null
        if ($checkboxIDs === null) {
            // Return error message if checkboxIDs is null
            echo "Checkbox ID is null!";
            exit(); // Stop further execution
        }
        
        // Separate checkbox IDs and Bloom's levels
        $idsAndLevels = explode(',', $checkboxIDs);

        // Prepare and execute the SQL statement for each ID and Bloom's level
        foreach ($idsAndLevels as $idAndLevel) {
            // Separate ID and Bloom's level
            list($questionId, $blLevel) = explode('-', $idAndLevel);
            
            $stmt_update = $con->prepare("UPDATE tbl_questions SET bl_level = ? WHERE id = ?");
            $stmt_update->bind_param("si", $blLevel, $questionId);
            $stmt_update->execute();
            // echo "Data updated successfully!";
        }
 
        // Check if similar entry already exists
        $stmt_check = $con->prepare("SELECT COUNT(*) AS count FROM tbl_paper WHERE subject_code = ? AND total_mark = ? AND question = ?");
        $stmt_check->bind_param("sis", $subject_code, $t_marks, $checkboxIDs);
        $stmt_check->execute();

        $result_check = $stmt_check->get_result();
        $row_check = $result_check->fetch_assoc();
        $count = $row_check['count'];

        if ($count > 0) {
            // Return error message if similar entry already exists
            echo "Data already exists!";
        } else {
            // Prepare and execute the SQL statement for insertion
            $stmt_insert = $con->prepare("INSERT INTO `tbl_paper` (subject_code, total_mark, question, create_by, clg_name, exam_name, exam_time, exam_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_insert->bind_param("sisissss", $subject_code, $t_marks, $checkboxIDs, $web_admin_id, $clg_name, $exam_name, $exam_time, $exam_date);
            $result_insert = $stmt_insert->execute();

            if ($result_insert) {
                // Return success message if insertion is successful
                echo "Data inserted successfully!";
            } else {
                // Return error message if insertion fails
                echo "Failed to insert data!";
            }
        }
    } else {
        // Return error message for invalid request method
        echo "Invalid request method!";
    }
}
?>
