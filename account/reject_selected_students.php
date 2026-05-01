<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'include/checklogin.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['exam_id'])) {
        $exam_id = mysqli_real_escape_string($con, $_POST['exam_id']);
        $exam_id = validate_data($exam_id);
        
        if (isset($_POST['selected_students']) && is_array($_POST['selected_students'])) {
            foreach ($_POST['selected_students'] as $student_id) {
                $stmt = $con->prepare("UPDATE tbl_exam_student SET account_status = 2 WHERE id = ?");
                $stmt->bind_param("i", $student_id);
                $result = $stmt->execute();
                // Check if the query ran successfully
                if (!$result) {
                    // Display an error message and exit the script
                    echo "Error: " . mysqli_error($con);
                    exit();
                }
            }
            
            if ($result) {
                $_SESSION['status'] = "Multiple Student Rejected Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='exam_form_multireject.php?exam_id=$exam_id'},100);</script>";
             }
            
         
            

            // header("Location: original_page.php?exam_id=" . $exam_id);
            // exit();
        }
    }
}
//   echo '<script>alert("Multiple Rejected Successfully")</script>';
// Redirect to the original page if no exam_id is provided
// header("Location: exam_form_multireject.php?exam_id=$exam_id");
exit();
?>
