<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Industry Visit at GMIU | Campus Opportunities"; 
    $meta_description = "Explore GMIU's Industry Visit Program for real-world exposure, practical insights, and industry connections to boost learning and career readiness.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>

    <style>
        .program-card {
            width: 100%;
        }

        .program-details {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-top: 10px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: none;
            width: 100%;
            margin-left: 0;
            transition: all 0.3s ease;
        }

        .courses-cards {
            display: block;
            /* This makes the cards stack vertically */
            gap: 20px;
        }

        .program-swiper {
            width: 100%;
            height: auto;
            /* Set height based on content (adjust as needed) */
        }

        .program-content {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .program-wrapper {
            width: 100%;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .program-description {
            flex: 1;
            max-height: 200px;
            overflow: hidden;
        }

        .program-image {
            height: 400px;
            width: auto;
            object-fit: contain;
            /* Keeps image aspect ratio */
            background-color: transparent;
            display: block;
            margin: 0 auto;
            /* Horizontally center */
        }

        .view-more {
            display: inline-block;
            margin-top: 10px;
            padding-left: 660px;
            color: #0056b3;
            text-decoration: underline;
        }

        .program-description p {
            text-align: center !important;
        }



        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 400px !important;
            background-color: transparent;
        }

        .swiper-slide img {
            height: 400px;
            width: auto;
            object-fit: contain;
            /* Keeps image aspect ratio */
            background-color: transparent;
            display: block;
            margin: 0 auto;
        }

        /* Mobile Responsive Styling */
        @media (max-width: 768px) {
            .program-content {
                flex-direction: column;
                gap: 10px;
            }

            .program-description {
                max-height: none;
                padding: 10px 0;
            }

            .swiper-slide,
            .program-image {
                height: auto !important;
                max-height: 300px;
            }

            .swiper-slide img,
            .program-image {
                height: auto !important;
                max-width: 100%;
                object-fit: contain;
            }

            .view-more {
                padding-left: 0;
                display: block;
                text-align: center;
            }

            .program-details {
                padding: 10px;
            }

          
        }
        .swiper-button-next, .swiper-button-prev {
            color: #c7ccd1b5 !important;
        }
           @media (max-width: 768px) {
                .curriculum-text-box .curriculum-section .panel-group .panel .panel-title {
                     padding: 0 0px !important;
                }
                .flexContainer .cont {
                    width: 90% !important;
                }
               
           }
    </style>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body class="courses">
    <!-- Preloader
<div id="preloader">
    <div id="status">&nbsp;</div>
</div> -->
    <?php include '../include/importheader.php'; ?>



    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Industry Visit</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="flexContainer container">
        <div class="cont">
            <div class="curriculum-text-box">
                <div class="curriculum-section">

                    <div class="panel-group" id="accordion">

                        <?php
                        // Query for faculty
                        $cmd = $con->prepare("SELECT faculty.name as faculty_name, faculty.faculty_slug as faculty_slug, faculty.id as faculty_id
                       FROM tbl_faculty as faculty
                       JOIN tbl_industry_visit as industry_visit
                       ON industry_visit.faculty_id = faculty.id
                       WHERE faculty.is_active = 1 AND faculty.is_delete = 0
                       AND industry_visit.is_active = 1 AND industry_visit.is_delete = 0
                       GROUP BY faculty.id");
                        $cmd->execute();
                        $result = $cmd->get_result();
                        if ($result->num_rows != 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                $faculty_name = $row['faculty_name'];
                                $faculty_id = $row['faculty_id'];
                                $faculty_slug = $row['faculty_slug'];
                        ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title click">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#c<?php echo $i; ?>"
                                                id="font-course" class="color-gmiu"><?php echo $faculty_name; ?></a>
                                        </h4>
                                    </div>
                                    <div id="c<?php echo $i; ?>" class="panel-collapse collapse out">
                                        <div class="panel-body">

                                            <?php

                                            $query = "SELECT program.level_id, level.name as level_name
                                                FROM tbl_program as program
                                                LEFT JOIN tbl_level level ON program.level_id = level.id
                                                JOIN tbl_industry_visit as industry_visit ON FIND_IN_SET(program.id, industry_visit.program_id) > 0
                                                WHERE program.faculty_id = $faculty_id
                                                AND program.is_active = 1 AND program.is_delete = 0
                                                AND program.level_id NOT IN (15)
                                                AND NOT (program.faculty_id = '27' AND program.level_id = '15')
                                                AND industry_visit.is_active = 1 AND industry_visit.is_delete = 0
                                                GROUP BY program.level_id
                                                ORDER BY FIELD(program.level_id, 5, 7, 3, 1, 2, 8, 4, 6, 9, 10, 12, 13, 14, 15, 17)";
                                            $result1 = mysqli_query($con, $query);

                                            if (mysqli_num_rows($result1) > 0) {
                                                // output data of each row
                                                while ($row1 = mysqli_fetch_assoc($result1)) {
                                                    $level_name = $row1['level_name'];
                                                    $level_id = $row1['level_id'];

                                            ?>
                                                    <section class="two-column-cards">
                                                        <h3 class="title gradText">
                                                            <?php echo $level_name; ?>
                                                        </h3>
                                                        <hr>

                                                        <div class="courses-cards">
                                                            <?php

                                                            $query2 = "SELECT DISTINCT program.id as program_id, program.name as program_name, program.program_slug as program_slug
                                                                FROM tbl_program as program
                                                                JOIN tbl_industry_visit as industry_visit ON FIND_IN_SET(program.id, industry_visit.program_id) > 0
                                                                WHERE program.faculty_id = $faculty_id
                                                                AND program.level_id = $level_id
                                                                AND program.is_active = 1 AND program.is_delete = 0
                                                                AND industry_visit.is_active = 1 AND industry_visit.is_delete = 0";
                                                            $result2 = mysqli_query($con, $query2);
                                                            if (mysqli_num_rows($result2) > 0) {
                                                                // output data of each row
                                                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                                                    $program_name = $row2['program_name'];
                                                                    $program_id = $row2['program_id'];
                                                                    $program_slug = $row2['program_slug'];

                                                            ?>
                                                                    <div class="program-wrapper">
                                                                        <div class="card-for-course toggle-program"
                                                                            data-program-id="<?php echo $program_id; ?>">
                                                                            <h3 class="course-name" style="cursor:pointer;">
                                                                                <?php echo $program_name; ?>
                                                                            </h3>
                                                                        </div>

                                                                        <div class="program-details" id="details-<?php echo $program_id; ?>"
                                                                            style="display: none;">
                                                                            <div class="program-content">
                                                                                <?php
                                                                                // Fetch Title
                                                                                $desc_query = $con->prepare("SELECT id, visit_name as title
                                                                                    FROM tbl_industry_visit 
                                                                                    WHERE program_id = ?
                                                                                    AND is_active = 1 AND is_delete = 0
                                                                                    ORDER BY id DESC LIMIT 1");
                                                                                $desc_query->bind_param("i", $program_id);

                                                                                $desc_query->execute();
                                                                                $desc_result = $desc_query->get_result();
                                                                                if ($desc_result->num_rows > 0) {
                                                                                    $desc_row = $desc_result->fetch_assoc();
                                                                                    $short_id = $desc_row['id'];
                                                                                    $short_description = $desc_row['title'];
                                                                                }
                                                                                ?>

                                                                                <!-- Swiper Container -->
                                                                                <div class="swiper program-swiper"
                                                                                    id="swiper-<?php echo $program_id; ?>">

                                                                                    <div class="swiper-wrapper">
                                                                                        <?php
                                                                                        // Fetch images
                                                                                        $type = "industry_visit";
                                                                                        $cmd1 = $con->prepare("SELECT sp.file_name 
                                                                                                               FROM tbl_site_photos AS sp  
                                                                                                               WHERE type_id = ? 
                                                                                                               AND type = ? 
                                                                                                               AND is_active = 1 
                                                                                                               AND is_delete = 0");
                                                                                        $cmd1->bind_param("is", $short_id, $type);
                                                                                        $cmd1->execute();
                                                                                        $result1 = $cmd1->get_result();

                                                                                        while ($row1 = $result1->fetch_assoc()) {
                                                                                            $image_url = $upload_website_admin_url . "industry_visit/image/" . htmlspecialchars($row1['file_name']);
                                                                                            $alt_text = !empty($short_description) ? $short_description : "Industry Visit at $program_name";
                                                                                            echo "<div class='swiper-slide'><img src='" . $image_url . "' class='program-image' 
                                                                                            alt='" . htmlspecialchars($alt_text, ENT_QUOTES) . "'></div>";
                                                                                        }

                                                                                        ?>
                                                                                    </div>
                                                                                    <!-- Swiper Arrows -->
                                                                                    <div class="swiper-button-next"></div>
                                                                                    <div class="swiper-button-prev"></div>


                                                                                </div>

                                                                                <!-- Title -->
                                                                                <div class="program-description">
                                                                                    <p><span
                                                                                            style="color: #ba2a21; font-weight: bold;"><?php echo $short_description; ?></span>
                                                                                    </p>

                                                                                    <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug; ?>/program-industry-visit"
                                                                                        class="view-more">View More</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </section>
                                            <?php
                                                }
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                        <?php
                                $i++;
                            }
                        }
                        ?>
                    </div> <!-- .curriculum-section-text END -->
                </div>
            </div>
        </div>

        <!-- right ber start -->
        <?php include "../campus/campussidebar.php"; ?>
        <!--  right bar end -->
    </div>



    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->

    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Swiper initialization for each program's swiper
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.swiper').forEach(swiperEl => {
                const swiperId = swiperEl.getAttribute('id');

                new Swiper('#' + swiperId, {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '#' + swiperId + ' .swiper-button-next',
                        prevEl: '#' + swiperId + ' .swiper-button-prev',
                    },
                    loop: true,
                    autoHeight: true,
                });
            });
        });


        // Toggle the display of program details
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".toggle-program").forEach(function(heading) {
                heading.addEventListener("click", function() {
                    const programId = this.getAttribute('data-program-id');
                    const detail = document.getElementById('details-' + programId);

                    // Hide all program details sections
                    document.querySelectorAll('.program-details').forEach(function(otherDetail) {
                        otherDetail.style.display = 'none';
                    });

                    // Toggle visibility of the clicked program's details
                    detail.style.display = detail.style.display === 'none' || detail.style.display === '' ? 'block' : 'none';
                });
            });
        });
    </script>
</body>

</html>