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
    $show_co_bl = 1; // default: show CO/BL
    if (isset($_GET['show']) && $_GET['show'] == 0) {
        $show_co_bl = 0; // hide CO/BL
    }

    $status = 0;
    $cmd = $con->prepare("SELECT p.id, c.id ,c.subject_code,c.sem, p.total_mark, c.subject_name,p.exam_date,
                      p.exam_time,p.end_time, p.exam_name,p.clg_name,p.blWeightageData , p.chapterWeightageData 
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
        $subject_name = $row1['subject_name'];
        $exam_date = $row1['exam_date'];
        $exam_time = $row1['exam_time'];
        $end_time = $row1['end_time'];
        $exam_name = $row1['exam_name'];
        $clg_name = $row1['clg_name'];
        $blWeightageData = $row1['blWeightageData'];
        $chapterWeightageData = $row1['chapterWeightageData'];
    }

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
    while ($row = $result_bl_level->fetch_assoc()) {
        // Assign values to $blMarks based on column names from your database
        $blMark['R'] = $row['remembering'];
        $blMark['U'] = $row['understanding'];
        $blMark['A'] = $row['applying'];
        $blMark['N'] = $row['analyzing'];
        $blMark['E'] = $row['evaluating'];
        $blMark['C'] = $row['creating'];
    }
    // Fetch questions
    $question_stmt = $con->prepare("
    SELECT pq.question_id, pq.bl_level, q.id, q.question, q.modify_question, q.marks, q.chapter AS co
    FROM tbl_paper_question pq
    LEFT JOIN tbl_questions q ON pq.question_id = q.id
    WHERE pq.paper_id = ? ");
    $question_stmt->bind_param("i", $Id);
    $question_stmt->execute();
    $questions_result = $question_stmt->get_result();

    $questions = [];
    while ($row = $questions_result->fetch_assoc()) {
        $questions[] = $row;
        $questionsByMarks = [
            5 => [],
            10 => []
        ];

        foreach ($questions as $q) {
            if ($q['marks'] == 5) {
                $questionsByMarks[5][] = $q;
            } elseif ($q['marks'] == 10) {
                $questionsByMarks[10][] = $q;
            }
        }
    }

    // Print all questions with marks
    // foreach ($questionsByMarks as $mark => $questions) {
    //     echo "<h3>Questions with {$mark} marks:</h3>";
    //     echo "<ol>";
    //     foreach ($questions as $q) {
    //         $text = $q['modify_question'] ?? $q['question'];
    //         echo "<li>{$text} ({$mark} marks)</li>";
    //     }
    //     echo "</ol>";
    // }
    $blData = json_decode($blWeightageData, true); // Bloom
    $chapterData = json_decode($chapterWeightageData, true); // CO/Chapter

    // Convert Bloom data into key => value
    $blMarks = [];
    foreach ($blData as $item) {
        if ($item['type'] === 'Bloom') {
            $blMarks[$item['level']] = $item['marks'];
        }
    }

    // Convert chapter data into CO marks (CO1..CO5)
    $coMarks = [];
    foreach ($chapterData as $i => $item) {
        if ($item['type'] === 'Chapter') {
            $coKey = 'CO' . ($i + 1);
            $coMarks[$coKey] = $item['marks'];
        }
    }


    $paperFormats = [
        90 => [
            [
                "Q.1",
                [
                    ['part' => 'a', 'type' => 'q']
                ]
            ],
            [
                "Q.2",
                [
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q'],
                    'OR',
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q']
                ]
            ],
            [
                "Q.3",
                [
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q'],
                    'OR',
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q']
                ]
            ]
        ],
        100 => [
            [
                "Q.1",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q']
                ]
            ],
            [
                "Q.2",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q'],
                    'OR',
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q']
                ]
            ],
            [
                "Q.3",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q'],
                    'OR',
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q']
                ]
            ]
        ],
        175 => [
            [
                "Q.1",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q']
                ]
            ],
            [
                "Q.2",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    'OR',
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q'],
                    'OR',
                    ['part' => 'c', 'type' => 'q']
                ]
            ],
            [
                "Q.3",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q'],
                    'OR',
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q']
                ]
            ],
            [
                "Q.4",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q'],
                    'OR',
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q']
                ]
            ],
            [
                "Q.5",
                [
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q'],
                    'OR',
                    ['part' => 'a', 'type' => 'q5'],
                    ['part' => 'b', 'type' => 'q5'],
                    ['part' => 'c', 'type' => 'q']
                ]
            ]
        ],
        180 => [
            [
                "Q.1",
                [
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q']
                ]
            ],
            [
                "Q.2",
                [
                    ['part' => 'a', 'type' => 'q'],
                    'OR',
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q'],
                    'OR',
                    ['part' => 'b', 'type' => 'q']
                ]
            ],
            [
                "Q.3",
                [
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q'],
                    'OR',
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q']
                ]
            ],
            [
                "Q.4",
                [
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q'],
                    'OR',
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q']
                ]
            ],
            [
                "Q.5",
                [
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q'],
                    'OR',
                    ['part' => 'a', 'type' => 'q'],
                    ['part' => 'b', 'type' => 'q']
                ]
            ]
        ]
    ];

    function getMarksByLabel($label)
    {
        if (strpos($label, 'q5') !== false) {
            return 5;
        } elseif ($label === 'q') {
            return 10;
        } else {
            return 0; // default
        }
    }

    ?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="print-paper.css">

</head>

