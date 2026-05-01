<?php
include "../include/checklogin.php";


$url_for = isset($_GET['url_for']) ? $_GET['url_for'] : ''; // Change 'url_for' to the actual parameter name
$url_faculty_id = isset($_GET['url_faculty_id']) ? $_GET['url_faculty_id'] : '';
$url_level_id = isset($_GET['url_level_id']) ? $_GET['url_level_id'] : '';
$url_program_id = isset($_GET['url_program_id']) ? $_GET['url_program_id'] : '';

$status = 0;
// $limit = isset($_GET['iDisplayLength']) ? intval($_GET['iDisplayLength']) : 100; // Records per page
// $offset = isset($_GET['iDisplayStart']) ? intval($_GET['iDisplayStart']) : 0; // Offset from URL parameters


$cmd = "SELECT 
    pro.is_admission_confirm AS is_admission_confirm,
    pro.id AS id,
    pro.last_exam_status AS exam_status,
    staff2.name AS counselor_name,
    pro.is_admission_confirm AS admission_status,
    pro.staff_id AS staff_id,
    staff.name AS staff_name,
    pro.inq_student_id AS inq_student_id,
    pro.first_name AS first_name,
    pro.middle_name AS middle_name,
    pro.last_name AS last_name,
     pro.last_school_name as last_school_name,
    pro.gender AS gender,
    pro.dob AS dob,
    pro.mobile_number AS mobile_number,
    pro.mobile_number2 AS mobile_number2,
    pro.email AS email,
    pro.faculty_id AS faculty_id,
    pro.level_id AS level_id,
    pro.program_id AS program_id,
    pro.last_exam AS last_exam,
    pro.last_exam_marks AS last_exam_mark,
    pro.is_online AS is_online,
    faculty.name AS faculty_name,
    level.name AS level_name,
    program.name AS program_name,
    latest_remarks.remarks AS latest_remarks,
    call_status.call_title AS call_title
FROM 
    tbl_inquiry_student AS pro
LEFT JOIN 
    tbl_faculty faculty ON pro.faculty_id = faculty.id
LEFT JOIN 
    tbl_level level ON pro.level_id = level.id
LEFT JOIN 
    tbl_program program ON pro.program_id = program.id
LEFT JOIN 
    tbl_staff staff ON pro.staff_id = staff.id
LEFT JOIN 
    tbl_staff staff2 ON pro.counselor_id = staff2.id
LEFT JOIN 
    (
        SELECT 
            ir.inq_student_id, 
            ir.call_rating,
            ir.remarks
        FROM 
            tbl_inquiry_remarks ir
        JOIN 
            (
                SELECT 
                    inq_student_id, 
                    MAX(remark_date) AS latest_remark_date
                FROM 
                    tbl_inquiry_remarks
                GROUP BY 
                    inq_student_id
            ) latest_ir 
        ON 
            ir.inq_student_id = latest_ir.inq_student_id 
            AND ir.remark_date = latest_ir.latest_remark_date
    ) latest_remarks 
ON pro.inq_student_id = latest_remarks.inq_student_id 
LEFT JOIN 
    tbl_call_status call_status ON latest_remarks.call_rating = call_status.id
WHERE 
    pro.is_delete = ? ";


