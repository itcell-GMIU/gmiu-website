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
    // $stmt = $con->prepare("UPDATE `tbl_exam_form` SET hallticket_status = 1 WHERE id = ? ");
    // $stmt->bind_param("i", $id);
    // $result = $stmt->execute();

    $cmdexam = $con->prepare("SELECT ef.year as year, ef.faculty_id as faculty_id, ef.level_id as level_id,ef.program_id as program_id, ef.type as type,ef.session as session, ef.semester as sem, sn.short_name as short_name
    FROM tbl_exam_form as ef
    LEFT JOIN tbl_short_name as sn ON ef.faculty_id = sn.faculty_id AND ef.level_id = sn.level_id
    WHERE ef.id = ?");
    $cmdexam->bind_param("i", $id);
    $cmdexam->execute();
    $resultexam = $cmdexam->get_result();

    global $type;
    global $sem;
    global $faculty_id;
    global $level_id;
    global $program_id;

    while ($exm = $resultexam->fetch_assoc()) {
        $short_name = $exm['short_name'];
        $year = $exm['year'];
        $session = $exm['session'];
        $sem = $exm['sem'];
        $type = $exm['type'];
        $faculty_id = $exm['faculty_id'];
        $level_id = $exm['level_id'];
        $program_id = $exm['program_id'];
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
        $updateQuery = "UPDATE tbl_exam_student SET seat_no = '$seat_no' WHERE enrollnment_no = '$enrollment' AND exam_id = $id";
        $con->query($updateQuery);

        if ($type == "remedial") {

            $stmtEXID = $con->prepare("SELECT id FROM tbl_exam_form WHERE faculty_id = ? AND level_id = ? AND program_id = ? AND semester = ? AND is_active = 1");
            $stmtEXID->bind_param("iiii", $faculty_id, $level_id, $program_id, $sem);
            $stmtEXID->execute();
            $resultEXID = $stmtEXID->get_result();

            while ($rowEXID = $resultEXID->fetch_assoc()) {

                $remedial_exID = $rowEXID['id'];

                // Prepare SQL statement to select all columns from tbl_final_exam_results table
                $stmtred = $con->prepare("SELECT tf.subject_code as subject_code, te.Mpractical as Mpractical, te.Mtheory as Mtheory, te.Mrmid as Mrmid, te.Mmid as Mmid, te.Mviva as Mviva, te.Mala as Mala, tf.gradeALA as gradeALA, tf.gradeTHEORY as gradeTHEORY, tf.gradeMID as gradeMID, tf.gradeVIVA as gradeVIVA, tf.gradePRACTICAL as gradePRACTICAL FROM tbl_final_exam_results as tf LEFT JOIN tbl_exam_results as te ON tf.enrollnment_no = te.enrollnment_no AND tf.exam_id = te.exam_id AND tf.subject_code = te.subject_code WHERE tf.enrollnment_no = ? AND tf.exam_id = ? AND tf.status = 0");

                // Bind parameters to the prepared statement
                $stmtred->bind_param("si", $enrollment, $remedial_exID);

                // Execute the prepared statement
                $stmtred->execute();

                // Get the result set
                $resultred = $stmtred->get_result();

                // Initialize an empty array to store all selected data
                $selectedData = array();

                // Fetch each row from the result set and store all selected data in the array
                while ($rowred = $resultred->fetch_assoc()) {
                    $selectedData[] = $rowred;
                }

                foreach ($selectedData as $sbj) {

                    $subject = $sbj['subject_code'];
                    $Mpractical = $sbj['Mpractical'];
                    $Mtheory = $sbj['Mtheory'];
                    $Mmid = $sbj['Mmid'];
                    $Mrmid = $sbj['Mrmid'];
                    $Mviva = $sbj['Mviva'];
                    $Mala = $sbj['Mala'];
                    $gradeALA = $sbj['gradeALA'];
                    $gradeMID = $sbj['gradeMID'];
                    $gradeTHEORY = $sbj['gradeTHEORY'];
                    $gradeVIVA = $sbj['gradeVIVA'];
                    $gradePRACTICAL = $sbj['gradePRACTICAL'];

                    if ($gradeALA == NULL || empty($gradeALA)) {
                        $Mala = NULL;
                    }
                    if ($gradeALA == 'F' || $gradeALA == 'AB') {
                        $Mala = NULL;
                    }

                    if ($gradeMID == NULL || empty($gradeMID)) {
                        $Mmid = NULL;
                    }
                    if ($gradeMID == 'F' || $gradeMID == 'AB') {
                        $Mmid = NULL;
                    }

                    if ($gradeTHEORY == NULL || empty($gradeTHEORY)) {
                        $Mtheory = NULL;
                    }
                    if ($gradeTHEORY == 'F' || $gradeTHEORY == 'AB') {
                        $Mtheory = NULL;
                    }

                    if ($gradeVIVA == NULL || empty($gradeVIVA)) {
                        $Mviva = NULL;
                    }
                    if ($gradeVIVA == 'F' || $gradeVIVA == 'AB') {
                        $Mviva = NULL;
                    }

                    if ($gradePRACTICAL == NULL || empty($gradePRACTICAL)) {
                        $Mpractical = NULL;
                    }
                    if ($gradePRACTICAL == 'F' || $gradePRACTICAL == 'AB') {
                        $Mpractical = NULL;
                    }

                    if (!empty(trim($subject))) {

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
                        $checkQuery = "SELECT COUNT(*) as count FROM `tbl_exam_results` WHERE `enrollnment_no`='$enrollment' AND `seat_no`='$seat_no' AND `exam_id`='$id' AND `subject_code`= '$subject' ";
                        $result = $con->query($checkQuery);
                        $row = $result->fetch_assoc();
                        $recordCount = $row['count'];

                        // If no record exists, insert a new one.
                        if ($recordCount == 0) {
                            // Assuming $mysqli is your MySQLi connection object

                            // Your SQL query
                            $sql = "INSERT INTO `tbl_exam_results` (`enrollnment_no`, `seat_no`, `barcode`, `subject_code`, `exam_id`, `Mpractical`, `Mtheory`, `Mmid`, `Mviva`, `Mala`, `Mrmid`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                            // Prepare the statement
                            $stmt = $con->prepare($sql);

                            // Bind parameters
                            $stmt->bind_param("sssssssssss", $enrollment, $seat_no, $uniqueIdentifier, $subject, $id, $Mpractical, $Mtheory, $Mmid, $Mviva, $Mala, $Mrmid);

                            // Execute the statement
                            $stmt->execute();

                            // Close the statement
                            $stmt->close();
                        }
                        // else {
                        //     $updateQuery = "UPDATE `tbl_exam_results` SET `barcode`='$uniqueIdentifier' WHERE `enrollnment_no`='$enrollment' AND `seat_no`='$seat_no' AND `exam_id`='$id' AND `subject_code` = '$subject'";
                        //     $con->query($updateQuery);
                        // }
                        // if ($con->query($insertQuery)) {
                        // }
                    }
                }
            }
        } else {
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
    }
    if ($resultstd) {
        $_SESSION['status'] = "Successfull";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='publish_hall_ticket.php'},100);</script>";
    } else {
        $_SESSION['status'] = "Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='publish_hall_ticket.php'},100);</script>";
    }
}
