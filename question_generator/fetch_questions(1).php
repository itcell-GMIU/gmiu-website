<?php
// Initialize the selectedCheckboxIDs array
$selectedCheckboxIDs = array();
// Include your database connection file or any necessary configurations
include '../database/connect.php'; // Adjust the path as per your setup

// Check if subject code and total marks are set in the POST request
if (isset($_POST['subject_code']) && isset($_POST['t_marks'])) {
    // Retrieve subject code and total marks from POST request
    $subjectCode = $_POST['subject_code'];
    $totalMarks = intval($_POST['t_marks']);
    $Marks = 10;
    $marksPerQuestion = $Marks; // Define marks per question
    if ($totalMarks == 90) {
        $maxLevel = 9;
    }
    if ($totalMarks == 180) {
        $maxLevel = 18;
    }
    // Fetch Bloom's level weightage from the database
    $stmt_bl_level = $con->prepare("SELECT * FROM `tbl_bl_level` WHERE subject_code = ? AND is_delete = 0 ");
    $stmt_bl_level->bind_param("s", $subjectCode);
    $stmt_bl_level->execute();
    $result_bl_level = $stmt_bl_level->get_result();

    // Initialize variables to store Bloom's level marks
    $blMarks = array(
        'R' => 0,
        'U' => 0,
        'A' => 0,
        'N' => 0,
        'E' => 0,
        'C' => 0
    );
    if ($totalMarks == 100 || $totalMarks == 175) {
        // Calculate Bloom's level marks based on weightage percentage
        while ($row = $result_bl_level->fetch_assoc()) {
            $blMarks['R'] += ($row['remembering'] / 100) * $totalMarks;
            $blMarks['U'] += ($row['understanding'] / 100) * $totalMarks;
            $blMarks['A'] += ($row['applying'] / 100) * $totalMarks;
            $blMarks['N'] += ($row['analyzing'] / 100) * $totalMarks;
            $blMarks['E'] += ($row['evaluating'] / 100) * $totalMarks;
            $blMarks['C'] += ($row['creating'] / 100) * $totalMarks;
        }
    }
    // Calculate Bloom's level marks based on weightage percentage
    while ($row = $result_bl_level->fetch_assoc()) {
        $blMarks['R'] = ($row['remembering'] / 100) * $totalMarks;
        $blMarks['U'] = ($row['understanding'] / 100) * $totalMarks;
        $blMarks['A'] = ($row['applying'] / 100) * $totalMarks;
        $blMarks['N'] = ($row['analyzing'] / 100) * $totalMarks;
        $blMarks['E'] = ($row['evaluating'] / 100) * $totalMarks;
        $blMarks['C'] = ($row['creating'] / 100) * $totalMarks;
    }

    // Calculate total questions choosable for each Bloom's level based on Bloom's level weightage
    $totalQuestionsPerBLLevel = array();
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


            // Output the level, remaining marks, and subtracted value
            // echo "Level: $level<br>";
            // echo "Remaining Marks: {$remainingMarks[$level]}<br>";
            // echo "Subtracted Value: {$subtractedValue[$level]}<br>"; 
        }
        $minSubtractedValue = min(array_values(array_diff($subtractedValue, [0])));
        //  echo "min: $minSubtractedValue<br>";

        // Output the adjusted subtracted value for each chapter
        foreach ($blMarks as $level => $marks) {
            // Adjust the subtracted value only in the chapter with the minimum subtracted value
            if ($minSubtractedValue == $subtractedValue[$level]) {
                // Debug statements
                // echo "Level $level: {$blMarks[$level]}<br>";
                // echo "Marks before adjustment: $marks<br>";
                // echo "Total Remaining Marks: $totalRemainingMarks1<br>";
                // echo "Minimum Subtracted Value: $minSubtractedValue<br>";
                $blMarks[$level] = $totalRemainingMarks1 + $minSubtractedValue;
                // Debug statements
                // echo "Adjusted Subtracted Value $level: {$blMarks[$level]}<br>";
            } else {
                $blMarks[$level] = $subtractedValue[$level];
                // echo "Adjusted bl marks Subtracted Value $level: {$blMarks[$level]}<br>";
            }
        }
    }
    // Pass the JSON strings to JavaScript as variables
    echo "<script>";
    echo "var blMarks = " . json_encode($blMarks) . ";";
    echo "</script>";




    //Echo the total questions choosable for each Bloom's level
    // foreach ($totalQuestionsPerBLLevel as $level => $totalQuestions) {
    //     echo "Bloom's Level $level: $totalQuestions<br>";
    // }
    // foreach ($remainingMarks as $level => $totalQuestions) {
    //     echo "Bloom's Level $level: $totalQuestions<br>";
    // }

    // Echo the calculated Bloom's level marks

    // foreach ($blMarks as $blLevel => $marks) {
    //     echo "Bloom's Level $blLevel: $marks<br>";
    // }

    // Fetch chapter weightage from the database
    $stmt_w = $con->prepare("SELECT * FROM tbl_weightage WHERE subject_code = ?  AND is_delete = '0'");
    $stmt_w->bind_param("i", $subjectCode); // Assuming you have the subject ID
    $stmt_w->execute();
    $result_weightage = $stmt_w->get_result();

    // Initialize an array to store the total marks available for each chapter
    $chapterMarks = array();

    // Calculate total marks available for each chapter
    while ($row = $result_weightage->fetch_assoc()) {
        $chapter = $row["chapter"];
        $chapterMarks[$chapter] = ($row["chapter_weight"] / 100) * $totalMarks;
        // echo "Chapter $chapter: {$chapterMarks[$chapter]}<br>"; // Print marks for each chapter
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
            $totalQuestionsPerBLLevel[$highestLevel] -= $tq;
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
        // Find the minimum subtracted value for all chapters
        $minSubtractedValue = min(array_values(array_diff($subtractedValue1, [0])));
        // echo "min: $minSubtractedValue<br>";

        // Output the adjusted subtracted value for each chapter
        // Output the adjusted subtracted value for each chapter
        foreach ($chapterMarks as $chapter => $marks) {
            // Adjust the subtracted value only in the chapter with the minimum subtracted value
            if ($minSubtractedValue == $subtractedValue1[$chapter]) {
                // Debug statements
                // echo "Chapter: $chapter<br>";
                // echo "Marks before adjustment: $marks<br>";
                // echo "Total Remaining Marks: $totalRemainingMarks<br>";
                // echo "Minimum Subtracted Value: $minSubtractedValue<br>";
                $chapterMarks[$chapter] = $totalRemainingMarks + $minSubtractedValue;
                // Debug statements
                //  echo "Adjusted Subtracted Value $chapter: {$chapterMarks[$chapter]}<br>";
            } else {
                $chapterMarks[$chapter] = $subtractedValue1[$chapter];
                //  echo "Adjusted Subtracted Value $chapter: {$chapterMarks[$chapter]}<br>";

            }
        }
    }
    // foreach ($totalQuestionsPerChapter as $chapter => $totalQuestions) {
    //     echo "Bloom's Level $chapter: $totalQuestions<br>";
    // }


    // Pass the JSON strings to JavaScript as variables
    echo "<script>";
    echo "var chapterMarks = " . json_encode($chapterMarks) . ";";
    echo "</script>";

    if ($totalMarks == 90 || $totalMarks == 180) {
        $stmt = $con->prepare("SELECT * FROM tbl_questions WHERE subject_code = ? AND marks = ? AND is_delete = '0'");
        $stmt->bind_param("si", $subjectCode, $Marks);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $stmt = $con->prepare("SELECT * FROM tbl_questions WHERE subject_code = ? AND is_delete = '0'");
        $stmt->bind_param("s", $subjectCode);
        $stmt->execute();
        $result = $stmt->get_result();
    }


    // Initialize an array to hold questions grouped by bl_level
    $questionsByBlLevel = array(
        'R' => array(), // Array to hold questions with bl_level 'R'
        'U' => array(), // Array to hold questions with bl_level 'U'
        'A' => array(), // Array to hold questions with bl_level 'A'
        'N' => array(), // Array to hold questions with bl_level 'N'
        'E' => array(), // Array to hold questions with bl_level 'E'
        'C' => array()  // Array to hold questions with bl_level 'C'
    );

    // Fetch each row and group questions by bl_level
    while ($row = $result->fetch_assoc()) {
        $blLevel = $row['bl_level'];
        // Extract the first character
        $firstCharacter = substr($blLevel, 0, 1);
        $questionsByBlLevel[$firstCharacter][] = $row;
    }
    // Start generating the HTML table structure

    echo '<table class="table">
                <thead>
                    <tr colspan="7"> ';

    if ($totalMarks == 90) {
        echo   '<th colspan="7" style="color: red;">*select Any Nine Questions For paper</th>';
    } elseif ($totalMarks == 100) {
        echo   '<th colspan="7" style="color: red;">*select Any 15 Questions For paper</th>';
    } elseif ($totalMarks == 180) {
        echo   '<th colspan="7" style="color: red;">*select Any 18 Questions For paper</th>';
    } elseif ($totalMarks == 175) {
        echo   '<th colspan="7" style="color: red;">*select Any 26 Questions For paper</th>';
    }

    echo '
                    </tr>
                    <tr>
                        <th colspan="2" scope="col">ID</th>
                        <th scope="col">Question</th>
                        <th scope="col">Marks</th>
                        <th scope="col">Chapter</th>
                        <th scope="col">CO_level</th>
                        <th scope="col">bl_level</th>
                    </tr>
                </thead>
                <tbody>';

    $questionCount = 0;
    // Loop through each bl_level and add questions to the HTML table
    foreach ($questionsByBlLevel as $blLevel => $questions) {
        // Check if there are questions for this bl_level
        if (!empty($questions)) {
            // Fetch each question and add it to the HTML table structure

            foreach ($questions as $question) {
                $questionCount++;
                $blLevel = $question['bl_level'];
                $bl_level = substr($blLevel, 0, 1);

                echo '<tr id="que' . $question['id'] . '">';
                echo '<td id= ' . $totalMarks . '>' .  $question['id'] . '</td>'; // ID
                echo '<td> <input type="checkbox" class="question_checkbox" id="' . $question['id'] . '" value="' . $question['marks'] . '"></td>'; // Checkbox for individual question selection
                echo '<td>' . $question['question'] . '</td>'; // Question
                echo '<td id=' . $question['marks'] . '>' . $question['marks'] . '</td>'; // Marks
                echo '<td id="' . $question['chapter'] . '">' . $question['chapter'] . '</td>'; // Chapter
                echo '<td>' . $question['co_level'] . '</td>'; // CO_level
                // echo '<td id="' . $bl_level . '">' . $bl_level . '
                // <a href="../question_bank/edit_question.php?id=' . $question['id'] . '" class="btn btn-primary" style="size: 10px;"><i class="fas fa-pencil-alt"></i></a>
                // </td>';

                $bl_levels = ['R', 'U', 'A', 'N', 'E', 'C'];
                echo '<td id="' . $bl_level . '">
                <select id="bl_level_' . $bl_level . '" class="bl-level-select" data-level-id="' . $bl_level . '">';
                foreach ($bl_levels as $level) {
                    echo '<option value="' . $level . '" ' . ($bl_level == $level ? 'selected' : '') . '>' . $level . '</option>';
                }
                echo '  </select>
                  </td>';
                echo '</tr>';
                //_' . $question['id'] . '
                //  <a href="../question_bank/edit_question.php?id=' . $question['id'] . '" class="btn btn-primary" style="size: 10px;"><i class="fas fa-pencil-alt"></i></a>

            }
        }
    }
    echo '<style>
        /* CSS styles for the preview table */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Add margin to separate the preview table from the main table */
        }

        .table th,
        .table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: left;
        }

        .table tbody tr:nth-child(even) {
             background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #ddd;
        }
        .table tbody tr.selected-row {
            background-color: #abb0f1;
        }
        input.question_checkbox{
            width: 50px;
            height: 20px;
        }

        .selected-row {
            background-color: blue;
        }
    </style>';

    // Complete the HTML table structure
    echo '</tbody></table>';
    echo ' <div id="previewContainer">  </div>';

    echo ' <button type="button" id="confirmation_button" class="btn btn-primary">Confirm Selection</button>
        ';


    // Encode the arrays as JSON strings
    $chapterQuestionsJSON = json_encode($totalQuestionsPerChapter);
    $blLevelQuestionsJSON = json_encode($totalQuestionsPerBLLevel);

    // Pass the JSON strings to JavaScript as variables
    echo "<script>";
    echo "var chapterQuestions = $chapterQuestionsJSON;";
    echo "var blLevelQuestions = $blLevelQuestionsJSON;";
    echo "</script>";
    // At the end of the script, encode the selectedCheckboxIDs array as JSON and echo it


}
?>
<script>
    // Add event listener to the Bloom's level dropdowns
    // var blLevelSelects = document.querySelectorAll('.bl-level-select');

    // blLevelSelects.forEach(function(select) {
    //     select.addEventListener('change', function() {
    //         var row = select.closest("tr"); // Get the row element
    //         var questionId = row.cells[0].textContent.trim();
    //         var blLevel = select.value;

    //         // Update the Bloom's level for the question in the database
    //         // You need to create a PHP script to handle the update request
    //         // For example, you can create a file named update_bl_level.php

    //         // Send an AJAX request to update_bl_level.php
    //         var xhr = new XMLHttpRequest();
    //         xhr.open('POST', 'update_bl_level.php', true);
    //         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //         xhr.onload = function() {
    //             if (xhr.status === 200) {
    //                 // Update the Bloom's level in the table row
    //                 row.cells[6].textContent = blLevel;
    //                 console.log("Bloom's level updated for question ID: " + questionId);
    //             } else {
    //                 console.log("Error updating Bloom's level for question ID: " + questionId);
    //             }
    //         };
    //         xhr.send('question_id=' + questionId + '&bl_level=' + blLevel);
    //     });
    // });
