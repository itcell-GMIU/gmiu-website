<?php
include '../../common/importwebsitefile.php';

if (isset($_GET['faculty_id']) && !empty($_GET['faculty_id']) && isset($_GET['program_id']) && !empty($_GET['program_id'])) {
    $faculty_id = intval($_GET['faculty_id']);
    $program_id = intval($_GET['program_id']);

    // Prepare query to get faculty_slug
    $cmd_faculty = $con->prepare("SELECT faculty_slug FROM tbl_faculty WHERE id=? AND is_active=1 AND is_delete=0");
    $cmd_faculty->bind_param("i", $faculty_id);
    $cmd_faculty->execute();
    $result_faculty = $cmd_faculty->get_result();

    // Prepare query to get program_slug
    $cmd_program = $con->prepare("SELECT program_slug FROM tbl_program WHERE id=? AND is_active=1 AND is_delete=0");
    $cmd_program->bind_param("i", $program_id);
    $cmd_program->execute();
    $result_program = $cmd_program->get_result();

    if ($result_faculty->num_rows > 0 && $result_program->num_rows > 0) {
        $row_faculty = $result_faculty->fetch_assoc();
        $row_program = $result_program->fetch_assoc();

        $faculty_slug = $row_faculty['faculty_slug'];
        $program_slug = $row_program['program_slug'];

        // Redirect
        header("Location: https://gmiu.edu.in/gmiu/website/faculty/" . $faculty_slug . '/' . $program_slug . '/student-corner' ,  true, 301);
        exit;
    }  elseif ($result_faculty->num_rows > 0) {
        $row_faculty = $result_faculty->fetch_assoc();
        $faculty_slug = $row_faculty['faculty_slug'];

        // Redirect to faculty page only
        header("Location: https://gmiu.edu.in/gmiu/website/faculty/" . $faculty_slug, true, 301);
        exit;
    }
    else {
        header("Location: https://gmiu.edu.in/gmiu/website/", true, 301);
        exit;
    }
} else {
    echo "Missing parameters.";
    exit;
}
?>
<?php



