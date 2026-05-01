<?php
include '../../common/importwebsitefile.php';

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Sports Activity Report - Gyanmanjari Innovative University | GMIU";
    
    $meta_description = "Discover GMIU's sports activities and events through detailed reports, showcasing student participation, achievements, and the importance of sports in holistic development.";
    ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php
    include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@latest/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">

    <style>
        .scrollable-description {
            height: 110px;
            overflow-y: auto;
            text-align: justify;
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 5px;
            background-color: #fff;
        }
        
        .scrollable-description::-webkit-scrollbar {
            width: 6px;
        }
        .scrollable-description::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .scrollable-description::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }
        .scrollable-description::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Swiper */
        .swiper-container {
            width: 100%;
            height: 250px;
            overflow: hidden;
        }
        
        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .swiper-container {
            width: 100%;
            height: 250px;
            position: relative;
            padding-bottom: 25px; /* space for dots */
        }
        
        .swiper-pagination {
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            text-align: center;
        }

        /* GRID FIX */
        .semester-content {
            display: flex;
            flex-wrap: wrap;
            margin-left: -10px;
            margin-right: -10px;
        }
        
        .col-sm-6 {
            width: 50%;
            padding: 10px;
            display: flex;
        }
        
        /* CARD */
        .brochure-card-gmiu {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            display: flex;
            flex-direction: column;
            width: 100%;
            background: #fff;
            transition: 0.3s ease;
        }
        
        .brochure-card-gmiu:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
        
        .brochure-card-gmiu h4 {
            font-size: 18px;
            margin: 15px 0;
            min-height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .brochure-card-gmiu p {
            font-size: 14px;
            color: #666;
        }
        
        /* Push button to bottom */
        .brochure-card-gmiu a {
            margin-top: auto;
        }
        
        /* Button */
        .download-btn {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .download-btn:hover {
            background-color: #0056b3;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .col-sm-6 {
                width: 100%;
            }
        }


    </style>
</head>

<body class="courses">
    <?php include '../include/importheader.php'; ?>

    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Sports Activity Report</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="https://gmiu.edu.in/gmiu/website/campus/sports_report.php">Sports Activity Report</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>

    <div class="flexContainer container">
        <div class="cont">
            <div class="curriculum-text-box">
                <div class="curriculum-section">
                    <div class="panel-group" id="accordion">

                        <section class="events-list-03">
                            <div class="buttons-container-flex" style="padding: 10px;">

                                <?php
                                // Query to fetch distinct years
                                $cmd = "SELECT YEAR(date) as year FROM tbl_ssports WHERE report_type='Sports' AND is_active = 1 AND is_delete = 0 GROUP BY YEAR(date) ORDER BY year DESC";
                                $stmt = $con->prepare($cmd);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    $sem_btn = $row['year'];
                                    echo '<button class="tabBtn" data-semester="' . $sem_btn . '" onclick="showSemester(' . $sem_btn . ')">' . $sem_btn . '</button>';
                                }
                                ?>

                            </div>

                            <?php
                            // Query for sports activity report data based on year
                            $cmd = $con->prepare("SELECT ssports.id as ssports_id, ssports.report_type as ssports_type, ssports.report_title as ssports_title, ssports.description as ssports_description, ssports.report as report, ssports.report_thumbnail as report_thumbnail 
                            FROM tbl_ssports as ssports WHERE ssports.is_delete = ? AND ssports.report_type = ? AND YEAR(date) = ?");
                            $status = 0;
                            $event_type = 'Sports';

                            // Query for distinct years
                            $stmt_years = $con->prepare("SELECT DISTINCT YEAR(date) as year FROM tbl_ssports WHERE is_delete = 0 and is_active= 1 ORDER BY year DESC");
                            $stmt_years->execute();
                            $years = $stmt_years->get_result();

                            while ($year_row = $years->fetch_assoc()) {
                                $sem_btn = $year_row['year'];

                                // Bind parameters for the main query
                                $cmd->bind_param("isi", $status, $event_type, $sem_btn);
                                $cmd->execute();
                                $result = $cmd->get_result();
                            ?>
                                <!--<div class="row">-->
                                    <div class="semester-content" id="sem-<?php echo $sem_btn; ?>" style="display: none;">
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $ssports_id = $row['ssports_id'];
                                                $ssports_title = !empty($row['ssports_title']) ? $row['ssports_title'] : "<b>N/A</b>";
                                                $ssports_description = !empty($row['ssports_description']) ? $row['ssports_description'] : "<b></b>";

                                                // Query to fetch images for the report
                                                $img_query = $con->prepare("SELECT image FROM tbl_ssports_images WHERE ssports_id = ?");
                                                $img_query->bind_param("i", $ssports_id);
                                                $img_query->execute();
                                                $img_result = $img_query->get_result();
                                        ?>
                                                <div class="col-sm-6">
                                                    <div class="brochure-card-gmiu">
                                                        <div class="swiper-container">
                                                            <div class="swiper-wrapper">
                                                                <?php while ($img_row = $img_result->fetch_assoc()) { ?>
                                                                    <div class="swiper-slide">
                                                                        <img alt="Image" src="<?php echo "../../website_admin/uploads/ssports/report_thumbnail/" . $img_row['image']; ?>">
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="swiper-pagination"></div>
                                                            <!--<div class="swiper-button-next"></div>-->
                                                            <!--<div class="swiper-button-prev"></div>-->
                                                        </div>
                                                        <div>
                                                            <h4><?php echo $ssports_title; ?></h4>
                                                        </div>
                                                        <div>
                                                            <div class="scrollable-description">
                                                                <p><?php echo $ssports_description; ?></p>
                                                            </div>

                                                        </div>
                                                       <?php 
                                                        $report = $row['report'];
                                                        $report_path = "../../website_admin/uploads/ssports/report/" . $report;
                                                        
                                                        if (!empty($report) && file_exists($report_path)) { 
                                                        ?>
                                                            <a target="_blank" href="<?php echo $report_path; ?>">
                                                                <button class="download-btn">Download Report</button>
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                <!--</div>-->

                            <?php
                            }
                            ?>

                        </section>
                    </div>
                </div>
            </div>
           
        </div>
 <?php include "campussidebar.php"; ?>
    </div>

    <?php include '../include/importjs.php'; ?>
    <?php include '../include/importfooter.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@latest/swiper-bundle.min.js"></script>
    <script>
        // document.addEventListener('DOMContentLoaded', function () {
        //     var swiper = new Swiper('.swiper-container', {
        //         slidesPerView: 1,
        //         spaceBetween: 10,
        //         loop: true,
        //         autoplay: {
        //             delay: 3000,
        //             disableOnInteraction: false,
        //         },
        //         pagination: {
        //             el: '.swiper-pagination',
        //             clickable: true,
        //         },
        //         navigation: {
        //             nextEl: '.swiper-button-next',
        //             prevEl: '.swiper-button-prev',
        //         },
        //     });
        // });
        document.querySelectorAll('.swiper-container').forEach(function (el) {
            new Swiper(el, {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: el.querySelector('.swiper-pagination'),
                    clickable: true,
                }
            });
        });


        function showSemester(semesterId) {
            var semesterDivs = document.querySelectorAll('.semester-content');
            var semesterButtons = document.querySelectorAll('.tabBtn');

            // Hide all semester divs
            for (var i = 0; i < semesterDivs.length; i++) {
                semesterDivs[i].style.display = 'none';
            }

            // Remove "active" class from all buttons
            for (var i = 0; i < semesterButtons.length; i++) {
                semesterButtons[i].classList.remove('tabBtn-active');
            }

            // Show the selected semester div
            var semesterDiv = document.getElementById('sem-' + semesterId);
            semesterDiv.style.display = 'block';

            // Add "active" class to the clicked button
            document.querySelector('button[data-semester="' + semesterId + '"]').classList.add('tabBtn-active');
        }

        document.addEventListener('DOMContentLoaded', function () {
            var firstSemesterDiv = document.querySelector('.semester-content');
            if (firstSemesterDiv) {
                var firstSemesterId = firstSemesterDiv.getAttribute('id').split('-')[1];
                showSemester(firstSemesterId);
            }
        });
    </script>

</body>

</html>