</script>
<script>
    // Initialize an array to store the IDs of selected checkboxes
    var selectedCheckboxIDs = [];
    var totalMarks = <?php echo $totalMarks; ?>;
    // Add event listeners to all question checkboxes
    var questionCheckboxes = document.querySelectorAll('.question_checkbox');
    var totalMarksSelected = 0;
    var totalMarksSelected1 = 0;

    questionCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Get the question ID, chapter, and Bloom's level of the selected question
            var questionId = this.id;
            var row = checkbox.closest("tr"); // Find the closest row
            var mark = row.cells[row.cells.length - 4].textContent.trim(); // Fetch Bloom's level from the ID property of the seventh cell in the row
            var chapter = row.cells[row.cells.length - 3].textContent.trim(); // Fetch chapter from the ID of the row
            // var blLevel = row.cells[row.cells.length - 1].textContent.trim(); // Fetch Bloom's level from the ID property of the seventh cell in the row
            var blLevelSelect = row.querySelector('.bl-level-select');
            var blLevel = blLevelSelect.value;
            // Use the retrieved values as needed in your JavaScript logic
            // alert(mark);
            if (totalMarks == 175 || totalMarks == 100) {


                if (checkbox.checked) {
                    // Calculate the maximum number of questions based on total marks
                    if (totalMarks == 175) {
                        if (mark == 10) {
                            total_que = 9;
                            totalMarksSelected++; // Increment totalMarksSelected                                             
                        } else if (mark == 5) {
                            total_que1 = 17;
                            totalMarksSelected1++;
                        }
                    } else {
                        if (mark == 10) {
                            total_que = 5;
                            totalMarksSelected++; // Increment totalMarksSelected
                        } else if (mark == 5) {
                            total_que1 = 10;
                            totalMarksSelected1++;

                        }
                    }
                    // Check if the number of selected questions exceeds the maximum allowed
                    if (totalMarksSelected > total_que) {
                        alert("You can only select " + total_que + " questions of 10 Marks. ");
                        this.checked = false;
                    }
                    if (totalMarksSelected1 > total_que1) {
                        alert("You can only select " + total_que1 + " questions of 5 Marks. ");
                        this.checked = false;
                    }
                    // If checked, deduct the mark from Bloom's Level and chapter weightage               
                    // Deduct the mark from Bloom's Level
                    blMarks[blLevel] -= parseInt(row.cells[3].textContent.trim());
                    // Deduct the mark from chapter weightage
                    chapterMarks[chapter] -= parseInt(row.cells[3].textContent.trim());
                    console.log(" update bl " + blMarks[blLevel]);

                    if (blMarks[blLevel] < 0) {
                        console.log(blMarks[blLevel]);
                        alert("Deducting this mark will result in negative Bloom's Level . Please select another question.");
                        // Add the mark back to Bloom's Level and chapter weightage
                        blMarks[blLevel] += parseInt(row.cells[3].textContent.trim());
                        chapterMarks[chapter] += parseInt(row.cells[3].textContent.trim());
                        if (parseInt(row.cells[3].textContent.trim()) === 10) {
                            totalMarksSelected--;
                            // console.log(totalMarksSelected);
                        }
                        if (parseInt(row.cells[3].textContent.trim()) === 5) {
                            totalMarksSelected1--;
                            // console.log(totalMarksSelected);
                        }

                        // console.log(totalMarksSelected);

                        // Uncheck the checkbox
                        this.checked = false;
                    }
                    if (chapterMarks[chapter] < 0) {
                        console.log(chapterMarks[chapter]);
                        alert("Deducting this mark will result in negative chapter weightage. Please select another question.");
                        // Add the mark back to Bloom's Level and chapter weightage
                        blMarks[blLevel] += parseInt(row.cells[3].textContent.trim());
                        chapterMarks[chapter] += parseInt(row.cells[3].textContent.trim());
                        if (parseInt(row.cells[3].textContent.trim()) === 10) {
                            totalMarksSelected--;
                            // console.log(totalMarksSelected);
                        }
                        if (parseInt(row.cells[3].textContent.trim()) === 5) {
                            totalMarksSelected1--;
                            // console.log(totalMarksSelected);
                        }

                        // Uncheck the checkbox
                        this.checked = false;
                    }
                } else {
                    // If unchecked, add the mark back to Bloom's Level and chapter weightage               
                    // Add the mark back to Bloom's Level
                    blMarks[blLevel] += parseInt(row.cells[3].textContent.trim());
                    // Add the mark back to chapter weightage
                    chapterMarks[chapter] += parseInt(row.cells[3].textContent.trim());

                }
            } else {
                console.log("Chapter: " + chapter + ", Bloom's Level: " + blLevel);
                // Check if the checkbox is checked
                if (checkbox.checked) {
                    // If checked, deduct 1 from the total questions available for the chapter and Bloom's level

                    chapterQuestions[chapter]--;
                    blLevelQuestions[blLevel]--;
                    console.log("Chapter Question:", chapterQuestions[chapter]);
                    console.log("BL Level Question:", blLevelQuestions[blLevel]);
                    // selectedCheckboxIDs.push(questionId);
                    // Check if the available questions for the Bloom's level is less than 0
                    // Check if the available questions for the Bloom's level is less than 0
                    if (chapterQuestions[chapter] < 0) {
                        // If so, uncheck the checkbox
                        checkbox.checked = false;
                        chapterQuestions[chapter]++;
                        blLevelQuestions[blLevel]++;

                        console.log("Chapter Question:", chapterQuestions[chapter]);
                        console.log("BL Level Question:", blLevelQuestions[blLevel]);
                        // Show an alert message
                        alert(chapter + " Chapter's: All questions are selected.");
                    }
                    if (blLevelQuestions[blLevel] < 0) {
                        // If so, uncheck the checkbox
                        checkbox.checked = false;
                        chapterQuestions[chapter]++;
                        blLevelQuestions[blLevel]++;
                        console.log("Chapter Question:", chapterQuestions[chapter]);
                        console.log("BL Level Question:", blLevelQuestions[blLevel]);
                        // Show an alert message
                        alert(blLevel + " level: All questions are selected.");
                    }
                } else {
                    // If unchecked, add 1 back to the total questions available for the chapter and Bloom's level
                    chapterQuestions[chapter]++;
                    blLevelQuestions[blLevel]++;

                    console.log("Chapter Question:", chapterQuestions[chapter]);
                    console.log("BL Level Question:", blLevelQuestions[blLevel]);

                }
            }


        });

        // Function to update the footer rows with remaining questions and total marks
        // Function to update the footer rows with remaining questions or Bloom's Level marks and chapter weightage
        function updateFooterRows() {
            var table = document.querySelector(".table");
            var footer = table.querySelector("tfoot");
            if (!footer) {
                footer = document.createElement("tfoot");
                table.appendChild(footer);
            }

            // Check if total marks are 175 or 100
            if (totalMarks == 175 || totalMarks == 100) {
                // Display Bloom's Level marks instead of remaining questions for Bloom's Levels
                var blLevelRow = footer.querySelector(".bl-level-row");
                if (!blLevelRow) {
                    blLevelRow = document.createElement("tr");
                    blLevelRow.className = "bl-level-row"; // Add a class to identify this row
                    footer.appendChild(blLevelRow);
                } else {
                    blLevelRow.innerHTML = ''; // Clear existing content if any
                }
                blLevelRow.innerHTML = `<td>Bloom's Level Marks:</td>`;
                for (var blLevel in blMarks) {
                    if (blMarks.hasOwnProperty(blLevel)) {
                        blLevelRow.innerHTML += `<td>${blLevel}: ${blMarks[blLevel]}</td>`;
                    }
                }

                // Display chapter weightage instead of remaining questions for chapters
                var chapterRow = footer.querySelector(".chapter-row");
                if (!chapterRow) {
                    chapterRow = document.createElement("tr");
                    chapterRow.className = "chapter-row"; // Add a class to identify this row
                    footer.appendChild(chapterRow);
                } else {
                    chapterRow.innerHTML = ''; // Clear existing content if any
                }
                chapterRow.innerHTML = `<td>Chapter Weightage:</td>`;
                for (var chapter in chapterMarks) {
                    if (chapterMarks.hasOwnProperty(chapter)) {
                        chapterRow.innerHTML += `<td>${chapter}: ${chapterMarks[chapter]}</td>`;
                    }
                }
            } else {
                // Display remaining questions for Bloom's Levels
                var blLevelRow = footer.querySelector(".bl-level-row");
                if (!blLevelRow) {
                    blLevelRow = document.createElement("tr");
                    blLevelRow.className = "bl-level-row"; // Add a class to identify this row
                    footer.appendChild(blLevelRow);
                } else {
                    blLevelRow.innerHTML = ''; // Clear existing content if any
                }
                blLevelRow.innerHTML = `<td>Bloom's Level Remaining Questions:</td>`;
                for (var blLevel in blLevelQuestions) {
                    if (blLevelQuestions.hasOwnProperty(blLevel)) {
                        var remaining = blLevelQuestions[blLevel] || 0; // Use remaining questions for Bloom's level
                        blLevelRow.innerHTML += `<td>${blLevel}: ${remaining}</td>`;
                    }
                }

                // Display remaining questions for chapters
                var chapterRow = footer.querySelector(".chapter-row");
                if (!chapterRow) {
                    chapterRow = document.createElement("tr");
                    chapterRow.className = "chapter-row"; // Add a class to identify this row
                    footer.appendChild(chapterRow);
                } else {
                    chapterRow.innerHTML = ''; // Clear existing content if any
                }
                chapterRow.innerHTML = `<td>Chapter Remaining Questions:</td>`;
                for (var chapter in chapterQuestions) {
                    if (chapterQuestions.hasOwnProperty(chapter)) {
                        var remaining = chapterQuestions[chapter] || 0; // Use remaining questions for chapter
                        chapterRow.innerHTML += `<td>${chapter}: ${remaining}</td>`;
                    }
                }
            }

            // Display total marks
            chapterRow.innerHTML += `<td colspan="7">Total Marks: ${totalMarks}</td>`;
        }


        // Add event listeners to all question checkboxes
        var questionCheckboxes = document.querySelectorAll('.question_checkbox');

        questionCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                // Your existing code for handling checkbox changes goes here

                // After handling checkbox changes, update the footer rows
                updateFooterRows();
            });
        });

        // Call the function to initially populate the footer rows
        updateFooterRows();

    });

    // Initialize an array to store the IDs of selected checkboxes
    // Define an array to store the selected checkbox IDs
    var selectedCheckboxIDs = [];

    // // Iterate through each checkbox
    // questionCheckboxes.forEach(function(checkbox) {
    //     checkbox.addEventListener('change', function() {
    //         // Get the question ID
    //         var questionId = this.id;
    //         var row = checkbox.closest("tr"); // Get the row element
            

    //         // Check if the checkbox is checked
    //         if (checkbox.checked) {
    //             // Add the question ID to the array if checked and it's not already present
    //             if (!selectedCheckboxIDs.includes(questionId)) {
    //                 selectedCheckboxIDs.push(questionId);
    //             }
    //             row.classList.add('selected-row');
    //         } else {
    //             // Remove the question ID from the array if unchecked
    //             var index = selectedCheckboxIDs.indexOf(questionId);
    //             if (index !== -1) {
    //                 selectedCheckboxIDs.splice(index, 1);
    //             }
    //             row.classList.remove('selected-row');
    //         }
    //         selectedCheckboxIDs.sort();
    //         // Update the value of the hidden input field with the selectedCheckboxIDs array
    //         // After updating the selectedCheckboxIDs array, set the value of the hidden input field
    //         document.getElementById("checkboxID").value = selectedCheckboxIDs.join(',');

    //         // Log the selectedCheckboxIDs array to see the IDs of selected checkboxes
    //         console.log("Selected Checkbox IDs: " + selectedCheckboxIDs);
    //     });
    // });

    // Iterate through each checkbox
questionCheckboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        // Get the question ID
        var questionId = this.id;
        var row = checkbox.closest("tr"); // Get the row element

        // Get the selected Bloom's level
        var blLevelSelect = row.querySelector('.bl-level-select');
        var selectedBlLevel = blLevelSelect.value;

        // Define a structure to hold both question ID and selected Bloom's level
        var selectedInfo = {
            id: questionId,
            blLevel: selectedBlLevel
        };

        // Check if the checkbox is checked
        if (checkbox.checked) {
            // Add the selectedInfo to the array if checked and it's not already present
            if (!selectedCheckboxIDs.some(info => info.id === questionId)) {
                selectedCheckboxIDs.push(selectedInfo);
            }
            row.classList.add('selected-row');
        } else {
            // Remove the selectedInfo from the array if unchecked
            var index = selectedCheckboxIDs.findIndex(info => info.id === questionId);
            if (index !== -1) {
                selectedCheckboxIDs.splice(index, 1);
            }
            row.classList.remove('selected-row');
        }
        selectedCheckboxIDs.sort((a, b) => a.id.localeCompare(b.id));

        // Update the value of the hidden input field with the selectedCheckboxIDs array
        // After updating the selectedCheckboxIDs array, set the value of the hidden input field
        document.getElementById("checkboxID").value = selectedCheckboxIDs.map(info => info.id + '-' + info.blLevel).join(',');

        // Log the selectedCheckboxIDs array to see the IDs of selected checkboxes
        console.log("Selected Checkbox IDs: " + selectedCheckboxIDs.map(info => info.id + '-' + info.blLevel));
    });
});



    // Add event listener to the confirmation button
    document.getElementById('confirmation_button').addEventListener('click', function() {

        // Clear the preview container before adding new content
        document.getElementById('previewContainer').innerHTML = '';

        // Create a table element to display the selected questions
        var previewTable = document.createElement('table');
        previewTable.classList.add('table');

        // Create table header
        var headerRow = document.createElement('tr');
        headerRow.innerHTML = `
        <th>Question</th>
        <th>Marks</th>
        <th>Chapter</th>
        <th>CO Level</th>
        <th>Bloom's Level</th>
    `;
        previewTable.appendChild(headerRow);
     //   12,13,15,18,38,4,72,8,9
        // Iterate through the selected checkboxes
        questionCheckboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                // Get the question details from the table row
                var row = checkbox.closest("tr");
                var question = row.cells[2].textContent.trim();
                var marks = row.cells[3].textContent.trim();
                var chapter = row.cells[4].textContent.trim();
                var coLevel = row.cells[5].textContent.trim();
                // var blLevel = row.cells[6].textContent.trim();
                var blLevelSelect = row.querySelector('.bl-level-select');
                var blLevel = blLevelSelect.value;

                // Create a new table row for the question
                var questionRow = document.createElement('tr');
                questionRow.innerHTML = `
                <td>${question}</td>
                <td>${marks}</td>
                <td>${chapter}</td>
                <td>${coLevel}</td>
                <td>${blLevel}</td> `;
                previewTable.appendChild(questionRow);
            }
        });
        if (totalMarks == 175 || totalMarks == 100) {

            var blLevelRemainingQuestions = Object.values(blMarks).some(function(value) {
                return value > 0;
            });

            var chapterRemainingQuestions = Object.values(chapterMarks).some(function(value) {
                return value > 0;
            });

        } else {
            var blLevelRemainingQuestions = Object.values(blLevelQuestions).some(function(value) {
                return value > 0;
            });

            var chapterRemainingQuestions = Object.values(chapterQuestions).some(function(value) {
                return value > 0;
            });
        }

        // If either remaining questions is not empty, display an alert
        if (blLevelRemainingQuestions || chapterRemainingQuestions) {
            alert("Please select questions for all Bloom's Levels and Chapters.");
        } else {
            // Proceed with confirmation logic
            console.log("All questions have been selected.");

            // Append the table to the preview container
            document.getElementById('previewContainer').appendChild(previewTable);

            // Add event listener to the confirmation checkbox
            var confirmCheckbox = document.createElement('input');
            confirmCheckbox.type = 'checkbox';
            confirmCheckbox.id = 'confirmCheckbox';
            var confirmLabel = document.createElement('label');
            confirmLabel.textContent = 'I confirm that I want to submit the question bank.';
            confirmLabel.setAttribute('for', 'confirmCheckbox');

            // Append the confirmation checkbox and label to the preview container
            document.getElementById('previewContainer').appendChild(confirmCheckbox);
            document.getElementById('previewContainer').appendChild(confirmLabel);
        }

    });
</script>