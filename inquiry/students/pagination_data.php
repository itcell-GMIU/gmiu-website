<?php
include "../include/checklogin.php";

$url_for = isset($_GET['url_for']) ? $_GET['url_for'] : ''; // Change 'url_for' to the actual parameter name
$url_faculty_id = isset($_GET['url_faculty_id']) ? $_GET['url_faculty_id'] : '';
$url_level_id = isset($_GET['url_level_id']) ? $_GET['url_level_id'] : '';
$url_program_id = isset($_GET['url_program_id']) ? $_GET['url_program_id'] : '';

$status = 0;
$cmd = "SELECT 
    pro.is_admission_confirm as is_admission_confirm,
    pro.id as id,
    pro.last_exam_status as exam_status ,
    staff2.name as counselor_name,
    pro.is_admission_confirm as admission_status ,
    pro.id as id,pro.staff_id as staff_id ,
    staff.name as staff_name,
    pro.inq_student_id as inq_student_id,
    pro.first_name as first_name ,
    pro.middle_name as middle_name,
    pro.last_name as last_name,
    pro.last_school_name as last_school_name,
    pro.gender as gender,
    pro.dob as dob,
    pro.mobile_number as mobile_number,
    pro.mobile_number2 as mobile_number2,
    pro.email as email,
    pro.faculty_id as faculty_id,
    pro.level_id as level_id,
    pro.program_id as program_id,
    pro.last_exam as last_exam,
    pro.last_exam_marks as last_exam_mark,
    pro.is_online as is_online,
    pro.call_count as call_count,
    faculty.name as faculty_name,
    level.name as level_name ,
    program.name as program_name
FROM 
    tbl_inquiry_student as pro
LEFT JOIN 
    tbl_faculty faculty ON pro.faculty_id = faculty.id 
LEFT JOIN
    tbl_level level ON pro.level_id = level.id 
LEFT JOIN 
    tbl_program program ON pro.program_id = program.id
LEFT JOIN 
    tbl_staff staff ON pro.staff_id = staff.id  
LEFT JOIN 
    tbl_staff staff2 ON pro.confirm_by = staff.id  
WHERE pro.is_delete = ? 
";
//AND R.call_rating != 13 
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
    $cmd .= " AND pro.is_admission_confirm  = '0' 
                AND pro.inq_student_id NOT IN (
            SELECT inq_student_id
            FROM tbl_inquiry_remarks
            WHERE is_followup_need = 0
            GROUP BY inq_student_id )  ";
} elseif ($url_for == "admission_confirm") {
    $cmd .= " AND pro.is_admission_confirm ='1' ";
}
if ($url_faculty_id != "") {
    $cmd .= " AND pro.faculty_id = '$url_faculty_id' ";
}
if ($url_level_id != "") {
    $cmd .= " AND pro.level_id = '$url_level_id' ";
}
if ($url_program_id != "") {
    $cmd .= " AND pro.program_id = '$url_program_id' ";
}
$cmd .=" ORDER BY pro.id;";
$cmd = $con->prepare($cmd);
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
        "inquiry Id" => $row['inq_student_id'] ?? 'N/A',
        "First Name" => $row['first_name'] ?? 'N/A',
        "middle Name" => $row['middle_name'] ?? 'N/A',
        "Last Name" => $row['last_name'] ?? 'N/A',
        "Gender" => $row['gender'] ?? 'N/A',
        "last_school_name" => $row['last_school_name'] ?? 'N/A',
        "Mobile Number 1" => $row['mobile_number'] ?? 'N/A',
        "Mobile Number 2" => $row['mobile_number2'] ?? 'N/A',
        "Email" => $row['email'] ?? 'N/A',
        "Faculty Name" => $row['faculty_name'] ?? 'N/A',
        "Level Name" => $row['level_name'] ?? 'N/A',
        "Program Name" => $row['program_name'] ?? 'N/A',
        "Last Exam" => $last_exam_name ?? 'N/A',
        "Last Exam Status" =>  $status ?? 'N/A',
        "Status" =>    $admission_status ?? 'N/A',
        "Inquiry Mode" => $mode ?? 'N/A',
        "Assign Staff" => $row['staff_name'] ?? 'N/A',
        "Counselor" => $row['counselor_name'] ?? 'N/A',
        "call_count" => $row['call_count'] ?? 'N/A',
        
        // "last Remarks"=> $row['latest_remarks'] ?? 'N/A',
        "Remarks" => '<a href="../common/fetch_remarks.php?id2=' . $row['inq_student_id'] . '" class="btn btn-primary"><i class="fa fa-eye"></i></a>', // Add remarks field if available in your database
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
