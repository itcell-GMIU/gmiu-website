<?php
if (isset($_POST['stu_id'])) {
    $student_id = $_POST['stu_id'];
    if (strlen($student_id) > 0) {
        session_start();
        $_SESSION['student_id'] = $student_id;
        $_SESSION['secretkey'] = "secret";
        
        // Redirect to the desired page
       // header('Location: ../../admission/dashboard.php');
        ?>
        <script type="text/javascript" language="Javascript">window.open('../../admission/dashboard.php');</script>
        <?php
        echo "<script>setTimeout(function(){window.location='conform_admission_list.php'},0)</script>";
        exit; // Make sure to exit after a header redirect
        
    }
}
?>
