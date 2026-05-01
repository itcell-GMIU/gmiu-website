<?php

include '../../common/importwebsitefile.php';

if (isset($_GET['program_slug']) && !empty($_GET['program_slug'])) {
    $program_slug = mysqli_real_escape_string($con, $_GET['program_slug']);
    // $program_slug = only_digits($program_slug);
    if ($program_slug == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='https://gmiu.edu.in/'},1000)</script>";
    }

    //fetch program details
    $cmd = $con->prepare("SELECT level.name as level_name, 
     REPLACE(
        REPLACE(
            REPLACE(
                program.name,
                'premium', 'PLM'
            ),
            'Premium', 'PLM'
        ),
        'PREMIUM', 'PLM'
    ) AS program_name,
    program.id as program_id, program.description as program_description, program.level_id as program_level from tbl_program as program LEFT JOIN tbl_level as level ON program.level_id = level.id
    WHERE program.program_slug=? AND program.is_active=1 AND program.is_delete=0");
    $cmd->bind_param("s", $program_slug);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
        $program_level = $row['program_level'];
        $program_id = $row['program_id'];
        $program_description = $row['program_description'];
        $level_name = $row['level_name'];
    } else {
        $program_name = "";
        $program_description = "";
    }
} else {
    $program_id = "";
    $program_name = "";
    $program_description = "";
}

if (isset($_GET['faculty_slug']) && !empty($_GET['faculty_slug'])) {
    $faculty_slug = mysqli_real_escape_string($con, $_GET['faculty_slug']);
    // $faculty_slug = only_digits($faculty_slug);
    if ($faculty_slug == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location=https://gmiu.edu.in/'},1000)</script>";
    }

    //  fetch faculty details
    $cmd = $con->prepare("SELECT faculty.id as faculty_id, faculty.name as faculty_name from tbl_faculty as faculty WHERE faculty.faculty_slug=? AND faculty.is_active=1 AND faculty.is_delete=0");
    $cmd->bind_param("s", $faculty_slug);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $faculty_name = $row['faculty_name'];
        $faculty_id = $row['faculty_id'];
    } elseif ($faculty_slug == 'faculty-of-engineering-amp-technology-diploma') {
        // Fetch faculty_description from the database where id = 1
        $query = $con->prepare("SELECT description FROM tbl_faculty WHERE id = 1");
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();

        $faculty_id = '1';
        $faculty_name = 'INSTITUTE OF ENGINEERING & TECHNOLOGY(DIPLOMA)';
        $faculty_description = $row['description'];
    }else {
        $faculty_name = "";
    }
} else {
    $faculty_id = "";
    $faculty_name = "";
}
if (!isset($program_slug) || empty($program_slug) || empty($program_name)) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . $base_url_website_faculty . $faculty_slug);
    exit;
}

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <style>
        .des p {
            margin: 0px 0px !important;
        }

        .card-shadow {
            box-shadow: rgba(0, 0, 0, 0.20) 0px 3px 8px;
            border-radius: 5px;
        }

        .card-shadow .table {
            text-align: center;
        }

        #dwn-btn a {
            color: white;
        }

        #dwn-btn {
            padding: 5px 10px;
            background-color: #ba2a21;
            color: white;
            border: 1px transparent;
            border-radius: 4px;
        }

        #dwn-btn:hover {
            transform: translateY(-5px);
            transition: all .3s ease-in-out;
        }
    </style>
    <style>
        /* Add custom styles to align the form and results side by side */
        .side-by-side {
            display: flex;
            justify-content: space-between;
        }

        .side-by-side .form-container,
        .side-by-side .results-container {
            flex: 1;
            margin-right: 10px;
            /* Adjust as needed */
        }

        .side-by-side .results-container {
            margin-right: 0;
            /* Remove margin from the last item */
        }
    </style>
</head>

