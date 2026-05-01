<?php
include '../include/checklogin.php';
if ($role_id == 51 ) {

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



?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include '../include/importcss.php'; ?>
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> -->

    <!-- <title>Gyanmanjari Institute of Technology</title> -->

    <style>
    /* Remove unnecessary scrollbar styles */
    #acedemic::-webkit-scrollbar {
        display: none; /* for Chrome, Safari, and Opera */
    }

    * {
        font-family: "Century Schoolbook", Georgia, serif;
    }
    p {
        margin-top: 0;
        margin-bottom: 0rem;
    }
    table {
        border-collapse: collapse;
        margin: 0.5rem 0.5rem;
    }

    th, td {
        border: none !important;
        padding: 0;
    }

    .table td {
        font-size: 16pt;
        padding: 0rem;
    }

    table.dataTable td, table.dataTable th {
        -webkit-box-sizing: content-box;
        box-sizing: content-box;
        vertical-align: top;
        line-height: 1.7;
    }

    .custom-line-height {
        line-height: 1.5;
    }

    .table th {
        padding: 0rem;
    }

    .custome-width-th {
        width: 50%;
    }

    .table {
        width: 100%;
        table-layout: flex;
    }

    .hidden-row {
        display: none;
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
        table td:nth-child(2) {
            padding-right: 10px;
        }
        tbody td:last-child {
            text-align: end;
        }
    @media print {
        @page {
            margin: 0.5cm 0.5cm;
        }

        body {
            margin: 0;
        }
        /* Prevent header content from breaking into multiple lines */
                    .header-info {
                        white-space: nowrap; /* Prevent line breaks */
                    }
        .print-header {
            display: block;
            position: fixed;
            top: 0;
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
        }

        @page {
            size: A4;
            margin: 1cm;
        }

        body {
            font-family: "Century Schoolbook", Georgia, serif;
            font-size: 16pt;
            padding: 0;
            margin: 0.5in 0.5in 0 0;
            line-height: 1.2;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
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

        .h1, .h4, .th {
            font-size: 30pt;
        }

        .custom-line-height {
            line-height: 1;
        }

        .print-btn,
        .no-print,
        .dataTables_wrapper .dt-buttons {
            display: none !important;
        }

        .print-button {
            display: inline-block;
            text-align: center;
            margin-top: 20px;
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
        table td:nth-child(2) {
            padding-right: 10px;
        }
           tbody tr:last-child {
            text-align: end;
        }
    }
</style>

</head>


<body>

    <div class="wrapper">
        <button onclick="window.print()" class="print-btn"><i class="fa fa-print mr5"></i>Print</button>
        <div class="table-responsive">
        <table id="acedemic" class="dataTableLoad" style="overflow-x: auto; -ms-overflow-style: none; scrollbar-width: none;">
            <!-- <table id="acedemic" class="dataTableLoad table"> -->
                <!-- <div class="container-fluid my-5">
        <table class="border border-dark c-b-t table" border="2">
            <div class="d-flex justify-content-center"> -->

                <thead>

                    <!-- Visible row with colspan -->
                    <tr>
                        <th colspan="4" style="text-align: center; font-size :16pt;">                         
                                 GYANMANJARI INNOVATIVE UNIVERSITY<br>                            
                           <?php echo $clg_name; ?><br>
                            <?php echo $exam_name; ?>
                        </th>
                    </tr>
                    <tr class="header-info">
                        <th colspan="3" style="padding: 25px 8px 8px 8px; text-align: left;font-size: 16pt;">
                            <p>
                                Enrollment No.:_________________<br>
                                Subject Code: <?php echo $subjectCode; ?><br>
                                Subject Name: <?php echo $subject_name; ?> <br>
                                Time: <?php echo $exam_time; ?> To <?php echo $end_time; ?><br>
                                Instructions:
                            <ol>
                                <li>Question No. 1 is Compulsory.</li>
                                <li>Make Suitable Assumptions wherever necessary.</li>
                                <li>Figures to the right indicate full marks.</li>
                            </ol>
                            </p>
                        </th>
                        <th style="padding: 25px 8px 8px 8px; text-align: left; font-size: 16pt; vertical-align: top;">
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
                        <!-- <th></th>
                        <th></th>
                        <th></th>
                        <th></th> -->
                    </tr>
                    <!-- Column headers for the table content -->
                    <tr style= "text-align:end; font-size: 12pt;">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><b>Marks</b></th>
                        
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
                    que.question as question, 
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
                       

                        // Loop through each row fetched from the database
                        while ($row = $result->fetch_assoc()) {
                            // Store values into respective arrays
                            $idArray[] = $row['id'];
                            $semArray[] = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                            $subjectCodeArray[] = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                            $chapterArray[] = !empty($row['chapter']) ? $row['chapter'] : "<b>N/A</b>";
                            // $questionArray[] = !empty($row['question']) ? preg_replace('/[,]+/', '<br>', $row['question']) : "<b>N/A</b>";
                            $questionArray[] = !empty($row['question']) ? $row['question'] : "<b>N/A</b>";
                            $marksArray[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                        }


                        ?>
                        <tr>
                            <td>Q.1</td>
                            <td>(a)</td>
                            <td style="text-align: left;">
                                <?php echo $questionArray[0]; ?></td>
                            <td><?php echo    $marksArray[0]; ?></td>
                            
                        </tr>
                      
                        <tr>
                            <td>Q.2</td>
                            <td>(a)</td>
                            <td style="text-align: left;"><?php echo $questionArray[1]; ?></td>
                            <td><?php echo  $marksArray[1]; ?></td>
                            
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;"><?php echo $questionArray[2]; ?></td>
                            <td><?php echo  $marksArray[2]; ?></td>
                           
                        </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: center;">OR</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Q.2</td>
                            <td>(a)</td>
                            <td style="text-align: left;"><?php echo $questionArray[3]; ?></td>
                            <td><?php echo     $marksArray[3]; ?></td>
                            
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;"><?php echo $questionArray[4]; ?></td>
                            <td><?php echo     $marksArray[4]; ?></td>
                            
                        </tr>
                      
                        <tr>
                            <td>Q.3</td>
                            <td>(a)</td>
                            <td style="text-align: left;"><?php echo $questionArray[5]; ?></td>
                            <td><?php echo     $marksArray[5]; ?></td>
                            
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;"><?php echo $questionArray[6]; ?></td>
                            <td><?php echo     $marksArray[6]; ?></td>
                           
                        </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: center;">OR</td>
                            <td></td>
                            
                        </tr>
                        <tr>
                            <td>Q.3</td>
                            <td>(a)</td>
                            <td style="text-align: left;"><?php echo   $questionArray[7]; ?></td>
                            <td><?php echo     $marksArray[7]; ?></td>
                           
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                           <td style="text-align: left;"><?php echo   $questionArray[8]; ?></td>
                            <td><?php echo     $marksArray[8]; ?></td>
                           
                        </tr>


                 <?php   } elseif ($totalMarks == 180) {

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
                  

                    // Loop through each row fetched from the database
                    while ($row = $result1->fetch_assoc()) {
                        // Store values into respective arrays
                        $idArray[] = $row['id'];
                        $semArray[] = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                        $subjectCodeArray[] = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                        $chapterArray[] = !empty($row['chapter']) ? $row['chapter'] : "<b>N/A</b>";
                        $questionArray[] =  !empty($row['question']) ? $row['question'] : "<b>N/A</b>";
                        $marksArray[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                       
                    }
                    ?>
                        <tr>
                            <td>Q.1</td>
                            <td>(a)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[0]; ?></td>
                            <td><?php echo     $marksArray[0]; ?></td>
                            
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[1]; ?></td>
                            <td><?php echo     $marksArray[1]; ?></td>
                            
                        </tr>
                        <tr>
                            <td>Q.2</td>
                            <td>(a)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[2]; ?></td>
                            <td><?php echo     $marksArray[2]; ?></td>
                           
                        </tr>
                         <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: center;">OR</td>
                            <td></td>
                            
                        </tr>
                        <tr>
                            <td></td>
                            <td>(a)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[3]; ?></td>
                            <td><?php echo     $marksArray[3]; ?></td>
                            
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[4]; ?></td>
                            <td><?php echo     $marksArray[4]; ?></td>
                            
                        </tr>
                         <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: center;">OR</td>
                            <td></td>
                            
                        </tr>
                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[5]; ?></td>
                            <td><?php echo     $marksArray[5]; ?></td>
                            
                        </tr>
                        
                        <tr>
                            <td>Q.3</td>
                            <td>(a)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[6]; ?></td>
                            <td><?php echo     $marksArray[6]; ?></td>
                           
                        </tr>

                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[7]; ?></td>
                            <td><?php echo     $marksArray[7]; ?></td>
                            
                        </tr>
                         <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: center;">OR</td>
                            <td></td>
                           
                        </tr>
                        <tr>
                            <td>Q.3</td>
                            <td>(a)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[8]; ?></td>
                            <td><?php echo     $marksArray[8]; ?></td>
                            
                        </tr>
                       
                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[9]; ?></td>
                            <td><?php echo     $marksArray[9]; ?></td>
                           
                        </tr>
                        <tr>
                            <td>Q.4</td>
                            <td>(a)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[10]; ?></td>
                            <td><?php echo     $marksArray[10]; ?></td>
                            
                        </tr>

                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[11]; ?></td>
                            <td><?php echo     $marksArray[11]; ?></td>
                            
                        </tr>
                         </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: center;">OR</td>
                            <td></td>
                           
                        </tr>
                        <tr>
                            <td>Q.4</td>
                            <td>(a)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[12]; ?></td>
                            <td><?php echo     $marksArray[12]; ?></td>
                           
                       
                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[13]; ?></td>
                            <td><?php echo     $marksArray[13]; ?></td>
                           
                        </tr>
                        <tr>
                            <td>Q.5</td>
                            <td>(a)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[14]; ?></td>
                            <td><?php echo     $marksArray[14]; ?></td>
                            
                        </tr>

                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[15]; ?></td>
                            <td><?php echo     $marksArray[15]; ?></td>
                            
                        </tr>
                         <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: center;">OR</td>
                            <td></td>
                           
                        </tr>
                        <tr>
                            <td>Q.5</td>
                            <td>(a)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[16]; ?></td>
                            <td><?php echo     $marksArray[16]; ?></td>
                            
                        </tr>
                       
                        <tr>
                            <td></td>
                            <td>(b)</td>
                            <td style="text-align: left;">
                                <?php echo  $questionArray[17]; ?></td>
                            <td><?php echo     $marksArray[17]; ?></td>
                           
                        </tr>
                      
                    </tbody>
                <?php  } elseif ($totalMarks == 100) {

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
                que.question as question, 
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
                        $questionArray[] =  !empty($row['question']) ? : "<b>N/A</b>";
                        // !empty($row['question']) ? $row['question'] : "<b>N/A</b>";
                        $marksArray[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
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
                        $questionArray5[] = !empty($row['question']) ? : "<b>N/A</b>";
                        // !empty($row['question']) ? $row['question'] : "<b>N/A</b>";
                        $marksArray5[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                       
                    }
                    
                    
                ?>

                    <tr>
                        <td>Q.1</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[0]; ?></td>
                        <td><?php echo     $marksArray5[0]; ?></td>
                       
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[1]; ?></td>
                        <td><?php echo     $marksArray5[1]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(c)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray[0]; ?></td>
                        <td><?php echo     $marksArray[0]; ?></td>
                    </tr>

                    <tr>
                        <td>Q.2</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[2]; ?></td>
                        <td><?php echo     $marksArray5[2]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[3]; ?></td>
                        <td><?php echo     $marksArray5[3]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(c)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray[1]; ?></td>
                        <td><?php echo     $marksArray[1]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;">OR</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Q.2</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[4]; ?></td>
                        <td><?php echo     $marksArray5[4]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[5]; ?></td>
                        <td><?php echo     $marksArray5[5]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(c)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray[2]; ?></td>
                        <td><?php echo     $marksArray[2]; ?></td>
                    </tr>

                    <tr>
                        <td>Q.3</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[6]; ?></td>
                        <td><?php echo     $marksArray5[6]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[7]; ?></td>
                        <td><?php echo     $marksArray5[7]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(c)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray[3]; ?></td>
                        <td><?php echo     $marksArray[3]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;">OR</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Q.3</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[8]; ?></td>
                        <td><?php echo     $marksArray5[8]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[9]; ?></td>
                        <td><?php echo     $marksArray5[9]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(c)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray[4]; ?></td>
                        <td><?php echo     $marksArray[4]; ?></td>
                    </tr>
                <?php  } else {
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
                   que.question as question, 
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
                        $questionArray[] =  !empty($row['question']) ? $row['question'] : "<b>N/A</b>";
                        // !empty($row['question']) ? $row['question'] : "<b>N/A</b>";
                        $marksArray[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
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
                        $questionArray5[] = !empty($row['question']) ? $row['question'] : "<b>N/A</b>";
                        // !empty($row['question']) ? $row['question'] : "<b>N/A</b>";
                        $marksArray5[] = !empty($row['marks']) ? $row['marks'] : "<b>N/A</b>";
                       
                    }
                ?>


                    <tr>
                        <td>Q.1</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[0]; ?></td>
                        <td><?php echo     $marksArray5[0]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[1]; ?></td>
                        <td><?php echo     $marksArray5[1]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(c)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray[0]; ?></td>
                        <td><?php echo     $marksArray[0]; ?></td>
                    </tr>
                    <tr>
                        <td>Q.2</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[2]; ?></td>
                        <td><?php echo     $marksArray5[2]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[3]; ?></td>
                        <td><?php echo     $marksArray5[3]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;">OR</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[4]; ?></td>
                        <td><?php echo     $marksArray5[4]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(c)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray[1]; ?></td>
                        <td><?php echo     $marksArray[1]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;">OR</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(c)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray[2]; ?></td>
                        <td><?php echo     $marksArray[2]; ?></td>
                    </tr>

                    <tr>
                        <td>Q.3</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[5]; ?></td>
                        <td><?php echo     $marksArray5[5]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[6]; ?></td>
                        <td><?php echo     $marksArray5[6]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(c)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray[3]; ?></td>
                        <td><?php echo     $marksArray[3]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;">OR</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Q.3</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[7]; ?></td>
                        <td><?php echo     $marksArray5[7]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[8]; ?></td>
                        <td><?php echo     $marksArray5[8]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(c)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray[4]; ?></td>
                        <td><?php echo     $marksArray[4]; ?></td>
                    </tr>

                    <tr>
                        <td>Q.4</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[9]; ?></td>
                        <td><?php echo     $marksArray5[9]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[10]; ?></td>
                        <td><?php echo     $marksArray5[10]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(c)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray[5]; ?></td>
                        <td><?php echo     $marksArray[5]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;">OR</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Q.4</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[11]; ?></td>
                        <td><?php echo     $marksArray5[11]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[12]; ?></td>
                        <td><?php echo     $marksArray5[12]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(c)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray[6]; ?></td>
                        <td><?php echo     $marksArray[6]; ?></td>

                    </tr>

                    <tr>
                        <td>Q.5</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[13]; ?></td>
                        <td><?php echo     $marksArray5[13]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[14]; ?></td>
                        <td><?php echo     $marksArray5[14]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(c)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray[7]; ?></td>
                        <td><?php echo     $marksArray[7]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center;">OR</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Q.5</td>
                        <td>(a)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[15]; ?></td>
                        <td><?php echo     $marksArray5[15]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(b)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray5[16]; ?></td>
                        <td><?php echo     $marksArray5[16]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>(c)</td>
                        <td style="text-align: left;">
                            <?php echo  $questionArray[8]; ?></td>
                        <td><?php echo     $marksArray[8]; ?></td>
                    </tr>
                <?php   }  ?>
            </table>
        </div>
    </div>
    <?php include '../include/table.php'; ?>
    
</body>

</html>

<?php } ?>