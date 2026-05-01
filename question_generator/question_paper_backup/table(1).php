
<?php
include '../include/checklogin.php';



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
$cmd = $con->prepare("SELECT p.id, c.subject_code,c.sem, p.total_mark, p.question, c.subject_name 
                      FROM tbl_paper p
                      JOIN tbl_std_corner c ON p.subject_code = c.id
                      WHERE p.id = ? AND p.is_delete = ?");
$cmd->bind_param("ii", $Id, $status);
$cmd->execute();
$result1 = $cmd->get_result();
while ($row1 = $result1->fetch_assoc()) {
    $id = $row1['id'];
    $subjectCode = $row1['subject_code'];
    $total_mark = $row1['total_mark'];
    $sem = $row1['sem'];
    $question_ids = $row1['question'];
    $subject_name = $row1['subject_name'];   
    // Use $subject_name as needed
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Gyanmanjari Institute of Technology</title>

    <style>
        * {
            font-family: 'Times New Roman', Times, serif;
        }

        .custom-line-height {
            line-height: 0.5;
        }

        .custome-width-th {
            width: 500px;
        }

        .table {
            width: 100%;
        }

        .table thead tr th,
        .table tbody tr td {
            border: 0px solid black !important;
        }

        .c-b-t th,
        .c-b-t td {
            max-height: 30px !important;
            /* Adjust the maximum height as needed */
        }

        .c-b-t {
            border: 0px solid black !important;
        }

        @media print {
            body {
                font-family: 'Times New Roman', Times, serif;
                font-size: 12pt;
                /* Adjust font size as needed */
                margin: 1cm;
                /* Remove default margin */
                padding: 0;
                /* Remove default padding */
            }

            .container-fluid {
                width: 90%;
                /* Set width to A4 size */
                margin: 0 auto;
                /* Center content horizontally */
                padding: 0cm;
                /* Adjust padding as needed */
            }

            .table {
                width: 100%;
                /* Ensure the table spans the entire container width */
            }

            .c-b-t th,
            .c-b-t td {
                max-height: 50px !important;
                /* Adjust maximum height for table cells */
                font-size: 15pt;
                /* Adjust font size for table cells */
            }

            .h1,
            .h4,
            .fs-1 {
                font-size: 36px;
                /* Adjust font sizes for headings and other text */
            }

            .custom-line-height {
                line-height: 1;
                /* Adjust line height for better readability */
            }

            .custome-width-th {
                width: 50%;
                /* Adjust width for table cells */
            }

            .tab-text {
                font-size: 1pt;
                /* Adjust font size for table text */
            }

            .print-btn {
                display: none;
            }

            .no-print {
                display: none;
                /* Hide elements with class "no-print" when printing */
            }

            .print-button {
                display: block;
                text-align: center;
                margin-top: 20px;
                /* Adjust margin top as needed */
            }
        }

        @media (max-width: 767px) {
            .h1 {
                font-size: 20px;
            }

            .h4 {
                font-size: 13px;
            }

            .fs-1 {
                font-size: 20px;
                text-wrap: nowrap;
                text-align: left;
            }

            .custom-line-height {
                line-height: 0.3;
            }

           
            .table {
                
                overflow-y: hidden;
                -ms-overflow-style: -ms-autohiding-scrollbar;
            }

            .tab-text td {
            width: 5%; /* Adjust the width as needed */
           /* word-wrap: break-word; /* Optional: This will wrap long words to the next line */
           }
            .tab-text {
                font-size: 10px;
            }
            .justify-space-between{
            justify-content: space-between;
        }

        }

       
    </style>
</head>


<body>

    <div class="container-fluid my-5">

       

        <section class="mt-4">
            <div class="d-flex justify-space-between">
                <div class="mr-5 custom-line-height">
                    <p class="fs-1">Enrollment No.:_________________</p>
                    <p class="fs-1">Subject Code:</p>
                    <p class="fs-1">Subject Name:</p>
                    <p class="fs-1">Time:</p>
                    <p class="fs-1">Instructions:</p>
                <ol style="line-height:1.5"> 
                    <li class="fs-1">Question No. 1 is Compulsory.</li>
                    <li class="fs-1">Make Suitable Assumptions wherever necessery.</li>
                    <li class="fs-1">Figures to the right indicate full marks.</li>
                </ol>
                </div>
                <div class="ml-5 custom-line-height">
                    <p class="fs-1">Date:</p>
                    <p class="fs-1">Semester: 02</p>
                    <p class="fs-1">Total Marks: 50</p>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                
            </div>
        </section>


        <div class="d-flex justify-content-center">
            <table class="border border-dark c-b-t table" border="2">

                <thead class="text-center tab-text">
                    <tr>
                        <th class="hi col-1"></th>
                        <th class="hi col-1"></th>
                        <th class="hi custome-width-th"></th>
                        <th class="hi col-1">Marks</th>
                        <th class="hi col-1">CO</th>
                        <th class="hi col-1">BL</th>
                    </tr>
                </thead>
                <?php
                if ($total_mark == 90) {
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
                    que.question as question, 
                    que.marks as marks,
                    que.bl_level as bl_level, 
                    que.co_level as co_level
                    
                    FROM tbl_questions as que
                    LEFT JOIN tbl_std_corner AS corner ON que.subject_code = corner.id
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

                        // Loop through each row fetched from the database
                        while ($row = $result->fetch_assoc()) {
                            // Store values into respective arrays
                            $idArray[] = $row['id'];
                            $semArray[] = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                            $subjectCodeArray[] = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                            $chapterArray[] = !empty($row['chapter']) ? $row['chapter'] : "<b>N/A</b>";
                          $questionArray[] = !empty($row['question']) ? preg_replace('/[,]+/', '<br>', $row['question']) : "<b>N/A</b>"; $marksArray[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                            $blLevel = !empty($row['bl_level']) ? $row['bl_level'] : "<b>N/A</b>";
                            $blLevel = substr($blLevel, 0, 1);
                            $blLevelArray[] = $blLevel;
                            $coLevelArray[] = !empty($row['co_level']) ? strtoupper($row['co_level']) : "<b>N/A</b>";
                        }


                        ?>
                        <tr>
                            <td>Q.1</td>
                            <td>(a)</td>
                            <td style="text-align: left;">
                                <?php echo $questionArray[0]; ?></td>
                            <td><?php echo    $marksArray[0]; ?></td>
                            <td><?php echo  $coLevelArray[0]; ?></td>
                            <td><?php echo  $blLevelArray[0]; ?></td>
                        </tr>
                        <!-- <tr>
                        <td><br></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr> -->
                        <tr>
                            <td>Q.2</td>
                            <td>(a)</td>
                            <td style="text-align: left;"><?php echo $questionArray[1]; ?></td>
                            <td><?php echo  $marksArray[1]; ?></td>
                            <td><?php echo  $coLevelArray[1]; ?></td>
                            <td><?php echo  $blLevelArray[1]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;"><?php echo $questionArray[2]; ?></td>
                            <td><?php echo  $marksArray[2]; ?></td>
                            <td><?php echo  $coLevelArray[2]; ?></td>
                            <td><?php echo  $blLevelArray[2]; ?></td>
                        </tr>
                        <!-- <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr> -->
                        <tr>
                            <td>Q.2</td>
                            <td>(a)</td>
                            <td style="text-align: left;"><?php echo $questionArray[3]; ?></td>
                            <td><?php echo     $marksArray[3]; ?></td>
                            <td><?php echo   $coLevelArray[3]; ?></td>
                            <td><?php echo   $blLevelArray[3]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;"><?php echo $questionArray[4]; ?></td>
                            <td><?php echo     $marksArray[4]; ?></td>
                            <td><?php echo   $coLevelArray[4]; ?></td>
                            <td><?php echo   $blLevelArray[4]; ?></td>
                        </tr>
                        <!-- <tr>
                        <td><br></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr> -->
                        <tr>
                            <td>Q.3</td>
                            <td>(a)</td>
                            <td style="text-align: left;"><?php echo $questionArray[5]; ?></td>
                            <td><?php echo     $marksArray[5]; ?></td>
                            <td><?php echo   $coLevelArray[5]; ?></td>
                            <td><?php echo   $blLevelArray[5]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;"><?php echo $questionArray[6]; ?></td>
                            <td><?php echo     $marksArray[6]; ?></td>
                            <td><?php echo   $coLevelArray[6]; ?></td>
                            <td><?php echo   $blLevelArray[6]; ?></td>
                        </tr>
                        <!-- <tr>
                        <td><br></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr> -->
                        <tr>
                            <td>Q.3</td>
                            <td>(a)</td>
                            <td style="text-align: left;"><?php echo   $questionArray[7]; ?></td>
                            <td><?php echo     $marksArray[7]; ?></td>
                            <td><?php echo   $coLevelArray[7]; ?></td>
                            <td><?php echo   $blLevelArray[7]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;">
                                <?php
                                $text = $questionArray[8];
                                // Define the regular expression pattern to match commas with optional spaces
                                $pattern = '/\s*,\s*/';

                                // Split the string into an array based on the regular expression pattern
                                $textArray = preg_split($pattern, $text);

                                // Loop through the array and remove the double quotes from each item when echoing
                                foreach ($textArray as $item) {
                                    // Remove the double quotes from the beginning and end of each item
                                    $item = trim($item, '"');
                                    echo $item . "<br>";
                                } ?>
                            </td>
                            <td><?php echo     $marksArray[8]; ?></td>
                            <td><?php echo   $coLevelArray[8]; ?></td>
                            <td><?php echo   $blLevelArray[8]; ?></td>
                        </tr>


                    <?php   }
                elseif ($total_mark == 180) {
                   
                    // Split the string into an array of IDs
                    $id_array = explode(',', $question_ids);
                    $placeholders = implode(',', array_fill(0, count($id_array), '?'));
                    $status = 0;
                    $cmd = $con->prepare("SELECT que.id as id,
                corner.sem as sem, 
                que.subject_code as subject_code, 
                que.chapter as chapter, 
                que.question as question, 
                que.marks as marks,
                que.bl_level as bl_level, 
                que.co_level as co_level
                
                FROM tbl_questions as que
                LEFT JOIN tbl_std_corner AS corner ON que.subject_code = corner.id
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

                    // Loop through each row fetched from the database
                    while ($row = $result1->fetch_assoc()) {
                        // Store values into respective arrays
                        $idArray[] = $row['id'];
                        $semArray[] = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                        $subjectCodeArray[] = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                        $chapterArray[] = !empty($row['chapter']) ? $row['chapter'] : "<b>N/A</b>";
                        $questionArray[] = !empty($row['question']) ? $row['question'] : "<b>N/A</b>";
                        // $text = $questionArray[];
                        // Define the regular expression pattern to match commas with optional spaces
                        // $pattern = '/\s*,\s*/';

                        // Split the string into an array based on the regular expression pattern
                        // $textArray = preg_split($pattern, $text);

                        // Loop through the array and remove the double quotes from each item when echoing
                        // foreach ($textArray as $item) {
                        //     // Remove the double quotes from the beginning and end of each item
                        //     $item = trim($item, '"');
                        //     echo $item . "<br>";
                        
                        $marksArray[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                        $blLevel = !empty($row['bl_level']) ? $row['bl_level'] : "<b>N/A</b>";
                        $blLevel = substr($blLevel, 0, 1);
                        $blLevelArray[] = $blLevel;
                        $coLevelArray[] = !empty($row['co_level']) ? strtoupper($row['co_level']) : "<b>N/A</b>";
                     
                    }
                    ?>
                        <tr>
                            <td>Q.1</td>
                            <td>(a)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[0]; ?></td>
                            <td><?php echo     $marksArray[0]; ?></td>
                            <td><?php echo   $coLevelArray[0]; ?></td>
                            <td><?php echo   $blLevelArray[0]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[1]; ?></td>
                            <td><?php echo     $marksArray[1]; ?></td>
                            <td><?php echo   $coLevelArray[1]; ?></td>
                            <td><?php echo   $blLevelArray[1]; ?></td>
                        </tr>
                        <tr>
                            <td>Q.2</td>
                            <td>(a)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[2]; ?></td>
                            <td><?php echo     $marksArray[2]; ?></td>
                            <td><?php echo   $coLevelArray[2]; ?></td>
                            <td><?php echo   $blLevelArray[2]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[3]; ?></td>
                            <td><?php echo     $marksArray[3]; ?></td>
                            <td><?php echo   $coLevelArray[3]; ?></td>
                            <td><?php echo   $blLevelArray[3]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>(a)</td>
                             <td style="text-align: left;">
                                <?php echo  $questionArray[4]; ?></td>
                            <td><?php echo     $marksArray[4]; ?></td>
                            <td><?php echo   $coLevelArray[4]; ?></td>
                            <td><?php echo   $blLevelArray[4]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                             <td style="text-align: left;">
                                <?php echo  $questionArray[5]; ?></td>
                            <td><?php echo     $marksArray[5]; ?></td>
                            <td><?php echo   $coLevelArray[5]; ?></td>
                            <td><?php echo   $blLevelArray[5]; ?></td>
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
                                <?php echo  $questionArray[6]; ?></td>
                            <td><?php echo     $marksArray[6]; ?></td>
                            <td><?php echo   $coLevelArray[6]; ?></td>
                            <td><?php echo   $blLevelArray[6]; ?></td>
                        </tr>

                        <tr>
                            <td>Q.3</td>
                            <td>(a)</td>
                             <td style="text-align: left;">
                                <?php echo  $questionArray[7]; ?></td>
                            <td><?php echo     $marksArray[7]; ?></td>
                            <td><?php echo   $coLevelArray[7]; ?></td>
                            <td><?php echo   $blLevelArray[7]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                             <td style="text-align: left;">
                                <?php echo  $questionArray[8]; ?></td>
                            <td><?php echo     $marksArray[8]; ?></td>
                            <td><?php echo   $coLevelArray[8]; ?></td>
                            <td><?php echo   $blLevelArray[8]; ?></td>
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
                                <?php echo  $questionArray[9]; ?></td>
                            <td><?php echo     $marksArray[9]; ?></td>
                            <td><?php echo   $coLevelArray[9]; ?></td>
                            <td><?php echo   $blLevelArray[9]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                             <td style="text-align: left;">
                                <?php echo  $questionArray[10]; ?></td>
                            <td><?php echo     $marksArray[10]; ?></td>
                            <td><?php echo   $coLevelArray[10]; ?></td>
                            <td><?php echo   $blLevelArray[10]; ?></td>
                        </tr>

                        <tr>
                            <td>Q.4</td>
                            <td>(a)</td>
                             <td style="text-align: left;">
                                <?php echo  $questionArray[11]; ?></td>
                            <td><?php echo     $marksArray[11]; ?></td>
                            <td><?php echo   $coLevelArray[11]; ?></td>
                            <td><?php echo   $blLevelArray[11]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                             <td style="text-align: left;">
                                <?php echo  $questionArray[12]; ?></td>
                            <td><?php echo     $marksArray[12]; ?></td>
                            <td><?php echo   $coLevelArray[12]; ?></td>
                            <td><?php echo   $blLevelArray[12]; ?></td>
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
                                <?php echo  $questionArray[13]; ?></td>
                            <td><?php echo     $marksArray[13]; ?></td>
                            <td><?php echo   $coLevelArray[13]; ?></td>
                            <td><?php echo   $blLevelArray[13]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                             <td style="text-align: left;">
                                <?php echo  $questionArray[14]; ?></td>
                            <td><?php echo     $marksArray[14]; ?></td>
                            <td><?php echo   $coLevelArray[14]; ?></td>
                            <td><?php echo   $blLevelArray[14]; ?></td>
                        </tr>

                        <tr>
                            <td>Q.5</td>
                            <td>(a)</td>
                             <td style="text-align: left;">
                                <?php echo  $questionArray[15]; ?></td>
                            <td><?php echo     $marksArray[15]; ?></td>
                            <td><?php echo   $coLevelArray[15]; ?></td>
                            <td><?php echo   $blLevelArray[15]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                             <td style="text-align: left;">
                                <?php echo  $questionArray[16]; ?></td>
                            <td><?php echo     $marksArray[16]; ?></td>
                            <td><?php echo   $coLevelArray[16]; ?></td>
                            <td><?php echo   $blLevelArray[16]; ?></td>
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
                                <?php echo  $questionArray[17]; ?></td>
                            <td><?php echo     $marksArray[17]; ?></td>
                            <td><?php echo   $coLevelArray[17]; ?></td>
                            <td><?php echo   $blLevelArray[17]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                             <td style="text-align: left;">
                                <?php echo  $questionArray[18]; ?></td>
                            <td><?php echo     $marksArray[18]; ?></td>
                            <td><?php echo   $coLevelArray[18]; ?></td>
                            <td><?php echo   $blLevelArray[18]; ?></td>
                        </tr>
                    </tbody>
                <?php  }  
                 elseif ($total_mark == 100) {
                   
                    // Split the string into an array of IDs
                    $id_array = explode(',', $question_ids);
                    $placeholders = implode(',', array_fill(0, count($id_array), '?'));
                    $status = 0;
                    $cmd = $con->prepare("SELECT que.id as id,
                corner.sem as sem, 
                que.subject_code as subject_code, 
                que.chapter as chapter, 
                que.question as question, 
                que.marks as marks,
                que.bl_level as bl_level, 
                que.co_level as co_level
                
                FROM tbl_questions as que
                LEFT JOIN tbl_std_corner AS corner ON que.subject_code = corner.id
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
                        $questionArray[] = !empty($row['question']) ? $row['question'] : "<b>N/A</b>";
                        $marksArray[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                        $blLevel = !empty($row['bl_level']) ? $row['bl_level'] : "<b>N/A</b>";
                        $blLevel = substr($blLevel, 0, 1);
                        $blLevelArray[] = $blLevel;
                        $coLevelArray[] = !empty($row['co_level']) ? strtoupper($row['co_level']) : "<b>N/A</b>";
                     
                    }

                    $cmd1 = $con->prepare("SELECT que.id as id,
                    corner.sem as sem, 
                    que.subject_code as subject_code, 
                    que.chapter as chapter, 
                    que.question as question, 
                    que.marks as marks,
                    que.bl_level as bl_level, 
                    que.co_level as co_level
                    
                    FROM tbl_questions as que
                    LEFT JOIN tbl_std_corner AS corner ON que.subject_code = corner.id
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
                            $questionArray5[] = !empty($row['question']) ? $row['question'] : "<b>N/A</b>";
                            $marksArray5[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                            $blLevel = !empty($row['bl_level']) ? $row['bl_level'] : "<b>N/A</b>";
                            $blLevel = substr($blLevel, 0, 1);
                            $blLevelArray5[] = $blLevel;
                            $coLevelArray5[] = !empty($row['co_level']) ? strtoupper($row['co_level']) : "<b>N/A</b>";
                     
                        }
                    ?>

                <tr>
                    <td>Q.1</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[0]; ?></td>
                            <td><?php echo     $marksArray5[0]; ?></td>
                            <td><?php echo   $coLevelArray5[0]; ?></td>
                            <td><?php echo   $blLevelArray5[0]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[1]; ?></td>
                            <td><?php echo     $marksArray5[1]; ?></td>
                            <td><?php echo   $coLevelArray5[1]; ?></td>
                            <td><?php echo   $blLevelArray5[1]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray[0]; ?></td>
                            <td><?php echo     $marksArray[0]; ?></td>
                            <td><?php echo   $coLevelArray[0]; ?></td>
                            <td><?php echo   $blLevelArray[0]; ?></td>
                </tr>
                
                <tr>
                    <td>Q.2</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[2]; ?></td>
                            <td><?php echo     $marksArray5[2]; ?></td>
                            <td><?php echo   $coLevelArray5[2]; ?></td>
                            <td><?php echo   $blLevelArray5[2]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[3]; ?></td>
                            <td><?php echo     $marksArray5[3]; ?></td>
                            <td><?php echo   $coLevelArray5[3]; ?></td>
                            <td><?php echo   $blLevelArray5[3]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray[1]; ?></td>
                            <td><?php echo     $marksArray[1]; ?></td>
                            <td><?php echo   $coLevelArray[1]; ?></td>
                            <td><?php echo   $blLevelArray[1]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td  style="text-align: center;">OR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Q.2</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[4]; ?></td>
                            <td><?php echo     $marksArray5[4]; ?></td>
                            <td><?php echo   $coLevelArray5[4]; ?></td>
                            <td><?php echo   $blLevelArray5[4]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[5]; ?></td>
                            <td><?php echo     $marksArray5[5]; ?></td>
                            <td><?php echo   $coLevelArray5[5]; ?></td>
                            <td><?php echo   $blLevelArray5[5]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray[2]; ?></td>
                            <td><?php echo     $marksArray[2]; ?></td>
                            <td><?php echo   $coLevelArray[2]; ?></td>
                            <td><?php echo   $blLevelArray[2]; ?></td>
                </tr>
               
                <tr>
                    <td>Q.3</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[6]; ?></td>
                            <td><?php echo     $marksArray5[6]; ?></td>
                            <td><?php echo   $coLevelArray5[6]; ?></td>
                            <td><?php echo   $blLevelArray5[6]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[7]; ?></td>
                            <td><?php echo     $marksArray5[7]; ?></td>
                            <td><?php echo   $coLevelArray5[7]; ?></td>
                            <td><?php echo   $blLevelArray5[7]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray[3]; ?></td>
                            <td><?php echo     $marksArray[3]; ?></td>
                            <td><?php echo   $coLevelArray[3]; ?></td>
                            <td><?php echo   $blLevelArray[3]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td  style="text-align: center;">OR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Q.3</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[8]; ?></td>
                            <td><?php echo     $marksArray5[8]; ?></td>
                            <td><?php echo   $coLevelArray5[8]; ?></td>
                            <td><?php echo   $blLevelArray5[8]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[9]; ?></td>
                            <td><?php echo     $marksArray5[9]; ?></td>
                            <td><?php echo   $coLevelArray5[9]; ?></td>
                            <td><?php echo   $blLevelArray5[9]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray[4]; ?></td>
                            <td><?php echo     $marksArray[4]; ?></td>
                            <td><?php echo   $coLevelArray[4]; ?></td>
                            <td><?php echo   $blLevelArray[4]; ?></td>
                </tr>
                 <?php  }
                 else{
                       // Split the string into an array of IDs
                       $id_array = explode(',', $question_ids);
                       $placeholders = implode(',', array_fill(0, count($id_array), '?'));
                       $status = 0;
                       $cmd3 = $con->prepare("SELECT que.id as id,
                   corner.sem as sem, 
                   que.subject_code as subject_code, 
                   que.chapter as chapter, 
                   que.question as question, 
                   que.marks as marks,
                   que.bl_level as bl_level, 
                   que.co_level as co_level
                   
                   FROM tbl_questions as que
                   LEFT JOIN tbl_std_corner AS corner ON que.subject_code = corner.id
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
                           $questionArray[] = !empty($row['question']) ? $row['question'] : "<b>N/A</b>";
                           $marksArray[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                           $blLevel = !empty($row['bl_level']) ? $row['bl_level'] : "<b>N/A</b>";
                           $blLevel = substr($blLevel, 0, 1);
                           $blLevelArray[] = $blLevel;
                           $coLevelArray[] = !empty($row['co_level']) ? strtoupper($row['co_level']) : "<b>N/A</b>";
                     
                       }
   
                       $cmd4 = $con->prepare("SELECT que.id as id,
                       corner.sem as sem, 
                       que.subject_code as subject_code, 
                       que.chapter as chapter, 
                       que.question as question, 
                       que.marks as marks,
                       que.bl_level as bl_level, 
                       que.co_level as co_level
                       
                       FROM tbl_questions as que
                       LEFT JOIN tbl_std_corner AS corner ON que.subject_code = corner.id
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
                               $questionArray5[] = !empty($row['question']) ? $row['question'] : "<b>N/A</b>";
                               $marksArray5[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                               $blLevel = !empty($row['bl_level']) ? $row['bl_level'] : "<b>N/A</b>";
                               $blLevel = substr($blLevel, 0, 1);
                               $blLevelArray5[] = $blLevel;
                               $coLevelArray5[] = !empty($row['co_level']) ? strtoupper($row['co_level']) : "<b>N/A</b>";
                     
                               
                           }
                       ?>
   

   <tr>
                    <td>Q.1</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[0]; ?></td>
                            <td><?php echo     $marksArray5[0]; ?></td>
                            <td><?php echo   $coLevelArray5[0]; ?></td>
                            <td><?php echo   $blLevelArray5[0]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[1]; ?></td>
                            <td><?php echo     $marksArray5[1]; ?></td>
                            <td><?php echo   $coLevelArray5[1]; ?></td>
                            <td><?php echo   $blLevelArray5[1]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray[0]; ?></td>
                            <td><?php echo     $marksArray[0]; ?></td>
                            <td><?php echo   $coLevelArray[0]; ?></td>
                            <td><?php echo   $blLevelArray[0]; ?></td>
                </tr>
                <tr>
                    <td>Q.2</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[2]; ?></td>
                            <td><?php echo     $marksArray5[2]; ?></td>
                            <td><?php echo   $coLevelArray5[2]; ?></td>
                            <td><?php echo   $blLevelArray5[2]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                   <td style="text-align: left;">
                                <?php echo  $questionArray5[3]; ?></td>
                            <td><?php echo     $marksArray5[3]; ?></td>
                            <td><?php echo   $coLevelArray5[3]; ?></td>
                            <td><?php echo   $blLevelArray5[3]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>OR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[4]; ?></td>
                            <td><?php echo     $marksArray5[4]; ?></td>
                            <td><?php echo   $coLevelArray5[4]; ?></td>
                            <td><?php echo   $blLevelArray5[4]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray[1]; ?></td>
                            <td><?php echo     $marksArray[1]; ?></td>
                            <td><?php echo   $coLevelArray[1]; ?></td>
                            <td><?php echo   $blLevelArray[1]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>OR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray[2]; ?></td>
                            <td><?php echo     $marksArray[2]; ?></td>
                            <td><?php echo   $coLevelArray[2]; ?></td>
                            <td><?php echo   $blLevelArray[2]; ?></td>
                </tr>
               
                <tr>
                    <td>Q.3</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[5]; ?></td>
                            <td><?php echo     $marksArray5[5]; ?></td>
                            <td><?php echo   $coLevelArray5[5]; ?></td>
                            <td><?php echo   $blLevelArray5[5]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[6]; ?></td>
                            <td><?php echo     $marksArray5[6]; ?></td>
                            <td><?php echo   $coLevelArray5[6]; ?></td>
                            <td><?php echo   $blLevelArray5[6]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray[3]; ?></td>
                            <td><?php echo     $marksArray[3]; ?></td>
                            <td><?php echo   $coLevelArray[3]; ?></td>
                            <td><?php echo   $blLevelArray[3]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>OR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Q.3</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[7]; ?></td>
                            <td><?php echo     $marksArray5[7]; ?></td>
                            <td><?php echo   $coLevelArray5[7]; ?></td>
                            <td><?php echo   $blLevelArray5[7]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[8]; ?></td>
                            <td><?php echo     $marksArray5[8]; ?></td>
                            <td><?php echo   $coLevelArray5[8]; ?></td>
                            <td><?php echo   $blLevelArray5[8]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray[4]; ?></td>
                            <td><?php echo     $marksArray[4]; ?></td>
                            <td><?php echo   $coLevelArray[4]; ?></td>
                            <td><?php echo   $blLevelArray[4]; ?></td>
                </tr>
               
                <tr>
                    <td>Q.4</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[9]; ?></td>
                            <td><?php echo     $marksArray5[9]; ?></td>
                            <td><?php echo   $coLevelArray5[9]; ?></td>
                            <td><?php echo   $blLevelArray5[9]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[10]; ?></td>
                            <td><?php echo     $marksArray5[10]; ?></td>
                            <td><?php echo   $coLevelArray5[10]; ?></td>
                            <td><?php echo   $blLevelArray5[10]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray[5]; ?></td>
                            <td><?php echo     $marksArray[5]; ?></td>
                            <td><?php echo   $coLevelArray[5]; ?></td>
                            <td><?php echo   $blLevelArray[5]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>OR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Q.4</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[11]; ?></td>
                            <td><?php echo     $marksArray5[11]; ?></td>
                            <td><?php echo   $coLevelArray5[11]; ?></td>
                            <td><?php echo   $blLevelArray5[11]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[12]; ?></td>
                            <td><?php echo     $marksArray5[12]; ?></td>
                            <td><?php echo   $coLevelArray5[12]; ?></td>
                            <td><?php echo   $blLevelArray5[12]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray[6]; ?></td>
                            <td><?php echo     $marksArray[6]; ?></td>
                            <td><?php echo   $coLevelArray[6]; ?></td>
                            <td><?php echo   $blLevelArray[6]; ?></td>
                    
                </tr>
               
                <tr>
                    <td>Q.5</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[13]; ?></td>
                            <td><?php echo     $marksArray5[13]; ?></td>
                            <td><?php echo   $coLevelArray5[13]; ?></td>
                            <td><?php echo   $blLevelArray5[13]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[14]; ?></td>
                            <td><?php echo     $marksArray5[14]; ?></td>
                            <td><?php echo   $coLevelArray5[14]; ?></td>
                            <td><?php echo   $blLevelArray5[14]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray[7]; ?></td>
                            <td><?php echo     $marksArray[7]; ?></td>
                            <td><?php echo   $coLevelArray[7]; ?></td>
                            <td><?php echo   $blLevelArray[7]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>OR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Q.5</td>
                    <td>(a)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[15]; ?></td>
                            <td><?php echo     $marksArray5[15]; ?></td>
                            <td><?php echo   $coLevelArray5[15]; ?></td>
                            <td><?php echo   $blLevelArray5[15]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(b)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray5[16]; ?></td>
                            <td><?php echo     $marksArray5[16]; ?></td>
                            <td><?php echo   $coLevelArray5[16]; ?></td>
                            <td><?php echo   $blLevelArray5[16]; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>(c)</td>
                    <td style="text-align: left;">
                                <?php echo  $questionArray[8]; ?></td>
                            <td><?php echo     $marksArray[8]; ?></td>
                            <td><?php echo   $coLevelArray[8]; ?></td>
                            <td><?php echo   $blLevelArray[8]; ?></td>
                </tr>


                 <?php   }  ?>

            </table>
        </div>


        <button onclick="window.print()" class="print-btn"><i class="fa fa-print mr5"></i>Print</button>

    </div>





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
</body>

</html>