<body class="courses">
    <!--   Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1><?php echo $program_name . ' (' . $level_name . ')'; ?></h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>"><?php echo $faculty_name; ?></a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="<?php echo $base_url_website_faculty?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>"><?php echo $program_name . ' (' . $level_name . ')'; ?></a></span>
                </p>
                <hr>
            </div>

        </div>

    </section>

    <div class="single-courses-area">
        <div class="container">
            <div class="row two-colum-section">
                <!-- left bar start  -->
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <section class="placed-students">
                            <h3 class="title gradText">SYLLABUS & TEACHING SCHEME</h3>
                            <hr>
                            <div class="buttons-container-flex">

                                <?php
                                //code for getting year buttons by grouping year in placement table
                                $cmd = "SELECT sem FROM tbl_std_corner WHERE is_active = 1 AND is_delete = 0 and FIND_IN_SET('$program_id', program_id) > 0 and faculty_id = $faculty_id GROUP BY sem ORDER BY `sem`";
                                $stmt = $con->prepare($cmd);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    $sem_btn = $row['sem'];
                                ?>
                                    <!-- <a href="#s-<?php echo $sem_btn; ?>"> -->
                                    <button class="tabBtn" data-semester="<?php echo $sem_btn; ?>" onclick="showSemester(<?php echo $sem_btn; ?>)">Sem <?php echo $sem_btn; ?></button>
                                    <!-- </a> -->
                                <?php
                                }
                                ?>
                            </div>
                        </section>
                        <!-- Faculty about  -->
                        <section class="des">

                            <?php
                            //code for getting year buttons by grouping year in placement table
                            $cmd2 = "SELECT sem FROM tbl_std_corner WHERE is_active = 1 AND is_delete = 0 and FIND_IN_SET('$program_id', program_id) > 0 and faculty_id = $faculty_id GROUP BY sem ORDER BY `sem`";
                            $stmt2 = $con->prepare($cmd2);
                            $stmt2->execute();
                            $result2 = $stmt2->get_result();

                            while ($row2 = $result2->fetch_assoc()) {
                                $sem_c = $row2['sem'];
                            ?>
                                <div class="card card-shadow semester-content" id="sem-<?php echo $sem_c; ?>" style="padding:1px 10px 10px 10px; margin-top: 40px; margin-bottom: 30px; display: none;">

                                    <h3 class="title gradText">Semester <?php echo $sem_c; ?></h3>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Subject Code</th>
                                                    <th class="text-center">Subject Name</th>
                                                    <th class="text-center">Short Name</th>
                                                    <th class="text-center">L</th>
                                                    <th class="text-center">T</th>
                                                    <th class="text-center">P</th>
                                                    <th class="text-center">Credit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $cmd = $con->prepare("SELECT id, sem,subject_code,subject_name,subject_short_name, lectures,tutorial,practical,credit, syllabus FROM tbl_std_corner WHERE sem = $sem_c AND is_active = 1 AND is_delete = 0 and FIND_IN_SET('$program_id', program_id) > 0 and level_id = $program_level and faculty_id = ? ORDER BY credit DESC , subject_code ASC");
                                                $cmd->bind_param("i",  $faculty_id);
                                                $cmd->execute();
                                                $result = $cmd->get_result();
                                                if ($result->num_rows > 0) {
                                                    // variable
                                                    while ($row = $result->fetch_assoc()) {
                                                        $sem = $row['sem'];
                                                        $subject_code = $row['subject_code'];
                                                        $subject_name = $row['subject_name'];
                                                        $subject_short_name = $row['subject_short_name'];
                                                        $lectures = $row['lectures'];
                                                        $tutorial = $row['tutorial'];
                                                        $practical = $row['practical'];
                                                        $credit = $row['credit'];
                                                        $syllabus = $row['syllabus'];

                                                        echo '<tr>';
                                                ?>
                                                        <td class="text-center"><a href="<?php echo $upload_website_admin_url; ?>Syllabus/<?php echo $syllabus; ?>"><?php echo $subject_code ?></a></td>
                                                <?php
                                                        echo '
                                        <td class="text-center">' . $subject_name . '</td>
                                        <td class="text-center">' . $subject_short_name . '</td>
                                        <td class="text-center">' . $lectures . '</td>
                                        <td class="text-center">' . $tutorial . '</td>
                                        <td class="text-center">' . $practical . '</td>
                                        <td class="text-center">' . $credit . '</td>
                                    </tr>';
                                                    }
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php 
                                 $paper_cmd = $con->prepare("SELECT * FROM tbl_exam_paper 
                                                WHERE sem = ? AND is_active = 1 AND is_delete = 0 
                                                AND program_id = ? 
                                                AND faculty_id = ?");
                                            $paper_cmd->bind_param('iii', $sem_c, $program_id, $faculty_id);
                                            $paper_cmd->execute();
                                            $paper_result = $paper_cmd->get_result();
                                            if ($paper_result && $paper_result->num_rows > 0) { 
                                          
                                           
                                ?>
                            <div class="card card-shadow semester-papers" id="papers-<?php echo $sem_c; ?>" style="padding:1px 10px 10px 10px; margin-top: 40px; margin-bottom: 30px; display: none;">
                                <h3 class="title gradText" style="margin-top: 30px;">Previous Exam Papers</h3>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Year</th>
                                                <th class="text-center">Session</th>
                                                <th class="text-center">Title</th>
                                                <th class="text-center">document</th>
                                                <th class="text-center">Sem</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                          
                                            
                                            if ($paper_result->num_rows > 0) {
                                                while ($paper = $paper_result->fetch_assoc()) {
                                                    echo '<tr>
                                                        <td class="text-center">' . $paper['year'] . '</td>
                                                        <td class="text-center">' . $paper['session'] . '</td>
                                                        <td class="text-center">' . $paper['title'] . '</td>
                                                        <td class="text-center">
                                                            <a href="' . $upload_website_admin_url . 'exam_paper/document/' . htmlspecialchars($paper['document']) . '" target="_blank">' . $paper['document'] . '</a>
                                                        </td>
                                                        <td class="text-center">' . $paper['sem'] . '</td>
                                                    </tr>';
                                                }
                                            } else {
                                                echo '<tr><td colspan="5" class="text-center">No Exam Papers Found</td></tr>';
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php 
                                 } 
                            ?>
                                            
                                <div class="card card-shadow semester-timetable" id="timetable-<?php echo $sem_c; ?>" style="margin-top: 40px; margin-bottom: 30px; display: none;">
                                    <?php
                                    $cmd = $con->prepare("SELECT img_name FROM tbl_timetable WHERE sem_id = $sem_c AND is_active = 1 AND is_delete = 0 and program_id = ? and faculty_id = ?");
                                    $cmd->bind_param("ii", $program_id, $faculty_id);
                                    $cmd->execute();
                                    $result = $cmd->get_result();
                                    if ($result->num_rows > 0) {
                                        // variable
                                        echo '<h3 class="title gradText" style="margin-top: 30px;">TIME TABLE</h3>
                                        <hr>';
                                        while ($row = $result->fetch_assoc()) {
                                            $time_table = $row['img_name'];
                                    ?>
                                            <img src="../../../../website_admin/uploads/timetable/<?php echo $time_table; ?>" alt="" style="width: 100%; padding-bottom: 17px;">
                                            <div class="row text-center">
                                                <button id="dwn-btn">
                                                    <a class="white" href="../../../../website_admin/uploads/timetable/<?php echo $time_table; ?>" download>
                                                        <i class="fa fa-download"></i>Download Time Table
                                                    </a></button>
                                                <br>
                                                <br>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                               <!-- Exam Paper Section -->
                            

                            <?php
                            }
                            ?>


                        </section>

                    </div>
                </div>
                <!-- left bar end  -->

                <!-- right bar start  -->
                <?php include '../include/importrightsidebar.php' ?>
                <!-- right bar end  -->
            </div>
        </div>
    </div>
    <script>
        function showSemester(semesterId) {
            var semesterDivs = document.querySelectorAll('.semester-content');
            var timetableDivs = document.querySelectorAll('.semester-timetable');
            var paperDivs = document.querySelectorAll('.semester-papers');
            var semesterButtons = document.querySelectorAll('.tabBtn');
        
            // Hide all semester, timetable, and paper divs
            for (var i = 0; i < semesterDivs.length; i++) semesterDivs[i].style.display = 'none';
            for (var i = 0; i < timetableDivs.length; i++) timetableDivs[i].style.display = 'none';
            for (var i = 0; i < paperDivs.length; i++) paperDivs[i].style.display = 'none';
        
            // Remove active class
            for (var i = 0; i < semesterButtons.length; i++) semesterButtons[i].classList.remove('tabBtn-active');
        
            // Show the selected semester content
            var semesterDiv = document.getElementById('sem-' + semesterId);
            var timetableDiv = document.getElementById('timetable-' + semesterId);
            var paperDiv = document.getElementById('papers-' + semesterId);
        
            if (semesterDiv) semesterDiv.style.display = 'block';
            if (timetableDiv) timetableDiv.style.display = 'block';
            if (paperDiv) paperDiv.style.display = 'block';
        
            // Highlight button
            var clickedButton = document.querySelector('.tabBtn[data-semester="' + semesterId + '"]');
            if (clickedButton) clickedButton.classList.add('tabBtn-active');
        }


        // Find the first available semester div and show it
        var firstSemesterDiv = document.querySelector('.semester-content');
        if (firstSemesterDiv) {
            var firstSemesterId = firstSemesterDiv.getAttribute('id').split('-')[1];
            showSemester(firstSemesterId);
        }
    </script>


    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->
    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>