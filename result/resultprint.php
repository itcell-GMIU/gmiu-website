<?php
include '../database/connect.php';
include '../common/validation.php';
include '../common/globalvariable.php';

$faculty_id = '';
if (isset($_POST['exam_id']) && isset($_POST['erNo'])) {
    $exam_id = $_POST['exam_id'];
    $enrollnment_no = $_POST['erNo'];
    $status = 0;
    function getExamDetailsById($con, $exam_id)
    {
        global $faculty_id;
        global $level_id;
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

            $faculty_name = !empty($row['faculty_name']) ? ucwords(strtolower($row['faculty_name'])) : "<b>N/A</b>";
            $level_name = !empty($row['level_name']) ? ucwords(strtolower($row['level_name'])) : "<b>N/A</b>";
            $Syllabus = !empty($row['Syllabus']) ? ucwords(strtolower($row['Syllabus'])) : "<b>N/A</b>";
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

            if ($id == $exam_id) {
                $exam_name = ucwords(strtolower($program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year']));

                return array(
                    'id' => $id,
                    'level_id' => $level_id,
                    'program_id' => $program_id,
                    'semester' => $semester,
                    'faculty_name' => $faculty_name,
                    'level_name' => $level_name,
                    'Syllabus' => $Syllabus,
                    'program_name' => $program_name,
                    'sem' => $sem,
                    'std_is_active' => $std_is_active,
                    'exam_type' => $exam_type,
                    'exam_session' => $exam_session,
                    'year' => $row['year'],
                    'exam_name' => $exam_name
                );
            }
        }

        return array(); // Return an empty array if no matching exam_id is found
    }

    // Example usage:
    $exam_id_to_lookup = $exam_id; // Replace with the actual exam_id you want to look up
    $exam_details = getExamDetailsById($con, $exam_id_to_lookup);

    $cmd22 = $con->prepare("SELECT ts.first_name as first_name, ts.middle_name as middle_name, ts.last_name as last_name, tes.seat_no as seat_no, tes.enrollnment_no as enrollnment_no,  tes.exam_sgpa as exam_sgpa, tes.exam_cgpa as exam_cgpa, tes.total_credit as total_credit, tes.total_credit_point as total_credit_point, tes.is_pass as is_pass, tes.total_backlog as backlog FROM tbl_students_2023 as ts LEFT JOIN tbl_exam_student as tes ON ts.enrollnment_no = tes.enrollnment_no WHERE tes.enrollnment_no = ? AND tes.exam_id = ? AND tes.is_delete = ? AND tes.status = 3");
    $cmd22->bind_param("sii", $enrollnment_no, $exam_id, $status);
    $cmd22->execute();
    $result22 = $cmd22->get_result();

    if ($result22->num_rows == 0) {
        $showID = 0;
        $_SESSION['status'] = "No Data Found!";
        $_SESSION['status_code'] = "success";
        echo "<script>alert('No Data Found!');
        setTimeout(function(){window.location='checkresult.php'},5)</script>";
    } else {
        $showID = 1;
        while ($row22 = $result22->fetch_assoc()) {
            $std_name = ucwords(strtolower($row22["first_name"])) . ' ' . ucwords(strtolower($row22["middle_name"])) . ' ' . ucwords(strtolower($row22["last_name"]));
            $ernumber = $row22['enrollnment_no'];
            $seat = $row22['seat_no'];
            $total_credit = $row22['total_credit'];
            $total_credit_point = $row22['total_credit_point'];
            $exam_sgpa = sprintf("%.2f", $row22['exam_sgpa']);
            $exam_cgpa = sprintf("%.2f", $row22['exam_cgpa']);
            $backlog = $row22['backlog'];
            $is_pass = $row22['is_pass'];
            if ($row22['is_pass'] == 1) {
                $rsStatus = "Pass";
            } else {
                $rsStatus = "Fail";
            }
        }
    }

    $cmd33 = "SELECT * FROM tbl_clg_name WHERE is_delete = '0' AND is_active = '1' AND FIND_IN_SET('$faculty_id', faculty_id) > 0 AND FIND_IN_SET('$level_id', level_id) > 0";
    $stmt33 = $con->prepare($cmd33);
    $stmt33->execute();
    $result33 = $stmt33->get_result();

    if ($result33->num_rows > 0) {
        while ($row33 = $result33->fetch_assoc()) {
            $clg_name =  $row33['clg_name'];
        }
    }

    $cmdMonth = $con->prepare("SELECT date FROM tbl_exam_timetable WHERE exam_id = ?");
    $cmdMonth->bind_param("i", $exam_id);
    $cmdMonth->execute();
    $resultexamMonth = $cmdMonth->get_result();
    while ($exmSUBMonth = $resultexamMonth->fetch_assoc()) {
        $MonthExam = $exmSUBMonth['date'];
        $month = date("F", strtotime($MonthExam));
        $year = date("Y", strtotime($MonthExam));
    }

    $exm_year = $exam_details['year'];
    $exm_year2 = $exam_details['year'] + 1;
    if ($showID = 1) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>GMIU - Result</title>
            <link rel="stylesheet" href="style.css">
        </head>

        <body>
            <header>
                <!-- <div class="logo">
            <img src="gmiulogo.webp" alt="GMIU">
        </div> -->
            </header>
            <main>
                <table class="table" style="margin-bottom:10px;">
                    <thead>
                        <tr>
                            <th class=" capitalized gmit">Semester Grade Report</th>
                        </tr>
                    </thead>
                </table>
                <table class="table" style="margin-bottom:10px;">
                    <thead class="tbhd">
                        <tr>
                            <th>Gyanmanjari Innovative University</th>
                        </tr>
                    </thead>
                </table>
                <table class="tb-1 table">
                    <thead class="tbhd">
                        <tr>
                            <th>Academic Year</th>
                            <th>Semester</th>
                            <th>Year of Examination</th>
                            <!-- <th>Statement No.</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="capitalized"><?= $exm_year . '-' . $exm_year2 ?></td>
                            <td class="capitalized"><?= $semester ?></td>
                            <td class="capitalized"><?= $month . '-' . $year ?></td>
                            <!-- <td>2301</td> -->
                        </tr>
                    </tbody>
                </table>
                <table class="tb-2 table">
                    <thead class="i-name">
                        <tr>
                            <th>Institute Name</th>
                            <th class=" capitalized gmit"><?= $clg_name ?></th>
                        </tr>
                    </thead>
                </table>
                <table class="tb-3 table">
                    <thead>
                        <tr>
                            <th>Program Name</th>
                            <th>Branch Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="capitalized"><?= $exam_details['level_name'] ?></td>
                            <td class="capitalized"><?= ucwords(strtoupper($exam_details['program_name'])) ?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="tb-2 tb-4 table">
                    <thead>
                        <tr class="tb-4-th">
                            <th>Student Name</th>
                            <th class=" capitalized gmit"><?= $std_name ?></th>
                        </tr>
                    </thead>
                </table>
                <table class="tb-2 tb-4 table">
                    <thead>
                        <tr class="tb-4-th">
                            <th>Enrollment No.</th>
                            <th class=" capitalized gmit"><?= $ernumber ?></th>
                            <th>Seat No.</th>
                            <th class=" capitalized gmit"><?= $seat ?></th>
                        </tr>
                    </thead>
                </table>
                <table class="tb-5 table">
                    <thead>
                        <tr class="tb-5-th">
                            <th rowspan="2">Course Code</th>
                            <th rowspan="2">Course Name</th>
                            <th rowspan="2">Course Credit</th>
                            <th rowspan="2">SEE Absent</th>
                            <th colspan="2">SEE</th>
                            <th colspan="3">CCE</th>
                            <th rowspan="2">Course Grade</th>
                            <th rowspan="2">Credit Point</th>
                        </tr>

                        <tr>
                            <th>T</th>
                            <th>P</th>
                            <th>M</th>
                            <th>I</th>
                            <th>V</th>
                        </tr>
                    </thead>

                    <tbody class="tbb tb-5-th">
                        <?php
                        $is_aproved = 1;
                        $cmdSUB = $con->prepare("SELECT * FROM tbl_final_exam_results WHERE enrollnment_no = ? AND seat_no = ? AND exam_id = ? AND is_approved = ?");
                        $cmdSUB->bind_param("sssi", $enrollnment_no, $seat, $exam_id, $is_aproved);
                        $cmdSUB->execute();
                        $resultexamSUB = $cmdSUB->get_result();
                        while ($exmSUB = $resultexamSUB->fetch_assoc()) {

                            $cmdSUBFetch = $con->prepare("SELECT subject_name, credit FROM tbl_subject_master WHERE  subject_code = ?");
                            $cmdSUBFetch->bind_param("s", $exmSUB['subject_code']);
                            $cmdSUBFetch->execute();
                            $resultexamSUBFetch = $cmdSUBFetch->get_result();
                            while ($exmSUBFetch = $resultexamSUBFetch->fetch_assoc()) {
                                $subject_name = $exmSUBFetch['subject_name'];
                                $credit = $exmSUBFetch['credit'];
                            }
                            $subject_name = str_replace("?", " ", $subject_name);
                            // $cmdDATEFetch = $con->prepare("SELECT ");
                            // $cmdDATEFetch->bind_param("s", $e);
                            // $cmdDATEFetch->execute();
                            // $resultexamDATEFetch = $cmdDATEFetch->get_result();
                            // while ($exmDATEFetch = $resultexamDATEFetch->fetch_assoc()) {
                            //     $subject_name = $exmDATEFetch['subject_name'];
                            // }
                        ?>
                            <tr>
                                <td class=""><?= $exmSUB['subject_code'] ?></td>
                                <td class=""><?= $subject_name ?></td>
                                <td class=""><?= $credit ?></td>
                                <td class=""><?= ($exmSUB['is_absent'] == 1) ? "Y" : "-" ?></td>
                                <td class=""><?= $exmSUB['gradeTHEORY'] ?? '-' ?></td>
                                <td class=""><?= $exmSUB['gradePRACTICAL'] ?? '-' ?></td>
                                <td class=""><?= $exmSUB['gradeMID'] ?? '-' ?></td>
                                <td class=""><?= $exmSUB['gradeALA'] ?? '-' ?></td>
                                <td class=""><?= $exmSUB['gradeVIVA'] ?? '-' ?></td>
                                <td class=""><?= $exmSUB['gradeFINAL'] ?? '-' ?></td>
                                <td class=""><?= $exmSUB['credit_point_total'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <table class="tb-2 tbb tb-6 table">
                    <thead class="tb-6-th">
                        <tr>
                            <th rowspan="2">Backlog</th>
                            <th>Sem.I</th>
                            <th>Sem.II</th>
                            <th>Sem.III</th>
                            <th>Sem.IV</th>
                            <th>Sem.V</th>
                            <th>Sem.VI</th>
                            <th>Sem.VII</th>
                            <th>Sem.VIII</th>
                        </tr>
                        <tr>
                            <?php
                            if ($semester == 1) {
                            ?>
                                <th class=" capitalized gmit"><?= $backlog ?></th>
                                <th class=" capitalized gmit">0</th>
                                <th class=" capitalized gmit">0</th>
                                <th class=" capitalized gmit">0</th>
                                <th class=" capitalized gmit">0</th>
                                <th class=" capitalized gmit">0</th>
                                <th class=" capitalized gmit">0</th>
                                <th class=" capitalized gmit">0</th>
                            <?php
                            } elseif ($semester == 3) {
                            ?>
                                <th class=" capitalized gmit">0</th>
                                <th class=" capitalized gmit">0</th>
                                <th class=" capitalized gmit"><?= $backlog ?></th>
                                <th class=" capitalized gmit">0</th>
                                <th class=" capitalized gmit">0</th>
                                <th class=" capitalized gmit">0</th>
                                <th class=" capitalized gmit">0</th>
                                <th class=" capitalized gmit">0</th>
                            <?php
                            }
                            ?>

                        </tr>
                    </thead>
                </table>
                <table class="tb-7 table">
                    <thead class="tb-7-th">
                        <tr>
                            <th>Credits</th>
                            <th>Credit Point</th>
                            <th>SGPA</th>
                            <th>Total Credits</th>
                            <th>Total Credit Point</th>
                            <th>CGPA</th>
                            <th>Attempt</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $total_credit ?></td>
                            <td><?= $total_credit_point ?></td>
                            <td><?= $exam_sgpa ?></td>
                            <td><?= $total_credit ?></td>
                            <td><?= $total_credit_point ?></td>
                            <td><?= $exam_cgpa ?></td>
                            <td>First</td>
                            <td><?= $rsStatus ?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table" style="margin-bottom:10px;">
                    <thead>
                        <tr>
                            <?php
                            if ($is_pass == 1) {
                            ?>
                                <br>
                                <th class="" style="color: green; background-color:white; border:none;"><b>Congratulations! You have passed this exam.</b></th>
                            <?php
                            } else {
                            ?>
                                <br>
                                <th class="" style="color: red; background-color:white; border:none;"><b>Sorry! You have not cleared this exam.</b></th>
                            <?php
                            }
                            ?>
                        </tr>
                    </thead>
                </table>
                <table class="table" style="margin-bottom:10px;">
                    <thead>
                        <tr>
                            <th class="capitalized gmit" style="text-align: left; ">
                                <p>Printed On : <?= date("Y-m-d H:i:s")  ?></p><br>
                                <p> This is automated generated marksheet, please consider the hard copy Gradesheet as final result.</p>
                            </th>
                        </tr>
                    </thead>
                </table>
            </main>
            <!-- Print Button -->
            <div class="text-center">
                <button class="btn btn-primary print-btn" id="print-btn" onclick="printA()">Print</button>
            </div>
        </body>

        <script>
            function printA() {
                if (typeof Android !== "undefined" && Android.print) {
                    Android.print();
                } else {
                    window.print();
                }
            }
        </script>

        </html>

<?php
    }
} else {
    echo "Invalid Request!";
}
?>