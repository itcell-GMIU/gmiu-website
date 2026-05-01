<?php
include '../../common/importwebsitefile.php';


if (isset($_GET['program_id']) && !empty($_GET['program_id'])) {
    $program_id = mysqli_real_escape_string($con, $_GET['program_id']);
    $program_id = only_digits($program_id);
    if ($program_id == false) {
        redirectHome("Invalid data in url");
    }

    $cmd = $con->prepare("SELECT level.name as level_name, program.name as program_name,
     program.id as program_id, program.program_slug as program_slug,
    program.description as program_description 
    FROM tbl_program as program 
    LEFT JOIN tbl_level as level ON program.level_id = level.id 
    WHERE program.id=? AND program.is_active=1 AND program.is_delete=0");
    $cmd->bind_param("i", $program_id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
        $program_description = $row['program_description'];
        $level_name = $row['level_name'];
        $program_slug = $row['program_slug'];
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
        echo "<script>setTimeout(function(){window.location='https://gmiu.edu.in/'},1000)</script>";
    }
    //  fetch faculty details
    $cmd = $con->prepare("SELECT faculty.name as faculty_name ,faculty.faculty_slug as faculty_slug  from tbl_faculty as faculty WHERE id=? AND is_active=1 AND is_delete=0");
    $cmd->bind_param("i", $faculty_id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $faculty_name = $row['faculty_name'];
         $faculty_slug = $row['faculty_slug'];
    } else {
        $faculty_name = "";
    }
} else {
    $faculty_id = "";
    $faculty_name = "";
}

// Redirect if both faculty_id and program_id exist
if (!empty($faculty_slug) && !empty($program_slug)) {
    $redirect_url = "https://gmiu.edu.in/gmiu/website/faculty/$faculty_slug/$program_slug/placement";
    header("Location: $redirect_url");
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
        .container-plc {
            margin-top: 10px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }

        .container-plc::before {
            display: none;
        }

        .card-plc {
            margin: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            width: 150px;
            height: 250px;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 15px;
        }

        .card-plc:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .plc-std {
            width: inherit;
            height: 100px;
            border-radius: 5px 5px 0 0;
        }

        .plc-logo {
            height: 50px;
        }

        .container-plc {
            padding: 2px 16px;
        }
    </style>
</head>

<body class="courses">
    <!-- Preloader
<div id="preloader">
    <div id="status">&nbsp;</div>
</div> -->
    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>PLACEMENT</h1>
                    <p style="font-size: 14px; text-transform: capitalize;">By Department Of <?= $program_name ?></p>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                      <span class="b-active"><a href="<?php echo $base_url_website_faculty; ?>faculty.php?id=<?php echo $faculty_id ?>"><?php echo $faculty_name; ?></a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#"><?php echo $program_name.' ('.$level_name .')'; ?></a><i class='fa fa-angle-right'></i></span>
                    <!--<span class="b-active"><a href=""><?//= $program_name ?></a> <i class='fa fa-angle-right'></i></span>-->
                    <span class="b-active"><a href="#">Placement</a></span>
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

                        <!-- Faculty about  -->
                        <section class="placement-overview">
                            <div class="buttons-container-flex">
                                <?php
                                //code for getting year buttons by grouping year in placement table
                                $cmd = "SELECT year FROM tbl_placement WHERE is_active = 1 AND is_delete = 0 and program_id = ? and faculty_id = ? GROUP BY year ORDER BY year DESC";
                                $stmt = $con->prepare($cmd);
                                $stmt->bind_param("ii", $program_id, $faculty_id);
                                $stmt->execute();
                                $result = $stmt->get_result();



                                while ($row = $result->fetch_assoc()) {
                                    $sem_btn = $row['year'];
                                ?>
                                    <!-- <a href="#s-<?php echo $sem_btn; ?>"> -->
                                    <button class="tabBtn" data-semester="<?php echo $sem_btn; ?>" onclick="showSemester(<?php echo $sem_btn; ?>)"><?php echo $sem_btn; ?></button>
                                    <!-- </a> -->
                                <?php
                                }
                                ?>
                            </div>
                            <hr>
                            <h3 class="title gradText">PLACEMENT OVERVIEW</h3>
                            <hr>
                            <?php
                            //code for getting year buttons by grouping year in placement table
                            // $cmd6 = "SELECT year FROM tbl_placement WHERE is_active = 1 AND is_delete = 0 and program_id = $program_id and faculty_id = $faculty_id GROUP BY year ORDER BY year DESC ";
                            // $stmt6 = $con->prepare($cmd6);
                            // $stmt6->execute();
                            // $result6 = $stmt6->get_result();
                            $cmd = $con->prepare("SELECT `year`, `registered_students`, `placed_students`, `placement_rat`, `highest_package`, `average_package`, `companies_visited` FROM tbl_placement_overview  WHERE faculty_id = ? AND program_id = ? AND is_active=1 AND is_delete=0 GROUP BY year ORDER BY year DESC");
                            $cmd->bind_param("ii", $faculty_id, $program_id);
                            $cmd->execute();
                            $result = $cmd->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $registered_students = $row['registered_students'];
                                    $placed_students = $row['placed_students'];
                                    $placement_rat = $row['placement_rat'];
                                    $highest_package = $row['highest_package'];
                                    $average_package = $row['average_package'];
                                    $companies_visited = $row['companies_visited'];
                                    $sem_c = $row['year'];
                            ?>
                                    <div class="placement-cards-container semester-content2 row" id="semC-<?php echo $sem_c; ?>" style="display: none;" id="test2">
                                        <div class="row">
                                            <div class="col-sm-4 col-6 p-2" style="margin-top: 10px;">
                                                <div class="placement-card">
                                                    <span class="head"><?php echo $registered_students; ?></span>
                                                    <span class="info">Registered Students</span>
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 col-6 p-2" style="margin-top: 10px;">
                                                <div class="placement-card">
                                                    <span class="head"><?php echo $placed_students; ?></span>
                                                    <span class="info">Placed Students</span>
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 col-6 p-2" style="margin-top: 10px;">
                                                <div class="placement-card">
                                                    <span class="head"><?php echo $placement_rat; ?></span>
                                                    <span class="info">Placement Rate</span>
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">


                                            <div class="col-sm-4 col-6 p-2" style="margin-top: 10px;">
                                                <div class="placement-card">
                                                    <span class="head"><?php echo $highest_package; ?></span>
                                                    <span class="info">Highest Package</span>
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 col-6 p-2" style="margin-top: 10px;">
                                                <div class="placement-card">
                                                    <span class="head"><?php echo $average_package; ?></span>
                                                    <span class="info">Average Package</span>
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 col-6 p-2" style="margin-top: 10px;">
                                                <div class="placement-card">
                                                    <span class="head"><?php echo $companies_visited; ?></span>
                                                    <span class="info">Companies Visited</span>
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>

                        </section>

                        <section class="placed-students">
                            <h3 class="title gradText">PLACED STUDENTS</h3>
                            <hr>
                            <?php
                            //code for getting year buttons by grouping year in placement table
                            // $cmd6 = "SELECT year FROM tbl_placement WHERE is_active = 1 AND is_delete = 0 and program_id = $program_id and faculty_id = $faculty_id GROUP BY year ORDER BY year DESC ";
                            // $stmt6 = $con->prepare($cmd6);
                            // $stmt6->execute();
                            // $result6 = $stmt6->get_result();
                            $cmd6 = "SELECT year FROM tbl_placement WHERE is_active = 1 AND is_delete = 0 and program_id = ? and faculty_id = ? GROUP BY year ORDER BY year DESC";
                            $stmt6 = $con->prepare($cmd6);
                            $stmt6->bind_param("ii", $program_id, $faculty_id);
                            $stmt6->execute();
                            $result6 = $stmt6->get_result();


                            while ($row6 = $result6->fetch_assoc()) {
                                $sem_c = $row6['year'];
                            ?>
                                <div class="placement-cards-container semester-content" id="sem-<?php echo $sem_c; ?>" style="display: none;">
                                    <div class="row container-plc">
                                        <?php
                                        $cmd9 = $con->prepare("SELECT `student_name`, `student_image`, `company_logo`, `package` FROM tbl_placement WHERE program_id=? AND is_active=1 AND is_delete=0 AND year = $sem_c");
                                        $cmd9->bind_param("i", $program_id);
                                        $cmd9->execute();
                                        $result9 = $cmd9->get_result();
                                        if ($result9->num_rows > 0) {
                                            while ($row9 = $result9->fetch_assoc()) {
                                                $student_name = $row9['student_name'];
                                                $student_image = $row9['student_image'];
                                                $company_logo = $row9['company_logo'];
                                        ?> <!-- //code for getting year wise student -->
                                                <div class="col-sm-3 card-plc">
                                                    <img class="plc-std" src="<?php echo $upload_website_admin_url; ?>placement/student_image/<?php echo $student_image; ?>" alt="Avatar" style="height:150px;">
                                                    <div class="container-plc">
                                                        <h5 style="margin: 0; padding:0;"><?php echo $student_name; ?></h5>
                                                    </div>
                                                    <img class="plc-logo" src="<?php echo $upload_website_admin_url; ?>placement/company_logo/<?php echo $company_logo; ?>" alt="Avatar" style="width:100%">
                                                </div>
                                        <?php }
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                    </div>
                </div>
                <!-- right bar start  -->
                <?php include '../include/importrightsidebar.php' ?>
                <!-- right bar end  -->
                </section>
            </div>
        </div>
        <!-- left bar end  -->


    </div>
    </div>
    </div>





    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->
    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <script>
        //script for hide and show on year button click
        function placement_overview(year) {
            var i;
            var x = document.getElementsByClassName("placement-cards-container");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            var id = document.getElementById(year) /* .style.display = "block"; */
            var test = document.getElementById('test') /* .style.display = "block"; */

            $(id).show();
            $(test).show();

        }
    </script>
    <script>
    function showSemester(semesterId) {
        var semesterDivs = document.querySelectorAll('.semester-content');
        var semesterDivs2 = document.querySelectorAll('.semester-content2');
        var semesterButtons = document.querySelectorAll('.tabBtn');

        // Hide all semester divs
        for (var i = 0; i < semesterDivs.length; i++) {
            semesterDivs[i].style.display = 'none';
        }

        // Hide all second semester divs
        for (var i = 0; i < semesterDivs2.length; i++) {
            semesterDivs2[i].style.display = 'none';
        }

        // Remove "active" class from all buttons
        for (var i = 0; i < semesterButtons.length; i++) {
            semesterButtons[i].classList.remove('tabBtn-active');
        }

        // Show selected semester div if it exists, otherwise show the first available semester div
        var semesterDiv = document.getElementById('sem-' + semesterId);
        if (!semesterDiv) {
            for (var i = 0; i < semesterDivs.length; i++) {
                if (semesterDivs[i].style.display !== 'none') {
                    semesterDiv = semesterDivs[i];
                    semesterId = semesterDiv.getAttribute('id').split('-')[1];
                    break;
                }
            }
        }

        semesterDiv.style.display = 'block';

        // Show selected second semester div if it exists, otherwise show the first available second semester div
        var semesterDiv2 = document.getElementById('semC-' + semesterId);
        if (!semesterDiv2) {
            for (var i = 0; i < semesterDivs2.length; i++) {
                if (semesterDivs2[i].style.display !== 'none') {
                    semesterDiv2 = semesterDivs2[i];
                    semesterId = semesterDiv2.getAttribute('id').split('-')[1];
                    break;
                }
            }
        }

        semesterDiv2.style.display = 'block';

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

    var secondSemesterDiv = document.querySelector('.semester-content2');
    if (secondSemesterDiv) {
        var secondSemesterId = secondSemesterDiv.getAttribute('id').split('-')[1];
        showSemester(secondSemesterId);
    }
</script>

    <?php include '../include/importjs.php'; ?>

</body>

</html>