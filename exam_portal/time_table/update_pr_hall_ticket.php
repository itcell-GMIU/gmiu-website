<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// GET  id from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='publish_hall_ticket.php'},100)</script>";
    }
    // Prepare and execute the SQL statement to delete a record in the tbl_program_outcome
    $stmt = $con->prepare("UPDATE `tbl_exam_form` SET pr_hallticket_status = 1 WHERE id = ? ");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    $cmdexam = $con->prepare("SELECT ef.year as year, ef.type as type,ef.session as session, ef.semester as sem, sn.short_name as short_name
    FROM tbl_exam_form as ef
    LEFT JOIN tbl_short_name as sn ON ef.faculty_id = sn.faculty_id AND ef.level_id = sn.level_id
    WHERE ef.id = ?");
    $cmdexam->bind_param("i", $id);
    $cmdexam->execute();
    $resultexam = $cmdexam->get_result();

    while ($exm = $resultexam->fetch_assoc()) {
        $short_name = $exm['short_name'];
        $year = $exm['year'];
        $session = $exm['session'];
        $sem = $exm['sem'];
        $type = $exm['type'];
    }
    if ($type == "regular") {
        $ts = "0";
    } elseif ($type == "remedial") {
        $ts = "1";
    }
    if ($session == "winter") {
        $sess = "W";
    } elseif ($session == "summer") {
        $sess = "S";
    }
    $nyear = substr($year, -2);
    $half_seat_no = $short_name . $sem . $sess . $nyear . $ts;

    $cmdstd = $con->prepare("SELECT * FROM tbl_exam_student WHERE exam_id = ? ");
    $cmdstd->bind_param("i", $id);
    $cmdstd->execute();
    $resultstd = $cmdstd->get_result();

    while ($stdr = $resultstd->fetch_assoc()) {
        $esId = $stdr['id'];

        $std_id = sprintf("%05d", $stdr['id']);
        $seat_no = $half_seat_no . $std_id;
        // echo $seat_no;
        // exit();
        $enrollment = $stdr['enrollnment_no'];
        $updateQuery = "UPDATE tbl_exam_student SET seat_no = '$seat_no' WHERE enrollnment_no = '$enrollment' AND exam_id = '$id'";
        $con->query($updateQuery);

        $cmd2 = $con->prepare("SELECT `subject_code`, `subject_name` FROM `tbl_student_subjects` WHERE `enrollnment_no`= ? and `semester`= ? ");
        $cmd2->bind_param("si", $enrollment, $sem);
        $cmd2->execute();
        $result2 = $cmd2->get_result();
        while ($row2 = $result2->fetch_assoc()) {
            $subject_codes = $row2['subject_code'];
            $subject_name = $row2['subject_name'];
            $subjectnameArray = explode(', ',  $subject_name);
            $subjectArray = explode(', ',  $subject_codes);
            foreach ($subjectArray as $subject) {
                // Use a counter for the subject name array to keep track of matching names.
                $sub_name = current($subjectnameArray);
                $barcode = $seat_no . $id . $subject;

                    $value = $barcode;

                    // Generate a unique salt, for example, using the current timestamp
                    $salt = uniqid();

                    // Combine the value, salt, and a counter
                    $combinedValue = $value . $salt;
                    $counter = 1; // You can replace this with a dynamic counter from your application logic

                    // Hash the combined value and counter
                    $hashedValue = hash('sha256', $combinedValue . $counter);

                    // Convert the hash to a numeric identifier
                    $numericIdentifier = hexdec(substr($hashedValue, 0, 9));

                    // Ensure it's a 9-digit number
                    $uniqueIdentifier = sprintf("%09d", $numericIdentifier);


                // Check if a record with the same combination already exists.
                $checkQuery = "SELECT COUNT(*) as count FROM `tbl_exam_results` WHERE `enrollnment_no`='$enrollment' AND `seat_no`='$seat_no' AND `exam_id`='$id' AND `subject_code`='$subject'";
                $result = $con->query($checkQuery);
                $row = $result->fetch_assoc();
                $recordCount = $row['count'];

                // If no record exists, insert a new one.
                if ($recordCount == 0) {
                    $insertQuery = "INSERT INTO `tbl_exam_results`(`enrollnment_no`, `seat_no`, `barcode`, `subject_code`, `exam_id`) VALUES ('$enrollment','$seat_no','$uniqueIdentifier','$subject','$id')";
                    $con->query($insertQuery);
                } 
                // else {
                //     $updateQuery = "UPDATE `tbl_exam_results` SET `barcode`='$uniqueIdentifier' WHERE `enrollnment_no`='$enrollment' AND `seat_no`='$seat_no' AND `exam_id`='$id' AND `subject_code` = '$subject'";
                //     $con->query($updateQuery);
                // }

                // Move to the next subject name, or reset to the beginning if there are no more names.
                if (next($subjectnameArray) === false) {
                    reset($subjectnameArray);
                }
            }
        }
    }

    if ($result && $resultstd) {
        $_SESSION['status'] = "Hall Ticket Published";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='publish_hall_ticket.php'},100);</script>";
    } else {
        $_SESSION['status'] = "Hall Ticket Publishing Failed";
        $_SESSION['status_code'] = "error";
        // echo "<script>setTimeout(function(){window.location='publish_hall_ticket.php'},100);</script>";
    }
}
