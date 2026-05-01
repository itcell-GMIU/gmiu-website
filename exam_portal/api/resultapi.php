<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../database/connect.php';
include '../../common/validation.php';
include '../../common/globalvariable.php';
include './inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['exam_id']) && isset($data['erNo'])) {
        $exam_id = $data['exam_id'];
        $enrollnment_no = $data['erNo'];
        $status = 0;

        function getExamDetailsById($con, $exam_id)
        {
            global $semester;
            $status = 0;
            $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.semester as semester, std.is_active as std_is_active, std.type as type , std.session as session , std.start_date as start_date, std.end_date as end_date, std.year as year,
                                    faculty.name as faculty_name, level.name as level_name , program.name as program_name FROM tbl_exam_form as std
                                    LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                    LEFT JOIN tbl_level level ON std.level_id = level.id 
                                    LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = ? AND std.result_status = 1");
            $cmd->bind_param("i", $status);
            $cmd->execute();
            $result = $cmd->get_result();

            while ($row = $result->fetch_assoc()) {
                $level_id = $row['level_id'];
                $program_id = $row['program_id'];
                $faculty_id = $row['faculty_id'];
                $id = $row['id'];
                $semester = $row['semester'];

                $year = date("Y", strtotime($row['year']));

                $faculty_name = !empty($row['faculty_name']) ? ucwords(strtolower($row['faculty_name'])) : "<b>N/A</b>";
                $level_name = !empty($row['level_name']) ? ucwords(strtolower($row['level_name'])) : "<b>N/A</b>";
                $program_name = !empty($row['program_name']) ? ucwords(strtolower($row['program_name'])) : "<b>N/A</b>";
                $sem = !empty($row['semester']) ? ucwords(strtolower($row['semester'])) : "<b>N/A</b>";
                $std_is_active = $row['std_is_active'];
                $exam_type = ucwords(strtolower($row['type']));
                $exam_session = ucwords(strtolower($row['session']));

                if ($row['type'] == "regular") {
                    $exam_type = "REGULAR";
                } else {
                    $exam_type = "REMEDIAL";
                }

                $cmd33 = "SELECT * FROM tbl_clg_name WHERE is_delete = '0' and is_active='1' and FIND_IN_SET('$faculty_id', faculty_id) > 0 AND FIND_IN_SET('$level_id', level_id) > 0";
                $stmt33 = $con->prepare($cmd33);
                $stmt33->execute();
                $result33 = $stmt33->get_result();

                if ($result33->num_rows > 0) {
                    while ($row33 = $result33->fetch_assoc()) {
                        $clg_name =  $row33['clg_name'];
                    }
                }

                if ($id == $exam_id) {
                    $exam_name = ucwords(strtolower($program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year']));

                    return array(
                        'id' => $id,
                        'level_id' => $level_id,
                        'program_id' => $program_id,
                        'semester' => $semester,
                        'faculty_name' => $faculty_name,
                        'level_name' => $level_name,
                        'program_name' => $program_name,
                        'sem' => $sem,
                        'std_is_active' => $std_is_active,
                        'exam_type' => $exam_type,
                        'exam_session' => $exam_session,
                        'year' => $year,
                        'exam_name' => $exam_name,
                        'college_name' => $clg_name
                    );
                }
            }

            return array(); // Return an empty array if no matching exam_id is found
        }

        // Fetch exam details
        $exam_details = getExamDetailsById($con, $exam_id);

        // Fetch student details
        $cmd22 = $con->prepare("SELECT ts.first_name as first_name, ts.middle_name as middle_name, ts.last_name as last_name, tes.seat_no as seat_no, tes.enrollnment_no as enrollnment_no,  tes.exam_sgpa as exam_sgpa, tes.exam_cgpa as exam_cgpa, tes.total_credit as total_credit, tes.total_credit_point as total_credit_point, tes.is_pass as is_pass, tes.total_backlog as backlog FROM tbl_students_2023 as ts LEFT JOIN tbl_exam_student as tes ON ts.enrollnment_no = tes.enrollnment_no WHERE tes.enrollnment_no = ? AND tes.exam_id = ? AND tes.is_delete = ? AND tes.status = 3");
        $cmd22->bind_param("sii", $enrollnment_no, $exam_id, $status);
        $cmd22->execute();
        $result22 = $cmd22->get_result();

        if ($result22->num_rows == 0) {
            $response = array(
                'status' => 'No Data Found!'
            );
            http_response_code(404);
        } else {
            $row22 = $result22->fetch_assoc();
            $std_name = ucwords(strtolower($row22["first_name"])) . ' ' . ucwords(strtolower($row22["middle_name"])) . ' ' . ucwords(strtolower($row22["last_name"]));
            $ernumber = $row22['enrollnment_no'];
            $seat = $row22['seat_no'];
            $total_credit = $row22['total_credit'];
            $total_credit_point = $row22['total_credit_point'];
            $exam_sgpa = $row22['exam_sgpa'];
            $exam_cgpa = $row22['exam_cgpa'];
            // $backlog = $row22['backlog'];
            $is_pass = $row22['is_pass'];
            $rsStatus = ($row22['is_pass'] == 1) ? "Pass" : "Fail";
        }

        // Fetch exam results
        $is_approved = 1;
        $cmdSUB = $con->prepare("SELECT * FROM tbl_final_exam_results WHERE enrollnment_no = ? AND seat_no = ? AND exam_id = ? AND is_approved = ?");
        $cmdSUB->bind_param("sssi", $enrollnment_no, $seat, $exam_id, $is_approved);
        $cmdSUB->execute();
        $resultexamSUB = $cmdSUB->get_result();

        $exam_results = array(); // Initialize array to store exam results

        while ($exmSUB = $resultexamSUB->fetch_assoc()) {
            $cmdSUBFetch = $con->prepare("SELECT subject_name, credit FROM tbl_subject_master WHERE subject_code = ?");
            $cmdSUBFetch->bind_param("s", $exmSUB['subject_code']);
            $cmdSUBFetch->execute();
            $resultexamSUBFetch = $cmdSUBFetch->get_result();
            $exmSUBFetch = $resultexamSUBFetch->fetch_assoc();
            $subject_name = $exmSUBFetch['subject_name'];
            $credit = $exmSUBFetch['credit'];
            $sub_code = $exmSUB['subject_code'];

            $sub_code_map = [
                'BETIT12304' => 'BETIT04358',
                'BETIT12305' => 'BETIT04359',
                'BETIT12306' => 'BETIT04360',
                'BETIT12205' => 'BETXX04361',
                'BETIT12206' => 'BETXX04362',
                'BETIT12207' => 'BETXX04363',
                'MCAXX11508' => 'MCAXX12508',
                'MCAXX11509' => 'MCAXX12509',
                'MCAXX11510' => 'MCAXX12510',
                'MCAXX11511' => 'MCAXX12511',
                'MCAXX11302' => 'MCAXX12302',
                'MCAAI11512' => 'MCAAI12512',
            ];

            $sub_code = $sub_code_map[$sub_code] ?? $sub_code;


            // Add each row of data to the exam_results array
            $exam_results[] = array(
                'subject_code' => strtoupper($sub_code),
                'subject_name' => str_replace("?", " ", strtoupper($subject_name)),
                'credit' => strtoupper($credit),
                'is_absent' => strtoupper($exmSUB['is_absent']),
                'gradeTHEORY' => strtoupper($exmSUB['gradeTHEORY'] ?? '-'),
                'gradePRACTICAL' => strtoupper($exmSUB['gradePRACTICAL'] ?? '-'),
                'gradeMID' => strtoupper($exmSUB['gradeMID'] ?? '-'),
                'gradeALA' => strtoupper($exmSUB['gradeALA'] ?? '-'),
                'gradeVIVA' => strtoupper($exmSUB['gradeVIVA'] ?? '-'),
                'gradeFINAL' => strtoupper($exmSUB['gradeFINAL'] ?? '-'),
                'credit_point_total' => strtoupper($exmSUB['credit_point_total'])
            );
        }

        $cmd = $con->prepare("SELECT reassesment_start FROM `tbl_exam_form` WHERE id = ?");
        $cmd->bind_param("i", $exam_id);
        $cmd->execute();
        $result = $cmd->get_result();

        while ($row = $result->fetch_assoc()) {
            $reassessment_date = $row['reassesment_start'];
        }

        $date = new DateTime($reassessment_date);
        $date->modify('+8 days');
        $end_date = $date->format('Y-m-d');

        // Fetch month
        $cmdMonth = $con->prepare("SELECT date FROM tbl_exam_timetable WHERE exam_id = ?");
        $cmdMonth->bind_param("i", $exam_id);
        $cmdMonth->execute();
        $resultexamMonth = $cmdMonth->get_result();
        $exmSUBMonth = $resultexamMonth->fetch_assoc();
        $MonthExam = $exmSUBMonth['date'];
        $month = date("F", strtotime($MonthExam));

        // $semester_data = [];
        // $cndBacklogs = array("is_active" => 1, "enrollnment_no" => $enrollnment_no);
        // $recBacklog = $crud->readRecordsWithConditions("tbl_exam_backlogs", $cndBacklogs);
        // if (is_array($recBacklog)) {
        //     foreach ($recBacklog as $back) {
        //         $semester_data[$back['semester']] = [
        //             'semester' => $back['semester'],
        //             'cgpa' => $back['exam_cgpa'],
        //             'sgpa' => $back['exam_sgpa'],
        //             'backlog' => $back['backlog_count'],
        //             'total_credit' => $back['total_credit'],
        //             'total_credit_point' => $back['total_credit_point'],
        //         ];
        //     }
        // }
        $semester_data = [];

        // Query to fetch latest exam data for each semester
        $query = "
        SELECT b.*
        FROM tbl_exam_backlogs b
        JOIN tbl_exam_form f ON b.exam_id = f.id
        WHERE b.enrollnment_no = '$enrollnment_no'
        AND (
            -- For the current semester
            (b.semester = $semester AND (
                -- Show data for the specified exam_id if it's regular
                (b.exam_id = $exam_id AND f.type = 'regular')
                -- Show data for the specified exam_id if it's remedial
                OR (b.exam_id = $exam_id AND f.type = 'remedial')
                -- Otherwise, show the latest exam data based on type
                OR (b.exam_id = (
                    SELECT b1.exam_id
                    FROM tbl_exam_backlogs b1
                    JOIN tbl_exam_form f1 ON b1.exam_id = f1.id
                    WHERE b1.enrollnment_no = '$enrollnment_no'
                    AND b1.semester = $semester
                    ORDER BY b1.exam_id DESC
                    LIMIT 1
                ))
            ))
            OR
            -- For previous semesters, get the latest exam for each semester
            (b.semester < $semester AND b.exam_id = (
                SELECT MAX(b1.exam_id)
                FROM tbl_exam_backlogs b1
                JOIN tbl_exam_form f1 ON b1.exam_id = f1.id
                WHERE b1.enrollnment_no = '$enrollnment_no'
                AND b1.semester = b.semester
            ))
        )
        ORDER BY b.semester ASC, b.exam_id DESC
    ";
    
        // Execute the query
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($back = mysqli_fetch_assoc($result)) {
                $semester = $back['semester'];
                $semester_data[$semester] = [
                    'semester' => $back['semester'],
                    'cgpa' => $back['exam_cgpa'],
                    'sgpa' => $back['exam_sgpa'],
                    'backlog' => $back['backlog_count'],
                    'total_credit' => $back['total_credit'],
                    'total_credit_point' => $back['total_credit_point'],
                ];
            }
        }


        if($exam_id == 160){
            $end_date = '2024-09-11';
        }

        // Prepare final response
        $response = array(
            'exam_details' => $exam_details,
            'student_name' => $std_name,
            'enrollnment_no' => $ernumber,
            'seat_no' => $seat,
            'total_credit' => $total_credit,
            'total_credit_point' => $total_credit_point,
            'exam_sgpa' => $exam_sgpa,
            'exam_cgpa' => $exam_cgpa,
            'semester_data' => $semester_data,
            'is_pass' => $is_pass,
            'result_status' => $rsStatus,
            'month' => $month,
            'exam_results' => $exam_results,
            'start_date' => $reassessment_date,
            'end_date' => $end_date,
        );

        // Set response headers to JSON
        header('Content-Type: application/json');

        // Output the response as JSON
        echo json_encode($response);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid Request!']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}