<body>

    <div class="wrapper a4-page">
        <button onclick="window.print()" class="print-btn"><i class="fa fa-print mr5"></i>Print</button>
        <div class="table-responsive" id="content">
            <table id="acedemic" class="dataTableLoad"
                style="overflow-x: auto; -ms-overflow-style: none; scrollbar-width: none;">
                <thead>
                    <!-- Visible row with colspan -->
                    <tr>
                        <?php if ($show_co_bl) { ?>
                        <th colspan="6" style="text-align: center; font-size :16pt;">
                            <?php } else { ?>
                        <th colspan="4" style="text-align: center; font-size :16pt;">
                            <?php } ?>
                            GYANMANJARI INNOVATIVE UNIVERSITY<br>
                            <?php echo $clg_name; ?><br>
                            <?php echo $exam_name; ?>
                        </th>
                    </tr>
                    <tr class="header-info">
                        <?php if ($show_co_bl) { ?>
                        <th colspan="3" style="padding: 0px 8px 8px 8px; text-align: left;">
                            <?php } else { ?>
                        <th colspan="3" style="padding: 0px 8px 8px 8px; text-align: left;">
                            <?php } ?>
                            <p>
                                Enrollment No.:_________________<br>
                                Subject Code: <?php echo $subjectCode; ?><br>
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
                        <?php if ($show_co_bl) { ?>
                        <th colspan="3" style="padding: 0px 8px 8px 8px; text-align: left; vertical-align: top;">
                            <?php } else { ?>
                        <th style="padding: 0px 8px 8px 8px; text-align: left; vertical-align: top;">
                            <?php } ?>
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
                            Semester:
                            <?php echo $sem; ?> <br>
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
                        <th style='text-align: center;'><b>Marks</b></th>
                        <?php if ($show_co_bl) { ?>
                        <th style='text-align: center;'><b>CO</b></th>
                        <th style='text-align: center;'><b>BL</b></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody class="text-center tab-text"> <?php

                    $qNum = 1;
                    $format = $paperFormats[$totalMarks]; // Get the format for this paper
                    $qIndex = 0;

                    foreach ($format as $qFormat) {
                        $qLabel = $qFormat[0];
                        $parts = $qFormat[1];

                        $first = true;

                        foreach ($parts as $item) {
                            if ($item === 'OR') {
                                echo "<tr>
                                        <td></td>
                                        <td></td>
                                        <td style='text-align: center;'>OR</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>";
                                continue;
                            }

                            $part = $item['part']; // a,b
                            $val = $item['type']; // q or q5
                
                            $mark = getMarksByLabel($val);

                            if (!empty($questionsByMarks[$mark])) {
                                $qData = array_shift($questionsByMarks[$mark]);
                                $sub = $qData['modify_question'] ?? $qData['question'];

                                echo "<tr>";
                                if ($first) {
                                    echo "<td>{$qLabel}</td>";
                                    $first = false;
                                } else {
                                    echo "<td></td>";
                                }

                                echo "<td>({$part})</td>";
                                echo "<td style='text-align: left;'>{$sub}</td>";
                                echo "<td>" . sprintf("%02d", $mark) . "</td>";

                                if ($show_co_bl) {
                                    echo "<td>CO{$qData['co']}</td>";
                                    echo "<td>{$qData['bl_level']}</td>";
                                }
                                echo "</tr>";
                            } else {
                                echo "<tr><td>{$qLabel}</td><td>({$part})</td><td>No question available</td><td>{$mark}</td><td></td><td></td></tr>";
                            }
                        }

                    }

                    ?>
                </tbody>
            </table>

            <br>
            <?php if ($show_co_bl) { ?>

            <!-- Chapter Table -->
            <table class="tbl-co" border="1" cellpadding="1" cellspacing="0"
                style="border-collapse: collapse; text-align:center; margin: 0px 0px 0px 0px; font-size: 12pt;">
                <tr>
                    <th style="border: 1px solid black !important; padding: 0px 0px;">CO</th>
                    <?php foreach ($chapterData as $item) { ?>


                    <th style="border: 1px solid black !important; padding: 0px 0px;">CO<?= $item['chapter'] ?></th>
                    <?php } ?>
                </tr>
                <tr>
                    <td style="border: 1px solid black !important; padding: 0px 0px;">Marks</td>
                    <?php foreach ($chapterData as $item) { ?>


                    <td style="border: 1px solid black !important; padding: 0px 0px;"><?= $item['marks'] ?></td>
                    <?php } ?>
                </tr>
            </table>

            <br>

            <!-- Bloom's Taxonomy Table -->
            <table border="1" cellpadding="5" cellspacing="0"
                style="border-collapse: collapse; text-align:center; margin: 0px 0px 0px 0px; font-size: 12pt;">
                <tr>
                    <th style="border: 1px solid black !important; padding: 0 50px;" rowspan="2">
                        Bloom's Taxonomy
                    </th>
                    <th style="border: 1px solid black !important; padding: 0 50px;" colspan="<?= count($blData) ?>">
                        % Weightage As per Syllabus
                    </th>
                </tr>
                <tr>
                    <?php foreach ($blData as $item) { ?>


                    <td style="border: 1px solid black !important; padding: 0 40px;"><?= $item['level'] ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td style="border: 1px solid black !important; padding: 0 40px;">% Weightage</td>
                    <?php foreach ($blMark as $marks) { ?>

                    <td style="border: 1px solid black !important; padding: 0 40px;"><?= $marks ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td style="border: 1px solid black !important; padding: 0 40px;">Marks</td>
                    <?php foreach ($blData as $item) { ?>


                    <td style="border: 1px solid black !important; padding: 0 40px;"><?= $item['marks'] ?></td>
                    <?php } ?>
                </tr>
            </table>
            <?php } ?>


        </div>
    </div>
    <?php include '../include/table.php'; ?>
</body>

</html>

<?php } ?>