// $cmd= "SELECT 
//     pro.is_admission_confirm AS is_admission_confirm, 
//     pro.id AS id, 
//     pro.last_exam_status AS exam_status,
//     staff2.name AS counselor_name,
//     pro.is_admission_confirm AS admission_status, 
//     pro.staff_id AS staff_id, 
//     staff.name AS staff_name, 
//     pro.inq_student_id AS inq_student_id, 
//     pro.first_name AS first_name, 
//     pro.middle_name AS middle_name, 
//     pro.last_name AS last_name, 
//     pro.gender AS gender, 
//     pro.dob AS dob, 
//     pro.mobile_number AS mobile_number, 
//     pro.mobile_number2 AS mobile_number2, 
//     pro.email AS email, 
//     pro.faculty_id AS faculty_id,
//     pro.level_id AS level_id,
//     pro.program_id AS program_id,
//     pro.last_exam AS last_exam,
//     pro.last_exam_marks AS last_exam_mark,
//     pro.is_online AS is_online,
//     faculty.name AS faculty_name,
//     level.name AS level_name, 
//     program.name AS program_name,
//     lr.remarks AS latest_remarks
// FROM 
//     tbl_inquiry_student AS pro
// LEFT JOIN 
//     tbl_faculty faculty ON pro.faculty_id = faculty.id 
// LEFT JOIN 
//     tbl_level level ON pro.level_id = level.id               
// LEFT JOIN 
//     tbl_program program ON pro.program_id = program.id
// LEFT JOIN 
//     tbl_staff staff ON pro.staff_id = staff.id  
// LEFT JOIN 
//     tbl_staff staff2 ON pro.counselor_id = staff.id  
// LEFT JOIN 
//     (
//         SELECT 
//             ir.id, 
//             ir.inq_student_id, 
//             ir.remarks
//         FROM 
//             tbl_inquiry_remarks ir
//         JOIN (
//             SELECT 
//                 inq_student_id, 
//                 MAX(remark_date) AS latest_remark_date
//             FROM 
//                 tbl_inquiry_remarks
//             GROUP BY 
//                 inq_student_id
//         ) latest_ir 
//         ON 
//             ir.inq_student_id = latest_ir.inq_student_id 
//             AND ir.remark_date = latest_ir.latest_remark_date
//     ) lr ON pro.inq_student_id = lr.inq_student_id
// WHERE 
//     pro.is_delete = ? ";
 
if ($url_for == "inq") {
    $cmd .= " AND pro.is_admission_confirm  = '0'";
} elseif ($url_for == "admission_confirm") {
    $cmd .= " AND pro.is_admission_confirm ='1' ";
}
if ($url_faculty_id != "") {
    $cmd .= " AND pro.faculty_id = '$url_faculty_id' ";
}
// else{
//      $cmd .= " AND pro.faculty_id IS NULL ";
// }
if ($url_level_id != "") {
    $cmd .= " AND pro.level_id = '$url_level_id' ";
}
if ($url_program_id != "") {
    $cmd .= " AND pro.program_id = '$url_program_id' ";
}
//   $cmd .= " LIMIT ?,? ";

// Log the cmd
//  error_log($cmd);
//  try {
//     $stmt = $con->prepare($cmd);
//     $stmt->bind_param("iii", $status, $start, $end);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $data = $result->fetch_all(MYSQLI_ASSOC);
//     echo json_encode($data);
// } catch (mysqli_sql_exception $e) {
//     error_log($e->getMessage());
//     echo json_encode(['error' => 'An error occurred while processing your request.']);
// }

$cmd = $con->prepare($cmd);
// $cmd->bind_param("iii", $status,$offset,$limit);
$cmd->bind_param("i", $status);
$cmd->execute();
$result = $cmd->get_result();
$data = array();
$sr = 0;


