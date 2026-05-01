<?php
set_time_limit(500);

// Include the checklogin.php file
include '../include/checklogin.php';

// GET  id from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $is_absent = 0;

    function convertMarks($originalMarks, $sourceScale, $targetScale)
    {
        // Assuming marks are in the range [0, $sourceScale]
        // Convert to the range [0, $targetScale]
        if ($sourceScale == 0) {
            // Handle division by zero error
            return "NA";
        } elseif ($originalMarks === "UFM") {
            // Handle UFM case
            return "UFM";
        } elseif ($originalMarks === null || is_null($originalMarks) || $originalMarks === "NULL") {
            // Handle null or empty value
            return "AB";
        } elseif ($originalMarks === "AB") {
            // Handle AB case
            return "AB";
        } else {
            // Perform the conversion
            $convertedMarks = ($originalMarks / $sourceScale) * $targetScale;
            return $convertedMarks;
        }
    }

    // function convertMarksToPercentage($originalMarks, $targetScale)
    // {
    //     // Assuming marks are in the range [0, $sourceScale]
    //     // Convert to the range [0, $targetScale]
    //     if ($originalMarks == "NA") {
    //         // Handle division by zero error
    //         return "NA";
    //     } elseif ($originalMarks == "UFM") {
    //         // Handle division by zero error
    //         return 0;
    //     } elseif ($originalMarks == "AB") {
    //         // Handle division by zero error
    //         return "AB";
    //     } elseif ($originalMarks == 0) {
    //         return 0;
    //     } else {
    //         // Convert to percentage
    //         $percentage = ($originalMarks / $targetScale) * 100;
    //         return $percentage;
    //     }
    // }

    function convertMarksToPercentage($originalMarks, $targetScale)
    {
        // Assuming marks are in the range [0, $sourceScale]
        // Convert to the range [0, $targetScale]
        if ($originalMarks == "NA") {
            // Handle division by zero error
            return "NA";
        } elseif ($originalMarks == "UFM") {
            // Handle division by zero error
            return 0;
        } elseif ($originalMarks == "AB") {
            // Handle division by zero error
            return "AB";
        } elseif ($originalMarks == 0) {
            return 0;
        } else {
            // Convert to percentage and round off to the next value
            $percentage = ($originalMarks / $targetScale) * 100;
            return ceil($percentage);
        }
    }

    function getGradeAndCredit($con, $faculty_id, $level_id, $percentage)
    {
        if ($percentage == "AB" || $percentage == "") {
            return array(
                'letter_grade' => "F",
                'grade_point' => 0,
                'is_absent' => 1
            );
        } else {
            $query = "SELECT * FROM tbl_grade_settings WHERE FIND_IN_SET(?, faculty_id) AND FIND_IN_SET(?, level_id)";

            $cmdexamGrade = $con->prepare($query);
            $cmdexamGrade->bind_param("ii", $faculty_id, $level_id);

            if ($cmdexamGrade->execute()) {
                $resultexamGrade = $cmdexamGrade->get_result();

                while ($exmGrade = $resultexamGrade->fetch_assoc()) {
                    // Assuming that 'lower_limit' and 'upper_limit' are columns in your table
                    $lowerLimit = $exmGrade['perc_from'];
                    $upperLimit = $exmGrade['perc_to'];

                    // Check if the percentage falls within the range
                    if ($percentage >= $lowerLimit && $percentage <= $upperLimit) {
                        return array(
                            'letter_grade' => $exmGrade['letter_grade'],
                            'grade_point' => $exmGrade['grade_point'],
                            'is_absent' => 0
                        );
                    }
                }

                $resultexamGrade->close(); // Close the result set
            }

            // If no match is found, return null or handle accordingly
            return null;
        }
    }

    // Function to safely convert a variable to float, ignoring "NA" values and empty strings
    function safeFloat($value)
    {
        if ($value === "NA" || $value === "") {
            return 0.0;
        } else {
            return (float)$value;
        }
    }

    $id = mysqli_real_escape_string($con, $_GET['id']);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location=''},100)</script>";
    }
    // Prepare and execute the SQL statement to delete a record in the tbl_program_outcome
    $stmt = $con->prepare("UPDATE `tbl_exam_form` SET result_status = 1, reassesment_start = CURRENT_DATE WHERE id = ? ");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    $cmdexam = $con->prepare("SELECT tbl_exam_results.*, tbl_exam_form.faculty_id, tbl_exam_form.level_id
    FROM tbl_exam_results
    LEFT JOIN tbl_exam_form ON tbl_exam_results.exam_id = tbl_exam_form.id
    WHERE tbl_exam_results.exam_id = ?");
    $cmdexam->bind_param("i", $id);
    $cmdexam->execute();
    $resultexam = $cmdexam->get_result();

    while ($exm = $resultexam->fetch_assoc()) {

        // echo "1";

        $enrollnment_no = $exm['enrollnment_no'];
        $subject_code = $exm['subject_code'];
        $seat_no = $exm['seat_no'];
        $exam_id = $exm['exam_id'];
        $faculty_id = $exm['faculty_id'];
        $level_id = $exm['level_id'];
        $Mpractical = $exm['Mpractical'];
        $Mtheory = $exm['Mtheory'];
        $Mrmid = $exm['Mrmid'];
        $Mmid = $exm['Mmid'];

        if ($Mmid == "AB" || $Mmid == "") {
            $Mmid = $Mrmid;
        }

        $Mviva = $exm['Mviva'];
        $Mala = $exm['Mala'];

        $cmdexamMark = $con->prepare("SELECT * FROM tbl_subject_master where subject_code = ?");
        $cmdexamMark->bind_param("s", $subject_code);
        $cmdexamMark->execute();
        $resultexamMark = $cmdexamMark->get_result();

        while ($exmMark = $resultexamMark->fetch_assoc()) {

            // echo "2 <br>";

            $subject_codeM = $exmMark['subject_code'];
            $subject_nameM = $exmMark['subject_name'];
            $L = $exmMark['L'];
            $T = $exmMark['T'];
            $P = $exmMark['P'];
            $credit = $exmMark['credit'];
            $entESE = $exmMark['entESE'];
            $contESE = $exmMark['contESE'];
            $passESE = $exmMark['passESE'];
            $entPRACTICAL = $exmMark['entPRACTICAL'];
            $contPRACTICAL = $exmMark['contPRACTICAL'];
            $passPRACTICAL = $exmMark['passPRACTICAL'];
            $entMSE = $exmMark['entMSE'];
            $contMSE = $exmMark['contMSE'];
            $passMSE = $exmMark['passMSE'];
            $entVIVA = $exmMark['entVIVA'];
            $contVIVA = $exmMark['contVIVA'];
            $passVIVA = $exmMark['passVIVA'];
            $entALA = $exmMark['entALA'];
            $contALA = $exmMark['contALA'];
            $passALA = $exmMark['passALA'];
            $passingMARK = $exmMark['passingMARK'];


            $convertedcontESE = convertMarks($Mtheory, $entESE, $contESE);
            $convertedcontPRACTICAL = convertMarks($Mpractical, $entPRACTICAL, $contPRACTICAL);
            $convertedcontVIVA = convertMarks($Mviva, $entVIVA, $contVIVA);
            $convertedcontALA = convertMarks($Mala, $entALA, $contALA);
            $convertedcontMSE = convertMarks($Mmid, $entMSE, $contMSE);
            $convertedcontRMSE = convertMarks($Mrmid, $entMSE, $contMSE);

            $perceContESE = convertMarksToPercentage($convertedcontESE, $contESE);
            $perceContPRACTICAL = convertMarksToPercentage($convertedcontPRACTICAL, $contPRACTICAL);
            $perceContVIVA = convertMarksToPercentage($convertedcontVIVA, $contVIVA);
            $perceContALA = convertMarksToPercentage($convertedcontALA, $contALA);
            $perceContMSE = convertMarksToPercentage($convertedcontMSE, $contMSE);
            $perceContRMSE = convertMarksToPercentage($convertedcontRMSE, $contMSE);



            $gradeESE = getGradeAndCredit($con, $faculty_id, $level_id, $perceContESE);
            $LettergradeESE = $gradeESE['letter_grade'] ?? null;
            $gradepointESE = $gradeESE['grade_point'] ?? null;
            $is_absent = $gradeESE['is_absent'] ?? 0; // If $is_absent is null, set it to 0


            if ($convertedcontALA < $passALA) {
                $LettergradeALA = "F";
                $gradepointALA = 0;
            } else {
                $gradeALA = getGradeAndCredit($con, $faculty_id, $level_id, $perceContALA);
                $LettergradeALA = $gradeALA['letter_grade'] ?? null;
                $gradepointALA = $gradeALA['grade_point'] ?? null;
            }

            if ($convertedcontVIVA < $passVIVA) {
                $LettergradeVIVA = "F";
                $gradepointVIVA = 0;
            } else {
                $gradeVIVA = getGradeAndCredit($con, $faculty_id, $level_id, $perceContVIVA);
                $LettergradeVIVA = $gradeVIVA['letter_grade'] ?? null;
                $gradepointVIVA = $gradeVIVA['grade_point'] ?? null;
            }

            if ($convertedcontPRACTICAL < $passPRACTICAL) {
                $LettergradePRACTICAL = "F";
                $gradepointPRACTICAL = 0;
            } else {
                $gradePRACTICAL = getGradeAndCredit($con, $faculty_id, $level_id, $perceContPRACTICAL);
                $LettergradePRACTICAL = $gradePRACTICAL['letter_grade'] ?? null;
                $gradepointPRACTICAL = $gradePRACTICAL['grade_point'] ?? null;
            }

            if ($Mrmid == "" || $Mrmid == "UFM" || $Mrmid == "NULL" || $Mrmid == null || empty($Mrmid)) {
                $gradeMSE = getGradeAndCredit($con, $faculty_id, $level_id, $perceContMSE);
                $LettergradeMSE = $gradeMSE['letter_grade'] ?? null;
                $gradepointMSE = $gradeMSE['grade_point'] ?? null;
            } else {
                $gradeMSE = getGradeAndCredit($con, $faculty_id, $level_id, $perceContRMSE);
                $LettergradeMSE = $gradeMSE['letter_grade'] ?? null;
                $gradepointMSE = $gradeMSE['grade_point'] ?? null;
            }

            if ($Mrmid == "" || $Mrmid == "NULL" || $Mrmid == "UFM" || $Mrmid == null || empty($Mrmid) || $Mrmid == "AB") {
                $midMark = $convertedcontMSE;
                $perceMid =  $perceContMSE;
            } else {
                $midMark = $convertedcontRMSE;
                $perceMid =  $perceContRMSE;
            }

            $spitotalfrom = $contESE + $contMSE + $contALA + $contPRACTICAL + $contVIVA;
            $getspitotal = safeFloat($convertedcontALA) + safeFloat($convertedcontESE) + safeFloat($convertedcontPRACTICAL) + safeFloat($midMark) + safeFloat($convertedcontVIVA);

            $contSPI = 100;

            $convertedcontSPI = convertMarks($getspitotal, $spitotalfrom, $contSPI);

            $convertedcontSPI =  $convertedcontSPI + 0.000001;

            $gradeFinal = getGradeAndCredit($con, $faculty_id, $level_id, $convertedcontSPI);
            $LettergradeFinal = $gradeFinal['letter_grade'] ?? null;
            $gradepointFinal = $gradeFinal['grade_point'] ?? null;

            if ($LettergradeALA == "F" || $LettergradeMSE == "F" || $LettergradeVIVA == "F" || $LettergradePRACTICAL == "F" || $LettergradeESE == "F") {
                $LettergradeFinal = "F";
            }

            if ($LettergradeFinal == "F" || $LettergradeFinal == "AB" || $LettergradeFinal == "UFM") {
                $is_pass = 0;
            } else {
                $is_pass = 1;
            }
            // exit;
            // Check if the record already exists
            $checkCmd = $con->prepare("SELECT id FROM `tbl_final_exam_results` WHERE `enrollnment_no` = ? AND `seat_no` = ? AND `subject_code` = ?");
            $checkCmd->bind_param("sss", $enrollnment_no, $seat_no, $subject_codeM);
            $checkCmd->execute();
            $checkResult = $checkCmd->get_result();

            if ($checkResult->num_rows > 0) {
                // Record exists, perform update
                $updateQuery = "UPDATE tbl_final_exam_results SET `barcode` = ?,
                `exam_id` = ?,
                `Mpractical` = ?,
                `Mtheory` = ?,
                `Mrmid` = ?,
                `Mmid` = ?,
                `Mviva` = ?,
                `Mala` = ?,
                `PercMpractical` = ?,
                `PercMtheory` = ?,
                `PercMrmid` = ?,
                `PercMmid` = ?,
                `PercMviva` = ?,
                `PercMala` = ?,`gradeALA` = ?, `gradeTHEORY` = ?, `gradeMID` = ?, `gradeVIVA` = ?, `gradePRACTICAL` = ?, gradeFINAL = ?, gradepointFINAL = ?, status =?, is_absent = ? WHERE enrollnment_no = ? AND seat_no = ? AND subject_code = ?";

                // Prepare the statement
                $stmt22 = $con->prepare($updateQuery);

                if ($stmt22) {
                    $stmt22->bind_param(
                        "ssssssssssssssssssssssssss",
                        $barcode,
                        $exam_id,
                        $convertedcontPRACTICAL,
                        $convertedcontESE,
                        $convertedcontRMSE,
                        $midMark,
                        $convertedcontVIVA,
                        $convertedcontALA,
                        $perceContPRACTICAL,
                        $perceContESE,
                        $perceContRMSE,
                        $perceContMSE,
                        $perceContVIVA,
                        $perceContALA,
                        $LettergradeALA,
                        $LettergradeESE,
                        $LettergradeMSE,
                        $LettergradeVIVA,
                        $LettergradePRACTICAL,
                        $LettergradeFinal,
                        $gradepointFinal,
                        $is_pass,
                        $is_absent,
                        $enrollnment_no,
                        $seat_no,
                        $subject_codeM
                    );

                    // Execute the update query
                    if ($stmt22->execute()) {
                        // echo "Update successful.";
                    } else {
                        echo "Error updating record: " . $stmt22->error;
                    }

                    // Close the statement
                    $stmt22->close();
                } else {
                    echo "Error preparing statement: " . $mysqli->error;
                }
            } else {
                // Record does not exist, perform insert
                $inscmdexam = $con->prepare("INSERT INTO `tbl_final_exam_results`(`enrollnment_no`, `seat_no`, `barcode`, `subject_code`, `exam_id`, `Mpractical`, `Mtheory`, `Mrmid`, `Mmid`, `Mviva`, `Mala`, `PercMpractical`, `PercMtheory`, `PercMrmid`, `PercMmid`, `PercMviva`, `PercMala`, `gradeALA`, `gradeTHEORY`, `gradeMID`, `gradeVIVA`, `gradePRACTICAL`, `gradeFINAL`, `gradepointFINAL`, `status`, `is_absent`)
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?)");

                $inscmdexam->bind_param(
                    "ssssssssssssssssssssssssss",
                    $enrollnment_no,
                    $seat_no,
                    $barcode,
                    $subject_codeM,
                    $exam_id,
                    $convertedcontPRACTICAL,
                    $convertedcontESE,
                    $convertedcontRMSE,
                    $midMark,
                    $convertedcontVIVA,
                    $convertedcontALA,
                    $perceContPRACTICAL,
                    $perceContESE,
                    $perceContRMSE,
                    $perceContMSE,
                    $perceContVIVA,
                    $perceContALA,
                    $LettergradeALA,
                    $LettergradeESE,
                    $LettergradeMSE,
                    $LettergradeVIVA,
                    $LettergradePRACTICAL,
                    $LettergradeFinal,
                    $gradepointFinal,
                    $is_pass,
                    $is_absent
                );
                $inscmdexam->execute();
                $insertResult = $inscmdexam->get_result();
            }
        }

        $cmdexamSPI = $con->prepare("SELECT subject_code,gradepointFINAL, gradeFINAL FROM tbl_final_exam_results WHERE enrollnment_no = ? AND seat_no = ? AND exam_id = ?");
        $cmdexamSPI->bind_param("ssi", $enrollnment_no, $seat_no, $exam_id);
        $cmdexamSPI->execute();
        $resultexamSPI = $cmdexamSPI->get_result();

        $examSPIArray = array();
        $spiFINAL = 0;
        $prevcredPlus = 0;
        $spiCountI = 0;

        while ($exmSPI = $resultexamSPI->fetch_assoc()) {
            $spiFINAL2 = $exmSPI['gradepointFINAL'];
            $supsub = $exmSPI['subject_code'];

            $cmdSUB = $con->prepare("SELECT credit FROM tbl_subject_master WHERE subject_code = ?");
            $cmdSUB->bind_param("s", $supsub);
            $cmdSUB->execute();
            $resultexamSUB = $cmdSUB->get_result();
            while ($exmSUB = $resultexamSUB->fetch_assoc()) {
                $cred = $exmSUB["credit"];
            }

            // $GRDFINAL = $exmSPI["gradeFINAL"];

            if ($exmSPI["gradeFINAL"] != "F") {
                $credit_point_total = $cred * $spiFINAL2;

                $multicred = $cred * $spiFINAL2;
            } else {
                $credit_point_total = 0;
                $multicred = 0;
            }

            $FcredPlus = $cred + $prevcredPlus;

            $ExamSPI = $spiFINAL + $multicred;

            $spiFINAL = $ExamSPI;
            // Store the results in an array
            $examSPIArray[] = array(
                'gradeFINAL' => $exmSPI['gradeFINAL']
            );

            $prevcredPlus = $FcredPlus;

            $spiCountI++;

            $UPcmdexamCred = $con->prepare("UPDATE tbl_final_exam_results SET credit_point_total = ? WHERE enrollnment_no = ? AND seat_no = ? AND exam_id = ? AND subject_code = ?");
            $UPcmdexamCred->bind_param("sssss", $credit_point_total, $enrollnment_no, $seat_no, $exam_id, $supsub);
            $UPcmdexamCred->execute();
        }


        foreach ($examSPIArray as $result11) {
            if ($result11['gradeFINAL'] == 'F') {
                $overallResult = 0;
                break;
            } else {
                $overallResult = 1;
            }
        }
        // if ($GRDFINAL == 'F') {
        //     $finalExamSPI = 0;
        // } else {
        $finalExamSPI = $ExamSPI / $FcredPlus;
        // }
        // echo '<br> SPI : ' . $finalExamSPI . '<br><br>';

        // Prepare the count query
        $countQuery = $con->prepare("SELECT COUNT(*) as row_count FROM tbl_final_exam_results WHERE enrollnment_no = '$enrollnment_no ' AND seat_no = '$seat_no' AND exam_id = $exam_id AND status = 0");
        // Execute the query
        $countQuery->execute();
        // Get the result
        $result = $countQuery->get_result();
        // Fetch the count value
        $row = $result->fetch_assoc();
        $backlog = $row['row_count'];

        $UPcmdexamSPI = $con->prepare("UPDATE tbl_exam_student SET is_pass = ?, exam_sgpa = ?, exam_cgpa = ?, total_credit_point = ?, total_credit = ?, total_backlog = ?, created_at = CURRENT_TIMESTAMP WHERE enrollnment_no = ? AND seat_no = ? AND exam_id = ?");
        $UPcmdexamSPI->bind_param("ssssssssi", $overallResult, $finalExamSPI, $finalExamSPI, $ExamSPI, $FcredPlus, $backlog, $enrollnment_no, $seat_no, $exam_id);
        $UPcmdexamSPI->execute();
    }
    if ($UPcmdexamSPI) {
        $_SESSION['status'] = "Result Published";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='publish_result.php'},100);</script>";
    } else {
        $_SESSION['status'] = "Result Published";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='publish_result.php'},100);</script>";
    }

    exit;
}
