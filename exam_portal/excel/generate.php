<?php
include '../include/checklogin.php';
ob_start(); // Start output buffering to prevent "headers already sent" issue

if (isset($_POST['exam_id'])) {

    $exam_id = $_POST['exam_id'];

    $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.semester as semester, std.is_active as std_is_active, std.type as type , std.session as session , std.start_date as start_date, std.end_date as end_date, std.year as year,
    faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_exam_form as std
    LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
    LEFT JOIN tbl_level level ON std.level_id = level.id 
    LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = 0 AND std.id = ? ");
    $cmd->bind_param("i", $exam_id);
    $cmd->execute();
    $result = $cmd->get_result();
    while ($row = $result->fetch_assoc()) {
        $semester = $row['semester'];

        $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
        $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
        $Syllabus = !empty($row['Syllabus']) ? $row['Syllabus'] : "<b>N/A</b>";
        $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
        $sem = !empty($row['semester']) ? $row['semester'] : "<b>N/A</b>";
        $std_is_active = $row['std_is_active'];
        $exam_type = $row['type'];
        $exam_session = $row['session'];
        if ($row['type'] == "regular") {
            $exam_type = "REGULAR";
        } else {
            $exam_type = "REMEDIAL";
        }

        $exam_name = $faculty_name . ' ' . $level_name . ' ' . $program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year'];
    }


    $query = "SELECT id, exam_id, subject_code, seat_no FROM tbl_exam_results WHERE exam_id = ? GROUP BY subject_code, exam_id";

    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $exam_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Create Excel file
    $filename = 'IM-' . $exam_name . '.xls';

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Start Excel file
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"\n";
    echo " xmlns:o=\"urn:schemas-microsoft-com:office:office\"\n";
    echo " xmlns:x=\"urn:schemas-microsoft-com:office:excel\"\n";
    echo " xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"\n";
    echo " xmlns:html=\"http://www.w3.org/TR/REC-html40\">\n";

    while ($row = $result->fetch_assoc()) {

        $subject_code = $row['subject_code'];
        $id = $row['id'];
        $exid = $row['exam_id'];
        $in = 1;

        echo "<Worksheet ss:Name=\"" . $subject_code . "\">\n";
        echo "<Table>\n";
        echo "<Row>\n";
        echo "<Cell><Data ss:Type=\"String\">Seat No</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">Subject Code</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">Enrollment No</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">MSE</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">RMSE</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">PRACTICAL</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">VIVA</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">ALA</Data></Cell>\n";

        echo "</Row>\n";


        $query22 = "SELECT id, enrollnment_no, exam_id, subject_code, seat_no 
        FROM tbl_exam_results 
        WHERE exam_id = ? AND subject_code = ? 
        ORDER BY enrollnment_no ASC";
        $stmt22 = $con->prepare($query22);
        $stmt22->bind_param("is", $exid, $subject_code);
        $stmt22->execute();
        $result22 = $stmt22->get_result();
        while ($row22 = $result22->fetch_assoc()) {
            echo "<Row>\n";
            echo "<Cell><Data ss:Type=\"String\">" . $row22['seat_no'] . "</Data></Cell>\n";
            echo "<Cell><Data ss:Type=\"String\">" . $row22['subject_code'] . "</Data></Cell>\n";
            echo "<Cell><Data ss:Type=\"String\">" . $row22['enrollnment_no'] . "</Data></Cell>\n";
            echo "<Cell><Data ss:Type=\"String\"></Data></Cell>\n";
            echo "<Cell><Data ss:Type=\"String\"></Data></Cell>\n";
            echo "<Cell><Data ss:Type=\"String\"></Data></Cell>\n";
            echo "<Cell><Data ss:Type=\"String\"></Data></Cell>\n";
            echo "<Cell><Data ss:Type=\"String\"></Data></Cell>\n";

            echo "</Row>\n";
        }
        echo "</Table>\n";
        echo "</Worksheet>\n";
    }
    echo "</Workbook>";

    // Close the database connection
    $stmt->close();
    $con->close();
    exit(); // Add exit to prevent any additional output
}
