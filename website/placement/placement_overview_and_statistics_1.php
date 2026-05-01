<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Placement Overview and Statistics | Gyanmanjari University";
    include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">

    <!-- link of css is only for this page  -->
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/placement_overview_and_statistics.css">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
   <style>
    .placement-section {
        margin-top: 15px;
        padding-top: 10px;
        border-top: 1px solid #e1e1e1;
    }

    .year-buttons {
        margin-bottom: 15px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .year-btn {
        padding: 6px 12px;
        border: 1px solid #c0392b;
        background: #fff;
        color: #c0392b;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }

    .year-btn:hover,
    .year-btn.active-year {
        background: #c0392b;
        color: #fff;
    }

    .placement-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
    }

    .student-card {
        background: #fafafa;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 10px;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .student-card:hover {
        transform: scale(1.02);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
    }

    .student-img {
        width: 100%;
        height: 150px;
        object-fit: contain;
        border-radius: 4px;
    }

    .student-info {
        margin-top: 8px;
        font-size: 13px;
    }

    .company-logo {
        width: 80px;
        height: 40px;
        object-fit: contain;
        margin-top: 5px;
    }

    /* Swiper image height consistent */
    .card-std img {
        height: 180px;
        object-fit: contain;
    }
    .courses-cards{
      display: unset;   
    }
    /* Responsive text adjustments */
    @media (max-width: 768px) {
        .year-btn {
            font-size: 12px;
            padding: 5px 10px;
        }
        .student-img {
            height: 120px;
        }
        .company-logo {
            width: 60px;
            height: 30px;
        }
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
                    <h1>Training & Placement Cell</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Training & Placement Cell</a></span>
                </p>
                <hr>
            </div>

        </div>

    </section>

    <div class="single-courses-area">
        <div class="container">
            <div class="row two-colum-section">
                <!-- left bar start  -->
                <div class="col-sm-12 sidebar-left">
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

                            <div class="curriculum-text-box">
                                <div class="curriculum-section">
                                    <div class="panel-group" id="accordion">
                                        <!-- 2 --> <?php
                                                    // $cmd = $con->prepare("SELECT faculty.name as faculty_name ,faculty.id as faculty_id, faculty.faculty_slug as faculty_slug from tbl_faculty as faculty
                                                    //  WHERE is_active=1 AND is_delete=0");
                                                    // $cmd->execute();
                                                    // $result = $cmd->get_result();
                                                    // if ($result->num_rows != 0) {
                                                    //     $i = 1;
                                                    //     while ($row = $result->fetch_assoc()) {
                                                    //         $faculty_name = $row['faculty_name'];
                                                    //         $faculty_id = $row['faculty_id'];
                                                    //         $faculty_slug = $row['faculty_slug'];

                                                    $cmd = $con->prepare("
                                                            SELECT faculty.name as faculty_name, faculty.id as faculty_id, faculty.faculty_slug as faculty_slug 
                                                            FROM tbl_faculty as faculty 
                                                            WHERE is_active=1 AND is_delete=0 
                                                            AND EXISTS (
                                                                SELECT 1 FROM tbl_program program 
                                                                INNER JOIN tbl_placement p ON p.program_id = program.id 
                                                                WHERE program.faculty_id = faculty.id 
                                                                AND p.is_active=1 AND p.is_delete=0
                                                            )
                                                        ");
                                                    $cmd->execute();
                                                    $result = $cmd->get_result();
                                                    if ($result->num_rows != 0) {
                                                        $i = 1;
                                                        while ($row = $result->fetch_assoc()) {
                                                            $faculty_name = $row['faculty_name'];
                                                            $faculty_id = $row['faculty_id'];
                                                            $faculty_slug = $row['faculty_slug'];
                                                            $collapseId = 'faculty_'.$faculty_id.'_panel_'.$i;
                                                            
                                                    ?>
                                                 
                                                <div class="panel panel-default">
                                                    <div class="panel-heading <?php if (($i & 1) != 1) {
                                                                                    echo "if-even-bg";
                                                                                } ?>">
                                                        <h4 class="panel-title click">
                                                            
                                                           <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $collapseId; ?>" id="font-course" class="color-gmiu collapsed" 
                                                              aria-expanded="false">
                                                                <?php echo $faculty_name; ?>
                                                            </a>

                                                        </h4>
                                                    </div>
                                                    <div id="<?php echo $collapseId; ?>" class="panel-collapse out collapse" aria-expanded="false">
                                                        <div class="panel-body">
                                                            <?php
                                                            $query = "SELECT level.id as level_id, level.name as level_name 
                                                                        FROM tbl_level level 
                                                                        WHERE EXISTS (
                                                                            SELECT 1 FROM tbl_program program 
                                                                            INNER JOIN tbl_placement p ON p.program_id = program.id 
                                                                            WHERE program.level_id = level.id 
                                                                            AND program.faculty_id = $faculty_id 
                                                                            AND program.is_active = 1 AND program.is_delete = 0 
                                                                            AND p.is_active = 1 AND p.is_delete = 0
                                                                        )
                                                                        ORDER BY level.id";

                                                            $result1 = mysqli_query($con, $query);

                                                            if (mysqli_num_rows($result1) > 0) {
                                                                // output data of each row
                                                                while ($row1 = mysqli_fetch_assoc($result1)) {
                                                                    $level_name = $row1['level_name'];
                                                                    $level_id = $row1['level_id'];
                                                            ?>

                                                                    <section class="two-column-cards">
                                                                        <h3 class="title gradText-sub">
                                                                            <?php echo $level_name; ?> </h3>
                                                                        <hr>

                                                                        <div class="courses-cards">
                                                                            <?php

                                                                            $query2 = "SELECT program.id as program_id, program.name as program_name, program.intake as program_intake, 
                                                                                        program.duration as program_duration, program.program_slug as program_slug 
                                                                                        FROM tbl_program as program 
                                                                                        WHERE program.faculty_id = $faculty_id 
                                                                                        AND program.level_id = $level_id 
                                                                                        AND program.is_active = 1 
                                                                                        AND program.is_delete = 0 
                                                                                        AND EXISTS (
                                                                                        SELECT 1 FROM tbl_placement p 
                                                                                        WHERE p.is_active = 1 AND p.is_delete = 0 
                                                                                        AND p.program_id = program.id 
                                                                                        AND p.faculty_id = program.faculty_id
                                                                                    )";

                                                                            $result2 = mysqli_query($con, $query2);
                                                                            if (mysqli_num_rows($result2) > 0) {
                                                                                // output data of each row
                                                                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                                                                    $program_name = $row2['program_name'];
                                                                                    $program_id = $row2['program_id'];
                                                                                    $program_intake = $row2['program_intake'];
                                                                                    $program_duration = $row2['program_duration'];
                                                                                    $program_slug = $row2['program_slug'];
                                                                            ?>

                                                                                    <div class="card-for-course">
                                                                                        <a
                                                                                            href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/placement">
                                                                                            <h3 class="course-name">
                                                                                                <?php echo $program_name; ?> </h3>

                                                                                            <div class="duration-intake">
                                                                                                <p>Duration: <b>
                                                                                                        <?php echo $program_duration; ?> Years
                                                                                                    </b> </p>
                                                                                                <p>Intake: <b>
                                                                                                        <?php echo $program_intake; ?>
                                                                                                    </b> </p>
                                                                                            </div>
                                                                                        </a>
                                                                                        <?php
                                                                                        // STEP 1: Get available placement years for this program
                                                                                        $yearStmt = $con->prepare("
                                                                                            SELECT year FROM tbl_placement 
                                                                                            WHERE program_id = ? AND faculty_id = ? AND is_active = 1 AND is_delete = 0 
                                                                                            GROUP BY year ORDER BY year DESC
                                                                                        ");
                                                                                        $yearStmt->bind_param("ii", $program_id, $faculty_id);
                                                                                        $yearStmt->execute();
                                                                                        $yearResult = $yearStmt->get_result();
                                                                                        $placement_years = [];
                                                                                        while ($yearRow = $yearResult->fetch_assoc()) {
                                                                                            $placement_years[] = $yearRow['year'];
                                                                                        }
                                                                                        ?>

                                                                                        <?php if (count($placement_years) > 0): ?>
                                                                                            <div class="placement-section">
                                                                                                <h4>Placement Details</h4>

                                                                                                <div class="year-buttons">
                                                                                                    <?php foreach ($placement_years as $y): ?>
                                                                                                        <button class="year-btn" onclick="showPlacement('<?php echo $program_id; ?>','<?php echo $y; ?>')"><?php echo $y; ?></button>
                                                                                                    <?php endforeach; ?>
                                                                                                </div>

                                                                                                <?php foreach ($placement_years as $y): ?>
                                                                                                    <div class="placement-year-content placement-<?php echo $program_id; ?> placement-<?php echo $program_id; ?>-<?php echo $y; ?>" style="display: none;">
                                                                                                        <div class="placement-grid">
                                                                                                           
                                                                                                            <?php
                                                                                                            $studentStmt = $con->prepare("
                                                                                                                SELECT student_name, student_image, company_logo 
                                                                                                                FROM tbl_placement 
                                                                                                                WHERE program_id = ?  AND year = ? AND is_active = 1 AND is_delete = 0
                                                                                                            ");
                                                                                                            $studentStmt->bind_param("ii", $program_id, $y);
                                                                                                            $studentStmt->execute();
                                                                                                            $studentResult = $studentStmt->get_result();
                                                                                                            while ($studentRow = $studentResult->fetch_assoc()): ?>
                                                                                                                <div class="student-card">
                                                                                                                    <img class="student-img" src="<?php echo $upload_website_admin_url; ?>placement/student_image/<?php echo $studentRow['student_image']; ?>" alt="<?php echo $studentRow['student_name']; ?>">
                                                                                                                    <div class="student-info">
                                                                                                                        <b><?php echo $studentRow['student_name']; ?></b>
                                                                                                                        <br>
                                                                                                                        <img class="company-logo" src="<?php echo $upload_website_admin_url; ?>placement/company_logo/<?php echo $studentRow['company_logo']; ?>" alt="Company">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            <?php endwhile; ?>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                <?php endforeach; ?>
                                                                                            </div>
                                                                                        <?php endif; ?>

                                                                                    </div>
                                                                            <?php }
                                                                            } ?>
                                                                        </div>
                                                                    </section>
                                                            <?php }
                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php $i++;
                                                        }
                                                    } ?>
                                    </div>
                                </div>
                                <!-- .curriculum-section-text END -->
                            </div>
                        </section>
                    </div>
                </div>
                <!-- left bar end  -->

                <!-- right bar start  -->
                <div class="col-sm-4 sidebar-right" style="display:none; ">
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
                                        <li><a href="placement_overview_and_statistics.php"
                                                class="active"><i class="fa-solid fa-arrow-right"></i> Placement Overview &
                                                Statistics</a></li>
                                        <li><a href="geps.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i>GMIU Employability Performance Scale</a></li>

                                        <li><a href="student_testimonial.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Student Testimonial</a></li>

                                        <li><a href="corporate_testimonial.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Corporate
                                                Testimonial</a></li>

                                        <!--<li><a href="https://gmiu.edu.in/placement/innovation-and-research" class=""><i-->
                                        <!--            class="fa-solid fa-arrow-right"></i> Innovation & Research</a></li>-->

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


    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        function showPlacement(programId, year) {
            // Hide all placement content for this program
            document.querySelectorAll(`.placement-${programId}`).forEach(el => {
                el.style.display = 'none';
            });

            // Show selected year content
            const selected = document.querySelector(`.placement-${programId}-${year}`);
            if (selected) selected.style.display = 'block';
            
             
           
            // Optional: handle active button styles
            document.querySelectorAll('.year-btn').forEach(btn => btn.classList.remove('active-year'));
            
        }
    </script>

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