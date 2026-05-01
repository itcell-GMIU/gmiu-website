<?php
include '../include/checklogin.php';
if ($role_id == 51) {

    $totalMark = array(
        90 => '50',
        100 => '60',
        175 => '100',
        180 => '100',

    );
    if (isset($_GET['id'])) {
        $Id = $_GET['id'];
        $Id = only_digits($Id); // Corrected variable name

        if ($Id === false) {
            $_SESSION['status'] = "Invalid data in URL";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='view_generate_paper.php'},1000)</script>";
        }
    }
    $status = 0;
    $cmd = $con->prepare("SELECT p.id, c.id ,c.subject_code,c.sem, p.total_mark, p.question, c.subject_name,p.exam_date,
                  p.exam_time,p.end_time, p.exam_name,p.clg_name 
                      FROM tbl_paper p
                      JOIN tbl_std_corner_exam c ON p.subject_code = c.id
                      WHERE p.id = ? AND p.is_delete = ?");
    $cmd->bind_param("ii", $Id, $status);
    $cmd->execute();
    $result1 = $cmd->get_result();
    while ($row1 = $result1->fetch_assoc()) {
        $id = $row1['id'];
        $subjectCode = $row1['subject_code'];
        $totalMarks = $row1['total_mark'];
        $sem = $row1['sem'];
        $subjectid = $row1['id'];
        $question_ids = $row1['question'];
        $subject_name = $row1['subject_name'];
        $exam_date = $row1['exam_date'];
        $exam_time = $row1['exam_time'];
        $end_time = $row1['end_time'];
        $exam_name = $row1['exam_name'];
        $clg_name = $row1['clg_name'];
    }
    // Fetch Bloom's level weightage from the database
    $stmt_bl_level = $con->prepare("SELECT * FROM `tbl_bl_level` WHERE subject_code = ? AND is_delete = 0 ");
    $stmt_bl_level->bind_param("s", $subjectid);
    $stmt_bl_level->execute();
    $result_bl_level = $stmt_bl_level->get_result();
    $blMark = array(
        'R' => 0,
        'U' => 0,
        'A' => 0,
        'N' => 0,
        'E' => 0,
        'C' => 0
    );
    $blMarks = array(
        'R' => 0,
        'U' => 0,
        'A' => 0,
        'N' => 0,
        'E' => 0,
        'C' => 0
    );

    while ($row = $result_bl_level->fetch_assoc()) {
        // Assign values to $blMarks based on column names from your database
        $blMark['R'] = $row['remembering'];
        $blMark['U'] = $row['understanding'];
        $blMark['A'] = $row['applying'];
        $blMark['N'] = $row['analyzing'];
        $blMark['E'] = $row['evaluating'];
        $blMark['C'] = $row['creating'];

        $blMarks['R'] = ($row['remembering'] / 100) * $totalMarks;
        $blMarks['U'] = ($row['understanding'] / 100) * $totalMarks;
        $blMarks['A'] = ($row['applying'] / 100) * $totalMarks;
        $blMarks['N'] = ($row['analyzing'] / 100) * $totalMarks;
        $blMarks['E'] = ($row['evaluating'] / 100) * $totalMarks;
        $blMarks['C'] = ($row['creating'] / 100) * $totalMarks;

        // You can echo or print each value here if needed
        // echo $blMarks['U']; // Example of echoing one of the values
    }


    // Calculate total questions choosable for each Bloom's level based on Bloom's level weightage
    $totalQuestionsPerBLLevel = array();
    $marksPerQuestion = 10;
    if ($totalMarks == 90) {
        $maxLevel = 9;
    } else {
        $maxLevel = 18;
    }
    $totalRemainingMarks1 = 0;
    if ($totalMarks == 90 || $totalMarks == 180) {
        $totalQuestions = 0;
        $highestLevel = null;
        $highestQuestions = 0;

        foreach ($blMarks as $level => $marks) {
            $totalQuestionsPerBLLevel[$level] = round($marks / $marksPerQuestion);
            $totalQuestions += $totalQuestionsPerBLLevel[$level];

            if ($totalQuestionsPerBLLevel[$level] > $highestQuestions) {
                $highestQuestions = $totalQuestionsPerBLLevel[$level];
                $highestLevel = $level;
            }
        }
        if ($totalQuestions > $maxLevel) {
            $tq = $totalQuestions - $maxLevel;
            $totalQuestionsPerBLLevel[$highestLevel] -= $tq;
        }
    } elseif ($totalMarks == 175) {
        foreach ($blMarks as $level => $marks) {
            // Calculate total questions, subtracted value, and remaining marks
            $totalQuestions[$level] = floor($marks / 5);
            $subtractedValue[$level] = $totalQuestions[$level] * 5;
            $remainingMarks[$level] = $marks - ($totalQuestions[$level] * 5);

            $totalRemainingMarks1 += $remainingMarks[$level];

            // echo "total Value : {$totalQuestions[$level]} ";
            // Output the level, remaining marks, and subtracted value
            // echo "Level: $level<br>";
            // echo "Remaining Marks: {$remainingMarks[$level]}<br>";
            //   echo "Subtracted Value: {$subtractedValue[$level]}<br>"; 
        }
        $minSubtractedValue = min(array_values(array_diff($subtractedValue, [0])));
        //    echo "min: $minSubtractedValue<br>";

        // Output the adjusted subtracted value for each chapter
        foreach ($blMarks as $level => $marks) {
            // Adjust the subtracted value only in the chapter with the minimum subtracted value
            if ($minSubtractedValue == $subtractedValue[$level]) {
                // Debug statements
                // echo "Level $level: {$blMarks[$level]}<br>";
                // echo "Marks before adjustment: $marks<br>";
                // echo "Total Remaining Marks: $totalRemainingMarks1<br>";
                // echo "Minimum Subtracted Value: $minSubtractedValue<br>";
                // $blMarks[$level] = $totalRemainingMarks1 + $minSubtractedValue;
                $blMarks[$level] = round($totalRemainingMarks1 + $minSubtractedValue);  // Rounded to the nearest integer

                // Debug statements
                // echo "Adjusted Subtracted Value $level: {$blMarks[$level]}<br>";
            } else {
                $blMarks[$level] = $subtractedValue[$level];
                // echo "Adjusted bl marks Subtracted Value $level: {$blMarks[$level]}<br>";
            }
        }
    }
    //  // Pass the JSON strings to JavaScript as variables
    //  echo "<script>";
    //  echo "var blMarks = " . json_encode($blMarks) . ";";
    //  //echo" console.log(blMarks);"; 
    //  echo "</script>";



    // Fetch chapter weightage from the database
    $stmt_w = $con->prepare("SELECT * FROM tbl_weightage WHERE subject_code = ?  AND is_delete = '0'");
    $stmt_w->bind_param("i", $subjectid); // Assuming you have the subject ID
    $stmt_w->execute();
    $result_weightage = $stmt_w->get_result();

    // Initialize an array to store the total marks available for each chapter
    $chapterMarks = array();

    // Calculate total marks available for each chapter
    while ($row = $result_weightage->fetch_assoc()) {
        $chapter = $row["chapter"];
        $chapterMarks[$chapter] = ($row["chapter_weight"] / 100) * $totalMarks;
        //  echo "Chapter $chapter: {$chapterMarks[$chapter]}<br>"; // Print marks for each chapter
    }
    // Calculate total questions choosable for each chapter based on chapter weightage

    $totalQuestionsPerChapter = array();
    $totalRemainingMarks = 0;

    if ($totalMarks == 90 || $totalMarks == 180) {
        $totalQuestions = 0;
        $highestLevel = null;
        $highestQuestions = 0;

        foreach ($chapterMarks as $chapter => $marks) {
            $totalQuestionsPerChapter[$chapter] = round($marks / $marksPerQuestion);
            $totalQuestions += $totalQuestionsPerChapter[$chapter];

            if ($totalQuestionsPerChapter[$chapter] > $highestQuestions) {
                $highestQuestions = $totalQuestionsPerChapter[$chapter];
                $highestLevel = $chapter;
            }
        }
        if ($totalQuestions > $maxLevel) {
            $tq = $totalQuestions - $maxLevel;
            $totalQuestionsPerChapter[$highestLevel] -= $tq;
        }
    } elseif ($totalMarks == 175) {
        foreach ($chapterMarks as $chapter => $marks) {
            $totalQuestions[$chapter] = floor($marks / 5);
            // Calculate total questions, subtracted value, and remaining marks
            $subtractedValue1[$chapter] = $totalQuestions[$chapter] * 5;
            $remainingMarks[$chapter] = $marks - ($totalQuestions[$chapter] * 5);

            $totalRemainingMarks += $remainingMarks[$chapter];
            // Output the level, remaining marks, and subtracted value
            // echo "Level: $level<br>";
            // echo "Chapter $chapter:{$chapterMarks[$chapter]}<br>";
            // echo "Remaining Marks $chapter: {$remainingMarks[$chapter]}<br>";
            // echo "Subtracted Value $chapter: {$subtractedValue1[$chapter]}<br>";
        }
        $allsame = count(array_unique($chapterMarks)) == 1;

        // Find the minimum subtracted value for all chapters
        $minSubtractedValue = min(array_values(array_diff($subtractedValue1, [0])));
        //    echo "min: $minSubtractedValue<br>";
        // echo $totalRemainingMarks;
        // Calculate total weightage and weightage per level
        $weightagePerLevel = $totalRemainingMarks / 5;
        // echo $weightagePerLevel;

        if ($allsame) {
            // Perform the adjustment only once
            // echo "hellow";
            $loopCompleted = false;
            foreach ($blMarks as $level => $marks) {
                foreach ($chapterMarks as $chapter => $value) {
                    $subtractedValue1[$chapter] += 5;
                    $chapterMarks[$chapter] = $subtractedValue1[$chapter];
                    // echo "$weightagePerLevel";
                    // echo "Adjusted Subtracted Value $chapter: {$chapterMarks[$chapter]}<br>";
                    $weightagePerLevel--;
                    if ($weightagePerLevel <= 0) {
                        $loopCompleted = true;
                        break 2; // Break out of both loops
                    }
                }
            }

            // Assign remaining chapters the value of $subtractedValue1[$chapter]
            if ($loopCompleted) {
                foreach ($chapterMarks as $chapter => $value) {
                    if ($weightagePerLevel <= 0) {
                        $chapterMarks[$chapter] = $subtractedValue1[$chapter];
                        // echo "Remaining Adjusted Subtracted Value $chapter: {$chapterMarks[$chapter]}<br>";
                    }
                }
            }
        } else {
            // Output the adjusted subtracted value for each chapter
            foreach ($chapterMarks as $chapter => $marks) {
                // Adjust the subtracted value only in the chapter with the minimum subtracted value
                if ($minSubtractedValue == $subtractedValue1[$chapter]) {
                    // Debug statements
                    // echo "Chapter: $chapter<br>";
                    // echo "Marks before adjustment: $marks<br>";
                    // echo "Total Remaining Marks: $totalRemainingMarks<br>";
                    // echo "Minimum Subtracted Value: $minSubtractedValue<br>";
                    $chapterMarks[$chapter] = round($totalRemainingMarks + $minSubtractedValue);
                    // Debug statements
                    // echo "Adjusted Subtracted Value $chapter: {$chapterMarks[$chapter]}<br>";
                } else {
                    $chapterMarks[$chapter] = $subtractedValue1[$chapter];
                    //   echo "Adjusted Subtracted Value $chapter: {$chapterMarks[$chapter]}<br>";
                }
            }
        }
    }



    ?>

    <!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://unpkg.com/docx@7.1.0/build/index.umd.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
        <?php include '../include/importcss.php'; ?>
        <!-- Bootstrap CSS -->
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> -->

        <!-- <title>Gyanmanjari Institute of Technology</title> -->

        <style>
            /* Remove unnecessary scrollbar styles */
            #acedemic::-webkit-scrollbar {
                display: none;
                /* for Chrome, Safari, and Opera */
            }

            * {
                font-family: "Century Schoolbook", Georgia, serif;
            }

            .a4-page {
                width: 210mm;
                min-height: 297mm;
                margin: 20px auto;
            }

            .a4-page {
                margin-top: 0px !important;
            }

            .table-responsive {
                overflow-x: unset !important;

            }

            table {
                border-collapse: collapse;
                margin: 0.5rem 0.5rem;
                width: 100%;
                table-layout: flex;
            }

            thead {
                display: table-header-group;
            }

            .table th {
                padding: 0rem;
            }

            th,
            td {
                border: none !important;
                padding: 0;
            }

            .table td {
                font-size: 16pt;
                padding: 0rem;
            }

            table.dataTable td,
            table.dataTable th {
                -webkit-box-sizing: content-box;
                box-sizing: content-box;
                vertical-align: top;
                line-height: 1.7;
            }

            /* Prevent header content from breaking into multiple lines */
            .header-info {
                white-space: nowrap;
                /* Prevent line breaks */
            }

            .custom-line-height {
                line-height: 1.5;
            }

            p {
                margin-top: 0;
                margin-bottom: 0rem;
            }

            .custome-width-th {
                width: 50%;
            }

            .hidden-row {
                display: none;
            }

            @media print {
                @page {
                    size: A4;
                    margin: 1.5cm 1cm 0.5cm 1cm !important;
                    /* top right bottom left */
                    /*margin: 0.5cm 1cm !important;*/
                }

                body {
                    font-family: "Century Schoolbook", Georgia, serif;
                    font-size: 16pt;
                    padding: 0;
                    margin: 0px !important;
                    line-height: 1.2;
                }

                .a4-page {
                    all: unset;
                }

                body {
                    margin: 0;
                    /* overflow-x: hidden;  */
                }

                /* Prevent header content from breaking into multiple lines */
                .header-info {
                    white-space: nowrap;
                    /* Prevent line breaks */
                }

                table thead tr th .ol {
                    margin-bottom: 0px !important;
                }

                .print-header {
                    display: block;
                    position: fixed;
                    top: 0px !important;
                    width: 100%;
                }

                .print-header~.print-header {
                    display: none;
                }

                thead {
                    display: table-header-group;
                }

                tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                }

                tfoot {
                    display: table-footer-group;
                }

                .container-fluid {
                    width: 100%;
                    margin: 0 auto;
                    padding: 0;
                }

                .table {
                    width: 100%;
                    page-break-after: auto;
                }

                .h1,
                .h4,
                .th {
                    font-size: 30pt;
                }

                .custom-line-height {
                    line-height: 1;
                }

                button {
                    display: none !important;
                }

                .print-btn,
                .no-print,
                .dataTables_wrapper .dt-buttons {
                    display: none !important;
                }

                #acedemic_wrapper {
                    display: none !important;
                }

                .a4-page {
                    margin-top: 0px !important;
                }

                .print-button {
                    display: inline-block;
                    text-align: center;
                    margin-top: 0px !important;
                }

                /* Make columns 1, 2, 4, 5, and 6 bold */
                table td:nth-child(1),
                table td:nth-child(2),
                table td:nth-child(4),
                table td:nth-child(5),
                table td:nth-child(6) {
                    font-weight: bold;
                }

                /* Apply 10px padding to the right side of columns 1 and 2 */
                table td:nth-child(1),
                table td:nth-child(2),
                table td:nth-child(3) {
                    padding-right: 10px;
                }
            }
        </style>

    </head>


    <body>
        <script>
            function exportToWord() {
                // Get the content div
                const contentDiv = document.getElementById('content');

                // Create a clone of the content to modify
                const contentClone = contentDiv.cloneNode(true);

                // Remove print button and DataTable controls from the clone
                const elementsToRemove = contentClone.querySelectorAll(
                    '.print-btn, .dt-buttons, .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate'
                );
                elementsToRemove.forEach(element => element.remove());

                // Get all the styles from the page
                let styles = '';
                for (const sheet of document.styleSheets) {
                    try {
                        for (const rule of sheet.cssRules) {
                            styles += rule.cssText;
                        }
                    } catch (e) {
                        console.log('Could not load styles from stylesheet', e);
                    }
                }

                const content =
                    `<html xmlns:o="urn:schemas-microsoft-com:office:office" 
                       xmlns:w="urn:schemas-microsoft-com:office:word" 
                       xmlns="http://www.w3.org/TR/REC-html40">
                    <head>
                        <meta charset="utf-8">
                        <title>Question Paper</title>
                        <style>
                            /* Hide DataTable elements in export */
                            .dt-buttons, .dataTables_length, 
                            .dataTables_filter, .dataTables_info, 
                            .dataTables_paginate, .print-btn {
                                display: none !important;
                            }
                            
                            /* A4 page setup */
                            @page {
                                size: A4 portrait;
                                margin: 1cm;
                                mso-page-orientation: portrait;
                            }
                            
                            body {
                                width: 21cm;
                                min-height: 29.7cm;
                                margin: 1cm;
                                padding: 0;
                                font-family: "Century Schoolbook", Georgia, serif;
                                font-size: 16pt;
                                line-height: 1.5;
                            }

                            .a4-page {
                                width: 21cm;
                                min-height: 29.7cm;
                                margin: 0 auto;
                                background: white;
                                box-sizing: border-box;
                            }
                            
                            /* Table styles */
                            table {
                                width: 100% !important;
                                border-collapse: collapse !important;
                                table-layout: fixed !important;
                                margin: 0 !important;
                            }
                            
                            td, th {
                                padding: 8px !important;
                                border: 1px solid black !important;
                                vertical-align: top !important;
                            }
                            
                            /* Make specific columns bold */
                            table td:nth-child(1),
                            table td:nth-child(2),
                            table td:nth-child(4),
                            table td:nth-child(5),
                            table td:nth-child(6) {
                                font-weight: bold !important;
                            }
                            
                            /* Header styles */
                            .header-info {
                                white-space: nowrap !important;
                            }
                            
                            /* Preserve table header on each page */
                            thead {
                                display: table-header-group !important;
                            }
                            
                            /* Prevent row breaks */
                            tr {
                                page-break-inside: avoid !important;
                            }

                            /* Custom line height */
                            .custom-line-height {
                                line-height: 1.5 !important;
                            }

                            /* Additional styles from your original CSS */
                            ${styles}
                        </style>
                    </head>
                    <body>
                        <div class="a4-page">
                            ${contentClone.outerHTML}
                        </div>
                    </body>
                </html>`;

            const blob = new Blob([content], {
                type: 'application/msword'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'question_paper.doc';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    </script>


    <button onclick="exportToWord()">Export as Word</button>

    <div class="wrapper a4-page">
        <button onclick="window.print()" class="print-btn"><i class="fa fa-print mr5"></i>Print</button>
        <div class="table-responsive" id="content">
            <table id="acedemic" class="dataTableLoad"
                style="overflow-x: auto; -ms-overflow-style: none; scrollbar-width: none;">

                <thead>
                    <!-- Visible row with colspan -->
                    <tr>
                        <th colspan="6" style="text-align: center; font-size :16pt;">
                            GYANMANJARI INNOVATIVE UNIVERSITY<br>
                            <?php echo $clg_name; ?><br>
                            <?php echo $exam_name; ?>
                        </th>
                    </tr>
                    <tr class="header-info">
                        <th colspan="3" style="padding: 0px 8px 8px 8px; text-align: left;">
                            <p>
                                Enrollment No.:_________________<br>
                                Subject Code: <?php echo $subjectCode; ?><br>
                                <!--Subject Name: <?php echo $subject_name; ?> <br>-->
                                <?php echo 'Subject Name: ' . (strlen($subject_name) > 40 ? preg_replace('/^(.{1,40})\s+/', '$1<br>', $subject_name) : $subject_name);
                                ?> <br>

                                Time: <?php echo $exam_time; ?> To <?php echo $end_time; ?><br>
                                Instructions:
                            </p>
                            <ol class="ol" style="margin-bottom: 0px;">
                                <li>Question No. 1 is Compulsory.</li>
                                <li>Make Suitable Assumptions wherever necessary.</li>
                                <li>Figures to the right indicate full marks.</li>
                            </ol>

                        </th>
                        <th colspan="3" style="padding: 0px 8px 8px 8px; text-align: left; vertical-align: top;">
                            Date: <?php echo $exam_date; ?><br>
                            Semester: <?php echo $sem; ?> <br>
                            Total Marks: <?php
                            foreach ($totalMark as $key => $totalmark) {
                                if ($key == $totalMarks) {
                                    echo $totalmark;
                                    break; // Exit the loop once the value is found
                                }
                            }
                            ?>
                        </th>
                    </tr>
                    <!-- Hidden row without colspan -->
                    <tr class="hidden-row">
                        <th style="padding: 8px; text-align: left;">
                            Enrollment No.:_________________<br>
                            Subject Code: <?php echo $subjectCode; ?><br>
                            Subject Name: <?php echo $subject_name; ?> <br>
                            Time:<br>
                            Instructions:
                            <ol>
                                <li>Question No. 1 is Compulsory.</li>
                                <li>Make Suitable Assumptions wherever necessary.</li>
                                <li>Figures to the right indicate full marks.</li>
                            </ol>
                        </th>
                        <th style="padding: 8px; text-align: left; vertical-align: top;">
                            Date:<br>
                            Semester: <?php echo $sem; ?> <br>
                            Total Marks: <?php
                            foreach ($totalMark as $key => $totalmark) {
                                if ($key == $totalMarks) {
                                    echo $totalmark;
                                    break; // Exit the loop once the value is found
                                }
                            }
                            ?>
                        </th>
                    </tr>
                    <!-- Column headers for the table content -->
                    <tr style=" font-size: 14pt;">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><b>Marks</b></th>
                        <th><b>CO</b></th>
                        <th><b>BL</b></th>
                    </tr>
                </thead>

                <?php
                if ($totalMarks == 90) {
                    ?>
                <tbody class="text-center tab-text">

                    <?php
                    // Split the string into an array of IDs
                    $id_array = explode(',', $question_ids);
                    $placeholders = implode(',', array_fill(0, count($id_array), '?'));

                    $status = 0;
                    $cmd = $con->prepare("SELECT que.id as id,
                    corner.sem as sem, 
                    que.subject_code as subject_code, 
                    que.chapter as chapter, 
                   COALESCE(NULLIF(que.modify_question, ''), que.question) AS question, 
                    que.marks as marks,
                    que.bl_level as bl_level, 
                    que.co_level as co_level
                    
                    FROM tbl_questions as que
                    LEFT JOIN tbl_std_corner_exam AS corner ON que.subject_code = corner.id
                    WHERE que.is_delete = ?  and que.id IN ($placeholders) and que.marks = 10");
                    $cmd->bind_param("i" . str_repeat('i', count($id_array)), $status, ...$id_array);

                    $cmd->execute();
                    $result = $cmd->get_result();

                    // Initialize arrays
                    $idArray = [];
                    $semArray = [];
                    $subjectCodeArray = [];
                    $chapterArray = [];
                    $questionArray = [];
                    $marksArray = [];
                    $blLevelArray = [];
                    $coLevelArray = [];

                    // Initialize array to store total marks for each CO
                    $coMarks = [
                        'CO1' => 0,
                        'CO2' => 0,
                        'CO3' => 0,
                        'CO4' => 0,
                        'CO5' => 0
                    ];

                    // Loop through each row fetched from the database
                    while ($row = $result->fetch_assoc()) {
                        // Store values into respective arrays
                        $idArray[] = $row['id'];
                        $semArray[] = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                        $subjectCodeArray[] = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                        $chapterArray[] = !empty($row['chapter']) ? $row['chapter'] : "<b>N/A</b>";
                        // $questionArray[] = !empty($row['question']) ? preg_replace('/[,]+/', '<br>', $row['question']) : "<b>N/A</b>";
                        $questionArray[] = !empty($row['question']) ? nl2br(htmlspecialchars($row['question'])) : "<b>N/A</b>";
                        $marksArray[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                        $blLevel = !empty($row['bl_level']) ? $row['bl_level'] : "<b>N/A</b>";
                        $blLevel = substr($blLevel, 0, 1);
                        $blLevelArray[] = $blLevel;

                        // Uppercase and trim CO level
                        $coLevel = !empty($row['co_level']) ? strtoupper(trim($row['co_level'])) : "<b>N/A</b>";
                        $coLevelArray[] = $coLevel;

                        // Update the total marks for each CO
                        if (isset($coMarks[$coLevel])) {
                            $coMarks[$coLevel] += (int) $row['marks'];
                        }
                    }


                    ?>
                    <tr>
                        <td>Q.1</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[0]; ?>
                        </td>
                        <td><?php echo $marksArray[0]; ?></td>
                        <td><?php echo $coLevelArray[0]; ?></td>
                        <td><?php echo $blLevelArray[0]; ?></td>
                    </tr>

                    <tr>
                        <td>Q.2</td>
                        <td>(a)</td>
                        <td style="text-align: left;"><?php echo $questionArray[1]; ?></td>
                        <td><?php echo $marksArray[1]; ?></td>
                        <td><?php echo $coLevelArray[1]; ?></td>
                        <td><?php echo $blLevelArray[1]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;"><?php echo $questionArray[2]; ?></td>
                        <td><?php echo $marksArray[2]; ?></td>
                        <td><?php echo $coLevelArray[2]; ?></td>
                        <td><?php echo $blLevelArray[2]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;">OR</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Q.2</td>
                        <td>(a)</td>
                        <td style="text-align: left;"><?php echo $questionArray[3]; ?></td>
                        <td><?php echo $marksArray[3]; ?></td>
                        <td><?php echo $coLevelArray[3]; ?></td>
                        <td><?php echo $blLevelArray[3]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;"><?php echo $questionArray[4]; ?></td>
                        <td><?php echo $marksArray[4]; ?></td>
                        <td><?php echo $coLevelArray[4]; ?></td>
                        <td><?php echo $blLevelArray[4]; ?></td>
                    </tr>

                    <tr>
                        <td>Q.3</td>
                        <td>(a)</td>
                        <td style="text-align: left;"><?php echo $questionArray[5]; ?></td>
                        <td><?php echo $marksArray[5]; ?></td>
                        <td><?php echo $coLevelArray[5]; ?></td>
                        <td><?php echo $blLevelArray[5]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;"><?php echo $questionArray[6]; ?></td>
                        <td><?php echo $marksArray[6]; ?></td>
                        <td><?php echo $coLevelArray[6]; ?></td>
                        <td><?php echo $blLevelArray[6]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;">OR</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Q.3</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[7]; ?>
                        </td>
                        <td><?php echo $marksArray[7]; ?></td>
                        <td><?php echo $coLevelArray[7]; ?></td>
                        <td><?php echo $blLevelArray[7]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[8]; ?>
                        </td>
                        <td><?php echo $marksArray[8]; ?></td>
                        <td><?php echo $coLevelArray[8]; ?></td>
                        <td><?php echo $blLevelArray[8]; ?></td>
                    </tr>


                    <?php } elseif ($totalMarks == 180) {

                    // Split the string into an array of IDs
                    $id_array = explode(',', $question_ids);
                    $placeholders = implode(',', array_fill(0, count($id_array), '?'));
                    $status = 0;
                    $cmd = $con->prepare("SELECT que.id as id,
                corner.sem as sem, 
                que.subject_code as subject_code, 
                que.chapter as chapter, 
               COALESCE(NULLIF(que.modify_question, ''), que.question) AS question, 
                que.marks as marks,
                que.bl_level as bl_level, 
                que.co_level as co_level
                
                FROM tbl_questions as que
                LEFT JOIN tbl_std_corner_exam AS corner ON que.subject_code = corner.id
                WHERE que.is_delete = ?  and que.id IN ($placeholders) and que.marks = 10");
                    $cmd->bind_param("i" . str_repeat('i', count($id_array)), $status, ...$id_array);

                    $cmd->execute();
                    $result1 = $cmd->get_result();

                    // Initialize arrays
                    $idArray = [];
                    $semArray = [];
                    $subjectCodeArray = [];
                    $chapterArray = [];
                    $questionArray = [];
                    $marksArray = [];
                    $blLevelArray = [];
                    $coLevelArray = [];
                    // Initialize array to store total marks for each CO level
                    $coMarks = [
                        'CO1' => 0,
                        'CO2' => 0,
                        'CO3' => 0,
                        'CO4' => 0,
                        'CO5' => 0
                    ];

                    // Loop through each row fetched from the database
                    while ($row = $result1->fetch_assoc()) {
                        // Store values into respective arrays
                        $idArray[] = $row['id'];
                        $semArray[] = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                        $subjectCodeArray[] = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                        $chapterArray[] = !empty($row['chapter']) ? $row['chapter'] : "<b>N/A</b>";
                        $questionArray[] = !empty($row['question']) ? nl2br(htmlspecialchars($row['question'])) : "<b>N/A</b>";
                        $marksArray[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                        $blLevel = !empty($row['bl_level']) ? $row['bl_level'] : "<b>N/A</b>";
                        $blLevel = substr($blLevel, 0, 1);
                        $blLevelArray[] = $blLevel;
                        // Uppercase and trim CO level
                        $coLevel = !empty($row['co_level']) ? strtoupper(trim($row['co_level'])) : "<b>N/A</b>";
                        $coLevelArray[] = $coLevel;

                        // Update the total marks for each CO
                        if (isset($coMarks[$coLevel])) {
                            $coMarks[$coLevel] += (int) $row['marks'];
                        }
                    }
                    ?>
                    <tr>
                        <td>Q.1</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[0]; ?>
                        </td>
                        <td><?php echo $marksArray[0]; ?></td>
                        <td><?php echo $coLevelArray[0]; ?></td>
                        <td><?php echo $blLevelArray[0]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[1]; ?>
                        </td>
                        <td><?php echo $marksArray[1]; ?></td>
                        <td><?php echo $coLevelArray[1]; ?></td>
                        <td><?php echo $blLevelArray[1]; ?></td>
                    </tr>
                    <tr>
                        <td>Q.2</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[2]; ?>
                        </td>
                        <td><?php echo $marksArray[2]; ?></td>
                        <td><?php echo $coLevelArray[2]; ?></td>
                        <td><?php echo $blLevelArray[2]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;">OR</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[3]; ?>
                        </td>
                        <td><?php echo $marksArray[3]; ?></td>
                        <td><?php echo $coLevelArray[3]; ?></td>
                        <td><?php echo $blLevelArray[3]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[4]; ?>
                        </td>
                        <td><?php echo $marksArray[4]; ?></td>
                        <td><?php echo $coLevelArray[4]; ?></td>
                        <td><?php echo $blLevelArray[4]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;">OR</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[5]; ?>
                        </td>
                        <td><?php echo $marksArray[5]; ?></td>
                        <td><?php echo $coLevelArray[5]; ?></td>
                        <td><?php echo $blLevelArray[5]; ?></td>
                    </tr>

                    <tr>
                        <td>Q.3</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[6]; ?>
                        </td>
                        <td><?php echo $marksArray[6]; ?></td>
                        <td><?php echo $coLevelArray[6]; ?></td>
                        <td><?php echo $blLevelArray[6]; ?></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[7]; ?>
                        </td>
                        <td><?php echo $marksArray[7]; ?></td>
                        <td><?php echo $coLevelArray[7]; ?></td>
                        <td><?php echo $blLevelArray[7]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;">OR</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Q.3</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[8]; ?>
                        </td>
                        <td><?php echo $marksArray[8]; ?></td>
                        <td><?php echo $coLevelArray[8]; ?></td>
                        <td><?php echo $blLevelArray[8]; ?></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[9]; ?>
                        </td>
                        <td><?php echo $marksArray[9]; ?></td>
                        <td><?php echo $coLevelArray[9]; ?></td>
                        <td><?php echo $blLevelArray[9]; ?></td>
                    </tr>
                    <tr>
                        <td>Q.4</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[10]; ?>
                        </td>
                        <td><?php echo $marksArray[10]; ?></td>
                        <td><?php echo $coLevelArray[10]; ?></td>
                        <td><?php echo $blLevelArray[10]; ?></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[11]; ?>
                        </td>
                        <td><?php echo $marksArray[11]; ?></td>
                        <td><?php echo $coLevelArray[11]; ?></td>
                        <td><?php echo $blLevelArray[11]; ?></td>
                    </tr>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;">OR</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Q.4</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[12]; ?>
                        </td>
                        <td><?php echo $marksArray[12]; ?></td>
                        <td><?php echo $coLevelArray[12]; ?></td>
                        <td><?php echo $blLevelArray[12]; ?></td>

                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[13]; ?>
                        </td>
                        <td><?php echo $marksArray[13]; ?></td>
                        <td><?php echo $coLevelArray[13]; ?></td>
                        <td><?php echo $blLevelArray[13]; ?></td>
                    </tr>
                    <tr>
                        <td>Q.5</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[14]; ?>
                        </td>
                        <td><?php echo $marksArray[14]; ?></td>
                        <td><?php echo $coLevelArray[14]; ?></td>
                        <td><?php echo $blLevelArray[14]; ?></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[15]; ?>
                        </td>
                        <td><?php echo $marksArray[15]; ?></td>
                        <td><?php echo $coLevelArray[15]; ?></td>
                        <td><?php echo $blLevelArray[15]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;">OR</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Q.5</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[16]; ?>
                        </td>
                        <td><?php echo $marksArray[16]; ?></td>
                        <td><?php echo $coLevelArray[16]; ?></td>
                        <td><?php echo $blLevelArray[16]; ?></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo $questionArray[17]; ?>
                        </td>
                        <td><?php echo $marksArray[17]; ?></td>
                        <td><?php echo $coLevelArray[17]; ?></td>
                        <td><?php echo $blLevelArray[17]; ?></td>
                    </tr>

                </tbody>
                <?php } elseif ($totalMarks == 100) {

                    // Split the string into an array of IDs
                    $id_array = explode(',', $question_ids);
                    $placeholders = implode(',', array_fill(0, count($id_array), '?'));
                    $status = 0;

                    // Initialize the total marks array for CO levels
                    $coMarks = [
                        'CO1' => 0,
                        'CO2' => 0,
                        'CO3' => 0,
                        'CO4' => 0,
                        'CO5' => 0,
                    ];
                    $cmd = $con->prepare("SELECT que.id as id,
                corner.sem as sem, 
                que.subject_code as subject_code, 
                que.chapter as chapter, 
               COALESCE(NULLIF(que.modify_question, ''), que.question) AS question, 
                que.marks as marks,
                que.bl_level as bl_level, 
                que.co_level as co_level
                
                FROM tbl_questions as que
                LEFT JOIN tbl_std_corner_exam AS corner ON que.subject_code = corner.id
                WHERE que.is_delete = ?  and que.id IN ($placeholders) and que.marks = 10");
                    $cmd->bind_param("i" . str_repeat('i', count($id_array)), $status, ...$id_array);

                    $cmd->execute();
                    $result2 = $cmd->get_result();

                    // Loop through each row fetched from the database
                    while ($row = $result2->fetch_assoc()) {
                        // Store values into respective arrays
                        $idArray[] = $row['id'];
                        $semArray[] = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                        $subjectCodeArray[] = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                        $chapterArray[] = !empty($row['chapter']) ? $row['chapter'] : "<b>N/A</b>";
                        $questionArray[] = !empty($row['question']) ? nl2br(htmlspecialchars($row['question'])) : "<b>N/A</b>";
                        //!empty($row['question']) ? nl2br(htmlspecialchars($row['question']))  : "<b>N/A</b>";
                        $marksArray[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                        $blLevel = !empty($row['bl_level']) ? $row['bl_level'] : "<b>N/A</b>";
                        $blLevel = substr($blLevel, 0, 1);
                        $blLevelArray[] = $blLevel;
                        // Uppercase and trim CO level
                        $coLevel = !empty($row['co_level']) ? strtoupper(trim($row['co_level'])) : "<b>N/A</b>";
                        $coLevelArray[] = $coLevel;

                        // Update the total marks for each CO
                        if (isset($coMarks[$coLevel])) {
                            $coMarks[$coLevel] += (int) $row['marks'];
                        }
                    }

                    $cmd1 = $con->prepare("SELECT que.id as id,
                    corner.sem as sem, 
                    que.subject_code as subject_code, 
                    que.chapter as chapter, 
                   COALESCE(NULLIF(que.modify_question, ''), que.question) AS question, 
                    que.marks as marks,
                    que.bl_level as bl_level, 
                    que.co_level as co_level
                    
                    FROM tbl_questions as que
                    LEFT JOIN tbl_std_corner_exam AS corner ON que.subject_code = corner.id
                    WHERE que.is_delete = ?  and que.id IN ($placeholders) and que.marks = 5");
                    $cmd1->bind_param("i" . str_repeat('i', count($id_array)), $status, ...$id_array);

                    $cmd1->execute();
                    $result3 = $cmd1->get_result();

                    // Loop through each row fetched from the database
                    while ($row = $result3->fetch_assoc()) {

                        // Store values into respective arrays
                        $idArray5[] = $row['id'];
                        $semArray5[] = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                        $subjectCodeArray5[] = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                        $chapterArray5[] = !empty($row['chapter']) ? $row['chapter'] : "<b>N/A</b>";
                        $questionArray5[] = !empty($row['question']) ? nl2br(htmlspecialchars($row['question'])) : "<b>N/A</b>";
                        //!empty($row['question']) ? nl2br(htmlspecialchars($row['question']))  : "<b>N/A</b>";
                        $marksArray5[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                        $blLevel = !empty($row['bl_level']) ? $row['bl_level'] : "<b>N/A</b>";
                        $blLevel = substr($blLevel, 0, 1);
                        $blLevelArray5[] = $blLevel;
                        $coLevel = !empty($row['co_level']) ? strtoupper(trim($row['co_level'])) : "<b>N/A</b>";
                        $coLevelArray5[] = $coLevel;

                        // Update the total marks for each CO
                        if (isset($coMarks[$coLevel])) {
                            $coMarks[$coLevel] += (int) $row['marks'];
                        }
                    }


                    ?>

                <tr>
                    <td>Q.1</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[0]; ?>
                    </td>
                    <td><?php echo $marksArray5[0]; ?></td>
                    <td><?php echo $coLevelArray5[0]; ?></td>
                    <td><?php echo $blLevelArray5[0]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[1]; ?>
                    </td>
                    <td><?php echo $marksArray5[1]; ?></td>
                    <td><?php echo $coLevelArray5[1]; ?></td>
                    <td><?php echo $blLevelArray5[1]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray[0]; ?>
                    </td>
                    <td><?php echo $marksArray[0]; ?></td>
                    <td><?php echo $coLevelArray[0]; ?></td>
                    <td><?php echo $blLevelArray[0]; ?></td>
                </tr>

                <tr>
                    <td>Q.2</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[2]; ?>
                    </td>
                    <td><?php echo $marksArray5[2]; ?></td>
                    <td><?php echo $coLevelArray5[2]; ?></td>
                    <td><?php echo $blLevelArray5[2]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[3]; ?>
                    </td>
                    <td><?php echo $marksArray5[3]; ?></td>
                    <td><?php echo $coLevelArray5[3]; ?></td>
                    <td><?php echo $blLevelArray5[3]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray[1]; ?>
                    </td>
                    <td><?php echo $marksArray[1]; ?></td>
                    <td><?php echo $coLevelArray[1]; ?></td>
                    <td><?php echo $blLevelArray[1]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: center;">OR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Q.2</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[4]; ?>
                    </td>
                    <td><?php echo $marksArray5[4]; ?></td>
                    <td><?php echo $coLevelArray5[4]; ?></td>
                    <td><?php echo $blLevelArray5[4]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[5]; ?>
                    </td>
                    <td><?php echo $marksArray5[5]; ?></td>
                    <td><?php echo $coLevelArray5[5]; ?></td>
                    <td><?php echo $blLevelArray5[5]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray[2]; ?>
                    </td>
                    <td><?php echo $marksArray[2]; ?></td>
                    <td><?php echo $coLevelArray[2]; ?></td>
                    <td><?php echo $blLevelArray[2]; ?></td>
                </tr>

                <tr>
                    <td>Q.3</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[6]; ?>
                    </td>
                    <td><?php echo $marksArray5[6]; ?></td>
                    <td><?php echo $coLevelArray5[6]; ?></td>
                    <td><?php echo $blLevelArray5[6]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[7]; ?>
                    </td>
                    <td><?php echo $marksArray5[7]; ?></td>
                    <td><?php echo $coLevelArray5[7]; ?></td>
                    <td><?php echo $blLevelArray5[7]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray[3]; ?>
                    </td>
                    <td><?php echo $marksArray[3]; ?></td>
                    <td><?php echo $coLevelArray[3]; ?></td>
                    <td><?php echo $blLevelArray[3]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: center;">OR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Q.3</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[8]; ?>
                    </td>
                    <td><?php echo $marksArray5[8]; ?></td>
                    <td><?php echo $coLevelArray5[8]; ?></td>
                    <td><?php echo $blLevelArray5[8]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[9]; ?>
                    </td>
                    <td><?php echo $marksArray5[9]; ?></td>
                    <td><?php echo $coLevelArray5[9]; ?></td>
                    <td><?php echo $blLevelArray5[9]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray[4]; ?>
                    </td>
                    <td><?php echo $marksArray[4]; ?></td>
                    <td><?php echo $coLevelArray[4]; ?></td>
                    <td><?php echo $blLevelArray[4]; ?></td>
                </tr>
                <?php } elseif ($totalMarks == 175) {

                    // Split the string into an array of IDs
                    $id_array = explode(',', $question_ids);
                    $placeholders = implode(',', array_fill(0, count($id_array), '?'));
                    $status = 0;
                    // Initialize the total marks array for CO levels
                    $coMarks = [
                        'CO1' => 0,
                        'CO2' => 0,
                        'CO3' => 0,
                        'CO4' => 0,
                        'CO5' => 0,
                    ];
                    $cmd3 = $con->prepare("SELECT que.id as id,
                   corner.sem as sem, 
                   que.subject_code as subject_code, 
                   que.chapter as chapter, 
                  COALESCE(NULLIF(que.modify_question, ''), que.question) AS question, 
                   que.marks as marks,
                   que.bl_level as bl_level, 
                   que.co_level as co_level
                   
                   FROM tbl_questions as que
                   LEFT JOIN tbl_std_corner_exam AS corner ON que.subject_code = corner.id
                   WHERE que.is_delete = ?  and que.id IN ($placeholders) and que.marks = 10");
                    $cmd3->bind_param("i" . str_repeat('i', count($id_array)), $status, ...$id_array);

                    $cmd3->execute();
                    $result3 = $cmd3->get_result();

                    // Loop through each row fetched from the database
                    while ($row = $result3->fetch_assoc()) {
                        // Store values into respective arrays
                        $idArray[] = $row['id'];
                        $semArray[] = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                        $subjectCodeArray[] = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                        $chapterArray[] = !empty($row['chapter']) ? $row['chapter'] : "<b>N/A</b>";
                        $questionArray[] = !empty($row['question']) ? nl2br(htmlspecialchars($row['question'])) : "<b>N/A</b>";
                        //!empty($row['question']) ? nl2br(htmlspecialchars($row['question']))  : "<b>N/A</b>";
                        $marksArray[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                        $blLevel = !empty($row['bl_level']) ? $row['bl_level'] : "<b>N/A</b>";
                        $blLevel = substr($blLevel, 0, 1);
                        $blLevelArray[] = $blLevel;
                        $coLevel = !empty($row['co_level']) ? strtoupper(trim($row['co_level'])) : "<b>N/A</b>";
                        $coLevelArray[] = $coLevel;

                        // Update the total marks for each CO
                        if (isset($coMarks[$coLevel])) {
                            $coMarks[$coLevel] += (int) $row['marks'];
                        }
                    }

                    $cmd4 = $con->prepare("SELECT que.id as id,
                       corner.sem as sem, 
                       que.subject_code as subject_code, 
                       que.chapter as chapter, 
                      COALESCE(NULLIF(que.modify_question, ''), que.question) AS question, 
                       que.marks as marks,
                       que.bl_level as bl_level, 
                       que.co_level as co_level
                       
                       FROM tbl_questions as que
                       LEFT JOIN tbl_std_corner_exam AS corner ON que.subject_code = corner.id
                       WHERE que.is_delete = ?  and que.id IN ($placeholders) and que.marks = 5");
                    $cmd4->bind_param("i" . str_repeat('i', count($id_array)), $status, ...$id_array);

                    $cmd4->execute();
                    $result4 = $cmd4->get_result();

                    // Loop through each row fetched from the database
                    while ($row = $result4->fetch_assoc()) {

                        // Store values into respective arrays
                        $idArray5[] = $row['id'];
                        $semArray5[] = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                        $subjectCodeArray5[] = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                        $chapterArray5[] = !empty($row['chapter']) ? $row['chapter'] : "<b>N/A</b>";
                        $questionArray5[] = !empty($row['question']) ? nl2br(htmlspecialchars($row['question'])) : "<b>N/A</b>";
                        //!empty($row['question']) ? nl2br(htmlspecialchars($row['question']))  : "<b>N/A</b>";
                        $marksArray5[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                        $blLevel = !empty($row['bl_level']) ? $row['bl_level'] : "<b>N/A</b>";
                        $blLevel = substr($blLevel, 0, 1);
                        $blLevelArray5[] = $blLevel;
                        $coLevel = !empty($row['co_level']) ? strtoupper(trim($row['co_level'])) : "<b>N/A</b>";
                        $coLevelArray5[] = $coLevel;

                        // Update the total marks for each CO
                        if (isset($coMarks[$coLevel])) {
                            $coMarks[$coLevel] += (int) $row['marks'];
                        }
                    }
                    ?>


                <tr>
                    <td>Q.1</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[0]; ?>
                    </td>
                    <td><?php echo $marksArray5[0]; ?></td>
                    <td><?php echo $coLevelArray5[0]; ?></td>
                    <td><?php echo $blLevelArray5[0]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[1]; ?>
                    </td>
                    <td><?php echo $marksArray5[1]; ?></td>
                    <td><?php echo $coLevelArray5[1]; ?></td>
                    <td><?php echo $blLevelArray5[1]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray[0]; ?>
                    </td>
                    <td><?php echo $marksArray[0]; ?></td>
                    <td><?php echo $coLevelArray[0]; ?></td>
                    <td><?php echo $blLevelArray[0]; ?></td>
                </tr>
                <tr>
                    <td>Q.2</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[2]; ?>
                    </td>
                    <td><?php echo $marksArray5[2]; ?></td>
                    <td><?php echo $coLevelArray5[2]; ?></td>
                    <td><?php echo $blLevelArray5[2]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[3]; ?>
                    </td>
                    <td><?php echo $marksArray5[3]; ?></td>
                    <td><?php echo $coLevelArray5[3]; ?></td>
                    <td><?php echo $blLevelArray5[3]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: center;">OR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[4]; ?>
                    </td>
                    <td><?php echo $marksArray5[4]; ?></td>
                    <td><?php echo $coLevelArray5[4]; ?></td>
                    <td><?php echo $blLevelArray5[4]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray[1]; ?>
                    </td>
                    <td><?php echo $marksArray[1]; ?></td>
                    <td><?php echo $coLevelArray[1]; ?></td>
                    <td><?php echo $blLevelArray[1]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: center;">OR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray[2]; ?>
                    </td>
                    <td><?php echo $marksArray[2]; ?></td>
                    <td><?php echo $coLevelArray[2]; ?></td>
                    <td><?php echo $blLevelArray[2]; ?></td>
                </tr>

                <tr>
                    <td>Q.3</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[5]; ?>
                    </td>
                    <td><?php echo $marksArray5[5]; ?></td>
                    <td><?php echo $coLevelArray5[5]; ?></td>
                    <td><?php echo $blLevelArray5[5]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[6]; ?>
                    </td>
                    <td><?php echo $marksArray5[6]; ?></td>
                    <td><?php echo $coLevelArray5[6]; ?></td>
                    <td><?php echo $blLevelArray5[6]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray[3]; ?>
                    </td>
                    <td><?php echo $marksArray[3]; ?></td>
                    <td><?php echo $coLevelArray[3]; ?></td>
                    <td><?php echo $blLevelArray[3]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: center;">OR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Q.3</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[7]; ?>
                    </td>
                    <td><?php echo $marksArray5[7]; ?></td>
                    <td><?php echo $coLevelArray5[7]; ?></td>
                    <td><?php echo $blLevelArray5[7]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[8]; ?>
                    </td>
                    <td><?php echo $marksArray5[8]; ?></td>
                    <td><?php echo $coLevelArray5[8]; ?></td>
                    <td><?php echo $blLevelArray5[8]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray[4]; ?>
                    </td>
                    <td><?php echo $marksArray[4]; ?></td>
                    <td><?php echo $coLevelArray[4]; ?></td>
                    <td><?php echo $blLevelArray[4]; ?></td>
                </tr>

                <tr>
                    <td>Q.4</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[9]; ?>
                    </td>
                    <td><?php echo $marksArray5[9]; ?></td>
                    <td><?php echo $coLevelArray5[9]; ?></td>
                    <td><?php echo $blLevelArray5[9]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[10]; ?>
                    </td>
                    <td><?php echo $marksArray5[10]; ?></td>
                    <td><?php echo $coLevelArray5[10]; ?></td>
                    <td><?php echo $blLevelArray5[10]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray[5]; ?>
                    </td>
                    <td><?php echo $marksArray[5]; ?></td>
                    <td><?php echo $coLevelArray[5]; ?></td>
                    <td><?php echo $blLevelArray[5]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: center;">OR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Q.4</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[11]; ?>
                    </td>
                    <td><?php echo $marksArray5[11]; ?></td>
                    <td><?php echo $coLevelArray5[11]; ?></td>
                    <td><?php echo $blLevelArray5[11]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[12]; ?>
                    </td>
                    <td><?php echo $marksArray5[12]; ?></td>
                    <td><?php echo $coLevelArray5[12]; ?></td>
                    <td><?php echo $blLevelArray5[12]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray[6]; ?>
                    </td>
                    <td><?php echo $marksArray[6]; ?></td>
                    <td><?php echo $coLevelArray[6]; ?></td>
                    <td><?php echo $blLevelArray[6]; ?></td>

                </tr>

                <tr>
                    <td>Q.5</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[13]; ?>
                    </td>
                    <td><?php echo $marksArray5[13]; ?></td>
                    <td><?php echo $coLevelArray5[13]; ?></td>
                    <td><?php echo $blLevelArray5[13]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[14]; ?>
                    </td>
                    <td><?php echo $marksArray5[14]; ?></td>
                    <td><?php echo $coLevelArray5[14]; ?></td>
                    <td><?php echo $blLevelArray5[14]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray[7]; ?>
                    </td>
                    <td><?php echo $marksArray[7]; ?></td>
                    <td><?php echo $coLevelArray[7]; ?></td>
                    <td><?php echo $blLevelArray[7]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: center;">OR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Q.5</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[15]; ?>
                    </td>
                    <td><?php echo $marksArray5[15]; ?></td>
                    <td><?php echo $coLevelArray5[15]; ?></td>
                    <td><?php echo $blLevelArray5[15]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray5[16]; ?>
                    </td>
                    <td><?php echo $marksArray5[16]; ?></td>
                    <td><?php echo $coLevelArray5[16]; ?></td>
                    <td><?php echo $blLevelArray5[16]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                        <?php echo $questionArray[8]; ?>
                    </td>
                    <td><?php echo $marksArray[8]; ?></td>
                    <td><?php echo $coLevelArray[8]; ?></td>
                    <td><?php echo $blLevelArray[8]; ?></td>
                </tr>


                <?php } ?>

            </table>

            <?php
            echo "<br>";
            // Display the total marks for each CO level
            echo "<table class='tbl-co' border='1' cellpadding='1' cellspacing='0' style='border-collapse: collapse; 
                text-align:center; margin: 0px 0px 0px 0px;font-size: 12pt;'>";
            echo "<tr><th  style='border: 1px solid black !important;padding: 0px 0px;'>CO</th>";

            // Display CO1 to CO5 headers
            for ($i = 1; $i <= 5; $i++) {
                echo "<th style='border: 1px solid black !important;padding: 0px 0px;'>CO$i</th>";
            }
            echo "</tr><tr><td style='border: 1px solid black !important;padding: 0px 0px;'>Marks</td>";

            // Display the total marks for each CO level
            for ($i = 1; $i <= 5; $i++) {
                $coKey = 'CO' . $i;
                if (isset($coMarks[$coKey])) {
                    echo "<td style='border: 1px solid black !important;padding: 0px 0px;'>{$coMarks[$coKey]}</td>";
                } else {
                    echo "<td style='border: 1px solid black !important;padding: 0px 0px;'>0</td>";
                }
            }
            echo "</tr></table>";

            echo "<br>";

            echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; text-align: center;margin: 0px 0px 0px 0px;font-size: 12pt;'>";
            echo "<tr>
            <th  style='border: 1px solid black !important;padding: 0 50px;'rowspan='2'>Bloom's Taxonomy</th>
            <th style='border: 1px solid black !important;padding: 0 50px;' colspan='6'>% Weightage As per Syllabus</th>
            </tr>";
            echo "<tr>";

            // Dynamically generate Bloom's level headers
            $blLevels = array_keys($blMarks);
            foreach ($blLevels as $level) {
                echo "<td style='border: 1px solid black !important;padding: 0 40px;'>$level</td>";
            }
            echo "</tr><tr><td style='border: 1px solid black !important;padding: 0 40px;'>% Weightage</td>";

            foreach ($blMark as $marks) {
                echo "<td style='border: 1px solid black !important;padding: 0 40px;'>$marks</td>";
            }
            echo "</tr><tr><td style='border: 1px solid black !important;padding: 0 40px;'>Marks</td>";

            // Dynamically generate Bloom's level marks
            foreach ($blMarks as $marks) {
                echo "<td style='border: 1px solid black !important;padding: 0 40px;'>$marks</td>";
            }
            echo "</tr></table>";

            // echo "<p style='text-align: center; margin-top: 20px;'>********************ALL THE BEST********************</p>";
        
            ?>
        </div>
    </div>



    <?php include '../include/table.php'; ?>
</body>

</html>

<?php } ?>