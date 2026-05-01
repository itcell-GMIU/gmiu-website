<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Initialize the selectedCheckboxIDs array
$selectedCheckboxIDs = array();
// Include your database connection file or any necessary configurations
include '../database/connect.php'; // Adjust the path as per your setup

// Check if subject code and total marks are set in the POST request
if (isset($_POST['subject_code']) && isset($_POST['t_marks'])) {
    // Retrieve subject code and total marks from POST request
    $subjectCode = $_POST['subject_code'];
    $totalMarks = intval($_POST['t_marks']);

    // Debug: Output values to browser console

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
        // echo "Bloom's Level $level: $totalQuestions<br>";
        if ($totalQuestions > $maxLevel) {
            $tq = $totalQuestions - $maxLevel;
            $totalQuestionsPerBLLevel[$highestLevel] -= $tq;
        }
        // Check total questions and adjust for remaining ones
        if ($totalQuestions < $maxLevel) {
            $remainingQuestions = $maxLevel - $totalQuestions;

            // Add the remaining questions to the "R" level
            $totalQuestionsPerBLLevel['R'] += $remainingQuestions;
            $totalQuestions += $remainingQuestions; // Update the totalQuestions count
        }
    } elseif ($totalMarks == 175) {
        $totalSubtracted = 0;
        $remainingMarks = [];
        $subtractedValue = [];
        $totalQuestions = [];

        foreach ($blMarks as $level => $marks) {
            $totalQuestions[$level] = floor($marks / 5);
            $subtractedValue[$level] = $totalQuestions[$level] * 5;
            $remainingMarks[$level] = $marks - $subtractedValue[$level];
            $totalSubtracted += $subtractedValue[$level];
        }

        $totalRemainingMarks = $totalMarks - $totalSubtracted;

        // Start with the base subtracted values
        foreach ($blMarks as $level => $marks) {
            $blMarks[$level] = $subtractedValue[$level];
        }

        // Distribute the leftover marks (in steps of 5)
        while ($totalRemainingMarks >= 5) {
            // Find the level with the lowest current mark to balance distribution
            // Temporary copy for sorting
            $tempMarks = $blMarks;
            // Sort only the copy
            asort($tempMarks);
            // Use the sorted copy to find the key to update in the original
            foreach ($tempMarks as $level => $val) {
                $blMarks[$level] += 5;
                $totalRemainingMarks -= 5;
                break; // Only distribute one chunk
            }
        }

        // Now the total of blMarks should match exactly 175
    }
    // Pass the JSON strings to JavaScript as variables
    // echo "<script>";
    // echo "var blMarks = " . json_encode($blMarks) . ";";
    // echo " console.log(blMarks);";
    // echo "</script>";


    // Fetch chapter weightage from the database
    $stmt_w = $con->prepare("SELECT * FROM tbl_weightage WHERE subject_code = ?  AND is_delete = '0'");
    $stmt_w->bind_param("i", $subjectCode); // Assuming you have the subject ID
    $stmt_w->execute();
    $result_weightage = $stmt_w->get_result();

    // Initialize arrays
    $chapterMarks = array();
    $totalQuestionsPerChapter = array();
    $totalRemainingMarks = 0;
    $roundedMarks = [];
    $rawMarks = [];
    $marksLost = [];

    // STEP 1: Fetch weightage and calculate chapter-wise raw and floored marks
    while ($row = $result_weightage->fetch_assoc()) {
        $chapter = $row["chapter"];
        $weight = floatval($row["chapter_weight"]);
        $raw = ($weight / 100) * $totalMarks;
        $rounded = floor($raw / 5) * 5;

        // Storing the calculated values
        $chapterMarks[$chapter] = $rounded;
        $roundedMarks[$chapter] = $rounded;
        $rawMarks[$chapter] = $raw;
        $marksLost[$chapter] = $raw - $rounded;
    }

    // STEP 2: Balance remaining marks to reach exactly $totalMarks
    $currentTotal = array_sum($chapterMarks);
    $difference = $totalMarks - $currentTotal;

    if ($difference !== 0) {
        // Sort chapters by most marks lost
        arsort($marksLost);

        foreach ($marksLost as $chapter => $loss) {
            while (
                $difference >= 5 &&
                $chapterMarks[$chapter] + 5 <= round($rawMarks[$chapter])
            ) {
                $chapterMarks[$chapter] += 5;
                $difference -= 5;
            }
            if ($difference <= 0) break;
        }
    }

    // STEP 3: Handle 90 and 180 totalMarks as question-based
    if ($totalMarks == 90 || $totalMarks == 180) {
        $totalQuestions = 0;
        $highestQuestions = 0;
        $highestLevels = [];  // To store chapters with the highest number of questions

        // STEP 1: Calculate total questions per chapter and find the highest questions
        foreach ($chapterMarks as $chapter => $marks) {
            $totalQuestionsPerChapter[$chapter] = round($marks / $marksPerQuestion);
            $totalQuestions += $totalQuestionsPerChapter[$chapter];
            if ($totalQuestionsPerChapter[$chapter] > $highestQuestions) {
                $highestQuestions = $totalQuestionsPerChapter[$chapter];
                $highestLevels = [$chapter]; // Reset to this chapter only
            } elseif ($totalQuestionsPerChapter[$chapter] == $highestQuestions) {
                $highestLevels[] = $chapter; // Add chapter to the list of highest levels
            }
        }
        // STEP 2: Balance the number of questions
        if ($totalQuestions > $maxLevel) {
            // If total questions exceed the max level, deduct equally from chapters with the highest number of questions
            $excessQuestions = $totalQuestions - $maxLevel;

            // If there is only one chapter with the highest number of questions, deduct from that chapter
            if (count($highestLevels) == 1) {
                $totalQuestionsPerChapter[$highestLevels[0]] -= $excessQuestions;
            } else {
                // If there are multiple chapters with the same number of questions, deduct equally
                $reductionPerChapter = floor($excessQuestions / count($highestLevels));

                foreach ($highestLevels as $chapter) {
                    // Deduct the calculated reduction from each of the chapters
                    $totalQuestionsPerChapter[$chapter] -= $reductionPerChapter;
                }

                // Adjust for any remaining questions if division was not exact
                $remainingQuestions = $excessQuestions % count($highestLevels);
                $index = 0;

                while ($remainingQuestions > 0) {
                    // Distribute remaining questions
                    $totalQuestionsPerChapter[$highestLevels[$index]]--;
                    $remainingQuestions--;
                    $index++;
                }
            }
        } elseif ($totalQuestions < $maxLevel) {
            // If total questions are less than max level, add the remaining questions
            $remainingQuestions = $maxLevel - $totalQuestions;
            reset($totalQuestionsPerChapter);
            $firstChapter = key($totalQuestionsPerChapter);
            $totalQuestionsPerChapter[$firstChapter] += $remainingQuestions;
            $totalQuestions += $remainingQuestions;
        }
    }

    // STEP 4: For 175 or 100 marks, use pure marks logic (already done above)
    if ($totalMarks == 175 || $totalMarks == 100) {
        // ✅ If there's a remaining difference, distribute it equally
        if ($difference > 0) {

            $maxMarks = max($chapterMarks);
            $topChapters = [];

            foreach ($chapterMarks as $chapter => $marks) {
                if ($marks == $maxMarks) {
                    $topChapters[] = $chapter;
                }
            }
            // Distribute marks equally in steps of 5
            $i = 0;
            while ($difference >= 5 && count($topChapters) > 0) {
                $chapter = $topChapters[$i % count($topChapters)];
                $chapterMarks[$chapter] += 5;
                $difference -= 5;
                $i++;
            }
        }
        // Finally calculate questions after balancing
        foreach ($chapterMarks as $chapter => $marks) {
            $totalQuestionsPerChapter[$chapter] = $marks / $marksPerQuestion;
        }
    }

    // Pass the JSON strings to JavaScript as variables
    echo "<script>";
    echo "var blMarks = " . json_encode($blMarks) . ";";
    // echo "console.log(blMarks);";
    echo "</script>";


    // Pass the JSON strings to JavaScript as variables
    echo "<script>";
    echo "var chapterMarks = " . json_encode($chapterMarks) . ";";
    // echo "console.log (chapterMarks);";
    echo "</script>";

    if ($totalMarks == 90 || $totalMarks == 180) {
        $stmt = $con->prepare("SELECT * FROM tbl_questions WHERE subject_code = ? AND marks = ? AND is_delete = '0' ");
        $stmt->bind_param("si", $subjectCode, $Marks);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $stmt = $con->prepare("SELECT * FROM tbl_questions WHERE subject_code = ? AND is_delete = '0' AND marks not in ('1','2') ");
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

    echo '<table class="table dataTableLoad">
                <thead>
                    <tr colspan="7"> ';
    if ($totalMarks == 90) {
        echo   '<th colspan="7" style="color: red;">*select Any Nine Questions For paper</th>';
    } elseif ($totalMarks == 100) {
        echo   '<th colspan="7" style="color: red;">*select Any 15 Questions For paper<br>*Select 5 Question of 10 Marks<br>*select 10 Question Of 5 Marks </th>';
    } elseif ($totalMarks == 180) {
        echo   '<th colspan="7" style="color: red;">*select Any 18 Questions For paper</th>';
    } elseif ($totalMarks == 175) {
        echo   '<th colspan="7" style="color: red;">*select Any 26 Questions For paper<br>*select 9 Question Of 10 Marks <br>*Select 17 Question of 5 Marks </th>';
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
                echo '<td> <input type="checkbox" class="question_checkbox" id="' . $question['id'] . '" data-seq="' . $questionCount . '" value="' . $question['marks'] . '"></td>'; // Checkbox for individual question selection
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

    // Complete the HTML table structure
    echo '</tbody>
            <tfoot>
                <th colspan="2" scope="col">ID</th>
                <th scope="col">Question</th>
                <th scope="col">Marks</th>
                <th scope="col">Chapter</th>
                <th scope="col">CO_level</th>
                <th scope="col">bl_level</th>
            </tfoot>
        </table>
      
        <table id="footerTable" class="footer-table">
       
        </table>';
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
// Initialize an array to store the IDs of selected checkboxes
var selectedCheckboxIDs = [];
var totalMarks = <?php echo $totalMarks; ?>;
// Add event listeners to all question checkboxes
var questionCheckboxes = document.querySelectorAll('.question_checkbox');
var total_que = 0;
var total_que1 = 0;
var totalMarksSelected = 0;
var totalMarksSelected1 = 0;

// Initialize an array to store the IDs of selected checkboxes
// Define an array to store the selected checkbox IDs
var selectedCheckboxIDs = [];

questionCheckboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {

        // Get the question ID, chapter, and Bloom's level of the selected question
        var questionId = this.id;
        var row = checkbox.closest("tr"); // Find the closest row
        var mark = row.cells[row.cells.length - 4].textContent
            .trim(); // Fetch Bloom's level from the ID property of the seventh cell in the row
        var chapter = row.cells[row.cells.length - 3].textContent
            .trim(); // Fetch chapter from the ID of the row
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
                        // console.log(totalMarksSelected);
                    } else if (mark == 5) {
                        total_que1 = 17;
                        totalMarksSelected1++;
                    }
                } else {
                    if (mark == 10) {
                        total_que = 5;
                        totalMarksSelected++; // Increment totalMarksSelected
                        // console.log("10 mark" + totalMarksSelected);
                    } else if (mark == 5) {
                        total_que1 = 10;
                        totalMarksSelected1++;
                        // console.log("5 mark" + totalMarksSelected1);

                    }
                }

                // Check if the number of selected questions exceeds the maximum allowed
                if (totalMarksSelected > total_que) {
                    swal("You can only select " + total_que + " questions of 10 Marks. ");
                    totalMarksSelected--;
                    this.checked = false;
                    blMarks[blLevel] += parseInt(row.cells[3].textContent.trim());
                    // console.log(blMarks);
                    // Deduct the mark from chapter weightage
                    chapterMarks[chapter] += parseInt(row.cells[3].textContent.trim());
                    // console.log("10 mark" + totalMarksSelected);
                }
                if (totalMarksSelected1 > total_que1) {
                    swal("You can only select " + total_que1 + " questions of 5 Marks. ");
                    totalMarksSelected1--;
                    this.checked = false;
                    blMarks[blLevel] += parseInt(row.cells[3].textContent.trim());
                    // Deduct the mark from chapter weightage
                    chapterMarks[chapter] += parseInt(row.cells[3].textContent.trim());
                    // console.log("5 mark" + totalMarksSelected1);
                }
                // If checked, deduct the mark from Bloom's Level and chapter weightage               
                // Deduct the mark from Bloom's Level
                blMarks[blLevel] -= parseInt(row.cells[3].textContent.trim());
                // Deduct the mark from chapter weightage
                chapterMarks[chapter] -= parseInt(row.cells[3].textContent.trim());

                // console.log(" update bl " + blMarks[blLevel]);
                // console.log("chapter mark " + chapterMarks[chapter]);



                if (blMarks[blLevel] < 0) {
                    // console.log(blMarks[blLevel]);
                    swal(
                        "Deducting this mark will result in negative Bloom's Level . Please select another question."
                    );
                    // Add the mark back to Bloom's Level and chapter weightage
                    blMarks[blLevel] += parseInt(row.cells[3].textContent.trim());
                    chapterMarks[chapter] += parseInt(row.cells[3].textContent.trim());

                    if (parseInt(row.cells[3].textContent.trim()) === 10) {
                        totalMarksSelected--;
                        // console.log(totalMarksSelected);
                    }
                    if (parseInt(row.cells[3].textContent.trim()) === 5) {
                        totalMarksSelected1--;
                        // console.log(totalMarksSelected1);
                    }
                    // console.log(" update bl " + blMarks[blLevel]);
                    // console.log("chapter mark " + chapterMarks[chapter]);

                    // console.log(totalMarksSelected);

                    // Uncheck the checkbox
                    this.checked = false;

                }
                if (chapterMarks[chapter] < 0) {
                    // alert("hello");
                    // console.log(chapterMarks[chapter]);
                    swal(
                        "Deducting this mark will result in negative chapter weightage. Please select another question."
                    );
                    // Add the mark back to Bloom's Level and chapter weightage
                    blMarks[blLevel] += parseInt(row.cells[3].textContent.trim());
                    //  console.log("plus bl mark" + blMarks[blLevel]);
                    chapterMarks[chapter] += parseInt(row.cells[3].textContent.trim());
                    // console.log("plus chapter mark" + chapterMarks[chapter]);

                    if (parseInt(row.cells[3].textContent.trim()) === 10) {
                        totalMarksSelected--;
                        // console.log(totalMarksSelected);
                    }
                    if (parseInt(row.cells[3].textContent.trim()) === 5) {
                        totalMarksSelected1--;
                        // console.log(totalMarksSelected1);
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
                // console.log(" else" + blMarks[blLevel]);
                // console.log(" else" + chapterMarks[chapter]);

                // if (!row.cells[0].children[0].checkbox.checked) {
                // Deduct totalMarksSelected based on the mark of the question
                if (parseInt(row.cells[3].textContent.trim()) === 10) {
                    totalMarksSelected--;
                    // alert("hello");
                    // console.log(totalMarksSelected);
                }
                if (parseInt(row.cells[3].textContent.trim()) === 5) {
                    totalMarksSelected1--;
                    // console.log(totalMarksSelected1);

                }
                // }
            }
        } else {
            // console.log("Chapter: " + chapter + ", Bloom's Level: " + blLevel);
            // Check if the checkbox is checked
            if (checkbox.checked) {
                // If checked, deduct 1 from the total questions available for the chapter and Bloom's level

                chapterQuestions[chapter]--;
                blLevelQuestions[blLevel]--;
                // console.log("Chapter Question:", chapterQuestions[chapter]);
                // console.log("BL Level Question:", blLevelQuestions[blLevel]);
                // selectedCheckboxIDs.push(questionId);
                // Check if the available questions for the Bloom's level is less than 0
                if (chapterQuestions[chapter] < 0) {
                    // If so, uncheck the checkbox
                    checkbox.checked = false;
                    chapterQuestions[chapter]++;
                    blLevelQuestions[blLevel]++;

                    // console.log("Chapter Question:", chapterQuestions[chapter]);
                    // console.log("BL Level Question:", blLevelQuestions[blLevel]);
                    // Show an alert message
                    swal(chapter + " Chapter's: All questions are selected.");
                }
                if (blLevelQuestions[blLevel] < 0) {
                    // If so, uncheck the checkbox
                    checkbox.checked = false;
                    chapterQuestions[chapter]++;
                    blLevelQuestions[blLevel]++;
                    // console.log("Chapter Question:", chapterQuestions[chapter]);
                    // console.log("BL Level Question:", blLevelQuestions[blLevel]);
                    // Show an alert message
                    swal(blLevel + " level: All questions are selected.");
                }
            } else {
                // If unchecked, add 1 back to the total questions available for the chapter and Bloom's level
                chapterQuestions[chapter]++;
                blLevelQuestions[blLevel]++;

                // console.log("Chapter Question:", chapterQuestions[chapter]);
                // console.log("BL Level Question:", blLevelQuestions[blLevel]);

            }
        }

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
                // selectedCheckboxIDs.push(selectedInfo);
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
        document.getElementById("checkboxID").value = selectedCheckboxIDs.map(info => info.id + '-' +
            info.blLevel).join(',');

        // Log the selectedCheckboxIDs array to see the IDs of selected checkboxes
        console.log("Selected Checkbox IDs: " + selectedCheckboxIDs.map(info => info.id + '-' + info
            .blLevel));

        updateFooterRows();
    });

    // Global array to store the first marks
    let initialMarksStored = false;
    let initialMarksArray = [];


    function storeInitialMarks() {
        if (initialMarksStored) return;

        let snapshot = []; // Temporary array to store first marks

        if (totalMarks == 175 || totalMarks == 100) {
            for (let blLevel in blMarks) {
                if (blMarks.hasOwnProperty(blLevel)) {
                    snapshot.push({
                        type: "Bloom",
                        level: blLevel,
                        marks: blMarks[blLevel]
                    });
                }
            }
            for (let chapter in chapterMarks) {
                if (chapterMarks.hasOwnProperty(chapter)) {
                    snapshot.push({
                        type: "Chapter",
                        chapter: chapter,
                        marks: chapterMarks[chapter]
                    });
                }
            }
        } else {
            for (let blLevel in blLevelQuestions) {
                if (blLevelQuestions.hasOwnProperty(blLevel)) {
                    let remaining = blLevelQuestions[blLevel] || 0;
                    snapshot.push({
                        type: "Bloom",
                        level: blLevel,
                        marks: remaining * 10
                    });
                }
            }
            for (let chapter in chapterQuestions) {
                if (chapterQuestions.hasOwnProperty(chapter)) {
                    let remaining = chapterQuestions[chapter] || 0;
                    snapshot.push({
                        type: "Chapter",
                        chapter: chapter,
                        marks: remaining * 10
                    });
                }
            }
        }

        initialMarksArray = snapshot; // Store the snapshot
        initialMarksStored = true;

        // Log a **stringified snapshot** to avoid console live update issues
        console.log("Initial Marks Stored:", JSON.stringify(initialMarksArray, null, 2));
        // --- Store in hidden inputs for form submission ---
        let bloomData = initialMarksArray.filter(item => item.type === "Bloom");
        let chapterData = initialMarksArray.filter(item => item.type === "Chapter");

        document.getElementById("blWeightageData").value = JSON.stringify(bloomData);
        document.getElementById("chapterWeightageData").value = JSON.stringify(chapterData);

    }

    // Function to update the footer rows with remaining questions or Bloom's Level marks and chapter weightage
    function updateFooterRows() {
        storeInitialMarks();

        var footerTable = document.getElementById("footerTable");

        if (!footerTable) {
            footerTable = document.createElement("table");
            footerTable.id = "footerTable";
            footerTable.className = "footer-table";
            document.body.appendChild(footerTable);
        }

        footerTable.innerHTML = ""; // Clear old content

        // --- Add Title/Header Row ---
        var headerRow = document.createElement("tr");
        headerRow.innerHTML = `<th colspan="7" style="text-align:center; background:#f0f0f0;">Summary</th>`;
        footerTable.appendChild(headerRow);

        if (totalMarks == 175 || totalMarks == 100) {
            // Bloom's level row
            var blLevelRow = document.createElement("tr");
            blLevelRow.innerHTML = `<td>Bloom's Level Marks:</td>`;
            for (var blLevel in blMarks) {
                if (blMarks.hasOwnProperty(blLevel)) {
                    blLevelRow.innerHTML += `<td>${blLevel}: ${blMarks[blLevel]}</td>`;
                }
            }
            footerTable.appendChild(blLevelRow);

            // Chapter weightage rows with wrapping
            var chapterRow = document.createElement("tr");
            chapterRow.innerHTML = `<td rowspan="2">Chapter Weightage:</td>`; // rowspan if multiple rows

            let count = 0;
            let tempRow = chapterRow;

            for (var chapter in chapterMarks) {
                if (chapterMarks.hasOwnProperty(chapter)) {
                    if (count > 0 && count % 6 === 0) {
                        footerTable.appendChild(tempRow);
                        tempRow = document.createElement("tr");
                    }
                    tempRow.innerHTML += `<td>${chapter}: ${chapterMarks[chapter]}</td>`;
                    count++;
                }
            }

            // Append last row
            footerTable.appendChild(tempRow);



        } else {
            // Bloom's level remaining questions row
            var blLevelRow = document.createElement("tr");
            blLevelRow.innerHTML = `<td>Bloom's Level Marks:</td>`;
            for (var blLevel in blLevelQuestions) {
                if (blLevelQuestions.hasOwnProperty(blLevel)) {
                    var remaining = blLevelQuestions[blLevel] || 0;
                    blLevelRow.innerHTML += `<td>${blLevel}: ${remaining * 10}</td>`;
                }
            }
            footerTable.appendChild(blLevelRow);

            // Chapter remaining questions row(s)
            var chapters = Object.keys(chapterQuestions);
            var maxCols = 6; // number of chapter cells per row (adjust as needed)
            var rowAdded = false;

            for (let i = 0; i < chapters.length; i++) {
                if (i % maxCols === 0) {
                    // create a new row every maxCols chapters
                    var chapterRow = document.createElement("tr");

                    // only put the label in the first row
                    if (!rowAdded) {
                        chapterRow.innerHTML =
                            `<td rowspan="${Math.ceil(chapters.length / maxCols)}">Chapter Weightage:</td>`;
                        rowAdded = true;
                    }
                }

                let chapter = chapters[i];
                let remaining = chapterQuestions[chapter] || 0;
                chapterRow.innerHTML += `<td>${chapter}: ${remaining * 10}</td>`;

                // when row is filled OR last chapter reached → append row
                if ((i + 1) % maxCols === 0 || i === chapters.length - 1) {
                    footerTable.appendChild(chapterRow);
                }
            }


        }

        // Total marks row
        var totalMarksRow = document.createElement("tr");
        totalMarksRow.innerHTML = `<td colspan="7">Total Marks: ${totalMarks}</td>`;
        footerTable.appendChild(totalMarksRow);
    }
    // Call the function to initially populate the footer rows
    updateFooterRows();

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
        <th>No.</th> <!-- NEW column -->
        <th>Question</th>
        <th>Marks</th>
        <th>Chapter</th>
        <th>CO Level</th>
        <th>Bloom's Level</th>
    `;
    previewTable.appendChild(headerRow);



    var totalSelected = Array.from(document.querySelectorAll('.question_checkbox'))
        .filter(cb => cb.checked).length;
    selectedCheckboxIDs = [];
    var seqCount = 1;
    document.querySelectorAll('.question_checkbox').forEach(function(checkbox) {
        if (checkbox.checked) {
            var row = checkbox.closest("tr");
            var qid = checkbox.id;
            var question = row.cells[2].textContent.trim();
            var marks = row.cells[3].textContent.trim();
            var chapter = row.cells[4].textContent.trim();
            var coLevel = row.cells[5].textContent.trim();
            var blLevelSelect = row.querySelector('.bl-level-select');
            var blLevel = blLevelSelect.value;

            // Create row
            var questionRow = document.createElement('tr');
            questionRow.dataset.qid = qid;
            questionRow.innerHTML = `
            <td></td>
            <td>${question}</td>
            <td>${marks}</td>
            <td>${chapter}</td>
            <td>${coLevel}</td>
            <td>${blLevel}</td>
        `;

            // Create seq dropdown
            var seqSelect = document.createElement('select');
            seqSelect.classList.add('seq-select');
            for (let i = 1; i <= totalSelected; i++) {
                let opt = document.createElement('option');
                opt.value = i;
                opt.textContent = i;
                if (i === seqCount) opt.selected = true;
                seqSelect.appendChild(opt);
            }
            // Add the sequence dropdown into the first cell
            var seqCell = document.createElement('td');
            seqCell.appendChild(seqSelect);
            questionRow.replaceChild(seqCell, questionRow.firstElementChild);
            previewTable.appendChild(questionRow);

            // Now push to selectedCheckboxIDs
            selectedCheckboxIDs.push({
                id: qid,
                blLevel: blLevel,
                seq: seqCount
            });

            seqCount++;
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
        swal("Please select questions for all Bloom's Levels and Chapters.");
    } else {
        // Proceed with confirmation logic
        // console.log("All questions have been selected.");

        // Append the table to the preview container
        document.getElementById('previewContainer').appendChild(previewTable);


        // Attach change listener to all seqSelect dropdowns
        function validateSequences() {
            let seqValues = {};
            let duplicates = new Set();

            // Collect values and track duplicates
            document.querySelectorAll('.seq-select').forEach(select => {
                let val = select.value;
                if (seqValues[val]) {
                    duplicates.add(val);
                } else {
                    seqValues[val] = true;
                }
            });

            // Update UI (red box)
            document.querySelectorAll('.seq-select').forEach(select => {
                if (duplicates.has(select.value)) {
                    select.classList.add('duplicate-seq');
                } else {
                    select.classList.remove('duplicate-seq'); // ✅ remove red if resolved
                }
            });
        }

        previewTable.querySelectorAll('.seq-select').forEach(function(select) {
            select.addEventListener('change', function() {
                let newSeq = parseInt(this.value);
                let row = this.closest('tr');
                row.dataset.seq = newSeq;
                let qid = row.dataset.qid;

                validateSequences();

                // Update seq in selectedCheckboxIDs
                let info = selectedCheckboxIDs.find(obj => obj.id === qid);
                if (info) info.seq = newSeq;

                // Update hidden input
                document.getElementById("checkboxID").value = selectedCheckboxIDs
                    .map(info => info.id + '-' + info.blLevel + '-' + info.seq)
                    .join(',');

                // Optional: check duplicates
                let allSeq = Array.from(previewTable.querySelectorAll('.seq-select')).map(s =>
                    parseInt(s.value));
                let duplicates = allSeq.filter((v, i, arr) => arr.indexOf(v) !== i);


                console.log("Updated Checkbox IDss: " + document.getElementById("checkboxID")
                    .value);
            });
        });

        // Update the hidden input with the final selected IDs and sequences
        document.getElementById("checkboxID").value = selectedCheckboxIDs
            .map(info => info.id + '-' + info.blLevel + '-' + info.seq)
            .join(',');
        console.log("Updated Checkbox IDs: " + document.getElementById("checkboxID").value);

        // event listener to the confirmation checkbox
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