while ($row = $result->fetch_assoc()) {
    $sr++;

    if ($row['is_admission_confirm'] != 1) {
        $actionLink = '<a href="student_edit.php?id=' . $row['id'] . '" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>';
    } else {
        $actionLink = '<a href="student_edit.php?id=' . $row['id'] . '" onclick="return false;" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a> ';
    }
    $last_exam=$row['last_exam'];
    if (!empty($last_exam)) {
        switch ($last_exam) {
            case '1':
                $last_exam_name = "SSC";
                break;
            case '2':
                $last_exam_name = "HSC(A)";
                break;
            case '3':
                $last_exam_name = "HSC(B)";
                break;
            case '4':
                $last_exam_name = "UNDER GRADUATION (UG)";
                break;
            case '5':
                $last_exam_name = "HSC(COMMERCE)";
                break;
            case '6':
                $last_exam_name = "HSC(ARTS)";
                break;
            case '7':
                $last_exam_name = "POST GRADUATION (PG)";
                break;
            case '8':
                $last_exam_name = "ITI";
                break;
            case '9':
                $last_exam_name = "DIPLOMA";
                break;
            default:
                $last_exam_name = "<b>N/A</b>";
                break;
        }
    } else {
        $last_exam_name = "<b>N/A</b>";
    }
$exam_status=$row['exam_status'];
    if ($exam_status == '1') {
        $status = "PASS";
    } elseif ($exam_status == '2') {
        $status = "Appeared";
    } elseif (!empty($exam_status)) {
        $status =  "<b>N/A</b>";
    }
    $is_online =$row['is_online'];
    if ($is_online == 0) {
        $mode = "Walk-In";
    } elseif ($is_online == 1) {
        $mode = "Website";
    } elseif ($is_online == 2) {
        $mode = "WhatsApp";
    } elseif ($is_online == 3) {
        $mode = "Other";
    } elseif ($is_online == 4) {
        $mode = "Walk In";
    } elseif ($is_online == 5) {
        $mode = "E-Mail";
    }
   $is_admission_confirm = $row['admission_status'];
    if ($is_admission_confirm == 0) {
          $admission_status = "Inquiry";
    } elseif ($is_admission_confirm == 1) {
           $admission_status = "Admission confirm";
    }

    $data[] = array(
        "Sr" => $sr,   
         "Id" => isset($row['id']) ? $row['id'] : 'N/A',
        "Inquiry Id" => isset($row['inq_student_id']) ? $row['inq_student_id'] : 'N/A',
        "First Name" => isset($row['first_name']) ? $row['first_name'] : 'N/A',
        "Middle Name" => isset($row['middle_name']) ? $row['middle_name'] : 'N/A',
        "Last Name" => isset($row['last_name']) ? $row['last_name'] : 'N/A',
        "Gender" => isset($row['gender']) ? $row['gender'] : 'N/A',
        "last_school_name" => $row['last_school_name'] ?? 'N/A',
        "Mobile Number 1" => isset($row['mobile_number']) ? $row['mobile_number'] : 'N/A',
        "Mobile Number 2" => isset($row['mobile_number2']) ? $row['mobile_number2'] : 'N/A',
        "Email" => isset($row['email']) ? $row['email'] : 'N/A',
        "Faculty Name" => isset($row['faculty_name']) ? $row['faculty_name'] : 'N/A',
        "Level Name" => isset($row['level_name']) ? $row['level_name'] : 'N/A',
        "Program Name" => isset($row['program_name']) ? $row['program_name'] : 'N/A',
        "Last Exam" => isset($last_exam_name) ? $last_exam_name : 'N/A',
        "Last Exam Status" => isset($status) ? $status : 'N/A',
        "Status" => isset($admission_status) ? $admission_status : 'N/A',
        "Inquiry Mode" => isset($mode) ? $mode : 'N/A',
        "Assign Staff" => isset($row['staff_name']) ? $row['staff_name'] : 'N/A',
        "Counselor" => isset($row['counselor_name']) ? $row['counselor_name'] : 'N/A',
        "Call_rate" => isset($row['call_title']) ? $row['call_title'] : 'N/A',
        "Last Remarks" => isset($row['latest_remarks']) ? $row['latest_remarks'] : 'N/A',
        "Remarks" => '<a href="../common/fetch_remarks.php?id2=' . (isset($row['inq_student_id']) ? $row['inq_student_id'] : 'N/A') . '" class="btn btn-primary"><i class="fa fa-eye"></i></a>',
        "Action" => $actionLink,
        // Add more fields as needed
    );
}

// Wrap the data in a results array
$results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
);

// Send the JSON response
echo json_encode($results);
exit;
