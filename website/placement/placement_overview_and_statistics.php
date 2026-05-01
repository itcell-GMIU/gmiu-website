<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Placement Overview and Statistics | Gyanmanjari University";
    $meta_description = "Explore GMIU's placement overview—see stats, top recruiters, and career opportunities that highlight student success after graduation.";
    ?>

    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">

    <!-- link of css is only for this page  -->
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/placement_overview_and_statistics.css">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

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
                    <h1>Placement Overview And Statistics</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Placement Overview And Statistics</a></span>
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
                        <section>
                            <!-- Swiper -->
                            <div class="swiper mySwiper">
                                <div class="swiper-wrapper">
                                    <?php
                                    $selected_images = [3, 4, 8, 15, 9];
                                    foreach ($selected_images as $i) {
                                        echo '
                                            <div class="swiper-slide">
                                                <div class="card-std text-center">
                                                    <img src="https://www.gmiu.edu.in/gmiu/website_assets/images/associates/p' . $i . '.jpg" 
                                                        alt="Placed Student ' . $i . '" class="img-fluid">
                                                </div>
                                            </div>';
                                    }
                                    ?>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>


                        </section>
                        <section class="table-card-placement">
                            <div class="red-background">
                                <h3 class="title gradText">Click Branch Name To See Detailed Placement</h3>
                            </div>

                            <div class="curriculum-text-box" style="margin-top: 10px; margin-bottom: 50px;">
                                <div class="curriculum-section">

                                    <?php
                                    // Fetch data
                                    $query = "SELECT program.id AS program_id,program.name AS program_name,program.intake AS program_intake,program.duration AS program_duration,
                                            program.program_slug AS program_slug,LEVEL.name AS level_name,faculty.name AS faculty_name, faculty.faculty_slug FROM tbl_program AS program JOIN tbl_level AS LEVEL
                                            ON program.level_id = LEVEL.id JOIN tbl_faculty AS faculty ON program.faculty_id = faculty.id WHERE program.faculty_id IN(SELECT faculty.id AS faculty_id
                                            FROM tbl_faculty AS faculty WHERE is_active = 1 AND is_delete = 0 AND EXISTS(SELECT 1 FROM tbl_program program INNER JOIN tbl_placement p ON 
                                            FIND_IN_SET(program.id, p.program_id) WHERE program.faculty_id = faculty.id AND p.is_active = 1 AND p.is_delete = 0)) AND program.level_id IN(SELECT LEVEL.id AS level_id
                                            FROM tbl_level AS LEVEL WHERE EXISTS(SELECT 1 FROM tbl_program program INNER JOIN tbl_placement p ON FIND_IN_SET(program.id, p.program_id) WHERE program.level_id = LEVEL.id 
                                            AND program.faculty_id IN(SELECT faculty.id AS faculty_id FROM tbl_faculty AS faculty WHERE is_active = 1 AND is_delete = 0 AND EXISTS(SELECT 1 FROM 
                                            tbl_program program INNER JOIN tbl_placement p ON FIND_IN_SET(program.id, p.program_id) WHERE program.faculty_id = faculty.id AND p.is_active = 1 AND p.is_delete = 0
                                            ) ) AND program.is_active = 1 AND program.is_delete = 0 AND p.is_active = 1 AND p.is_delete = 0 ) ORDER BY LEVEL.id ) AND program.is_active = 1 
                                            AND program.is_delete = 0 AND EXISTS(SELECT 1 FROM tbl_placement p WHERE p.is_active = 1 AND p.is_delete = 0 AND FIND_IN_SET(program.id, p.program_id) AND 
                                            p.faculty_id = program.faculty_id) ORDER BY program.faculty_id ASC";
                                    $result = mysqli_query($con, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        $flag = true;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($flag) {
                                                $color = "white";
                                            } else {
                                                $color = "rgba(186, 42, 33, .1)";
                                            }
                                            ?>
                                            <a href="<?php echo $base_url_website_faculty; ?><?php echo $row['faculty_slug']; ?>/<?php echo $row['program_slug']; ?>/placement"
                                                style="text-decoration:none; color:inherit; display:block; width:100%;">

                                                <div style="width:100%;
                                                            background: <?php echo isset($color) ? $color : '#e0f7fa'; ?>;
                                                            
                                                            overflow:hidden;
                                                            transition: all 0.3s ease;
                                                            background-color: <?php echo $color; ?>">

                                                    <div style="padding:12px 24px;
                                                                text-align:center;">
                                                        <h3 class="course-name">
                                                            <?php echo $row['program_name']; ?>
                                                            (<?php echo $row['level_name']; ?>)
                                                        </h3>
                                                    </div>

                                                </div>
                                            </a>

                                            <?php
                                            $flag = !($flag);
                                        }
                                    } else {
                                        echo '<p class="text-muted">No sections found.</p>';
                                    }

                                    // Close connection
                                    mysqli_close($con);
                                    ?>

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
                                        <li>
                                            PLACEMENT
                                        </li>
                                        <li><a href="training_and_placement_cell.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i>
                                                Training and Placement Cell</a></li>
                                        <li><a href="placement_overview_and_statistics.php" class="active"><i
                                                    class="fa-solid fa-arrow-right"></i> Placement Overview &
                                                Statistics</a></li>
                                        <li><a href="geps.php" class=""><i class="fa-solid fa-arrow-right"></i>GMIU
                                                Employability Performance Scale</a></li>

                                        <li><a href="student_testimonial.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Student Testimonial</a></li>

                                        <li><a href="corporate_testimonial.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Corporate
                                                Testimonial</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>


    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 30,
            autoplay: {
                delay: 3000,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                0: {
                    slidesPerView: 1
                },
                576: {
                    slidesPerView: 2
                },
                992: {
                    slidesPerView: 3
                }
            }
        });
    </script>

</body>

</html>