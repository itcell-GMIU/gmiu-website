<?php

include '../../common/importwebsitefile.php';

if (isset($_GET['program_id']) && !empty($_GET['program_id'])) {
    $program_id = mysqli_real_escape_string($con, $_GET['program_id']);
    $program_id = only_digits($program_id);
    if ($program_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='https://gmiu.edu.in/'},1000)</script>";
    }

    //fetch program details
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

// Generate dynamic meta tags based on program_id and faculty_id
if (!empty($program_name)) {
    if ($program_id == 363 && $faculty_id == 2) {
        // Set meta tags for M. Pharmacy (Postgraduate) program
        $meta_description = "Explore pharmacy university programs, M. Pharmacy colleges in Bhavnagar and Gujarat, and online admission for pharmacy degrees. Learn about pharmaceutical science and medical science education.";
        $meta_keywords = "pharmacy university, pharmacy program, university admission, university program, pharmacy degree programs, education university, health care colleges, university apply online, university degree, teaching university, pharmacy bachelor degree, pharmacy study, medical science, pharmaceutical science degree, pharmacy course, science research, colleges and universities, education colleges, degree in pharmacy, student university, pharmaceutical course, best M. Pharmacy college in Bhavnagar, best M. Pharmacy college in Gujarat, best M. Pharmacy college near me, best M. Pharmacy college in my city, top pharmacy college, top pharmacy college in Bhavnagar, top pharmacy college in Gujarat, top pharmacy college near me, top pharmacy college in my city, top M. Pharmacy college in Bhavnagar, top M. Pharmacy college in Gujarat, top M. Pharmacy college near me, top M. Pharmacy college in my city";
    } elseif ($program_id == 119 && $faculty_id == 2) {
        // Set meta tags for B. Pharmacy (Undergraduate) program
        $meta_description = "Explore top pharmacy courses, undergraduate degree programs, and the best B. Pharmacy colleges in Bhavnagar, Gujarat, and nearby cities. Apply online for university degrees and pharmacy studies.";
        $meta_keywords = "pharmacy course, undergraduate degree, university course, pharmacy study, bachelor degree programs, undergraduate program, bachelor degree courses, undergraduate degree programs, university apply online, degree online, education university, best pharmacy college, best pharmacy college in Bhavnagar, best pharmacy college in Gujarat, best pharmacy college near me, best pharmacy college in my city, best B. Pharmacy college in Bhavnagar, best B. Pharmacy college in Gujarat, best B. Pharmacy college near me, best B. Pharmacy college in my city, top pharmacy college, top pharmacy college in Bhavnagar, top pharmacy college in Gujarat, top pharmacy college near me, top pharmacy college in my city, top B. Pharmacy college in Bhavnagar, top B. Pharmacy college in Gujarat, top B. Pharmacy college near me, top B. Pharmacy college in my city";
    }elseif ($program_id == 21 && $faculty_id == 1) {
    // Set meta tags for Civil Engineering program
    $meta_description = "Explore comprehensive civil engineering courses, including diplomas and degree programs, at our engineering university. Learn about construction engineering, structural engineering, and the skills needed for a successful career in civil engineering.";
    $meta_keywords = "civil engineering, construction engineering, civil engineering diploma, civil engineering course, engineering diploma, engineering university, structural engineering, best civil engineering colleges, civil engineering education, civil engineering programs, online civil engineering courses, civil engineering degree, top civil engineering college in Bhavnagar, top civil engineering college in Gujarat, civil engineering near me";
}
elseif ($program_id == 22 && $faculty_id == 1) {
    // Set meta tags for Mechanical Engineering program
    $meta_description = "Discover our Mechanical Engineering program, offering comprehensive courses including diplomas and degrees. Join our mechanical engineering university to explore manufacturing engineering, mechanical engineering programs, and pursue your career in engineering.";
    $meta_keywords = "mechanical engineering, mechanical engineering degree, mechanical engineering diploma, degree courses, mechanical engineering university, mechanical engineering programs, mechanical degree, mechanical university, manufacturing engineering, mechanical engineering degree programs, mechanical engineering bachelor degree, B.Tech mechanical engineering, top mechanical engineering colleges, mechanical engineering education, mechanical engineering near me";
}
elseif ($program_id == 23 && $faculty_id == 1) {
    // Set meta tags for Information Technology program
    $meta_description = "Explore our Information Technology program, offering diploma courses, degree programs, and certificate courses. Join our university to gain essential skills in IT, including business information technology and hands-on training in the latest technologies.";
    $meta_keywords = "information technology, information technology diploma, diploma course, degree courses, university information, information technology program, business information technology, information technology course, information technology certificate course, IT information technology, information technology university, information technology certificate programs, top IT universities, IT education, information technology career opportunities";
}
elseif ($program_id == 24 && $faculty_id == 1) {
    // Set meta tags for Electrical Engineering program
    $meta_description = "Discover our Electrical Engineering program, featuring comprehensive courses, diplomas, and specialized certificate courses. Join our electrical engineering university to learn about electrical systems, circuits, and the latest technologies in the field.";
    $meta_keywords = "electrical engineering, electrical engineering course, engineering diploma, electrical engineering program, electrical engineering diploma, electrical engineering university, electrical engineering curriculum, electrical certificate course, electrical engineering education, top electrical engineering colleges, electrical engineering career opportunities, electrical engineering near me";
}
elseif ($program_id == 25 && $faculty_id == 1) {
    // Set meta tags for Computer Engineering program
    $meta_description = "Explore our Computer Engineering program, offering comprehensive courses, diplomas, and online degrees. Join our software engineering university to gain expertise in software development, computer systems, and cutting-edge technologies.";
    $meta_keywords = "computer engineering, computer engineering course, engineering diploma, software engineering, computer engineer programs, software engineering program, software engineer diploma, computer engineering diploma, software engineer university, software engineering course, computer programs, computer engineering degree online, computer engineering certificate programs, top computer engineering colleges, computer engineering education, software development";
}
elseif ($program_id == 118 && $faculty_id == 1) {
    // Set meta tags for Chemical Engineering program
    $meta_description = "Discover our Chemical Engineering program, offering a range of courses, bachelor's degrees, and certificate programs. Join our chemical engineering university to explore environmental engineering and gain the knowledge needed for a successful career in chemical processes.";
    $meta_keywords = "chemical engineering, chemical engineering degree, university certificate programs, chemical engineering course, environmental engineering, bachelor degree programs, chemical engineering programs, engineering curriculum, chemical engineering curriculum, bachelor degree in engineering, chemical engineering university, chemical engineering bachelor degree, top chemical engineering colleges, chemical engineering education, chemical process engineering";
}
elseif ($program_id == 189 && $faculty_id == 1) {
    // Set meta tags for Costume Design program
    $meta_description = "Explore our Costume Design courses, including diploma and degree programs in fashion designing. Join our design university to learn about computer-aided design and the latest trends in fashion.";
    $meta_keywords = "costume design courses, fashion designing course, fashion designing, diploma course, computer aided design, design university, degree courses, fashion design education, fashion design diploma, top fashion design colleges";
}
elseif ($program_id == 190 && $faculty_id == 1) {
    // Set meta tags for Interior Design program
    $meta_description = "Join our Interior Design diploma course to gain skills in interior design, decoration, and space planning. Explore our interior design bachelor degree and certificate programs at our design university.";
    $meta_keywords = "interior design diploma course, interior design, interior design diploma, interior design course, interior design bachelor degree, interior design certificate course, interior design certificate programs, design diploma, interior design university, interior design course university, interior design class, interior design study, interior design degree programs, degree in interior design, certificate in interior design, designing courses, diploma programs, diploma in fashion designing";
}
elseif ($program_id == 213 && $faculty_id == 1) {
    // Set meta tags for Electronics and Communication Engineering program
    $meta_description = "Discover our Electronics and Communication Engineering program, featuring comprehensive courses in electronics and communication. Join our engineering classes to explore career opportunities in this dynamic field.";
    $meta_keywords = "electronics and communication engineering, communication course, electronic engineering, electronics courses, electronic engineering courses, communication engineering, electronics engineering degree programs, engineering class, top electronics engineering colleges, electronics education";
}

elseif ($program_id == 365 && $faculty_id == 26) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover GMIU's program offerings in the Faculty of Management, designed to prepare students for leadership roles in the business world with practical skills.";
    
    $meta_keywords = "university admission, degree courses, university program, university study, faculty of law, top law college in bhavnagar, top law college in gujarat, top llb college in bhavnagar, top llb college in gujarat, best law college in bhavnagar, best law college in gujarat, best llb college in bhavnagar, best llb college in gujarat";
}

}

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head> 
    <?php
    echo '<meta name="description" content="' . htmlspecialchars($meta_description)  . '">' . "\n";
    echo '<meta name="keywords" content="' . htmlspecialchars($meta_keywords) . '">' . "\n";
    ?>
     <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <style>
        .des p {
            margin: 0px 0px !important;
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
                    <span class="b-active"><a href="../faculty/faculty.php?id=<?php echo $faculty_id ?>"><?php echo $faculty_name; ?></a> <i class='fa fa-angle-right'></i></span>
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
                        <!-- Faculty about  -->
                        <section class="des">
                            <h3 class="title gradText">About <?php echo $program_name.' ('.$level_name .')'; ?></h3>
                            <hr>
                            <p style="margin: 0px 0px;"><?php echo htmlspecialchars_decode($program_description) ?></p>

                        </section>

                        <!--  <section class="video-content">
                            <h3 class="title gradText">Video About Department</h3>
                            <hr>
                            <div class="video">
                                <iframe width="100%" height="315" src="https://www.youtube.com/embed/ZGO5Q8H3pwQ"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                        </section>


                        <section class="links-card">
                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                            <hr>
                            <div class="cards-container">
                                <div class="card">
                                    <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                    <p>Admission Process</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-book"></i>
                                    <p>Brochure</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-question"></i>
                                    <p>FAQ</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-building"></i>
                                    <p>Hostel Facility</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-street-view"></i>
                                    <p>360 tour link</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-link"></i>
                                    <p>Apply Online</p>
                                </div>
                            </div>
                        </section>

                        <section class="links-card" style="margin-bottom : 35px"> 
                        <h3 class="title gradText">UNIQUE FEATURES OF OUR DEPARTMENT</h3>
                        <hr>
                        <div class="cards-container">
                            <div class="card">
                                <i class="fa fa-flask"></i>
                                <p>Advance Laboratories</p>
                            </div>
                            <div class="card">
                                <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px"
                                    class="center">
                                <p>Excellent Academic System</p>
                            </div>
                            <div class="card">
                                <i class="fa fa-flask"></i>
                                <p>SDP</p>
                            </div>
                            <div class="card">
                                <i class="fa fa-flask"></i>
                                <p>National/lnternational Association</p>
                            </div>
                        </div>
                        </section>-->

                        <!-- why study at gmiu -->
                        <section>
                            <h3 class="title gradText">WHY STUDY AT GMIU?</h3>
                            <hr>
                            <div class="courses-cards">

                                <div class="wel-text-box">
                                    <div class="wel-icon">
                                        <i class="fa-solid fa-user-graduate fa-gmiu"></i>
                                    </div>
                                    <div class="wel-text">
                                        <h3>HIGHEST PLACEMENT</h3>
                                        <p>Placement process GMIU is robust and transparent process which ensures that
                                            all student got equal chance in any placement drive according to their
                                            eligibility and skills expertise which match est with recruiters.</p>
                                    </div>
                                </div>
                                <div class="wel-text-box">
                                    <div class="wel-icon">
                                        <i class="fa-sharp fa-solid fa-arrow-up-right-dots fa-gmiu"></i>
                                    </div>
                                    <div class="wel-text">
                                        <h3>SUPPORT TO START UP</h3>
                                        <p>A startup or start-up is a company or project undertaken by an entrepreneur
                                            to seek, develop, and validate a scalable business model. While
                                            entrepreneurship refers to all new businesses, including self-employment...
                                        </p>
                                    </div>
                                </div>
                                <div class="wel-text-box">
                                    <div class="wel-icon">
                                        <i class="fa-solid fa-graduation-cap fa-gmiu"></i>
                                    </div>
                                    <div class="wel-text">
                                        <h3>EXCELLENT ACADEMIC SYSTEM</h3>
                                        <p>providing excellent teaching learning process by highly qualified faculties.
                                            GMIU is known for the outstanding calibre of its students, well qualified
                                            faculty dedicated to teaching and research and excellent infrastructure.</p>
                                    </div>
                                </div>
                                <div class="wel-text-box">
                                    <div class="wel-icon">
                                        <i class="fa-solid fa-lightbulb fa-gmiu"></i>
                                    </div>
                                    <div class="wel-text">
                                        <h3>RESEARCH & INNOVATION (R&I)</h3>
                                        <p>Research and innovation (R&I) plays an essential role in triggering smart and
                                            sustainable growth and job creation. Research is an intrinsic aspect of the
                                            idea development process. Research helps guide numerous decisions that turn
                                            an idea into an innovation.</p>
                                    </div>
                                </div>

                            </div>
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