if (isset($_GET['program_id']) && !empty($_GET['program_id'])) {
    $program_id = mysqli_real_escape_string($con, $_GET['program_id']);
    $program_id = only_digits($program_id);
    if ($program_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='https://gmiu.edu.in/'},1000)</script>";
    }

    $cmd = $con->prepare("SELECT level.name as level_name, program.name as program_name ,program.id as program_id,program.description as program_description from tbl_program as program LEFT JOIN tbl_level as level ON program.level_id = level.id
    WHERE program.id=? AND program.is_active=1 AND program.is_delete=0");
    $cmd->bind_param("i", $program_id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
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

if (isset($_GET['faculty_id']) && !empty($_GET['faculty_id'])) {
    $faculty_id = mysqli_real_escape_string($con, $_GET['faculty_id']);
    $faculty_id = only_digits($faculty_id);
    if ($faculty_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location=https://gmiu.edu.in/'},1000)</script>";
    }

    //  fetch faculty details
    $cmd = $con->prepare("SELECT faculty.name as faculty_name from tbl_faculty as faculty WHERE faculty.id=? AND faculty.is_active=1 AND faculty.is_delete=0");
    $cmd->bind_param("i", $faculty_id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $faculty_name = $row['faculty_name'];
    } else {
        $faculty_name = "";
    }
} else {
    $faculty_id = "";
    $faculty_name = "";
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
        #dwn-btn a{
            color: white;
        }
        #dwn-btn{
            padding: 5px 10px;
            background-color: #ba2a21;
            color: white;
            border: 1px transparent;
            border-radius: 4px;
        }
        #dwn-btn:hover{
            transform: translateY(-5px);
            transition: all .3s ease-in-out;
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
                    <h1><?php echo $program_name.' ('.$level_name .')'; ?></h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="<?php echo $base_url_website_faculty; ?>faculty.php?id=<?php echo $faculty_id ?>"><?php echo $faculty_name; ?></a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#"><?php echo $program_name.' ('.$level_name .')'; ?></a></span>
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
                                $cmd = "SELECT sem FROM tbl_std_corner WHERE is_active = 1 AND is_delete = 0 and program_id = $program_id and faculty_id = $faculty_id GROUP BY sem ORDER BY `sem`";
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
                            $cmd2 = "SELECT sem FROM tbl_std_corner WHERE is_active = 1 AND is_delete = 0 and program_id = $program_id and faculty_id = $faculty_id GROUP BY sem ORDER BY `sem`";
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
                                                $cmd = $con->prepare("SELECT id, sem,subject_code,subject_name,subject_short_name, lectures,tutorial,practical,credit, syllabus FROM tbl_std_corner WHERE sem = $sem_c AND is_active = 1 AND is_delete = 0 and program_id = ? and faculty_id = ? ORDER BY `credit` DESC");
                                                $cmd->bind_param("ii", $program_id, $faculty_id);
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
                                            <img src="../../website_admin/uploads/timetable/<?php echo $time_table; ?>" alt="" style="width: 100%; padding-bottom: 17px;">
                                            <div class="row text-center">
                                                <button id="dwn-btn">
                                                <a class="white" href="../../website_admin/uploads/timetable/<?php echo $time_table; ?>" download>
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
                            <?php
                            }
                            ?>


                        </section>
                        
                        <section class="placed-students">
                            <h3 class="title gradText">Previous Exam Papers</h3>
                            <hr>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <form id="filterForm" method="POST" action="" style="display: flex; gap: 10px; margin-bottom: 20px;">
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="year" style="margin-right: 5px;">Year</label>
                                        <select name="year" id="year" class="form-control" required style="margin-right: 10px;">
                                            <option value="">---Select Year---</option>
                                            <?php
                                            // Fetch distinct years from the database
                                            $query = "SELECT DISTINCT year FROM tbl_exam_paper ORDER BY year DESC";
                                            $result = mysqli_query($con, $query);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $row['year'] . '">' . $row['year'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="session" style="margin-right: 5px;">Session</label>
                                        <select name="session" id="session" class="form-control" required style="margin-right: 10px;">
                                            <option value="">---Select Session---</option>
                                            <option value="Summer">Summer</option>
                                            <option value="Winter">Winter</option>
                                        </select>
                                    </div>
                                    <br>
                                    <button type="submit" name="filter" class="btn btn-primary" style="margin-top: 25px;  ">Filter</button>
                                </form>
                            </div>
                            <!-- Filtered results will be displayed here -->
                            <?php
                            // Include the PHP script to handle the filter and display results
                            include 'fetch_exam_papers.php';
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
            var semesterButtons = document.querySelectorAll('.tabBtn');

            // Hide all semester divs
            for (var i = 0; i < semesterDivs.length; i++) {
                semesterDivs[i].style.display = 'none';
            }

            // Hide all timetable divs
            for (var i = 0; i < timetableDivs.length; i++) {
                timetableDivs[i].style.display = 'none';
            }

            // Remove "active" class from all buttons
            for (var i = 0; i < semesterButtons.length; i++) {
                semesterButtons[i].classList.remove('tabBtn-active');
            }

            // Show selected semester div if it exists, otherwise show the first available semester div
            var semesterDiv = document.getElementById('sem-' + semesterId);
            var timetableDiv = document.getElementById('timetable-' + semesterId);
            if (!semesterDiv) {
                for (var i = 0; i < semesterDivs.length; i++) {
                    if (semesterDivs[i].style.display !== 'none') {
                        semesterDiv = semesterDivs[i];
                        semesterId = semesterDiv.getAttribute('id').split('-')[1];
                        timetableDiv = document.getElementById('timetable-' + semesterId);
                        break;
                    }
                }
            }

            semesterDiv.style.display = 'block';
            timetableDiv.style.display = 'block';

            // Add "active" class to the clicked button
            var clickedButton = document.querySelector('.tabBtn[data-semester="' + semesterId + '"]');
            clickedButton.classList.add('tabBtn-active');
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
