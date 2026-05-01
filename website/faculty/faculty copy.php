<?php
include '../../common/importwebsitefile.php';

if (isset($_GET['faculty_slug']) && !empty($_GET['faculty_slug'])) {
    $faculty_slug = mysqli_real_escape_string($con, $_GET['faculty_slug']);
    $faculty_slug = validate_data($faculty_slug);



    //  fetch faculty details
    $cmd = $con->prepare("SELECT faculty.id as faculty_id, faculty.description as faculty_description, faculty.name as faculty_name from tbl_faculty as faculty WHERE faculty.faculty_slug=? AND faculty.is_active=1 AND faculty.is_delete=0");
    $cmd->bind_param("s", $faculty_slug);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $faculty_id = $row['faculty_id'];
        $faculty_name = $row['faculty_name'];
        $faculty_description = $row['faculty_description'];
    } else {
        $faculty_id = "";
        $faculty_name = "";
        $faculty_description = "";
    }
} else {
    $faculty_id = "";
    $faculty_name = "";
    $faculty_description = "";
}
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/font-awesome.css">
    <style>
        .duration-intake p {
            color: #333333;
            margin-top: 4px;
            display: flex;
            justify-content: space-between;
            flex-wrap: nowrap;
        }
    </style>
</head>

<body class="courses">
    <!--  Preloader -->
    <!--  <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> -->
    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>
                        <?php echo $faculty_name; ?>
                    </h1>
                </div>
                <p style="margin-top:5px;"><span><a href="#" style="color:#727272">Home <i class='fa fa-angle-right'></i></a></span> <span class="b-active">
                        <?php echo $faculty_name ?>
                    </span></p>
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
                            <h3 class="title gradText">ABOUT FACULTY</h3>
                            <hr>
                            <p>
                                <?php echo htmlspecialchars_decode($faculty_description) ?>
                            </p>
                        </section>
                        <!-- apply now box -->
                        <section class="trausted-stu-area">
                            <!-- <div class="container"> -->
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="trausted-content">
                                        <div class="row border-box-admission">
                                            <div class="col-sm-12 col-md-9">
                                                <h3 class="title gradText" style="font-size : 17px;">ADMISSION 2024-25
                                                </h3>
                                                <hr>
                                                <h3 class="section-h-medium">For admission regarding query:</h3>
                                                <p><i class="fa-solid fa-phone"></i> <span class="mobile-number"> +91
                                                        90999 51160, </span><span class="mobile-number"> +91 75749
                                                        49494</span> </p>
                                            </div>

                                            <div class="col-sm-12 col-md-3">
                                                <div class="trausted-stu-btn">
                                                    <a href="<?php echo $base_url_admission; ?>" class="">Apply Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- </div> -->
                        </section>

                        <!-- cource-1 cards  -->
                        <?php
                        /*  $query="SELECT program.level_id,level.name as level_name from tbl_program as program
                                LEFT JOIN tbl_level level ON program.level_id = level.id
                                WHERE program.faculty_id=? AND program.is_active=1 AND program.is_delete=0 GROUP BY level_id ORDER BY level_id";
                                $cmd = $con->prepare($query);
                                $cmd->bind_param("i",$faculty_id);
                                $cmd->execute();
                                $result = $cmd->get_result();
                                $cmd->store_result();
                                $cmd->close(); */

                        /*    if ($result->num_rows != 0) {
                                    while ($row = $result->fetch_assoc()) {
                                
                                    $level_name=$row['level_name'];
                                    $level_id=$row['level_id']; */
                        $query = "SELECT program.level_id,level.name as level_name from tbl_program as program
                                    LEFT JOIN tbl_level level ON program.level_id = level.id
                                    WHERE program.faculty_id=$faculty_id AND program.is_active=1 AND program.is_delete=0 GROUP BY program.level_id ORDER BY FIELD(program.level_id,5,7,3,1,2,8,4,6,9,10,12,13,14)";
                        $result = mysqli_query($con, $query);

                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                                $level_name = $row['level_name'];
                                $level_id = $row['level_id'];
                         //       $brochure = $row['brochure'];


                                $query22 = "SELECT `id`, `faculty_id`, `level_id`, `document` FROM `tbl_faculty_brochure` WHERE faculty_id = $faculty_id AND level_id = $level_id";
                                $result22 = mysqli_query($con, $query22);

                                if (mysqli_num_rows($result22) > 0) {
                                    // output data of each row
                                    while ($row22 = mysqli_fetch_assoc($result22)) {
                                        $brochure = $row22['document'];
                                    }
                                }



                        ?>
                                <section class="two-column-cards">
                                    <h3 class="title gradText">
                                        <?php echo $level_name; ?>
                                    </h3>
                                    <hr>

                                    <div class="courses-cards">
                                        <?php
                                        /*  $query1="SELECT program.name as program_name from tbl_program as program
                                WHERE program.faculty_id=? AND program.is_active=1 AND program.is_delete=0";
                                $cmd1 = $con->prepare($query1);
                                $cmd1->bind_param("i",$faculty_id);
                                $cmd1->execute();
                                $cmd1->store_result();
                                $cmd1->close();
                                $result1 = $cmd->get_result();
                                if ($result1->num_rows != 0) {
                                    while ($row1 = $result->fetch_assoc()) { */
                                        $query1 = "SELECT program.id as program_id,program.name as program_name,program.intake as program_intake,program.regular as regular,program.duration as program_duration from tbl_program as program 
                                WHERE program.faculty_id=$faculty_id AND program.level_id = $level_id AND program.is_active=1 AND program.is_delete=0";
                                        $result1 = mysqli_query($con, $query1);
                                        if (mysqli_num_rows($result1) > 0) {
                                            // output data of each row
                                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                                $program_name = $row1['program_name'];
                                                $program_id = $row1['program_id'];
                                                $regfees = $row1['regular'];
                                                $regyear = $row1['program_duration'];
                                                $program_intake = $row1['program_intake'];
                                                $program_duration = $row1['program_duration'];
                                                if ($faculty_id == 16) {
                                                    $fees = $regfees;
                                                } else {
                                                    $fees = $regfees / 2;
                                                }
                                        ?>
                                                <div class="card-for-course">
                                                    <a>
                                                        <?php
                                                        if ($level_id == 9 || $level_id == 10 || $level_id == 11 || $level_id == 12) {
                                                        ?>
                                                            <a href="#">
                                                            <?php
                                                        } else {
                                                            ?>
                                                                <a href="<?php echo $base_url_website_program; ?>program.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>">
                                                                <?php
                                                            }
                                                                ?>
                                                                <h3 class="course-name" style="word-break: auto-phrase;">
                                                                    <?php echo $program_name; ?>
                                                                </h3>
                                                                <div class="duration-intake">
                                                                    <p>Duration: <b>
                                                                            <?php echo $program_duration; ?> <?php
                                                                                                                if ($faculty_id == 22 || $faculty_id == 16) {
                                                                                                                    echo '';
                                                                                                                } else {
                                                                                                                    echo 'Years';
                                                                                                                }
                                                                                                                ?>
                                                                        </b> </p>
                                                                    <p>Intake: <b>
                                                                            <?php echo $program_intake; ?>
                                                                        </b> </p>
                                                                    <?php if ($level_id == 5 &&  $faculty_id == 1) {
                                                                    ?>
                                                                        <p>Fees: <b>
                                                                            <?php
                                                                        } elseif ($level_id == 2 &&  $faculty_id == 8) {
                                                                            ?>
                                                                                <p>Fees: <b>
                                                                                    <?php
                                                                                } elseif ($faculty_id == 2) {
                                                                                    ?>
                                                                                        <p>Fees: <b>
                                                                                            <?php
                                                                                        } elseif ($level_id == 2 &&  $faculty_id == 5) {
                                                                                            ?>
                                                                                                <p>Fees: <b>
                                                                                                    <?php
                                                                                                } elseif ($faculty_id == 22 || $faculty_id == 16) {
                                                                                                    ?>
                                                                                                        <p>Fees: &nbsp;<b>
                                                                                                            <?php
                                                                                                        } else {
                                                                                                            ?>
                                                                                                                <p>Semester Fees: <b>
                                                                                                                    <?php
                                                                                                                }
                                                                                                                    ?>
                                                                                                                    <?php
                                                                                                                    if ($faculty_id == 22) {
                                                                                                                        echo ' As Per Course';
                                                                                                                    } else {
                                                                                                                        echo $fees;
                                                                                                                    } ?>
                                                                                                                    </b> </p>
                                                                </div>
                                                                </a>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </section>
                                <?php if ($level_id == 5 &&  $faculty_id == 1) {
                                ?>
                                    <div class="">
                                        <p>*Semester Fees As Per FRC.</p>
                                    </div>
                                <?php
                                } elseif ($level_id == 2 &&  $faculty_id == 8) {
                                ?>
                                    <div class="">
                                        <p>*Semester Fees As Per FRC.</p>
                                    </div>
                                <?php
                                } elseif ($faculty_id == 2) {
                                ?>
                                    <div class="">
                                        <p>*Semester Fees As Per FRC.</p>
                                    </div>
                                <?php
                                } elseif ($level_id == 2 &&  $faculty_id == 5) {
                                ?>
                                    <div class="">
                                        <p>*Semester Fees As Per FRC.</p>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if ($faculty_id == 1 && $level_id == 1) {
                                    //engineering and ug
                                    echo '<section class="video-content">
                                    <h3 class="title gradText">Video About Department</h3>
                                    <hr>
                                    <div class="video">
                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/Q09uiWcpCOQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
                                </section>
                                <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                                <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF ENGINEERING/B.Tech/B.Tech FAQ.pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 1 && $level_id == 2) {
                                    //engineering and pg  
                                    echo '<section class="video-content">
                                                    <h3 class="title gradText">Video About Department</h3>
                                                    <hr>
                                                    <div class="video">
                                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/dPLM06J425w"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    </div>
                                            </section>
                                            <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                    <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                    <div class="card">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                        <p>Admission Process</p>
                                    </div>
                                </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                            <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="#">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 1 && $level_id == 5) {
                                    echo '<section class="video-content">
                                                    <h3 class="title gradText">Video About Department</h3>
                                                    <hr>
                                                    <div class="video">
                                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/qRtYABFKjxk"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    </div>
                                            </section>
                                            <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                            <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                            <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF ENGINEERING/DIPLOMA ENGG/FAQ OF Diploma Engg.pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 2 && $level_id == 1) {
                                    echo '<section class="video-content">
                                                    <h3 class="title gradText">Video About Department</h3>
                                                    <hr>
                                                    <div class="video">
                                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/AaCo62xqJ54"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    </div>
                                            </section>
                                            <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                            <i class="fa-solid fa-graduation-cap"></i>

                                                <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF PHARMACY/FAQ OF PHARMACY E_G FINAL.pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 3 && $level_id == 1) {
                                    echo '<section class="video-content">
                                                    <h3 class="title gradText">Video About Department</h3>
                                                    <hr>
                                                    <div class="video">
                                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/YZTIEV403OA"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    </div>
                                            </section>
                                            <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                       <i class="fa-solid fa-graduation-cap"></i>
                                            <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FECULTY OF SCIENCE/B.Sc/FAQ OF B.Sc.pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 3 && $level_id == 2) {
                                    echo '<section class="video-content">
                                                    <h3 class="title gradText">Video About Department</h3>
                                                    <hr>
                                                    <div class="video">
                                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/p7esgc9Rz8o"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    </div>
                                            </section>
                                            <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                            <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FECULTY OF SCIENCE/M.Sc/_FAQ OF M.Sc.pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 4 && $level_id == 1) {
                                    echo '<section class="video-content">
                                                    <h3 class="title gradText">Video About Department</h3>
                                                    <hr>
                                                    <div class="video">
                                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/oRDg6WDFgrM"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    </div>
                                            </section>
                                            <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                            <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF COMMERCE/B.Com/FAQ OF B.COM.pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 4 && $level_id == 2) {
                                    echo '<section class="video-content">
                                                    <h3 class="title gradText">Video About Department</h3>
                                                    <hr>
                                                    <div class="video">
                                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/kznjdUAuxJA"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    </div>
                                            </section>
                                            <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                            <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF COMMERCE/M.Com/M.Com(1).pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 5 && $level_id == 1) {
                                    echo '<section class="video-content">
                                <h3 class="title gradText">Video About Department</h3>
                                <hr>
                                <div class="video">
                                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/5ZJpU_whx1k"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen></iframe>
                                </div>
                                </section>
                                <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                            <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF MANAGEMENT/BBA/FAQ BBA.pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 5 && $level_id == 2) {
                                    echo '<section class="video-content">
                            <h3 class="title gradText">Video About Department</h3>
                            <hr>
                            <div class="video">
                                <iframe width="100%" height="315" src="https://www.youtube.com/embed/e6LuIGooOCA"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                            </section>
                            <section class="links-card">
                                <h3 class="title gradText">IMPORTANT LINKS</h3>
                                <hr>
                                <div class="cards-container">
                                    <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                        <div class="card">
                                            <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                            <p>Admission Process</p>
                                        </div>
                                    </a>
                                    <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF MANAGEMENT/MBA/MBA.pdf">
                                        <div class="card">
                                            <i class="fa fa-book"></i>
                                            <p>Brochure</p>
                                        </div>
                                    </a>
                                    <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF MANAGEMENT/MBA/faq MBA.pdf">
                                        <div class="card">
                                            <i class="fa fa-question"></i>
                                            <p>FAQ</p>
                                        </div>
                                    </a>
                                    <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                        <div class="card">
                                            <i class="fa fa-building"></i>
                                            <p>Hostel Facility</p>
                                        </div>
                                    </a>
                                    <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                        <div class="card">
                                            <i class="fa fa-street-view"></i>
                                            <p>360 tour link</p>
                                        </div>
                                    </a>
                                    <a target="_blank" href="' . $base_url_admission . '">
                                        <div class="card">
                                            <i class="fa fa-link"></i>
                                            <p>Apply Online</p>
                                        </div>
                                    </a>
                                </div>
                            </section>';
                                } else if ($faculty_id == 6 && $level_id == 1) {
                                    echo '<section class="video-content">
                        <h3 class="title gradText">Video About Department</h3>
                        <hr>
                        <div class="video">
                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/a2roJ1ze3pE"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                        </section>
                        <section class="links-card">
                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                            <hr>
                            <div class="cards-container">
                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                    <div class="card">
                                        <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                        <p>Admission Process</p>
                                    </div>
                                </a>
                                <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                    <div class="card">
                                        <i class="fa fa-book"></i>
                                        <p>Brochure</p>
                                    </div>
                                </a>
                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF ARTS/B.A/FAQ B.A.pdf">
                                    <div class="card">
                                        <i class="fa fa-question"></i>
                                        <p>FAQ</p>
                                    </div>
                                </a>
                                <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                    <div class="card">
                                        <i class="fa fa-building"></i>
                                        <p>Hostel Facility</p>
                                    </div>
                                </a>
                                <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                    <div class="card">
                                        <i class="fa fa-street-view"></i>
                                        <p>360 tour link</p>
                                    </div>
                                </a>
                                <a target="_blank" href="' . $base_url_admission . '">
                                    <div class="card">
                                        <i class="fa fa-link"></i>
                                        <p>Apply Online</p>
                                    </div>
                                </a>
                            </div>
                        </section>';
                                } else if ($faculty_id == 6 && $level_id == 2) {
                                    echo '<section class="video-content">
                    <h3 class="title gradText">Video About Department</h3>
                    <hr>
                    <div class="video">
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/Y1esXwLElpU"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                    </div>
                    </section>
                    <section class="links-card">
                        <h3 class="title gradText">IMPORTANT LINKS</h3>
                        <hr>
                        <div class="cards-container">
                            <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                <div class="card">
                                    <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                    <p>Admission Process</p>
                                </div>
                            </a>
                            <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                <div class="card">
                                    <i class="fa fa-book"></i>
                                    <p>Brochure</p>
                                </div>
                            </a>
                            <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF ARTS/M.A/FAQM.A.2.pdf">
                                <div class="card">
                                    <i class="fa fa-question"></i>
                                    <p>FAQ</p>
                                </div>
                            </a>
                            <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                <div class="card">
                                    <i class="fa fa-building"></i>
                                    <p>Hostel Facility</p>
                                </div>
                            </a>
                            <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                <div class="card">
                                    <i class="fa fa-street-view"></i>
                                    <p>360 tour link</p>
                                </div>
                            </a>
                            <a target="_blank" href="' . $base_url_admission . '">
                                <div class="card">
                                    <i class="fa fa-link"></i>
                                    <p>Apply Online</p>
                                </div>
                            </a>
                        </div>
                    </section>';
                                } else if ($faculty_id == 8 && $level_id == 1) {
                                    echo '<section class="video-content">
                <h3 class="title gradText">Video About Department</h3>
                <hr>
                <div class="video">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/cuMltdXFDJU"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
                </section>
                <section class="links-card">
                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                    <hr>
                    <div class="cards-container">
                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                            <div class="card">
                                <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                <p>Admission Process</p>
                            </div>
                        </a>
                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                            <div class="card">
                                <i class="fa fa-book"></i>
                                <p>Brochure</p>
                            </div>
                        </a>
                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF COMPUTER SCIENCE/BCA/BCA FAQs.pdf">
                            <div class="card">
                                <i class="fa fa-question"></i>
                                <p>FAQ</p>
                            </div>
                        </a>
                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                            <div class="card">
                                <i class="fa fa-building"></i>
                                <p>Hostel Facility</p>
                            </div>
                        </a>
                        <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                            <div class="card">
                                <i class="fa fa-street-view"></i>
                                <p>360 tour link</p>
                            </div>
                        </a>
                        <a target="_blank" href="' . $base_url_admission . '">
                            <div class="card">
                                <i class="fa fa-link"></i>
                                <p>Apply Online</p>
                            </div>
                        </a>
                    </div>
                </section>';
                                } else if ($faculty_id == 8 && $level_id == 2) {
                                    echo '<section class="video-content">
                                        <h3 class="title gradText">Video About Department</h3>
                                        <hr>
                                        <div class="video">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/EQAOP5e82Zk"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen></iframe>
                                        </div>
                                        </section>
                                        <section class="links-card">
                                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                                            <hr>
                                            <div class="cards-container">
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                                    <div class="card">
                                                        <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                                        <p>Admission Process</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                                    <div class="card">
                                                        <i class="fa fa-book"></i>
                                                        <p>Brochure</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF COMPUTER SCIENCE/MCA/MCA FAQs (1).pdf">
                                                    <div class="card">
                                                        <i class="fa fa-question"></i>
                                                        <p>FAQ</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                                    <div class="card">
                                                        <i class="fa fa-building"></i>
                                                        <p>Hostel Facility</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                                    <div class="card">
                                                        <i class="fa fa-street-view"></i>
                                                        <p>360 tour link</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_admission . '">
                                                    <div class="card">
                                                        <i class="fa fa-link"></i>
                                                        <p>Apply Online</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </section>';
                                } else if ($faculty_id == 9 && $level_id == 1) {
                                    echo '<section class="video-content">
                                            <h3 class="title gradText">Video About Department</h3>
                                            <hr>
                                            <div class="video">
                                                <iframe width="100%" height="315" src="https://www.youtube.com/embed/xruEuQcOc1M"
                                                    title="YouTube video player" frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen></iframe>
                                            </div>
                                            </section>
                                            <section class="links-card">
                                                <h3 class="title gradText">IMPORTANT LINKS</h3>
                                                <hr>
                                                <div class="cards-container">
                                                    <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                                        <div class="card">
                                                            <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                                            <p>Admission Process</p>
                                                        </div>
                                                    </a>
                                                    <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                                        <div class="card">
                                                            <i class="fa fa-book"></i>
                                                            <p>Brochure</p>
                                                        </div>
                                                    </a>
                                                    <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF DESIGN/Bachelor in Design/FAQ- Bachelor Design & Home Science.pdf">
                                                        <div class="card">
                                                            <i class="fa fa-question"></i>
                                                            <p>FAQ</p>
                                                        </div>
                                                    </a>
                                                    <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                                        <div class="card">
                                                            <i class="fa fa-building"></i>
                                                            <p>Hostel Facility</p>
                                                        </div>
                                                    </a>
                                                    <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                                        <div class="card">
                                                            <i class="fa fa-street-view"></i>
                                                            <p>360 tour link</p>
                                                        </div>
                                                    </a>
                                                    <a target="_blank" href="' . $base_url_admission . '">
                                                        <div class="card">
                                                            <i class="fa fa-link"></i>
                                                            <p>Apply Online</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </section>';
                                } else if ($faculty_id == 9 && $level_id == 2) {
                                    echo '<section class="video-content">
                                        <h3 class="title gradText">Video About Department</h3>
                                        <hr>
                                        <div class="video">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/zL3VgR1A6_c"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen></iframe>
                                        </div>
                                        </section>
                                        <section class="links-card">
                                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                                            <hr>
                                            <div class="cards-container">
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                                    <div class="card">
                                                        <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                                        <p>Admission Process</p>
                                                    </div>
                                                </a>
   
                                                <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                                    <div class="card">
                                                        <i class="fa fa-book"></i>
                                                        <p>Brochure</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF DESIGN/Master in Design/FAQ- PG- Master Home Science.pdf">
                                                    <div class="card">
                                                        <i class="fa fa-question"></i>
                                                        <p>FAQ</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                                    <div class="card">
                                                        <i class="fa fa-building"></i>
                                                        <p>Hostel Facility</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                                    <div class="card">
                                                        <i class="fa fa-street-view"></i>
                                                        <p>360 tour link</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_admission . '">
                                                    <div class="card">
                                                        <i class="fa fa-link"></i>
                                                        <p>Apply Online</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </section>';
                                } else if ($faculty_id == 9 && $level_id == 5) {
                                    echo '<section class="video-content">
                                        <h3 class="title gradText">Video About Department</h3>
                                        <hr>
                                        <div class="video">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/0iCczYv_zcI"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen></iframe>
                                        </div>
                                        </section>
                                        <section class="links-card">
                                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                                            <hr>
                                            <div class="cards-container">
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                                    <div class="card">
                                                        <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                                        <p>Admission Process</p>
                                                    </div>
                                                </a>
   
                                                <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                                    <div class="card">
                                                        <i class="fa fa-book"></i>
                                                        <p>Brochure</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF DESIGN/Diploma in Design/FAQ- Diploma Faculty of Design.pdf">
                                                    <div class="card">
                                                        <i class="fa fa-question"></i>
                                                        <p>FAQ</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                                    <div class="card">
                                                        <i class="fa fa-building"></i>
                                                        <p>Hostel Facility</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                                    <div class="card">
                                                        <i class="fa fa-street-view"></i>
                                                        <p>360 tour link</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_admission . '">
                                                    <div class="card">
                                                        <i class="fa fa-link"></i>
                                                        <p>Apply Online</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </section>';
                                } else if ($faculty_id == 10 && $level_id == 1) {
                                    echo '<section class="video-content">
                                    <h3 class="title gradText">Video About Department</h3>
                                    <hr>
                                    <div class="video">
                                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/f1U4A7HUe5o"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen></iframe>
                                    </div>
                                    </section>
                                    <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                                <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                                <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '"><a target="_blank" href="' . $website_assets_url . 'gmiu_doc/MEDICAL SCIENCE _ HEALTH CARE/(MS_HC)
                                            <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="#">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                    </section>';
                                } else if ($faculty_id == 11) {
                                    echo '<section class="video-content">
                                            <h3 class="title gradText">Video About Department</h3>
                                            <hr>
                                            <div class="video">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/f1U4A7HUe5o"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen></iframe>
                                            </div>
                                            </section>
                                            <section class="links-card">
                                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                                            <hr>
                                            <div class="cards-container">
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                                    <div class="card">
                                                        <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                                        <p>Admission Process</p>
                                                    </div>
                                                </a>
   
                                                <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                                    <div class="card">
                                                        <i class="fa fa-book"></i>
                                                        <p>Brochure</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/MEDICAL SCIENCE _ HEALTH CARE/FAQS Of Medical Science 2024-2025.pdf">
                                                    <div class="card">
                                                        <i class="fa fa-question"></i>
                                                        <p>FAQ</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                                    <div class="card">
                                                        <i class="fa fa-building"></i>
                                                        <p>Hostel Facility</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                                    <div class="card">
                                                        <i class="fa fa-street-view"></i>
                                                        <p>360 tour link</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_admission . '">
                                                    <div class="card">
                                                        <i class="fa fa-link"></i>
                                                        <p>Apply Online</p>
                                                    </div>
                                                </a>
                                            </div>
                                            </section>';
                                } else if ($faculty_id == 12 && $level_id == 1) {
                                    echo '<section class="video-content">
                                        <h3 class="title gradText">Video About Department</h3>
                                        <hr>
                                        <div class="video">
                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/x5LHZ9Fhkc8"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen></iframe>
                                        </div>
                                        </section>
                                        <section class="links-card">
                                        <h3 class="title gradText">IMPORTANT LINKS</h3>
                                        <hr>
                                        <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                        <div class="card">
                                        <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                        <p>Admission Process</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                        <i class="fa fa-book"></i>
                                        <p>Brochure</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/SOCIAL WORK/BSW/BSW FAQ .pdf">
                                        <div class="card">
                                        <i class="fa fa-question"></i>
                                        <p>FAQ</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                        <div class="card">
                                        <i class="fa fa-building"></i>
                                        <p>Hostel Facility</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                        <div class="card">
                                        <i class="fa fa-street-view"></i>
                                        <p>360 tour link</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                        <div class="card">
                                        <i class="fa fa-link"></i>
                                        <p>Apply Online</p>
                                        </div>
                                        </a>
                                        </div>
                                        </section>';
                                } else if ($faculty_id == 12 && $level_id == 2) {
                                    echo '<section class="video-content">
                                        <h3 class="title gradText">Video About Department</h3>
                                        <hr>
                                        <div class="video">
                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/jzq7QoGiXDI"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen></iframe>
                                        </div>
                                        </section>
                                        <section class="links-card">
                                        <h3 class="title gradText">IMPORTANT LINKS</h3>
                                        <hr>
                                        <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                        <div class="card">
                                        <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                        <p>Admission Process</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                        <i class="fa fa-book"></i>
                                        <p>Brochure</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/SOCIAL WORK/MSW/FAQ MSW final for online.pdf">
                                        <div class="card">
                                        <i class="fa fa-question"></i>
                                        <p>FAQ</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                        <div class="card">
                                        <i class="fa fa-building"></i>
                                        <p>Hostel Facility</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                        <div class="card">
                                        <i class="fa fa-street-view"></i>
                                        <p>360 tour link</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                        <div class="card">
                                        <i class="fa fa-link"></i>
                                        <p>Apply Online</p>
                                        </div>
                                        </a>
                                        </div>
                                        </section>';
                                } else if ($faculty_id == 15 && $level_id == 1) {
                                    echo '<section class="video-content">
                                            <h3 class="title gradText">Video About Department</h3>
                                            <hr>
                                            <div class="video">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/5ZJpU_whx1k"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>
                                            </div>
                                            </section>
                                            <section class="links-card">
                                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                                            <hr>
                                            <div class="cards-container">
                                            <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                            <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                            <p>Admission Process</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                            <div class="card">
                                            <i class="fa fa-book"></i>
                                            <p>Brochure</p>
                                            </div>
                                            </a>
                                            <a href="#" target="_blank" >
                                            <div class="card">
                                            <i class="fa fa-question"></i>
                                            <p>FAQ</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                            <i class="fa fa-building"></i>
                                            <p>Hostel Facility</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                            <div class="card">
                                            <i class="fa fa-street-view"></i>
                                            <p>360 tour link</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                            <i class="fa fa-link"></i>
                                            <p>Apply Online</p>
                                            </div>
                                            </a>
                                            </div>
                                            </section>';
                                } else if ($faculty_id == 15 && $level_id == 5) {
                                    echo '<section class="video-content">
                                            <h3 class="title gradText">Video About Department</h3>
                                            <hr>
                                            <div class="video">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/LyLBT3SaxDM"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>
                                            </div>
                                            </section>
                                            <section class="links-card">
                                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                                            <hr>
                                            <div class="cards-container">
                                            <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                            <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                            <p>Admission Process</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                            <div class="card">
                                            <i class="fa fa-book"></i>
                                            <p>Brochure</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF HOTEL MANAGEMENT/Bachelor of Hotel Managment/8. HM_FAQ.pdf">
                                            <div class="card">
                                            <i class="fa fa-question"></i>
                                            <p>FAQ</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                            <i class="fa fa-building"></i>
                                            <p>Hostel Facility</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                            <div class="card">
                                            <i class="fa fa-street-view"></i>
                                            <p>360 tour link</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                            <i class="fa fa-link"></i>
                                            <p>Apply Online</p>
                                            </div>
                                            </a>
                                            </div>
                                            </section>';
                                } else if ($faculty_id == 18) {
                                    echo '<section class="links-card">
                                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                                            <hr>
                                            <div class="cards-container">
                                            <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                            <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                            <p>Admission Process</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                            <div class="card">
                                            <i class="fa fa-book"></i>
                                            <p>Brochure</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="#">
                                            <div class="card">
                                            <i class="fa fa-question"></i>
                                            <p>FAQ</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                            <i class="fa fa-building"></i>
                                            <p>Hostel Facility</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="https://gmiu.edu.in/campus/virtualtour">
                                            <div class="card">
                                            <i class="fa fa-street-view"></i>
                                            <p>360 tour link</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                            <i class="fa fa-link"></i>
                                            <p>Apply Online</p>
                                            </div>
                                            </a>
                                            </div>
                                            </section>';
                                }
                                ?>
                        <?php
                            }
                        }
                        ?>
                        <!-- cource-2 cards  -->
                        <!-- WHY STUDY AT GMIU? section -->
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
                <div class="col-sm-4 sidebar-right">
                    <div class="sidebar-content">
                        <div class="sideBar">
                            <div class="sticky">
                                <div>
                                    <ul>
                                        <li>FACULTY</li>
                                        <?php
                                        $cmd = "SELECT `name` as faculty_name, faculty_slug, `id` as faculty_id FROM `tbl_faculty` WHERE is_active=1 AND is_delete=0";
                                        $stmt = $con->prepare($cmd);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <li><a href="<?php echo $base_url_website_faculty?><?php echo $row['faculty_slug']; ?>"><i class="fa-solid fa-arrow-right"></i>
                                                    <?php echo strtoupper($row['faculty_name']); ?>
                                                </a>
                                            </li>
                                        <?php
                                        }
                                        ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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